<?php

namespace App\Controllers\Interview\My\resume;

use App\Controllers\BaseController;
use App\Controllers\Interview\WwwController;

use App\Models\MemKorModel;
use App\Models\MemberModel;
use App\Models\MemCateModel;
use App\Models\JobCategoryModel;
use App\Models\KoreaAreaModel;
use App\Models\ResumeModel;
use App\Models\FileModel;
use Config\Database;
use Config\Services;
use App\Libraries\SendLib;

class ResumeController extends WwwController
{
    public $db;
    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function resume()
    {
        $aData = $this->commonData();

        $this->header();
        //$this->aData['data']['session']['memIdx'] = 1;
        $memIdx = $this->aData['data']['session']['idx'];

        //이력서 작성시 사용한 cache 삭제
        //cache()->delete('postData.'.$memIdx);


        $resumeModel = new ResumeModel();

        $this->aData['data']['resume'] = $resumeModel->getResumeList($memIdx);

        echo view("www/my/resume/main", $this->aData);
        $this->footer(['resume']);
    }

    public function resumeModify($rIdx = 0, $str = null)
    {
        $aData = $this->commonData();

        $this->header();

        $resumeModel = new ResumeModel();

        $memIdx = $this->aData['data']['session']['idx'];
        $this->aData['data']['memIdx'] = $memIdx;
        $this->aData['data']['rIdx'] = $rIdx;
        if ($rIdx == 0) {
            //cache 삭제
            //cache()->delete('postData.' . $memIdx . '.' . $rIdx);
            $getApp = $this->request->getGet('app') ?? '';
            $getData = $this->request->getGet('data') ?? '';
            if ($getData != '') {
                $returnUrl = "/jobs/apply?app=" . $getApp . "&data=" . $getData;
                cache()->save('returnUrl.' . $memIdx, $returnUrl, 3600);
            } else {
                $returnUrl = "/my/resume";
                cache()->save('returnUrl.' . $memIdx, $returnUrl, 3600);
            }
        } else {
            $getApp = $this->request->getGet('app') ?? '';
            $getData = $this->request->getGet('data') ?? '';

            // 종합레포트 설정
            if($getData == 'set_report') {
                $returnUrl = "/report/share?report=" . $getApp;
                cache()->save('returnUrl.' . $memIdx, $returnUrl, 3600);
            }
            
            $boolMyResChk = $resumeModel
                ->select('idx')
                ->where([
                    'idx' => $rIdx,
                    'mem_idx' => $memIdx,
                    'delyn' => 'N'
                ])->first();
            if (!$boolMyResChk) {
                alert_back($this->globalvar->aMsg['error1']);
                exit;
            }
        }
        if (isset($str)) {
            //    $this->cacheSave($rIdx);
        }
        //resume cache naming : postData + session idx + resume idx
        $resumeModify = $postData = cache()->get('postData.' . $memIdx . '.' . $rIdx);

        //저장된 이력서 호출시 cache 처리 - DB 컬럼명과 cache 필드명 맞춰줘야함
        if ($rIdx > 0) { //&& !empty($postData)
            if (empty($postData)) {
                // $resumeModel = new ResumeModel();
                //$resumeModify = $resumeModel->getResume($rIdx, 'modify');
                $resumeModify['base'] = $resumeModel->getResume($rIdx, 'base');
                $resumeModify['interest'] = $resumeModel->getResume($rIdx, 'interest');
                $resumeModify['education'] = $resumeModel->getResume($rIdx, 'education');
                $resumeModify['career'] = $resumeModel->getResume($rIdx, 'career');
                $resumeModify['language'] = $resumeModel->getResume($rIdx, 'language');
                $resumeModify['license'] = $resumeModel->getResume($rIdx, 'license');
                $resumeModify['activity'] = $resumeModel->getResume($rIdx, 'activity');
                $resumeModify['portfolio'] = $resumeModel->getResume($rIdx, 'portfolio');

                $postData = $this->dbCache($rIdx, $resumeModify);
            }
        } else {
        }

        $this->aData['data']['postData'] = $postData;


        if (!empty($postData['education'])) {
            $this->aData['data']['postData']['education']['resumeSub'] = json_decode($postData['education']['resumeSub'], true);
        }
        if (!empty($postData['career'])) {
            $this->aData['data']['postData']['career']['resumeSub'] = json_decode($postData['career']['resumeSub'], true);
        }
        if (!empty($postData['language'])) {
            $this->aData['data']['postData']['language']['resumeSub'] = json_decode($postData['language']['resumeSub'], true);
        }
        if (!empty($postData['activity'])) {
            $this->aData['data']['postData']['activity']['resumeSub'] = json_decode($postData['activity']['resumeSub'], true);
        }
        if (!empty($postData['license'])) {
            $this->aData['data']['postData']['license']['resumeSub'] = json_decode($postData['license']['resumeSub'], true);
        }
        if (!empty($postData['rPortfolio'])) {
            $this->aData['data']['postData']['rPortfolio'] = json_decode($postData['rPortfolio'], true);
        }

        if ($str == 'base') {
            $memberModel = new MemberModel('iv_member');
            $this->aData['data']['member'] = $memberModel->MypageMem($memIdx);
            //$this->aData['data']['postData']['base']['filePath'] = $resumeModify['base']['file_save_name'];


        } else if ($str == 'interest') {

            $jobCategoryModel = new JobCategoryModel();
            $this->aData['data']['jobCate'] = $jobCategoryModel->getAllcategory();
            $this->cacheSave($rIdx);
        } else if ($str == 'education') {
            $this->cacheSave($rIdx);
        } else if ($str == 'career') {
            $this->cacheSave($rIdx);
        } else if ($str == 'language') {
            $this->cacheSave($rIdx);
        } else if ($str == 'activity') {
            $this->cacheSave($rIdx);
        } else if ($str == 'license') {
            $this->cacheSave($rIdx);
        } else {
            $memberModel = new MemberModel('iv_member');
            $this->aData['data']['member'] = $memberModel->MypageMem($memIdx);
            $str = 'modify';

           // if ($rIdx == 0) {
                $resumeModify = cache()->get('postData.' . $memIdx . '.' . $rIdx);
                $resumeModify['base']['bName'] = $this->aData['data']['member']['mem_name'];
                $resumeModify['base']['bTel'] = $this->aData['data']['member']['mem_tel'];
                $resumeModify['base']['bEmail'] = $this->aData['data']['member']['mem_email'];
                $resumeModify['base']['bBirth'] = $this->aData['data']['member']['mem_age'];

                cache()->save('postData.' . $memIdx . '.' . $rIdx, $resumeModify, 3600);
          //  }
            //$this->aData['data']['postData']['base']['filePath'] = $resumeModify['base']['file_save_name'];
        }

        echo view("www/my/resume/" . $str, $this->aData);
    }

    public function cacheSave($rIdx = 0, $str = null)
    {
        $session = session();
        $memIdx = $session->get('idx');
        //$memIdx = $this->aData['data']['session']['idx'];
        $aInputdata = $this->request->getPost();


        //날짜 형식 변경
        $arrinputdate = ['bMilitaryStartDate', 'bMilitaryEndDate', 'resumeSub', 'eYearMonth'];
        foreach ($arrinputdate as $val) {


            if ($val == 'resumeSub') {
                if (!empty($aInputdata['resumeSub'])) {
                    $resumeSubinputdate = ['sYearMonth', 'eYearMonth', 'sDate', 'eDate', 'lObtainDate', 'aStartDate', 'aEndDate'];
                    $resumeSubdata = json_decode($aInputdata['resumeSub'], true);
                    foreach ($resumeSubinputdate as $val2) {
                        if (!empty($resumeSubdata[0][$val2])) {
                            for($i=0; $i<count($resumeSubdata);$i++){
                            $create_date  = date_create($resumeSubdata[$i][$val2]);
                            $resumeSubdata[$i][$val2] = str_replace('-','',date_format($create_date, "Ym"));

                            $aInputdata[$val] = json_encode($resumeSubdata);
                        
                            }
                        }
                    }
                }
            } else if (!empty($aInputdata[$val])) {
            
                $create_date  = date_create($aInputdata[$val]);
                $aInputdata[$val] = str_replace('-','',date_format($create_date, "Ym"));
            }
          
        }

        //기존 cache 가져오기
        $aResumeData = cache()->get('postData.' . $memIdx . '.' . $rIdx);
        if (!empty($aInputdata)) {

            if (isset($str)) {
                $aResumeData[$str] = $aInputdata;
            } else {
                if (!empty($aInputdata['res_title'])) {
                    $aResumeData['res_title'] = $aInputdata['res_title'];
                }

                if (!empty($aInputdata['rIntro_contents'])) {
                    $aResumeData['rIntro_contents'] = $aInputdata['rIntro_contents'];
                }
                if (!empty($aInputdata['rPortfolio'])) {
                    $aResumeData['rPortfolio'] = $aInputdata['rPortfolio'];
                }
            }
            cache()->save('postData.' . $memIdx . '.' . $rIdx, $aResumeData, 3600);
        } else {
            $profileIdx = $this->request->getGet('file');
            $fileModel = new FileModel();

            if ($profileIdx) {
                $this->encrypter = Services::encrypter();   //공고 idx 복호화

                $decodeData = json_decode($this->encrypter->decrypt(base64url_decode($profileIdx)), true);

                $aResumeData['base']['fileIdx'] = $decodeData;
                $fileName = $fileModel->getProfile($decodeData);

                $aResumeData['base']['file_save_name'] = $fileName['file_save_name'];
                cache()->save('postData.' . $memIdx . '.' . $rIdx, $aResumeData, 3600);
            }
        }
    }

    public function resumeModifySubAction($rIdx = 0, $str = null)
    {
        $this->cacheSave($rIdx, $str);

        $this->response->redirect('/my/resume/modify/' . $rIdx);
    }

    public function resumeModifySubDelete($rIdx = 0, string $strBackUrl = '')
    {
        $session = session();
        $memIdx = $session->get('idx');

        $aGetData = $this->request->getGet();
        //$memIdx = $this->aData['data']['session']['idx'];

        $postData = cache()->get('postData.' . $memIdx . '.' . $rIdx);

        if ($aGetData['type'] == 'interest') {
            unset($postData[$aGetData['type']][$aGetData['key']]);
            array_values($postData[$aGetData['type']]);
        } else if ($aGetData['type'] == 'rPortfolio') {
            $resumeSub = json_decode($postData[$aGetData['type']], true);
            unset($resumeSub[$aGetData['key']]);
            array_values($resumeSub);
            $postData[$aGetData['type']] = json_encode($resumeSub);
        } else {
            $resumeSub = json_decode($postData[$aGetData['type']]['resumeSub'], true);
            unset($resumeSub[$aGetData['key']]);
            array_values($resumeSub);
            $postData[$aGetData['type']]['resumeSub'] = json_encode($resumeSub);
        }

        cache()->save('postData.' . $memIdx . '.' . $rIdx, $postData, 3600);

        $strUrl = '/my/resume/modify/' . $rIdx;
        $strUrl .= $strBackUrl ? '/' . $strBackUrl : '';
        $this->response->redirect($strUrl);
    }

    public function resumeModifySave($rIdx = 0)
    {
        $session = session();
        $memIdx = $session->get('idx');
        //$memIdx = $this->aData['data']['session']['idx'];
        $this->cacheSave($rIdx);

        $postData = cache()->get('postData.' . $memIdx . '.' . $rIdx);

        $rData = $this->cacheDb($postData);

        $resumeModel = new ResumeModel();
        $resumeIdx = $resumeModel->setResume($memIdx, $rIdx, $rData);
        $this->resumeAnalysis($resumeIdx); // 이력서 분석 데이터
        $returnUrl = cache()->get('returnUrl.' . $memIdx);

        if ($rIdx == 0) {
        }
        //cache 삭제
        cache()->delete('postData.' . $memIdx . '.' . $rIdx);
        if ($returnUrl) {
            $this->response->redirect($returnUrl);
        } else {
            $this->response->redirect('/my/resume');
        }
    }

    public function resumeDelete($rIdx)
    {
        $session = session();
        $memIdx = $session->get('idx');

        $resumeModel = new ResumeModel();
        $resumeModel->resetResume($memIdx, $rIdx);

        $this->response->redirect('/my/resume');
    }

    public function dbCache($rIdx, $dbArr)
    {
        $cacheArr = [];

        foreach ($dbArr as $key => $val) {
            $arrData = [];
            $jData = [];
            switch ($key) {
                case 'base':
                    $cacheArr['res_title'] = $dbArr[$key]['res_title'];  //제목
                    $cacheArr['rIntro_contents'] = $dbArr[$key]['res_intro_contents'];  //자기소개서
                    $cacheArr[$key]['profileFile'] = $dbArr[$key]['file_org_name']; //원본파일명
                    $cacheArr[$key]['file_save_name'] = $dbArr[$key]['file_save_name']; //저장파일명
                    $cacheArr[$key]['fileSize'] = $dbArr[$key]['file_size']; //파일사이즈
                    $cacheArr[$key]['fileIdx'] = $dbArr[$key]['file_idx_profile']; //파일idx
                    $cacheArr[$key]['bName'] = $dbArr[$key]['res_name'] ?? ""; //이름
                    $cacheArr[$key]['bBirth'] = $dbArr[$key]['res_birth'] ?? ""; //생년월일 > 나이
                    $cacheArr[$key]['bTel'] = $dbArr[$key]['res_tel'] ?? ""; //전화번호
                    $cacheArr[$key]['bEmail'] = $dbArr[$key]['res_email'] ?? ""; //이메일
                    $cacheArr[$key]['bGender'] = $dbArr[$key]['res_gender'] ?? ""; //성별
                    $cacheArr[$key]['bBohun'] = $dbArr[$key]['res_bohun_yn'] ?? ""; //보훈대상여부
                    $cacheArr[$key]['bMilitaryType'] = $dbArr[$key]['res_military_type'] ?? ""; //병역여부
                    $cacheArr[$key]['bMilitaryStartDate'] = $dbArr[$key]['res_military_start_date'] ?? ""; //복무 시작일
                    $cacheArr[$key]['bMilitaryEndDate'] = $dbArr[$key]['res_military_end_date'] ?? ""; //복무 종료일
                    $cacheArr[$key]['input_postcode'] = $dbArr[$key]['res_address_postcode'] ?? ""; //우편번호
                    $cacheArr[$key]['input_address'] = $dbArr[$key]['res_address'] ?? ""; //주소
                    $cacheArr[$key]['input_detailAddress'] = $dbArr[$key]['res_address_detail'] ?? ""; //주소상세
                    $cacheArr[$key]['careerProfile'] = $dbArr[$key]['res_career_profile'] ?? ""; //경력기술서

                    break;
                case 'interest':
                    foreach ($dbArr[$key] as $i => $j) {
                        $cacheArr[$key][$dbArr[$key][$i]['job_depth_text']] = $dbArr[$key][$i]['job_idx'] ?? ""; //관심직종
                    }

                    break;
                case 'education':
                    foreach ($dbArr[$key] as $i => $j) {
                        $jData[$i] = [
                            "num" => $i,
                            "eSchoolType" => $dbArr[$key][$i]['res_edu_school_type'], //학교구분
                            "eGradType" => $dbArr[$key][$i]['res_edu_graduate_type'], //재학여부
                            "eName" => $dbArr[$key][$i]['res_edu_school'], //학교명
                            "cName" => $dbArr[$key][$i]['res_edu_department'], //학과명
                            "sYearMonth" => $dbArr[$key][$i]['res_edu_admission'], //입학년도
                            "eYearMonth" => $dbArr[$key][$i]['res_edu_graduate'], //졸업년도
                            "score" =>   $dbArr[$key][$i]['res_edu_score'], //학점
                            "tscore" =>   $dbArr[$key][$i]['res_edu_tscore'], //총학점
                        ];
                    }
                    $arrData = json_encode($jData, true);
                    $cacheArr[$key]["resumeSub"] = $arrData;
                    break;
                case 'career':
                    foreach ($dbArr[$key] as $i => $j) {
                        $jData[$i] = [
                            "num" => $i,
                            "cName" => $dbArr[$key][$i]['res_career_company_name'], //회사명
                            "sDate" => $dbArr[$key][$i]['res_career_join_date'], //입사일
                            "eDate" => $dbArr[$key][$i]['res_career_leave_date'], //퇴사일
                            "depName" => $dbArr[$key][$i]['res_career_dept'], //부서명/직책
                            "business" => $dbArr[$key][$i]['res_career_contents'], //주요업무
                            "cpay" => $dbArr[$key][$i]['res_career_pay'], //연봉
                        ];
                    }
                    $arrData = json_encode($jData, true);
                    $cacheArr[$key]["resumeSub"] = $arrData;
                    break;
                case 'language':
                    foreach ($dbArr[$key] as $i => $j) {
                        $jData[$i] = [
                            "num" => $i,
                            "lName" => $dbArr[$key][$i]['res_language_name'], //시험명
                            "lScore" => $dbArr[$key][$i]['res_language_score'], //점수
                            "lLever" => $dbArr[$key][$i]['res_language_level'], //금수
                            "lObtainDate" => $dbArr[$key][$i]['res_language_obtain_date'], //취득일
                        ];
                    }
                    $arrData = json_encode($jData, true);
                    $cacheArr[$key]["resumeSub"] = $arrData;
                    break;
                case 'license':
                    foreach ($dbArr[$key] as $i => $j) {
                        $jData[$i] = [
                            "num" => $i,
                            "lName" => $dbArr[$key][$i]['res_license_name'], //자격증명
                            "lPublicOrg" => $dbArr[$key][$i]['res_license_public_org'], //발급처
                            "lLevel" => $dbArr[$key][$i]['res_license_level'], //합격여부
                            "lObtainDate" => $dbArr[$key][$i]['res_license_obtain_date'], //취득일
                        ];
                    }
                    $arrData = json_encode($jData, true);
                    $cacheArr[$key]["resumeSub"] = $arrData;
                    break;
                case 'activity':
                    foreach ($dbArr[$key] as $i => $j) {
                        $jData[$i] = [
                            "num" => $i,
                            "actName" => $dbArr[$key][$i]['res_activity_name'], //활동명
                            "detail" => $dbArr[$key][$i]['res_activity_score'], //상세
                            "aStartDate" => $dbArr[$key][$i]['res_activity_start_date'], //활동시작일
                            "aEndDate" => $dbArr[$key][$i]['res_activity_end_date'], //활동종료일
                        ];
                    }
                    $arrData = json_encode($jData, true);
                    $cacheArr[$key]["resumeSub"] = $arrData;
                    break;
                case 'portfolio':
                    foreach ($dbArr[$key] as $i => $j) {
                        $jData[$i] = [
                            "num" => $i,
                            "profileFile" => $dbArr[$key][$i]['file_save_name'], //파일경로
                            "file_save_name" => $dbArr[$key][$i]['file_org_name'], //파일명
                            "fileSize" => $dbArr[$key][$i]['file_size'], //파일크기

                        ];
                    }
                    $arrData = json_encode($jData, true);
                    $cacheArr["rPortfolio"] = $arrData;
                    break;

                default:
            }
        }

        $session = session();
        $memIdx = $session->get('idx');

        cache()->save('postData.' . $memIdx . '.' . $rIdx, $cacheArr, 3600);

        $postData = cache()->get('postData.' . $memIdx . '.' . $rIdx);
        return $postData;
    }

    public function cacheDb($postData)
    {

        //기본프로필
        if (!empty($postData['base'])) {
            $rData['base'] = $postData['base'];
        }
        if (!empty($postData['res_title'])) {
            $rData['base']['res_title'] = $postData['res_title'];
        }
        if (!empty($postData['rIntro_contents'])) {
            $rData['base']['rIntro_contents'] = $postData['rIntro_contents'];
        }
        //관심직무
        if (!empty($postData['interest'])) {
            $rData['interest'] = $postData['interest'];
        }
        //학력
        if (!empty($postData['education']['resumeSub'])) {
            $rData["education"] = json_decode($postData['education']['resumeSub'], true);
        }
        //경력
        if (!empty($postData['career']['resumeSub'])) {
            $rData["career"] = json_decode($postData['career']['resumeSub'], true);
        }
        //외국어
        if (!empty($postData['language']['resumeSub'])) {
            $rData["language"] = json_decode($postData['language']['resumeSub'], true);
        }
        //자격증
        if (!empty($postData['license']['resumeSub'])) {
            $rData["license"] = json_decode($postData['license']['resumeSub'], true);
        }
        //기타활동
        if (!empty($postData['activity']['resumeSub'])) {
            $rData["activity"] = json_decode($postData['activity']['resumeSub'], true);
        }
        //첨부파일
        if (!empty($postData['rPortfolio'])) {
            $rData["rPortfolio"] = json_decode($postData['rPortfolio'], true);
        }

        return $rData;
    }

    public function profile($rIdx)
    {
        $this->commonData();
        $this->header();

        $session = session();

        $memidx = $session->get('idx');

        $this->aData['data']['memIdx'] = $memidx;
        $this->aData['data']['rIdx'] = $rIdx;

        echo view("www/my/resume/profile", $this->aData);
    }

    public function resumeJobportal()
    {
        $jobPortal = $this->request->getPost('jobportal');
        $jobPortalId = $this->request->getPost('jobportal_id');
        $jobPortalPw = $this->request->getPost('jobportal_pw');

        $session = session();
        $memIdx = $session->get('idx');
        $rData['jobportal'] = $jobPortal;

        $sendLib = new SendLib();
        $sendResult = $sendLib->telegramSend("[인터뷰_이력서_불러오기]\n사이트 : " . $jobPortal . "\n아이디 : " . $jobPortalId . "\n비밀번호 : " . $jobPortalPw . "", "HB_TEST"); //텔레그램 전송

        $resumeModel = new ResumeModel();
        $resumeModel->jobportalResume($memIdx, $rData);
        $this->response->redirect('/my/resume');
    }

    private function resumeAnalysis($rIdx)
    {
        $resumeModel = new ResumeModel();
        // 학력 평가
        // edu : 최종 학력 평가
        // 학력종류 점수 : H(2), C(4), U(6), M(8), D(10)
        // 총 점수 = ((학교종류 점수 / 10 * 100) + (100 - (대학교 랭킹 / 1355 * 100)) + 학점 백분위) / 3
        $getAnalysisEdu = $resumeModel->getAnalysisEdu($rIdx);
        $estate = $getAnalysisEdu ? 1 : 0;
        $eScore = $getAnalysisEdu[0]->t_score ?? 0; //총 점수
        $eType = $getAnalysisEdu[0]->res_edu_school_type ?? ''; //학력 종류
        $eName = $getAnalysisEdu[0]->res_edu_school ?? ''; //학교명
        $eDep = $getAnalysisEdu[0]->res_edu_department ?? ''; //학과
        $etypeScore = $getAnalysisEdu[0]->type_score ?? 0; //학력 종류 점수
        $eschoolScore = $getAnalysisEdu[0]->school_rank ?? 0; //학교 순위
        $egradeScore = $getAnalysisEdu[0]->grade_score ?? 0; //학점 백분위

        // 경력 평가
        // career : 최종 경력 평가
        // 총경력 : 신입(0), 1년미만(2), 1~3년(4), 3~5년(6), 5년이상(8), 10년이상(10) 
        // 공백기간 : 0개월(10), 3개월(8) 6개월(6), 1년(4), 2년이상(2)
        // 이직횟수 : 0번(10), 1번(9), 2번(8), 3번(7), 4번(6), 5번이상(5)
        // 총 점수 = ((총경력점수 / 10 * 100) + (공백기간점수 / 10 * 100) + (이직횟수점수 / 10 * 100)) / 3
        $getAnalysisCareer = $resumeModel->getAnalysisCareer($rIdx);
        $cstate = $getAnalysisCareer ? 1 : 0;
        $cScore = $getAnalysisCareer[0]->t_score ?? 0; //총 점수
        $cYear = $getAnalysisCareer[0]->t_year ?? 0; //총 경력(년)
        $cName = $getAnalysisCareer[0]->res_career_company_name ?? ''; // 최종 회사명
        $cPay = $getAnalysisCareer[0]->res_career_pay ?? 0; // 연봉
        $cEnddate = $getAnalysisCareer[0]->res_career_leave_date ?? ''; // 퇴사일
        $cType = $getAnalysisCareer[0]->c_type ?? ''; //재직여부
        $cCount = $getAnalysisCareer[0]->rcnt ?? ''; //이직횟수
        $cBlank = $getAnalysisCareer[0]->cm3 ?? ''; //공백기간(월)
        $cAscore = $getAnalysisCareer[0]->c_score ?? ''; //총 경력 점수
        $cRscore = $getAnalysisCareer[0]->r_score ?? ''; //이직횟수 점수
        $cLscore = $getAnalysisCareer[0]->l_score ?? ''; //공백기간 점수

        // language : 어학 시험 수, 어학 시험 별 평가
        // 어학 시험 수 점수 : 0개(0), 1개(1), 2개(2), 3개(3), 4개(4), 5개이상(5)
        // 총 점수 = 각 어학시험별점수 합 / 어학시험 수 
        $getAnalysisLanguage = $resumeModel->getAnalysisLanguage($rIdx);
        $lstate = $getAnalysisLanguage ? 1 : 0;
        $sumlScore = 0;
        $lCnt = 0;
        $lData = [];
        $i = 0;
        foreach ($getAnalysisLanguage as $key => $val) {
            if ($getAnalysisLanguage[$i]->res_language_name == 'T') {
                $lCnt = $getAnalysisLanguage[$i]->cnt ?? 0; //어학 시험 수
                $lcntScore = $getAnalysisLanguage[$i]->l_score ?? 0; //어학 시험 수 점수
            } else {
                $sumlScore += $getAnalysisLanguage[$i]->l_score ?? 0;
                $lData[$i]['type'] = $getAnalysisLanguage[$i]->res_language_name ?? ''; //시험명(시험종류)
                $lData[$i]['score'] = $getAnalysisLanguage[$i]->res_language_score ?? 0; //시험점수
                $lData[$i]['valuation'] = $getAnalysisLanguage[$i]->l_score ?? 0; //평가점수
            }
            $i++;
        }
        if ($lstate == 1) {
            if ($sumlScore == 0) {
                $lScore = ($sumlScore + $lcntScore) / 2; //총 점수
            } else {
                $lScore = ($sumlScore / $lCnt + $lcntScore) / 2; //총 점수
            }
        } else {
            $lScore = 0;
        }
        // license : 자격증 수, 자격증 별 평가(DB 데이터 없을시 기타 분류)
        // 자격증 평가 : priority 데이터 있는경우(10), suitability 데이터 있는경우(7), 없는경우(4)
        // 총 점수 = 각 자격증별점수 합 / 자격증 수
        $getAnalysisLicense = $resumeModel->getAnalysisLicense($rIdx);
        $istate = $getAnalysisLicense ? 1 : 0;
        $sumiScore = 0;
        $iCnt = 0;
        $iData = [];
        $i = 0;
        foreach ($getAnalysisLicense as $key => $val) {
            if ($getAnalysisLicense[$i]->l_name == 'T') {
                $iCnt = $getAnalysisLicense[$i]->cnt ?? 0; //자격증 수
                $icntScore = $getAnalysisLicense[$i]->l_score ?? 0; //자격증 수 점수
            } else {
                $sumiScore += $getAnalysisLicense[$i]->l_score ?? 0;
                $iData[$i]['dep'] = $getAnalysisLicense[$i]->l_type ?? ''; //자격증 분야
                $iData[$i]['name'] = $getAnalysisLicense[$i]->l_name ?? ''; //자격증 명
                $iData[$i]['valuation'] = $getAnalysisLicense[$i]->l_score ?? 0; //평가점수
            }
            $i++;
        }

        if ($istate == 1) {
            if ($sumiScore == 0) {
                $iScore = ($sumiScore + $icntScore) / 2;
            } else {
                $iScore = ($sumiScore / $iCnt + $icntScore) / 2; //총 점수
            }
        } else {
            $iScore = 0;
        }

        $analysisData['edu']['state'] = $estate;
        $analysisData['edu']['score'] = $eScore;
        $analysisData['edu']['type'] = $eType;
        $analysisData['edu']['name'] = $eName;
        $analysisData['edu']['dep'] = $eDep;
        $analysisData['edu']['typeScore'] = $etypeScore;
        $analysisData['edu']['schoolRank'] = $eschoolScore;
        $analysisData['edu']['gradeSore'] = $egradeScore;

        $analysisData['career']['state'] = $cstate;
        $analysisData['career']['score'] = $cScore;
        $analysisData['career']['year'] = $cYear;
        $analysisData['career']['name'] = $cName;
        $analysisData['career']['pay'] = $cPay;
        $analysisData['career']['enddate'] = $cEnddate;
        $analysisData['career']['type'] = $cType;
        $analysisData['career']['count'] = $cCount;
        $analysisData['career']['blank'] = $cBlank;
        $analysisData['career']['careerScore'] = $cAscore;
        $analysisData['career']['leaveScore'] = $cLscore;
        $analysisData['career']['moveScore'] = $cRscore;

        $analysisData['language'] = $lData;
        $analysisData['language']['state'] = $lstate;
        $analysisData['language']['score'] = $lScore;
        $analysisData['language']['count'] = $lCnt;

        $analysisData['license'] = $iData;
        $analysisData['license']['state'] = $istate;
        $analysisData['license']['score'] = $iScore;
        $analysisData['license']['count'] = $iCnt;

        $jsonData = json_encode($analysisData, JSON_UNESCAPED_UNICODE);
        $resumeModel->setAnalysis($rIdx, $jsonData);
    }

    public function resumeReport($rIdx)
    {
        $this->commonData();
        $this->header();

        $session = session();

        $memidx = $session->get('idx');

        $this->aData['data']['memIdx'] = $memidx;
        $this->aData['data']['rIdx'] = $rIdx;

        $resumeModel = new ResumeModel();
        $resumeReport['base'] = $resumeModel->getResume($rIdx, 'base');
        //resume file_idx_profile
        //resume res_name
        $this->aData['data']['report'] = $resumeReport['base'];
        //resume_category 
        $resumeReport['interest'] = $resumeModel->getResume($rIdx, 'interest');
        $this->aData['data']['report']['interest'] = $resumeReport['interest'];

        //지원자 현황 분석 - 전체(각항목별), 나(포함항목)
        //지원자 수
        //foreach($resumeReport['interest'] as $key => $val){
        $this->aData['data']['reportTotal'] = $reportTotal = $resumeModel->reportResumeTotalCount($resumeReport['interest'][0]['job_idx']);
        //}
        //성별예측
        $genderData = $resumeModel->reportResumeGenderCount($resumeReport['interest'][0]['job_idx']);

        foreach ($genderData as $row) {
            $this->aData['data']['reportTotalGender']['All'] = $row->genderAll;
            if ($row->genderAll == 0 || $row->genderM == 0) {
                $this->aData['data']['reportTotalGender']['M'] = 0;
            } else {
                $this->aData['data']['reportTotalGender']['M'] = round($row->genderM / $row->genderAll * 100);
            }
            if ($row->genderAll == 0 || $row->genderW == 0) {
                $this->aData['data']['reportTotalGender']['W'] = 0;
            } else {
                $this->aData['data']['reportTotalGender']['W'] = round($row->genderW / $row->genderAll * 100);
            }
        }

        //연령별 현황
        $ageData = $resumeModel->reportResumeAgeCount($rIdx, $resumeReport['interest'][0]['job_idx']);
        $ageMyData = $resumeModel->reportResumeAgeCount($rIdx, $resumeReport['interest'][0]['job_idx'], 'my');
        foreach ($ageMyData as $row) {
            $myAge = $row->age;
        }

        $my = [];
        for ($i = 10; $i <= 50; $i = $i + 10) {
            $age50 = 0;
            foreach ($ageData as $row) {

                if ($myAge == $row->age && $row->age == $i) {
                    $my['age' . $i] = true;
                }
                if ($row->age == $i && $i < 50) {
                    $this->aData['data']['reportTotalAge']['age' . $i] = $row->total;
                } else {
                    if ($row->age >= 50) {
                        $age50 += $row->total;
                    }
                }
            }
            if ($i == 50) {
                $this->aData['data']['reportTotalAge']['age' . $i] = $age50;
            }
        }
        $this->aData['data']['reportAgeMy'] = $my;

        //학력별 현황 - 이력서 내용 수정 후 가능

        //경력별 현황
        $careerMyData = $resumeModel->reportResumeCareerCount($rIdx, $resumeReport['interest'][0]['job_idx'], 'my');
        if (isset($careerMyData)) {
            if ($careerMyData->mm >= 5) {
                $this->aData['data']['reportCareerMy']['car10'] = true;
            } else if ($careerMyData->mm > 3 && $careerMyData->mm < 5) {
                $this->aData['data']['reportCareerMy']['car5'] = true;
            } else if ($careerMyData->mm > 1 && $careerMyData->mm < 3) {
                $this->aData['data']['reportCareerMy']['car3'] = true;
            } else if ($careerMyData->mm > 0 && $careerMyData->mm < 1) {
                $this->aData['data']['reportCareerMy']['car1'] = true;
            } else {
                $this->aData['data']['reportCareerMy']['car0'] = true;
            }
        }
        $careerData = $resumeModel->reportResumeCareerCount($rIdx, $resumeReport['interest'][0]['job_idx']);

        if (isset($careerData)) {
            $careerTotal = $careerData->c0 + $careerData->c1 + $careerData->c3 + $careerData->c5 + $careerData->c10;
            //경력을 입력하지 않은 경우 신입으로 취급
            $c0 = $reportTotal['jobCnt'] - $careerTotal + $careerData->c0;

            $this->aData['data']['reportTotalCareer']['car0'] = $c0;
            $this->aData['data']['reportTotalCareer']['car1'] = $careerData->c1;
            $this->aData['data']['reportTotalCareer']['car3'] = $careerData->c3;
            $this->aData['data']['reportTotalCareer']['car5'] = $careerData->c5;
            $this->aData['data']['reportTotalCareer']['car10'] = $careerData->c10;
        }

        //외국어 현황 - 이력서에서 외국어 선택 필드로 수정 필요 
        $lnagData = $resumeModel->reportResumeLnagCount($rIdx, $resumeReport['interest'][0]['job_idx']);
        $lnagMyData = $resumeModel->reportResumeLnagCount($rIdx, $resumeReport['interest'][0]['job_idx'], "my");

        foreach ($lnagData as $row) {
            foreach ($lnagMyData as $row2) {
                if ($row2->res_language_name == $row->res_language_name) {
                    $this->aData['data']['reportlanguageMy'][$row2->res_language_name] = true;
                }
            }
            //해당부분은 데이터 업로드 이후 이력서 수정 후 상황에 따라 수정
            //$this->aData['data']['reportTotallanguage'][$row->res_language_name] = $row->lang_cnt;
            if ($row->res_language_name == 'TOEIC') {
                $this->aData['data']['reportTotallanguage']['TOEIC'] = $row->lang_cnt;
            } else if ($row->res_language_name == 'TOEFL') {
                $this->aData['data']['reportTotallanguage']['TOEFL'] = $row->lang_cnt;
            } else if ($row->res_language_name == 'TEPS') {
                $this->aData['data']['reportTotallanguage']['TEPS'] = $row->lang_cnt;
            } else if ($row->res_language_name == 'OPIC') {
                $this->aData['data']['reportTotallanguage']['OPIC'] = $row->lang_cnt;
            } else if ($row->res_language_name == 'JPT') {
                $this->aData['data']['reportTotallanguage']['JPT'] = $row->lang_cnt;
            } else if ($row->res_language_name == 'HSK') {
                $this->aData['data']['reportTotallanguage']['HSK'] = $row->lang_cnt;
            } else { //기타
                $this->aData['data']['reportTotallanguage']['ETC'] = $row->lang_cnt;
            }
        }

        //TOEIC 점수
        $toeicData = $resumeModel->reportResumeLangToeicCount($rIdx, $resumeReport['interest'][0]['job_idx']);
        $toeicMyData = $resumeModel->reportResumeLangToeicCount($rIdx, $resumeReport['interest'][0]['job_idx'], "my");
        $myScore = 0;
        foreach ($toeicMyData as $row2) {
            $myScore = $row2->score;
        }

        foreach ($toeicData as $row) {
            if ($row->score > 900) {
                if ($row->score == $myScore) $this->aData['data']['reportToeicMy']['T1000'] = true;
                $this->aData['data']['reportTotalToeic']['T1000'] = $row->total;
            } else if ($row->score > 800) {
                if ($row->score == $myScore) $this->aData['data']['reportToeicMy']['T900'] = true;
                $this->aData['data']['reportTotalToeic']['T900'] = $row->total;
            } else if ($row->score > 700) {
                if ($row->score == $myScore) $this->aData['data']['reportToeicMy']['T800'] = true;
                $this->aData['data']['reportTotalToeic']['T800'] = $row->total;
            } else if ($row->score > 600) {
                if ($row->score == $myScore) $this->aData['data']['reportToeicMy']['T700'] = true;
                $this->aData['data']['reportTotalToeic']['T700'] = $row->total;
            } else {
                if ($row->score == $myScore) $this->aData['data']['reportToeicMy']['T600'] = true;
                $this->aData['data']['reportTotalToeic']['T600'] = $row->total;
            }
        }
        //자격증 개수
        $licenseData = $resumeModel->reportResumeLicenseTotleCount($rIdx, $resumeReport['interest'][0]['job_idx']);
        $licenseTotal = $resumeModel->reportResumeLicenseTotleCount($rIdx, $resumeReport['interest'][0]['job_idx'], "total");
        $licenseFtotal = $resumeModel->reportResumeLicenseTotleCount($rIdx, $resumeReport['interest'][0]['job_idx'], "ftotal");
        $licenseMyCnt = $resumeModel->reportResumeLicenseTotleCount($rIdx, $resumeReport['interest'][0]['job_idx'], "my");
        foreach ($licenseTotal as $row) {
            $licTotal = $row->total;
        }
        foreach ($licenseFtotal as $row) {
            $licFtotal = $row->total;
        }
        foreach ($licenseMyCnt as $row) {
            $licMyCnt = $row->res_cnt;
        }

        $this->aData['data']['reportTotalLicense']['L0'] = $licTotal - $licFtotal;

        foreach ($licenseData as $row) {
            if ($row->res_cnt == 1) {
                if ($row->res_cnt == $licMyCnt) $this->aData['data']['reportLicenseMY']['L1'] = true;
                $this->aData['data']['reportTotalLicense']['L1'] = $row->cnt;
            } else if ($row->res_cnt == 2) {
                if ($row->res_cnt == $licMyCnt) $this->aData['data']['reportLicenseMY']['L2'] = true;
                $this->aData['data']['reportTotalLicense']['L2'] = $row->cnt;
            } else if ($row->res_cnt == 3) {
                if ($row->res_cnt == $licMyCnt) $this->aData['data']['reportLicenseMY']['L3'] = true;
                $this->aData['data']['reportTotalLicense']['L3'] = $row->cnt;
            } else if ($row->res_cnt >= 4) {
                if ($row->res_cnt == $licMyCnt) $this->aData['data']['reportLicenseMY']['L4'] = true;
                $this->aData['data']['reportTotalLicense']['L4'] += $row->cnt;
            }
        }

        //자격증 현황
        //기타활동 개수
        //기타문서 제출

        //나의 스펙, 나의 스펙분석 - 나, 전체
        //학력 - 최종학위, 학교순위, 학점
        //경력 - 관심직무 연관성, 근무연수
        //어학 - 어학자격증 수, 점수
        //자격증 - 개수, 연관성

        //이력서 점수


        echo view("www/my/resume/report", $this->aData);
    }

    public function __destruct()
    {
        $this->db->close();
    }
}
