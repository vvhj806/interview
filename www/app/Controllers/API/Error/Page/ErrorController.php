<?php

namespace App\Controllers\API\Error\Page;

use App\Controllers\API\APIController;
use App\Models\MemberRecruitScrapModel;
use App\Libraries\SendLib;
use PDO;

class ErrorController extends APIController
{
    private $aResponse = [];

    public function index()
    {
    }

    public function create(string $code)
    {
        if (!$this->request->isAJAX()) {
            return $this->respond([
                'status'   => 403,
                'code'     => 'fail',
                'messages' => $this->globalvar->aApiMsg['error1'],
            ], 403);
        }

        if (!in_array($code, ['applier', 'photo', 'modify', 'start', 'write'])) {
            return $this->respond([
                'status'   => 404,
                'code'     => 'fail',
                'messages' => $this->globalvar->aApiMsg['error2'],
            ], 404);
        }

        $session = session();
        $iMemIdx = $session->get('idx') ?? '';
        $aData = [];
        $tel_txt = "";
        //$result = false;
        if ($code == 'applier') {
            $iApplierIdx = $this->request->getPost('applierIdx');
            $iQuestionIdx = $this->request->getPost('questionIdx');
            $strFullPage = $this->request->getPost('pullPage');
            $strErrorTxt = $this->request->getPost('errorTxt');

            $aData = [
                'userIp' => $this->request->getIPAddress(),
                'serverProtocol' => $this->request->getServer('SERVER_PROTOCOL'),
                'userAgent' => $this->request->getServer('HTTP_USER_AGENT'),
                'fullPage' => $strFullPage,
                'memIdx' => $iMemIdx,
                'applierIdx' => $iApplierIdx,
                'questionIdx' => $iQuestionIdx,
                'error' => $strErrorTxt,
            ];
            $tel_txt = "[하이버프2.0_ERROR]\n경로: /Views/www/interview/start.php\n에러: 영상 파일 사이즈가 10미만 미디어 서버로 업로드 불가";
        } else if ($code == 'photo') {
            $iApplierIdx = $this->request->getPost('applierIdx');
            $strFullPage = $this->request->getPost('pullPage');
            $strErrorTxt = $this->request->getPost('errorTxt');

            $aData = [
                'userIp' => $this->request->getIPAddress(),
                'serverProtocol' => $this->request->getServer('SERVER_PROTOCOL'),
                'userAgent' => $this->request->getServer('HTTP_USER_AGENT'),
                'fullPage' => $strFullPage,
                'applierIdx' => $iApplierIdx,
                'memIdx' => $iMemIdx,
                'error' => $strErrorTxt,
            ];
            $tel_txt = "[하이버프2.0_ERROR]\n경로: " . $strFullPage . "\n에러: socket 연결에서 문제\nerror: " . $strErrorTxt;
        } else if ($code == 'modify') {
            $strFullPage = $this->request->getPost('pullPage');
            $strErrorTxt = $this->request->getPost('errorTxt');

            $aData = [
                'userIp' => $this->request->getIPAddress(),
                'serverProtocol' => $this->request->getServer('SERVER_PROTOCOL'),
                'userAgent' => $this->request->getServer('HTTP_USER_AGENT'),
                'fullPage' => $strFullPage,
                'memIdx' => $iMemIdx,
                'error' => $strErrorTxt,
            ];
            $tel_txt = "[하이버프2.0_ERROR]\n경로: " . $strFullPage . "\n에러: socket 연결에서 문제 \nerror:" . $strErrorTxt;
        } else if ($code == 'start') {
            $iApplierIdx = $this->request->getPost('applierIdx');
            $strFullPage = $this->request->getPost('pullPage');
            $strErrorTxt = $this->request->getPost('errorTxt');

            $aData = [
                'userIp' => $this->request->getIPAddress(),
                'serverProtocol' => $this->request->getServer('SERVER_PROTOCOL'),
                'userAgent' => $this->request->getServer('HTTP_USER_AGENT'),
                'fullPage' => $strFullPage,
                'memIdx' => $iMemIdx,
                'applierIdx' => $iApplierIdx,
                'error' => $strErrorTxt,
            ];

            $tel_txt = "[하이버프2.0_ERROR]\n경로: " . $strFullPage . "\n에러: socket 연결에서 문제 \nerror:" . $strErrorTxt;
        } else if ($code == 'write') {
            $strFullPage = $this->request->getPost('pullPage');
            $strErrorTxt = $this->request->getPost('errorTxt');

            $aData = [
                'userIp' => $this->request->getIPAddress(),
                'serverProtocol' => $this->request->getServer('SERVER_PROTOCOL'),
                'userAgent' => $this->request->getServer('HTTP_USER_AGENT'),
                'fullPage' => $strFullPage,
                'memIdx' => $iMemIdx,
                'error' => $strErrorTxt,
            ];
            $tel_txt = "[하이버프2.0_ERROR]\n경로: " . $strFullPage . "\n에러: socket 연결에서 문제 \nerror:" . $strErrorTxt;
        } else if ($code == 'record' || $code == 'audioRecord') { //영상 녹화 및 음성 녹음에서 문제
            $iApplierIdx = $this->request->getPost('applierIdx');
            $strFullPage = $this->request->getPost('pullPage');
            $strErrorTxt = $this->request->getPost('errorTxt');

            $aData = [
                'userIp' => $this->request->getIPAddress(),
                'serverProtocol' => $this->request->getServer('SERVER_PROTOCOL'),
                'userAgent' => $this->request->getServer('HTTP_USER_AGENT'),
                'fullPage' => $strFullPage,
                'memIdx' => $iMemIdx,
                'applierIdx' => $iApplierIdx,
                'code' => $code,
                'error' => $strErrorTxt,
            ];
            $tel_txt = "[하이버프2.0_ERROR]\n경로: " . $strFullPage . "\n에러: 인터뷰 녹화에서 문제 \nerror:" . $strErrorTxt;
        }

        $result = $this->masterDB->table('log_error_page')
            ->set([
                'error_page' => $code,
                'error_data' => json_encode($aData),
            ])
            ->set(['error_reg_date' => 'NOW()'], '', false)
            ->insert();

        if ($result) {
            $sendLib = new SendLib();
            $sendResult = $sendLib->telegramSend($tel_txt, "DEV");

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

    public function show($id = null)
    {
    }

    public function update($id = null)
    {
    }

    public function delete(string $scrapType, int $memIdx, int $idx)
    {
    }
}
