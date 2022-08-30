<?php

namespace App\Controllers\API\Send;

use App\Controllers\API\APIController;
use CodeIgniter\I18n\Time;
use App\Libraries\SendLib;

class MessageController extends APIController
{
    private $aResponse = [];

    public function index()
    {
    }

    public function create()
    {
    }

    public function show(string $code)
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

        $strMsg =  $this->request->getPost('msg');
        $strBotType = $this->request->getPost('botType');

        if (!in_array($code, ['telegram']) || !$strMsg) {
            return $this->respond([
                'status'   => 404,
                'code'     => 'fail',
                'messages' => $this->globalvar->aApiMsg['error2'],
            ], 404);
        }

        $sendLib = new SendLib();
        $sendResult = $sendLib->telegramSend($strMsg, $strBotType);
        if ($sendResult == 200) {
            $this->aResponse = [
                'status'   => 200,
                'code'     => [
                    'stat' => 'success',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['success12'],
            ];
        } else {
            $this->aResponse = [
                'status'   => $sendResult,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error3'],
            ];
        }
        return $this->respond($this->aResponse, $this->aResponse['status']);
    }

    public function update($id = null)
    {
    }

    public function delete($id = null)
    {
    }
}
