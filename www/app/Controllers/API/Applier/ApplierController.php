<?php

namespace App\Controllers\API\Applier;

use App\Controllers\API\APIController;

use Config\Services;
use App\Models\{
    ApplierModel,
};

class ApplierController extends APIController
{
    private $aResponse = [];

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
        $iMemIdx = $this->request->getGet('mem-idx');
        //init
        $aApplierList = [];
        //model
        $applierModel = new ApplierModel();

        if ($iMemIdx) {
            $aApplierList = $applierModel->select(['idx'])->getApplyPossibleReport($iMemIdx)->findAll();
        }

        if ($aApplierList) {
            $this->aResponse = [
                'status'   => 200,
                'code'     => [
                    'stat' => 'success'
                ],
                'item' => $aApplierList,
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
