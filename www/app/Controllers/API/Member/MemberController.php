<?php

namespace App\Controllers\API\Member;

use App\Controllers\API\APIController;

use Config\Services;
use App\Models\{
    MemberModel,
};

class MemberController extends APIController
{
    private $aResponse = [];

    public function nextMonth()
    {
        if (!$this->request->isAJAX()) {
            return $this->respond([
                'status'   => 403,
                'code'     => 'fail',
                'messages' => $this->globalvar->aApiMsg['error1'],
            ], 403);
        }
        $memberModel = new MemberModel();
        $session = session();
        $iMemIdx = $session->get('idx');
        $aMemberInfo = $memberModel->select('mem_next_password_date')->getMember2($iMemIdx);

        $baseDate = date('Y-m-d H:i:s');
        if ($aMemberInfo['mem_next_password_date']) {
            $baseDate = $aMemberInfo['mem_next_password_date'];
        }

        $nextMonth = date("Y-m-d H:i:s", strtotime("+1 months", strtotime($baseDate)));

        $result = $memberModel->updateLastPasswordDate($iMemIdx, $nextMonth);

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

    public function read()
    {
        if (!$this->request->isAJAX()) {
            return $this->respond([
                'status'   => 403,
                'code'     => 'fail',
                'messages' => $this->globalvar->aApiMsg['error1'],
            ], 403);
        }
        //get
        $strSearchText = $this->request->getGet('search-text');
        //init
        $aMemList = [];

        //model
        $memberModel = new MemberModel();

        if ($strSearchText) {
            $aMemList = $memberModel->select(['idx', 'mem_id AS memId', 'mem_name AS memName', 'mem_tel AS memTel'])->memberBaseCondition()->like('mem_name', $strSearchText, 'both')->where(['mem_type' => 'M'])->findAll();
        }

        if ($aMemList) {
            $this->aResponse = [
                'status'   => 200,
                'code'     => [
                    'stat' => 'success'
                ],
                'item' => $aMemList,
                'messages' => $this->globalvar->aApiMsg['success6'],
            ];
        } else {
            $this->aResponse = [
                'status'   => 201,
                'code'     => [
                    'stat' => 'success'
                ],
                'messages' => $this->globalvar->aApiMsg['error17'],
            ];
        }

        return $this->respond($this->aResponse, $this->aResponse['status']);
    }
}
