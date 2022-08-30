<?php

namespace App\Controllers\Admin\Recruit;

use App\Models\{
    RecruitModel,
};
use App\Controllers\Admin\AdminController;

class RecruitListController extends AdminController
{
    public function index()
    {
        $this->list();
    }

    public function list()
    {
        $this->commonData();
        $apply = ['M' => '지원자', 'C' => '기업', 'A' => '무관'];
        $stat = ['I' => '대기중', 'Y' => '승인완료', 'N' => '승인거절'];
        $strStat = $this->request->getGet('stat') ?? "";
        $strSearchText = $this->request->getGet('searchText') ?? "";
        if ($strStat != 'I') {
            $strStat = "";
        }
        $recruitModel = new RecruitModel();

        if ($strStat === 'I') {
            $recruitModel->where('iv_recruit.rec_stat', 'I');
        }
        if ($strSearchText) {
            $recruitModel
                ->groupStart() // 키워드
                ->like('rec_title', $strSearchText, 'both')
                ->orLike('com_name', $strSearchText, 'both')
                ->orLike('job_depth_text', $strSearchText, 'both')
                ->groupEnd();
        }
        $aList = $recruitModel
            ->buildeRecruitList()
            ->paginate(10, 'recruit');

        foreach ($aList as $key => $val) {
            $aList[$key]['recStat'] = $stat[$val['recStat']];
            $aList[$key]['recApply'] = $apply[$val['recApply']];
        }

        $aRecruitStat = $recruitModel->getRecruitStat();

        $this->aData['data']['recStat'] = $aRecruitStat;
        $this->aData['data']['list'] = $aList;
        $this->aData['data']['pager'] = $recruitModel->pager;
        $this->aData['data']['count'] = $recruitModel->pager->getTotal('recruit');
        $this->aData['data']['searchText'] = $strSearchText;
        $this->aData['data']['stat'] = $strStat;

        // view
        $this->header();
        $this->nav();
        echo view('prime/recruit/list', $this->aData);
        $this->footer();
    }
}
