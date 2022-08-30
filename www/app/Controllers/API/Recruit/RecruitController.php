<?php

namespace App\Controllers\API\Recruit;

use App\Controllers\API\APIController;

use Config\Services;
use App\Models\{
    RecruitModel,
};

class RecruitController extends APIController
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
        $strType = $this->request->getGet('type');
        $strSearchText = $this->request->getGet('search-text');
        $iRecIdx = $this->request->getGet('recruit-idx');

        if ($strType === 'list') {
            $aRecruitList = $this->list($strSearchText);
        } elseif ($strType === 'detail') {
            $aRecruitList = $this->detail($iRecIdx);
        }

        if ($aRecruitList) {
            $this->aResponse = [
                'status'   => 200,
                'code'     => [
                    'stat' => 'success'
                ],
                'item' => $aRecruitList,
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

    private function list(string $strSearchText)
    {
        if (!$strSearchText) {
            return [];
        }
        $recruitModel = new RecruitModel();

        $recruitModel->select(['iv_recruit.idx as idx', 'rec_title', 'com_name'])->recruitBaseCondition()->companyBuilder()
            ->like('rec_title', $strSearchText, 'both');

        $aRecruitList = $recruitModel->findAll();

        return $aRecruitList;
    }

    private function detail(int $iRecIdx)
    {
        if (!$iRecIdx) {
            return [];
        }
        $recruitModel = new RecruitModel();

        $recruitModel
            ->select([
                'iv_recruit.idx AS recIdx', 'iv_company.idx AS comIdx', 'iv_company.com_name', 'iv_recruit.rec_title', 'iv_job_category.job_depth_text',
                'iv_korea_area.area_depth_text_2', 'iv_recruit.rec_apply AS recApply', 'iv_recruit.rec_end_date'
            ])
            ->companyBuilder()->jobCategoryBuilder()->koreaAreaBuilder()
            ->recruitBaseCondition()->where(['iv_recruit.idx' => $iRecIdx]);

        $aRecruitList = $recruitModel->first();
        $aRecruitList['recApply'] = $recruitModel->getApplyMsg($aRecruitList['recApply']);
        return $aRecruitList;
    }
}
