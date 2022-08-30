<?php

namespace App\Controllers\Interview\Sns\Leave;

use App\Controllers\Interview\WwwController;
use Config\Services;
use App\Models\{
    MemberModel,
};

use App\Libraries\{
    EncryptLib,
};

use Google_Client;

class SnsLeaveController extends WwwController
{
    private $backUrlList = '/';
    public function index()
    {
    }

    public function web($snsType)
    {
        if (!in_array($snsType, ['kakao', 'naver', 'google', 'apple', 'highbuff'])) {
            alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
            exit;
        }

        $encryptLib = new EncryptLib();
        $strCode = $this->request->getGet('code');
        $session = session();

        if (!$snsType) {
            if (!$strCode) {
                alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
                exit;
            }
        }

        $client = Services::curlrequest();
        $this->encrypter = Services::encrypter();
        $this->commonData();

        // 카카오
        if ($snsType == 'kakao') {
            $fields = array(
                'grant_type' => urlencode("authorization_code"),
                'client_id' => urlencode($this->globalvar->aSnsInfo['kakao']['clientId']),
                'redirect_uri' => urlencode('https://' . $_SERVER["HTTP_HOST"] . '/sns/kakao/web/leave'),
                'code' => urlencode($strCode)
            );

            $fields_string = "";
            foreach ($fields as $key => $value) {
                $fields_string .= $key . '=' . $value . '&';
            }
            rtrim($fields_string, '&');

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://kauth.kakao.com/oauth/token');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($status_code == 200) {
                $json = json_decode($result);
                $access_token = $json->access_token;
                $enAccessToken = base64url_encode($this->encrypter->encrypt(json_encode($access_token)));

                // 각 SNS마다 적어줘야함
                $this->aData['data']['type'] = 'leave';
                $this->aData['data']['state'] = '';
                $this->aData['data']['snsType'] = $snsType;
                $this->aData['data']['token'] = $enAccessToken;

                cache()->save('is_leaveMemIdx_' . $session->get('idx'), 'Y', 600);
                cache()->save('sns_leave_token_' . $session->get('idx'), $access_token, 600);
                echo view("/auth/sns/toLeave", $this->aData);
            } else {
                alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
                exit;
            }
        }
        // 네이버
        else if ($snsType == 'naver') {
            $responseToken = $client->request('POST', 'https://nid.naver.com/oauth2.0/token', [
                'form_params' => [
                    'grant_type' => "authorization_code",
                    'client_id' => $this->globalvar->aSnsInfo['naver']['clientId'],
                    'client_secret' => 'Xd1WE28MgA',
                    'code' => $strCode,
                    'state' => 'asdf'
                ],
            ]);

            if ($responseToken->getStatusCode() == 200) {
                $aGetToken = json_decode($responseToken->getBody(), true);
                $access_token = $aGetToken["access_token"];

                // 각 SNS마다 적어줘야함
                $this->aData['data']['type'] = 'leave';
                $this->aData['data']['state'] = '';
                $this->aData['data']['snsType'] = $snsType;

                cache()->save('is_leaveMemIdx_' . $session->get('idx'), 'Y', 600);
                cache()->save('sns_leave_token_' . $session->get('idx'), $access_token, 600);
                echo view("/auth/sns/toLeave", $this->aData);
            } else {
                alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
                exit;
            }
        }
        // 구글
        else if ($snsType == 'google') {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://oauth2.googleapis.com/token");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: aapplication/x-www-form-urlencoded'));
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'code=' . $strCode . '&client_id=' . $this->globalvar->aSnsInfo['google']['clientId'] . '&client_secret=' . $this->globalvar->aSnsInfo['google']['clientSecret'] . '&redirect_uri=' . 'https://' . $_SERVER["HTTP_HOST"] . '/sns/google/web/leave' . '&grant_type=authorization_code');

            $result = curl_exec($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($status_code == 200) {
                $json = json_decode($result);
                $access_token = $json->access_token;

                // 각 SNS마다 적어줘야함
                $this->aData['data']['type'] = 'leave';
                $this->aData['data']['state'] = '';
                $this->aData['data']['snsType'] = $snsType;

                cache()->save('is_leaveMemIdx_' . $session->get('idx'), 'Y', 600);
                cache()->save('sns_leave_token_' . $session->get('idx'), $access_token, 600);
                echo view("/auth/sns/toLeave", $this->aData);
            } else {
                alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
                exit;
            }
        }
        // 애플
        else if ($snsType == 'apple') {
            $access_token = $this->request->getGet('at');
            $isApp = $this->request->getGet('app');
            $check = $this->request->getGet('check');

            if ($access_token) {
                // 각 SNS마다 적어줘야함
                $this->aData['data']['type'] = 'leave';
                $this->aData['data']['state'] = '';
                $this->aData['data']['snsType'] = $snsType;

                cache()->save('is_leaveMemIdx_' . $session->get('idx'), 'Y', 600);
                cache()->save('sns_leave_token_' . $session->get('idx'), $access_token, 600);
                if ($isApp == 1) {
                    cache()->save('sns_leave_isApp_' . $session->get('idx'), $isApp, 600);
                }
                
                return redirect()->to('/my/leave/step2');
            } else {
                alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
                exit;
            }
        } else {
            alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
            exit;
        }
        //window.close(); 창닫은후 종료
        exit;
    }

    public function webLeave($snsType)
    {
        if (!in_array($snsType, ['kakao', 'naver', 'google', 'apple', 'highbuff'])) {
            alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
            exit;
        }

        $session = session();
        $this->commonData();
        $this->header();
        $cache = \Config\Services::cache();
        $leaveCheck = $this->request->getGet('leaveCheck');
        if ($leaveCheck != 'login') {
            if (!$cache->get('sns_leave_token_' . $session->get('idx'))) {
                alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
                exit;
            }
        }


        if ($snsType == 'kakao') {
            $access_token = $cache->get('sns_leave_token_' . $session->get('idx'));
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
                cache()->delete('sns_leave_token_' . $session->get('idx'));
                session()->destroy();
                echo view("www/member/leave/step3", $this->aData);
            } else {
                cache()->delete('sns_leave_token_' . $session->get('idx'));
                alert_url($this->globalvar->aMsg['error20'], $this->backUrlList);
                exit;
            }
        } else if ($snsType == 'naver') {
            $client_id = "xgw7omXoMTrWdMLU9cw2";
            $client_secret = "Xd1WE28MgA";
            $service_provider = 'NAVER';
            $access_token = $cache->get('sns_leave_token_' . $session->get('idx'));
            $url = "https://nid.naver.com/oauth2.0/token?grant_type=delete&client_id=" . $client_id . "&client_secret=" . $client_secret . "&access_token=" . urlencode($access_token) . "&service_provider=" . $service_provider;
            $is_post = false;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, $is_post);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $headers = array();
            $response = curl_exec($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($status_code == 200) {
                cache()->delete('sns_leave_token_' . $session->get('idx'));
                session()->destroy();
                echo view("www/member/leave/step3", $this->aData);
            } else {
                // echo "Error 내용:" . $response;
                cache()->delete('sns_leave_token_' . $session->get('idx'));
                alert_url($this->globalvar->aMsg['error20'], $this->backUrlList);
                exit;
            }
            return;
        } else if ($snsType == 'google') {
            $access_token = $cache->get('sns_leave_token_' . $session->get('idx'));

            $client = new Google_Client();
            $revoke = $client->revokeToken($access_token);

            if ($revoke == 1) {
                cache()->delete('sns_leave_token_' . $session->get('idx'));
                session()->destroy();
                echo view("www/member/leave/step3", $this->aData);
            } else {
                // cache()->delete('sns_leave_token_' . $session->get('idx'));
                // alert_url($this->globalvar->aMsg['error20'], $this->backUrlList);
                // exit;
                cache()->delete('sns_leave_token_' . $session->get('idx'));
                session()->destroy();
                echo view("www/member/leave/step3", $this->aData);
            }
        } else if ($snsType == 'apple') {
            $leaveState = $this->request->getGet('leaveState');
            $leaveCheck = $this->request->getGet('leaveCheck');
            $isApp = $this->request->getGet('isApp');
            if ($leaveState == 'revoke') {
                cache()->delete('sns_leave_token_' . $session->get('idx'));
                session()->destroy();
                if ($leaveCheck == 'login') {
                    alert_url($this->globalvar->aMsg['error23'], $this->globalvar->getWwwUrl().'/login');

                    exit;
                } else {
                    echo view("www/member/leave/step3", $this->aData);
                }
            } else {
                $access_token = $cache->get('sns_leave_token_' . $session->get('idx'));
                $isApp = $cache->get('sns_leave_isApp_' . $session->get('idx'));

                return redirect()->to('https://api.highbuff.com/interview/20/leave.php?isApp=' . $isApp . '&at=' . $access_token);
            }
        } else {
            cache()->delete('sns_leave_token_' . $session->get('idx'));
            alert_url($this->globalvar->aMsg['error20'], $this->backUrlList);
            exit;
        }
        $this->footer(['quick']);
    }

    public function app($snsType)
    {
        if (!in_array($snsType, ['kakao', 'naver', 'google', 'apple', 'highbuff'])) {
            alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
            exit;
        }

        $access_token = $this->request->getGet('user_key');

        if (in_array($snsType, ['kakao', 'naver', 'highbuff'])) {
            if (!$access_token) {
                alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
                exit;
            }
        }

        $session = session();
        $this->aData['data']['type'] = 'leave';
        $this->aData['data']['state'] = 'app';
        $this->aData['data']['snsType'] = $snsType;

        cache()->save('is_leaveMemIdx_' . $session->get('idx'), 'Y', 600);
        cache()->save('sns_leave_token_' . $session->get('idx'), $access_token, 600);
        echo view("/auth/sns/toLeave", $this->aData);
    }
}
