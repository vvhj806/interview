<?php

namespace App\Controllers\API\Interview;

use App\Controllers\API\APIController;
use Config\Services;

use App\Models\{
    ApplierModel,
    JobCategoryModel,
    SetReportScoreRankModel
};

use App\Libraries\SendLib;

class SampleController extends APIController
{
    private $aResponse = [];

    public function index()
    {
    }

    public function show($id = null)
    {
    }

    public function SampleInterview()
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
        $iPager = $this->request->getPost('pager');
        $strCheck = $this->request->getPost('updown');
        $aCateCheck = $this->request->getPost('cate');

        $ApplierModel = new ApplierModel();
        $jobCategoryModel = new JobCategoryModel();
        $SetReportScoreRankModel = new SetReportScoreRankModel();
        $this->encrypter = Services::encrypter();

        if ($aCateCheck == "") {
            $aCateCheck = null;
        }
        if ($strCheck == "") {
            $strCheck = null;
        }


        if ($strCheck || $aCateCheck) {
            if ($aCateCheck) {
                $aGetCheckCate = $jobCategoryModel->getCheckCate($aCateCheck);
                $aSampleInfo = $ApplierModel->sampleList($strCheck, $aGetCheckCate);
            } else {
                $aSampleInfo = $ApplierModel->sampleList($strCheck, $aCateCheck);
            }
        } else {
            $aSampleInfo = $ApplierModel->sampleList();
        }

        $aApplierList = $aSampleInfo->limit(4, $iPager)->find();
        $aGetPercent = $SetReportScoreRankModel->getRankScore();

        $iSampleInfoCount = $aSampleInfo->countAllResults();

        if (!$aApplierList) {
            return $this->respond([
                'status'   => 201,
                'code'     => [
                    'stat' => 'fail',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['error18'],
            ], 201);
        } else {
            foreach ($aApplierList as $sampleKey => $Sample) {
                $rankSum = 0;
                $persentSum = 0;
                $aApplierList[$sampleKey]['percent'] = "-";
                $aApplierList[$sampleKey]['enIdx'] = base64url_encode($this->encrypter->encrypt(json_encode($Sample['idx'])));
                $aSamplesAnal = json_decode($aApplierList[$sampleKey]['repo_analysis']);
                $aApplierList[$sampleKey]['analy'] = $aSamplesAnal;
                foreach ($aGetPercent as $key => $val) {
                    $rankSum = $rankSum + (int)$val['score_rank_count_member'];
                }
                foreach ($aGetPercent as $key => $val) {
                    if ($val['score_rank_count_member'] > 0) {
                        $persent = (floatval($val['score_rank_count_member']) / $rankSum) * 100;
                        $persentSum = $persentSum + $persent;
                        if ($aSamplesAnal->grade == $val['score_rank_grade']) {
                            $aApplierList[$sampleKey]['percent'] = $persentSum;
                        }
                    }
                }
            }

            $this->aResponse = [
                'status'   => 200,
                'code'     => [
                    'stat' => 'success',
                    'token' => csrf_hash()
                ],
                'messages' => $this->globalvar->aApiMsg['success2'],
                'pager' => $iPager,
                'applierList' => $aApplierList,
                'applierCount' => $iSampleInfoCount,
            ];
        }

        return $this->respond($this->aResponse, $this->aResponse['status']);
    }

    public function delete(int $idx)
    {
    }
}
