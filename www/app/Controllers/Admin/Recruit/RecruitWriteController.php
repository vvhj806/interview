<?php

namespace App\Controllers\Admin\Recruit;

use App\Models\{
    RecruitModel,
    CompanyModel,
    KoreaAreaModel,
    JobCategoryModel,
    MemberRecruitCategoryModel,
    MemberRecruitKor,
    InterviewModel,
    QuestionModel,
    FileModel,
};
use App\Controllers\Admin\AdminController;

class RecruitWriteController extends AdminController
{

    public function write(int $recIdx = null)
    {
        $this->commonData();
        $companyModel = new CompanyModel();
        $recruitModel = new RecruitModel();
        $memberRecruitKor = new MemberRecruitKor();
        $memberRecruitCategoryModel = new MemberRecruitCategoryModel();
        $interviewModel = new InterviewModel();
        $koreaAreaModel = new KoreaAreaModel();
        $JobCategoryModel = new JobCategoryModel();
        $questionModel = new QuestionModel();
        $FileModel = new FileModel();

        if (!$aKoreaArea = cache("search.korea.area")) {
            $aKoreaArea = $koreaAreaModel->getKoreaArea();
            cache()->save("search.korea.area", $aKoreaArea, 86400);
        }

        $aAreaCategory = [];
        foreach ($aKoreaArea as $val) {
            if ($val['area_depth_2'] == null) {
                $aAreaCategory[$val['area_depth_1']]['all'] = ['areaName' => $val['area_depth_text_1'], 'idx' => $val['idx']];
            } else {
                $aAreaCategory[$val['area_depth_1']][] = ['areaName' => $val['area_depth_text_2'], 'idx' => $val['idx']];
            }
        }

        if ($recIdx) { //공고수정
            $aRecList = $recruitModel
                ->select(['*', 'iv_file.idx as fileIdx'])
                ->join('iv_file', 'iv_file.idx = iv_recruit.file_idx_recruit', 'left')
                ->where(['iv_recruit.idx' => $recIdx, 'iv_recruit.delyn' => 'N'])
                ->first();

            if (!$aRecList) {
                alert_back('없습니다');
                exit;
            }

            $aInterList = $interviewModel
                ->select(['iv_interview.idx as interIdx', 'iv_interview.inter_question as interQue', 'iv_job_category.idx as jobIdx', 'iv_job_category.job_depth_text as jobText'])
                ->join('iv_job_category', 'iv_job_category.idx = iv_interview.job_idx_position', 'left')
                ->where(['iv_interview.rec_idx' => $recIdx, 'iv_interview.delyn' => 'N'])
                ->findAll();

            foreach ($aInterList as $key => $val) {
                $aInterQue = explode(',', $val['interQue']);
                $aInterList[$key]['question'] = $questionModel->select(['iv_question.idx as queIdx', 'iv_question.que_question as queText'])->getQue($aInterQue, $val['interQue']);
            }

            $aRecList['rec_work_type'] = explode(',', $aRecList['rec_work_type']);
            $aRecList['rec_end_date'] = date('Y-m-d', strtotime($aRecList['rec_end_date']));
            $aRecList['kor_area_idx'] = $memberRecruitKor->getRecKor($recIdx);
            $aRecList['job_idx'] = $memberRecruitCategoryModel->getRecJob($recIdx);
            $aRecList['com_logo_img'] = $FileModel->select('iv_file.file_save_name')->join('iv_company', 'iv_company.file_idx_logo = iv_file.idx', 'left')
                ->join('iv_recruit','iv_recruit.com_idx = iv_company.idx', 'left',)->where(['iv_recruit.idx' => $recIdx])->first();
        } else { // 새공고만들기
            $getSearchWord = $this->request->getGet('searchText');
            $aComList = $companyModel->select(['idx as comIdx', 'com_name as comName'])->where('delyn', 'N');
            if ($getSearchWord) {
                $aComList = $aComList->like('com_name', $getSearchWord, 'both')
                    ->orLike('com_reg_number', $getSearchWord, 'both')
                    ->orLike('com_ceo_name', $getSearchWord, 'both');
            }
            $aComList = $aComList->findAll();
        }

        //view data
        $this->aData['data']['areaList'] = $aAreaCategory;
        $this->aData['data']['comList'] = $aComList ?? [];
        $this->aData['data']['recList'] = $aRecList ?? [];
        $this->aData['data']['interList'] = $aInterList ?? [];
        $this->aData['data']['recIdx'] = $recIdx ?? '';
        $this->aData['data']['searchTxt'] = $getSearchWord ?? '';

        // view
        $this->header();
        $this->nav();
        echo view('prime/recruit/write', $this->aData);
        $this->footer();
    }
}
