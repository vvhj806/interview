<?php

namespace App\Controllers\API\Applier\Upload\Navertts;

use App\Controllers\API\APIController;

use App\Models\ApplierModel;
use Config\Services;
use App\Libraries\GlobalvarLib;
use App\Libraries\SendLib;

class FileController extends APIController
{
    private $aResponse = [];

    public function index()
    {
    }

    public function naverTTS()
    {

        // helper('file');
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
        $iMemIdx = $this->request->getPost('memIdx');
        $strTtsText = $this->request->getPost('ttsText');
        $strTtsIndex = $this->request->getPost('ttsIndex');
        $strTtsType = $this->request->getPost('ttsType');
        $strPostCase = $this->request->getPost('postCase');
        $strBackUrl = $this->request->getPost('BackUrl');

        $uploadPath = "tts/";
        $GlobalvarLib = new GlobalvarLib();

        $strFilePath = WRITEPATH . $uploadPath;

        $strTtsType = $strTtsType ?? "";

        if ($strTtsType == "0" || $strTtsType == "1") {
            $boolTtsType = true;
        } else if ($strTtsType == null || $strTtsType == "") {
            $boolTtsType = false;
        }

        if (!$session->has('idx') || $session->get('idx') != $iMemIdx || $strPostCase != 'naver_tts' || !$strTtsText || !$strTtsIndex || !$boolTtsType || !$strBackUrl) {
            return $this->respond([
                'status'   => 400,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash()
                ],
                "tts_text" => $strTtsText,
                "tts_index" => $strTtsIndex,
                "tts_type" => $strTtsType,
                "memIdx" => $session->get('idx'),
                'messages' => $this->globalvar->aApiMsg['error2'],
            ], 400);
        }

        $postfields = array(
            'tts_text' => $strTtsText,
            'tts_index' => $strTtsIndex,
            'tts_type' => $strTtsType,
            'server_type' => $GlobalvarLib->getServerHost()
        );

        $header = array();
        $header[] = 'Content-Type: multipart/form-data';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://media.highbuff.com/app/interview/naver_tts.php');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60); // 60초
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $return = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($status_code == 200) {
            $this->aResponse = [
                'status' => 200,
                'code' => [
                    'stat' => 'success',
                    'token' => csrf_hash()
                ],
                "tts_text" => $strTtsText,
                "tts_index" => $strTtsIndex,
                "tts_type" => $strTtsType,
                'messages' => $this->globalvar->aApiMsg['error7'],
            ];
        } else {
            $this->aResponse = [
                'status' => 500,
                'code' => [
                    'stat' => 'success',
                    'token' => csrf_hash()
                ],
                "tts_text" => $strTtsText,
                "tts_index" => $strTtsIndex,
                "tts_type" => $strTtsType,
                "test" => $status_code,
                'messages' => $this->globalvar->aApiMsg['error8'],
            ];
        }

        curl_close($ch);

        return $this->respond($this->aResponse, $this->aResponse['status']);
    }

    public function delete(int $idx)
    {
    }
}
