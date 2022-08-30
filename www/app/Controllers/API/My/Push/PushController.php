<?php

namespace App\Controllers\API\My\Push;

use App\Controllers\API\APIController;

use App\Models\MemberPushModel;
use Config\Services;
use App\Libraries\GlobalvarLib;
use App\Libraries\SendLib;

class PushController extends APIController
{
    private $aResponse = [];

    public function index()
    {
    }

    public function push()
    {

        // helper('file');
        if (!$this->request->isAJAX()) {
            return $this->respond([
                'status'   => 403,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error3'],
            ], 403);
        }
        $session = session();
        $memIdx = $session->get('idx');
        $strRecommend = $this->request->getPost('Recommend') ? $this->request->getPost('Recommend') : "N";
        $strNoticeEvent = $this->request->getPost('NoticeEvent') ? $this->request->getPost('NoticeEvent') : "N";
        $strreportRead = $this->request->getPost('reportRead') ? $this->request->getPost('reportRead') : "N";
        $strcompanyProposal = $this->request->getPost('companyProposal') ? $this->request->getPost('companyProposal') : "N";
        $strretryRequestAccept = $this->request->getPost('retryRequestAccept') ? $this->request->getPost('retryRequestAccept') : "N";
        $strscrapDeadline = $this->request->getPost('scrapDeadline') ? $this->request->getPost('scrapDeadline') : "N";
        $strscrapNewRecurit = $this->request->getPost('scrapNewRecurit') ? $this->request->getPost('scrapNewRecurit') : "N";

        $strPostCase = $this->request->getPost('postCase');
        $strBackUrl = $this->request->getPost('BackUrl');

        if (!$strPostCase || !$strBackUrl) {
            return $this->respond([
                'status'   => 400,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error2'],
            ], 400);
        }

        $MemberPushModel = new MemberPushModel();
        $aPushInfo = $MemberPushModel->getPushInfo($memIdx);
        $PushModify = $this->masterDB->table('iv_member_push')
            ->set([
                'recommend' => $strRecommend,
                'notice_event' => $strNoticeEvent,
                'report_read' => $strreportRead,
                'company_proposal' => $strcompanyProposal,
                'retry_request_accept' => $strretryRequestAccept,
                'scrap_deadline' => $strscrapDeadline,
                'scrap_new_recurit' => $strscrapNewRecurit,
            ])
            ->set(['push_mod_date' => 'NOW()'], '', false);

        if (!$aPushInfo) {
            $PushModify
                ->set(['mem_idx' => $memIdx])
                ->set(['push_reg_date' => 'NOW()'], '', false)
                ->insert();

            if ($PushModify) {
                $this->aResponse = [
                    'status' => 200,
                    'code' => [
                        'stat' => 'success',
                        'token' => csrf_hash()
                    ],
                    'messages' => $this->globalvar->aApiMsg['success1'],
                ];
            } else {
                $this->aResponse = [
                    'status' => 401,
                    'code' => [
                        'stat' => 'success',
                        'token' => csrf_hash()
                    ],
                    'messages' => $this->globalvar->aApiMsg['error3'],
                ];
            }
        } else {
            $PushModify
                ->where(['mem_idx' => $memIdx, 'delyn' => 'N'])
                ->update();

            if ($PushModify) {
                $this->aResponse = [
                    'status' => 200,
                    'code' => [
                        'stat' => 'success',
                        'token' => csrf_hash()
                    ],
                    'messages' => $this->globalvar->aApiMsg['success1'],
                ];
            } else {
                $this->aResponse = [
                    'status' => 401,
                    'code' => [
                        'stat' => 'success',
                        'token' => csrf_hash()
                    ],
                    'messages' => $this->globalvar->aApiMsg['error3'],
                ];
            }
        }

        return $this->respond($this->aResponse, $this->aResponse['status']);
    }

    public function delete(int $idx)
    {
    }
}
