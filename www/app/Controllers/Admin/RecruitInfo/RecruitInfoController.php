<?php

namespace App\Controllers\Admin\RecruitInfo;

use App\Models\{
    RecruitInfoModel,
    FileModel,
    ApplierModel,
    RecruitModel
};
use App\Controllers\Admin\AdminController;

class RecruitInfoController extends AdminController
{
    public function mList()
    {
        $this->commonData();
        $searchText = $this->request->getGet('searchText');
        $strAgainType = $this->request->getGet('againType') ?? '';

        $recruitInfoModel = new RecruitInfoModel();

        $again = '';
        if ($strAgainType == 'again') {
            $again = 'config_again_request.ag_req_com is not';
        } else if ($strAgainType == 'noAgain') {
            $again = 'config_again_request.ag_req_com';
        }

        if ($searchText) {
            $recruitInfoModel
                ->groupStart()
                ->like('mem_id', trim($searchText), 'both')
                ->orLike('mem_name', trim($searchText), 'both')
                ->orLike('mem_tel', trim($searchText), 'both')
                ->orLike('com_name', trim($searchText), 'both')
                ->orLike('rec_title', trim($searchText), 'both')
                ->groupEnd();
        }

        $recruitInfoModel->select('iv_recruit_info.idx as rec_info_idx, iv_member.mem_id, iv_member.mem_name, iv_member.mem_tel, iv_company.com_name, iv_recruit.rec_title, iv_applier.app_type, iv_recruit_info.res_info_reg_date, config_again_request.ag_req_com, config_again_request.ag_req_stat');
        if ($again != '') {
            $recruitInfoModel->where($again, null);
        }
        $getRecruitList = $recruitInfoModel->getRecruitList()->orderBy('iv_recruit_info.idx', 'DESC')->paginate(10, 'recruitInfo');

        $this->aData['data']['state'] = 'm';
        $this->aData['data']['list'] = $getRecruitList;
        $this->aData['data']['pager'] = $recruitInfoModel->pager;
        $this->aData['data']['search'] = $searchText;    //검색
        $this->aData['data']['againType'] = $strAgainType;

        // view
        $this->header();
        $this->nav();
        echo view('prime/recruit_info/mList', $this->aData);
        $this->footer();
    }

    public function write()
    {
        $this->commonData();
        // view
        $this->header();
        $this->nav();
        echo view('prime/recruit_info/write', $this->aData);
        $this->footer();
    }

    public function writeAction()
    {
        //post
        $aRecIdx = $this->request->getPost('rec_idx');
        $aComIdx = $this->request->getPost('com_idx');
        $aMemIdx = $this->request->getPost('mem_idx');
        $aAppIdx = $this->request->getPost('app_idx');
        //model
        $recruitInfoModel = new RecruitInfoModel();
        $applierModel = new ApplierModel();
        $recruitModel = new RecruitModel();
        //init
        $this->commonData();
        $aFailedMemIdx = [];

        $aRecList = $recruitModel->select(['iv_recruit.idx AS recIdx', 'iv_recruit.com_idx AS comIdx', 'iv_recruit.rec_apply_count AS recApplyCnt'])->whereIn('iv_recruit.idx', $aRecIdx)->findAll();
        $aAppList = $applierModel->select(['iv_applier.idx AS appIdx', 'iv_applier.res_idx AS resIdx', 'iv_applier.mem_idx AS memIdx'])->whereIn('iv_applier.idx', $aAppIdx)->findAll();


        //트랜잭션 start
        $this->masterDB->transBegin();

        foreach ($aRecList as $recRow) {
            foreach ($aAppList as $appRow) {
                $iApplyCount = $recruitInfoModel->where(['mem_idx' => $appRow['memIdx'], 'rec_idx' => $recRow['recIdx'], 'delyn' => 'N'])->countAllResults();
                if ($iApplyCount >= $recRow['recApplyCnt']) {
                    $aFailedMemIdx[] = $appRow['memIdx'];
                    continue;
                }

                $this->masterDB->table('iv_recruit_info')
                    ->set([
                        'mem_idx' => $appRow['memIdx'],
                        'app_idx' => $appRow['appIdx'],
                        'res_idx' => $appRow['resIdx'],
                        'rec_idx' => $recRow['recIdx'],
                        'com_idx' => $recRow['comIdx'],
                        'res_info_ing_mem' => 'C'
                    ])
                    ->set(['res_info_reg_date' => 'NOW()'], '', false)
                    ->set(['res_info_mod_date' => 'NOW()'], '', false)
                    ->insert();
            }
        }
        $strFailedMemIdx = implode('/', $aFailedMemIdx);
        // 트랜잭션 end
        if ($this->masterDB->transStatus() === false) {
            $this->masterDB->transRollback();
            alert_back($this->globalvar->aMsg['error3']);
            exit;
        } else {
            $this->masterDB->transCommit();
            alert_back($this->globalvar->aMsg['success1'] . '지원 횟수 초과 회원 번호' . $strFailedMemIdx);
            exit;
        }
    }

    public function mDetail($recInfoIdx)
    {
        $this->commonData();
        $recruitInfoModel = new RecruitInfoModel();
        $fileModel = new FileModel();

        $recruitInfoModel->select('iv_recruit_info.idx as rec_info_idx, iv_company.idx as com_idx, iv_recruit.idx as rec_idx, iv_file.file_save_name, iv_company.com_name, iv_recruit.rec_title, iv_member.mem_id, iv_member.mem_name, iv_member.mem_tel, iv_recruit_info.res_info_reg_date, iv_applier.app_type, config_again_request.ag_req_com, config_again_request.ag_req_stat, config_again_request.ag_req_reg_date, iv_recruit_info.file_idx_data_1, iv_recruit_info.file_idx_data_2, iv_recruit_info.file_idx_data_3, iv_recruit_info.file_idx_data_4, iv_recruit_info.file_idx_data_5, iv_applier.idx as app_idx, config_again_request.ag_req_reason')
            ->where(['iv_recruit_info.idx' => $recInfoIdx,])
            ->orderBy('config_again_request.idx', 'desc');
        $recruitInfo = $recruitInfoModel->getRecruitList()->first();

        // 지원 첨부파일
        for ($i = 0; $i < 5; $i++) {
            if ($recruitInfo['file_idx_data_' . ($i + 1)] == '' || $recruitInfo['file_idx_data_' . ($i + 1)] == null) {
                break;
            } else {
                $getFileSaveName = $fileModel->getChumbuFileInfo($recruitInfo['file_idx_data_' . ($i + 1)]);
                $aChumbuFile[] = $getFileSaveName;
            }
        }

        $this->aData['data']['info'] = $recruitInfo;
        $this->aData['data']['chumbuFile'] = $aChumbuFile ?? [];
        $this->aData['data']['recInfoIdx'] = $recInfoIdx;

        // view
        $this->header();
        $this->nav();
        echo view('prime/recruit_info/mDetail', $this->aData);
        $this->footer();
    }

    public function cList()
    {
        $this->commonData();
        $searchText = $this->request->getGet('searchText');

        $recruitInfoModel = new RecruitInfoModel();

        if ($searchText) {
            $recruitInfoModel
                ->groupStart()
                ->like('com_name', trim($searchText), 'both')
                ->orLike('rec_title', trim($searchText), 'both')
                ->groupEnd();
        }

        $recruitInfoModel->select('iv_recruit_info.idx as rec_info_idx, iv_member.mem_id, iv_member.mem_name, iv_member.mem_tel, iv_company.com_name, iv_recruit.rec_title, iv_applier.app_type, iv_recruit_info.res_info_reg_date, config_again_request.ag_req_com, config_again_request.ag_req_stat,iv_recruit.idx as rec_idx, iv_recruit.rec_reg_date');
        $getRecruitList = $recruitInfoModel->getRecruitList()->orderBy('iv_recruit_info.idx', 'DESC')->groupBy('iv_recruit.idx')->paginate(10, 'recruitInfo');

        $this->aData['data']['state'] = 'c';
        $this->aData['data']['list'] = $getRecruitList;
        $this->aData['data']['pager'] = $recruitInfoModel->pager;
        $this->aData['data']['search'] = $searchText;    //검색

        // view
        $this->header();
        $this->nav();
        echo view('prime/recruit_info/cList', $this->aData);
        $this->footer();
    }

    public function cDetail($recIdx)
    {
        $this->commonData();
        $recruitInfoModel = new RecruitInfoModel();

        $getRecruitInfoDetail = $recruitInfoModel->select('iv_company.idx as comIdx, iv_company.com_name, iv_recruit.idx as recIdx, iv_file.file_save_name, iv_recruit.rec_title');
        $getRecruitInfoDetail = $recruitInfoModel->getRecInfoDetail($recIdx)->first();

        $getRecruitInfoList = $recruitInfoModel->select('iv_member.idx as memIdx, iv_member.mem_id, iv_member.mem_name, iv_member.mem_tel, iv_recruit_info.idx as recInfoIdx, iv_recruit_info.app_idx, config_again_request.ag_req_stat, config_again_request.ag_req_com, config_again_request.ag_req_reason, config_again_request.idx as ag_req_idx, iv_recruit_info.res_info_reg_date');
        $getRecruitInfoList = $recruitInfoModel->getRecruitInfoDetail($recIdx)->orderBy('recInfoIdx', 'desc')->paginate(5, 'applicant');

        $this->aData['data']['info'] = $getRecruitInfoDetail;
        $this->aData['data']['applicatnInfo'] = $getRecruitInfoList;
        $this->aData['data']['pager'] = $recruitInfoModel->pager;

        // view
        $this->header();
        $this->nav();
        echo view('prime/recruit_info/cDetail', $this->aData);
        $this->footer();
    }

    private function getinfo()
    { // mem_idx, app_idx, res_idx

    }

    private function getinfo2()
    { // com_idx, rec_idx

    }
    private function getbase()
    { //날짜, res_info_ing_mem

    }
}
