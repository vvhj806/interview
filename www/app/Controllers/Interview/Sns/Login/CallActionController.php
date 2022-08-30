<?php

namespace App\Controllers\Interview\Sns\Login;

use App\Controllers\Interview\WwwController;
use Config\Services;
use App\Models\{
    MemberModel,
};

use App\Libraries\{
    EncryptLib,
};

use Google_Client;

class CallActionController extends WwwController
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
        // print_r($strCode);
        if (!$strCode) {
            //todo telegram
            alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
            exit;
        }

        $client = Services::curlrequest();

        // 카카오
        if ($snsType == 'kakao') {
            $responseToken = $client->request('POST', 'https://kauth.kakao.com/oauth/token', [
                'form_params' => [
                    'grant_type' => "authorization_code",
                    'client_id' => $this->globalvar->aSnsInfo['kakao']['clientId'],
                    'redirect_uri' => $this->globalvar->aSnsInfo['kakao']['redirectUrl'],
                    'code' => $strCode
                ],
            ]);

            if ($responseToken->getStatusCode() == 200) {
                $aGetToken = json_decode($responseToken->getBody(), true);

                $responseUser = $client->request('POST', 'https://kapi.kakao.com/v2/user/me', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $aGetToken["access_token"]
                    ],
                ]);

                if ($responseUser->getStatusCode() == 200) {
                    //로그인
                    $aGetUser = json_decode($responseUser->getBody(), true);
                    $strMemKey = $aGetUser['id'];
                    $strObjectEncrayt = $encryptLib->getSha1($strMemKey);
                    $cacheKey = 'sns.' . $snsType . '.' . $strObjectEncrayt;
                    cache()->save($cacheKey, [
                        'snsType' => $snsType,
                        'mem_key' => $strMemKey,
                        'mem_email' => $aGetUser['kakao_account']['email'],
                        'mem_object_enc' => $strObjectEncrayt,
                        'access_token' => $aGetToken["access_token"],
                    ], 300);
                    return redirect()->to("/login/sns/action/{$snsType}/{$strObjectEncrayt}");
                } else {
                    alert_url($this->globalvar->aMsg['error15'], $this->backUrlList);
                }
            } else {
                //todo 에러로그 쌓아야함
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

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://openapi.naver.com/v1/nid/me");
                curl_setopt($ch, CURLOPT_POST, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $header = "Bearer " . $aGetToken["access_token"]; // Bearer 다음에 공백 추가
                $headers = array();
                $headers[] = "Authorization: " . $header;
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $result = curl_exec($ch);
                $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                if ($status_code == 200) {
                    $json = json_decode($result);
                    $strMemKey = $json->response->id;
                    $strObjectEncrayt = $encryptLib->getSha1($strMemKey);
                    $cacheKey = 'sns.' . $snsType . '.' . $strObjectEncrayt;
                    cache()->save($cacheKey, [
                        'snsType' => $snsType,
                        'mem_key' => $strMemKey,
                        'mem_email' => $json->response->email,
                        'mem_object_enc' => $strObjectEncrayt,
                        'access_token' => $aGetToken["access_token"],
                    ], 300);
                    return redirect()->to("/login/sns/action/{$snsType}/{$strObjectEncrayt}");
                } else {
                    alert_url($this->globalvar->aMsg['error15'], $this->backUrlList);
                }
            } else {
                //todo 에러로그 쌓아야함
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
            curl_setopt($ch, CURLOPT_POSTFIELDS, 'code=' . $strCode . '&client_id=' . $this->globalvar->aSnsInfo['google']['clientId'] . '&client_secret=' . $this->globalvar->aSnsInfo['google']['clientSecret'] . '&redirect_uri=' . $this->globalvar->aSnsInfo['google']['redirectUrl'] . '&grant_type=authorization_code');

            $result = curl_exec($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($status_code == 200) {
                $json = json_decode($result);
                $idtoken =  $json->id_token;
                $client = new Google_Client();
                $payload = $client->verifyIdToken($idtoken);

                $strMemKey = $payload['sub'];
                $strObjectEncrayt = $encryptLib->getSha1($strMemKey);
                $cacheKey = 'sns.' . $snsType . '.' . $strObjectEncrayt;
                $email = $payload['email'];

                // $strMemKey = $email;
                $strObjectEncrayt = $encryptLib->getSha1($strMemKey);
                $cacheKey = 'sns.' . $snsType . '.' . $strObjectEncrayt;
                cache()->save($cacheKey, [
                    'snsType' => $snsType,
                    'mem_key' => $strMemKey,
                    'mem_email' => $email,
                    'mem_object_enc' => $strObjectEncrayt,
                    'access_token' => $json->access_token,
                ], 300);
                return redirect()->to("/login/sns/action/{$snsType}/{$strObjectEncrayt}");
            } else {
                alert_url($this->globalvar->aMsg['error15'], $this->backUrlList);
            }
        }

        // 애플
        else if ($snsType == 'apple') {
            $strMemKey = $this->request->getGet('user_key');
            $email = $this->request->getGet('email');
            $token = $this->request->getGet('token');
            
            $strObjectEncrayt = $encryptLib->getSha1($strMemKey);

            $cacheKey = 'sns.' . $snsType . '.' . $strObjectEncrayt;

            cache()->save($cacheKey, [
                'snsType' => $snsType,
                'mem_key' => $strMemKey,
                'mem_email' => $email,
                'mem_object_enc' => $strObjectEncrayt,
                'access_token' => $token,
            ], 300);

            // print_r(cache()->get('sns.apple.b0cb8c28bda3b71df0b6665e583c2de12b603c75'));
            // return;

            return redirect()->to("/login/sns/action/{$snsType}/{$strObjectEncrayt}");
        }

        // alert_url($this->globalvar->aMsg['error12'], $this->backUrlList);

        //todo 에러로그 쌓아야함
        //window.close(); 창닫은후 종료
        exit;
    }

    public function apple()
    {
        // 애플 개발자계정 관련 Service ID, KEYID 등
        $teamId = 'DQALHSS7F2';
        $clientId = $this->globalvar->aSnsInfo['apple']['clientId'];
        $keyFileId = '738B4R89BJ';
        $keyFileName = 'AuthKey_Alphagong.pem';
        $redirectUri = $this->globalvar->aSnsInfo['apple']['redirectUrl'];
        $authorizationCode = $strCode;

        $jwt = $this->generateJWT($keyFileId, $teamId, $clientId);

        $data = [
            'client_id' => $clientId,
            'client_secret' => $jwt,
            'code' => $authorizationCode,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $redirectUri
        ];

        /********* 데이터 담기 **********/

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://appleid.apple.com/auth/token');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch); //실행
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $response = json_decode($result);

        print_r($result);
        return;

        $claims = explode('.', $response->id_token)[1];
        $claims = json_decode(base64_decode($claims));

        print_r($claims);

        if ($status_code == 200) {
            $user_key = $claims->sub;
            $email = $claims->email;
            $object_sha = sha1($user_key);

            $strMemKey = $email;
            $strObjectEncrayt = $encryptLib->getSha1($strMemKey);
            $cacheKey = 'sns.' . $snsType . '.' . $strObjectEncrayt;
            cache()->save($cacheKey, [
                'snsType' => $snsType,
                'mem_key' => $strMemKey,
                'mem_email' => 'apple_login',
                'mem_object_enc' => $strObjectEncrayt,
            ], 300);
            return redirect()->to("/login/sns/action/{$snsType}/{$strObjectEncrayt}");
        } else {
            alert_url($this->globalvar->aMsg['error15'], $this->backUrlList);
        }
    }

    public function app($snsType)
    {
        if (!in_array($snsType, ['kakao', 'naver', 'google', 'apple', 'highbuff'])) {
            alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
            exit;
        }

        $encryptLib = new EncryptLib();
        $strMemKey = $this->request->getGet('user_key');
        $email = $this->request->getGet('email');
        $access_token = $this->request->getGet('access_token');

        if ($snsType == 'apple') {
            if (!$strMemKey) {
                //todo telegram
                alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
                $email = 'apple@apple.com';
                exit;
            }
        } else {
            if (!$strMemKey || !$email) {
                //todo telegram
                alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
                exit;
            }
        }


        $strObjectEncrayt = $encryptLib->getSha1($strMemKey);
        $cacheKey = 'sns.' . $snsType . '.' . $strObjectEncrayt;
        cache()->save($cacheKey, [
            'snsType' => $snsType,
            'mem_key' => $strMemKey,
            'mem_email' => $email,
            'mem_object_enc' => $strObjectEncrayt,
            'access_token' => $access_token,
        ], 300);
        // return redirect()->to("/login/sns/action/{$snsType}/{$strObjectEncrayt}");
        return redirect()->to("/login/sns/action/{$snsType}/{$strObjectEncrayt}?state=app");
    }

    public function generateJWT($keyFileId, $teamId, $clientId)
    {
        $header = [
            'alg' => 'ES256',
            'kid' => $keyFileId
        ];
        $body = [
            'iss' => $teamId,
            'iat' => time(),
            'exp' => time() + 3600,
            'aud' => 'https://appleid.apple.com',
            'sub' => $clientId
        ];

        // $privKey = openssl_pkey_get_private(file_get_contents("/public/plugins/apple/AuthKey_Alphagong.pem"));
        $privKey = openssl_pkey_get_private(file_get_contents("/opt/www/twoPointZero/interviewer/public/plugins/apple/AuthKey_Alphagong.pem"));

        if (!$privKey) {
            return false;
        }

        $payload = $this->encode(json_encode($header)) . '.' . $this->encode(json_encode($body));

        $signature = '';
        $success = openssl_sign($payload, $signature, $privKey, OPENSSL_ALGO_SHA256);
        if (!$success) return false;

        $raw_signature = $this->fromDER($signature, 64);

        return $payload . '.' . $this->encode($raw_signature);
    }

    public function encode($data)
    {
        $encoded = strtr(base64_encode($data), '+/', '-_');
        return rtrim($encoded, '=');
    }

    /********* 데이터 암호화 함수 **********/
    /**
     * @param string $der
     * @param int    $partLength
     *
     * @return string
     */
    public function fromDER(string $der, int $partLength)
    {
        $hex = unpack('H*', $der)[1];
        if ('30' !== mb_substr($hex, 0, 2, '8bit')) { // SEQUENCE
            throw new \RuntimeException();
        }
        if ('81' === mb_substr($hex, 2, 2, '8bit')) { // LENGTH > 128
            $hex = mb_substr($hex, 6, null, '8bit');
        } else {
            $hex = mb_substr($hex, 4, null, '8bit');
        }
        if ('02' !== mb_substr($hex, 0, 2, '8bit')) { // INTEGER
            throw new \RuntimeException();
        }
        $Rl = hexdec(mb_substr($hex, 2, 2, '8bit'));
        $R = $this->retrievePositiveInteger(mb_substr($hex, 4, $Rl * 2, '8bit'));
        $R = str_pad($R, $partLength, '0', STR_PAD_LEFT);
        $hex = mb_substr($hex, 4 + $Rl * 2, null, '8bit');
        if ('02' !== mb_substr($hex, 0, 2, '8bit')) { // INTEGER
            throw new \RuntimeException();
        }
        $Sl = hexdec(mb_substr($hex, 2, 2, '8bit'));
        $S = $this->retrievePositiveInteger(mb_substr($hex, 4, $Sl * 2, '8bit'));
        $S = str_pad($S, $partLength, '0', STR_PAD_LEFT);
        return pack('H*', $R . $S);
    }

    /**
     * @param string $data
     *
     * @return string
     */
    public function retrievePositiveInteger(string $data)
    {
        while ('00' === mb_substr($data, 0, 2, '8bit') && mb_substr($data, 2, 2, '8bit') > '7f') {
            $data = mb_substr($data, 2, null, '8bit');
        }
        return $data;
    }
}
