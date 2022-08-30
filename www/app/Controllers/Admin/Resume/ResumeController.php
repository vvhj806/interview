<?php

namespace App\Controllers\Admin\Resume;

use App\Models\{
    MemKorModel,
    MemberModel,
    MemCateModel,
    JobCategoryModel,
    KoreaAreaModel,
    ResumeModel,
    FileModel,
    ApplierModel,
};
use Config\{Database, Services};
use App\Libraries\SendLib;

use App\Controllers\Admin\AdminController;

class ResumeController extends AdminController
{
    public function resumeList()
    {
        //get
        $iGetMemIdx = $this->request->getGet('memIdx') ?? '';
        $strSearchText = $this->request->getGet('searchText') ?? '';
        $strOrder = $this->request->getGet('order') ?? 'resIdx';
        $strOrderType = $this->request->getGet('orderType') ?? 'DESC';

        //init
        $this->commonData();
        $phonePattern = '/^(010|011|016|017|018|019)[0-9]{3,4}[0-9]{4}$/';

        $resumeModel = new ResumeModel();

        if (is_numeric($strSearchText)) {
            if (preg_match($phonePattern, $strSearchText)) { // 폰번호면 폰
                $resumeModel->where(['iv_member.mem_tel' => $strSearchText]);
            } else {
                $resumeModel // 그냥 숫자면 idx검색 || memtel 검색
                    ->groupStart()
                    ->OrLike('iv_member.mem_tel', $strSearchText, 'both')
                    ->groupEnd();
            }
        } else { // 스트링일시 name 검색
            $resumeModel
                ->groupStart()
                ->Like('iv_member.mem_name', $strSearchText, 'both')
                ->orLike('iv_member.mem_id', $strSearchText, 'both')
                ->groupEnd();
        }
        if ($iGetMemIdx) { // 회원번호
            $resumeModel->where('iv_member.idx', $iGetMemIdx);
        }

        $resumeModel->select([
            'iv_resume.idx AS resIdx', 'iv_resume.mem_idx AS memIdx', 'iv_resume.res_title AS resTitle', 'iv_resume.res_reg_date AS resRegDate',
            'iv_member.idx AS memIdx', 'iv_member.mem_id AS memId', 'iv_member.mem_name AS memName', 'iv_member.mem_tel AS memTel'
        ])->where(['iv_resume.delyn' => 'N'])->memberBuilder()->orderBy($strOrder, $strOrderType);
        $aList = $resumeModel->paginate(10, 'resume');

        $this->aData['data']['getMemIdx'] = $iGetMemIdx;
        $this->aData['data']['searchText'] = $strSearchText;
        $this->aData['data']['order'] = ['column' => $strOrder, 'type' => $strOrderType];
        $this->aData['data']['resumeList'] = $aList;
        $this->aData['data']['pager'] = $resumeModel->pager;
        $this->aData['data']['count'] = $resumeModel->pager->getTotal('resume');
        // view
        $this->header();
        $this->nav();
        echo view('prime/resume/list', $this->aData);
        $this->footer();
    }

    public function write($iResIdx = null)
    {
        //init
        $this->commonData();
        //model
        $resumeModel = new ResumeModel();
        if ($iResIdx) {
            $aBaseList = $resumeModel->select(['iv_resume.mem_idx'])->memberBuilder()->getResume($iResIdx, 'base');
            $aInterestList = $resumeModel->getResume($iResIdx, 'interest');
            $aEducationList = $resumeModel->getResume($iResIdx, 'education');
            $aCareerList = $resumeModel->getResume($iResIdx, 'career');
            $aLicenseList = $resumeModel->getResume($iResIdx, 'license');
            $aLanguageList = $resumeModel->getResume($iResIdx, 'language');
            $aActivityList = $resumeModel->getResume($iResIdx, 'activity');
            $aPortfolioList = $resumeModel->getResume($iResIdx, 'portfolio');
        }

        $this->aData['data']['resIdx'] = $iResIdx;
        $this->aData['data']['resume'] = [
            'base' => $aBaseList,
            'interest' => $aInterestList,
            'education' => $aEducationList,
            'career' => $aCareerList,
            'license' => $aLicenseList,
            'language' => $aLanguageList,
            'activity' => $aActivityList,
            'portfolio' => $aPortfolioList,
        ];

        // view
        $this->header();
        $this->nav();
        echo view('prime/resume/write', $this->aData);
        $this->footer();
    }
}
