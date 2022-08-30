<?php

namespace App\Controllers\Interview\My\main;

use App\Controllers\BaseController;
use App\Controllers\Interview\WwwController;

use App\Models\{
    MemberModel,
    MemberRecruitCategoryModel,
    MemberRecruitKor,
    FileModel,
    MemberPushModel,
    MemberRestrictionsCompanyModel,
    MemberRecruitScrapModel,
    RecruitModel,
    AlarmModel,
    SearchModel,
    RecruitInfoModel,
    ApplierModel,
    CompnaySuggestModel,
    ResumeModel,
};
use App\Libraries\{
    EncryptLib,
    TimeLib
};

use Config\Database;
use Config\Services;

use CodeIgniter\I18n\Time;

class MypageController extends WwwController
{

    public function main()
    {
        $this->commonData();

        //멤버 테이블
        $memberModel = new MemberModel();

        //멤버가 선택한 희망직무 테이블
        $memCateModel = new MemberRecruitCategoryModel();

        //멤버가 선택한 희망지역 테이블
        $memKorModel = new MemberRecruitKor();

        $alarmModel = new AlarmModel();
        $recruitInfoModel = new RecruitInfoModel();
        $applierModel = new ApplierModel();
        $compnaySuggestModel = new CompnaySuggestModel();
        $resumeModel = new ResumeModel();

        $memidx = $this->aData['data']['session']['idx'];

        //N아이콘 값 구하기
        $aHasData['alarm'] = $alarmModel->checkAlarm($memidx, 3);
        $aHasData['recruitInfo'] = $recruitInfoModel->checkRecruitInfo($memidx, 3);
        $aHasData['applier'] = $applierModel->checkApplier($memidx, 3);
        $aHasData['suggest'] = $compnaySuggestModel->checkSuggest($memidx, 3);
        $aHasData['resume'] = $resumeModel->checkResume($memidx, 3);

        //기본적인 마이페이지 정보 가져오기 (이름 등)
        $aRowMember = $this->aData['data']['Member'] = $memberModel->MypageMem($memidx);

        if ($aRowMember) {
            if ($aRowMember['mem_name'] == null || $aRowMember['mem_name'] == "") {
                $this->aData['data']['Member']['mem_name'] = '사용자';
            }
        }

        $fileModel = new FileModel();
        $this->aData['data']['file'] = ["file_save_name" => "/static/www/img/sub/prf_no_img.jpg"];

        if ($aRowMember['file_idx_profile']) {
            $fileName = $fileModel->getProfile($aRowMember['file_idx_profile']);
            $this->aData['data']['file'] = ["file_save_name" => $this->aData['data']['url']['media'] . $fileName['file_save_name']];
        }

        //희망지역 가져오기
        $aRowKor = $this->aData['data']['kor'] = $memKorModel->getKorArea($memidx);

        if ($aRowKor == null || $aRowKor == '') {
            $this->aData['data']['kor'][0]['area_depth_text_1'] = '관심 직무 입력하고, 맞춤 정보 추천받기';
        }

        //희망직무 가져오기
        $aRowCategory = $this->aData['data']['category'] = $memCateModel->getJopcategory($memidx);

        if ($aRowCategory == null || $aRowCategory == '') {
            $this->aData['data']['category'][0]['job_depth_text'] = '어떤 포지션에서 일하고 싶나요?';
        }
        
        $this->aData['data']['nIcon'] = $aHasData;

        $this->header();
        echo view("www/my/main/main", $this->aData);
        $this->footer(['mypage']);
    }

    public function modify()
    {
        $this->commonData();

        $memidx = $this->aData['data']['session']['idx'];
        $profileIdx = $this->request->getGet('file');

        //수정할 멤버 테이블
        $memberModel = new MemberModel();
        //멤버가 선택한 희망직무 테이블
        $memCateModel = new MemberRecruitCategoryModel();

        //멤버가 선택한 희망지역 테이블
        $memKorModel = new MemberRecruitKor();

        $aRowMember = $this->aData['data']['member'] = $memberModel->MypageMem($memidx);

        $today = date("Y");
        
        //나이를 출생년도로 변경
        if (!$aRowMember['mem_age']) {
            $this->aData['data']['member']['mem_age'] = "";
        } else {
            // $this->aData['data']['member']['mem_age'] = $today - $aRowMember['mem_age'];
            $this->aData['data']['member']['mem_age'] = $aRowMember['mem_age'];
        }

        if (strpos($aRowMember['mem_id'], 'naver_')) {
            $this->aData['data']['loginType'] = '네이버 로그인 사용 중';
        } else if (strpos($aRowMember['mem_id'], 'kakao_')) {
            $this->aData['data']['loginType'] = '카카오 로그인 사용 중';
        } else if (strpos($aRowMember['mem_id'], 'apple_')) {
            $this->aData['data']['loginType'] = '애플 로그인 사용 중';
        } else {
            $this->aData['data']['loginType'] = "";
        }

        // var_dump($this->aData['data']['modify']['mem_age']);
        // file_idx_profile //개인 프로필
        // job_idx_position //관심 직무(희망직무)
        // area_idx //관심지역(희망지역)
        // mem_pay //희망 연봉
        $fileModel = new FileModel();
        $this->aData['data']['file'] = ["file_save_name" => "/static/www/img/sub/prf_no_img.jpg"];

        if ($aRowMember['file_idx_profile']) {
            $fileName = $fileModel->getProfile($aRowMember['file_idx_profile']);
            $this->aData['data']['file'] = ["file_save_name" => $this->aData['data']['url']['media'] . $fileName['file_save_name']];
        }

        if ($profileIdx) {
            $this->encrypter = Services::encrypter();   //공고 idx 복호화

            $decodeData = json_decode($this->encrypter->decrypt(base64url_decode($profileIdx)), true);
            $this->aData['data']['get']['fileIdx'] = $decodeData;
            $fileName = $fileModel->getProfile($decodeData);

            $this->aData['data']['file'] = ["file_save_name" => $this->aData['data']['url']['media'] . $fileName['file_save_name']];
        }

        //희망직무 가져오기
        $aRowCategory = $this->aData['data']['category'] = $memCateModel->getJopcategory($memidx);

        //희망지역 가져오기
        $aRowKor = $this->aData['data']['kor'] = $memKorModel->getKorArea($memidx);


        if ($aRowKor == null || $aRowKor == '' || $aRowCategory == null || $aRowCategory == '' || $aRowMember['mem_pay'] == null || $aRowMember['mem_pay'] == '') {
            $this->aData['data']['wantCate'] = 0;
        } else {
            $this->aData['data']['wantCate'] = 1;
        }

        $this->header();
        echo view("www/my/main/modify", $this->aData);
        $this->footer(['modify']);
    }

    public function modifyAction()
    {

        $this->commonData();

        $memidx = $this->aData['data']['session']['idx'];

        $strloginName = $this->request->getPost('loginName');
        $strModifyPhone = $this->request->getPost('ModifyPhone');
        $strModifyAge = $this->request->getPost('ModifyAge');
        $strExtraAddress = $this->request->getPost('input_extraAddress');
        $strPostcode = $this->request->getPost('input_postcode');
        $strAddress = $this->request->getPost('input_address');
        $strDetailAddress = $this->request->getPost('input_detailAddress');
        $strProfileIdx = $this->request->getPost('profileIdx');

        $strProfileFile = $this->request->getPost('profileFile');
        $strFilePath = $this->request->getPost('filePath');
        $strFileSize = $this->request->getPost('fileSize');

        $postCase = $this->request->getPost('postCase');
        $strBackUrl = $this->request->getPost('backUrl');

        if ($postCase == "" || $postCase == null) {
            alert_url($this->globalvar->aMsg['error1'], $strBackUrl ? $strBackUrl : "/");
            exit;
        }
        if (!$strloginName || !$strModifyPhone || !$strModifyAge || !$strPostcode || !$strAddress) {
            alert_url($this->globalvar->aMsg['error1'], $strBackUrl ? $strBackUrl : "/");
            exit;
        }

        //출생년도를 나이로 변경
        // $today = date("Y");
        // $strModifyAge = $today - $strModifyAge;

        //트랜잭션 start
        $this->masterDB->transBegin();

        if ($strProfileFile) {
            $this->masterDB->table('iv_file')
                ->set([
                    'file_type' => 'M',
                    'file_org_name' => $strProfileFile,
                    'file_save_name' => $strFilePath,
                    'file_size' => $strFileSize,
                ])
                ->set(['file_reg_date' => 'NOW()'], '', false)
                ->set(['file_mod_date' => 'NOW()'], '', false)
                ->insert();

            $fileIdx = $this->masterDB->insertID();

            $strProfileIdx = $fileIdx;
        }

        $result = $this->masterDB->table('iv_member')
            ->set([
                'mem_name' => $strloginName,
                'mem_tel' => $strModifyPhone,
                'mem_age' => $strModifyAge,
                'mem_address' => $strAddress . $strExtraAddress,
                'mem_address_detail' => $strDetailAddress,
                'mem_address_postcode' => $strPostcode
            ])
            ->set(['mem_mod_date' => 'NOW()'], '', false)

            ->where([
                'idx' => $memidx,
            ]);

        if ($strProfileIdx) {

            $result->set(['file_idx_profile' => $strProfileIdx]);
        }

        $result->update();

        // 트랜잭션 end
        if ($this->masterDB->transStatus() === false) {
            $this->masterDB->transRollback();
            return alert_url($this->globalvar->aMsg['error2'], $strBackUrl ? $strBackUrl : $this->backUrl);
        } else {
            $this->masterDB->transCommit();
            $session = session();
            $session->set(['mem_name' => $strloginName]);
            return alert_url($this->globalvar->aMsg['success1'], '/my/main');
        }
    }

    public function profile()
    {
        $this->commonData();
        $this->header();

        $session = session();

        $memidx = $session->get('idx');

        $this->aData['data']['memIdx'] = $memidx;


        echo view("www/my/main/profile", $this->aData);
        $this->footer(['quick']);
    }

    public function albumAction()
    {

        $this->commonData();

        $strProfileFile = $this->request->getPost('profileFile');
        $strFilePath = $this->request->getPost('filePath');
        $strFileSize = $this->request->getPost('fileSize');
        $memIdx = $this->request->getPost('memIdx');
        $postCase = $this->request->getPost('postCase');
        $strBackUrl = $this->request->getPost('backUrl');

        if ($postCase == "" || $postCase == null) {
            alert_url($this->globalvar->aMsg['error1'], $strBackUrl ? $strBackUrl : "/");
            exit;
        }

        $session = session();

        $this->masterDB->table('iv_file')
            ->set([
                'file_type' => 'M',
                'file_org_name' => $strProfileFile,
                'file_save_name' => $strFilePath,
                'file_size' => $strFileSize,
            ])
            ->set(['file_reg_date' => 'NOW()'], '', false)
            ->set(['file_mod_date' => 'NOW()'], '', false)
            ->insert();

        $fileIdx = $this->masterDB->insertID();

        //암호화
        $this->encrypter = Services::encrypter();

        $encodeData = base64url_encode($this->encrypter->encrypt(json_encode($fileIdx)));
        return redirect()->to('/my/modify?file=' . $encodeData);
    }

    public function exist()
    {
        $this->commonData();
        $this->header();

        $session = session();

        $memidx = $session->get('idx');

        $this->aData['data']['memIdx'] = $memidx;

        $fileModel = new FileModel();

        $aAllProfile = $fileModel->getAllprofile($memidx)->findAll();

        //암호화
        $this->encrypter = Services::encrypter();

        if ($aAllProfile) {
            foreach ($aAllProfile as $key => $val) {
                $aAllProfile[$key]['Enidx'] = base64url_encode($this->encrypter->encrypt(json_encode($val['idx'])));
            }
        }
        $this->aData['data']['profile'] = $aAllProfile;

        echo view("www/my/main/exist", $this->aData);
        $this->footer(['quick']);
    }

    public function setting()
    {
        $this->commonData();
        $this->header();

        echo view("www/my/main/setting", $this->aData);
        $this->footer(['setting']);
    }

    public function push()
    {
        $this->commonData();
        $this->header();

        $session = session();

        $memidx = $session->get('idx');
        $this->aData['data']['memIdx'] = $memidx;

        $MemberPushModel = new MemberPushModel();
        $aPushInfo = $MemberPushModel->getPushInfo($memidx);

        if (!$aPushInfo) {
            $aPushInfo = ['recommend' => "N", 'notice_event' => "N", 'report_read' => "N", 'company_proposal' => "N", 'retry_request_accept' => "N", 'scrap_deadline' => "N", 'scrap_new_recurit' => "N"];
        }
        $this->aData['data']['PushInfo'] = $aPushInfo;

        echo view("www/my/main/push", $this->aData);
        $this->footer(['quick']);
    }

    public function restrictionsList()
    {
        // data init
        $this->commonData();
        $iMemIdx = $this->aData['data']['session']['idx'];

        $memberRestrictionsCompanyModel = new MemberRestrictionsCompanyModel;
        $memberRestrictionsCompanyModel
            ->select(['iv_company.com_name as comName', 'iv_company.idx as comIdx'])
            ->getRestrictionsList($iMemIdx);

        $aList = $memberRestrictionsCompanyModel->paginate(10, 'cut');

        $this->aData['data']['list'] = $aList;
        $this->aData['data']['pager'] = $memberRestrictionsCompanyModel->pager;

        $this->header();
        echo view("www/my/restrictions/list", $this->aData);
        $this->footer(['restrictions']);
    }

    public function restrictionsSearch()
    {
        // data init
        $this->commonData();
        $iMemIdx = $this->aData['data']['session']['idx'];
        $keyword = $this->request->getGet('keyword') ?? '';

        $searchModel = new SearchModel('iv_company');

        $searchModel
            ->getCompany($keyword)
            ->select([
                'iv_company.idx as comIdx',
                'iv_company.com_name as comName'
            ])
            ->join(
                'iv_member_restrictions_company',
                "
                iv_member_restrictions_company.com_idx = iv_company.idx 
                AND iv_member_restrictions_company.mem_idx = {$iMemIdx} 
                AND iv_member_restrictions_company.delyn = 'N'
                ",
                'left'
            )
            ->where(['iv_member_restrictions_company.idx' => null]);

        if ($keyword == '') {
            $searchModel
                ->orderBy('rand()', '', false);
        }
        $aList = $searchModel
            ->paginate(10, 'restrictions_company');

        $this->aData['data']['list'] = $aList;
        $this->aData['data']['allCount'] = $searchModel->pager->getTotal('restrictions_company');
        $this->aData['data']['pager'] = $searchModel->pager;
        $this->aData['data']['keyword'] = $keyword;

        $this->header();
        echo view("www/my/restrictions/search", $this->aData);
        $this->footer(['quick']);
    }

    public function recentlyList()
    {
        // data init
        $this->commonData();
        $iMemIdx = $this->aData['data']['session']['idx'] ?? false;
        $timeLib = new TimeLib();
        $aScrap = [];
        if ($cookie = get_cookie('recently') ?? false) {
            $aRecIdx = json_decode($cookie, true);

            $recruitModel = new RecruitModel();
            $aList = $recruitModel
                ->getRecruitListPure()
                ->select(
                    'iv_recruit.idx as recIdx, 
                 iv_recruit.rec_title as recTitle, 
                 iv_recruit.rec_career as recCareer, 
                 iv_recruit.rec_end_date as recEndDate, 
                 iv_company.com_name as comName, 
                 iv_file.file_save_name as fileComLogo,
                 iv_recruit.rec_apply as recApply'
                )
                ->whereIn('iv_recruit.idx', $aRecIdx)
                ->paginate(10, 'recently');

            if ($iMemIdx) { // 스크랩
                $memberRecruitScrapModel = new MemberRecruitScrapModel;
                $aScrap = $memberRecruitScrapModel
                    ->where('scr_type', 'R')
                    ->getMyScrap($iMemIdx)
                    ->findColumn('rec_idx');
            }

            foreach ($aList as $key => $val) {
                if ($aScrap) {
                    if (in_array($val['recIdx'], $aScrap)) {
                        $aList[$key]['scrap'] = true;
                    }
                }
                if ($val['recCareer'] == 'N') {
                    $aList[$key]['recCareer'] = '신입';
                } else if ($val['recCareer'] == 'C') {
                    $aList[$key]['recCareer'] = '경력';
                } else {
                    $aList[$key]['recCareer'] = '경력무관';
                }
                if ($val['recEndDate']) {
                    $aList[$key]['recEndDate'] = $timeLib->makeDay($val['recEndDate']);
                }

                if ($val['area_depth_text_2']) {
                    $aList[$key]['area_depth_text_1'] .= ".{$val['area_depth_text_2']}";
                }
            }
            $this->aData['data']['pager'] = $recruitModel->pager;
        }

        $this->aData['data']['list'] = $aList ?? [];

        $this->header();
        echo view("www/my/recently/list", $this->aData);
        $this->footer(['recently']);
    }

    public function recentlyDelete()
    {
        // data init
        $this->commonData();
        $aRecIdx = $this->request->getPost('recIdx') ?? [];
        $cookie = get_cookie('recently');

        $aList = [];

        $aCookie = json_decode($cookie);

        foreach ($aCookie as $val) {
            if (in_array($val, $aRecIdx)) {
                continue;
            }
            $aList[] = $val;
        }

        if (count($aList) === 0) {
            setcookie('recently', '', time() - 60, '/');
        } else {
            $aList = json_encode($aList);
            setcookie('recently', $aList, time() + 86400, '/');
        }

        alert_back($this->globalvar->aMsg['success2']);
    }

    public function alarm($aType = '')
    {
        $this->commonData();
        $this->header();

        $session = session();

        $memIdx = $session->get('idx');

        $this->aData['data']['memIdx'] = $memIdx;
        $alarmType = [];
        if ($aType == 'company') {
            $alarmType = ['S', 'P'];
        } else if ($aType == 'board') {
            $alarmType = ['N', 'E'];
        }
        $this->aData['data']['aType'] = $aType;

        $alarmModel = new AlarmModel();
        $alarmData = $alarmModel->selectAlarm($memIdx, $alarmType);
        //암호화
        $this->encrypter = Services::encrypter();
        foreach ($alarmData as $key => $val) {
            //시간 표시
            $aDate = date("Y-m-d", strtotime($alarmData[$key]['reg_date']));
            $diff = time() - strtotime($alarmData[$key]['reg_date']);

            $s = 60; //1분 = 60초
            $h = $s * 60; //1시간 = 60분
            $d = $h * 24; //1일 = 24시간

            if ($diff < $s * 2) {
                $aDateResult = '방금 전';
            } elseif ($h > $diff && $diff >= $s * 2) {
                $aDateResult = round($diff / $s) . '분전';
            } elseif ($d > $diff && $diff >= $h) {
                $aDateResult = round($diff / $h) . '시간전';
            } else {
                $aDateResult = $aDate;
            }
            $alarmData[$key]['aDateResult'] = $aDateResult;
            //page link

            $alarmData[$key]['pageIdx'] = base64url_encode($this->encrypter->encrypt(json_encode($alarmData[$key]['alarm_page_idx'])));
        }
       // $this->commonClass->setAlarm('G', 'E', 'I', '1', 'testtt', 'test', $memIdx);
        
        $this->aData['data']['alarm'] = $alarmData;
        echo view("www/my/main/alarm", $this->aData);
        $this->footer(['alarm']);
    }

    public function resetPwd()
    {
        $this->backUrl = '/';

        $this->commonData();

        $this->header();
        echo view("www/my/main/resetPwd", $this->aData);
    }
    public function resetAction()
    {
        $session = session();

        $memIdx = $session->get('idx');

        $strNewPassword = $this->request->getPost('newpassword');
        $encryptLib = new EncryptLib();
        $encryptNewPassword = $encryptLib->makePassword($strNewPassword);

        $memberModel = new MemberModel();
        $memberData = $memberModel->MypageMem($memIdx);
        $strId = $memberData['mem_id'];

        $strBeforeDate = date("Y-m-d H:i:s", strtotime("-5 minutes"));
        // getLastPasswordDate() : 라스트 패스워드 변경일의 데이터가 있을시 비밀번호 변경 불가
        $aMemRow = $memberModel->getLastPasswordDate($strId, $strBeforeDate);
        if ($aMemRow) {
            return alert_back($this->globalvar->aMsg['error6']);
        }

        $strGetResultPw = dot_array_search('mem_password', $memberData);

        if ($encryptLib->checkPassword($strNewPassword, $strGetResultPw)) { //checkPassword(사용자가 입력한 비밀번호, db에 있는 비밀번호) 
            return alert_back($this->globalvar->aMsg['error7']);
        } else {
            $aRow = $memberModel->getOldMember($strId, $strNewPassword);
            if ($aRow) {
                return alert_back($this->globalvar->aMsg['error7']);
            }
        }

        $result = $this->masterDB->table('iv_member')
            ->set(['mem_password' => $encryptNewPassword])
            ->set(['mem_last_password_date' => 'NOW()'], '', false)
            ->where(['idx' => $memIdx])
            ->update();
        if ($result) {
            return redirect()->to('/my/modify');
        } else {
            return alert_back($this->globalvar->aMsg['error3']);
        }
    }
}
