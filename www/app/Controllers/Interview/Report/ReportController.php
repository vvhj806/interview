<?php

namespace App\Controllers\Interview\Report;

use App\Controllers\Interview\WwwController;
use App\Controllers\Interview\My\ChangeController;

use Config\Database;
use Config\Services;

use App\Models\{
    ResumeModel,
    ReportResumeModel,
    ConfigCompnaySuggestModel,
    ReportScoreRankModel,
    JobCategoryModel,
    ReportResultModel,
    ApplierModel,
    MbtiScoreModel
};
use App\Libraries\GlobalvarLib;

class ReportController extends WwwController
{
    private $encrypter;

    public function index()
    {
        $this->list();
    }

    private function test()
    {
        $this->commonData();


        $applierModel = new ApplierModel;
        exit;

        $test = $applierModel->getGrade();

        $aGradeTemp = [];

        foreach ($test as $key => $val) {
            $test[$key]['repo_analysis'] = json_decode($val['repo_analysis'], true);
            $test[$key]['repo_analysis'] = $test[$key]['repo_analysis']['grade'];

            $jobDepth = $test[$key]['job_depth_1'];
            $grade = $test[$key]['repo_analysis'];

            $aGradeTemp[$jobDepth][$grade] = 0;
            $aGradeTemp['Total'][$grade] = 0;
        }

        foreach ($test as $key => $val) {
            $jobDepth = $test[$key]['job_depth_1'];
            $grade = $test[$key]['repo_analysis'];

            ++$aGradeTemp[$jobDepth][$grade];
            ++$aGradeTemp['Total'][$grade];
        }

        //트랜잭션 start
        $this->masterDB->transBegin();
        foreach ($aGradeTemp as $rankType => $aValue) {
            if ($rankType === 'Total') {
                foreach ($aValue as $grade => $countMember) {
                    $this->masterDB->table('set_report_score_rank')
                        ->set([
                            'score_rank_count_member' => $countMember
                        ])
                        ->set(['score_rank_reg_date' => 'NOW()'], '', false)
                        ->where([
                            'score_rank_type' => 'T',
                            'score_rank_grade' => $grade,
                        ])
                        ->update();
                }
            } else {
                foreach ($aValue as $grade => $countMember) {
                    $this->masterDB->table('set_report_score_rank')
                        ->set([
                            'score_rank_count_member' => $countMember
                        ])
                        ->set(['score_rank_reg_date' => 'NOW()'], '', false)
                        ->where([
                            'score_rank_type' => 'C',
                            'job_depth_1' => $rankType,
                            'score_rank_grade' => $grade,
                        ])
                        ->update();
                }
            }
        }

        // 트랜잭션 end
        if ($this->masterDB->transStatus() === false) {
            $this->masterDB->transRollback();
            return alert_back($this->globalvar->aMsg['error3']);
        } else {
            $this->masterDB->transCommit();
            alert_back($this->globalvar->aMsg['success4']);
            exit;
        }

        $this->header();
        exit;
    }

    public function list()
    {
        // data init
        $this->commonData();
        $this->encrypter = Services::encrypter();
        $iAppCount = 0;
        $iSuggestCount = 0;

        $iMemberIdx = $this->aData['data']['session']['idx'] ?? 0;

        if ($iMemberIdx && ($this->aData['data']['session']['type'] === 'M')) { // 로그인되어야함
            $strType = $this->request->getGet('type') ?? 'all';
            $applierModel = new ApplierModel();
            $configCompnaySuggestModel = new ConfigCompnaySuggestModel();
            $allCount = $applierModel->getApplierAllList($iMemberIdx, '', '', 3)->countAllResults() ?? 0;
            $openCount = $applierModel->getComprehensiveList($iMemberIdx)->countAllResults() ?? 0;
            $aJobIdx = $applierModel
                ->select('job_idx')
                ->getShareJobIdx($iMemberIdx)
                ->findColumn('job_idx'); // 본인 인터뷰 중 공개한것 job_idx가져옴

            if ($strType === 'all') { // 전체 리포트
                $strReportType = $this->request->getGet('reportType') ?? 'all';
                $strReportSort = $this->request->getGet('reportSort') ?? 'date';

                if (in_array($strReportType, ['all', '0', '1', 'company']) && in_array($strReportSort, ['date', 'max', 'min'])) {
                } else {
                    alert_back($this->globalvar->aMsg['error1']);
                    exit;
                }
                $applierModel
                    ->getApplierAllList($iMemberIdx, $strReportType, $strReportSort, 3);
                $aReport = $applierModel->paginate(5, 'report');

                $reportResultModel = new ReportResultModel();
                $countReport = $reportResultModel->getReportPoint($iMemberIdx);

                foreach ($countReport as $val) {
                    $aRepoPoints[] = $val['repo_analysis']['sum'] ?? 0;
                }

                foreach ($aReport as $key => $val) {
                    $aReport[$key]['repo_analysis'] = json_decode($val['repo_analysis'], true);
                    $aReport[$key]['repo_analysis'] = $aReport[$key]['repo_analysis']['grade'] ?? '';
                    $aReport[$key]['queCount'] = $reportResultModel->getQueCount($val['idx']);
                    $aReport[$key]['idx'] = base64url_encode($this->encrypter->encrypt(json_encode($val['idx'])));
                }
            } else if ($strType === 'open') { // 공개중인 리포트
                $applierModel
                    ->getComprehensiveList($iMemberIdx)
                    ->select(['count(config_company_suggest.idx) as suggest'], '', false)->select(['config_company_suggest.idx as sugIdx'])
                    ->join('config_company_suggest', 'iv_applier.idx = config_company_suggest.app_idx', 'left')
                    ->groupBy('iv_applier.idx');
                $aReport = $applierModel->paginate(5, 'report');

                foreach ($aReport as $key => $val) {
                    $aReport[$key]['repo_analysis'] = json_decode($val['repo_analysis'], true);
                    $aReport[$key]['repo_analysis'] = $aReport[$key]['repo_analysis']['grade'] ?? '';
                    $aReport[$key]['idx'] = base64url_encode($this->encrypter->encrypt(json_encode($val['idx'])));
                    $aReport[$key]['sugIdx'] = base64url_encode($this->encrypter->encrypt(json_encode($val['sugIdx'])));
                }

                $iAppCount = $applierModel
                    ->where([
                        'iv_applier.app_share' => '1', 'iv_applier.delyn' => 'N',
                        'iv_applier.app_iv_stat >=' => '4', 'iv_applier.mem_idx' => $iMemberIdx
                    ])
                    ->findColumn('app_count');
                if ($iAppCount) {
                    $iAppCount = array_sum($iAppCount);
                }

                $iSuggestCount = $configCompnaySuggestModel
                    ->where([
                        'delyn' => 'N',
                        'mem_idx' => $iMemberIdx
                    ])
                    ->countAllResults();
            } else {
                alert_back($this->globalvar->aMsg['error1']);
                exit;
            }
        } else { //비로그인
            return $this->sample();
        }

        $this->aData['data']['jobIdx'] = $aJobIdx ?? [];
        $this->aData['data']['appCount'] = $iAppCount;
        $this->aData['data']['suggestCount'] = $iSuggestCount;
        $this->aData['data']['reportType'] = $strReportType ?? '';
        $this->aData['data']['reportSort'] = $strReportSort ?? '';
        $this->aData['data']['points'] = $aRepoPoints ?? [];
        $this->aData['data']['pager'] = $applierModel->pager;
        $this->aData['data']['list'] = $aReport;
        $this->aData['data']['allCount'] = $allCount;
        $this->aData['data']['openCount'] = $openCount;
        $this->aData['data']['type'] = $strType;
        $this->header();
        echo view("www/report/reportList", $this->aData);
        $this->footer(['report']);
    }

    public function applierDeleteAction()
    {
        // data init
        $this->commonData();

        $this->header();

        if (!$this->aData['data']['session']['id']) {
            return redirect($this->globalvar->getlogin());
        }
        $strApplierIdx = $this->request->getPost('deleteIdx') ?? false;
        $this->encrypter = Services::encrypter();

        $applierModel = new ApplierModel;
        if ($strApplierIdx) {

            $iApplierIdx = $this->encrypter->decrypt(base64url_decode($strApplierIdx));
            $iApplierIdx = str_replace('"', '', $iApplierIdx);

            if ($applierModel->chkMine($iApplierIdx, $this->aData['data']['session']['idx'])) {
                //트랜잭션 start
                $this->masterDB->transBegin();

                $this->masterDB->table('iv_applier')
                    ->set('delyn', 'Y')
                    ->set(['app_del_date' => 'NOW()'], '', false)
                    ->where([
                        'idx' => $iApplierIdx,
                        'delyn' => 'N'
                    ])
                    ->update();

                $this->masterDB->table('iv_report_result')
                    ->set('delyn', 'Y')
                    ->set(['repo_del_date' => 'NOW()'], '', false)
                    ->where([
                        'applier_idx' => $iApplierIdx,
                        'delyn' => 'N'
                    ])
                    ->update();
                // 트랜잭션 end
                if ($this->masterDB->transStatus() === false) {
                    $this->masterDB->transRollback();
                    return alert_back($this->globalvar->aMsg['error3']);
                } else {
                    $this->masterDB->transCommit();
                    alert_back($this->globalvar->aMsg['success2']);
                    exit;
                }
            }
        }
        alert_back($this->globalvar->aMsg['error1']);
        exit;
    }

    public function applierUpdateAction()
    {
        // data init
        $this->commonData();

        $this->header();
        if (!$this->aData['data']['session']['id']) {
            return redirect($this->globalvar->getlogin());
        }
        $strApplierIdx = $this->request->getPost('updateIdxMain') ?? false;

        $this->encrypter = Services::encrypter();
        $applierModel = new ApplierModel;

        if ($strApplierIdx) {

            $iApplierIdx = $this->encrypter->decrypt(base64url_decode($strApplierIdx));
            $iApplierIdx = str_replace('"', '', $iApplierIdx);

            if ($applierModel->chkApplier($iApplierIdx, $this->aData['data']['session']['idx'])) {
                $this->masterDB->table('iv_applier')
                    ->set('app_comprehensive', 0)
                    ->where([
                        'idx' => $iApplierIdx,
                        'delyn' => 'N'
                    ])
                    ->update();
                alert_url($this->globalvar->aMsg['success4'], '/report?type=open');
                exit;
            }
        }
        alert_back($this->globalvar->aMsg['error1']);
        exit;
    }

    public function applierShare()
    {
        // data init
        $this->commonData();

        if (!$this->aData['data']['session']['id']) {
            return redirect($this->globalvar->getlogin());
        }
        $strApplierIdx = $this->request->getGet('report') ?? false;

        $applierModel = new ApplierModel();
        $this->encrypter = Services::encrypter();

        if ($strApplierIdx) {
            $iApplierIdx = $this->encrypter->decrypt(base64url_decode($strApplierIdx));
            $iApplierIdx = str_replace('"', '', $iApplierIdx);

            if ($applierModel->chkApplier($iApplierIdx, $this->aData['data']['session']['idx'])) {
                $iQueCount = 0;
                $aReport = $applierModel
                    ->getDetail($iApplierIdx)
                    ->select(['res_idx', 'res_title', 'res_reg_date', 'iv_applier.app_type'])
                    ->join('iv_resume', 'iv_applier.res_idx = iv_resume.idx AND iv_resume.delyn="N"', 'left')
                    ->findAll();

                foreach ($aReport as $key => $val) {
                    $aReport[$key]['idx'] = base64url_encode($this->encrypter->encrypt(json_encode($val['idx'])));
                    if ($val['res_idx']) {
                        $aReport[$key]['resume_idx'] = preg_replace('/[\@\.\;\" "]+/', '', json_encode($val['res_idx']));
                        $aReport[$key]['res_idx'] = base64url_encode($this->encrypter->encrypt(json_encode($val['res_idx'])));
                    }
                    $aReport[$key]['app_share_text'] = $val['app_share']  ? "공개" : "비공개";

                    if (isset($val['res_reg_date'])) {
                        $aReport[$key]['res_reg_date'] = date('Y.m.d', strtotime($val['res_reg_date']));
                    }
                    if ($val['que_type'] === 'T') {
                        $aReport[$key]['repo_analysis'] = json_decode($val['repo_analysis'], true);
                        $aReport = $aReport[$key];
                        unset($aReport[$key]);
                    } else {
                        ++$iQueCount;
                        unset($aReport[$key]);
                    }
                }
            } else {
                alert_back($this->globalvar->aMsg['error1']);
                exit;
            }
        }

        $jobCategoryModel = new JobCategoryModel('iv_job_category');
        $job = $jobCategoryModel->getJobCategory();
        $reportChange = new ChangeController();

        $this->aData['data']['queCount'] = $iQueCount ?? 0;
        $this->aData['data']['report'] = $aReport ?? [];
        $this->aData['data']['jobs'] = $job ?? [];
        $this->aData['data']['appIdx'] = $strApplierIdx ?? '';

        $this->header();
        echo view("www/report/reportShare", $this->aData);
        $reportChange->index('report', $this->aData, $strApplierIdx);
        $reportChange->index('resume', $this->aData, $strApplierIdx);
        $this->footer(['quick']);
    }

    public function comprehensiveShare()
    {
        // data init
        $this->commonData();

        $strApplierIdx = $this->request->getGet('report') ?? false;

        $applierModel = new ApplierModel();
        $this->encrypter = Services::encrypter();

        if ($strApplierIdx) {
            $iApplierIdx = $this->encrypter->decrypt(base64url_decode($strApplierIdx));
            $iApplierIdx = str_replace('"', '', $iApplierIdx);

            if ($applierModel->chkApplier($iApplierIdx, $this->aData['data']['session']['idx'])) {
                $iQueCount = 0;
                $aReport = $applierModel
                    ->getDetail($iApplierIdx)
                    ->select(['res_idx', 'res_title', 'res_reg_date', 'iv_applier.app_type'])
                    ->join('iv_resume', 'iv_applier.res_idx = iv_resume.idx AND iv_resume.delyn="N"', 'left')
                    ->findAll();

                foreach ($aReport as $key => $val) {
                    $aReport[$key]['idx'] = base64url_encode($this->encrypter->encrypt(json_encode($val['idx'])));
                    $aReport[$key]['res_idx'] = base64url_encode($this->encrypter->encrypt(json_encode($val['res_idx'])));
                    $aReport[$key]['app_share_text'] = $val['app_share']  ? lang('Sample.Public') : lang('Sample.Private');

                    if (isset($val['res_reg_date'])) {
                        $aReport[$key]['res_reg_date'] = date('Y.m.d', strtotime($val['res_reg_date']));
                    }
                    if ($val['que_type'] === 'T') {
                        $aReport[$key]['repo_analysis'] = json_decode($val['repo_analysis'], true);
                        $aReport = $aReport[$key];
                        unset($aReport[$key]);
                    } else {
                        ++$iQueCount;
                        unset($aReport[$key]);
                    }
                }
            } else {
                alert_back($this->globalvar->aMsg['error1']);
                exit;
            }
        } else {
            alert_back($this->globalvar->aMsg['error1']);
            exit;
        }

        $jobCategoryModel = new JobCategoryModel('iv_job_category');
        $job = $jobCategoryModel->getJobCategory();

        $this->aData['data']['queCount'] = $iQueCount ?? 0;
        $this->aData['data']['report'] = $aReport ?? [];
        $this->aData['data']['jobs'] = $job ?? [];

        $this->header();
        echo view("www/report/comprehensiveShare", $this->aData);
        $this->footer(['quick']);
    }

    public function applierShareAction(string $strType)
    {
        // data init
        $this->commonData();

        if (!$this->aData['data']['session']['id']) {
            return redirect($this->globalvar->getlogin());
        }

        $strApplierIdx = $this->request->getPost('updateIdx') ?? false;
        $strShareType = $this->request->getPost('share') ?? null;
        $strShareCompanyType = $this->request->getPost('shareCompany') ?? 'off';
        $strResumeIdx = $this->request->getPost('resume') ?? null;
        $iMemberIdx = $this->aData['data']['session']['idx'];

        $applierModel = new ApplierModel;
        $this->encrypter = Services::encrypter();

        if ($strApplierIdx) {

            $iApplierIdx = $this->encrypter->decrypt(base64url_decode($strApplierIdx));
            $iApplierIdx = str_replace('"', '', $iApplierIdx);

            $iResumeIdx = null;
            if ($strResumeIdx) {
                $iResumeIdx = $this->encrypter->decrypt(base64url_decode($strResumeIdx));
                $iResumeIdx = str_replace('"', '', $iResumeIdx);
            }

            if ($applierModel->chkApplier($iApplierIdx, $iMemberIdx)) {
                $aChk = ['on' => '1',  'off' => '0'];
                $aChk2 = ['off' => '0', 'half' => '1', 'all' => '2'];

                $iShareType = $aChk[$strShareType] ?? false;
                $iShareCompanyType = $aChk2[$strShareCompanyType] ?? false;

                //트랜잭션 start
                $this->masterDB->transBegin();

                $readyDB = $this->masterDB->table('iv_applier')
                    ->set(['app_mod_date' => 'NOW()'], '', false)
                    ->where([
                        'idx' => $iApplierIdx,
                        'app_type' => 'M',
                        'delyn' => 'N'
                    ]);
                if ($strType === "report") {
                    $readyDB->set(['res_idx' => $iResumeIdx, 'app_comprehensive' => 1])->update();
                } else if ($strType === "comprehensive") {
                    if ($iShareType && $iShareCompanyType) {
                        $readyDB
                            ->set(['app_share' => $iShareType, 'app_share_company' => $iShareCompanyType])->where(['app_comprehensive' => 1])->update();
                    }
                    $iJobIdx = $applierModel->select('job_idx')->where(['idx' => $iApplierIdx, 'delyn' => 'N'])->first();
                    if ($applierModel->getJobIdx($iApplierIdx, $iMemberIdx, $iJobIdx['job_idx'])) { // 내 레포트중 job idx가 같은 레포트는 비공개 전환
                        $this->masterDB->table('iv_applier')
                            ->set([
                                'app_share' => 0,
                                'app_share_company' => 0
                            ])
                            ->set(['app_mod_date' => 'NOW()'], '', false)
                            ->where([
                                'mem_idx' => $iMemberIdx,
                                'job_idx' => $iJobIdx,
                                'app_type' => 'M',
                                'delyn' => 'N'
                            ])
                            ->update();
                    }
                }

                // 트랜잭션 end
                if ($this->masterDB->transStatus() === false) {
                    $this->masterDB->transRollback();
                    return alert_back($this->globalvar->aMsg['error3']);
                } else {
                    $this->masterDB->transCommit();
                    alert_url($this->globalvar->aMsg['success4'], "/report?type=open");
                    exit;
                }
            }
        }
        alert_back($this->globalvar->aMsg['error1']);
        exit;
    }

    public function sample()
    {
        $this->header();
        echo view("www/report/sample", $this->aData);
        $this->footer(['report']);
    }

    public function detail($strApplierIdx)
    {
        // data init
        $this->commonData();
        $this->encrypter = Services::encrypter();
        $globalvar = new GlobalvarLib();
        $session = session();
        $iStypeCount = 0;

        $iApplierIdx = $this->encrypter->decrypt(base64url_decode($strApplierIdx));
        $iApplierIdx = str_replace('"', '', $iApplierIdx);

        $applierModel = new ApplierModel();
        $chkMine = false;
        if ($this->aData['data']['session']['id']) {
            $chkMine = $applierModel->chkApplier($iApplierIdx, $this->aData['data']['session']['idx']);
            $memName = $this->aData['data']['session']['name'];
        }
        $chkManager = $session->get('mem_ex_4');

        if ($chkMine || $applierModel->chkApplierShare($iApplierIdx) || in_array($this->aData['data']['session']['type'], ['C', 'A'])  || $chkManager == 'M') {
        } else {
            $_SESSION['backLogin'] = uri_string();

            $gs = $this->request->getGet('gs');
            if ($gs == 'm') {
            } else {
                alert_url($globalvar->aMsg['error11'], "/login");
                exit;
            }
        }

        $aReport = $applierModel
            ->getDetail($iApplierIdx)
            ->select([
                'iv_video.video_record',
                'iv_question.que_question',
                'iv_report_result.repo_speech_txt_detail',
                'iv_report_result.repo_syntaxnet_tree'
            ])
            ->join('iv_video', 'iv_report_result.idx = iv_video.repo_res_idx', 'inner')
            ->join('iv_question', 'iv_video.que_idx = iv_question.idx', 'inner')
            ->where(['iv_report_result.que_type' => 'S',])
            ->findAll();

        $aReport[] = $applierModel
            ->getDetail($iApplierIdx)
            ->select(['iv_member.mem_name as memName', 'iv_applier.app_share_company as appShareCom'])
            ->join('iv_member', 'iv_member.idx = iv_applier.mem_idx', 'left')
            ->where(['iv_report_result.que_type' => 'T'])
            ->first();

        foreach ($aReport as $val) {
            $aTempT = []; // score 필터 돌린것
            if ($val['que_type'] === 'T') {
                $aScoreT = json_decode($val['repo_score'], true);
                $aAnalysisT = json_decode($val['repo_analysis'], true);
                $aAnalysisT['sum'] = round($aAnalysisT['sum'], 2);

                if (!$chkMine) {
                    $memName = $val['appShareCom'] == 2 ? $val['memName'] : '비공개'; // 본인것인지 체크
                }
                if ($gs ?? false == 'm') {
                    $memName = $val['memName'];
                }

                $strFileSaveName = $val['file_save_name'];

                foreach ($aScoreT as $k => $v) {
                    if (in_array($k, ['age', 'gender', 'hair_length', 'glasses', 'skin', 'beard'])) {
                        continue;
                    } else {
                        $aTempT[$k] = $v;
                    }
                }
                if ($val['job_depth_1'] == '' || $val['job_depth_1'] == null) {
                } else {
                    if (!$reportScoreRank = cache("report.score.{$val['job_depth_1']}")) { // 지원자들 랭크 받아옴
                        $reportScoreRankModel = new ReportScoreRankModel();
                        $reportScoreRank = $reportScoreRankModel->getScoreInfo($val['job_depth_1']);
                        cache()->save("report.score.{$val['job_depth_1']}", $reportScoreRank, 600);
                    }

                    foreach ($reportScoreRank as $v) {
                        if ($v['score_rank_type'] === 'T') {
                            unset($v['score_rank_type']);
                            $reportScoreRankT[] = $v;
                        } else {
                            unset($v['score_rank_type']);
                            $reportScoreRankC[] = $v;
                        }
                    }
                }
            } else if ($val['que_type'] === 'S') {
                $aScoreS = json_decode($val['repo_score'], true);
                $aAnalysisS = json_decode($val['repo_analysis'], true);

                $aAnalysisS['sum'] = round($aAnalysisS['sum'], 2);

                $this->aData['data']['S'][$iStypeCount]['speech'] = json_decode($val['repo_speech_txt_detail'], true) ?? [];
                $this->aData['data']['S'][$iStypeCount]['video'] = $val['video_record'] ?? '';
                $this->aData['data']['S'][$iStypeCount]['question'] = $val['que_question'] ?? '';
                $this->aData['data']['S'][$iStypeCount]['score'] = $aScoreS ?? [];
                $this->aData['data']['S'][$iStypeCount]['analysis'] = $aAnalysisS ?? [];
                $this->aData['data']['S'][$iStypeCount]['syntaxnet'] = json_decode($val['repo_syntaxnet_tree'], true) ?? [];
                ++$iStypeCount;
            }
        }

        $this->aData['data']['T']['reportScoreRank']['T'] = $reportScoreRankT ?? [];
        $this->aData['data']['T']['reportScoreRank']['C'] = $reportScoreRankC ?? [];
        $this->aData['data']['T']['temp'] = $aTempT ?? [];
        $this->aData['data']['T']['score'] = $aScoreT ?? [];
        $this->aData['data']['T']['analysis'] = $aAnalysisT ?? [];
        $this->aData['data']['memName'] = $memName;
        $this->aData['data']['job'] = $aReport[0]['job_depth_text'] ?? '';
        $this->aData['data']['fileSaveName'] = $strFileSaveName ?? '';
        $this->aData['data']['mine'] = $chkMine;
        $this->header();
        echo view("www/report/reportDetail", $this->aData);
    }

    public function detail2($strApplierIdx)
    {
        // data init
        $this->commonData();
        $this->encrypter = Services::encrypter();
        $globalvar = new GlobalvarLib();
        $session = session();
        $iStypeCount = 0;

        $iApplierIdx = $this->encrypter->decrypt(base64url_decode($strApplierIdx));
        $iApplierIdx = str_replace('"', '', $iApplierIdx);

        // model
        $applierModel = new ApplierModel();
        $resumeModel = new ResumeModel();
        $reportResultModel = new ReportResultModel();

        $chkMine = false;
        if ($this->aData['data']['session']['id']) {
            $chkMine = $applierModel->chkApplier($iApplierIdx, $this->aData['data']['session']['idx']);
            $memName = $this->aData['data']['session']['name'];
        }
        $chkManager = $session->get('mem_ex_4');

        if ($chkMine || $applierModel->chkApplierShare($iApplierIdx) || $this->aData['data']['session']['type'] == 'C' || $chkManager == 'M') {
        } else {
            $_SESSION['backLogin'] = uri_string();
            $gs = $this->request->getGet('gs');
            if ($gs == 'm') {
            } else {
                alert_url($globalvar->aMsg['error11'], "/login");
                exit;
            }
        }

        //역량분석 (평균점수 구하기)
        $aReportAvg = $applierModel->getAllDetail()->findAll();
        $totalActivity = $totalAlacrity = $totalStability = $totalWillpower = $totalAttraction = $totalAffirmative = $totalReliability = $totalAggressiveness = 0;
        $totalCnt = count($aReportAvg);

        foreach ($aReportAvg as $avgVal) {
            $aAvgAnalysis = json_decode($avgVal['repo_analysis'], true);

            //능동성
            $activity = $aAvgAnalysis['activity'] ?? 0;
            $totalActivity += (int)$activity;
            //대응성
            $alacrity = $aAvgAnalysis['alacrity'] ?? 0;
            $totalAlacrity += (int)$alacrity;
            //안정성
            $stability = $aAvgAnalysis['stability'] ?? 0;
            $totalStability += (int)$stability;
            //의지력
            $willpower = $aAvgAnalysis['willpower'] ?? 0;
            $totalWillpower += (int)$willpower;
            //매력도
            $attraction = $aAvgAnalysis['attraction'] ?? 0;
            $totalAttraction += (int)$attraction;
            //긍정성
            $affirmative = $aAvgAnalysis['affirmative'] ?? 0;
            $totalAffirmative += (int)$affirmative;
            //신뢰성
            $reliability = $aAvgAnalysis['reliability'] ?? 0;
            $totalReliability += (int)$reliability;
            //적극성
            $aggressiveness = $aAvgAnalysis['aggressiveness'] ?? 0;
            $totalAggressiveness += (int)$aggressiveness;
        }

        $aAvgCapacity = array();
        array_push($aAvgCapacity, array(
            'activity' => round($totalActivity / $totalCnt, 2),
            'alacrity' => round($totalAlacrity / $totalCnt, 2),
            'stability' => round($totalStability / $totalCnt, 2),
            'willpower' => round($totalWillpower / $totalCnt, 2),
            'attraction' => round($totalAttraction / $totalCnt, 2),
            'affirmative' => round($totalAffirmative / $totalCnt, 2),
            'reliability' => round($totalReliability / $totalCnt, 2),
            'aggressiveness' => round($totalAggressiveness / $totalCnt, 2)
        ));

        $aReport = $applierModel
            ->getDetail($iApplierIdx)
            ->select([
                'iv_video.video_record',
                'iv_question.que_question',
                'iv_question.que_best_answer',
                'iv_report_result.repo_speech_txt_detail',
                'iv_report_result.repo_audio_detail',
                'iv_report_result.repo_syntaxnet_tree',
            ])
            ->join('iv_video', 'iv_report_result.idx = iv_video.repo_res_idx', 'inner')
            ->join('iv_question', 'iv_video.que_idx = iv_question.idx', 'inner')
            ->where(['iv_report_result.que_type' => 'S',])
            ->findAll();


        $aReport[] = $applierModel
            ->getDetail($iApplierIdx)
            ->select([
                'iv_member.mem_name as memName', 'iv_member.mem_mbti as memMbti',
                'iv_applier.app_share_company as appShareCom', 'iv_applier.app_type as appType', 'iv_job_category.idx as jobIdx'
            ])
            ->join('iv_member', 'iv_member.idx = iv_applier.mem_idx', 'left')
            ->where(['iv_report_result.que_type' => 'T'])
            ->first();

        // 날짜,시간 구하기
        $regDates = $aReport[0]['app_reg_date'];
        $regDates = explode(' ', $regDates);
        $regDate = $regDates[0];
        $regTime = $regDates[1];

        $regDate = explode('-', $regDate);
        $regYear = $regDate[0];
        $regMonth = $regDate[1];
        $regDay = $regDate[2];

        $dateDay = $regYear . '년 ' . $regMonth . '월 ' . $regDay . '일';
        $dateTime = date('A h:i', strtotime($regTime));

        foreach ($aReport as $val) {
            $aTempT = []; // score 필터 돌린것
            if ($val['que_type'] === 'T') {
                $aScoreT = json_decode($val['repo_score'], true);
                $aAnalysisT = json_decode($val['repo_analysis'], true);
                $aAnalysisT['sum'] = round($aAnalysisT['sum'], 2);
                $strMemMbti = $val['memMbti'];
                $strAppType = $val['appType'];
                $iJobIdx = $val['jobIdx'];

                if (!$chkMine) {
                    // $memName = $val['appShareCom'] == 2 ? $val['memName'] : lang('Sample.Private'); // 본인것인지 체크
                    $memName = $val['appShareCom'] == 2 ? $val['memName'] : '비공개'; // 본인것인지 체크
                }

                if ($gs ?? false == 'm') {
                    $memName = $val['memName'];
                }

                $strFileSaveName = $val['file_save_name'];

                foreach ($aScoreT as $k => $v) {
                    if (in_array($k, ['age', 'gender', 'hair_length', 'glasses', 'skin', 'beard'])) {
                        continue;
                    } else {
                        $aTempT[$k] = $v;
                    }
                }
                if ($val['job_depth_1'] == '' || $val['job_depth_1'] == null) {
                } else {
                    if (!$reportScoreRank = cache("report.score.{$val['job_depth_1']}")) { // 지원자들 랭크 받아옴
                        $reportScoreRankModel = new ReportScoreRankModel();
                        $reportScoreRank = $reportScoreRankModel->getScoreInfo($val['job_depth_1']);
                        cache()->save("report.score.{$val['job_depth_1']}", $reportScoreRank, 600);
                    }

                    foreach ($reportScoreRank as $v) {
                        if ($v['score_rank_type'] === 'T') {
                            unset($v['score_rank_type']);
                            $reportScoreRankT[] = $v;
                        } else {
                            unset($v['score_rank_type']);
                            $reportScoreRankC[] = $v;
                        }
                    }
                }
            } else if ($val['que_type'] === 'S') {
                $aScoreS = json_decode($val['repo_score'], true);
                $aAnalysisS = json_decode($val['repo_analysis'], true);

                $aAudioS = json_decode($val['repo_audio_detail'], true) ?? [];

                $aAnalysisS['sum'] = round($aAnalysisS['sum'], 2);
                $this->aData['data']['S'][$iStypeCount]['audio'] = $aAudioS;
                $this->aData['data']['S'][$iStypeCount]['speech'] = json_decode($val['repo_speech_txt_detail'], true);
                $this->aData['data']['S'][$iStypeCount]['video'] = $val['video_record'] ?? '';
                $this->aData['data']['S'][$iStypeCount]['question'] = $val['que_question'] ?? '';
                $this->aData['data']['S'][$iStypeCount]['queBestAnswer'] = $val['que_best_answer'] ?? '';
                $this->aData['data']['S'][$iStypeCount]['score'] = $aScoreS ?? [];
                $this->aData['data']['S'][$iStypeCount]['analysis'] = $aAnalysisS ?? [];
                $this->aData['data']['S'][$iStypeCount]['syntaxnet'] = json_decode($val['repo_syntaxnet_tree'], true) ?? [];
                ++$iStypeCount;
            }
        }

        //응답 신뢰도
        if ($aScoreT['sincerity'] >= 1 && $aScoreT['sincerity'] <= 3) {
            $response = '낮음';
        } else if ($aScoreT['sincerity'] >= 4 && $aScoreT['sincerity'] <= 6) {
            $response = '보통';
        } else if ($aScoreT['sincerity'] >= 7) {
            $response = '높음';
        } else {
            $response = '분석불가';
        }

        //표정분석-본인점수
        $quiver = $aScoreT["quiver"];   //음성떨림
        $volume = $aScoreT["volume"];   //음성크기
        $tone = $aScoreT["tone"];   //목소리톤
        $speed = $aScoreT["speed"];   //음성속도
        $diction = $aScoreT["diction"];   //발음정확도
        $eyes = $aScoreT["eyes"];   //시선처리
        $blink = $aScoreT["blink"];   //눈깜빡임
        $gesture = $aScoreT["gesture"];   //제스처빈도
        $head_motion = $aScoreT["head_motion"];   //머리움직임
        $glow = $aScoreT["glow"];   //홍조현상

        $realScore = $this->getRealScore($speed, $quiver, $glow, $head_motion, $blink);
        $confidence = ((int)$realScore[0]['quiver'] + (int)$volume + (int)$tone + (int)$realScore[0]['speed']) / 4; //자신감
        $Attitude = ((int)$realScore[0]['head_motion'] + (int)$gesture) / 2; //태도

        $facial_analysis = array();
        array_push($facial_analysis, array('complexion' => $glow * 10, 'blinking' => $blink * 10, 'pronunciation' => $diction * 10, 'eye_contact' => $eyes * 10, 'confidence' => $confidence * 10, 'Attitude' => $Attitude * 10));

        //표정분석-평균점수
        $complexion = $blinking = $pronunciation = $eye_contact = $confidence = $Attitude = 0;
        $facial_total = 0;

        $getAllgetfacialAnalysis = $reportResultModel->getAllgetfacialAnalysis();
        foreach ($getAllgetfacialAnalysis as $facialKey => $facialVal) {
            $facialAnalysisAvg = json_decode($getAllgetfacialAnalysis[$facialKey]['repo_score'], true);

            $quiver = $facialAnalysisAvg["quiver"] ?? 0;   //음성떨림
            $volume = $facialAnalysisAvg["volume"] ?? 0;   //음성크기
            $tone = $facialAnalysisAvg["tone"] ?? 0;   //목소리톤
            $speed = $facialAnalysisAvg["speed"] ?? 0;   //음성속도
            $diction = $facialAnalysisAvg["diction"] ?? 0;   //발음정확도
            $eyes = $facialAnalysisAvg["eyes"] ?? 0;   //시선처리
            $blink = $facialAnalysisAvg["blink"] ?? 0;   //눈깜빡임
            $gesture = $facialAnalysisAvg["gesture"] ?? 0;   //제스처빈도
            $head_motion = $facialAnalysisAvg["head_motion"] ?? 0;   //머리움직임
            $glow = $facialAnalysisAvg["glow"] ?? 0;   //홍조현상

            $realScore = $this->getRealScore($speed, $quiver, $glow, $head_motion, $blink);
            $confidence_cate = ((int)$realScore[0]['quiver'] + (int)$volume + (int)$tone + (int)$realScore[0]['speed']) / 4; //자신감
            $Attitude_cate = ((int)$realScore[0]['head_motion'] + (int)$gesture) / 2; //태도

            $complexion += (int)$glow;   //안색
            $blinking += (int)$blink;    //눈깜빡임
            $pronunciation += (int)$diction; //발음정확도
            $eye_contact += (int)$eyes; //시선마주침
            $confidence += (int)$confidence_cate;   //자신감
            $Attitude += (int)$Attitude_cate;   //태도
            $facial_total++;
        }

        $facial_result = array();
        array_push($facial_result, array(
            'complexion' => round($complexion / $facial_total, 1) * 10,
            'blinking' => round($blinking / $facial_total, 1) * 10,
            'pronunciation' => round($pronunciation / $facial_total, 1) * 10,
            'eye_contact' => round($eye_contact / $facial_total, 1) * 10,
            'confidence' => round($confidence / $facial_total, 1) * 10,
            'Attitude' => round($Attitude / $facial_total, 1) * 10,
        ));

        $checkHaveResume = $applierModel->checkHaveResume($iApplierIdx)->first();

        $reportResume = new ReportResumeModel();
        $getJobcategory = $reportResume->getJobcategory($iApplierIdx);

        //iv_applier에 app_share랑 comprehensive는 값이 0이 아니고 res_idx가 있으면 
        if (!empty($checkHaveResume['res_idx']) && !empty($getJobcategory['idx'])) {
            //이력서 레포트
            $resumeReport = $this->resumeReport($iApplierIdx);
            $this->aData['data']['resume'] = $resumeReport;

            //이력서 내 SPEC 점수 구하기
            $getResumeScore = $resumeModel->select('res_analysis');
            $getResumeScore = $resumeModel->getResumeScore($iApplierIdx)->first();

            $eduScore = json_decode($getResumeScore['res_analysis'])->edu->score;
            $careerScore = json_decode($getResumeScore['res_analysis'])->career->score;
            $languageScore = json_decode($getResumeScore['res_analysis'])->language->score;
            $licenseScore = json_decode($getResumeScore['res_analysis'])->license->score;

            $aScoreArr = array();
            array_push($aScoreArr, array('edu' => number_format($eduScore, 2), 'career' => $careerScore, 'language' => $languageScore, 'license' => $licenseScore));

            //이력서 평균 SPEC 점수 구하기
            $getResumeSpecAvg = $resumeModel->getResumeSpecAvg($iApplierIdx);

            $iAvgCnt = count($getResumeSpecAvg);
            $totEduScore = 0;
            $totCareerScore = 0;
            $totLanguageScore = 0;
            $totLicenseScore = 0;
            $avgArr = [];
            $i = 0;
            foreach ($getResumeSpecAvg as $val) {
                $totEduScore += (float)json_decode($val->res_analysis)->edu->score;
                $totCareerScore += (float)json_decode($val->res_analysis)->career->score;
                $totLanguageScore += (float)json_decode($val->res_analysis)->language->score;
                $totLicenseScore += (float)json_decode($val->res_analysis)->license->score;

                $avgArr['edu'][$i] = number_format((float)json_decode($val->res_analysis)->edu->score, 2) ?? 0;
                $avgArr['career'][$i] = number_format((float)json_decode($val->res_analysis)->career->score, 2) ?? 0;
                $avgArr['language'][$i] = number_format((float)json_decode($val->res_analysis)->language->score, 2) ?? 0;
                $avgArr['license'][$i] = number_format((float)json_decode($val->res_analysis)->license->score, 2) ?? 0;
                $i++;
            }

            if ($totEduScore == 0 || $iAvgCnt == 0) {
                $eduavgscore = 0;
            } else {
                $eduavgscore = $totEduScore / $iAvgCnt;
            }

            if ($totCareerScore == 0 || $iAvgCnt == 0) {
                $careeravgscore = 0;
            } else {
                $careeravgscore = $totCareerScore / $iAvgCnt;
            }

            if ($totLanguageScore == 0 || $iAvgCnt == 0) {
                $languageavgscore = 0;
            } else {
                $languageavgscore = $totLanguageScore / $iAvgCnt;
            }

            if ($totLicenseScore == 0 || $iAvgCnt == 0) {
                $licenseavgscore = 0;
            } else {
                $licenseavgscore = $totLicenseScore / $iAvgCnt;
            }

            $aAvgScoreArr = array();
            array_push($aAvgScoreArr, array('edu' => number_format($eduavgscore, 2), 'career' => number_format($careeravgscore, 2), 'language' => number_format($languageavgscore, 2), 'license' => number_format($licenseavgscore, 2)));

            //이력서 학목별 평가
            $getResumeText = $this->getResumeText($aScoreArr, $aAvgScoreArr, $iAvgCnt, $avgArr);
            $this->aData['data']['resume']['text'] = $getResumeText;

            //종합등급 / 종합점수
            $getResumeTotal = $this->getResumeTotal($aScoreArr);
            $this->aData['data']['resume']['atotal'] = $getResumeTotal;
            $this->aData['data']['resumeScore'] = number_format((float)$getResumeTotal[0]['score'], 2);

            $isRes = true;
        } else {
            $isRes = false;
        }

        $this->aData['data']['response'] = $response ?? ''; //응답신뢰도
        $this->aData['data']['facialAnalysis'] = $facial_analysis[0] ?? []; //표정분석-본인점수
        $this->aData['data']['facialAnalysisAvg'] = $facial_result[0] ?? [];   //표정분석-평균점수
        $this->aData['data']['T']['reportScoreRank']['T'] = $reportScoreRankT ?? [];
        $this->aData['data']['T']['reportScoreRank']['C'] = $reportScoreRankC ?? [];
        $this->aData['data']['T']['temp'] = $aTempT ?? [];
        $this->aData['data']['T']['score'] = $aScoreT ?? [];
        $this->aData['data']['T']['analysis'] = $aAnalysisT ?? [];
        $this->aData['data']['memName'] = $memName;
        $this->aData['data']['job'] = $aReport[0]['job_depth_text'] ?? '';
        $this->aData['data']['mbtiData'] = $strAppType === 'B' ? [] : $this->getMbtiData($strMemMbti, $iJobIdx);
        $this->aData['data']['fileSaveName'] = $strFileSaveName ?? '';
        $this->aData['data']['mine'] = $chkMine;
        $this->aData['data']['regDate'] = $dateDay . ' ' . $dateTime;
        $this->aData['data']['avgCapacity'] = $aAvgCapacity ?? '';
        $this->aData['data']['mySpecScore'] = $aScoreArr ?? [];
        $this->aData['data']['avgSpecScore'] = $aAvgScoreArr ?? [];
        $this->aData['data']['reportScore'] = number_format((float)$aAnalysisT['sum'], 2) ?? '';
        $this->aData['data']['isRes'] = $isRes;
        $this->header(false);
        echo view("www/report/reportDetail2", $this->aData);
    }

    public function fail($strApplierIdx)
    {
        // data init
        $this->commonData();
        $this->encrypter = Services::encrypter();
        $iMemberIdx = $this->aData['data']['session']['idx'] ?? 0;
        $iApplierIdx = $this->encrypter->decrypt(base64url_decode($strApplierIdx));
        $iApplierIdx = str_replace('"', '', $iApplierIdx);

        //model
        $globalvar = new GlobalvarLib();
        $applierModel = new ApplierModel();

        $aReport['T'] = $applierModel->getFailTotal($iApplierIdx)->first();

        if ($aReport['T']['memIdx'] != $iMemberIdx) {
            if ($aReport['T']['appShare'] == 0) {
                $_SESSION['backLogin'] = uri_string();
                alert_url($globalvar->aMsg['error11'], "/login");
                exit;
            }
        }

        $aReport['S'] = $applierModel->getFailSection($iApplierIdx)->findAll();

        $this->aData['data']['T'] = $aReport['T'];
        $this->aData['data']['S'] = $aReport['S'];
        $this->header();
        echo view("www/report/reportFail", $this->aData);
        $this->footer(['quick']);
    }

    public function print($strApplierIdx)
    {
        $this->commonData();
        $this->encrypter = Services::encrypter();
        $globalvar = new GlobalvarLib();
        $session = session();
        $iStypeCount = 0;

        $iApplierIdx = $this->encrypter->decrypt(base64url_decode($strApplierIdx));
        $iApplierIdx = str_replace('"', '', $iApplierIdx);

        // model
        $applierModel = new ApplierModel();
        $resumeModel = new ResumeModel();
        $reportResultModel = new ReportResultModel();

        $chkMine = false;
        if ($this->aData['data']['session']['id']) {
            $chkMine = $applierModel->chkApplier($iApplierIdx, $this->aData['data']['session']['idx']);
            $memName = $this->aData['data']['session']['name'];
        }
        $chkManager = $session->get('mem_ex_4');

        if ($chkMine || $applierModel->chkApplierShare($iApplierIdx) || in_array($this->aData['data']['session']['type'], ['C', 'A']) || $chkManager == 'M') {
        } else {
            $_SESSION['backLogin'] = uri_string();
            $gs = $this->request->getGet('gs');
            if ($gs == 'm') {
            } else {
                alert_url($globalvar->aMsg['error11'], "/login");
                exit;
            }
        }


        //역량분석 (평균점수 구하기)
        $aReportAvg = $applierModel->getAllDetail()->findAll();
        $totalActivity = $totalAlacrity = $totalStability = $totalWillpower = $totalAttraction = $totalAffirmative = $totalReliability = $totalAggressiveness = 0;
        $totalCnt = count($aReportAvg);

        foreach ($aReportAvg as $avgVal) {
            $aAvgAnalysis = json_decode($avgVal['repo_analysis'], true);

            //능동성
            $activity = $aAvgAnalysis['activity'] ?? 0;
            $totalActivity += (int)$activity;
            //대응성
            $alacrity = $aAvgAnalysis['alacrity'] ?? 0;
            $totalAlacrity += (int)$alacrity;
            //안정성
            $stability = $aAvgAnalysis['stability'] ?? 0;
            $totalStability += (int)$stability;
            //의지력
            $willpower = $aAvgAnalysis['willpower'] ?? 0;
            $totalWillpower += (int)$willpower;
            //매력도
            $attraction = $aAvgAnalysis['attraction'] ?? 0;
            $totalAttraction += (int)$attraction;
            //긍정성
            $affirmative = $aAvgAnalysis['affirmative'] ?? 0;
            $totalAffirmative += (int)$affirmative;
            //신뢰성
            $reliability = $aAvgAnalysis['reliability'] ?? 0;
            $totalReliability += (int)$reliability;
            //적극성
            $aggressiveness = $aAvgAnalysis['aggressiveness'] ?? 0;
            $totalAggressiveness += (int)$aggressiveness;
        }

        $aAvgCapacity = array();
        array_push($aAvgCapacity, array(
            'activity' => round($totalActivity / $totalCnt, 2),
            'alacrity' => round($totalAlacrity / $totalCnt, 2),
            'stability' => round($totalStability / $totalCnt, 2),
            'willpower' => round($totalWillpower / $totalCnt, 2),
            'attraction' => round($totalAttraction / $totalCnt, 2),
            'affirmative' => round($totalAffirmative / $totalCnt, 2),
            'reliability' => round($totalReliability / $totalCnt, 2),
            'aggressiveness' => round($totalAggressiveness / $totalCnt, 2)
        ));

        $aReport = $applierModel
            ->getDetail($iApplierIdx)
            ->select([
                'iv_video.video_record',
                'iv_question.que_question',
                'iv_question.que_best_answer',
                'iv_report_result.repo_speech_txt_detail',
                'iv_report_result.repo_audio_detail'
            ])
            ->join('iv_video', 'iv_report_result.idx = iv_video.repo_res_idx', 'inner')
            ->join('iv_question', 'iv_video.que_idx = iv_question.idx', 'inner')
            ->where(['iv_report_result.que_type' => 'S',])
            ->findAll();

        $aReport[] = $applierModel
            ->getDetail($iApplierIdx)
            ->select([
                'iv_member.mem_name as memName', 'iv_member.mem_mbti as memMbti',
                'iv_applier.app_share_company as appShareCom', 'iv_applier.app_type as appType',
                'iv_job_category.idx as jobIdx'
            ])
            ->join('iv_member', 'iv_member.idx = iv_applier.mem_idx', 'left')
            ->where(['iv_report_result.que_type' => 'T'])
            ->first();

        // 날짜,시간 구하기
        $regDates = $aReport[0]['app_reg_date'];
        $regDates = explode(' ', $regDates);
        $regDate = $regDates[0];
        $regTime = $regDates[1];

        $regDate = explode('-', $regDate);
        $regYear = $regDate[0];
        $regMonth = $regDate[1];
        $regDay = $regDate[2];

        $dateDay = $regYear . '년 ' . $regMonth . '월 ' . $regDay . '일';
        $dateTime = date('A h:i', strtotime($regTime));

        foreach ($aReport as $val) {
            $aTempT = []; // score 필터 돌린것
            if ($val['que_type'] === 'T') {
                $aScoreT = json_decode($val['repo_score'], true);
                $aAnalysisT = json_decode($val['repo_analysis'], true);
                $aAnalysisT['sum'] = round($aAnalysisT['sum'], 2);
                $strMemMbti = $val['memMbti'];
                $iJobIdx = $val['jobIdx'];
                $strAppType = $val['appType'];

                if (!$chkMine) {
                    $memName = $val['appShareCom'] == 2 ? $val['memName'] : '비공개'; // 본인것인지 체크
                }
                if ($gs ?? false == 'm') {
                    $memName = $val['memName'];
                }
                $strFileSaveName = $val['file_save_name'];

                foreach ($aScoreT as $k => $v) {
                    if (in_array($k, ['age', 'gender', 'hair_length', 'glasses', 'skin', 'beard'])) {
                        continue;
                    } else {
                        $aTempT[$k] = $v;
                    }
                }
                if ($val['job_depth_1'] == '' || $val['job_depth_1'] == null) {
                } else {
                    if (!$reportScoreRank = cache("report.score.{$val['job_depth_1']}")) { // 지원자들 랭크 받아옴
                        $reportScoreRankModel = new ReportScoreRankModel();
                        $reportScoreRank = $reportScoreRankModel->getScoreInfo($val['job_depth_1']);
                        cache()->save("report.score.{$val['job_depth_1']}", $reportScoreRank, 600);
                    }

                    foreach ($reportScoreRank as $v) {
                        if ($v['score_rank_type'] === 'T') {
                            unset($v['score_rank_type']);
                            $reportScoreRankT[] = $v;
                        } else {
                            unset($v['score_rank_type']);
                            $reportScoreRankC[] = $v;
                        }
                    }
                }
            } else if ($val['que_type'] === 'S') {
                $aScoreS = json_decode($val['repo_score'], true);
                $aAnalysisS = json_decode($val['repo_analysis'], true);
                $aAnalysisS['sum'] = round($aAnalysisS['sum'], 2);

                $aAudioS = json_decode($val['repo_audio_detail'], true) ?? [];

                $this->aData['data']['S'][$iStypeCount]['speech'] = json_decode($val['repo_speech_txt_detail'], true);
                $this->aData['data']['S'][$iStypeCount]['video'] = $val['video_record'] ?? '';
                $this->aData['data']['S'][$iStypeCount]['audio'] = $aAudioS;
                $this->aData['data']['S'][$iStypeCount]['question'] = $val['que_question'] ?? '';
                $this->aData['data']['S'][$iStypeCount]['queBestAnswer'] = $val['que_best_answer'] ?? '';
                $this->aData['data']['S'][$iStypeCount]['score'] = $aScoreS ?? [];
                $this->aData['data']['S'][$iStypeCount]['analysis'] = $aAnalysisS ?? [];
                ++$iStypeCount;
            }
        }

        //응답 신뢰도
        if ($aScoreT['sincerity'] >= 1 && $aScoreT['sincerity'] <= 3) {
            $response = '낮음';
        } else if ($aScoreT['sincerity'] >= 4 && $aScoreT['sincerity'] <= 6) {
            $response = '보통';
        } else if ($aScoreT['sincerity'] >= 7) {
            $response = '높음';
        } else {
            $response = '분석불가';
        }

        //표정분석-본인점수 
        $quiver = $aScoreT["quiver"];   //음성떨림
        $volume = $aScoreT["volume"];   //음성크기
        $tone = $aScoreT["tone"];   //목소리톤
        $speed = $aScoreT["speed"];   //음성속도
        $diction = $aScoreT["diction"];   //발음정확도
        $eyes = $aScoreT["eyes"];   //시선처리
        $blink = $aScoreT["blink"];   //눈깜빡임
        $gesture = $aScoreT["gesture"];   //제스처빈도
        $head_motion = $aScoreT["head_motion"];   //머리움직임
        $glow = $aScoreT["glow"];   //홍조현상

        $realScore = $this->getRealScore($speed, $quiver, $glow, $head_motion, $blink);
        $confidence = ((int)$realScore[0]['quiver'] + (int)$volume + (int)$tone + (int)$realScore[0]['speed']) / 4; //자신감
        $Attitude = ((int)$realScore[0]['head_motion'] + (int)$gesture) / 2; //태도

        $facial_analysis = array();
        array_push($facial_analysis, array('complexion' => $glow * 10, 'blinking' => $blink * 10, 'pronunciation' => $diction * 10, 'eye_contact' => $eyes * 10, 'confidence' => $confidence * 10, 'Attitude' => $Attitude * 10));

        //표정분석-평균점수
        $complexion = $blinking = $pronunciation = $eye_contact = $confidence = $Attitude = 0;
        $facial_total = 0;

        $getAllgetfacialAnalysis = $reportResultModel->getAllgetfacialAnalysis();
        foreach ($getAllgetfacialAnalysis as $facialKey => $facialVal) {
            $facialAnalysisAvg = json_decode($getAllgetfacialAnalysis[$facialKey]['repo_score'], true);

            $quiver = $facialAnalysisAvg["quiver"] ?? 0;   //음성떨림
            $volume = $facialAnalysisAvg["volume"] ?? 0;   //음성크기
            $tone = $facialAnalysisAvg["tone"] ?? 0;   //목소리톤
            $speed = $facialAnalysisAvg["speed"] ?? 0;   //음성속도
            $diction = $facialAnalysisAvg["diction"] ?? 0;   //발음정확도
            $eyes = $facialAnalysisAvg["eyes"] ?? 0;   //시선처리
            $blink = $facialAnalysisAvg["blink"] ?? 0;   //눈깜빡임
            $gesture = $facialAnalysisAvg["gesture"] ?? 0;   //제스처빈도
            $head_motion = $facialAnalysisAvg["head_motion"] ?? 0;   //머리움직임
            $glow = $facialAnalysisAvg["glow"] ?? 0;   //홍조현상

            $realScore = $this->getRealScore($speed, $quiver, $glow, $head_motion, $blink);
            $confidence_cate = ((int)$realScore[0]['quiver'] + (int)$volume + (int)$tone + (int)$realScore[0]['speed']) / 4; //자신감
            $Attitude_cate = ((int)$realScore[0]['head_motion'] + (int)$gesture) / 2; //태도

            $complexion += (int)$glow;   //안색
            $blinking += (int)$blink;    //눈깜빡임
            $pronunciation += (int)$diction; //발음정확도
            $eye_contact += (int)$eyes; //시선마주침
            $confidence += (int)$confidence_cate;   //자신감
            $Attitude += (int)$Attitude_cate;   //태도
            $facial_total++;
        }

        $facial_result = array();
        array_push($facial_result, array(
            'complexion' => round($complexion / $facial_total, 1) * 10,
            'blinking' => round($blinking / $facial_total, 1) * 10,
            'pronunciation' => round($pronunciation / $facial_total, 1) * 10,
            'eye_contact' => round($eye_contact / $facial_total, 1) * 10,
            'confidence' => round($confidence / $facial_total, 1) * 10,
            'Attitude' => round($Attitude / $facial_total, 1) * 10,
        ));


        $checkHaveResume = $applierModel->checkHaveResume($iApplierIdx)->first();

        $reportResume = new ReportResumeModel();
        $getJobcategory = $reportResume->getJobcategory($iApplierIdx);

        //iv_applier에 app_share랑 comprehensive는 값이 0이 아니고 res_idx가 있으면 
        if (!empty($checkHaveResume['res_idx']) && !empty($getJobcategory['idx'])) {
            //이력서 레포트
            $resumeReport = $this->resumeReport($iApplierIdx);
            $this->aData['data']['resume'] = $resumeReport;

            //이력서 내 SPEC 점수 구하기
            $getResumeScore = $resumeModel->select('res_analysis');
            $getResumeScore = $resumeModel->getResumeScore($iApplierIdx)->first();

            $eduScore = (float)json_decode($getResumeScore['res_analysis'])->edu->score;
            $careerScore = (float)json_decode($getResumeScore['res_analysis'])->career->score;
            $languageScore = (float)json_decode($getResumeScore['res_analysis'])->language->score;
            $licenseScore = (float)json_decode($getResumeScore['res_analysis'])->license->score;

            $aScoreArr = array();
            array_push($aScoreArr, array('edu' => number_format($eduScore, 2), 'career' => number_format($careerScore, 2), 'language' => number_format($languageScore, 2), 'license' => number_format($licenseScore, 2)));

            //이력서 평균 SPEC 점수 구하기
            $getResumeSpecAvg = $resumeModel->getResumeSpecAvg($iApplierIdx);

            $iAvgCnt = count($getResumeSpecAvg);
            $totEduScore = 0;
            $totCareerScore = 0;
            $totLanguageScore = 0;
            $totLicenseScore = 0;
            $i = 0;
            $avgArr = [];
            foreach ($getResumeSpecAvg as $val) {
                $totEduScore += (float)json_decode($val->res_analysis)->edu->score;
                $totCareerScore += (float)json_decode($val->res_analysis)->career->score;
                $totLanguageScore += (float)json_decode($val->res_analysis)->language->score;
                $totLicenseScore += (float)json_decode($val->res_analysis)->license->score;

                $avgArr['edu'][$i] = number_format((float)json_decode($val->res_analysis)->edu->score, 2) ?? 0;
                $avgArr['career'][$i] = number_format((float)json_decode($val->res_analysis)->career->score, 2) ?? 0;
                $avgArr['language'][$i] = number_format((float)json_decode($val->res_analysis)->language->score, 2) ?? 0;
                $avgArr['license'][$i] = number_format((float)json_decode($val->res_analysis)->license->score, 2) ?? 0;
                $i++;
            }

            if ($totEduScore == 0 || $iAvgCnt == 0) {
                $eduavgscore = 0;
            } else {
                $eduavgscore = $totEduScore / $iAvgCnt;
            }

            if ($totCareerScore == 0 || $iAvgCnt == 0) {
                $careeravgscore = 0;
            } else {
                $careeravgscore = $totCareerScore / $iAvgCnt;
            }

            if ($totLanguageScore == 0 || $iAvgCnt == 0) {
                $languageavgscore = 0;
            } else {
                $languageavgscore = $totLanguageScore / $iAvgCnt;
            }

            if ($totLicenseScore == 0 || $iAvgCnt == 0) {
                $licenseavgscore = 0;
            } else {
                $licenseavgscore = $totLicenseScore / $iAvgCnt;
            }

            $aAvgScoreArr = array();
            array_push($aAvgScoreArr, array('edu' => number_format($eduavgscore, 2), 'career' => number_format($careeravgscore, 2), 'language' => number_format($languageavgscore, 2), 'license' => number_format($licenseavgscore, 2)));


            //이력서 학목별 평가
            $getResumeText = $this->getResumeText($aScoreArr, $aAvgScoreArr, $iAvgCnt, $avgArr);
            $this->aData['data']['resume']['text'] = $getResumeText;

            //종합등급 / 종합점수
            $getResumeTotal = $this->getResumeTotal($aScoreArr);
            $this->aData['data']['resume']['atotal'] = $getResumeTotal;
            $this->aData['data']['resumeScore'] = number_format((float)$getResumeTotal[0]['score'], 2);

            $isRes = true;
        } else {
            $isRes = false;
        }

        $this->aData['data']['response'] = $response ?? ''; //응답신뢰도
        $this->aData['data']['facialAnalysis'] = $facial_analysis[0] ?? []; //표정분석-본인점수
        $this->aData['data']['facialAnalysisAvg'] = $facial_result[0] ?? [];   //표정분석-평균점수
        $this->aData['data']['T']['reportScoreRank']['T'] = $reportScoreRankT ?? [];
        $this->aData['data']['T']['reportScoreRank']['C'] = $reportScoreRankC ?? [];
        $this->aData['data']['T']['temp'] = $aTempT ?? [];
        $this->aData['data']['T']['score'] = $aScoreT ?? [];
        $this->aData['data']['T']['analysis'] = $aAnalysisT ?? [];
        $this->aData['data']['memName'] = $memName;
        $this->aData['data']['mbtiData'] = $strAppType === 'B' ? [] : $this->getMbtiData($strMemMbti, $iJobIdx);
        $this->aData['data']['job'] = $aReport[0]['job_depth_text'] ?? '';
        $this->aData['data']['fileSaveName'] = $strFileSaveName ?? '';
        $this->aData['data']['mine'] = $chkMine;
        $this->aData['data']['regDate'] = $dateDay . ' ' . $dateTime;
        $this->aData['data']['avgCapacity'] = $aAvgCapacity ?? '';
        $this->aData['data']['mySpecScore'] = $aScoreArr ?? [];
        $this->aData['data']['avgSpecScore'] = $aAvgScoreArr ?? [];
        $this->aData['data']['reportScore'] = number_format((float)$aAnalysisT['sum'], 2) ?? '';
        $this->aData['data']['enAppIdx'] = $strApplierIdx;
        $this->aData['data']['isRes'] = $isRes;
        $this->header(false);
        echo view("www/report/reportPrint", $this->aData);
    }

    public function getRealScore($speed, $quiver, $glow, $head_motion, $blink)
    {
        if ($speed == 1) {  //음성속도
            $speed = 5;
        } else if ($speed == 2 || $speed == 10) {
            $speed = 6;
        } else if ($speed == 3 || $speed == 9) {
            $speed = 7;
        } else if ($speed == 4 || $speed == 8) {
            $speed = 8;
        } else if ($speed == 5 || $speed == 6) {
            $speed = 10;
        } else if ($speed == 7) {
            $speed = 9;
        } else if ($speed == 0) {
            $speed = 0;
        }

        if ($quiver == 0) { //목소리떨림
            $quiver = 0;
        } else {
            $quiver = 11 - $quiver;
        }

        if ($glow == 0) {   //홍조현상
            $glow = 0;
        } else {
            $glow = 11 - $glow;
        }

        if ($head_motion == 0) {  //머리움직임
            $head_motion = 0;
        } else {
            $head_motion = 11 - $head_motion;
        }

        if ($blink == 0) { //눈깜빡임
            $blink = 0;
        } else {
            $blink = 11 - $blink;
        }

        $getScore = array();
        array_push($getScore, array('speed' => $speed, 'quiver' => $quiver, 'glow' => $glow, 'head_motion' => $head_motion, 'blink' => $blink));

        return $getScore;
    }

    private function resumeReport($iApplierIdx)
    {

        //이력서 레포트
        //이력서 직무 추출
        $reportResume = new ReportResumeModel();

        $getJobcategory = $reportResume->getJobcategory($iApplierIdx);

        $job_idx = $getJobcategory['idx'];
        $job_depth_text = $getJobcategory['job_depth_text'];
        //총 지원자 수 - 같은 직무 지원자 
        $getTotal = $reportResume->getTotal($job_idx);
        $total = $getTotal->cnt;
        $arrDate['total'] = $total;

        //지원자 현황 분석 - 각항목(%) = 항목 개수 / 전체 개수 * 100
        //학력별 현황
        $getTotalEdu = $reportResume->getTotalEdu($job_idx);
        $arrDate['totalEdu'] = $getTotalEdu;
        $getTopE10 = $this->getTop10($getTotalEdu[0], 'edu', 5); // 상위 10%
        $arrDate['top']['edu'] = $getTopE10;

        //경력별 현황
        $getTotalCareer = $reportResume->getTotalCareer($job_idx); //a5
        $arrDate['totalCareer'] = $getTotalCareer;
        $getTopC10 = $this->getTop10($getTotalCareer[0], 'career', 5); // 상위 10%
        $arrDate['top']['career'] = $getTopC10;

        //외국어 현황
        $getTotalLanguage = $reportResume->getTotalLanguage($job_idx); //a6
        $arrDate['totalLanguage'] = $getTotalLanguage;
        $getTopL10 = $this->getTop10($getTotalLanguage[0], 'language', 6); // 상위 10%
        $arrDate['top']['language'] = $getTopL10;

        //TOEIC 점수 현황
        $getTotalToeicscore = $reportResume->getTotalToeicscore($job_idx); //a5
        $arrDate['totalToeicscore'] = $getTotalToeicscore;
        $getTopT10 = $this->getTop10($getTotalToeicscore[0], 'toeicscore', 5); // 상위 10%
        $arrDate['top']['toeicscore'] = $getTopT10;

        //자격증 개수
        $getTotalLicense = $reportResume->getTotalLicense($job_idx); //a5
        $arrDate['totalLicense'] = $getTotalLicense;
        $getTopI10 = $this->getTop10($getTotalLicense[0], 'license', 5); // 상위 10%
        $arrDate['top']['license'] = $getTopI10;

        //활동 지수
        $getTotalActivity = $reportResume->getTotalActivity($job_idx); //a5
        $arrDate['totalActivity'] = $getTotalActivity;
        $getTopA10 = $this->getTop10($getTotalActivity[0], 'activity', 5); // 상위 10%
        $arrDate['top']['activity'] = $getTopA10;

        //나의 스펙 - 각항목(100점 만점) 항목 순위 / 1위 * 100
        //학력
        //경력
        //어학
        //자격증


        return $arrDate;
    }

    private function getTop10($arrData, $tpye, $langth)
    {
        for ($i = 1; $i <= $langth; $i++) { //초기화
            $returnData['a' . $i] = false;
        }
        $dataSum = 0;
        for ($i = $langth; $i > 0; $i--) {
            $dataSum = $dataSum + $arrData->{'a' . $i};
            if ($dataSum >= 10) {
                $returnData['a' . $i] = true;
                break;
            }
        }


        return $returnData ?? [];
    }

    private function getResumeText($aScoreArr, $aAvgScoreArr, $iAvgCnt, $avgArr)
    {

        //항목별 평가

        arsort($avgArr['edu']); // 배열을 값으로 내림차순 정렬하고 인덱스의 상관관계 유지print_r($fruits);
        $i = 0;
        foreach ($avgArr['edu'] as $key => $val) {
            $eduSortArr[$i] = $val;
            $i++;
        }
        $eduRank =  array_search($aScoreArr[0]['edu'], $eduSortArr);

        arsort($avgArr['career']); // 배열을 값으로 내림차순 정렬하고 인덱스의 상관관계 유지print_r($fruits);
        $i = 0;
        foreach ($avgArr['career'] as $key => $val) {
            $careerSortArr[$i] = $val;
            $i++;
        }
        $careerRank =  array_search($aScoreArr[0]['career'], $careerSortArr);

        arsort($avgArr['language']); // 배열을 값으로 내림차순 정렬하고 인덱스의 상관관계 유지print_r($fruits);
        $i = 0;
        foreach ($avgArr['language'] as $key => $val) {
            $languageSortArr[$i] = $val;
            $i++;
        }
        $languageRank =  array_search($aScoreArr[0]['language'], $languageSortArr);

        arsort($avgArr['license']); // 배열을 값으로 내림차순 정렬하고 인덱스의 상관관계 유지print_r($fruits);
        $i = 0;
        foreach ($avgArr['license'] as $key => $val) {
            $licenseSortArr[$i] = $val;
            $i++;
        }
        $licenseRank =  array_search($aScoreArr[0]['license'], $licenseSortArr);

        //(전체 수 - 지원자 순위) * 100     
        $eduT = 100 - (($iAvgCnt - $eduRank) / $iAvgCnt * 100);
        $careerT = 100 - (($iAvgCnt - $careerRank) / $iAvgCnt * 100);
        $languageT = 100 - (($iAvgCnt - $languageRank) / $iAvgCnt * 100);
        $licenseT = 100 - (($iAvgCnt - $licenseRank) / $iAvgCnt * 100);

        switch ($eduT) {

            case $eduT <= 10:
                $eduText = "지원자 대비 학교 등급 및 학력이 훌륭합니다.";
                break;
            case $eduT > 10 && $eduT <= 30:
                $eduText = "지원자 대비 학교 등급 및 학력이 다소 높은 편입니다.";
                break;
            case $eduT > 30 && $eduT <= 50:
                $eduText = "지원자 대비 학교 등급 및 학력이 적정한 편입니다.";
                break;
            case $eduT > 50 && $eduT <= 100:
                $eduText = "지원자 대비 학교 등급 및 학력이 다소 낮은 편입니다. 경력, 어학, 자격증의 점수를 높이기 위해 노력을 하면 합격률이 높아질 수 있습니다. ";
                break;
            default:
        }
        switch ($careerT) {

            case $careerT <= 10:
                $careerText = "지원자 대비 인턴, 대외활동 등 경력이 훌륭합니다. 본 경력을 면접 때 어필해 보세요. 호감도 및 입사에 유리하게 작용할 수 있습니다.";
                break;
            case $careerT > 10 && $careerT <= 30:
                $careerText = "지원자 대비 인턴, 대외활동 등 경력이 다소 높은 편입니다. 면접 때 어필해 보세요. 입사에 유리하게 작용할 수 있습니다.";
                break;
            case $careerT > 30 && $careerT <= 50:
                $careerText = "지원자 대비 인턴, 대외활동 등 경력이 적정한 편입니다. 공모전, 인턴 경험 등 다양한 활동으로 경력 점수를 높여 보세요.";
                break;
            case $careerT > 50 && $careerT <= 100:
                $careerText = "지원자 대비 인턴, 대외활동 등 경력이 다소 낮은 편입니다. 지원한 직무와 관련된 다양한 활동에 참여해 보세요.";
                break;
            default:
        }
        switch ($languageT) {
            case $iAvgCnt <= 1:
                $languageText = "강점으로 어필할 수 있도록 어학점수를 끌어올려 보세요.";
                break;
            case $languageT <= 10:
                $languageText = "어학점수가 다른 지원자 대비 훌륭합니다. 직무와 연관시켜 어학점수에 대한 강점을 면접에 어필해 보세요.";
                break;
            case $languageT > 10 && $languageT <= 30:
                $languageText = "어학점수가 다른 지원자 대비 다소 높은 편입니다. 다른 어학에 도전을 하거나, 점수를 유지할 수 있도록 해 주세요.";
                break;
            case $languageT > 30 && $languageT <= 50:
                $languageText = "어학점수가 다른 지원자 대비 적정한 편입니다. 강점으로 어필할 수 있도록 어학점수를 끌어올려 보세요.";
                break;
            case $languageT > 50 && $languageT <= 100:
                $languageText = "어학점수가 다른 지원자 대비 다소 낮은 편입니다. 점수를 올릴 수 있도록 조금 더 노력해 주세요.";
                break;
            default:
        }
        switch ($licenseT) {
            case $iAvgCnt <= 1:
                $licenseText = "경쟁력을 갖출 수 있도록 자격증 개수를 늘려 보세요.";
                break;
            case $licenseT <= 10:
                $licenseText = "자격증 종류 및 개수가 타 지원자 대비 훌륭합니다. 면접 시 자격증에 대한 강점을 효과적으로 발휘해 보세요.";
                break;
            case $licenseT > 10 && $licenseT <= 30:
                $licenseText = "자격증 종류 및 개수가 타 지원자 대비 다소 높은 편입니다. 직무와 관련된 분야의 자격증이 어느 정도인지 체크해 보세요.";
                break;
            case $licenseT > 30 && $licenseT <= 50:
                $licenseText = "자격증 종류 및 개수가 타 지원자 대비 적정한 편입니다. 경쟁력을 갖출 수 있도록 자격증 개수를 늘려 보세요.";
                break;
            case $licenseT > 50 && $licenseT <= 100:
                $licenseText = "자격증 종류 및 개수가 타 지원자 대비 다소 부족합니다. 합격률을 올리기 위해 직무에 관련된 자격증 응시에 도전해 보세요.";
                break;
            default:
        }

        $aTextArr = array();
        array_push($aTextArr, array('edu' => $eduText, 'career' => $careerText, 'language' => $languageText, 'license' => $licenseText));

        return $aTextArr;
    }

    private function getResumeTotal($aScoreArr)
    {
        //종합점수
        //각학목 합 / 4
        $totalAve = ($aScoreArr[0]['edu'] + $aScoreArr[0]['career'] + $aScoreArr[0]['language'] + $aScoreArr[0]['license']) / 4;
        //종합평점
        switch ($totalAve) {

            case $totalAve >= 90:
                $totalRank = "S";
                break;
            case $totalAve >= 80 && $totalAve < 90:
                $totalRank = "A";
                break;
            case $totalAve >= 70 && $totalAve < 80:
                $totalRank = "B";
                break;
            case $totalAve >= 60 && $totalAve < 70:
                $totalRank = "C";
                break;
            case $totalAve >= 60 && $totalAve < 70:
                $totalRank = "D";
                break;
            default:
                $totalRank = "E";
        }

        $asArr = array();
        array_push($asArr, array('score' => $totalAve, 'rank' => $totalRank));

        return $asArr;
    }

    private function getMbtiData($strMbti,  $iJobIdx): array
    {
        //init
        $aResult = ['stat' => false, 'mbti' => 'MBTI', 'score' => 0, 'msg' => '연관도', 'recommendJob' => []];

        if (!$strMbti || !$iJobIdx) {
            return $aResult;
        }

        if (!$aMbtiData = cache("mbti.scroe.{$iJobIdx}")) {
            $mbtiScoreModel = new MbtiScoreModel();
            $aMbtiData = $mbtiScoreModel->getMbtiData($iJobIdx);
            cache()->save("mbti.scroe.{$iJobIdx}", $aMbtiData, 86400);
        }

        //process
        foreach ($aMbtiData as $val) {
            if ($val['mbtiValue'] === $strMbti) {
                $aResult = ['stat' => true, 'mbti' => $strMbti, 'score' => $val['mbtiScore'], 'msg' => $val['mbtiMsg']];
                $aResult['recommendJob'][] = $val['recommendJob1'];
                $aResult['recommendJob'][] = $val['recommendJob2'];
                $aResult['recommendJob'][] = $val['recommendJob3'];
            }
        }

        if (!$aResult['stat']) { // job_idx가 aMbtiData와 일치하는것이 없을때 ex) 3depth변경전 리포트
            $aResult = [];
        }

        return $aResult;
    }
}
