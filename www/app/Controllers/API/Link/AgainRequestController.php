<?php

namespace App\Controllers\API\Link;

use App\Controllers\API\APIController;

use Config\Services;

class AgainRequestController extends APIController
{
    private $aResponse = [];

    public function index()
    {
    }

    public function request()
    {
        if (!$this->request->isAJAX()) {
            return $this->respond([
                'status'   => 403,
                'code'     => 'fail',
                'messages' => $this->globalvar->aApiMsg['error1'],
            ], 403);
        }

        $requestText = $this->request->getPost('requestText');
        $sugAppIdx = $this->request->getPost('sugAppIdx'); //복호화해야함
        $comIdx = $this->request->getPost('comIdx');

        $this->encrypter = Services::encrypter();
        $sugAppIdx = $this->encrypter->decrypt(base64url_decode($sugAppIdx));

        if (!$sugAppIdx || !$requestText) {
            $this->aResponse = [
                'status'   => 404,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error2'],
            ];
        } else {

            $url = "https://api.highbuff.com/interview/20/link_applicant.php";
            $post_data = array(
                'type' => 'restart',
                'ap_idx' => $sugAppIdx,
                'ag_req_reason' => $requestText,
                'com_idx' => $comIdx
            );

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);

            if ($result) {
                $this->aResponse = [
                    'status'   => 200,
                    'code'     => [
                        'stat' => 'success',
                        'token' => csrf_hash()
                    ],
                    'messages' => $this->globalvar->aApiMsg['success1'],
                ];
            } else {
                $this->aResponse = [
                    'status'   => 500,
                    'code'     => [
                        'stat' => 'fail',
                        'token' => csrf_hash()
                    ],
                    'messages' => $this->globalvar->aApiMsg['error3'],
                ];
            }

            return $this->respond($this->aResponse, $this->aResponse['status']);
        }
    }
}
