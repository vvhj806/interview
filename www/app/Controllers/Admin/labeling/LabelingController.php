<?php

namespace App\Controllers\Admin\labeling;

use App\Models\{
    ApplierModel,
    CompanyQuestionCategoryModel,
    CompanySuggestApplicantModel,
    CompanySuggestModel,
    MemberModel,
    JobCategoryModel,
    ReportResultModel
};

use App\Libraries\{
    SendLib,
    ShortUrlLib
};
use Config\Services;
use App\Controllers\Admin\AdminController;

class LabelingController extends AdminController
{
    public $sLabel = [
        'dialect' => ['name' => '방언 빈도', 'type' => 0],
        'quiver' => ['name' => '음성 떨림', 'type' => 1],
        'volume' => ['name' => '음성 크기', 'type' => 1],
        'tone' => ['name' => '목소리 톤', 'type' => 1],
        'speed' => ['name' => '음성 속도', 'type' => 2],
        'diction' => ['name' => '발음 정확도', 'type' => 1],
        'sincerity' => ['name' => '성실답변률', 'type' => 1],
        'understanding' => ['name' => '질문 이해도', 'type' => 3],
        'eyes' => ['name' => '시선 처리', 'type' => 3],
        'smile' => ['name' => '긍정적 표정', 'type' => 0],
        'mouth_motion' => ['name' => '입 움직임', 'type' => 4],
        'blink' => ['name' => '눈 깜빡임', 'type' => 0],
        'gesture' => ['name' => '제스쳐 빈도', 'type' => 0],
        'head_motion' => ['name' => '머리 움직임', 'type' => 0],
        'glow' => ['name' => '홍조 현상', 'type' => 1],
        'foreign' => ['name' => '외국어 빈도', 'type' => 0]
    ];

    public $tLabel = [
        'gender' => ['name' => '성별 예측', 'type' => 7],
        'age' => ['name' => '나이 예측', 'type' => 7],
        'skin' => ['name' => '피부톤', 'type' => 5],
        'beard' => ['name' => '수염 비중', 'type' => 0],
        'hair_length' => ['name' => '머리 길이', 'type' => 6],
        'glasses' => ['name' => '안경 착용 여부', 'type' => 7]
    ];

    public $labelType = ['적음 → 많음', '낮음 → 높음', '느림 → 빠름', '불안정 → 안정', '작음 → 큼', '어두움 → 밝음', '짧은 머리 → 긴머리', ''];

    public function quick()
    {
        $session = session();

        if (!$session->get('idx')) {
            return redirect($this->globalvar->getAdminLogin());
        } else {
            if (!in_array($session->get('mem_type'), ['A', 'L'])) {
                return redirect($this->globalvar->getMain());
            } else {
                alert_url('라벨링 페이지로 이동됩니다.', 'prime/labeling/list');
            }
        }
    }
    public function list()
    {
        $this->commonData();

        $applierModel = new ApplierModel();
        $memberModel = new MemberModel();
        $reportResultModel = new ReportResultModel();

        $iLbIdx = $this->request->getGet('lbIdx') ?? ''; // 해당 라벨러가 분석한것만 검색
        $strLbSearch = $this->request->getGet('lbSearch') ?? ''; // 번호 검색

        if ($strLbSearch) {
            $applierModel->where(['iv_applier.idx' => $strLbSearch]);
        }
        if ($iLbIdx) {
            $applierModel->where(['iv_labeler_count.mem_idx' => $iLbIdx]);
        }

        $applierModel
            ->select([
                'iv_applier.idx AS appIdx', 'iv_applier.app_reg_date AS appRegDate',
                'iv_applier.app_iv_stat AS appStat', 'iv_member.mem_id AS memId',
                'iv_file.file_save_name AS fileName', 'iv_job_category.job_depth_text AS jobText',
                'iv_labeler_count.lab_stat AS labStat'
            ])
            ->join('iv_member', 'iv_applier.mem_idx = iv_member.idx', 'inner')
            ->join('iv_file', 'iv_applier.file_idx_thumb = iv_file.idx', 'left')
            ->join('iv_job_category', 'iv_applier.job_idx = iv_job_category.idx', 'left')
            ->join('iv_labeler_count', 'iv_applier.idx = iv_labeler_count.app_idx AND iv_labeler_count.delyn = "N" ', 'left')
            ->where([
                'iv_applier.delyn' => 'N',
                'iv_applier.app_iv_stat >=' => 3
            ])
            ->orderBy('app_iv_stat', 'ASC')
            ->orderBy('appIdx', 'DESC');

        $aList = $applierModel->paginate(10, 'applier');
        foreach ($aList as $key => $val) {
            if ($val['appStat'] == '3') {
                $aList[$key]['appStat'] = '분석 대기';
                if ($val['labStat'] == '1') {
                    $aList[$key]['appStat'] = '분석 중';
                }
            } else if ($val['appStat'] == '5') {
                $aList[$key]['appStat'] = '분석 불가';
            } else {
                $aList[$key]['appStat'] = '분석 완료';
                $aList[$key]['sttLog'] = $reportResultModel
                    ->select(['iv_member.mem_id AS memId'])
                    ->join('iv_labeler_stt_log', 'iv_labeler_stt_log.res_idx = iv_report_result.idx')
                    ->join('iv_member', 'iv_member.idx = iv_labeler_stt_log.mem_idx')
                    ->where(['iv_report_result.applier_idx' => $val['appIdx']])
                    ->first();
            }
        }

        $aLbList = $memberModel
            ->builderLbStat()
            ->select(['iv_member.mem_id as memId', 'iv_labeler_stat.mem_idx as memIdx'])
            ->findAll();

        foreach ($aLbList as $key => $val) {
            if ($val['memIdx'] === $this->aData['data']['session']['idx']) {
                $boolStat = true;
                break;
            }
        }

        $this->aData['data']['labelIdx'] = $iLbIdx;
        $this->aData['data']['search'] = $strLbSearch;
        $this->aData['data']['list'] = $aList ?? [];
        $this->aData['data']['count'] = $applierModel->pager->getTotal('applier') ?? 0;
        $this->aData['data']['pager'] = $applierModel->pager;
        $this->aData['data']['labeler'] = $aLbList ?? [];
        $this->aData['data']['stat'] = $boolStat ?? false;
        // view

        $this->header();
        $this->nav();
        echo view('prime/labeling/list', $this->aData);
        $this->footer();
    }

    public function statAction()
    {
        $this->commonData();

        $boolChecked = $this->request->getPost('lbStat') ?? false; // total repo result idx

        //트랜잭션 start
        $this->masterDB->transBegin();

        $this->masterDB->table('iv_labeler_stat')
            ->set([
                'lab_stat' => $boolChecked ? 1 : 0
            ])
            ->set(['app_mod_date' => 'NOW()'], '', false)
            ->where([
                'mem_idx' => $this->aData['data']['session']['idx']
            ])
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

    public function detail(int $iAppIdx)
    {
        $this->commonData();

        $applierModel = new ApplierModel();
        $memberModel = new MemberModel();

        $aList = $applierModel
            ->getDetail($iAppIdx)
            ->select(['iv_member.mem_id', 'iv_report_result.repo_answer_time'])
            ->join('iv_member', 'iv_applier.mem_idx = iv_member.idx', 'left')
            ->where('iv_report_result.que_type', 'T')
            ->first();

        $aLbList = $memberModel
            ->builderLbCount()
            ->select(['iv_member.mem_id as memId', 'iv_labeler_count.lab_stat'])
            ->where(['iv_labeler_count.app_idx' => $iAppIdx])
            ->first();

        $this->aData['data']['list'] = $aList;
        $this->aData['data']['labeler'] = $aLbList;
        $this->aData['data']['appIdx'] = $iAppIdx;

        // view
        $this->header();
        $this->nav();
        echo view('prime/labeling/detail', $this->aData);
        $this->footer();
    }

    public function detailAction(int $iAppIdx)
    {
        $this->commonData();

        $applierModel = new ApplierModel();

        $boolChecked = $this->request->getPost('lbStat') ?? false; // total repo result idx
        $iMemIdx = $this->aData['data']['session']['idx'];

        //트랜잭션 start
        $this->masterDB->transBegin();

        $chk = $applierModel
            ->select(['iv_labeler_count.mem_idx as memIdx'])
            ->join('iv_labeler_count', 'iv_applier.idx = iv_labeler_count.app_idx', 'left')
            ->where(['iv_labeler_count.app_idx' => $iAppIdx])
            ->first();

        if ($chk ?? false) {
            if ($chk['memIdx'] != $iMemIdx) {
                alert_back('이미 다른 사람이 체크');
                exit;
            }
        }

        if ($boolChecked) {
            $this->masterDB->table('iv_labeler_count')
                ->set([
                    'lab_stat' => 1,
                    'mem_idx' => $iMemIdx,
                    'app_idx' => $iAppIdx
                ])
                ->set(['lab_cnt_reg_date' => 'NOW()'], '', false)
                ->insert();
        } else {
            $this->masterDB->table('iv_labeler_count')
                ->set([
                    'delyn' => 'Y'
                ])
                ->set(['lab_cnt_del_date' => 'NOW()'], '', false)
                ->where([
                    'mem_idx' => $iMemIdx, 'app_idx' => $iAppIdx,
                    'lab_stat' => 1, 'delyn' => 'N'
                ])
                ->update();
        }

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

    public function score(int $iAppIdx)
    {
        $this->commonData();

        $applierModel = new ApplierModel();

        $aList = $applierModel
            ->select([
                'iv_applier.idx', 'iv_report_result.idx AS repo_idx', 'iv_report_result.que_type',
                'iv_report_result.repo_score', 'iv_report_result.repo_analysis', 'iv_report_result.repo_speech_txt_detail',
                'iv_job_category.job_depth_text', 'iv_job_category.job_depth_1', 'iv_applier.app_share',
                'iv_applier.app_share_company', 'iv_video.video_record', 'iv_question.que_question',
                'iv_labeler_stt_log.idx as sttLog', 'iv_member.mem_id as memId'
            ])
            ->join('iv_video', 'iv_applier.idx = iv_video.app_idx', 'left')
            ->join('iv_report_result', 'iv_video.repo_res_idx = iv_report_result.idx', 'left')
            ->join('iv_job_category', 'iv_applier.job_idx = iv_job_category.idx', 'left')
            ->join('iv_question', 'iv_video.que_idx = iv_question.idx', 'left')

            ->join('iv_labeler_stt_log', 'iv_report_result.idx = iv_labeler_stt_log.res_idx', 'left')
            ->join('iv_member', 'iv_labeler_stt_log.mem_idx = iv_member.idx', 'left')

            ->where(['iv_report_result.que_type' => 'S',])
            ->where('iv_applier.delyn', 'N')
            ->where('iv_applier.idx', $iAppIdx)
            ->groupBy('repo_idx')
            ->findAll();

        $aList[] = $applierModel
            ->select([
                'iv_applier.idx', 'iv_report_result.idx AS repo_idx', 'iv_report_result.que_type',
                'iv_report_result.repo_score', 'iv_report_result.repo_analysis', 'iv_applier.app_share',
                'iv_applier.app_share_company', 'iv_report_result.repo_speech_txt_detail'
            ])
            ->join('iv_report_result', 'iv_applier.idx = iv_report_result.applier_idx', 'left')
            ->where(['iv_report_result.que_type' => 'T',])
            ->where('iv_applier.delyn', 'N')
            ->where('iv_applier.idx', $iAppIdx)
            ->first();

        foreach ($aList as $key => $val) {
            $aList[$key]['repo_score'] = json_decode($val['repo_score'], true);
            $aList[$key]['repo_analysis'] = json_decode($val['repo_analysis'], true);
            if ($val['que_type'] === 'T') {
                if ($aList[$key]['repo_score']) {
                    if (is_array($aList[$key]['repo_score']['age'])) {
                        $temp = array_search(max($aList[$key]['repo_score']['age']), $aList[$key]['repo_score']['age']) + 1;
                        $aList[$key]['repo_score']['age'] = "$temp";
                    }
                }
            }
            //elseif ($val['que_type'] === 'S') {}
        }

        $this->aData['data']['appIdx'] = $iAppIdx;
        $this->aData['data']['list'] = $aList;
        $this->aData['data']['type'] = $this->labelType;
        $this->aData['data']['label'] = $this->sLabel;
        $this->aData['data']['labelTotal'] = $this->tLabel;

        // view
        $this->header();
        $this->nav();
        echo view('prime/labeling/score', $this->aData);
        $this->footer();
    }

    public function scoreAction(int $iAppIdx)
    {
        $this->commonData();

        $boolStat = true; // 분석불가인지 아닌지
        $aRepoIdx = $this->request->getPost('repo_result_idx'); // total 제외한 repo result idx
        $iRepoIdxTotal = $this->request->getPost('repo_result_idx_total'); // total repo result idx

        $aScoreTotal = $this->request->getPost($iRepoIdxTotal); // que_type = T

        foreach ($aRepoIdx as $iRepoIdx) { // que_type = S
            $aScore[$iRepoIdx] = $this->request->getPost($iRepoIdx);

            foreach ($aScore[$iRepoIdx] as $scoreType => $val) {
                if (isset($aScoreTotal[$scoreType])) { // 전부 다한값
                    $aScoreTotal[$scoreType] += $val;
                } else {
                    $aScoreTotal[$scoreType] = $val;
                }
            }
        }

        foreach ($aScoreTotal as $key => $val) { // que_type = T
            if (!in_array($key, ['gender', 'age', 'skin', 'beard', 'hair_length', 'glasses'])) {
                $aScoreTotal[$key] = round($val / count($aRepoIdx)); // 평균값
                if (($key === 'sincerity') && ($aScoreTotal[$key] == 0)) { // sincerity 성실도가 0이면 분석불가
                    $boolStat = false;
                }
            } else if ($key === 'gender') { // 성별
                $rand = mt_rand(80, 100);
                if ($val == "male") {
                    $val = [$rand, (100 - $rand)];
                } else if ($val == "female") {
                    $val = [(100 - $rand), $rand];
                }
                $aScoreTotal[$key] = $val;
            } else if ($key === 'age') { // 나이
                $rand = mt_rand(60, 80);
                if ($val == 10) {
                    $val = [$rand, (100 - $rand), 0, 0, 0, 0, 0]; //([10대], 20대, 0, 0, 0, 0, 0)
                } else if ($val == 20) {
                    $rand1 = mt_rand(0, 100 - $rand);
                    $rand2 = 100 - $rand1 - $rand;
                    $val = [$rand1, $rand, $rand2, 0, 0, 0, 0]; //(10대, [20대], 30대, 0, 0, 0, 0)
                } else if ($val == 30) {
                    $rand1 = mt_rand(0, 100 - $rand);
                    $rand2 = 100 - $rand1 - $rand;
                    $val = [0, $rand1, $rand, $rand2, 0, 0, 0]; //(0, 20대, [30대], 40대, 0, 0, 0)
                } else if ($val == 40) { //20~40대
                    $rand1 = mt_rand(0, 100 - $rand);
                    $rand2 = 100 - $rand1 - $rand;
                    $val = [0, 0, $rand1, $rand, $rand2, 0, 0]; //(0, 0, 30대, [40대], 50대, 0, 0)
                } else if ($val == 50) {
                    $rand1 = mt_rand(0, 100 - $rand);
                    $rand2 = 100 - $rand1 - $rand;
                    $val = [0, 0, 0, $rand1, $rand, $rand2, 0]; //(0, 0, 0, 40대, [50대], 60대, 0)
                } else if ($val == 60) {
                    $rand1 = mt_rand(0, 100 - $rand);
                    $rand2 = 100 - $rand1 - $rand;
                    $val = [0, 0, 0, 0, $rand1, $rand, $rand2]; //(0, 0, 0, 50대, [60대], 70대)
                } else if ($val == 70) {
                    $val = [0, 0, 0, 0, 0, (100 - $rand), $rand]; //(0, 0, 0, 0, 0, 60대, [70대])
                }
                $aScoreTotal[$key] = $val;
            }
        }

        $aScore[$iRepoIdxTotal] = $aScoreTotal; // que_type = S, T 합침 

        //트랜잭션 start
        $this->masterDB->transBegin();

        foreach ($aScore as $repoIdx => $score) {
            $this->masterDB->table('iv_report_result')
                ->set([
                    'repo_process' => 2,
                    'repo_score' => json_encode($score),
                    'repo_analysis' => json_encode($this->calculAnalysis($score)),
                ])
                ->set(['repo_mod_date' => 'NOW()'], '', false)
                ->where([
                    'idx' => $repoIdx,
                    'applier_idx' => $iAppIdx,
                ])
                ->update();
        }

        $iStat = $boolStat ? 4 : 5;

        $this->masterDB->table('iv_applier')
            ->set([
                'app_iv_stat' => $iStat
            ])
            ->set(['app_mod_date' => 'NOW()'], '', false)
            ->where([
                'idx' => $iAppIdx
            ])
            ->update();

        $applierModel = new ApplierModel();
        $aApplierInfo = $applierModel
            ->select(['iv_applier.app_iv_stat as appStat', 'iv_member.mem_tel as memTel', 'iv_job_category.job_depth_text as jobText'])
            ->select(['iv_member.mem_type as memType', 'iv_company_suggest_applicant.idx as apIdx'])
            ->join('iv_member', 'iv_member.idx = iv_applier.mem_idx AND iv_member.delyn = "N" ', 'inner')
            ->join('iv_job_category', 'iv_job_category.idx = iv_applier.job_idx', 'left')
            ->join('iv_company_suggest_applicant', 'iv_company_suggest_applicant.app_idx = iv_applier.idx', 'left')
            ->where(['iv_applier.idx' => $iAppIdx, 'iv_applier.delyn' => 'N'])
            ->first();

        if (!in_array($aApplierInfo['appStat'], [4, 5])) {
            $this->masterDB->table('iv_labeler_count')
                ->set(['lab_stat' => 2])
                ->set(['lab_cnt_reg_date' => 'NOW()'], '', false)
                ->where(['app_idx' => $iAppIdx])
                ->update();
        }

        // 트랜잭션 end
        if ($this->masterDB->transStatus() === false) {
            $this->masterDB->transRollback();
            alert_back($this->globalvar->aMsg['error3']);
            exit;
        } else {
            $this->masterDB->transCommit();

            if (!in_array($aApplierInfo['appStat'], [4, 5])) {
                $sendLib = new SendLib();
                $shortUrlLib = new ShortUrlLib();
                $companySuggestApplicantModel = new CompanySuggestApplicantModel();
                $companySuggestModel = new CompanySuggestModel();
                $this->encrypter = Services::encrypter();

                $strEnAppIdx = base64url_encode($this->encrypter->encrypt(json_encode($iAppIdx)));

                if ($boolStat) {
                    $strResetUrl = "/report/detail/{$strEnAppIdx}";
                } else {
                    $strResetUrl = "/report/fail/{$strEnAppIdx}";
                }

                $applicantInfo = $companySuggestApplicantModel->getApplicantInfo2($iAppIdx)->first();
                $getSuggestInfo = $companySuggestModel->getSuggestInfo($applicantInfo['sug_idx'])->first();

                $strShortUrl = $shortUrlLib->setShortUrl($strResetUrl, date('is'));
                $strReseturl = $this->globalvar->getShortUrl() . '/' . $strShortUrl;
                if ($aApplierInfo['memType'] == 'U') {
                    $encrypt_data = $this->setEncrypt($applicantInfo['app_idx'], "bluevisorencrypt");
                    $strReseturl = $this->generateDynamicLink($encrypt_data);
                }


                if ($applicantInfo['gs_ck'] == 'Y') {
                    $strToTel = $getSuggestInfo['sug_manager_tel'];
                } else {
                    $strToTel = $aApplierInfo['memTel'];
                }

                if ($boolStat) {
                    $strMsg = "고객님이 응시하신 {$aApplierInfo['jobText']} 인공지능 분석이 완료되었습니다.\n\n바로가기 : {$strReseturl}";
                } else {
                    $strMsg = "고객님이 응시하신 {$aApplierInfo['jobText']}의 인공지능 리포트가 데이터 부족으로 발행되지 않았습니다.\n\n바로가기 : {$strReseturl}";
                }

                $sendLib->sendSMS($strToTel, $strMsg);

                if ($iAppIdx) {
                    $url = "https://api.highbuff.com/interview/20/link_applicant.php";
                    $post_data = array(
                        'type' => 'end',
                        'ap_idx' => $iAppIdx
                    );

                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $result = curl_exec($ch);
                    curl_close($ch);
                }
            }

            alert_back($this->globalvar->aMsg['success1']);
            exit;
        }
    }

    public function lbQuick()
    {
        $session = session();
        if ($session->get('idx') ?? false) {
        }
        session()->destroy();
    }

    public function asd2()
    {
        $this->commonData();

        $ddd = [
            "1" => "157",
            "12" => "446",
            "23" => "382",
            "41" => "227",
            "50	" => "248",
            "63	" => "",
            "77	" => "195",
            "88	" => "",
            "101" => "281",
            "110" => "446",
            "119" => "227",
            "132" => "187",
            "142" => "",
            "151" => "463",
            "153" => "466",
        ];


        //트랜잭션 start
        $this->masterDB->transBegin();
        foreach ($ddd as $before => $after) {
            if ($after) {
                $this->masterDB->table('iv_member_recruit_category')
                    ->set(['job_idx' => $after,])
                    ->where(['job_idx' => $before])
                    ->update();
            } else {
                $this->masterDB->table('iv_member_recruit_category')
                    ->set(['delyn' => 'Y',])
                    ->where(['job_idx' => $before])
                    ->update();
            }
        }
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
    public function asd()
    {
        $this->commonData();
        $grade = ['S', 'A', 'B', 'C', 'D'];

        //트랜잭션 start
        $this->masterDB->transBegin();

        for ($i = 16; $i <= 33; $i++) {
            foreach ($grade as $val) {
                $this->masterDB->table('set_report_score_rank')
                    ->set([
                        'score_rank_type' => 'C',
                        'job_depth_1' => $i,
                        'score_rank_grade' => $val
                    ])
                    ->insert();
            }
        }
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
        exit;
    }

    public function calculAnalysis($aData)
    {
        $dialect = $aData["dialect"];  //방언빈도
        $quiver = $aData["quiver"];   //음성떨림
        $volume = $aData["volume"];   //음성크기
        $tone = $aData["tone"];   //목소리톤
        $speed = $aData["speed"];   //음성속도
        $diction = $aData["diction"];   //발음정확도
        $sincerity = $aData["sincerity"];   //성싱답변률
        $understanding = $aData["understanding"];   //질문이해도
        $eyes = $aData["eyes"];   //시선처리
        $smile = $aData["smile"];   //긍정적표정
        $mouth_motion = $aData["mouth_motion"];   //입움직임
        $blink = $aData["blink"];   //눈깜빡임
        $gesture = $aData["gesture"];   //제스처빈도
        $head_motion = $aData["head_motion"];   //머리움직임
        $foreign = $aData["foreign"];   //외국어빈도
        $glow = $aData["glow"];   //홍조현상

        if ($speed == 1) {
            $score_speed = 5;
        } else if ($speed == 2 || $speed == 10) {
            $score_speed = 6;
        } else if ($speed == 3 || $speed == 9) {
            $score_speed = 7;
        } else if ($speed == 4 || $speed == 8) {
            $score_speed = 8;
        } else if ($speed == 5 || $speed == 6) {
            $score_speed = 10;
        } else if ($speed == 7) {
            $score_speed = 9;
        } else if ($speed == 0) {
            $score_speed = 0;
        }

        //-------------------------------------------------------------------

        //[적극성 (목소리떨림, 발음정확도, 음성속도, 긍정적표정, 제스쳐빈도)]
        if ($quiver == 0) { //목소리떨림
            $score_quiver = 0;
        } else {
            $score_quiver = 11 - $quiver;
        }
        $score_diction = $diction;    //발음정확도
        //$score_speed = 10;    //음성속도 
        $score_smile = $smile;    //긍정적표정
        $score_gesture = $gesture;    //제스쳐빈도

        $aggressiveness = $score_quiver + $score_diction + $score_speed + $score_smile + $score_gesture;

        //-------------------------------------------------------------------

        //[안정성 (목소리떨림, 음성속도, 홍조현상, 머리움직임, 눈깜빡임)]
        if ($quiver == 0) { //목소리떨림
            $score_quiver = 0;
        } else {
            $score_quiver = 11 - $quiver;
        }
        //$score_speed = 10;    //음성속도 

        if ($glow == 0) {   //홍조현상
            $score_glow = 0;
        } else {
            $score_glow = 11 - $glow;
        }


        if ($head_motion == 0) {  //머리움직임
            $score_head_motion = 0;
        } else {
            $score_head_motion = 11 - $head_motion;
        }

        if ($blink == 0) { //눈깜빡임
            $score_blink = 0;
        } else {
            $score_blink = 11 - $blink;
        }


        $stability = $score_quiver + $score_speed + $score_glow + $score_head_motion + $score_blink;

        //-------------------------------------------------------------------

        //[신뢰성 (목소리떨림, 음성속도, 발음정확도, 성실답변률, 시선처리)]
        if ($quiver == 0) { //목소리떨림
            $score_quiver = 0;
        } else {
            $score_quiver = 11 - $quiver;
        }
        //$score_speed = 10;    //음성속도 
        $score_diction = $diction;    //발음정확도
        $score_sincerity = $sincerity;    //성실답변률
        $score_eyes = $eyes;    //시선처리

        $reliability = $score_quiver + $score_speed + $score_diction + $score_sincerity + $score_eyes;

        //-------------------------------------------------------------------

        //[긍정성 (음성크기, 목소리톤, 입움직임, 긍정적표정, 시선처리)]
        $score_volume = $volume;    //음성크기
        $score_tone = $tone;    //목소리톤
        $mouth_motion = $mouth_motion;    //입움직임
        $score_smile = $smile;    //긍정적표정
        $score_eyes = $eyes;    //시선처리

        $affirmative = $score_volume + $score_tone + $mouth_motion + $score_smile + $score_eyes;

        //-------------------------------------------------------------------

        //[대응력 (음성속도, 성실답변률, 질문이해도, 시선처리, 긍정적표정)]
        //$score_speed = 10;    //음성속도
        $score_sincerity = $sincerity;    //성실답변률
        $score_understanding = $understanding;    //질문이해도
        $score_eyes = $eyes;    //시선처리
        $score_smile = $smile;    //긍정적표정

        $alacrity = $score_speed + $score_sincerity + $score_understanding + $score_eyes + $score_smile;

        //-------------------------------------------------------------------

        //[의지력 (성실답변률, 시선처리, 제스쳐빈도, 질문이해도, 입움직임)]
        $score_sincerity = $sincerity;    //성실답변률
        $score_eyes = $eyes;    //시선처리
        $score_gesture = $gesture;    //제스쳐빈도
        $score_understanding = $understanding;    //질문이해도
        $mouth_motion = $mouth_motion;    //입움직임

        $willpower = $score_sincerity + $score_eyes + $score_gesture + $score_understanding + $mouth_motion;

        //-------------------------------------------------------------------

        //[능동성 (음성크기, 성실답변률, 긍정적표정, 입움직임, 답변속도)]
        $score_volume = $volume;    //음성크기
        $score_sincerity = $sincerity;    //성실답변률
        $score_smile = $smile;    //긍정적표정
        $mouth_motion = $mouth_motion;    //입움직임
        //$score_speed = 10;    //음성속도

        $activity = $score_volume + $score_sincerity + $score_smile + $mouth_motion + $score_speed;

        //-------------------------------------------------------------------

        //[매력도 (목소리톤, 음성크기, 제스쳐빈도, 긍정적표정, 홍조현상)]
        $score_tone = $tone;    //목소리톤
        $score_volume = $volume;    //음성크기
        $score_gesture = $gesture;    //제스쳐빈도
        $score_smile = $smile;    //긍정적표정
        $score_glow = $glow;    //홍조현상

        $attraction = $score_tone + $score_volume + $score_gesture + $score_smile + $score_glow;

        //-------------------------------------------------------------------
        $total =  $aggressiveness + $stability + $reliability + $affirmative + $alacrity + $willpower + $activity + $attraction;
        $sum = $total / 3.5;

        //-------------------------------------------------------------------

        if ($sum >= 80) {
            $grade = 'S';
        } else if ($sum >= 60) {
            $grade = 'A';
        } else if ($sum >= 40) {
            $grade = 'B';
        } else if ($sum >= 20) {
            $grade = 'C';
        } else {
            $grade = 'D';
        }

        $value =
            [
                'sum' => $sum, 'grade' => $grade,
                'aggressiveness' => $aggressiveness, 'stability' => $stability, 'reliability' => $reliability, 'affirmative' => $affirmative, 'alacrity' => $alacrity, 'willpower' => $willpower, 'activity' => $activity, 'attraction' => $attraction
            ];

        return $value;
    }

    public function setEncrypt($str, $secret_key = 'secret key')
    {
        $key = substr(hash('sha256', $secret_key, true), 0, 32);
        $iv = substr(hash('sha256', $secret_key, true), 0, 16);
        return base64_encode(openssl_encrypt($str, "AES-256-CBC", $key, 0, $iv));
    }

    public function setDecrypt($str, $secret_key = 'secret key')
    {
        $key = substr(hash('sha256', $secret_key, true), 0, 32);
        $iv = substr(hash('sha256', $secret_key, true), 0, 16);
        return openssl_decrypt(base64_decode($str), "AES-256-CBC", $key, 0, $iv);
    }

    public function generateDynamicLink($link)
    {
        $api_key = "AIzaSyD5Vl719H0krVaaFSkhbQ8QoSupiUue1nU";
        $header_data = array("Content-Type:application/json");
        if ($this->globalvar->getServerHost() == 'test') {
            $post_data = array(
                'dynamicLinkInfo' => array(
                    'domainUriPrefix' => 'https://highbuffinterview.page.link',
                    'link' => 'https://localinterviewr.highbuff.com/linkInterview/' . $link,
                    'androidInfo' => array(
                        'androidPackageName' => 'com.highbuff.iss',
                        'androidFallbackLink' => 'https://interview.highbuff.com/link.php?apply=' . $link
                    ),
                    'iosInfo' => array(
                        'iosBundleId' => 'com.bluevisor.interview',
                        'iosCustomScheme' => 'highbuffinterview',
                        'iosIpadBundleId' => 'com.bluevisor.interview'
                    )
                )
            );
        } else if ($this->globalvar->getServerHost() == 'webtest') {
            $post_data = array(
                'dynamicLinkInfo' => array(
                    'domainUriPrefix' => 'https://highbuffinterview.page.link',
                    'link' => 'https://webtestinterviewr.highbuff.com/linkInterview/' . $link,
                    'androidInfo' => array(
                        'androidPackageName' => 'com.highbuff.iss',
                        'androidFallbackLink' => 'https://webtestinterviewr.com/linkInterview/' . $link
                    ),
                    'iosInfo' => array(
                        'iosBundleId' => 'com.bluevisor.interview',
                        'iosCustomScheme' => 'highbuffinterview',
                        'iosIpadBundleId' => 'com.bluevisor.interview'
                    )
                )
            );
        } else if ($this->globalvar->getServerHost() == 'real') {
            $post_data = array(
                'dynamicLinkInfo' => array(
                    'domainUriPrefix' => 'https://highbuffinterview.page.link',
                    'link' => 'https://interview.highbuff.com/linkInterview/' . $link,
                    'androidInfo' => array(
                        'androidPackageName' => 'com.highbuff.iss',
                        'androidFallbackLink' => 'https://interview.highbuff.com/linkInterview/' . $link
                    ),
                    'iosInfo' => array(
                        'iosBundleId' => 'com.bluevisor.interview',
                        'iosCustomScheme' => 'highbuffinterview',
                        'iosIpadBundleId' => 'com.bluevisor.interview'
                    )
                )
            );
        }

        $url = "https://firebasedynamiclinks.googleapis.com/v1/shortLinks?key=" . $api_key;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data, true));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($result, true);
        usleep(500000); //1초에 5건이상 발생시 api에서 429 에러 발생하여 0.5초 딜레이
        //print_r($json);
        return $json["shortLink"];
    }
}
