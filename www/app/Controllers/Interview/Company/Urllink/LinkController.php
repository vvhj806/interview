<?php

namespace App\Controllers\Interview\Company\Urllink;

use App\Controllers\Interview\WwwController;

use App\Models\{
    CompanySuggestApplicantModel,
    CompanySuggestModel,
    MemberModel,
    ConfigAgainRequestModel,
};

use App\Libraries\{SendLib, EncryptLib};
use Config\Services;

class LinkController extends WwwController
{
    private $backUrlList = '/';

    // 문자로 링크전송
    public function index()
    {
        $this->commonData();

        $kakao = $this->request->getGet('kakao');
        $link = $this->request->getGet('link');
        $gs = $this->request->getGet('gs');
        $sendLib = new SendLib();
        $encryptLib = new EncryptLib();
        echo $kakao;

        // 2.0 코드에 맞게 바꿔야함
        if ($kakao) {
            $key = substr($kakao, 0, 8);
            $data = substr($kakao, 8);
            $data = str_replace(" ", "+", $data);

            if ($key == "" || $data == "") {
                //alert_url 
                return;
            }

            $method = "aes-256-cbc";
            $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
            $hash_key = substr(hash('sha256', $key, true), 0, 32);
            $decrypted_data = explode("||#", openssl_decrypt(base64_decode($data), $method, $hash_key, OPENSSL_RAW_DATA, $iv)); //0:사용자인덱스, 1:템플릿코드

            $idx = $decrypted_data[0];
            $code = $decrypted_data[1];

            echo $idx . '<br>';

            //$idx = 1959;
            // echo $idx . '<br>';

            $companySuggestApplicantModel = new CompanySuggestApplicantModel();
            $companySuggestModel = new CompanySuggestModel();

            $url = "https://api.highbuff.com/interview/20/link_applicant.php";

            $post_data = array(
                'type' => 'start',
                'ap_idx' => $idx
            );


            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);

            $data_result = json_decode($result);
            $last_app_idx = $data_result->ap_idx;
            echo $last_app_idx;

            $post_data2 = array(
                'type' => 'apupdate',
                'ap_idx' => $last_app_idx,
                'old_ap_idx' => $idx
            );

            $ch2 = curl_init($url);
            curl_setopt($ch2, CURLOPT_POSTFIELDS, $post_data2);
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch2);
            curl_close($ch2);

            $applicantInfo = $companySuggestApplicantModel->getApplicantInfo($last_app_idx)->first();

            print_r($applicantInfo);
            echo '<br>';

            $getSuggestInfo = $companySuggestModel->getSuggestInfo($applicantInfo['sug_idx'])->first();

            if (!$getSuggestInfo) {
                //정보가 없습니다 alert url 처리해주기
                echo '정보가 없습니다.';
                return;
            }

            print_r($getSuggestInfo);
            echo '<br>';

            $inter_name = $applicantInfo['sug_app_title'];  //인터뷰제목
            if ($gs == 'm') {
                //트랜잭션 start
                $this->masterDB->transBegin();

                $this->masterDB->table('iv_company_suggest_applicant')
                    ->set('gs_ck', 'Y') //log update -> member table
                    ->where('idx', $last_app_idx)
                    ->update();

                // 트랜잭션 end
                if ($this->masterDB->transStatus() === false) {
                    $this->masterDB->transRollback();

                    //   return alert_back($this->globalvar->aMsg['error3']);
                } else {
                    $this->masterDB->transCommit();
                }
                $applicant_phone = $getSuggestInfo['sug_manager_tel'];
            } else {
                $applicant_phone = $applicantInfo['sug_app_phone']; //지원자 전화번호
            }
            $comIdx = $getSuggestInfo['com_idx'];   //회사 idx
            $comName = $getSuggestInfo['com_name'];    //회사명
            $managerName = $getSuggestInfo['sug_manager_name'];
            $managerTel = $getSuggestInfo['sug_manager_tel'];

            $startDate = $getSuggestInfo['sug_start_date'];
            $sDate1 = date_create($startDate);
            $newStartDate = date_format($sDate1, "Y.m.d");

            $endDate = $getSuggestInfo['sug_end_date'];
            $eDate2 = date_create($endDate);
            $newEndDate = date_format($eDate2, "Y.m.d");

            $startTime = $getSuggestInfo['sug_start_time'];
            $sTime1 = date_create($startTime);
            $newStartTime = date_format($sTime1, "H:i");

            $endTime = $getSuggestInfo['sug_end_time'];
            $eTime2 = date_create($endTime);
            $newEndTime = date_format($eTime2, "H:i");

            $encrypt_data = $encryptLib->setEncrypt($last_app_idx, "bluevisorencrypt");
            $url = $this->generateDynamicLink($encrypt_data);

            echo $encrypt_data;
            echo '<br>';
            echo $url;
            echo '<br>';

            // return;

            //$strMsg = "HIGHBUFF Interview 응시 안내\n\n안녕하세요!\n\n" . "[" . $comName . "] " . $inter_name . " 부문에 서류전형에 합격하셨습니다.\n\n" . $newStartDate . ' ' . $newStartTime . " ~ " . $newEndDate . ' ' . $newStartTime . "까지 비대면 인공지능 면접을 진행해주시기 바랍니다.\n\n본 면접과 관련하여 문의사항이 있으시면 아래 담당자 정보로 부탁드리겠습니다.\n\n문의 : " . $managerName . " " . $managerTel . "\n\n면접 시작 : " . $url;
            $strMsg = "HIGHBUFF Interview 인터뷰 제안 안내\n\n인터뷰 제안이 도착해 안내드립니다.\n답변기한 : " . $newStartDate . " " . $newStartTime . " ~ " . $newEndDate . " " . $newEndTime . "\n기업명 : " . $comName . "\n채용공고 : " . $inter_name . "\n\n본 인터뷰와 관련하여 문의사항이 있으시면 아래 담당자 정보로 부탁드리겠습니다.\n문의 : " . $managerName . "  " . $managerTel . "\n\n인터뷰 시작 : " . $url . "\n\n해당 메세지는 고객님께서 입사지원 또는 공개한 인터뷰가 있는 경우에 발송됩니다.\n인터뷰 요청을 받고 싶지 않을 경우 해당 인터뷰를 비공개 처리하거나 하이버프 인터뷰 고객센터로 문의해주세요.\n고객센터 : 1855-4549";

            // echo $strMsg;
            $smsResult = $sendLib->sendSMS($applicant_phone, $strMsg);
            if ($smsResult) {
                echo '문자 전송이 완료되었습니다.';
            } else {
                echo '문자 전송 실패';
            }
        }

        return;

        $this->header();
        echo view("www/link/link", $this->aData);
    }

    // 지원자 정보를 담고있는 화면
    public function link($idx)
    {
        $this->commonData();

        $encryptLib = new EncryptLib();
        $decrypt_data = $encryptLib->setDecrypt($idx, "bluevisorencrypt");
        if (!$decrypt_data) {
            return;
        }

        // print_r($decrypt_data);

        //암호화
        $this->encrypter = Services::encrypter();
        $enAppIdx = base64url_encode($this->encrypter->encrypt($decrypt_data));

        $companySuggestApplicantModel = new CompanySuggestApplicantModel();
        $companySuggestModel = new CompanySuggestModel();
        $configAgainRequestModel = new ConfigAgainRequestModel();
        $memberModel = new MemberModel();

        $applicantInfo = $companySuggestApplicantModel->getApplicantInfo($decrypt_data)->first();


        $getSuggestInfo = $companySuggestModel->getSuggestInfo($applicantInfo['sug_idx'])->first();

        // iv_company_suggest_applicant 테이블에 app_idx가 있는지 체크
        $checkAppApplier = $companySuggestApplicantModel->checkAppApplier($decrypt_data)->first();
        $checkAppApplierStat = $companySuggestApplicantModel->checkAppApplierStat($decrypt_data)->first();

        // iv_applier idx
        $applierIdx = $checkAppApplier['app_idx'] ?? [];
        if ($applierIdx) {
            $enApplierIdx = base64url_encode($this->encrypter->encrypt($applierIdx));
        }

        // 응시기한 '-' 추가하기
        $endDate = $getSuggestInfo['sug_end_date'];
        $dateY = substr($endDate, 0, 4);
        $dateM = substr($endDate, 4, 2);
        $dateD = substr($endDate, 6, 2);
        $endDate = $dateY . '-' . $dateM . '-' . $dateD;

        // 응시여부 (닐짜)
        $today = date("Y-m-d H:i:s");
        $str_now = strtotime($today);
        //$str_target = strtotime($getSuggestInfo['sug_end_date']);
        $eTime = date_create($getSuggestInfo['sug_end_time']);
        $endTime = date_format($eTime, "H:i");
        $endDataTime = $endDate . ' ' . $endTime;
        $str_target = strtotime($endDataTime);

        if ($str_now >= $str_target) {
            $applyWhether = 'N';
        } else {
            $applyWhether = 'Y';
        }

        // 재응시여부 체크 (config_again_request 테이블에 값이 있으면 - ag_req_com이 P인 값)
        $againRequest = $configAgainRequestModel->againRequest($decrypt_data)->first();

        $isMemberCheck = $memberModel->getMemberLink("temp_{$decrypt_data}");
        if ($isMemberCheck) {
            $tempId = $isMemberCheck['mem_id'];
            $tempType = $isMemberCheck['mem_personal_type_1'];
            $tempInt = 1;
        } else {
            $tempId = "temp_{$decrypt_data}_{$enAppIdx}";
        }

        $this->aData['data']['applicantInfo'] = $applicantInfo;
        $this->aData['data']['getSuggestInfo'] = $getSuggestInfo;
        $this->aData['data']['memId'] = $tempId;
        $this->aData['data']['memName'] = $applicantInfo['sug_app_name'];
        $this->aData['data']['enAppIdx'] = $enAppIdx;
        $this->aData['data']['checkAppApplier'] = $checkAppApplier;
        $this->aData['data']['checkAppApplierStat'] = $checkAppApplierStat;
        $this->aData['data']['enApplierIdx'] = $enApplierIdx ?? '';
        $this->aData['data']['applyWhether'] = $applyWhether;
        $this->aData['data']['endDate'] = $endDataTime;
        $this->aData['data']['againRequest'] = $againRequest;
        $this->aData['data']['checkPersonal'] = $tempType ?? '';
        $this->aData['data']['checkPersonalInt'] = $tempInt ?? '';

        $this->header();
        echo view("www/link/link", $this->aData);
        echo view('www/modal/agreement', $this->aData);
        echo view('www/modal/privacy', $this->aData);
        // $this->footer(['quick']);
    }

    public function linkAction()
    {
        $this->commonData();
        $memId = $this->request->getPost('memId');
        $memName = $this->request->getPost('memName');
        $memTel = $this->request->getPost('memTel');
        $enAppIdx = $this->request->getPost('enAppIdx');
        $memPersonalAgree = $this->request->getPost('mem_personal_agree');

        // 복호화
        $memberModel = new MemberModel();
        $encryptLib = new EncryptLib();
        $this->encrypter = Services::encrypter();
        $deAppIdx = $this->encrypter->decrypt(base64url_decode($enAppIdx));
        $aContinueColumn = ['mem_password', 'mem_token', 'mem_join_path', 'mem_reg_date', 'mem_mod_date', 'mem_del_date', 'delyn'];

        // 1.iv_member에 $memId가 있는지 없는지 체크
        $isMemberCheck = $memberModel->getMember($memId);

        // 2. 없다면 member로 INSERT
        if (!$isMemberCheck) {
            if (strpos($memId, 'temp_') !== false) {
                $mm_pwd = '$2y$12$P22mcIarkYB5apFgyubPx.nLfHAsPCR4j4OsT.rDOdGEDeS.1zUsi';
            } else {
                $mm_pwd = $memId;
            }
            $this->masterDB->table('iv_member')
                ->set([
                    'mem_type' => 'U',
                    'mem_id' => $memId,
                    'mem_password' => $mm_pwd,
                    'mem_name' => $memName,
                    'mem_tel' => $memTel,
                    'mem_personal_type_1' => $memPersonalAgree
                ])
                ->set(['mem_reg_date' => 'NOW()'], '', false)
                ->insert();
            $iMemIdx = $this->masterDB->insertID();

            // INSERT가 잘되었다면 세션 생성
            if ($iMemIdx) {
                // session()->destroy();   //모든세션해제
                $session = session();
                $isMemberCheck = $memberModel->getMember($memId);
                $tmpArrData = [];
                foreach ($isMemberCheck as $key => $val) {
                    if (in_array($key, $aContinueColumn)) {
                        continue;
                    }
                    $tmpArrData[$key] = $val;
                }
                $session->set($tmpArrData);
                $memIdx = $iMemIdx;
            } else {
                alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
                exit;
            }
        } else { // 2-1. 있다면 member 정보 session에 담기
            $session = session();

            $tmpArrData = [];
            foreach ($isMemberCheck as $key => $val) {
                if (in_array($key, $aContinueColumn)) {
                    continue;
                }
                $tmpArrData[$key] = $val;
            }
            $session->set($tmpArrData);
            // print_r(1);
            // print_r($tmpArrData);
            $memIdx = $isMemberCheck['idx'];
        }
        $_SESSION['tempBack'] = $encryptLib->setEncrypt($deAppIdx, 'bluevisorencrypt');

        // 로그 남기기 (나중에 주석 제거)
        $this->masterDB->table('log_member_login')
            ->set([
                'mem_idx' => $memIdx,
                'login_status' => 'login',
                'login_result' => 'S'
            ])
            ->set('log_reg_date', 'now()', false)
            ->insert(); //log insert -> log table

        // 3. 인터뷰보는 페이지로 이동시키기


        return redirect()->to('/interview/ready?sug=' . $enAppIdx . '&opf=');
    }

    public function urlRedirect()
    {
        $this->commonData();

        $kakao = $this->request->getGet('kakao');

        if (!$kakao) {
            echo '잘못된 접근입니다.';
            alert_url($this->globalvar->aMsg['error1'], '/');
        }

        return redirect()->to('linkInterview?kakao=' . $kakao);
    }

    // --------------------------------------------------------------------

    public function generateDynamicLink($link)
    {
        $api_key = "AIzaSyD5Vl719H0krVaaFSkhbQ8QoSupiUue1nU";
        $header_data = array("Content-Type:application/json");
        if ($this->globalvar->getServerHost() == 'test') {
            $post_data = array(
                'dynamicLinkInfo' => array(
                    'domainUriPrefix' => 'https://highbuffinterview.page.link',
                    'link' => 'https://localinterviewr.highbuff.com/linkInterview/' . $link,
                    'androidInfo' => array(
                        'androidPackageName' => 'com.highbuff.iss',
                        'androidFallbackLink' => 'https://interview.highbuff.com/link.php?apply=' . $link
                    ),
                    'iosInfo' => array(
                        'iosBundleId' => 'com.bluevisor.interview',
                        'iosCustomScheme' => 'highbuffinterview',
                        'iosIpadBundleId' => 'com.bluevisor.interview'
                    )
                )
            );
        } else if ($this->globalvar->getServerHost() == 'webtest') {
            $post_data = array(
                'dynamicLinkInfo' => array(
                    'domainUriPrefix' => 'https://highbuffinterview.page.link',
                    'link' => 'https://webtestinterviewr.highbuff.com/linkInterview/' . $link,
                    'androidInfo' => array(
                        'androidPackageName' => 'com.highbuff.iss',
                        'androidFallbackLink' => 'https://webtestinterviewr.com/linkInterview/' . $link
                    ),
                    'iosInfo' => array(
                        'iosBundleId' => 'com.bluevisor.interview',
                        'iosCustomScheme' => 'highbuffinterview',
                        'iosIpadBundleId' => 'com.bluevisor.interview'
                    )
                )
            );
        } else if ($this->globalvar->getServerHost() == 'real') {
            $post_data = array(
                'dynamicLinkInfo' => array(
                    'domainUriPrefix' => 'https://highbuffinterview.page.link',
                    'link' => 'https://interview.highbuff.com/linkInterview/' . $link,
                    'androidInfo' => array(
                        'androidPackageName' => 'com.highbuff.iss',
                        'androidFallbackLink' => 'https://interview.highbuff.com/linkInterview/' . $link
                    ),
                    'iosInfo' => array(
                        'iosBundleId' => 'com.bluevisor.interview',
                        'iosCustomScheme' => 'highbuffinterview',
                        'iosIpadBundleId' => 'com.bluevisor.interview'
                    )
                )
            );
        }

        $url = "https://firebasedynamiclinks.googleapis.com/v1/shortLinks?key=" . $api_key;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data, true));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($result, true);
        usleep(500000); //1초에 5건이상 발생시 api에서 429 에러 발생하여 0.5초 딜레이
        //print_r($json);
        return $json["shortLink"];
    }

    public function url_reload()
    {
        $encryptLib = new EncryptLib();
        $index = $this->request->getGet('index');
        $decrypt_data = $encryptLib->setDecrypt($index, "bluevisorencrypt");
        $v = $this->request->getGet('v'); //igg 비즈 구버전에서 던져주는값
        if (isset($v) && $v != '') { // igg v값이 있다면 1.5 AI리포트 페이지로 이동
            $url = "https://api.highbuff.com/interview/20/link_applicant.php";
            $post_data = array(
                'type' => 'reload2',
                'ap_idx' => $decrypt_data
            );

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            echo $result;
            $data_result = json_decode($result);

            return redirect("https://realinterviewr.highbuff.com/company/itv_view.php?index=" + $data_result->encrpt_ap_idx);
        }
        //////////////////

        $url = "https://api.highbuff.com/interview/20/link_applicant.php";
        $post_data = array(
            'type' => 'reload',
            'ap_idx' => $decrypt_data
        );

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        echo $result;
        $data_result = json_decode($result);
        //echo $data_result->mem_id;

        $memberModel = new MemberModel();
        $isMemberCheck = $memberModel->getMember($data_result->mem_id);
        $aContinueColumn = ['mem_password', 'mem_token', 'mem_join_path', 'mem_reg_date', 'mem_mod_date', 'mem_del_date', 'delyn'];
        if (substr($data_result->mem_id, 0, 5) === "temp_") {
            if ($isMemberCheck) {

                $session = session();

                $tmpArrData = [];
                foreach ($isMemberCheck as $key => $val) {
                    if (in_array($key, $aContinueColumn)) {
                        continue;
                    }
                    $tmpArrData[$key] = $val;
                }
                $session->set($tmpArrData);
            }
            $session->get('mem_id');
        }
        //echo $session->get('mem_type');
        return redirect()->to($data_result->report_url);
    }


    public function schoolLink()
    {
        $this->commonData();

        $memIdx = $this->request->getGet('midx');
        $appIdx = $this->request->getGet('aidx');

        if (!$memIdx || !$appIdx) {
            return alert_url('잘못된 접근입니다.', '/');
        }

        //암호화
        $this->encrypter = Services::encrypter();
        $encodeData = base64url_encode($this->encrypter->encrypt(json_encode($appIdx)));

        // return;
        return redirect()->to('/report/detail2/' . $encodeData . '?gs=m');

        /*
        $MemberModel = new MemberModel();
        $session = session();

        $aContinueColumn = ['mem_password', 'mem_token', 'mem_join_path', 'mem_reg_date', 'mem_mod_date', 'mem_del_date', 'delyn'];
        $aRow = [];
        $aRow = $MemberModel->getMember2($memIdx);
        $tmpArrData = [];
        if ($aRow) {
            foreach ($aRow as $key => $val) {
                if (in_array($key, $aContinueColumn)) {
                    continue;
                }
                $tmpArrData[$key] = $val;
            }
            $session->set($tmpArrData);

            //트랜잭션 start
            $this->masterDB->transBegin();

            $this->masterDB->table('iv_member')
                ->set('mem_visit_count', 'mem_visit_count + 1', false) //log update -> member table
                ->set('mem_visit_date', 'now()', false)
                ->where('idx', $memIdx)
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
                //암호화
                $this->encrypter = Services::encrypter();
                $encodeData = base64url_encode($this->encrypter->encrypt(json_encode($appIdx)));
                print_r($tmpArrData);
                // return;
                return redirect()->to('/report/detail/' . $encodeData);
            }
        } else {
            return alert_url($this->globalvar->aMsg['error1'], '/');
        }
        */
    }
}
