<?php

namespace App\Controllers\API\Admin;

use App\Controllers\API\APIController;
use App\Models\MemberRecruitScrapModel;

use App\Models\{
    CompanyModel,
    CompanyTagModel,
    TagModel,
    ConfigCompanyTagModel,
    RecruitModel,
    ConfigCompnaySuggestModel,
    CompnaySuggestModel
};
use  App\Libraries\{
    GlobalvarLib
};
use App\Controllers\Admin\AdminController;

class SearchCompanyController extends APIController
{
    private $aResponse = [];

    public function list()
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

        $this->commonData();

        $strSearchText = $this->request->getGet('searchText') ?? '';
        $companyModel = new CompanyModel();
        $today = date('Ymd');

        if ($strSearchText) {
            $companyModel
                ->groupStart() // 키워드
                ->like('iv_member.mem_id', $strSearchText, 'both')
                ->orLike('com_name', $strSearchText, 'both')
                ->orLike('iv_company.com_tel', $strSearchText, 'both')
                ->groupEnd();
        }
        $aList = $companyModel
            ->select([
                'iv_company.idx AS comIdx', 'iv_company.com_name as comName',
                'iv_member.mem_name AS memName', 'iv_member.mem_id AS memId',
            ])
            ->join('iv_member', 'iv_member.idx = iv_company.mem_idx', 'left')
            ->groupBy('iv_company.idx')
            ->orderBy('comIdx', 'DESC')->paginate(10, 'company');

        if ($aList) {
            $this->aResponse = [
                'status'   => 200,
                'code'     => [
                    'stat' => 'success',
                    'token' => csrf_hash(),
                    'list' => $aList
                ],
                'messages' => '성공',
            ];
        } else {
            $this->aResponse = [
                'status'   => 503,
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
