<?php

namespace App\Controllers\API\Interview;

use App\Controllers\API\APIController;

use App\Models\{
    MemberRecruitCategoryModel,
    RecruitNostradamusModel,
    JobCategoryModel,
    QuestionModel,
    ApplierModel,
    RecruitModel,
    InterviewModel
};

class SubmitController extends APIController
{
    private $aResponse = [];

    public function index()
    {
    }

    public function show($id = null)
    {
    }

    public function submit()
    {
        if (!$this->request->isAJAX()) {
            return $this->respond([
                'status'   => 403,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error1'],
            ], 403);
        }

        $session = session();
        $iRecIdx = $this->request->getPost('rec');
        $iMockIdx = $this->request->getPost('mock');
        $icMockIdx = $this->request->getPost('cmock');
        $sugAppIdx = $this->request->getPost('sug');
        $iCateIdx = $this->request->getPost('cateIdx');
        $strAppType = $this->request->getPost('appType');
        $strAppBrowserName = $this->request->getPost('appBrowserName');
        $strAppBrowserVersion = $this->request->getPost('appBrowserVersion');
        $strAppPlatform = $this->request->getPost('appPlatform');
        $postCase = $this->request->getPost('postCase');
        $iMemIdx = $this->request->getPost('memIdx');
        $strBackUrl = $this->request->getPost('BackUrl');

        if (!$strAppType || !$strAppBrowserName || !$strAppPlatform || !$postCase || !$session->has('idx') || $session->get('idx') != $iMemIdx) {
            return $this->respond([
                'status'   => 400,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error2'],
                'strAppType' => $strAppType,
                'strAppBrowserName' => $strAppBrowserName,
                'strAppBrowserVersion' => $strAppBrowserVersion,
                'strAppPlatform' => $strAppPlatform,
                'postCase' => $postCase,
                'iMemIdx' => $iMemIdx
            ], 400);
        }

        $iCateIdx = $iCateIdx ?? "";

        $memberRecruitCategoryModel = new MemberRecruitCategoryModel();
        $jobCategoryModel = new JobCategoryModel();
        $RecruitNostradamusModel = new RecruitNostradamusModel();
        $QuestionModel = new QuestionModel();
        $RecruitModel = new RecruitModel();
        $InterviewModel = new InterviewModel();
        $cache = \Config\Services::cache();

        $aQuestion = [];
        $aCompanyName = [];
        $iAnswerTime = "";
        $iAnswer = null;
        $aPersonalQList = null;

        $aAllCategory = $cache->get('aAlljobCate.each');
        if (!$aAllCategory) {
            $aAllCategory = $jobCategoryModel->getAllcategory();
        }

        if ($iRecIdx) {
            $aInterview = $InterviewModel->getInterview($iRecIdx);
            $strIidx = $aInterview['idx'];
            $aRecQueIdx = explode(",", $aInterview['inter_question']);
            $iAnswerTime = $aInterview['inter_answer_time'];
            $aQuestion = $QuestionModel->getQue($aRecQueIdx, $aInterview['inter_question']);
            $aCompanyName = $RecruitModel->getCompany($iRecIdx);
            $iCateIdx = $aInterview['job_idx_position'];
        }

        if ($iMockIdx) {
            $aMock = $RecruitNostradamusModel->getMock($iMockIdx);
            $aCompanyName = $RecruitNostradamusModel->getCompanyName($iMockIdx);
            $aMockQueIdx = explode(",", $aMock['rec_nos_question']);
            $aQuestion = $QuestionModel->getQue($aMockQueIdx, $aMock['rec_nos_question']);
            $iCateIdx = $aMock['job_idx'];
        }

        if ($icMockIdx) {
            $aMock = $InterviewModel->getMock($icMockIdx);
            $aMockQueIdx = explode(",", $aMock['inter_question']);
            $aQuestion = $QuestionModel->getQue($aMockQueIdx, $aMock['inter_question']);
            $iAnswerTime = $aMock['inter_answer_time'];
            $iCateIdx = $aMock['job_idx_position'];
        }

        if ($sugAppIdx) {
            $aSug = $InterviewModel->getBizInterview($sugAppIdx);
            if ($aSug['idx'] != 1) {
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
            if ($aSug['old_ap_idx']) {
                $iCateIdx = $aSug['job_idx'];
            } else {
                $iCateIdx = $aSug['job_idx_position'];
            }
            $iAnswerTime = $aSug['inter_answer_time'];
            $iInterIdx = $aSug['idx'];
            $iAnswer = $iAnswerTime;
            $aPersonalQList = $aSug['sug_app_personal_q_list'];
        }

        $this->masterDB->transBegin();

        $result = $this->masterDB->table('iv_applier')
            ->set([
                'mem_idx' => $session->get('idx'),
                'job_idx' => $iCateIdx,
                'app_type' => $strAppType,
                'app_platform' => $strAppPlatform,
                'app_browser_name' => $strAppBrowserName,
                'app_browser_version' => $strAppBrowserVersion,
            ]);

        if ($iRecIdx) {
            $result->set([
                'rec_idx' => $iRecIdx,
                'i_idx' => $strIidx
            ]);
        }

        if ($iMockIdx) {
            $result->set(['rec_nos_idx' => $iMockIdx]);
        }

        if ($icMockIdx) {
            $result->set([
                'i_idx' => $icMockIdx,
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
            if (!$iMockIdx) {
                $iAnswer = $iAnswerTime;
            }
        } else {
            if ($iCateIdx == '465' || $iCateIdx == '475' || $iCateIdx == '476' || $iCateIdx == '477') { //영어, 정치 직무질문 4개
                $aGetQueRand = $QuestionModel->getQueRandJob($iCateIdx)->findAll(4);
            } else {
                if ($iCateIdx <= 153) {
                    $aGetQueRand = $QuestionModel->getQueRandJobOld($iCateIdx)->findAll(4);
                } else {
                    $aGetQueCommon = $QuestionModel->getQueRandCommon()->findAll(2); //공통질문 가져오기

                    $aGetQueRand = $QuestionModel->getQueRandJob($iCateIdx)->findAll(2);
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
            // foreach ($aAllCategory as $val) {
            //     foreach ($val as $key2 => $val2) {
            //         if ($key2 != 0) {
            //             if ($val2['idx'] == $iCateIdx) {
            //                 $strCode = $val2['job_depth_1'];
            //                 break;
            //             }
            //         }
            //     }
            // }

            if ($iCateIdx == "465") { //10580
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

            return $this->aResponse = [
                'status' => 500,
                'code' => [
                    'stat' => 'success',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error3'],
                'strBackUrl' => $strBackUrl != '' ? $strBackUrl : $this->backUrlList
            ];
        }

        $ApplierModel = new ApplierModel();
        $aApplierInfo = $ApplierModel->getStartApplier($strIdx);

        if ($aApplierInfo == "" || $aApplierInfo == null) {
            return $this->aResponse = [
                'status' => 500,
                'code' => [
                    'stat' => 'success',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error2'],
                'strBackUrl' => $strBackUrl ? $strBackUrl : "/"
            ];
        }

        cache()->save('is.applierStart.' . $strIdx . '.' .  $session->get('idx'), $aApplierInfo, 3600);

        if (!$aCompanyName) {
            $strComName = "";
        } else {
            $strComName = $aCompanyName['com_name'];
        }
        $this->aResponse = [
            'status'   => 200,
            'code'     => [
                'stat' => 'success',
                'token' => csrf_hash()
            ],
            'messages' => $this->globalvar->aApiMsg['success2'],
            'applyIdx' => $strIdx,
            'memIdx' => $session->get('idx'),
            'memName' => $session->get('mem_name'),
            'c_name' => $strComName
        ];

        return $this->respond($this->aResponse, $this->aResponse['status']);
    }


    public function delete(int $idx)
    {
    }
}
