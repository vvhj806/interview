<?php

namespace App\Controllers\Interview\Company\Tag;

use App\Controllers\Interview\WwwController;
use App\Models\{
    CompanyModel,
    ConfigCompanyTagModel,
    JobCategoryModel,
    MemberRecruitScrapModel,
    CompanyTagModel
};
use Config\Services;
use CodeIgniter\Cookie\Cookie;
use CodeIgniter\Cookie\CookieStore;
use DateTime;

class TagListController extends WwwController
{
    private $backUrlList = '/';

    public function list()
    {
        $this->commonData();
        if ($this->aData['data']['session']['idx']) {
            $iMemberIdx = $this->aData['data']['session']['idx'];
            $memberRecruitScrapModel = new MemberRecruitScrapModel();
            $aScrap = $memberRecruitScrapModel
                ->where('scr_type', 'C')
                ->getMyScrap($iMemberIdx)
                ->findColumn('com_idx');
        }
        $aTagCheck = $this->request->getGet('tagCheck') ?? [];
        $boolHire = $this->request->getGet('hire') ?? false;
        $iSort = $this->request->getGet('sort') ?? 1;
        $checkSort = [
            1 => '',
            2 => 'com_form',
            3 => 'com_industry'
        ];

        $configCompanyTag = new ConfigCompanyTagModel();
        $aConfigTag = $configCompanyTag->getTagList();

        $companyModel = new CompanyModel();

        $strJoinName = $boolHire ? 'inner' : 'left';

        $companyModel
            ->getTagList($aTagCheck, $strJoinName);
        if ($checkSort[$iSort] === 'com_form') {
            $companyModel
                ->orderBy("CASE
                WHEN com_form = '대기업' THEN 0
                WHEN com_form = '공기업' THEN 1
                WHEN com_form = '중견기업' THEN 2
                ELSE 3 END", FALSE);
        } else {
            $companyModel
                ->orderBy($checkSort[$iSort], 'desc');
        }
        $aList = $companyModel->paginate(10, 'tagCompany');

        $companyTagModel = new CompanyTagModel();
        foreach ($aList as $key => $val) {
            $aList[$key]['tagCnt'] = $companyTagModel->getCompanyTagCount($val['comIdx']);
            if ($aScrap ?? false) {
                if (in_array($val['comIdx'], $aScrap)) {
                    $aList[$key]['scrap'] = true;
                }
            }
        }

        $this->aData['data']['sort'] = $iSort;
        $this->aData['data']['hire'] = $boolHire;
        $this->aData['data']['list'] = $aList;
        $this->aData['data']['count'] = $companyModel->pager->getTotal('tagCompany');
        $this->aData['data']['pager'] = $companyModel->pager;
        $this->aData['data']['tag'] = $aConfigTag;
        $this->aData['data']['get']['tag'] = $aTagCheck;

        // view
        $this->header();
        echo view('www/company/tag/list', $this->aData);
        $this->footer(['company']);
    }
}
