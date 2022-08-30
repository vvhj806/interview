<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;

use Config\{
    Database,
    Services,
};
use App\Models\{
    ConfigModel,
    MemberModel,
    InterviewModel,
    InterestModel,
    AuthTelModel,
    JobCategoryModel,
    KoreaAreaModel,
    MemberRecruitCategoryModel,
    MemberRecruitKor,
    UniversityModel,
};

use App\Libraries\{
    EncryptLib,
    SortUrlLib,
};

use Google_Client;

class AuthController extends BaseController
{
    public $masterDB;
    private $backUrlAdmin = '/prime/login';
    private $backUrl = '/login';
    private $aData = [];
    public function __construct()
    {
        $this->masterDB = Database::connect('master');
    }

    public function commonData()
    {
        // data init
        $aCommon = [];
        $aCommon['data'] = $this->viewData;
        $aCommon['data']['page'] = $this->request->getUri()->getPath();

        $session = session();
        $aCommon['data']['session'] = [
            'idx' => $session->get('idx'),
            'id' => $session->get('mem_id'),
            'name' => $session->get('mem_name')
        ];

        $this->aData = $aCommon;
    }

    public function logout()
    {
        $session = session();
        $this->masterDB->table('log_member_login')
            ->set([
                'mem_idx' => $session->get('idx'),
                'login_status' => 'logout'
            ])
            ->set('log_reg_date', 'now()', false)
            ->insert(); //log insert -> log table

        // 세션설정
        session()->destroy();
        return redirect($this->globalvar->getMain());
    }

    // start : interview 및 biz
    public function index()
    {
        $this->login();
    }

    public function login()
    {
        // data init
        $this->commonData();

        // 세션설정
        $session = session();
        if ($session->has('mem_id') && $session->get('mem_type') != 'U') {
            return redirect($this->globalvar->getMain());
        }

        // ios 구분
        $browserAgent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($browserAgent, 'iPhone') || strpos($browserAgent, 'iPad') || strpos($browserAgent, 'Macintosh')) {
            $device = 'ios';
        }
        $this->aData['data']['device'] = $device ?? '';

        $this->header();
        echo view("/auth/login", $this->aData);
        $this->footer(['quick']);
    }

    public function oAuth()
    {
        // data init
        $this->commonData();
        // 세션설정
        $session = session();
        if ($session->has('mem_id')) {
            return redirect($this->globalvar->getMain());
        }
        echo view("/auth/oAuth", $this->aData);
    }

    //특정 페이지 로드 체크
    public function pageLimitLoding($arrData = [], $pageName)
    {
        $this->aData['data']['use'][$pageName] = false;

        foreach ($arrData as $page) {
            if (strpos($this->aData['data']['page'], $page) !== false) {
                $this->aData['data']['use'][$pageName] = true;
            }
        }
    }

    public function header()
    {
        $UniversityModel = new UniversityModel();
        $aUni = $UniversityModel->getAllUniUrl();
        foreach ($aUni as $key => $val) {
            $aUni[$key] = $val['uni_url'];
        }
        $this->aData['data']['uniUrl'] = $aUni;

        if ($this->aData['data']['page'] == '/') {
            $this->aData['data']['class']['body'] = 'main';
        } else if ($this->aData['data']['page'] == '/splash') {
            //미구현
            $this->aData['data']['class']['body'] = 'splash';
        } else {
            $this->aData['data']['class']['body'] = 'sub';
        }

        $aUseLodash = ['/aaa/bbb/ccc'];
        $this->pageLimitLoding($aUseLodash, 'lodash');
        $aFileUpload = ['my/resume/modify'];
        $this->pageLimitLoding($aFileUpload, 'fileUpload');
        $aSocketIo = ['my/resume/modify'];
        $this->pageLimitLoding($aSocketIo, 'socketIo');

        echo view('www/templates/header', $this->aData);
    }

    public function footer($ignore = [])
    {
        $aConfig = [
            'private' => cache('config.private'),
            'agreement' => cache('config.agreement'),
        ];

        if (!$aConfig['private'] || !$aConfig['agreement']) {
            $strAgreement = '';
            $strPrivate = '';
            $configModel = new ConfigModel();
            $aConfig = $configModel->getConfigType('total');
            foreach ($aConfig as $val) {
                if ($val['cfg_type'] == 'A') {
                    $strAgreement = $val['cfg_content'];
                } else if ($val['cfg_type'] == 'P') {
                    $strPrivate = $val['cfg_content'];
                }
            }
            cache()->save('config.private', $strAgreement, 86400);
            cache()->save('config.agreement', $strPrivate, 86400);
            $aConfig['private'] = $strAgreement;
            $aConfig['agreement'] = $strPrivate;
        }
        $this->aData['data']['config']['agreement'] = $aConfig['agreement'];
        $this->aData['data']['config']['private'] = $aConfig['private'];

        echo view('www/templates/wrapBottom', $this->aData);
        if (!$this->aData['data']['session']['idx']) {
            //로그인 중이 아닐때
            $this->aData['data']['sns']['url']['kakao'] = 'https://kauth.kakao.com/oauth/authorize?client_id=' . $this->globalvar->aSnsInfo['kakao']['clientId'] . '&redirect_uri=' . urlencode($this->globalvar->aSnsInfo['kakao']['redirectUrl']) . '&response_type=code';
            $this->aData['data']['sns']['url']['apple'] = 'https://appleid.apple.com/auth/authorize?response_type=code&response_mode=form_post&client_id=' . $this->globalvar->aSnsInfo['apple']['clientId'] . '&redirect_uri=' . urlencode($this->globalvar->aSnsInfo['apple']['redirectUrl']) . '&scope=name%20email';
            $this->aData['data']['sns']['url']['naver'] = 'https://nid.naver.com/oauth2.0/authorize?client_id=' . $this->globalvar->aSnsInfo['naver']['clientId'] . '&response_type=code&redirect_uri=' . urlencode($this->globalvar->aSnsInfo['naver']['redirectUrl']) . '&state=RAMDOM_STATE';
            $this->aData['data']['sns']['url']['google'] = 'https://accounts.google.com/o/oauth2/v2/auth?response_type=code&client_id=' . $this->globalvar->aSnsInfo['google']['clientId'] . '&scope=profile%20email&redirect_uri=' . urlencode($this->globalvar->aSnsInfo['google']['redirectUrl']) . '&state=highbuff&nonce=1';
            echo view('www/modal/login', $this->aData);
        }
        echo view('www/modal/agreement', $this->aData);
        echo view('www/modal/privacy', $this->aData);
        if (!in_array("quick", $ignore)) {
            echo view('www/templates/quick', $this->aData);
        }
        //푸터 하단에 스크립트는 footer 작성
        echo view('www/templates/footer', $this->aData);
    }

    public function join()
    {
        // data init
        $this->commonData();
        $this->header();

        $session = session();
        $stuCode = $session->get('stuCode');
        $uniCode = $session->get('uniCode');
        $UniversityModel = new UniversityModel();

        if ($uniCode) {
            $aMajorList = $UniversityModel->getMajor($uniCode);
            $uniType = $UniversityModel->getUniType($uniCode);
            $this->aData['data']['stuCode'] = $stuCode;
            $this->aData['data']['uniCode'] = $uniCode;
            $this->aData['data']['uniType'] = $uniType['uni_type'];
            $this->aData['data']['MajorList'] = $aMajorList;
        }

        echo view("/auth/join", $this->aData);
        $this->footer(['quick']);
    }

    public function snsJoin()
    {
        // data init
        $this->commonData();
        $strCacheKey = $this->request->getGet('cacheKey');
        $encrypter = Services::encrypter();
        $cacheKey = $encrypter->decrypt(base64url_decode($strCacheKey));

        $session = session();
        $stuCode = $session->get('stuCode');
        $uniCode = $session->get('uniCode');
        $UniversityModel = new UniversityModel();

        if ($uniCode) {
            $aMajorList = $UniversityModel->getMajor($uniCode);
            $uniType = $UniversityModel->getUniType($uniCode);
            $this->aData['data']['stuCode'] = $stuCode;
            $this->aData['data']['uniCode'] = $uniCode;
            $this->aData['data']['uniType'] = $uniType['uni_type'];
            $this->aData['data']['MajorList'] = $aMajorList;
        }

        if (!$aSnsCache = cache($cacheKey)) {
            return redirect($this->globalvar->getLogin());
        }

        $strSnsProvider = substr($aSnsCache['snsType'], 0, 1);
        if ($strSnsProvider) {
            $strSnsProvider = strtoupper($strSnsProvider);
        } else {
            $strSnsProvider = 'E';
        }
        $this->aData['data']['sns']['cache']['id'] = $aSnsCache['snsType'] . '_' . $aSnsCache['mem_object_enc'];
        $this->aData['data']['sns']['cache']['snsType'] = $aSnsCache['snsType'];
        $this->aData['data']['sns']['cache']['key'] = $aSnsCache['mem_key'];
        $this->aData['data']['sns']['cache']['enc'] = $aSnsCache['mem_object_enc'];
        $this->aData['data']['sns']['cache']['provider'] = $strSnsProvider;
        $this->aData['data']['sns']['cache']['email'] = $aSnsCache['mem_email'];
        $this->aData['data']['sns']['cache']['accessToken'] = $aSnsCache['access_token'];

        $this->header();
        echo view("/auth/sns/join", $this->aData);
        $this->footer(['quick']);
    }

    public function interest($code)
    {
        if (!in_array($code, ['join', 'main'])) {
            return alert_url($this->globalvar->aMsg['error1'], $this->backUrl);
        }
        // data init
        $this->commonData();
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

        $memberRecruitCategoryModel = new MemberRecruitCategoryModel();
        $aMemberCate = $memberRecruitCategoryModel->getJoinType('M', $this->aData['data']['session']['idx']);
        if (count($aMemberCate) == 1) {
            $aMemberCate = ['0' => dot_array_search('*.job_depth_1', $aMemberCate)];
        } else {
            $aMemberCate = dot_array_search('*.job_depth_1', $aMemberCate);
        }

        $memberRecruitKorModel = new MemberRecruitKor();
        $aMemberKor = $memberRecruitKorModel->getKorArea($this->aData['data']['session']['idx']);
        if (count($aMemberKor) == 1) {
            $aMemberKor = ['0' => dot_array_search('*.area_depth_text_1', $aMemberKor)];
        } else {
            $aMemberKor = dot_array_search('*.area_depth_text_1', $aMemberKor);
        }

        $memberModel = new MemberModel();
        $aMemberInfo = $memberModel->MypageMem($this->aData['data']['session']['idx']);
        $aMemMbti = str_split($aMemberInfo['mem_mbti']);
        $aMemberPay = $aMemberInfo['mem_pay'];
        $checked = "";
        if ($aMemberPay) {
            if ($aMemberPay == "1억이상") {
                $this->aData['data']['my']['mem_pay_left'] = 24;
                $this->aData['data']['my']['mem_pay_right'] = 100;
                $checked = "checked";
            } else {
                $this->aData['data']['my']['mem_pay_left'] = substr(str_replace(',', '', explode('~', $aMemberPay)[0]), 0, 2);
                $this->aData['data']['my']['mem_pay_right'] = substr(str_replace(',', '', explode('~', $aMemberPay)[1]), 0, 2);
            }
        }

        $this->aData['data']['category'] = $aCacheJobcategory;
        $this->aData['data']['my']['category'] = $aMemberCate ?? [];
        $this->aData['data']['my']['area'] = $aMemberKor ?? [];
        $this->aData['data']['my']['payCheck'] = $checked;
        $this->aData['data']['my']['mbti'] = ['m' =>  $aMemMbti[0] ?? '', 'b' => $aMemMbti[1] ?? '', 't' => $aMemMbti[2] ?? '', 'i' => $aMemMbti[3] ?? ''];
        $this->aData['data']['area'] = $aCacheKoreaarea;
        $this->aData['data']['code'] = $code;

        $this->header();
        echo view("/auth/interest", $this->aData);
        $this->footer(['quick']);
    }

    public function snsLoginCheck($snsType, $snsEncrypt)
    {
        $strCacheKey = "sns.{$snsType}.{$snsEncrypt}";
        if (!$aSnsCache = cache($strCacheKey)) {
            return redirect($this->globalvar->getLogin());
        }

        $state = $this->request->getGet('state');
        if (!$state) {
            $state = '';
        }

        $strId = $aSnsCache['snsType'] . '_' . $aSnsCache['mem_object_enc'];
        $strPw = $aSnsCache['mem_object_enc'];
        $aParam = [
            'sns' => $snsType,
            'id' => $strId,
            'password' => $strPw,
            'state' => $state
        ];
        $encryptLib = new EncryptLib();
        $encrypter = Services::encrypter();
        $memberModel = new MemberModel();
        $aRow = $memberModel->getMember($strId);

        $strGetResultPw = dot_array_search('mem_password', $aRow);

        if ($encryptLib->checkPassword($strPw, $strGetResultPw)) {
            // 로그인 진행
            $this->loginAction($aParam);
        } else {
            // 회원가입페이지 호출
            $this->commonData();
            $this->aData['data']['type'] = 'join';
            $this->aData['data']['cacheKey'] = base64url_encode($encrypter->encrypt($strCacheKey));
            $this->aData['data']['state'] = $state;
            $this->aData['data']['snsType'] = $snsType;
            echo view("/auth/sns/toJoin", $this->aData);
        }
    }

    public function loginAction($aParam = null)
    {

        // $this->aData['data']['snsType'] = $snsType;
        $isSns = false;
        $multipleLogin = false;
        $errorMsg = '';
        if ($aParam) {
            $isSns = true;
        }

        // print_r($aParam);
        // return;
        //action page
        if ($isSns) {
            $strId = $aParam['id'];
            $strPw = $aParam['password'];
            $strState = $aParam['state'];
        } else {
            $strId = $this->request->getPost('id');
            $strPw = $this->request->getPost('password');
            $strState = '';
        }
        //init
        $aContinueColumn = ['mem_password', 'mem_token', 'mem_join_path', 'mem_reg_date', 'mem_mod_date', 'mem_del_date', 'delyn'];
        $aRow = [];
        if (!$strPw || !$strId) {
            return redirect($this->globalvar->getLogin());
        }

        $aSubDate = [
            'allowedFields' => ['log_reg_date', '', ''], // allowedFields 에 들어갈 date 정보
            'createdField' => 'log_reg_date',
            'updatedField' => '',
            'deletedField' => '',
            'jsonField' => ['', ''],
            'useSoftDeletes' => true,
        ];

        $encryptLib = new EncryptLib();
        $memberModel = new MemberModel();
        $interviewModel = new InterviewModel('log_member_login', $aSubDate);
        $aRow = $memberModel->getMember($strId);

        $aLeaveRow = $memberModel->getLeaveMember($strId); //탈퇴한 회원 확인 , sns 도 여기서 확인
        if ($aLeaveRow) { //탈퇴한 회원일 때
            alert_back($this->globalvar->aMsg['error23']);
            return;
        }

        $aFailCount = $memberModel->getFailLog($strId);

        if ($aFailCount[0]['failcount'] >= 5) { //로그인 실패 5번 이상일경우 계정 잠금
            alert_back($this->globalvar->aMsg['error21']);
            return;
        }

        $aGetLogStatus = $memberModel->getLogStatus($strId);

        $strGetResultPw = dot_array_search('mem_password', $aRow);
        if ($encryptLib->checkPassword($strPw, $strGetResultPw)) {

            if ($aGetLogStatus['login_status'] == 'login' && $aGetLogStatus['login_result'] == 'S') { //중복로그인 제어
                $sess_path = $this->globalvar->sessionPath;
                $dirlist = opendir($sess_path);
                while ($file = readdir($dirlist)) { //세션 파일 가져와서 삭제
                    if ($file != "." && $file != "..") {
                        $sline = file_get_contents($sess_path . "/" . $file);
                        $slist = explode(";", $sline);
                        foreach ($slist as $key => $val) {
                            if (preg_match('/idx/', $val)) {
                                if (!preg_match('/_/', $val)) {
                                    $aSessionIdx = explode(":", $val);
                                    $sessionMemIdx = str_replace('"', '', $aSessionIdx[2]);
                                    if ($sessionMemIdx == $aRow['idx']) {
                                        unlink($sess_path . "/" . $file);
                                    }
                                }
                            }
                        }
                    }
                }
                session()->destroy();
                $this->masterDB->table('log_member_login')
                    ->set([
                        'mem_idx' => $aRow['idx'],
                        'login_status' => 'logout',
                    ])
                    ->set('log_reg_date', 'now()', false)
                    ->insert(); //log insert -> log table
                if ($strState != 'app') { //웹일경우 alert_back
                    if (empty($aParam['sns'])) {
                        alert_back($this->globalvar->aMsg['error22']);
                    } else if ($aParam['sns'] == 'apple') {
                        alert_url($this->globalvar->aMsg['error22'], '/login');
                    } else {
                        alert_close($this->globalvar->aMsg['error22']);
                    }
                    return;
                } else { //앱일 경우 toJoin 으로 보내서 튕기게
                    $multipleLogin = true;
                    $errorMsg = $this->globalvar->aMsg['error22'];
                    if ($isSns) { //웹이든 앱이든 여기로 들어옴
                        $this->aData['data']['type'] = 'login';
                        $this->aData['data']['state'] = $strState;
                        $this->aData['data']['snsType'] = $aParam['sns'];
                        $this->aData['data']['snsId'] = $strId;
                        $this->aData['data']['multipleLogin'] = $multipleLogin;
                        $this->aData['data']['errorMsg'] = $errorMsg;
                        echo view("/auth/sns/toJoin", $this->aData);
                        return;
                    }
                }
            } else { //중복 로그인이 아니라면 세션 설정
                //세션설정
                $session = session();
                $tmpArrData = [];
                foreach ($aRow as $key => $val) {
                    if (in_array($key, $aContinueColumn)) {
                        continue;
                    }
                    $tmpArrData[$key] = $val;
                }
                $session->set($tmpArrData);
                //세션설정 끝

                //트랜잭션 start
                $this->masterDB->transBegin();

                $this->masterDB->table('iv_member')
                    ->set('mem_visit_count', 'mem_visit_count + 1', false) //log update -> member table
                    ->set('mem_visit_date', 'now()', false)
                    ->where('mem_id', $strId)
                    ->update();

                $this->masterDB->table('log_member_login')
                    ->set([
                        'mem_idx' => $session->get('idx'),
                        'login_status' => 'login',
                        'login_result' => 'S'
                    ])
                    ->set('log_reg_date', 'now()', false)
                    ->insert(); //log insert -> log table

                // 트랜잭션 end
                if ($this->masterDB->transStatus() === false) {
                    $this->masterDB->transRollback();
                    session()->destroy();
                    return alert_back($this->globalvar->aMsg['error3']);
                } else {
                    $this->masterDB->transCommit();
                    if ($isSns) { //웹이든 앱이든 sns 로그인은 여기로 들어옴
                        $this->aData['data']['type'] = 'login';
                        $this->aData['data']['state'] = $strState;
                        $this->aData['data']['snsType'] = $aParam['sns'];
                        $this->aData['data']['snsId'] = $strId;
                        $this->aData['data']['multipleLogin'] = $multipleLogin;
                        $this->aData['data']['errorMsg'] = $errorMsg;
                        echo view("/auth/sns/toJoin", $this->aData);
                        return;
                    } else {
                        if ($backUrl = $_SESSION['backLogin'] ?? false) {
                            unset($_SESSION['backLogin']);
                            echo "<script type='text/javascript'>if(navigator.userAgent.indexOf('APP_Highbuff_Android') != -1){window.interview.send_id('" . $strId . "')}</script>";
                            echo "<script type='text/javascript'>if(navigator.userAgent.indexOf('APP_Highbuff_IOS') != -1){webkit.messageHandlers.send_id.postMessage('" . $strId . "')}</script>";
                            echo "<script>location.href='/" . $backUrl . "'</script>";
                            // return redirect()->to($backUrl);
                            return;
                        }
                        echo "<script type='text/javascript'>if(navigator.userAgent.indexOf('APP_Highbuff_Android') != -1){window.interview.send_id('" . $strId . "')}</script>";
                        echo "<script type='text/javascript'>if(navigator.userAgent.indexOf('APP_Highbuff_IOS') != -1){webkit.messageHandlers.send_id.postMessage('" . $strId . "')}</script>";
                        echo "<script>location.href='/'</script>";
                        // return redirect($this->globalvar->getMain());
                        return;
                    }
                }
            }
        } else {
            //1.0 비밀번호 체크
            $aRow = $memberModel->getOldMember($strId, $strPw);
            if ($aRow) {
                if ($aGetLogStatus['login_status'] == 'login' && $aGetLogStatus['login_result'] == 'S') { //중복로그인 제어
                    $sess_path = $this->globalvar->sessionPath;
                    $dirlist = opendir($sess_path);
                    while ($file = readdir($dirlist)) {  //세션 파일 가져와서 삭제
                        if ($file != "." && $file != "..") {
                            $sline = file_get_contents($sess_path . "/" . $file);
                            $slist = explode(";", $sline);
                            foreach ($slist as $key => $val) {
                                if (preg_match('/idx/', $val)) {
                                    if (!preg_match('/_/', $val)) {
                                        $aSessionIdx = explode(":", $val);
                                        $sessionMemIdx = str_replace('"', '', $aSessionIdx[2]);
                                        if ($sessionMemIdx == $aRow['idx']) {
                                            unlink($sess_path . "/" . $file);
                                        }
                                    }
                                }
                            }
                        }
                    }

                    session()->destroy();
                    $this->masterDB->table('log_member_login')
                        ->set([
                            'mem_idx' => $aRow['idx'],
                            'login_status' => 'logout',
                        ])
                        ->set('log_reg_date', 'now()', false)
                        ->insert(); //log insert -> log table
                    if ($strState != 'app') { //웹일 경우 alert_back
                        if (empty($aParam['sns'])) {
                            alert_back($this->globalvar->aMsg['error22']);
                        } else if ($aParam['sns'] == 'apple') {
                            alert_url($this->globalvar->aMsg['error22'], '/login');
                        } else {
                            alert_close($this->globalvar->aMsg['error22']);
                        }
                        return;
                    } else { //앱일경우 toJoin으로 보내서 처리
                        $multipleLogin = true;
                        $errorMsg = $this->globalvar->aMsg['error22'];
                        if ($isSns) {
                            $this->aData['data']['type'] = 'login';
                            $this->aData['data']['state'] = $strState;
                            $this->aData['data']['snsType'] = $aParam['sns'];
                            $this->aData['data']['snsId'] = $strId;
                            $this->aData['data']['multipleLogin'] = $multipleLogin;
                            $this->aData['data']['errorMsg'] = $errorMsg;
                            echo view("/auth/sns/toJoin", $this->aData);
                            return;
                        }
                    }
                } else { //중복로그인이 아닐때 세션 설정
                    //세션설정
                    $session = session();
                    $tmpArrData = [];
                    foreach ($aRow as $key => $val) {
                        if (in_array($key, $aContinueColumn)) {
                            continue;
                        }
                        $tmpArrData[$key] = $val;
                    }
                    $session->set($tmpArrData);
                    //세션설정 끝

                    //트랜잭션 start
                    $this->masterDB->transBegin();

                    $this->masterDB->table('iv_member')
                        ->set('mem_visit_count', 'mem_visit_count + 1', false) //log update -> member table
                        ->set('mem_visit_date', 'now()', false)
                        ->where('mem_id', $strId)
                        ->update();

                    $this->masterDB->table('log_member_login')
                        ->set([
                            'mem_idx' => $session->get('idx'),
                            'login_status' => 'login',
                            'login_result' => 'S'
                        ])
                        ->set('log_reg_date', 'now()', false)
                        ->insert(); //log insert -> log table

                    // 트랜잭션 end
                    if ($this->masterDB->transStatus() === false) {
                        $this->masterDB->transRollback();
                        session()->destroy();
                        return alert_back($this->globalvar->aMsg['error3']);
                    } else {
                        $this->masterDB->transCommit();
                        if ($isSns) {
                            $this->aData['data']['type'] = 'login';
                            $this->aData['data']['state'] = $strState;
                            $this->aData['data']['snsType'] = $aParam['sns'];
                            $this->aData['data']['snsId'] = $strId;
                            $this->aData['data']['multipleLogin'] = $multipleLogin;
                            $this->aData['data']['errorMsg'] = $errorMsg;
                            echo view("/auth/sns/toJoin", $this->aData);
                            return;
                        } else {
                            if ($backUrl = $_SESSION['backLogin'] ?? false) {
                                unset($_SESSION['backLogin']);
                                echo "<script type='text/javascript'>if(navigator.userAgent.indexOf('APP_Highbuff_Android') != -1){window.interview.send_id('" . $strId . "')}</script>";
                                echo "<script type='text/javascript'>if(navigator.userAgent.indexOf('APP_Highbuff_IOS') != -1){webkit.messageHandlers.send_id.postMessage('" . $strId . "')}</script>";
                                echo "<script>location.href='/" . $backUrl . "'</script>";
                                return;
                                // return redirect()->to($backUrl);
                            }
                            echo "<script type='text/javascript'>if(navigator.userAgent.indexOf('APP_Highbuff_Android') != -1){window.interview.send_id('" . $strId . "')}</script>";
                            echo "<script type='text/javascript'>if(navigator.userAgent.indexOf('APP_Highbuff_IOS') != -1){webkit.messageHandlers.send_id.postMessage('" . $strId . "')}</script>";
                            echo "<script>location.href='/'</script>";
                            return;
                            // return redirect($this->globalvar->getMain());
                        }
                    }
                }
            }
        }
        //로그인 실패 시 
        $aMemInfo = $memberModel->getMember($strId);
        $this->masterDB->table('log_member_login')
            ->set([
                'mem_idx' => $aMemInfo['idx'],
                'login_result' => 'F',
                'login_status' => 'login'
            ])
            ->set('log_reg_date', 'now()', false)
            ->insert(); //log insert -> log table 

        alert_back($this->globalvar->aMsg['error4']);
    }

    public function joinAction($type = null)
    {
        $this->backUrl = '/login';
        $isSns = false;
        if ($type) {
            $isSns = true;
        }
        //init
        $memberModel = new MemberModel();
        if ($isSns) {
            $strKey = $this->request->getPost('loginKey');
            $strObjectSha = $this->request->getPost('loginPassword');
            $strProvider = $this->request->getPost('loginProvider');
            $strEmail = $this->request->getPost('loginEmail');
            $strAccessToken = $this->request->getPost('loginAccessToken');
            $strloginType = $this->request->getPost('loginType');
            $strAppCheck = $this->request->getPost('AppCheck');
            $strPostCase = $this->request->getPost('postCase');
            $strBackUrl = $this->request->getPost('backUrl') ?? $this->backUrl;
            if ($strPostCase != 'join_write') {
                return alert_url($this->globalvar->aMsg['error1'], $strBackUrl);
            }

            if ($memberModel->getLeaveMemberSnsKey($strKey, 'M')) { //sns 탈퇴회원인지 확인

                if ($type == 'kakao') {
                    $access_token = $strAccessToken;
                    $UNLINK_API_URL = "https://kapi.kakao.com/v1/user/unlink";
                    $opts = array(
                        CURLOPT_URL => $UNLINK_API_URL,
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_SSLVERSION => 1,
                        CURLOPT_POST => true,
                        CURLOPT_POSTFIELDS => false,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HTTPHEADER => array(
                            "Authorization: Bearer " . $access_token
                        )
                    );

                    $curlSession = curl_init();
                    curl_setopt_array($curlSession, $opts);
                    $accessUnlinkJson = curl_exec($curlSession);
                    curl_close($curlSession);
                    $unlink_responseArr = json_decode($accessUnlinkJson, true);

                    if ($unlink_responseArr['id']) {
                        alert_url($this->globalvar->aMsg['error23'], '/login'); //탈퇴한 아이디 입니다.
                        exit;
                    } else {
                        alert_back($this->globalvar->aMsg['error25']); //SNS 연동해제가 정상적으로 이루어지지 않았습니다.
                        exit;
                    }
                } else if ($type == 'naver') {
                    if ($strAppCheck == 'ios') {
                        echo '<script type="text/javascript">webkit.messageHandlers.naver_unlink.postMessage("");</script>';
                        alert_url($this->globalvar->aMsg['error23'], '/login');
                        exit;
                    } else {
                        $client_id = "xgw7omXoMTrWdMLU9cw2";
                        $client_secret = "Xd1WE28MgA";
                        $service_provider = 'NAVER';
                        $access_token = $strAccessToken;
                        $url = "https://nid.naver.com/oauth2.0/token?grant_type=delete&client_id=" . $client_id . "&client_secret=" . $client_secret . "&access_token=" . urlencode($access_token) . "&service_provider=" . $service_provider;
                        $is_post = false;

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_POST, $is_post);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $headers = array();
                        $response = curl_exec($ch);
                        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                        if ($status_code == 200) {
                            alert_url($this->globalvar->aMsg['error23'], '/login');
                            exit;
                        } else {
                            alert_back($this->globalvar->aMsg['error25']);
                            exit;
                        }
                    }
                } else if ($type == "google") {
                    if ($strAppCheck == 'Android') {
                        echo '<script type="text/javascript">window.interview.google_unlink();</script>';
                        alert_url($this->globalvar->aMsg['error23'], '/login');
                        exit;
                    } else {
                        $access_token = $strAccessToken;

                        $client = new Google_Client();
                        $revoke = $client->revokeToken($access_token);

                        if ($revoke == 1) {
                            alert_url($this->globalvar->aMsg['error23'], '/login');
                            exit;
                        } else {
                            alert_back($this->globalvar->aMsg['error25']);
                            exit;
                        }
                    }
                } else if ($type == "apple") {
                    $leaveState = $this->request->getGet('leaveState');
                    $access_token = $strAccessToken;
                    $leaveCheck = 'login';
                    $isApp = 0;
                    if ($strloginType == 'apple') {
                        $isApp = 1;
                    }

                    return redirect()->to('https://api.highbuff.com/interview/20/leave.php?isApp=' . $isApp . '&at=' . $access_token . '&leaveCheck=' . $leaveCheck);
                }
            }
        } else {
            $strTel = $this->request->getPost('loginPhone');
            if ($memberModel->getMemberTel($strTel, 'M')) {
                alert_back($this->globalvar->aMsg['error5']);
                exit;
            } else {
                if ($memberModel->getLeaveMemberTel($strTel, 'M')) { //이메일 탈퇴회원인지 확인
                    alert_back($this->globalvar->aMsg['error23']);
                    exit;
                }
            }
        }
        $strId = $this->request->getPost('loginId');
        $strPw = $this->request->getPost('loginPassword');
        $strPwAgain = $this->request->getPost('loginPasswordAgain');
        $strName = $this->request->getPost('loginName');
        $strPersonal1 = $this->request->getPost('mem_personal_type_1') ?? 'Y';
        $strPersonal2 = $this->request->getPost('mem_personal_type_2') ?? 'N';
        $iUniCode =  $this->request->getPost('uniCode') ?? '';
        $strUniType =  $this->request->getPost('uniType') ?? '';
        $strStuCode =  $this->request->getPost('stuCode') ?? '';
        $iMajor =  $this->request->getPost('major') ?? '';
        $iGrade =  $this->request->getPost('Grade') ?? '';
        $iClass =  $this->request->getPost('Class') ?? '';
        $iNumber =  $this->request->getPost('Number') ?? '';


        if (!$isSns) {
            if (!$strId || !$strPw || !$strPwAgain || !$strName) {
                alert_back($this->globalvar->aMsg['error4']);
                exit;
            }
        }
        $encryptLib = new EncryptLib();
        $strPw = $encryptLib->makePassword($strPw);

        $aSave = [
            'mem_type' =>  'M',
            'mem_id' => $strId,
            'mem_password' => $strPw,
            'mem_name' => $strName,
            'mem_personal_type_1' => $strPersonal1,
            'mem_personal_type_2' => $strPersonal2,
        ];

        if ($iUniCode) {
            if ($strUniType == "H") {
                $strStuCode = $iGrade . "/" . $iClass . "/" . $iNumber;
            }
            $aSave['mem_ex_1'] = $iUniCode;
            $aSave['mem_ex_2'] = $iMajor;
            $aSave['mem_ex_3'] = $strStuCode;
        }

        if ($isSns) {
            $aSave['mem_sns_key'] = $strKey;
            $aSave['mem_email'] = $strEmail;
            $aSave['mem_sns_object_sha'] = $strObjectSha;
            $aSave['mem_sns_provider'] = $strProvider;
        } else {
            $aSave['mem_tel'] = $strTel;
            $aSave['mem_email'] = $strId;
        }
        //action page
        foreach ($aSave as $key => $val) {
            if (empty($val)) {
                return redirect($this->globalvar->getLogin());
            }
        }

        $aRow = [];
        $aRow = $memberModel->getMember($strId);

        if ($aRow) {
            return alert_back($this->globalvar->aMsg['error5']);
        }
        $this->masterDB->transBegin();
        $this->masterDB->table('iv_member')
            ->set($aSave)
            ->set(['mem_reg_date' => 'NOW()'], '', false)
            ->set(['mem_mod_date' => 'NOW()'], '', false)
            ->set(['mem_visit_date' => 'NOW()'], '', false)
            ->set(['mem_visit_count' => '1'], '', false)
            ->insert();

        $insertMemIdx = $this->masterDB->insertID();

        $this->masterDB->table('log_member_login')
            ->set([
                'mem_idx' => $insertMemIdx,
                'login_status' => 'login',
                'login_result' => 'S'
            ])
            ->set('log_reg_date', 'now()', false)
            ->insert(); //log insert -> log table

        // 트랜잭션 end
        if ($this->masterDB->transStatus() === false) {
            $this->masterDB->transRollback();
            return alert_back($this->globalvar->aMsg['error4']);
        } else {
            $this->masterDB->transCommit();

            $aContinueColumn = ['mem_password', 'mem_token', 'mem_join_path', 'mem_reg_date', 'mem_mod_date', 'mem_del_date', 'delyn'];
            $aRow = $memberModel->getMember($strId);
            $session = session();
            $tmpArrData = [];
            foreach ($aRow as $key => $val) {
                if (in_array($key, $aContinueColumn)) {
                    continue;
                }
                $tmpArrData[$key] = $val;
            }
            $session->set($tmpArrData);
            if ($isSns) {
                echo "<script type='text/javascript'>if(navigator.userAgent.indexOf('APP_Highbuff_Android') != -1){window.interview.send_id('" . $strId . "')}</script>";
                echo "<script type='text/javascript'>if(navigator.userAgent.indexOf('APP_Highbuff_IOS') != -1){webkit.messageHandlers.send_id.postMessage('" . $strId . "')}</script>";
            }

            return alert_url($this->globalvar->aMsg['success3'], '/my/interest/join');
        }
    }

    public function interestAction(string $code)
    {
        //init
        $session = session();
        $this->backUrl = '/';

        $strMbti = '';
        $aRec = $this->request->getPost('rec');
        $aArea = $this->request->getPost('area');
        $iLeftPay = $this->request->getPost('leftPay');
        $iRightPay = $this->request->getPost('rightPay');
        $iTopPay = $this->request->getPost('topPay');
        $m = $this->request->getPost('m');
        $b = $this->request->getPost('b');
        $t = $this->request->getPost('t');
        $i = $this->request->getPost('i');
        if ($m && $b && $t && $i) {
            $strMbti = $m . $b . $t . $i;
        }
        $strPostCase = $this->request->getPost('postCase');
        $strBackUrl = $this->request->getPost('backUrl');
        $iMemIdx = $session->get('idx');
        $strMemType = $session->get('mem_type');
        $iRecMax = count($aRec);
        $iAreaMax = count($aArea);

        if (!is_numeric($iLeftPay) || !is_numeric($iRightPay) || $iLeftPay + $iRightPay > 198 || $strPostCase != 'interest_write' || $iRecMax > 4 || $iAreaMax > 4) {
            session()->destroy();
            return alert_back($this->globalvar->aMsg['error1']);
        }

        if ($iTopPay == '999') {
            $strPay = '1억이상';
        } else if ($iLeftPay > $iRightPay) {
            $strPay = number_format($iRightPay . '00') . '~' . number_format($iLeftPay . '00');
        } else {
            $strPay = number_format($iLeftPay . '00') . '~' . number_format($iRightPay . '00');
        }

        if ($code == 'join') {
            //트랜잭션 start
            $this->masterDB->transBegin();
            // insert iv_member
            $saveData = [
                'mem_pay' => $strPay,
                'mem_mbti' => $strMbti
            ];

            $this->masterDB->table('iv_member')
                ->set($saveData)
                ->set(['mem_mod_date' => 'NOW()'], '', false)
                ->where('idx', $iMemIdx)
                ->update();

            // insert iv_member_recruit_category
            $aMemRecCate = [];
            foreach ($aRec as $val) {
                $aMemRecCate[] = [
                    'mem_idx' => $iMemIdx,
                    'job_idx' => $val,
                    'mem_rec_type' => $strMemType,
                ];
            }

            if ($aMemRecCate) {
                $this->masterDB->table('iv_member_recruit_category')
                    ->insertBatch($aMemRecCate);
            }

            // insert iv_member_recruit_kor
            $aMemRecKor = [];
            foreach ($aArea as $val) {
                $aMemRecKor[] = [
                    'mem_idx' => $iMemIdx,
                    'kor_area_idx' => $val,
                    'mem_rec_type' => $strMemType,
                ];
            }

            $this->masterDB->table('iv_member_recruit_kor')
                ->insertBatch($aMemRecKor);

            // 트랜잭션 end
            if ($this->masterDB->transStatus() === false) {
                $this->masterDB->transRollback();
                return alert_url($this->globalvar->aMsg['error2'], $strBackUrl ? $strBackUrl : $this->backUrl);
            } else {
                $this->masterDB->transCommit();
                return alert_url($this->globalvar->aMsg['success3'], $this->backUrl);
            }
        } else {
            //todo
            $memberRecruitCategoryModel = new MemberRecruitCategoryModel();
            $aMemRecCate = $memberRecruitCategoryModel
                ->where([
                    'mem_idx' => $iMemIdx,
                    'delyn' => 'N'
                ])->findAll();

            $memberRecruitKorModel = new MemberRecruitKor();
            $aMemRecKor = $memberRecruitKorModel
                ->where([
                    'mem_idx' => $iMemIdx,
                    'delyn' => 'N'
                ])->findAll();

            $aMemRecCate = dot_array_search('*.job_idx', $aMemRecCate);
            $aMemRecKor = dot_array_search('*.kor_area_idx', $aMemRecKor);

            //트랜잭션 start
            $this->masterDB->transBegin();

            // iv_member_recruit_category delyn = 'Y'
            $this->masterDB->table('iv_member_recruit_category')
                ->set(['delyn' => 'Y'])
                ->where('mem_idx', $iMemIdx)
                ->update();

            // iv_member_recruit_kor delyn = 'Y'
            $this->masterDB->table('iv_member_recruit_kor')
                ->set(['delyn' => 'Y'])
                ->where('mem_idx', $iMemIdx)
                ->update();

            // insert iv_member
            $saveData = [
                'mem_pay' => $strPay,
                'mem_mbti' => $strMbti
            ];

            $this->masterDB->table('iv_member')
                ->set($saveData)
                ->set(['mem_mod_date' => 'NOW()'], '', false)
                ->where('idx', $iMemIdx)
                ->update();

            // insert iv_member_recruit_category
            $aMemRecCateInsert = [];
            foreach ($aRec as $val) {
                $aMemRecCateInsert[] = [
                    'mem_idx' => $iMemIdx,
                    'job_idx' => $val,
                    'mem_rec_type' => $strMemType,
                ];
            }

            if ($aMemRecCateInsert) {
                $this->masterDB->table('iv_member_recruit_category')
                    ->insertBatch($aMemRecCateInsert);
            }
            // insert iv_member_recruit_kor
            $aMemRecKorInsert = [];
            foreach ($aArea as $val) {
                $aMemRecKorInsert[] = [
                    'mem_idx' => $iMemIdx,
                    'kor_area_idx' => $val,
                    'mem_rec_type' => $strMemType,
                ];
            }
            if ($aMemRecKorInsert) {
                $this->masterDB->table('iv_member_recruit_kor')
                    ->insertBatch($aMemRecKorInsert);
            }


            // 트랜잭션 end
            if ($this->masterDB->transStatus() === false) {
                $this->masterDB->transRollback();
                return alert_url($this->globalvar->aMsg['error2'], $strBackUrl ? $strBackUrl : $this->backUrl);
            } else {
                $this->masterDB->transCommit();
                return alert_url($this->globalvar->aMsg['success4'], '/my/main');
            }
        }
    }

    public function find()
    {
        // data init
        $this->commonData();

        // 세션설정
        $session = session();
        if ($session->has('mem_id')) {
            return redirect()->to($this->globalvar->getWwwUrl());
        }

        echo view("/auth/find", $this->aData);
    }



    public function findId(string $type)
    {
        $this->backUrl = '/login/find';
        if (!in_array($type, ['person', 'company'])) {
            return alert_url($this->globalvar->aMsg['error1'], $this->backUrl);
            exit;
        }
        $this->commonData();
        $this->aData['data']['aData'] = [
            'type' => $type
        ];

        $this->header();
        echo view("/auth/find/id", $this->aData);
        $this->footer(['quick']);
    }

    public function findPwd(string $type)
    {
        $this->backUrl = '/login/find';
        if (!in_array($type, ['person']) && !in_array($type, ['company'])) {
            return alert_url($this->globalvar->aMsg['error1'], $this->backUrl);
            exit;
        }
        $this->commonData();
        $this->aData['data']['aData'] = [
            'type' => $type
        ];

        $this->header();
        echo view("/auth/find/password", $this->aData);
        $this->footer(['quick']);
    }

    public function reset(string $type)
    {
        $this->backUrl = '/';
        $strUserData = $this->request->getGet('data');
        if (!in_array($type, ['person']) && !in_array($type, ['company']) || !$strUserData) {
            return alert_url($this->globalvar->aMsg['error1'], $this->backUrl);
            exit;
        }
        $this->commonData();
        $encrypter = Services::encrypter();
        $aUserData = $encrypter->decrypt(base64url_decode($strUserData));
        $this->aData['data']['userData'] = json_decode($aUserData, true);

        $this->header();
        echo view("/auth/find/resetPassword", $this->aData);
    }

    public function resetAction()
    {
        $strType = $this->request->getPost('mtype');
        $strPostCase = $this->request->getPost('postCase');
        $strId = $this->request->getPost('memId');
        $strPhone = $this->request->getPost('memPhone');
        $strAuth = $this->request->getPost('auth');
        $strNewPassword = $this->request->getPost('newpassword');
        $strbackUrl = $this->request->getPost('backUrl');
        if ($strPostCase != 'reset_write' || !$strType || !$strId || !$strNewPassword || !$strAuth || !$strPhone) {
            return alert_url($this->globalvar->aMsg['error1'], $strbackUrl ? $strbackUrl : $this->backUrl);
        }

        $encryptLib = new EncryptLib();
        $encryptNewPassword = $encryptLib->makePassword($strNewPassword);

        $memberModel = new MemberModel();
        $aMemberInfo = $memberModel->getmember($strId);
        $strBeforeDate = date("Y-m-d H:i:s", strtotime("-5 minutes"));
        // getLastPasswordDate() : 라스트 패스워드 변경일의 데이터가 있을시 비밀번호 변경 불가
        $aMemRow = $memberModel->getLastPasswordDate($strId, $strBeforeDate);
        if ($aMemRow) {
            return alert_back($this->globalvar->aMsg['error6']);
        }
        $strGetResultPw = dot_array_search('mem_password', $aMemberInfo);
        if ($encryptLib->checkPassword($strNewPassword, $strGetResultPw)) {
            return alert_back($this->globalvar->aMsg['error7']);
        } else {
            $aRow = $memberModel->getOldMember($strId, $strNewPassword);
            if ($aRow) {
                return alert_back($this->globalvar->aMsg['error7']);
            }
        }

        $authTelModel = new AuthTelModel();
        $aAuthData = $authTelModel->where([
            'auth_tel' => $strPhone,
            'auth_code' => $strAuth,
            'auth_start_date >' => $strBeforeDate,
        ])->first();

        if ($aAuthData) {
            $result = $this->masterDB->table('iv_member')
                ->set(['mem_password' => $encryptNewPassword])
                ->set(['mem_last_password_date' => 'NOW()'], '', false)
                ->where(['mem_id' => $strId, 'mem_type' => $strType])
                ->update();
            if ($result) {
                return alert_url($this->globalvar->aMsg['success4'], $strbackUrl ? $strbackUrl : $this->backUrl);
            } else {
                return alert_back($this->globalvar->aMsg['error3']);
            }
        } else {
            return alert_back($this->globalvar->aMsg['error8']);
        }
    }
    // end : interview 및 biz

    // start : admin
    public function adminMain()
    {
        // 세션설정
        $session = session();
        if ($session->has('mem_id') && $session->get('mem_type') == 'M') {
            return redirect($this->globalvar->getAdminMain());
        }
        return redirect($this->globalvar->getMain());
    }
    public function adminLogin()
    {
        // data init
        $aData = $this->commonData();

        // 세션설정
        $session = session();
        if ($session->has('mem_id') && $session->get('mem_type') == 'M') {
            return redirect($this->globalvar->getAdminMain());
        }
        echo view("prime/auth/login", $this->aData);
    }


    public function adminLoginAction()
    {
        //action page
        $strId = $this->request->getPost('id');
        $strPw = $this->request->getPost('password');
        $aMemberData = [];
        if (!$strPw || !$strId) {
            return redirect($this->globalvar->getAdminLogin());
        }

        $encryptLib = new EncryptLib();
        $memberModel = new MemberModel('iv_member');
        $aMemberData = $memberModel->getMember($strId);

        $aFailCount = $memberModel->getFailLog($strId);;

        if ($aFailCount[0]['failcount'] >= 5) {
            alert_back($this->globalvar->aMsg['error21']);
            return;
        }

        $strGetResultPw = dot_array_search('mem_password', $aMemberData);
        if ($encryptLib->checkPassword($strPw, $strGetResultPw)) {

            //트랜잭션 start
            $this->masterDB->transBegin();
            $intvisiteCount = $aMemberData['mem_visit_count'] ?? 0;
            $aMemberData['mem_visit_count'] = $intvisiteCount + 1;

            $this->masterDB->table('iv_member')
                ->set(['mem_visit_count' => $aMemberData['mem_visit_count']])
                ->set(['mem_visit_date' => 'NOW()'], '', false)
                ->where(['idx' => $aMemberData['idx']])
                ->update();
            $this->masterDB->table('log_member_login')
                ->set([
                    'mem_idx' => $aMemberData['idx'],
                    'login_status' => 'login',
                    'login_result' => 'S'
                ])
                ->set(['log_reg_date' => 'NOW()'], '', false)
                ->insert();

            // 트랜잭션 end
            if ($this->masterDB->transStatus() === false) {
                $this->masterDB->transRollback();
                alert_url($this->globalvar->aMsg['error3'] . '(code:401)', $this->backUrlAdmin);
                exit;
            } else {
                $this->masterDB->transCommit();
                //세션설정
                $session = session();
                $tmpArrData = [];
                foreach ($aMemberData as $key => $val) {
                    if (in_array($key, ['mem_password', 'mem_token', 'mem_join_path', 'mem_reg_date', 'mem_mod_date', 'mem_del_date', 'delyn'])) {
                        continue;
                    }
                    $tmpArrData[$key] = $val;
                }
                $session->set($tmpArrData);
            }
            return redirect($this->globalvar->getAdminMain());
        } else {
            $aMemberData = $memberModel->getOldMember($strId, $strPw);

            if ($aMemberData) {
                //트랜잭션 start
                $this->masterDB->transBegin();
                $intvisiteCount = $aMemberData['mem_visit_count'] ?? 0;
                $aMemberData['mem_visit_count'] = $intvisiteCount + 1;

                $this->masterDB->table('iv_member')
                    ->set(['mem_visit_count' => $aMemberData['mem_visit_count']])
                    ->set(['mem_visit_date' => 'NOW()'], '', false)
                    ->where(['idx' => $aMemberData['idx']])
                    ->update();
                $this->masterDB->table('log_member_login')
                    ->set([
                        'mem_idx' => $aMemberData['idx'],
                        'login_status' => 'login',
                        'login_result' => 'S'
                    ])
                    ->set(['log_reg_date' => 'NOW()'], '', false)
                    ->insert();

                // 트랜잭션 end
                if ($this->masterDB->transStatus() === false) {
                    $this->masterDB->transRollback();
                    alert_url($this->globalvar->aMsg['error3'] . '(code:401)', $this->backUrlAdmin);
                    exit;
                } else {
                    $this->masterDB->transCommit();
                    //세션설정
                    $session = session();
                    $tmpArrData = [];
                    foreach ($aMemberData as $key => $val) {
                        if (in_array($key, ['mem_password', 'mem_token', 'mem_join_path', 'mem_reg_date', 'mem_mod_date', 'mem_del_date', 'delyn'])) {
                            continue;
                        }
                        $tmpArrData[$key] = $val;
                    }
                    $session->set($tmpArrData);
                }
                return redirect($this->globalvar->getAdminMain());
            }
        }
        //로그인 실패 시 
        $aMemInfo = $memberModel->getMember($strId);
        $this->masterDB->table('log_member_login')
            ->set([
                'mem_idx' => $aMemInfo['idx'],
                'login_result' => 'F',
                'login_status' => 'login'
            ])
            ->set('log_reg_date', 'now()', false)
            ->insert(); //log insert -> log table 

        alert_back($this->globalvar->aMsg['error4']);
        exit;
    }
    // end : admin

    public function __destruct()
    {
        session_write_close();
        $this->masterDB->close();
    }
}
