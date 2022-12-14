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

        //νΈλμ­μ start
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

        // νΈλμ­μ end
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

        if ($iMemberIdx && ($this->aData['data']['session']['type'] === 'M')) { // λ‘κ·ΈμΈλμ΄μΌν¨
            $strType = $this->request->getGet('type') ?? 'all';
            $applierModel = new ApplierModel();
            $configCompnaySuggestModel = new ConfigCompnaySuggestModel();
            $allCount = $applierModel->getApplierAllList($iMemberIdx, '', '', 3)->countAllResults() ?? 0;
            $openCount = $applierModel->getComprehensiveList($iMemberIdx)->countAllResults() ?? 0;
            $aJobIdx = $applierModel
                ->select('job_idx')
                ->getShareJobIdx($iMemberIdx)
                ->findColumn('job_idx'); // λ³ΈμΈ μΈν°λ·° μ€ κ³΅κ°νκ² job_idxκ°μ Έμ΄

            if ($strType === 'all') { // μ μ²΄ λ¦¬ν¬νΈ
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
            } else if ($strType === 'open') { // κ³΅κ°μ€μΈ λ¦¬ν¬νΈ
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
        } else { //λΉλ‘κ·ΈμΈ
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
                //νΈλμ­μ start
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
                // νΈλμ­μ end
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
                    $aReport[$key]['app_share_text'] = $val['app_share']  ? "κ³΅κ°" : "λΉκ³΅κ°";

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

                //νΈλμ­μ start
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
                    if ($applierModel->getJobIdx($iApplierIdx, $iMemberIdx, $iJobIdx['job_idx'])) { // λ΄ λ ν¬νΈμ€ job idxκ° κ°μ λ ν¬νΈλ λΉκ³΅κ° μ ν
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

                // νΈλμ­μ end
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
            $aTempT = []; // score νν° λλ¦°κ²
            if ($val['que_type'] === 'T') {
                $aScoreT = json_decode($val['repo_score'], true);
                $aAnalysisT = json_decode($val['repo_analysis'], true);
                $aAnalysisT['sum'] = round($aAnalysisT['sum'], 2);

                if (!$chkMine) {
                    $memName = $val['appShareCom'] == 2 ? $val['memName'] : 'λΉκ³΅κ°'; // λ³ΈμΈκ²μΈμ§ μ²΄ν¬
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
                    if (!$reportScoreRank = cache("report.score.{$val['job_depth_1']}")) { // μ§μμλ€ λ­ν¬ λ°μμ΄
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

        //μ­λλΆμ (νκ· μ μ κ΅¬νκΈ°)
        $aReportAvg = $applierModel->getAllDetail()->findAll();
        $totalActivity = $totalAlacrity = $totalStability = $totalWillpower = $totalAttraction = $totalAffirmative = $totalReliability = $totalAggressiveness = 0;
        $totalCnt = count($aReportAvg);

        foreach ($aReportAvg as $avgVal) {
            $aAvgAnalysis = json_decode($avgVal['repo_analysis'], true);

            //λ₯λμ±
            $activity = $aAvgAnalysis['activity'] ?? 0;
            $totalActivity += (int)$activity;
            //λμμ±
            $alacrity = $aAvgAnalysis['alacrity'] ?? 0;
            $totalAlacrity += (int)$alacrity;
            //μμ μ±
            $stability = $aAvgAnalysis['stability'] ?? 0;
            $totalStability += (int)$stability;
            //μμ§λ ₯
            $willpower = $aAvgAnalysis['willpower'] ?? 0;
            $totalWillpower += (int)$willpower;
            //λ§€λ ₯λ
            $attraction = $aAvgAnalysis['attraction'] ?? 0;
            $totalAttraction += (int)$attraction;
            //κΈμ μ±
            $affirmative = $aAvgAnalysis['affirmative'] ?? 0;
            $totalAffirmative += (int)$affirmative;
            //μ λ’°μ±
            $reliability = $aAvgAnalysis['reliability'] ?? 0;
            $totalReliability += (int)$reliability;
            //μ κ·Ήμ±
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

        // λ μ§,μκ° κ΅¬νκΈ°
        $regDates = $aReport[0]['app_reg_date'];
        $regDates = explode(' ', $regDates);
        $regDate = $regDates[0];
        $regTime = $regDates[1];

        $regDate = explode('-', $regDate);
        $regYear = $regDate[0];
        $regMonth = $regDate[1];
        $regDay = $regDate[2];

        $dateDay = $regYear . 'λ ' . $regMonth . 'μ ' . $regDay . 'μΌ';
        $dateTime = date('A h:i', strtotime($regTime));

        foreach ($aReport as $val) {
            $aTempT = []; // score νν° λλ¦°κ²
            if ($val['que_type'] === 'T') {
                $aScoreT = json_decode($val['repo_score'], true);
                $aAnalysisT = json_decode($val['repo_analysis'], true);
                $aAnalysisT['sum'] = round($aAnalysisT['sum'], 2);
                $strMemMbti = $val['memMbti'];
                $strAppType = $val['appType'];
                $iJobIdx = $val['jobIdx'];

                if (!$chkMine) {
                    // $memName = $val['appShareCom'] == 2 ? $val['memName'] : lang('Sample.Private'); // λ³ΈμΈκ²μΈμ§ μ²΄ν¬
                    $memName = $val['appShareCom'] == 2 ? $val['memName'] : 'λΉκ³΅κ°'; // λ³ΈμΈκ²μΈμ§ μ²΄ν¬
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
                    if (!$reportScoreRank = cache("report.score.{$val['job_depth_1']}")) { // μ§μμλ€ λ­ν¬ λ°μμ΄
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

        //μλ΅ μ λ’°λ
        if ($aScoreT['sincerity'] >= 1 && $aScoreT['sincerity'] <= 3) {
            $response = 'λ?μ';
        } else if ($aScoreT['sincerity'] >= 4 && $aScoreT['sincerity'] <= 6) {
            $response = 'λ³΄ν΅';
        } else if ($aScoreT['sincerity'] >= 7) {
            $response = 'λμ';
        } else {
            $response = 'λΆμλΆκ°';
        }

        //νμ λΆμ-λ³ΈμΈμ μ
        $quiver = $aScoreT["quiver"];   //μμ±λ¨λ¦Ό
        $volume = $aScoreT["volume"];   //μμ±ν¬κΈ°
        $tone = $aScoreT["tone"];   //λͺ©μλ¦¬ν€
        $speed = $aScoreT["speed"];   //μμ±μλ
        $diction = $aScoreT["diction"];   //λ°μμ νλ
        $eyes = $aScoreT["eyes"];   //μμ μ²λ¦¬
        $blink = $aScoreT["blink"];   //λκΉλΉ‘μ
        $gesture = $aScoreT["gesture"];   //μ μ€μ²λΉλ
        $head_motion = $aScoreT["head_motion"];   //λ¨Έλ¦¬μμ§μ
        $glow = $aScoreT["glow"];   //νμ‘°νμ

        $realScore = $this->getRealScore($speed, $quiver, $glow, $head_motion, $blink);
        $confidence = ((int)$realScore[0]['quiver'] + (int)$volume + (int)$tone + (int)$realScore[0]['speed']) / 4; //μμ κ°
        $Attitude = ((int)$realScore[0]['head_motion'] + (int)$gesture) / 2; //νλ

        $facial_analysis = array();
        array_push($facial_analysis, array('complexion' => $glow * 10, 'blinking' => $blink * 10, 'pronunciation' => $diction * 10, 'eye_contact' => $eyes * 10, 'confidence' => $confidence * 10, 'Attitude' => $Attitude * 10));

        //νμ λΆμ-νκ· μ μ
        $complexion = $blinking = $pronunciation = $eye_contact = $confidence = $Attitude = 0;
        $facial_total = 0;

        $getAllgetfacialAnalysis = $reportResultModel->getAllgetfacialAnalysis();
        foreach ($getAllgetfacialAnalysis as $facialKey => $facialVal) {
            $facialAnalysisAvg = json_decode($getAllgetfacialAnalysis[$facialKey]['repo_score'], true);

            $quiver = $facialAnalysisAvg["quiver"] ?? 0;   //μμ±λ¨λ¦Ό
            $volume = $facialAnalysisAvg["volume"] ?? 0;   //μμ±ν¬κΈ°
            $tone = $facialAnalysisAvg["tone"] ?? 0;   //λͺ©μλ¦¬ν€
            $speed = $facialAnalysisAvg["speed"] ?? 0;   //μμ±μλ
            $diction = $facialAnalysisAvg["diction"] ?? 0;   //λ°μμ νλ
            $eyes = $facialAnalysisAvg["eyes"] ?? 0;   //μμ μ²λ¦¬
            $blink = $facialAnalysisAvg["blink"] ?? 0;   //λκΉλΉ‘μ
            $gesture = $facialAnalysisAvg["gesture"] ?? 0;   //μ μ€μ²λΉλ
            $head_motion = $facialAnalysisAvg["head_motion"] ?? 0;   //λ¨Έλ¦¬μμ§μ
            $glow = $facialAnalysisAvg["glow"] ?? 0;   //νμ‘°νμ

            $realScore = $this->getRealScore($speed, $quiver, $glow, $head_motion, $blink);
            $confidence_cate = ((int)$realScore[0]['quiver'] + (int)$volume + (int)$tone + (int)$realScore[0]['speed']) / 4; //μμ κ°
            $Attitude_cate = ((int)$realScore[0]['head_motion'] + (int)$gesture) / 2; //νλ

            $complexion += (int)$glow;   //μμ
            $blinking += (int)$blink;    //λκΉλΉ‘μ
            $pronunciation += (int)$diction; //λ°μμ νλ
            $eye_contact += (int)$eyes; //μμ λ§μ£ΌμΉ¨
            $confidence += (int)$confidence_cate;   //μμ κ°
            $Attitude += (int)$Attitude_cate;   //νλ
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

        //iv_applierμ app_shareλ comprehensiveλ κ°μ΄ 0μ΄ μλκ³  res_idxκ° μμΌλ©΄ 
        if (!empty($checkHaveResume['res_idx']) && !empty($getJobcategory['idx'])) {
            //μ΄λ ₯μ λ ν¬νΈ
            $resumeReport = $this->resumeReport($iApplierIdx);
            $this->aData['data']['resume'] = $resumeReport;

            //μ΄λ ₯μ λ΄ SPEC μ μ κ΅¬νκΈ°
            $getResumeScore = $resumeModel->select('res_analysis');
            $getResumeScore = $resumeModel->getResumeScore($iApplierIdx)->first();

            $eduScore = json_decode($getResumeScore['res_analysis'])->edu->score;
            $careerScore = json_decode($getResumeScore['res_analysis'])->career->score;
            $languageScore = json_decode($getResumeScore['res_analysis'])->language->score;
            $licenseScore = json_decode($getResumeScore['res_analysis'])->license->score;

            $aScoreArr = array();
            array_push($aScoreArr, array('edu' => number_format($eduScore, 2), 'career' => $careerScore, 'language' => $languageScore, 'license' => $licenseScore));

            //μ΄λ ₯μ νκ·  SPEC μ μ κ΅¬νκΈ°
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

            //μ΄λ ₯μ νλͺ©λ³ νκ°
            $getResumeText = $this->getResumeText($aScoreArr, $aAvgScoreArr, $iAvgCnt, $avgArr);
            $this->aData['data']['resume']['text'] = $getResumeText;

            //μ’ν©λ±κΈ / μ’ν©μ μ
            $getResumeTotal = $this->getResumeTotal($aScoreArr);
            $this->aData['data']['resume']['atotal'] = $getResumeTotal;
            $this->aData['data']['resumeScore'] = number_format((float)$getResumeTotal[0]['score'], 2);

            $isRes = true;
        } else {
            $isRes = false;
        }

        $this->aData['data']['response'] = $response ?? ''; //μλ΅μ λ’°λ
        $this->aData['data']['facialAnalysis'] = $facial_analysis[0] ?? []; //νμ λΆμ-λ³ΈμΈμ μ
        $this->aData['data']['facialAnalysisAvg'] = $facial_result[0] ?? [];   //νμ λΆμ-νκ· μ μ
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


        //μ­λλΆμ (νκ· μ μ κ΅¬νκΈ°)
        $aReportAvg = $applierModel->getAllDetail()->findAll();
        $totalActivity = $totalAlacrity = $totalStability = $totalWillpower = $totalAttraction = $totalAffirmative = $totalReliability = $totalAggressiveness = 0;
        $totalCnt = count($aReportAvg);

        foreach ($aReportAvg as $avgVal) {
            $aAvgAnalysis = json_decode($avgVal['repo_analysis'], true);

            //λ₯λμ±
            $activity = $aAvgAnalysis['activity'] ?? 0;
            $totalActivity += (int)$activity;
            //λμμ±
            $alacrity = $aAvgAnalysis['alacrity'] ?? 0;
            $totalAlacrity += (int)$alacrity;
            //μμ μ±
            $stability = $aAvgAnalysis['stability'] ?? 0;
            $totalStability += (int)$stability;
            //μμ§λ ₯
            $willpower = $aAvgAnalysis['willpower'] ?? 0;
            $totalWillpower += (int)$willpower;
            //λ§€λ ₯λ
            $attraction = $aAvgAnalysis['attraction'] ?? 0;
            $totalAttraction += (int)$attraction;
            //κΈμ μ±
            $affirmative = $aAvgAnalysis['affirmative'] ?? 0;
            $totalAffirmative += (int)$affirmative;
            //μ λ’°μ±
            $reliability = $aAvgAnalysis['reliability'] ?? 0;
            $totalReliability += (int)$reliability;
            //μ κ·Ήμ±
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

        // λ μ§,μκ° κ΅¬νκΈ°
        $regDates = $aReport[0]['app_reg_date'];
        $regDates = explode(' ', $regDates);
        $regDate = $regDates[0];
        $regTime = $regDates[1];

        $regDate = explode('-', $regDate);
        $regYear = $regDate[0];
        $regMonth = $regDate[1];
        $regDay = $regDate[2];

        $dateDay = $regYear . 'λ ' . $regMonth . 'μ ' . $regDay . 'μΌ';
        $dateTime = date('A h:i', strtotime($regTime));

        foreach ($aReport as $val) {
            $aTempT = []; // score νν° λλ¦°κ²
            if ($val['que_type'] === 'T') {
                $aScoreT = json_decode($val['repo_score'], true);
                $aAnalysisT = json_decode($val['repo_analysis'], true);
                $aAnalysisT['sum'] = round($aAnalysisT['sum'], 2);
                $strMemMbti = $val['memMbti'];
                $iJobIdx = $val['jobIdx'];
                $strAppType = $val['appType'];

                if (!$chkMine) {
                    $memName = $val['appShareCom'] == 2 ? $val['memName'] : 'λΉκ³΅κ°'; // λ³ΈμΈκ²μΈμ§ μ²΄ν¬
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
                    if (!$reportScoreRank = cache("report.score.{$val['job_depth_1']}")) { // μ§μμλ€ λ­ν¬ λ°μμ΄
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

        //μλ΅ μ λ’°λ
        if ($aScoreT['sincerity'] >= 1 && $aScoreT['sincerity'] <= 3) {
            $response = 'λ?μ';
        } else if ($aScoreT['sincerity'] >= 4 && $aScoreT['sincerity'] <= 6) {
            $response = 'λ³΄ν΅';
        } else if ($aScoreT['sincerity'] >= 7) {
            $response = 'λμ';
        } else {
            $response = 'λΆμλΆκ°';
        }

        //νμ λΆμ-λ³ΈμΈμ μ 
        $quiver = $aScoreT["quiver"];   //μμ±λ¨λ¦Ό
        $volume = $aScoreT["volume"];   //μμ±ν¬κΈ°
        $tone = $aScoreT["tone"];   //λͺ©μλ¦¬ν€
        $speed = $aScoreT["speed"];   //μμ±μλ
        $diction = $aScoreT["diction"];   //λ°μμ νλ
        $eyes = $aScoreT["eyes"];   //μμ μ²λ¦¬
        $blink = $aScoreT["blink"];   //λκΉλΉ‘μ
        $gesture = $aScoreT["gesture"];   //μ μ€μ²λΉλ
        $head_motion = $aScoreT["head_motion"];   //λ¨Έλ¦¬μμ§μ
        $glow = $aScoreT["glow"];   //νμ‘°νμ

        $realScore = $this->getRealScore($speed, $quiver, $glow, $head_motion, $blink);
        $confidence = ((int)$realScore[0]['quiver'] + (int)$volume + (int)$tone + (int)$realScore[0]['speed']) / 4; //μμ κ°
        $Attitude = ((int)$realScore[0]['head_motion'] + (int)$gesture) / 2; //νλ

        $facial_analysis = array();
        array_push($facial_analysis, array('complexion' => $glow * 10, 'blinking' => $blink * 10, 'pronunciation' => $diction * 10, 'eye_contact' => $eyes * 10, 'confidence' => $confidence * 10, 'Attitude' => $Attitude * 10));

        //νμ λΆμ-νκ· μ μ
        $complexion = $blinking = $pronunciation = $eye_contact = $confidence = $Attitude = 0;
        $facial_total = 0;

        $getAllgetfacialAnalysis = $reportResultModel->getAllgetfacialAnalysis();
        foreach ($getAllgetfacialAnalysis as $facialKey => $facialVal) {
            $facialAnalysisAvg = json_decode($getAllgetfacialAnalysis[$facialKey]['repo_score'], true);

            $quiver = $facialAnalysisAvg["quiver"] ?? 0;   //μμ±λ¨λ¦Ό
            $volume = $facialAnalysisAvg["volume"] ?? 0;   //μμ±ν¬κΈ°
            $tone = $facialAnalysisAvg["tone"] ?? 0;   //λͺ©μλ¦¬ν€
            $speed = $facialAnalysisAvg["speed"] ?? 0;   //μμ±μλ
            $diction = $facialAnalysisAvg["diction"] ?? 0;   //λ°μμ νλ
            $eyes = $facialAnalysisAvg["eyes"] ?? 0;   //μμ μ²λ¦¬
            $blink = $facialAnalysisAvg["blink"] ?? 0;   //λκΉλΉ‘μ
            $gesture = $facialAnalysisAvg["gesture"] ?? 0;   //μ μ€μ²λΉλ
            $head_motion = $facialAnalysisAvg["head_motion"] ?? 0;   //λ¨Έλ¦¬μμ§μ
            $glow = $facialAnalysisAvg["glow"] ?? 0;   //νμ‘°νμ

            $realScore = $this->getRealScore($speed, $quiver, $glow, $head_motion, $blink);
            $confidence_cate = ((int)$realScore[0]['quiver'] + (int)$volume + (int)$tone + (int)$realScore[0]['speed']) / 4; //μμ κ°
            $Attitude_cate = ((int)$realScore[0]['head_motion'] + (int)$gesture) / 2; //νλ

            $complexion += (int)$glow;   //μμ
            $blinking += (int)$blink;    //λκΉλΉ‘μ
            $pronunciation += (int)$diction; //λ°μμ νλ
            $eye_contact += (int)$eyes; //μμ λ§μ£ΌμΉ¨
            $confidence += (int)$confidence_cate;   //μμ κ°
            $Attitude += (int)$Attitude_cate;   //νλ
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

        //iv_applierμ app_shareλ comprehensiveλ κ°μ΄ 0μ΄ μλκ³  res_idxκ° μμΌλ©΄ 
        if (!empty($checkHaveResume['res_idx']) && !empty($getJobcategory['idx'])) {
            //μ΄λ ₯μ λ ν¬νΈ
            $resumeReport = $this->resumeReport($iApplierIdx);
            $this->aData['data']['resume'] = $resumeReport;

            //μ΄λ ₯μ λ΄ SPEC μ μ κ΅¬νκΈ°
            $getResumeScore = $resumeModel->select('res_analysis');
            $getResumeScore = $resumeModel->getResumeScore($iApplierIdx)->first();

            $eduScore = (float)json_decode($getResumeScore['res_analysis'])->edu->score;
            $careerScore = (float)json_decode($getResumeScore['res_analysis'])->career->score;
            $languageScore = (float)json_decode($getResumeScore['res_analysis'])->language->score;
            $licenseScore = (float)json_decode($getResumeScore['res_analysis'])->license->score;

            $aScoreArr = array();
            array_push($aScoreArr, array('edu' => number_format($eduScore, 2), 'career' => number_format($careerScore, 2), 'language' => number_format($languageScore, 2), 'license' => number_format($licenseScore, 2)));

            //μ΄λ ₯μ νκ·  SPEC μ μ κ΅¬νκΈ°
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


            //μ΄λ ₯μ νλͺ©λ³ νκ°
            $getResumeText = $this->getResumeText($aScoreArr, $aAvgScoreArr, $iAvgCnt, $avgArr);
            $this->aData['data']['resume']['text'] = $getResumeText;

            //μ’ν©λ±κΈ / μ’ν©μ μ
            $getResumeTotal = $this->getResumeTotal($aScoreArr);
            $this->aData['data']['resume']['atotal'] = $getResumeTotal;
            $this->aData['data']['resumeScore'] = number_format((float)$getResumeTotal[0]['score'], 2);

            $isRes = true;
        } else {
            $isRes = false;
        }

        $this->aData['data']['response'] = $response ?? ''; //μλ΅μ λ’°λ
        $this->aData['data']['facialAnalysis'] = $facial_analysis[0] ?? []; //νμ λΆμ-λ³ΈμΈμ μ
        $this->aData['data']['facialAnalysisAvg'] = $facial_result[0] ?? [];   //νμ λΆμ-νκ· μ μ
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
        if ($speed == 1) {  //μμ±μλ
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

        if ($quiver == 0) { //λͺ©μλ¦¬λ¨λ¦Ό
            $quiver = 0;
        } else {
            $quiver = 11 - $quiver;
        }

        if ($glow == 0) {   //νμ‘°νμ
            $glow = 0;
        } else {
            $glow = 11 - $glow;
        }

        if ($head_motion == 0) {  //λ¨Έλ¦¬μμ§μ
            $head_motion = 0;
        } else {
            $head_motion = 11 - $head_motion;
        }

        if ($blink == 0) { //λκΉλΉ‘μ
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

        //μ΄λ ₯μ λ ν¬νΈ
        //μ΄λ ₯μ μ§λ¬΄ μΆμΆ
        $reportResume = new ReportResumeModel();

        $getJobcategory = $reportResume->getJobcategory($iApplierIdx);

        $job_idx = $getJobcategory['idx'];
        $job_depth_text = $getJobcategory['job_depth_text'];
        //μ΄ μ§μμ μ - κ°μ μ§λ¬΄ μ§μμ 
        $getTotal = $reportResume->getTotal($job_idx);
        $total = $getTotal->cnt;
        $arrDate['total'] = $total;

        //μ§μμ νν© λΆμ - κ°ν­λͺ©(%) = ν­λͺ© κ°μ / μ μ²΄ κ°μ * 100
        //νλ ₯λ³ νν©
        $getTotalEdu = $reportResume->getTotalEdu($job_idx);
        $arrDate['totalEdu'] = $getTotalEdu;
        $getTopE10 = $this->getTop10($getTotalEdu[0], 'edu', 5); // μμ 10%
        $arrDate['top']['edu'] = $getTopE10;

        //κ²½λ ₯λ³ νν©
        $getTotalCareer = $reportResume->getTotalCareer($job_idx); //a5
        $arrDate['totalCareer'] = $getTotalCareer;
        $getTopC10 = $this->getTop10($getTotalCareer[0], 'career', 5); // μμ 10%
        $arrDate['top']['career'] = $getTopC10;

        //μΈκ΅­μ΄ νν©
        $getTotalLanguage = $reportResume->getTotalLanguage($job_idx); //a6
        $arrDate['totalLanguage'] = $getTotalLanguage;
        $getTopL10 = $this->getTop10($getTotalLanguage[0], 'language', 6); // μμ 10%
        $arrDate['top']['language'] = $getTopL10;

        //TOEIC μ μ νν©
        $getTotalToeicscore = $reportResume->getTotalToeicscore($job_idx); //a5
        $arrDate['totalToeicscore'] = $getTotalToeicscore;
        $getTopT10 = $this->getTop10($getTotalToeicscore[0], 'toeicscore', 5); // μμ 10%
        $arrDate['top']['toeicscore'] = $getTopT10;

        //μκ²©μ¦ κ°μ
        $getTotalLicense = $reportResume->getTotalLicense($job_idx); //a5
        $arrDate['totalLicense'] = $getTotalLicense;
        $getTopI10 = $this->getTop10($getTotalLicense[0], 'license', 5); // μμ 10%
        $arrDate['top']['license'] = $getTopI10;

        //νλ μ§μ
        $getTotalActivity = $reportResume->getTotalActivity($job_idx); //a5
        $arrDate['totalActivity'] = $getTotalActivity;
        $getTopA10 = $this->getTop10($getTotalActivity[0], 'activity', 5); // μμ 10%
        $arrDate['top']['activity'] = $getTopA10;

        //λμ μ€ν - κ°ν­λͺ©(100μ  λ§μ ) ν­λͺ© μμ / 1μ * 100
        //νλ ₯
        //κ²½λ ₯
        //μ΄ν
        //μκ²©μ¦


        return $arrDate;
    }

    private function getTop10($arrData, $tpye, $langth)
    {
        for ($i = 1; $i <= $langth; $i++) { //μ΄κΈ°ν
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

        //ν­λͺ©λ³ νκ°

        arsort($avgArr['edu']); // λ°°μ΄μ κ°μΌλ‘ λ΄λ¦Όμ°¨μ μ λ ¬νκ³  μΈλ±μ€μ μκ΄κ΄κ³ μ μ§print_r($fruits);
        $i = 0;
        foreach ($avgArr['edu'] as $key => $val) {
            $eduSortArr[$i] = $val;
            $i++;
        }
        $eduRank =  array_search($aScoreArr[0]['edu'], $eduSortArr);

        arsort($avgArr['career']); // λ°°μ΄μ κ°μΌλ‘ λ΄λ¦Όμ°¨μ μ λ ¬νκ³  μΈλ±μ€μ μκ΄κ΄κ³ μ μ§print_r($fruits);
        $i = 0;
        foreach ($avgArr['career'] as $key => $val) {
            $careerSortArr[$i] = $val;
            $i++;
        }
        $careerRank =  array_search($aScoreArr[0]['career'], $careerSortArr);

        arsort($avgArr['language']); // λ°°μ΄μ κ°μΌλ‘ λ΄λ¦Όμ°¨μ μ λ ¬νκ³  μΈλ±μ€μ μκ΄κ΄κ³ μ μ§print_r($fruits);
        $i = 0;
        foreach ($avgArr['language'] as $key => $val) {
            $languageSortArr[$i] = $val;
            $i++;
        }
        $languageRank =  array_search($aScoreArr[0]['language'], $languageSortArr);

        arsort($avgArr['license']); // λ°°μ΄μ κ°μΌλ‘ λ΄λ¦Όμ°¨μ μ λ ¬νκ³  μΈλ±μ€μ μκ΄κ΄κ³ μ μ§print_r($fruits);
        $i = 0;
        foreach ($avgArr['license'] as $key => $val) {
            $licenseSortArr[$i] = $val;
            $i++;
        }
        $licenseRank =  array_search($aScoreArr[0]['license'], $licenseSortArr);

        //(μ μ²΄ μ - μ§μμ μμ) * 100     
        $eduT = 100 - (($iAvgCnt - $eduRank) / $iAvgCnt * 100);
        $careerT = 100 - (($iAvgCnt - $careerRank) / $iAvgCnt * 100);
        $languageT = 100 - (($iAvgCnt - $languageRank) / $iAvgCnt * 100);
        $licenseT = 100 - (($iAvgCnt - $licenseRank) / $iAvgCnt * 100);

        switch ($eduT) {

            case $eduT <= 10:
                $eduText = "μ§μμ λλΉ νκ΅ λ±κΈ λ° νλ ₯μ΄ νλ₯­ν©λλ€.";
                break;
            case $eduT > 10 && $eduT <= 30:
                $eduText = "μ§μμ λλΉ νκ΅ λ±κΈ λ° νλ ₯μ΄ λ€μ λμ νΈμλλ€.";
                break;
            case $eduT > 30 && $eduT <= 50:
                $eduText = "μ§μμ λλΉ νκ΅ λ±κΈ λ° νλ ₯μ΄ μ μ ν νΈμλλ€.";
                break;
            case $eduT > 50 && $eduT <= 100:
                $eduText = "μ§μμ λλΉ νκ΅ λ±κΈ λ° νλ ₯μ΄ λ€μ λ?μ νΈμλλ€. κ²½λ ₯, μ΄ν, μκ²©μ¦μ μ μλ₯Ό λμ΄κΈ° μν΄ λΈλ ₯μ νλ©΄ ν©κ²©λ₯ μ΄ λμμ§ μ μμ΅λλ€. ";
                break;
            default:
        }
        switch ($careerT) {

            case $careerT <= 10:
                $careerText = "μ§μμ λλΉ μΈν΄, λμΈνλ λ± κ²½λ ₯μ΄ νλ₯­ν©λλ€. λ³Έ κ²½λ ₯μ λ©΄μ  λ μ΄νν΄ λ³΄μΈμ. νΈκ°λ λ° μμ¬μ μ λ¦¬νκ² μμ©ν  μ μμ΅λλ€.";
                break;
            case $careerT > 10 && $careerT <= 30:
                $careerText = "μ§μμ λλΉ μΈν΄, λμΈνλ λ± κ²½λ ₯μ΄ λ€μ λμ νΈμλλ€. λ©΄μ  λ μ΄νν΄ λ³΄μΈμ. μμ¬μ μ λ¦¬νκ² μμ©ν  μ μμ΅λλ€.";
                break;
            case $careerT > 30 && $careerT <= 50:
                $careerText = "μ§μμ λλΉ μΈν΄, λμΈνλ λ± κ²½λ ₯μ΄ μ μ ν νΈμλλ€. κ³΅λͺ¨μ , μΈν΄ κ²½ν λ± λ€μν νλμΌλ‘ κ²½λ ₯ μ μλ₯Ό λμ¬ λ³΄μΈμ.";
                break;
            case $careerT > 50 && $careerT <= 100:
                $careerText = "μ§μμ λλΉ μΈν΄, λμΈνλ λ± κ²½λ ₯μ΄ λ€μ λ?μ νΈμλλ€. μ§μν μ§λ¬΄μ κ΄λ ¨λ λ€μν νλμ μ°Έμ¬ν΄ λ³΄μΈμ.";
                break;
            default:
        }
        switch ($languageT) {
            case $iAvgCnt <= 1:
                $languageText = "κ°μ μΌλ‘ μ΄νν  μ μλλ‘ μ΄νμ μλ₯Ό λμ΄μ¬λ € λ³΄μΈμ.";
                break;
            case $languageT <= 10:
                $languageText = "μ΄νμ μκ° λ€λ₯Έ μ§μμ λλΉ νλ₯­ν©λλ€. μ§λ¬΄μ μ°κ΄μμΌ μ΄νμ μμ λν κ°μ μ λ©΄μ μ μ΄νν΄ λ³΄μΈμ.";
                break;
            case $languageT > 10 && $languageT <= 30:
                $languageText = "μ΄νμ μκ° λ€λ₯Έ μ§μμ λλΉ λ€μ λμ νΈμλλ€. λ€λ₯Έ μ΄νμ λμ μ νκ±°λ, μ μλ₯Ό μ μ§ν  μ μλλ‘ ν΄ μ£ΌμΈμ.";
                break;
            case $languageT > 30 && $languageT <= 50:
                $languageText = "μ΄νμ μκ° λ€λ₯Έ μ§μμ λλΉ μ μ ν νΈμλλ€. κ°μ μΌλ‘ μ΄νν  μ μλλ‘ μ΄νμ μλ₯Ό λμ΄μ¬λ € λ³΄μΈμ.";
                break;
            case $languageT > 50 && $languageT <= 100:
                $languageText = "μ΄νμ μκ° λ€λ₯Έ μ§μμ λλΉ λ€μ λ?μ νΈμλλ€. μ μλ₯Ό μ¬λ¦΄ μ μλλ‘ μ‘°κΈ λ λΈλ ₯ν΄ μ£ΌμΈμ.";
                break;
            default:
        }
        switch ($licenseT) {
            case $iAvgCnt <= 1:
                $licenseText = "κ²½μλ ₯μ κ°μΆ μ μλλ‘ μκ²©μ¦ κ°μλ₯Ό λλ € λ³΄μΈμ.";
                break;
            case $licenseT <= 10:
                $licenseText = "μκ²©μ¦ μ’λ₯ λ° κ°μκ° ν μ§μμ λλΉ νλ₯­ν©λλ€. λ©΄μ  μ μκ²©μ¦μ λν κ°μ μ ν¨κ³Όμ μΌλ‘ λ°νν΄ λ³΄μΈμ.";
                break;
            case $licenseT > 10 && $licenseT <= 30:
                $licenseText = "μκ²©μ¦ μ’λ₯ λ° κ°μκ° ν μ§μμ λλΉ λ€μ λμ νΈμλλ€. μ§λ¬΄μ κ΄λ ¨λ λΆμΌμ μκ²©μ¦μ΄ μ΄λ μ λμΈμ§ μ²΄ν¬ν΄ λ³΄μΈμ.";
                break;
            case $licenseT > 30 && $licenseT <= 50:
                $licenseText = "μκ²©μ¦ μ’λ₯ λ° κ°μκ° ν μ§μμ λλΉ μ μ ν νΈμλλ€. κ²½μλ ₯μ κ°μΆ μ μλλ‘ μκ²©μ¦ κ°μλ₯Ό λλ € λ³΄μΈμ.";
                break;
            case $licenseT > 50 && $licenseT <= 100:
                $licenseText = "μκ²©μ¦ μ’λ₯ λ° κ°μκ° ν μ§μμ λλΉ λ€μ λΆμ‘±ν©λλ€. ν©κ²©λ₯ μ μ¬λ¦¬κΈ° μν΄ μ§λ¬΄μ κ΄λ ¨λ μκ²©μ¦ μμμ λμ ν΄ λ³΄μΈμ.";
                break;
            default:
        }

        $aTextArr = array();
        array_push($aTextArr, array('edu' => $eduText, 'career' => $careerText, 'language' => $languageText, 'license' => $licenseText));

        return $aTextArr;
    }

    private function getResumeTotal($aScoreArr)
    {
        //μ’ν©μ μ
        //κ°νλͺ© ν© / 4
        $totalAve = ($aScoreArr[0]['edu'] + $aScoreArr[0]['career'] + $aScoreArr[0]['language'] + $aScoreArr[0]['license']) / 4;
        //μ’ν©νμ 
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
        $aResult = ['stat' => false, 'mbti' => 'MBTI', 'score' => 0, 'msg' => 'μ°κ΄λ', 'recommendJob' => []];

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

        if (!$aResult['stat']) { // job_idxκ° aMbtiDataμ μΌμΉνλκ²μ΄ μμλ ex) 3depthλ³κ²½μ  λ¦¬ν¬νΈ
            $aResult = [];
        }

        return $aResult;
    }
}
