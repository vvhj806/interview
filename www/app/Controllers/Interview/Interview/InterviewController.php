<?php

namespace App\Controllers\Interview\Interview;

use App\Controllers\BaseController;
use App\Controllers\Interview\WwwController;

use App\Models\{
    JobCategoryModel,
    ApplierModel,
    FileModel,
    RecruitModel,
    MemberRecruitCategoryModel,
    ApplierProfileModel,
    InterviewModel,
    QuestionModel,
    RecruitNostradamusModel,
    KoreaAreaModel,
    InterviewInfoModel,
    CompanyModel,
    MemberRecruitScrapModel,
    RecruitInfoModel,
    MemberModel,
    CompanySuggestApplicantModel
};

use App\Libraries\SendLib;

use Config\Database;
use Config\Services;
use PDO;

class InterviewController extends WwwController
{
    public function index(int $_idx)
    {
        $this->preview($_idx);
    }

    public function preview(int $idx)
    {
        // data init
        $this->commonData();

        $this->header();

        $RecruitNostradamusModel = new RecruitNostradamusModel();
        $QuestionModel = new QuestionModel();
        $aMock = $RecruitNostradamusModel->getMock($idx);

        // return;

        $aMockQueIdx = explode(",", $aMock['rec_nos_question']);
        $aMockQuestion = $QuestionModel->getQue($aMockQueIdx, $aMock['rec_nos_question']);

        $this->aData['data']['mock'] = $aMock;
        $this->aData['data']['mockQuestion'] = $aMockQuestion;
        $this->aData['data']['mockIdx'] = $idx;

        echo view("www/interview/preview", $this->aData);
        $this->footer(['quick']);
    }

    public function mock()
    {
        // data init
        $this->commonData();
        $cache = \Config\Services::cache();
        $jobCategoryModel = new JobCategoryModel();
        $companyModel = new CompanyModel();
        $InterviewModel = new InterviewModel();
        if ($this->aData['data']['session']['idx'] ?? false) {
            $iMemberIdx = $this->aData['data']['session']['idx'];
            $memberRecruitScrapModel = new MemberRecruitScrapModel();
            $aScrap = $memberRecruitScrapModel
                ->where('scr_type', 'C')
                ->getMyScrap($iMemberIdx)
                ->findColumn('com_idx');
        }

        //[1]기업형태종류가져오기
        $aConfig = $this->globalvar->getConfig();
        $aCompanyForm = $aConfig['company']['company_form'];
        $this->aData['data']['comForm'] = $aCompanyForm;

        //[2]검색어가져오기
        $strSearchText = $this->request->getGet('searchText');

        //[3]검색기업형태가져오기
        $aSearchComForm = $this->request->getGet('comCheck') ?? [];

        //[4]지역 태그 가져오기
        $aGetKorea = $this->request->getGet('korea');

        //[5]응시 직무 태그 가져오기
        $aGetCategory = $this->request->getGet('cate');

        if (!$aCacheJobcategory = cache('jobcategory.each')) {
            $aJobcategory = [];
            $jobCategoryModel = new JobCategoryModel();
            $aJobcategory = $jobCategoryModel->getJobCategory('interest');
            cache()->save('jobcategory.each', $aJobcategory, 86400);
            $aCacheJobcategory = $aJobcategory;
        }

        if (!$aCacheKoreaarea = cache('koreaarea.each')) {
            $aKoreaarea = [];
            $koreaAreaModel = new KoreaAreaModel();
            $aKoreaarea = $koreaAreaModel->getKoreaArea('interest');
            cache()->save('koreaarea.each', $aKoreaarea, 86400);
            $aCache['koreaarea'] = $aKoreaarea;
            $aCacheKoreaarea = $aKoreaarea;
        }

        //[1]모의면접기업정보목록 가져오기 
        $companyModel = new CompanyModel();
        $companyModel
            ->getPracticeList($strSearchText, $aSearchComForm)
            ->select([
                'iv_interview.job_idx_position', 'iv_interview_info.idx as infoIdx',
                'iv_interview.idx as i_idx', 'iv_job_category.job_depth_text'
            ])
            ->join('iv_interview_info', 'iv_interview_info.com_idx = iv_company.idx', 'inner')
            ->join('iv_interview', 'iv_interview.info_idx = iv_interview_info.idx', 'inner')
            ->join('iv_job_category', 'iv_interview_info.job_idx = iv_job_category.idx', 'inner')
            ->where(['iv_interview.inter_type' => 'B']);
        if ($aGetKorea) {
            $companyModel
                ->groupStart();
            foreach ($aGetKorea as $val) {
                $companyModel
                    ->orLike('com_address', $val, 'both');
            }
            $companyModel
                ->groupEnd();
        }
        if ($aGetCategory) {
            $companyModel->whereIn('iv_job_category.job_depth_1', $aGetCategory);
        }
        $aList = $companyModel
            ->paginate(5, 'practiceList');
        $aInterviews = [];
        //[2]모의면접기업정보목록 가공
        foreach ($aList as $key => $val) {
            if ($aScrap ?? false) {
                if (in_array($val['comIdx'], $aScrap)) {
                    $aList[$key]['scrap'] = true;
                }
            }
            $aInterviews = $InterviewModel->getMockInterviews($aList[$key]['infoIdx']);
            $aList[$key]['interviews'] = $aInterviews;
            // foreach ($aAllCategory as $val2) {
            //     foreach ($val2 as $key3 => $val3) {
            //         if ($key3 != 0) {
            //             if ($val3['idx'] == $aList[$key]['job_idx_position']) {
            //                 $aList[$key]['job_depth_text'] = $val3['job_depth_text'];
            //                 break;
            //             }
            //         }
            //     }
            // }
        }

        $this->aData['data']['search'] = ['text' => $strSearchText];
        $this->aData['data']['category'] = $aCacheJobcategory;
        $this->aData['data']['koreaArea'] = $aCacheKoreaarea;
        $this->aData['data']['get']['company_form'] = $aSearchComForm;
        $this->aData['data']['get']['korea'] = $aGetKorea;
        $this->aData['data']['get']['cate'] = $aGetCategory;
        $this->aData['data']['list'] = $aList;
        $this->aData['data']['pager'] = $companyModel->pager;
        $this->aData['data']['enList'] = json_encode($aList);
        $this->header();
        echo view("www/interview/mock", $this->aData);
        $this->footer(['company']);
    }


    public function ready()
    { //인터뷰 시작 전 가이드 및 type 선택 전
        $this->commonData();

        $this->header();

        $memberRecruitCategoryModel = new MemberRecruitCategoryModel();
        $jobCategoryModel = new JobCategoryModel();
        $RecruitNostradamusModel = new RecruitNostradamusModel();
        $InterviewModel = new InterviewModel();
        $recruitInfoModel = new RecruitInfoModel();
        $RecruitModel = new RecruitModel();

        $cache = \Config\Services::cache();
        $this->encrypter = Services::encrypter();

        $aAllCategory = $cache->get('aAlljobCate.each');
        if (!$aAllCategory) {
            $aAllCategory = $jobCategoryModel->getAllcategory();
        }
        // //암호화
        //         $this->encrypter = Services::encrypter();
        //         $encodeData = base64url_encode($this->encrypter->encrypt(json_encode(1092)));

        //         print_r($encodeData);
        // exit;

        $recIdx = $this->aData['data']['recIdx'] = $this->request->getGet('rec');
        $memType = $this->aData['data']['type'] = $this->request->getGet('type');
        $mockIdx = $this->aData['data']['mockIdx'] = $this->request->getGet('mock');
        $cMockIdx = $this->aData['data']['cMockIdx'] = $this->request->getGet('cmock');
        $sugAppIdx = $this->request->getGet('sug'); //iv_company_suggest_applicant idx 가 암호화되어있음
        //$opfIdx= $this->request->getGet('opf');


        $this->aData['data']['text'] = "지원을";
        $this->aData['data']['sugAppIdx'] = "";
        if ($sugAppIdx) {
            $sugAppIdx = json_decode($this->encrypter->decrypt(base64url_decode($sugAppIdx)), true);
            $aSugInfo = $InterviewModel->getBizInterInfo($sugAppIdx);
            $this->aData['data']['sugAppIdx'] = $sugAppIdx;
            $this->aData['data']['sugAppInfo'] = $aSugInfo;
        }

        if ($recIdx) {
            $JobText = $InterviewModel->getRecCate($recIdx);

            $this->aData['data']['position'] = $JobText;
            cache()->save('is.backUrl.Rec.' . $this->aData['data']['session']['idx'], $recIdx, 600);
            $cache->delete('is.backUrl.Mock.' . $this->aData['data']['session']['idx']);
            $cache->delete('is.backUrl.cMock.' . $this->aData['data']['session']['idx']);
            $getMyApply = $recruitInfoModel->getMyApplys($this->aData['data']['session']['idx'], $recIdx)->findAll();
            $applyCnt = count($getMyApply);
            $getRecApplyCount = $RecruitModel->getRecApplyCount([0 => $recIdx])[0]['rec_apply_count'];
            $reMain = $getRecApplyCount - $applyCnt;
            if (!$reMain) {
                alert_url('지원 가능 횟수를 초과하였습니다.', "/");
                exit;
            }
        } else if ($mockIdx) {
            $JobText = $RecruitNostradamusModel->getJobcate($mockIdx);
            $this->aData['data']['position'] = $JobText;
            $this->aData['data']['text'] = "모의인터뷰를";
            cache()->save('is.backUrl.Mock.' . $this->aData['data']['session']['idx'], $mockIdx, 600);
            $cache->delete('is.backUrl.Rec.' . $this->aData['data']['session']['idx']);
            $cache->delete('is.backUrl.cMock.' . $this->aData['data']['session']['idx']);
        } else if ($cMockIdx) {
            $JobText = $InterviewModel->getJobcate($cMockIdx);
            $this->aData['data']['position'] = $JobText;
            $this->aData['data']['text'] = "모의인터뷰를";
            cache()->save('is.backUrl.cMock.' . $this->aData['data']['session']['idx'], $cMockIdx, 600);
            $cache->delete('is.backUrl.Rec.' . $this->aData['data']['session']['idx']);
            $cache->delete('is.backUrl.Mock.' . $this->aData['data']['session']['idx']);
        } else {
            $cache->delete('is.backUrl.Rec.' . $this->aData['data']['session']['idx']);
            $cache->delete('is.backUrl.Mock.' . $this->aData['data']['session']['idx']);
            $cache->delete('is.backUrl.cMock.' . $this->aData['data']['session']['idx']);
        }

        echo view("www/interview/ready", $this->aData);
        $this->footer(['quick']);
    }

    public function type()
    {
        $this->commonData();

        $recIdx = $this->request->getGet('rec') ?? null;
        $memIdx = $this->aData['data']['session']['idx'];

        $memberRecruitCategoryModel = new MemberRecruitCategoryModel();

        $aMyCategory = $memberRecruitCategoryModel
            ->select(['iv_job_category.idx', 'iv_job_category.job_depth_text'])->getMyFirstCategory($memIdx);

        $this->aData['data']['myCategory'] = $aMyCategory;

        $this->aData['data']['recIdx'] = $recIdx;

        $this->header();
        echo view("www/interview/type", $this->aData);
        $this->footer(['quick']);
    }

    public function typeAction()
    {
        $this->commonData();

        $this->header();
        $cateIdx = $this->request->getPost('cateIdx');
        $appType = $this->request->getPost('appType');
        $appBrowserName = $this->request->getPost('appBrowserName');
        $appBrowserVersion = $this->request->getPost('appBrowserVersion');
        $appPlatform = $this->request->getPost('appPlatform');
        $postCase = $this->request->getPost('postCase');
        $strBackUrl = $this->request->getPost('backUrl');
        $recIdx = $this->request->getPost('rec');
        $mockIdx = $this->request->getPost('mock');
        $cmock = $this->request->getPost('cmock');
        $sugAppIdx = $this->request->getPost('sug');

        if ($postCase == "" || $postCase == null) {
            alert_url($this->globalvar->aMsg['error1'], $strBackUrl ? $strBackUrl : "/");
            exit;
        }

        if ($this->aData['data']['session']['idx'] == "" || $this->aData['data']['session']['idx'] == null) {
            alert_url($this->globalvar->aMsg['error11'], $strBackUrl ? $strBackUrl : "/");
            exit;
        }

        $cateIdx = $cateIdx ?? "";

        $memberRecruitCategoryModel = new MemberRecruitCategoryModel();
        $jobCategoryModel = new JobCategoryModel();
        $RecruitNostradamusModel = new RecruitNostradamusModel();
        $QuestionModel = new QuestionModel();
        $InterviewModel = new InterviewModel();
        $InterviewInfoModel = new InterviewInfoModel();
        $cache = \Config\Services::cache();

        $aQuestion = [];
        $iAnswerTime = "";
        $strIidx = null;
        $iAnswer = null;
        $aPersonalQList = null;

        $aAllCategory = $cache->get('aAlljobCate.each');
        if (!$aAllCategory) {
            $aAllCategory = $jobCategoryModel->getAllcategory();
        }

        if ($recIdx) {
            $aInterview = $InterviewModel->getInterview($recIdx);
            $strIidx = $aInterview['idx'];
            $aRecQueIdx = explode(",", $aInterview['inter_question']);
            $aQuestion = $QuestionModel->getQue($aRecQueIdx, $aInterview['inter_question']);
            $iAnswerTime = $aInterview['inter_answer_time'];
            $cateIdx = $aInterview['job_idx_position'];
        }

        if ($mockIdx) {
            $aMock = $RecruitNostradamusModel->getMock($mockIdx);
            $aMockQueIdx = explode(",", $aMock['rec_nos_question']);
            $aQuestion = $QuestionModel->getQue($aMockQueIdx, $aMock['rec_nos_question']);
            $cateIdx = $aMock['job_idx'];
        }

        if ($cmock) {
            $aMock = $InterviewModel->getMock($cmock);
            $aMockQueIdx = explode(",", $aMock['inter_question']);
            $aQuestion = $QuestionModel->getQue($aMockQueIdx, $aMock['inter_question']);
            $iAnswerTime = $aMock['inter_answer_time'];
            $cateIdx = $aMock['job_idx_position'];
        }

        if ($sugAppIdx) {
            $aSug = $InterviewModel->getBizInterview($sugAppIdx);
            if ($aSug['idx'] != 1) { //$aSug['idx'] == iv_interview idx
                $aSugQueIdx = explode(",", $aSug['inter_question']);
                if ($aSug['sug_app_personal_q_list'] && $aSug['sug_app_personal_q_list'] != "") {
                    $sug_app_personal_q_list = ',' . $aSug['sug_app_personal_q_list'];
                    if (strpos($aSug['sug_app_personal_q_list'], ',') !== false) { // , 가 포함됨 / 질문 여러개
                        $str_ap_person_q = explode(',', $aSug['sug_app_personal_q_list']);
                    } else { // , 가 포함 안됨 / 질문 한개
                        $str_ap_person_q[0] = $aSug['sug_app_personal_q_list'];
                    }

                    $aSugQueIdx = array_merge($aSugQueIdx, $str_ap_person_q);
                } else {
                    $sug_app_personal_q_list = '';
                }
                $strPersonQ = $aSug['inter_question'] . $sug_app_personal_q_list;
                $aQuestion = $QuestionModel->getQue($aSugQueIdx, $strPersonQ);
            }
            if ($aSug['old_ap_idx']) { //비즈 응용에서 제안 보냈을 때
                $cateIdx = $aSug['job_idx'];
            } else { //비즈 웹에서 제안 보냈을 때
                $cateIdx = $aSug['job_idx_position'];
            }
            $iAnswerTime = $aSug['inter_answer_time'];
            $iInterIdx = $aSug['idx'];
            $iAnswer = $iAnswerTime;
            $aPersonalQList = $aSug['sug_app_personal_q_list'];
        }

        //트랜잭션 start
        $this->masterDB->transBegin();

        $result = $this->masterDB->table('iv_applier')
            ->set([
                'mem_idx' => $this->aData['data']['session']['idx'],
                'job_idx' => $cateIdx,
                'app_type' => $appType,
                'app_platform' => $appPlatform,
                'app_browser_name' => $appBrowserName,
                'app_browser_version' => $appBrowserVersion,
            ]);

        if ($recIdx) {
            $result->set([
                'rec_idx' => $recIdx,
                'i_idx' => $strIidx
            ]);
        }

        if ($mockIdx) {
            $result->set(['rec_nos_idx' => $mockIdx]);
        }

        if ($cmock) {
            $result->set([
                'i_idx' => $cmock,
                'info_idx' => $aMock['info_idx']
            ]);
        }
        if ($sugAppIdx) {
            $result->set([
                'i_idx' => $iInterIdx,
                'app_share' => '1',
            ]);
        }

        $result
            ->set(['app_reg_date' => 'NOW()'], '', false)
            ->set(['app_mod_date' => 'NOW()'], '', false)
            ->insert();
        $strIdx = $this->masterDB->insertID();

        if ($aQuestion) {
            $aGetQue = $aQuestion;
            if (!$mockIdx) {
                $iAnswer = $iAnswerTime;
            }
        } else {
            if ($cateIdx == '465' || $cateIdx == '475' || $cateIdx == '476' || $cateIdx == '477') { //영어, 정치 직무질문 4개
                $aGetQueRand = $QuestionModel->getQueRandJob($cateIdx)->findAll(4);
            } else {
                if ($cateIdx <= 153) {
                    $aGetQueRand = $QuestionModel->getQueRandJobOld($cateIdx)->findAll(4);
                } else {
                    $aGetQueCommon = $QuestionModel->getQueRandCommon()->findAll(2); //공통질문 가져오기

                    $aGetQueRand = $QuestionModel->getQueRandJob($cateIdx)->findAll(2);
                    $aGetQueRand = array_merge($aGetQueCommon, $aGetQueRand);
                }
            }

            if ($aPersonalQList) {
                if ($aPersonalQList && $aPersonalQList != "") {
                    if (strpos($aPersonalQList, ',') !== false) { // , 가 포함됨 / 질문 여러개
                        $str_ap_person_q = explode(',', $aPersonalQList);
                        $str_ap_person_q = $QuestionModel->getQue($str_ap_person_q, $aPersonalQList);
                    } else { // , 가 포함 안됨 / 질문 한개
                        $str_ap_person_q[0] = $aPersonalQList;
                        $str_ap_person_q = $QuestionModel->getQue($str_ap_person_q, $aPersonalQList);
                    }
                    $aGetQueRand = array_merge($aGetQueRand, $str_ap_person_q);
                }
            }
            $aGetQue = $aGetQueRand;
            // $strCode = "";
            //job_idx 로 job_depth_1 을 가져와서 외국어 면접에 해당하는 depth 코드 가져와 외국어 면접에 해당하는 모든 카테고리는 첫질문을 영어로 자기소개부탁드립니다 나오게 하려고 했음
            // foreach ($aAllCategory as $val) { 
            //     foreach ($val as $key2 => $val2) {
            //         if ($key2 != 0) {
            //             if ($val2['idx'] == $cateIdx) { 
            //                 $strCode = $val2['job_depth_1'];
            //                 break;
            //             }
            //         }
            //     }
            // }
            if ($cateIdx == "465") { //10580
                $this->masterDB->table('iv_report_result')
                    ->set([
                        'applier_idx' => $strIdx,
                        'que_idx' => 10580,
                        'que_type' => 'S',
                        'repo_answer_time' => $iAnswer
                    ])
                    ->set(['repo_reg_date' => 'NOW()'], '', false)
                    ->set(['repo_mod_date' => 'NOW()'], '', false)
                    ->insert();
            } else {
                $this->masterDB->table('iv_report_result')
                    ->set([
                        'applier_idx' => $strIdx,
                        'que_idx' => 1,
                        'que_type' => 'S',
                        'repo_answer_time' => $iAnswer
                    ])
                    ->set(['repo_reg_date' => 'NOW()'], '', false)
                    ->set(['repo_mod_date' => 'NOW()'], '', false)
                    ->insert();
            }
        }

        foreach ($aGetQue as $val) {
            $this->masterDB->table('iv_report_result')
                ->set([
                    'applier_idx' => $strIdx,
                    'que_idx' => $val['idx'],
                    'que_type' => 'S',
                    'repo_answer_time' => $iAnswer
                ])
                ->set(['repo_reg_date' => 'NOW()'], '', false)
                ->set(['repo_mod_date' => 'NOW()'], '', false)
                ->insert();
        }

        $this->masterDB->table('iv_report_result')
            ->set([
                'applier_idx' => $strIdx,
                'que_type' => 'T'
            ])
            ->set(['repo_reg_date' => 'NOW()'], '', false)
            ->set(['repo_mod_date' => 'NOW()'], '', false)
            ->insert();

        if ($sugAppIdx) {
            $this->masterDB->table('iv_company_suggest_applicant')
                ->set([
                    'app_idx' => $strIdx,
                ])
                ->set(['sug_app_mod_date' => 'NOW()'], '', false)
                ->where([
                    'idx' => $sugAppIdx
                ])
                ->update();
        }

        // 트랜잭션 end
        if ($this->masterDB->transStatus() === false) {
            $this->masterDB->transRollback();
        } else {
            $this->masterDB->transCommit();
        }

        // 트랜잭션 검사
        if ($this->masterDB->transStatus()) {
        } else {
            alert_url($this->globalvar->aMsg['error3'], $strBackUrl != '' ? $strBackUrl : $this->backUrlList);
            exit;
        }

        $ApplierModel = new ApplierModel();
        $aApplierInfo = $ApplierModel->getStartApplier($strIdx);

        if ($aApplierInfo == "" || $aApplierInfo == null) {
            alert_url($this->globalvar->aMsg['error1'], $strBackUrl ? $strBackUrl : "/");
            exit;
        }

        cache()->save('is.applierStart.' . $strIdx . '.' . $this->aData['data']['session']['idx'], $aApplierInfo, 3600);
        return redirect()->to('/interview/profile/' . $strIdx . '/' . $this->aData['data']['session']['idx']);
    }

    public function profile(int $applyIdx, int $memIdx)
    {
        $this->commonData();

        $this->header();
        $cache = \Config\Services::cache();
        $aApplier = $cache->get('is.applierStart.' . $applyIdx . '.' . $memIdx);

        $strFileIdx = $this->request->getPost('fileIdx');
        $postCase = $this->request->getPost('postCase');
        $selectType = $this->request->getPost('selectType');
        $strBackUrl = $this->request->getPost('backUrl');

        if (!$aApplier) {
            alert_url($this->globalvar->aMsg['error13'], "/interview/ready");
            exit;
        } else {
            if ($aApplier[0]['mem_idx'] != $memIdx || $aApplier[0]['idx'] != $applyIdx) {
                alert_url($this->globalvar->aMsg['error13'], "/");
                exit;
            }
        }

        $applierProfileModel = new ApplierProfileModel();
        $CompanySuggestApplicantModel = new CompanySuggestApplicantModel();
        $this->encrypter = Services::encrypter();
        $this->aData['data']['recInterview'] = 0;
        $this->aData['data']['nosInterview'] = 0;
        $this->aData['data']['iInterview'] = 0;
        $this->aData['data']['linkInterview'] = 0;

        $aGetAllprofile = $applierProfileModel->getMemberProfile($memIdx)->findAll(12);

        if (!$aGetAllprofile) {
            $this->aData['data']['noprofile'] = 0;
        } else {
            $this->aData['data']['noprofile'] = 1;
        }

        if ($aApplier[0]['rec_idx'] != 0 && $aApplier[0]['rec_idx'] != null && $aApplier[0]['rec_idx'] != "") {
            $this->aData['data']['recInterview'] = 1;
            $this->aData['data']['recIdx'] = $aApplier[0]['rec_idx'];
        }

        if ($aApplier[0]['rec_nos_idx'] != 0 && $aApplier[0]['rec_nos_idx'] != null && $aApplier[0]['rec_nos_idx'] != "") {
            $this->aData['data']['nosInterview'] = 1;
            $this->aData['data']['recNosIdx'] = $aApplier[0]['rec_nos_idx'];
        }

        if ($aApplier[0]['i_idx'] != 0 && $aApplier[0]['i_idx'] != null && $aApplier[0]['i_idx'] != "") {
            $this->aData['data']['iInterview'] = 1;
            $this->aData['data']['i_idx'] = $aApplier[0]['i_idx'];
            $sugAppIdx = $CompanySuggestApplicantModel->getApplicantIdx($applyIdx);
            if ($sugAppIdx) {
                $this->aData['data']['iInterview'] = 0;
                $this->aData['data']['gsCk'] = $CompanySuggestApplicantModel->checkGsCk($sugAppIdx);
                $sugAppIdx = base64url_encode($this->encrypter->encrypt($sugAppIdx));
                $this->aData['data']['linkInterview'] = 1;
                $this->aData['data']['sug_idx'] = $sugAppIdx;
            }
        }

        $this->aData['data']['applyIdx'] = $applyIdx;
        $this->aData['data']['memIdx'] = $memIdx;
        $this->aData['data']['setBtn'] = 0;
        $this->aData['data']['fileIdx'] = "";

        $FileModel = new FileModel();
        if ($aApplier[0]['file_idx_thumb']) { //기존 설정된 프로필이 있을때
            $this->aData['data']['setBtn'] = 1;
            $aProfileInfo = $FileModel->getProfile($aApplier[0]['file_idx_thumb']);
            $this->aData['data']['fileInfo'] = $aProfileInfo;
            $this->aData['data']['fileIdx'] = $aApplier[0]['file_idx_thumb'];
            if ($strFileIdx) { // 지금 촬영하기든 기존 프로필에서 선택이든 get에 fileidx 가 있을때
                $this->encrypter = Services::encrypter();   //공고 idx 복호화
                $decodeData = json_decode($this->encrypter->decrypt(base64url_decode($strFileIdx)), true);
                $aProfileInfo = $FileModel->getProfile($decodeData);
                if ($selectType == 'E' || $selectType == 'P') {
                    $this->aData['data']['fileInfo'] = $aProfileInfo;
                    $this->aData['data']['fileIdx'] = $decodeData;
                }
            }
        } else { //기존 설정된 프로필이 없을때
            if ($strFileIdx) { // 지금 촬영하기든 기존 프로필에서 선택이든 get에 fileidx 가 있을때
                $this->encrypter = Services::encrypter();   //공고 idx 복호화
                $this->aData['data']['setBtn'] = 1;
                $decodeData = json_decode($this->encrypter->decrypt(base64url_decode($strFileIdx)), true);
                $aProfileInfo = $FileModel->getProfile($decodeData);
                if ($selectType == 'E' || $selectType == 'P') {
                    $this->aData['data']['fileInfo'] = $aProfileInfo;
                    $this->aData['data']['fileIdx'] = $decodeData;
                }
            }
        }


        echo view("www/interview/profile", $this->aData);
        $this->footer(['quick']);
    }

    public function photo(int $applyIdx, int $memIdx)
    {
        $this->commonData();

        $this->header();

        $cache = \Config\Services::cache();

        $aApplier = $cache->get('is.applierStart.' . $applyIdx . '.' . $memIdx);

        if (!$aApplier) {
            alert_url($this->globalvar->aMsg['error13'], "/interview/ready");
            exit;
        } else {
            if ($aApplier[0]['mem_idx'] != $memIdx || $aApplier[0]['idx'] != $applyIdx) {
                alert_url($this->globalvar->aMsg['error13'], "/");
                exit;
            }
        }

        $this->aData['data']['applyIdx'] = $applyIdx;
        $this->aData['data']['memIdx'] = $memIdx;
        $this->aData['data']['recIdx'] = $aApplier[0]['rec_idx'] ?? "";

        echo view("www/interview/photo", $this->aData);
        $this->footer(['quick']);
    }

    public function photo2(int $applyIdx, int $memIdx)
    {
        $this->commonData();

        $this->header();

        $cache = \Config\Services::cache();

        $aApplier = $cache->get('is.applierStart.' . $applyIdx . '.' . $memIdx);

        // if (!$aApplier) {
        //     alert_url($this->globalvar->aMsg['error13'], "/interview/ready");
        //     exit;
        // } else {
        //     if ($aApplier[0]['mem_idx'] != $memIdx || $aApplier[0]['idx'] != $applyIdx) {
        //         alert_url($this->globalvar->aMsg['error13'], "/");
        //         exit;
        //     }
        // }

        $this->aData['data']['applyIdx'] = $applyIdx;
        $this->aData['data']['memIdx'] = $memIdx;
        $this->aData['data']['recIdx'] = $aApplier[0]['rec_idx'] ?? "";

        echo view("www/interview/photo2", $this->aData);
        $this->footer(['quick']);
    }

    public function albumAction()
    {
        $this->commonData();

        $strProfileFile = $this->request->getPost('profileFile');
        $strFilePath = $this->request->getPost('filePath');
        $strFileSize = $this->request->getPost('fileSize');
        $strFileIdx = $this->request->getPost('fileIdx');
        $applyIdx = $this->request->getPost('applyIdx');
        $postCase = $this->request->getPost('postCase');
        $strBackUrl = $this->request->getPost('backUrl');
        $session = session();

        if ($postCase == "" || $postCase == null) {
            alert_url($this->globalvar->aMsg['error1'], $strBackUrl ? $strBackUrl : "/");
            exit;
        }

        if ($postCase == 'skip') {
            $result = $this->masterDB->table('iv_applier')
                ->set([
                    'file_idx_thumb' => null,
                    'app_iv_stat' => 1
                ])
                ->set(['app_mod_date' => 'NOW()'], '', false)
                ->where([
                    'idx' => $applyIdx,
                    'mem_idx' => $session->get('idx')
                ])
                ->update();
            if ($result) {
                return redirect()->to('/interview/mic/' . $applyIdx . '/' . $session->get('idx'));
                exit;
            } else {
                alert_url($this->globalvar->aMsg['error3'], $strBackUrl != '' ? $strBackUrl : $this->backUrlList);
                exit;
            }
        } else {
            //트랜잭션 start
            $this->masterDB->transBegin();

            if ($strProfileFile) {
                $this->masterDB->table('iv_file')
                    ->set([
                        'file_type' => 'A',
                        'file_org_name' => $strProfileFile,
                        'file_save_name' => $strFilePath,
                        'file_size' => $strFileSize,
                    ])
                    ->set(['file_reg_date' => 'NOW()'], '', false)
                    ->set(['file_mod_date' => 'NOW()'], '', false)
                    ->insert();

                $strFileIdx = $this->masterDB->insertID();
            }

            if ($strFileIdx == null || $strFileIdx == '' || $strFileIdx == 0) {
                alert_back($this->globalvar->aMsg['error2'] . ' 프로필을 다시 선택해주세요.');
                exit;
            }

            $this->masterDB->table('iv_applier')
                ->set([
                    'file_idx_thumb' => $strFileIdx,
                    'app_iv_stat' => 1
                ])
                ->set(['app_mod_date' => 'NOW()'], '', false)
                ->where([
                    'idx' => $applyIdx,
                    'mem_idx' => $session->get('idx')
                ])
                ->update();

            // 트랜잭션 end
            if ($this->masterDB->transStatus() === false) {
                $this->masterDB->transRollback();
            } else {
                $this->masterDB->transCommit();
            }

            // 트랜잭션 검사
            if ($this->masterDB->transStatus()) {
                $ApplierModel = new ApplierModel();
                $aApplierInfo = $ApplierModel->getStartApplier($applyIdx);
                cache()->save('is.applierStart.' . $applyIdx . '.' . $this->aData['data']['session']['idx'], $aApplierInfo, 3600);

                return redirect()->to('/interview/mic/' . $applyIdx . '/' . $session->get('idx'));
            } else {
                alert_url($this->globalvar->aMsg['error3'], $strBackUrl != '' ? $strBackUrl : $this->backUrlList);
                exit;
            }
        }
    }

    public function exist(int $applyIdx, int $memIdx)
    {
        $this->commonData();

        $this->header();

        $cache = \Config\Services::cache();

        $aApplier = $cache->get('is.applierStart.' . $applyIdx . '.' . $memIdx);

        if (!$aApplier) {
            alert_url($this->globalvar->aMsg['error13'], "/interview/ready");
            exit;
        } else {
            if ($aApplier[0]['mem_idx'] != $memIdx || $aApplier[0]['idx'] != $applyIdx) {
                alert_url($this->globalvar->aMsg['error13'], "/");
                exit;
            }
        }

        $this->aData['data']['applyIdx'] = $applyIdx;
        $this->aData['data']['memIdx'] = $memIdx;

        $applierProfileModel = new ApplierProfileModel();

        // $aGetAllprofile = $applierProfileModel->getAllprofile($memIdx, $applyIdx)->findAll();
        // $this->aData['data']['getAllfile'] = $aGetAllprofile->paginate(6, 'getAllfile');
        // $this->aData['data']['pager'] = $aGetAllprofile->pager;

        //해당회원이 찍은 프로필 최근 N개 가져오기
        $aGetAllprofile = $applierProfileModel->getMemberProfile($memIdx)->findAll(12);

        //암호화
        $this->encrypter = Services::encrypter();

        if ($aGetAllprofile) {
            foreach ($aGetAllprofile as $key => $val) {
                $aGetAllprofile[$key]['Enidx'] = base64url_encode($this->encrypter->encrypt(json_encode($val['idx'])));
            }
        }
        $this->aData['data']['getAllfile'] = $aGetAllprofile;

        echo view("www/interview/exist", $this->aData);
        $this->footer(['quick']);
    }

    public function mic(int $applyIdx, int $memIdx)
    {
        $this->commonData();

        $this->header();

        $cache = \Config\Services::cache();

        $aApplier = $cache->get('is.applierStart.' . $applyIdx . '.' . $memIdx);

        if (!$aApplier) {
            alert_url($this->globalvar->aMsg['error13'], "/interview/ready");
            exit;
        } else {
            if ($aApplier[0]['mem_idx'] != $memIdx || $aApplier[0]['idx'] != $applyIdx) {
                alert_url($this->globalvar->aMsg['error13'], "/");
                exit;
            }
        }
        $this->aData['data']['applyIdx'] = $applyIdx;
        $this->aData['data']['memIdx'] = $memIdx;
        $this->aData['data']['recIdx'] = $aApplier[0]['rec_idx'];
        $this->aData['data']['interIdx'] = $aApplier[0]['i_idx'];

        echo view("www/interview/mic", $this->aData);
        $this->footer(['quick']);
    }

    public function skipMicAction()
    {
        $this->commonData();
        $cache = \Config\Services::cache();

        $strapplyIdx = $this->request->getPost('applyIdx');
        $strmemIdx = $this->request->getPost('memIdx');
        $strProcess = $this->request->getPost('process');
        $postCase = $this->request->getPost('postCase');
        $strBackUrl = $this->request->getPost('backUrl');

        if ($postCase == "" || $postCase == null) {
            alert_url($this->globalvar->aMsg['error1'], $strBackUrl ? $strBackUrl : "/");
            exit;
        }
        $session = session();
        if ($strmemIdx != $session->get('idx')) {
            alert_url($this->globalvar->aMsg['error1'], $strBackUrl ? $strBackUrl : "/");
            exit;
        }

        $this->masterDB->table('iv_applier')
            ->set([
                'app_iv_stat' => $strProcess
            ])
            ->where([
                'idx' => $strapplyIdx,
                'mem_idx' => $strmemIdx
            ])
            ->update();

        $ApplierModel = new ApplierModel();
        $aApplierInfo = $ApplierModel->getStartApplier($strapplyIdx);
        cache()->save('is.applierStart.' . $strapplyIdx . '.' . $this->aData['data']['session']['idx'], $aApplierInfo, 3600);
        $aApplier = $cache->get('is.applierStart.' . $strapplyIdx . '.' . $strmemIdx);
        if (!$aApplier[0]['rec_idx']) {
            if ($aApplier[0]['i_idx']) {
                return redirect()->to('/interview/start/' . $strapplyIdx . '/' . $session->get('idx'));
            } else {
                return redirect()->to('/interview/timer/' . $strapplyIdx . '/' . $session->get('idx'));
            }
        } else {
            return redirect()->to('/interview/start/' . $strapplyIdx . '/' . $session->get('idx'));
        }
    }

    public function timer(int $applyIdx, int $memIdx)
    {
        $this->commonData();

        $this->header();

        $cache = \Config\Services::cache();

        $aApplier = $cache->get('is.applierStart.' . $applyIdx . '.' . $memIdx);

        if (!$aApplier) {
            alert_url($this->globalvar->aMsg['error13'], "/interview/ready");
            exit;
        } else {
            if ($aApplier[0]['mem_idx'] != $memIdx || $aApplier[0]['idx'] != $applyIdx) {
                alert_url($this->globalvar->aMsg['error13'], "/");
                exit;
            }
        }

        $this->aData['data']['applyIdx'] = $applyIdx;
        $this->aData['data']['memIdx'] = $memIdx;

        echo view("www/interview/timer", $this->aData);
        $this->footer(['quick']);
    }

    public function timerAction()
    {
        $this->commonData();

        $strapplyIdx = $this->request->getPost('applyIdx');
        $strmemIdx = $this->request->getPost('memIdx');
        $stranswerTimer = $this->request->getPost('answerTimer');
        $postCase = $this->request->getPost('postCase');
        $strBackUrl = $this->request->getPost('backUrl');
        if ($postCase == "" || $postCase == null) {
            alert_url($this->globalvar->aMsg['error1'], $strBackUrl ? $strBackUrl : "/");
            exit;
        }
        $session = session();
        if ($strmemIdx != $session->get('idx')) {
            alert_url($this->globalvar->aMsg['error1'], $strBackUrl ? $strBackUrl : "/");
            exit;
        }

        $this->masterDB->table('iv_report_result')
            ->set([
                'repo_answer_time' => $stranswerTimer
            ])
            ->where([
                'applier_idx' => $strapplyIdx,
                'que_type !=' => 'T'
            ])
            ->update();

        $ApplierModel = new ApplierModel();
        $aApplierInfo = $ApplierModel->getStartApplier($strapplyIdx);
        cache()->save('is.applierStart.' . $strapplyIdx . '.' . $this->aData['data']['session']['idx'], $aApplierInfo, 3600);

        return redirect()->to('/interview/start/' . $strapplyIdx . '/' . $session->get('idx'));
    }

    public function start(int $applyIdx, int $memIdx)
    {
        $this->commonData();

        $this->header();

        $cache = \Config\Services::cache();
        $aApplier = $cache->get('is.applierStart.' . $applyIdx . '.' . $memIdx);

        if (!$aApplier) {
            alert_url($this->globalvar->aMsg['error13'], "/interview/ready");
            exit;
        } else {
            if ($aApplier[0]['mem_idx'] != $memIdx || $aApplier[0]['idx'] != $applyIdx) {
                alert_url($this->globalvar->aMsg['error13'], "/");
                exit;
            }
        }

        $ApplierModel = new ApplierModel();
        $CompanySuggestApplicantModel = new CompanySuggestApplicantModel();
        $aStartInterview = $ApplierModel->startInterview($applyIdx);

        $this->aData['data']['startInterview'] = $aStartInterview;

        $aReportResult = json_encode($aStartInterview[0]['report_result']);

        $ApplicantIdx = $CompanySuggestApplicantModel->getApplicantIdx($applyIdx);
        $appIdx = "";
        if ($ApplicantIdx) {
            $secret_key = 'bluevisorencrypt';
            $key = substr(hash('sha256', $secret_key, true), 0, 32);
            $iv = substr(hash('sha256', $secret_key, true), 0, 16);
            $appIdx = base64_encode(openssl_encrypt($ApplicantIdx, "AES-256-CBC", $key, 0, $iv));
        }

        $this->aData['data']['applyIdx'] = $applyIdx;
        $this->aData['data']['memIdx'] = $memIdx;
        $this->aData['data']['reportResult'] = $aReportResult;
        $this->aData['data']['applicantIdx'] = $appIdx;

        echo view("www/interview/start", $this->aData);
        $this->footer(['quick']);
    }

    public function end(int $applyIdx, int $memIdx)
    {
        $this->commonData();

        $this->header();

        $ApplierModel = new ApplierModel();
        $aEndInterview = $ApplierModel->endInterview($applyIdx, $memIdx);

        $aData = [

            'idx' => array($aEndInterview['rec_idx']),
            'state' => $aEndInterview['app_type'],
        ];

        //암호화
        $this->encrypter = Services::encrypter();
        $encodeData = base64url_encode($this->encrypter->encrypt(json_encode($aData)));


        $this->aData['data']['endInterview'] = $aEndInterview;

        $this->aData['data']['applyIdx'] = $applyIdx;
        $this->aData['data']['memIdx'] = $memIdx;
        $this->aData['data']['enRecIdx'] = $encodeData;

        echo view("www/interview/end", $this->aData);
        $this->footer(['quick']);
    }
}
