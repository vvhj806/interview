<?php

namespace App\Controllers\Admin\Interview;

use App\Models\{
    JobCategoryModel,
    ApplierModel,
    CompanyModel
};
use Config\Services;
use App\Controllers\Admin\AdminController;

class InterviewController extends AdminController
{
    public function viewList()
    {
        //get
        $iGetMemIdx = $this->request->getGet('memIdx') ?? '';
        $strSearchText = $this->request->getGet('searchText') ?? '';
        $strOrder = $this->request->getGet('order') ?? 'appIdx';
        $strOrderType = $this->request->getGet('orderType') ?? 'DESC';
        $aInterType = $this->request->getGet('interType') ?? [];
        $aJobIdx = $this->request->getGet('depth3') ?? [];
        $aAppStat = $this->request->getGet('iv_app_stat') ?? [4];

        //init
        $this->commonData();
        $phonePattern = '/^(010|011|016|017|018|019)[0-9]{3,4}[0-9]{4}$/';
        //model
        $applierModel = new ApplierModel();

        if (is_numeric($strSearchText)) {
            if (preg_match($phonePattern, $strSearchText)) { // 폰번호면 폰
                $applierModel->where(['iv_member.mem_tel' => $strSearchText]);
            } else {
                $applierModel // 그냥 숫자일때
                    ->groupStart()
                    ->orWhere(['iv_applier.idx' => $strSearchText])
                    ->orLike('iv_member.mem_tel', $strSearchText, 'both')
                    ->groupEnd();
            }
        } else { // 스트링일시 id, name 검색
            $applierModel
                ->groupStart()
                ->orLike('iv_member.mem_id', $strSearchText, 'both')
                ->orLike('iv_member.mem_name', $strSearchText, 'both')
                ->groupEnd();
        }
        if ($aInterType) { //기업인터뷰,모의인터뷰,인터뷰등
            $applierModel->whereIn('iv_applier.app_type', $aInterType);
        }
        if ($aJobIdx) { // 잡카테고리 
            $applierModel->whereIn('iv_applier.job_idx', $aJobIdx);
        }
        if ($iGetMemIdx) { // 회원번호
            $applierModel->where('iv_member.idx', $iGetMemIdx);
        }

        $applierModel
            ->selectorAdminList('interview')
            ->whereIn('iv_applier.app_iv_stat', $aAppStat)
            ->jobCategoryBuilder()->thumbNailBuilder()->memberBuilder()->orderBy($strOrder, $strOrderType);
        $aList = $applierModel->paginate(10, 'applier');

        foreach ($aList as $key => $val) {
            $aList[$key]['appType'] = $applierModel->getAppTypeMsg($val['appType']);
            $aList[$key]['appStat'] = $applierModel->getAppStatMsg($val['appStat']);
        }

        $this->aData['data']['getMemIdx'] = $iGetMemIdx;
        $this->aData['data']['search'] = ['text' => $strSearchText];
        $this->aData['data']['order'] = ['column' => $strOrder, 'type' => $strOrderType];
        $this->aData['data']['filter'] = ['stat' => $aAppStat, 'jobIdx' => $aJobIdx, 'type' => $aInterType];
        $this->aData['data']['applierList'] = $aList;
        $this->aData['data']['pager'] = $applierModel->pager;
        $this->aData['data']['count'] = $applierModel->pager->getTotal('applier');
        // view
        $this->header();
        $this->nav();
        echo view('prime/interview/view/list', $this->aData);
        $this->footer();
    }

    public function viewDetail(int $iAppIdx)
    {
        //init
        $this->commonData();
        //model
        $applierModel = new ApplierModel();

        $applierModel->select([
            'iv_applier.app_type AS appType', 'iv_applier.app_reg_date AS appRegDate', 'iv_applier.app_iv_stat AS appStat',
            'iv_applier.app_count AS appCount', 'iv_applier.app_like_count AS appLikeCount', 'iv_applier.app_share AS appShare',
            'iv_applier.app_platform AS appPlatForm', 'iv_applier.app_browser_name AS appBrowserName', 'iv_applier.app_browser_version AS appBrowserVer',
            'iv_applier.app_os AS appOs', 'iv_applier.app_os_version AS appOsVer', 'iv_applier.app_referer AS appReferer',
            'iv_applier.rec_idx AS recIdx', 'iv_applier.mem_idx AS memIdx',
            'iv_report_result.repo_analysis AS analysis', 'iv_report_result.repo_score AS score',
            'iv_file.file_save_name as fileName', 'iv_job_category.job_depth_text as jobText',
        ]);
        $aTotalList = $applierModel->getTotalScore($iAppIdx)->jobCategoryBuilder()->thumbNailBuilder()->first();

        $applierModel->select([
            'iv_video.video_record', 'iv_question.que_question AS queText',
            'iv_report_result.repo_analysis AS analysis', 'iv_report_result.repo_score AS score', 'iv_report_result.repo_speech_txt_detail AS sttDetail',
            'iv_report_result.repo_audio_detail AS audio'
        ]);
        $aScoreList = $applierModel->getScoreVideo($iAppIdx)->findAll();

        $aTotalList['analysis'] = json_decode($aTotalList['analysis'], true);
        $aTotalList['score'] = json_decode($aTotalList['score'], true);
        $aTotalList['appStatMsg'] = $applierModel->getAppStatMsg($aTotalList['appStat']);
        $aTotalList['appType'] = $applierModel->getAppTypeMsg($aTotalList['appType']);

        foreach ($aScoreList as $key => $val) {
            $aScoreList[$key]['analysis'] = json_decode($val['analysis'], true);
            $aScoreList[$key]['score'] = json_decode($val['score'], true);
            $aScoreList[$key]['sttDetail'] = json_decode($val['sttDetail'], true);
            $aScoreList[$key]['audio'] = json_decode($val['audio'], true);
        }

        $this->aData['data']['totalList'] = $aTotalList;
        $this->aData['data']['scoreList'] = $aScoreList;
        // view
        $this->header();
        $this->nav();
        echo view('prime/interview/view/detail', $this->aData);
        $this->footer();
    }

    public function comprehensiveList()
    {
        //get
        $strSearchText = $this->request->getGet('searchText') ?? '';
        $strOrder = $this->request->getGet('order') ?? 'appIdx';
        $strOrderType = $this->request->getGet('orderType') ?? 'DESC';
        $aInterType = $this->request->getGet('interType') ?? [];
        $aJobIdx = $this->request->getGet('depth3') ?? [];

        //init
        $this->commonData();
        $phonePattern = '/^(010|011|016|017|018|019)[0-9]{3,4}[0-9]{4}$/';
        //model
        $applierModel = new ApplierModel();
        $this->encrypter = Services::encrypter();

        if (is_numeric($strSearchText)) {
            if (preg_match($phonePattern, $strSearchText)) { // 폰번호면 폰
                $applierModel->where(['iv_member.mem_tel' => $strSearchText]);
            } else {
                $applierModel // 그냥 숫자일때
                    ->groupStart()
                    ->orWhere(['iv_member.idx' => $strSearchText])
                    ->orWhere(['iv_applier.idx' => $strSearchText])
                    ->orLike('iv_member.mem_tel', $strSearchText, 'both')
                    ->groupEnd();
            }
        } else { // 스트링일시 id, name 검색
            $applierModel
                ->groupStart()
                ->orLike('iv_member.mem_id', $strSearchText, 'both')
                ->orLike('iv_member.mem_name', $strSearchText, 'both')
                ->groupEnd();
        }
        if ($aInterType) { //기업인터뷰,모의인터뷰,인터뷰등
            $applierModel->whereIn('iv_applier.app_type', $aInterType);
        }
        if ($aJobIdx) { // 잡카테고리 
            $applierModel->whereIn('iv_applier.job_idx', $aJobIdx);
        }

        $applierModel
            ->selectorAdminList('comprehensive')->where(['iv_applier.app_iv_stat' => 4])->resumeBuilder()
            ->jobCategoryBuilder()->thumbNailBuilder()->memberBuilder()->orderBy($strOrder, $strOrderType);
        $aList = $applierModel->paginate(10, 'applier');

        foreach ($aList as $key => $val) {
            $aList[$key]['strAppIdx'] = base64url_encode($this->encrypter->encrypt(json_encode($val['appIdx'])));
            $aList[$key]['appType'] = $applierModel->getAppTypeMsg($val['appType']);
            $aList[$key]['address'] = $val['appComprehensive'] ? 'print' : 'detail2';
        }

        $this->aData['data']['search'] = ['text' => $strSearchText];
        $this->aData['data']['order'] = ['column' => $strOrder, 'type' => $strOrderType];
        $this->aData['data']['filter'] = ['jobIdx' => $aJobIdx, 'type' => $aInterType];
        $this->aData['data']['applierList'] = $aList;
        $this->aData['data']['pager'] = $applierModel->pager;
        $this->aData['data']['count'] = $applierModel->pager->getTotal('applier');
        // view
        $this->header();
        $this->nav();
        echo view('prime/interview/comprehensive/list', $this->aData);
        $this->footer();
    }

    public function question()
    {
        $this->commonData();
        $jobCategoryModel = new JobCategoryModel('iv_job_category');

        if (!$aCategory = cache("admin.job.category")) {
            $aCategory = $jobCategoryModel->select(['delyn'])->getJobCategoryAdmin();
            cache()->save("admin.job.category", $aCategory, 86400);
        }

        $aJobsCategory = [];
        foreach ($aCategory as $val) {
            if ($val['job_depth_2'] == null) {
                $aJobsCategory['job_depth_1'][$val['job_depth_1']][] = ['jobName' => $val['job_depth_text'], 'idx' => $val['idx'], 'delyn' => $val['delyn']];
            } else if ($val['job_depth_3'] == null) {
                $aJobsCategory['job_depth_2'][$val['job_depth_1']][$val['job_depth_2']] = ['jobName' => $val['job_depth_text'], 'idx' => $val['idx'], 'delyn' => $val['delyn']];
            } else {
                $aJobsCategory['job_depth_3'][$val['job_depth_1']][$val['job_depth_2']][$val['job_depth_3']] = ['jobName' => $val['job_depth_text'], 'idx' => $val['idx'], 'delyn' => $val['delyn']];
            }
        }

        $this->aData['data']['category'] = $aJobsCategory;

        // view
        $this->header();
        $this->nav();
        echo view('prime/interview/question', $this->aData);
        $this->footer();
    }

    public function mock()
    {
        $this->commonData();
        $companyModel = new CompanyModel();

        $strSearchText = $this->request->getGet('searchText') ?? '';
        $strOrderApply = $this->request->getGet('orderApply') ?? '';

        if ($strSearchText) {
            $companyModel
                ->groupStart() // 키워드
                ->like('iv_company.com_name', $strSearchText, 'both')
                ->orLike('iv_job_category.job_depth_text', $strSearchText, 'both')
                ->groupEnd();
        }

        if ($strOrderApply) {
            $companyModel
                ->orderBy('applierCount', 'DESC');
        }

        $companyModel
            ->getPracticeList()
            ->select([
                'iv_interview.job_idx_position', 'iv_interview_info.idx as infoIdx', 'iv_interview.idx as i_idx',
                'iv_interview.inter_reg_date as interRegDate', 'iv_job_category.job_depth_text'
            ])
            ->select("COUNT(iv_applier.idx) as applierCount", '', false) // 진행중인 공고
            ->join('iv_interview_info', 'iv_interview_info.com_idx = iv_company.idx', 'inner')
            ->join('iv_interview', 'iv_interview.info_idx = iv_interview_info.idx', 'inner')
            ->join('iv_job_category', 'iv_interview_info.job_idx = iv_job_category.idx', 'inner')
            ->join('iv_applier', 'iv_interview.idx = iv_applier.i_idx', 'left')
            ->where(['iv_interview.inter_type' => 'B'])
            ->groupBy('comIdx')
            ->orderBy('i_idx', 'DESC');
        $aMockList = $companyModel->paginate(10, 'practiceList');

        $this->aData['data']['searchText'] = $strSearchText;
        $this->aData['data']['orderApply'] = $strOrderApply;
        $this->aData['data']['mockList'] = $aMockList;
        $this->aData['data']['pager'] = $companyModel->pager;
        $this->aData['data']['count'] = $companyModel->pager->getTotal('practiceList');
        // view
        $this->header();
        $this->nav();
        echo view('prime/interview/mock', $this->aData);
        $this->footer();
    }

    public function mockDeleteAction()
    {
        $this->commonData();

        $aInterIdx = $this->request->getPost('interIdx');
        if (!$aInterIdx) {
            alert_back($this->globalvar->aMsg['error13']);
            exit;
        }

        //트랜잭션 start
        $this->masterDB->transBegin();

        $this->masterDB->table('iv_interview')
            ->set(['delyn' => 'Y'])
            ->set(['inter_del_date' => 'NOW()'], '', false)
            ->whereIn('idx', $aInterIdx)
            ->update();

        // 트랜잭션 end
        if ($this->masterDB->transStatus() === false) {
            $this->masterDB->transRollback();
            alert_back($this->globalvar->aMsg['error3']);
            exit;
        } else {
            $this->masterDB->transCommit();
            alert_back($this->globalvar->aMsg['success1']);
            exit;
        }
    }

    public function mockWrite()
    {
        $this->commonData();
        $companyModel = new CompanyModel();
        $aComList = $companyModel->select(['idx as comIdx', 'com_name as comName'])->where('delyn', 'N')->findAll();

        $this->aData['data']['comList'] = $aComList ?? [];

        // view
        $this->header();
        $this->nav();
        echo view('prime/interview/mock_write', $this->aData);
        $this->footer();
    }

    public function sample()
    {
        $this->commonData();
        $applierModel = new ApplierModel();
        $orderCount = $this->request->getGet('orderCount') ?? '';

        $applierModel->select(['iv_applier.app_reg_date', 'iv_applier.app_count'])->sampleList();

        if ($orderCount) {
            $applierModel->orderBy('iv_applier.app_count', 'DESC');
        }

        $aSampleList = $applierModel->paginate(5, 'sample');

        foreach ($aSampleList as $key => $val) {
            $aSampleList[$key]['repo_analysis'] = json_decode($val['repo_analysis'], true);
        }

        $this->aData['data']['get'] = $orderCount;
        $this->aData['data']['sampleList'] = $aSampleList;
        $this->aData['data']['pager'] = $applierModel->pager;

        // view
        $this->header();
        $this->nav();
        echo view('prime/interview/sample', $this->aData);
        $this->footer();
    }

    public function sampleAction()
    {
        $this->commonData();

        $iApplierIdx = $this->request->getPost('iApplierIdx') ?? '';

        if (!$iApplierIdx) {
            alert_back($this->globalvar->aMsg['error1']);
            exit;
        }

        $result = $this->masterDB->table('iv_question')
            ->set(['app_type' => 'S'])
            ->set(['app_mod_date' => 'NOW()'], '', false)
            ->where(['idx' => $iApplierIdx, 'app_iv_stat' => 4, 'delyn' => 'N'])
            ->update();

        if ($result) {
            alert_back($this->globalvar->aMsg['success1']);
            exit;
        }
        alert_back($this->globalvar->aMsg['error1']);
        exit;
    }
}
