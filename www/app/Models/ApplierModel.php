<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\DatabaseInterview;

class ApplierModel extends Model
{
    protected $table = ''; // 데이터베이스 테이블을 지정
    protected $primaryKey = ''; // 테이블에서 레코드를 고유하게 식별하는 열(column)의 이름
    protected $useAutoIncrement = true; // (auto-increment) 기능을 사용할지 여부
    protected $tempReturnType = 'array'; // 반환되는값 지정 array,object 
    protected $useSoftDeletes = false; // true 일경우 실제로 행을 삭제하는 대신 deleted_at 필드를 설정
    protected $allowedFields = []; //save, insert, update 메소드를 통하여 설정할 수 있는 필드 이름
    protected $useTimestamps = true; // INSERT 및 UPDATE에 자동으로 추가되는지 여부를 결정.
    protected $createdField = 'app_reg_date'; // 데이터 레코드 작성 타임스탬프를 유지하기 위해 사용하는 데이터베이스 필드
    protected $updatedField = 'app_mod_date'; // 데이터 레코드 업데이트 타임스탬프를 유지하기 위해 사용할 데이터베이스 필드
    protected $deletedField = 'app_del_date'; // 데이터 레코드 삭제 타임스탬프를 유지하기 위해 사용할 데이터베이스 필드
    protected $validationRules = []; // 유효성 검사 규칙 배열
    protected $validationMessages = []; // 유효성 검증 중에 사용해야하는 사용자 정의 오류 메시지 배열
    protected $skipValidation = false; // 모든 inserts와 updates의 유효성 검사를 하지 않을지 여부 기본값은 false이며 데이터의 유효성 검사를 항상 시도.


    public function __construct()
    {
        parent::__construct();
        $code = 'iv_applier';
        $this->table = $code;
        $this->fields = DatabaseInterview::$code();
        if (is_array($this->fields)) {
            foreach ($this->fields as $key => $row) {
                if (isset($row['auto_increment']) && $row['auto_increment'] === true) {
                    $this->primaryKey = $key;
                } else if (!in_array($key, ['app_reg_date', 'app_mod_date', 'app_del_date'])) {
                    $this->allowedFields[] = $key;
                }
            }
        }
    }

    public function applierBaseCondition(): object
    {
        $objQuery = $this->where(['iv_applier.delyn' => 'N']);
        return $objQuery;
    }

    // 공고 카테고리가 내가 본 면접중에 있는지 체크
    public function getMemberCategoty(string $id, $categories)
    {
        $strMemberCategory = '';
        if (!$id || !$categories) {
            return $strMemberCategory;
        }

        $aMemberCategory = $this
            ->select('iv_job_category.job_depth_text')
            ->join('iv_job_category', 'iv_applier.job_idx=iv_job_category.idx', 'left')
            ->where('iv_applier.mem_idx', $id)->findAll();

        if ($aMemberCategory) {
            foreach ($aMemberCategory as $val) {
                if (in_array($val['job_depth_text'], $categories)) {
                    $strMemberCategory = 'get'; //공고카테고리 = 인터뷰 카테고리가
                    break;
                }
                $strMemberCategory = 'not'; //인터뷰가 있지만 동일한 카테고리가 존재하지않음
            }
        } else {
            $strMemberCategory = 'none'; //인터뷰가 없음
        }
        return $strMemberCategory;
    }

    public function getApplierData(string $id, array $jobCategory): array
    {
        $ajobCategory = [];

        if (!$id || !$jobCategory) {
            return $ajobCategory;
        }

        for ($i = 0; $i < count($jobCategory); $i++) {
            array_push($ajobCategory, $jobCategory[$i]['job_idx']);
        }

        $this
            ->select('idx, job_idx')
            ->where('mem_idx', $id)
            ->where('app_iv_stat', 4);
        if (count($ajobCategory) > 0) {
            $this->whereIn('job_idx', $ajobCategory);
        }
        $aMemberJobCategory = $this->findAll();
        $aApplierIdx = [];

        //같은 job_catrgory가 있는 경우
        if ($aMemberJobCategory) {
            foreach ($aMemberJobCategory as $val) {
                array_push($aApplierIdx, $val);
            }
        } else {
            //같은 job_catrgory가 없는 경우
            $aAllCategory = $this
                ->select('idx, job_idx')
                ->where('app_iv_stat', 4)
                ->where('mem_idx', $id)
                ->findAll();

            for ($i = 0; $i < count($aAllCategory); $i++) {
                array_push($aApplierIdx, $aAllCategory[$i]);
            }
        }

        return $aApplierIdx;
    }

    public function getApplierInfo(int $applierIdx): array
    {
        $aInfo = [];
        if (!$applierIdx || $applierIdx == "") {
            return $aInfo;
        }

        $aApplierInfo = $this
            ->select('*')
            ->join('iv_job_category', 'iv_applier.job_idx=iv_job_category.idx', 'left')
            ->where('iv_applier.idx', $applierIdx)
            ->first();

        $aApplierInfoImg = $this
            ->select('iv_file.file_save_name')
            ->join('iv_file', 'iv_applier.file_idx_thumb = iv_file.idx', 'left')
            ->where('iv_file.idx', $aApplierInfo['file_idx_thumb'])
            ->where('iv_file.file_type', 'A')
            ->where('iv_file.delyn', 'N')
            ->first();

        $aApplierInfoShare = $this
            ->select('app_share, idx')
            ->where('iv_applier.idx', $applierIdx)
            ->where('delyn', 'N')
            ->first();

        if ($aApplierInfo && $aApplierInfoImg && $aApplierInfoShare) {
            if ($aApplierInfoShare['app_share'] == 0) {
                $aApplierInfoShare['app_share'] = '비공개';
            } else {
                $aApplierInfoShare['app_share'] = '공개';
            }
            array_push($aInfo, $aApplierInfo['app_reg_date'], $aApplierInfo['job_depth_text'], $aApplierInfoImg['file_save_name'], $aApplierInfoShare['app_share'], $aApplierInfoShare['idx']);
        }

        return $aInfo;
    }

    public function getMemberInterview($memIdx): array
    {
        $aRow = [];
        if (!$memIdx) {
            return $aRow;
        }

        $aRow = $this
            ->select('iv_applier.idx, iv_job_category.job_depth_text, iv_file.file_save_name, iv_applier.app_reg_date, iv_report_result.repo_analysis, iv_applier.app_share')
            ->join('iv_job_category', 'iv_applier.job_idx = iv_job_category.idx', 'left')
            ->join('iv_file', 'iv_applier.file_idx_thumb = iv_file.idx', 'left')
            ->join('iv_report_result', 'iv_applier.idx = iv_report_result.applier_idx', 'left')
            ->where('iv_applier.app_type', 'M')
            ->where('iv_report_result.que_type', 'T')
            ->where('mem_idx', $memIdx)
            ->where('app_iv_stat', 4)
            ->findAll();

        $aInterviewCnt = [];
        for ($i = 0; $i < count($aRow); $i++) {
            $aCnt = $this
                ->select('COUNT(iv_report_result.idx) as cnt')
                ->join('iv_report_result', 'iv_applier.idx = iv_report_result.applier_idx', 'left')
                ->where('iv_report_result.applier_idx', $aRow[$i]['idx'])
                ->where('iv_report_result.que_type', 'S')
                ->first();

            array_push($aInterviewCnt, $aCnt);
        }

        $aInfo = [];
        array_push($aInfo, array("itv" => $aRow, "cnt" => $aInterviewCnt));

        return $aInfo;
    }

    public function getApplierAllList(int $iMemberIdx, string $strType, string $strSort, int $iStat): object
    {
        $aResult = (object)[];
        if (!$iMemberIdx) {
            return $aResult;
        }

        $aResult = $this
            ->select([
                'iv_applier.idx',
                'iv_applier.job_idx',
                'iv_applier.app_count',
                'iv_applier.app_iv_stat',
                'iv_applier.app_type',
                'iv_applier.app_share',
                'iv_applier.app_reg_date',
                'iv_applier.app_like_count',
                'iv_report_result.repo_analysis',
                'iv_job_category.job_depth_text',
                'iv_file.file_save_name'
            ])
            ->join('iv_report_result', 'iv_applier.idx = iv_report_result.applier_idx', 'inner')
            ->join('iv_job_category', 'iv_applier.job_idx = iv_job_category.idx', 'inner')
            ->join('iv_file', 'iv_applier.file_idx_thumb = iv_file.idx', 'inner')
            ->where(
                [
                    'iv_applier.delyn' => 'N',
                    'iv_report_result.delyn' => 'N',
                    'iv_applier.app_iv_stat >=' => $iStat,
                    'que_type' => 'T',
                ]
            )
            ->where('mem_idx', $iMemberIdx);
        if ($strType === '0') {
            $aResult = $this
                ->where('iv_applier.app_share', 0);
        } else if ($strType === '1') {
            $aResult = $this
                ->where('iv_applier.app_share', 1);
        } else if ($strType === 'company') {
            $aResult = $this
                ->where('iv_applier.app_type', 'C');
        }

        if ($strSort === 'all') {
            $aResult = $this
                ->orderBy('iv_applier.app_reg_date', 'ASC');
        } else if ($strSort === 'max') {
            $aResult = $this
                ->orderBy('iv_applier.app_iv_stat', 'DESC')
                ->orderBy('iv_report_result.repo_analysis', 'DESC');
        } else if ($strSort === 'min') {
            $strSort = $this
                ->orderBy('iv_applier.app_iv_stat', 'DESC')
                ->orderBy('iv_report_result.repo_analysis', 'ASC');
        } else {
            $aResult = $this
                ->orderBy('iv_applier.app_reg_date', 'DESC');
        }
        return $aResult;
    }

    public function getApplierAllList2(int $iMemberIdx, int $iStat): object
    {
        $aResult = (object)[];
        if (!$iMemberIdx) {
            return $aResult;
        }

        $aResult = $this
            ->select([
                'iv_applier.idx',
                'iv_applier.job_idx',
                'iv_applier.app_count',
                'iv_applier.app_iv_stat',
                'iv_applier.app_type',
                'iv_applier.app_share',
                'iv_applier.app_reg_date',
                'iv_applier.app_like_count',
                'iv_report_result.repo_analysis',
                'iv_job_category.job_depth_text',
                'iv_file.file_save_name'
            ])
            ->join('iv_report_result', 'iv_applier.idx = iv_report_result.applier_idx', 'inner')
            ->join('iv_job_category', 'iv_applier.job_idx = iv_job_category.idx', 'inner')
            ->join('iv_file', 'iv_applier.file_idx_thumb = iv_file.idx', 'inner')
            ->where([
                'iv_applier.delyn' => 'N',
                'iv_report_result.delyn' => 'N',
                'iv_applier.app_iv_stat' => $iStat,
                'que_type' => 'T',
            ])
            ->where('mem_idx', $iMemberIdx)->orderBy('iv_applier.app_reg_date', 'DESC');
        return $aResult;
    }

    public function getApplierAllCount(int $iMemberIdx): int
    {
        $aResult = 0;
        if (!$iMemberIdx) {
            return $aResult;
        }

        $aResult = $this
            ->where([
                'delyn' => 'N',
                'app_iv_stat >=' => '3',
            ])
            ->where('mem_idx', $iMemberIdx)
            ->countAllResults();
        return $aResult;
    }

    public function selectorAdminList(string $type = 'interview'): object
    {
        $objQuery = $this
            ->select([
                'iv_applier.idx AS appIdx', 'iv_applier.app_type AS appType', 'iv_applier.app_reg_date AS appRegDate', 'iv_applier.delyn AS appDel',
                'iv_file.file_save_name as fileName', 'iv_job_category.job_depth_text as jobText',
                'iv_member.mem_id AS memId', 'iv_member.mem_name AS memName',
            ]);
        if ($type === 'interview') {
            $objQuery = $this
                ->select(['iv_applier.app_iv_stat AS appStat']);
        } elseif ($type === 'comprehensive') {
            $objQuery = $this
                ->select(['iv_applier.app_comprehensive AS appComprehensive', 'iv_applier.res_idx AS resIdx', 'iv_resume.res_title AS resTitle']);
        }
        return $objQuery;
    }

    public function selectorComprehensiveList(): object
    {
        $objQuery = $this
            ->select([
                'iv_applier.idx', 'iv_applier.app_count', 'iv_applier.app_iv_stat', 'iv_applier.app_type',
                'iv_applier.app_share', 'iv_applier.app_mod_date', 'iv_applier.app_like_count',
                'iv_report_result.repo_analysis', 'iv_job_category.job_depth_text', 'iv_file.file_save_name',
                'iv_resume.res_title', 'iv_job_category.idx as jobIdx'
            ]);
        return $objQuery;
    }

    public function getComprehensiveList(int $iMemberIdx): object
    {
        $objQuery = (object)[];
        if (!$iMemberIdx) {
            return $objQuery;
        }

        $objQuery = $this
            ->selectorComprehensiveList()
            ->join('iv_report_result', 'iv_applier.idx = iv_report_result.applier_idx', 'inner')
            ->jobCategoryBuilder()->thumbNailBuilder()->resumeBuilder()
            ->where(['iv_applier.app_comprehensive' => '1', 'que_type' => 'T',])->getMyReport($iMemberIdx);
        return $objQuery;
    }

    public function getApplierOpenCount(int $iMemberIdx): int
    {
        $iResult = 0;
        if (!$iMemberIdx) {
            return $iResult;
        }

        $iResult = $this
            ->where([
                'delyn' => 'N',
                'app_iv_stat >=' => '3',
                'app_share' => '1',
            ])
            ->where('mem_idx', $iMemberIdx)
            ->countAllResults();
        return $iResult;
    }

    public function getDetail(int $iApplierIdx)
    {
        $aResult = [];
        if (!$iApplierIdx) {
            return $aResult;
        }

        $aResult = $this
            ->select([
                'iv_applier.idx', 'iv_applier.app_reg_date', 'iv_report_result.que_type',
                'iv_report_result.repo_score', 'iv_report_result.repo_analysis',
                'iv_report_result.repo_speech_txt', 'iv_job_category.job_depth_text',
                'iv_job_category.job_depth_1', 'iv_applier.app_share',
                'iv_applier.app_share_company', 'iv_file.file_save_name',
            ])
            ->join('iv_report_result', 'iv_applier.idx = iv_report_result.applier_idx', 'inner')
            ->join('iv_job_category', 'iv_applier.job_idx = iv_job_category.idx', 'left')
            ->join('iv_file', 'iv_applier.file_idx_thumb = iv_file.idx', 'left')
            ->where('iv_applier.delyn', 'N')
            ->where('iv_applier.idx', $iApplierIdx);
        return $aResult;
    }

    public function getAllDetail()
    {
        $aResult = $this
            ->select(['iv_report_result.repo_analysis'])
            ->join('iv_report_result', 'iv_applier.idx = iv_report_result.applier_idx', 'inner')
            ->join('iv_job_category', 'iv_applier.job_idx = iv_job_category.idx', 'left')
            ->where([
                'iv_applier.app_iv_stat' => '4',
                'iv_report_result.que_type' => 'T',
                'iv_applier.delyn' => 'N'
            ]);
        return $aResult;
    }

    public function getFailTotal(int $iApplierIdx): object
    {
        $objQuery = (object)[];
        if (!$iApplierIdx) {
            return $objQuery;
        }

        $objQuery = $this
            ->select(['iv_applier.mem_idx AS memIdx', 'iv_applier.app_iv_stat AS appStat', 'iv_applier.app_share AS appShare'])
            ->where(['iv_applier.delyn' => 'N', 'iv_applier.idx' => $iApplierIdx]);
        return $objQuery;
    }

    public function getFailSection(int $iApplierIdx): object
    {
        if (!$iApplierIdx) {
            $objQuery = (object)[];
            return $objQuery;
        }

        $objQuery = $this
            ->select(['iv_video.video_record AS videoName'])->videoBuilder()
            ->where(['iv_applier.delyn' => 'N', 'iv_applier.idx' => $iApplierIdx]);
        return $objQuery;
    }

    public function chkApplier(string $iApplierIdx, int $iMemberIdx): bool
    {
        $boolResult = false;
        if (!$iApplierIdx) {
            return $boolResult;
        }

        $boolResult = $this
            ->where([
                'delyn' => 'N',
                'app_iv_stat' => 4,
                'mem_idx' => $iMemberIdx,
                'iv_applier.idx' => $iApplierIdx,
            ])
            ->first();
        return $boolResult ? true : false;
    }

    public function chkMine(string $iApplierIdx, int $iMemberIdx): bool
    {
        $boolResult = false;
        if (!$iApplierIdx) {
            return $boolResult;
        }

        $boolResult = $this
            ->where([
                'delyn' => 'N',
                'mem_idx' => $iMemberIdx,
                'iv_applier.idx' => $iApplierIdx,
            ])
            ->first();
        return $boolResult ? true : false;
    }

    public function chkApplierShare(string $iApplierIdx): bool
    {
        $boolResult = false;
        if (!$iApplierIdx) {
            return $boolResult;
        }

        $boolResult = $this
            ->where([
                'delyn' => 'N',
                'app_iv_stat' => 4,
                'idx' => $iApplierIdx,
                'app_share' => 1
            ])
            ->first();
        return $boolResult ? true : false;
    }

    public function getGrade(): array
    {
        $aResult = [];

        $aResult = $this
            ->select(['iv_report_result.repo_analysis', 'iv_job_category.job_depth_1',])
            ->join('iv_report_result', 'iv_applier.idx = iv_report_result.applier_idx', 'inner')
            ->join('iv_job_category', 'iv_applier.job_idx = iv_job_category.idx', 'inner')
            ->where([
                'iv_applier.delyn' => 'N',
                'que_type' => 'T',
                'app_iv_stat' => 4,
            ])
            ->findAll();
        return $aResult ?? [];
    }

    public function getJobIdx(int $iApplierIdx, int $iMemberIdx, int $iJobIdx): bool
    {
        $boolResult = false;
        $boolResult = $this
            ->select(['job_idx'])
            ->where([
                'idx !=' => $iApplierIdx,
                'mem_idx' => $iMemberIdx,
                'job_idx' => $iJobIdx,
                'delyn' => 'N',
                'app_share' => 1
            ])
            ->first();
        return $boolResult ? true : false;
    }

    public function getStartApplier(int $applierIdx): array
    {
        $aStartInfo = [];

        if (!$applierIdx) {
            return $aStartInfo;
        }

        $aStartApplier = $this
            ->select('*')
            ->where([
                'iv_applier.idx' => $applierIdx,
                'delyn' => 'N'
            ])
            ->first();

        $aStartQuestion = $this
            ->select('iv_report_result.que_idx,iv_report_result.repo_answer_time')
            ->join('iv_report_result', 'iv_applier.idx=iv_report_result.applier_idx', 'left')
            ->where([
                'iv_applier.idx' => $applierIdx,
                'iv_applier.delyn' => 'N'
            ])
            ->findAll();

        $aStartVideo = $this
            ->select('iv_video.idx')
            ->join('iv_video', 'iv_applier.idx=iv_video.app_idx', 'left')
            ->where([
                'iv_video.app_idx' => $applierIdx,
                'iv_applier.delyn' => 'N'
            ])
            ->findAll();

        array_push($aStartInfo, array(
            'idx' => $applierIdx, 'mem_idx' => $aStartApplier['mem_idx'], 'com_idx' => $aStartApplier['com_idx'],
            'job_idx' => $aStartApplier['job_idx'], 'rec_idx' => $aStartApplier['rec_idx'], 'rec_nos_idx' => $aStartApplier['rec_nos_idx'], 'i_idx' => $aStartApplier['i_idx'], 'file_idx_thumb' => $aStartApplier['file_idx_thumb'], 'app_type' => $aStartApplier['app_type'], 'app_stt_stat' => $aStartApplier['app_stt_stat'], 'app_iv_stat' => $aStartApplier['app_iv_stat'], 'report_result' => $aStartQuestion, 'video_idx' => $aStartVideo
        ));

        return $aStartInfo;
    }

    //면접 진행중 
    public function startInterview(int $applierIdx): array
    {
        $aStartInfo = [];

        if (!$applierIdx) {
            return $aStartInfo;
        }

        $aStartApplier = $this
            ->select('*')
            ->where([
                'iv_applier.idx' => $applierIdx,
                'delyn' => 'N'
            ])
            ->first();

        $aStartQuestion = $this
            ->select('iv_report_result.que_idx,iv_report_result.repo_answer_time, iv_report_result.idx,iv_question.que_question,iv_question.que_lang_type,iv_report_result.idx')
            ->join('iv_report_result', 'iv_applier.idx=iv_report_result.applier_idx', 'left')
            ->join('iv_question', 'iv_report_result.que_idx=iv_question.idx', 'left')
            ->where([
                'iv_applier.idx' => $applierIdx,
                'iv_report_result.que_type !=' => 'T',
                'iv_applier.delyn' => 'N'
            ])
            ->findAll();

        $aCompleteVideo = $this
            ->select('iv_video.idx, iv_video.app_idx')
            ->join('iv_video', 'iv_applier.idx=iv_video.app_idx', 'left')
            ->where([
                'iv_video.app_idx' => $applierIdx,
                'iv_applier.delyn' => 'N'
            ])
            ->findAll();

        $aNextQuestion = $this
            ->select('iv_report_result.que_idx,iv_report_result.idx,iv_question.que_type,iv_question.que_question,iv_report_result.repo_answer_time')
            ->join('iv_report_result', 'iv_applier.idx=iv_report_result.applier_idx', 'left')
            ->join('iv_question', 'iv_report_result.que_idx=iv_question.idx', 'left')
            ->where([
                'iv_applier.idx' => $applierIdx,
                'iv_report_result.repo_process' => 0,
                'iv_report_result.que_type !=' => 'T',
                'iv_applier.delyn' => 'N'
            ])
            ->first();

        array_push($aStartInfo, array(
            'idx' => $applierIdx, 'mem_idx' => $aStartApplier['mem_idx'], 'com_idx' => $aStartApplier['com_idx'],
            'job_idx' => $aStartApplier['job_idx'], 'rec_idx' => $aStartApplier['rec_idx'], 'file_idx_thumb' => $aStartApplier['file_idx_thumb'], 'app_type' => $aStartApplier['app_type'], 'app_stt_stat' => $aStartApplier['app_stt_stat'], 'app_iv_stat' => $aStartApplier['app_iv_stat'], 'report_result' => $aStartQuestion, 'video' => $aCompleteVideo, "next_question" => $aNextQuestion
        ));

        return $aStartInfo;
    }

    public function endInterview(int $applierIdx, int $memIdx)
    {
        $aEndInfo = [];

        if (!$applierIdx) {
            return $aEndInfo;
        }

        $aEndInfo = $this
            ->select('*')
            ->where([
                'iv_applier.idx' => $applierIdx,
                'iv_applier.mem_idx' => $memIdx,
                'delyn' => 'N'
            ])
            ->first();

        return $aEndInfo;
    }

    public function sampleList(string $upDown = null, array $cateCheck = null)
    {
        $aSampleInfo = [];

        $aSampleInfo = $this
            ->select('iv_applier.idx, iv_applier.mem_idx,iv_file.file_save_name,iv_report_result.repo_analysis, iv_job_category.job_depth_text')
            ->join('iv_file', 'iv_applier.file_idx_thumb=iv_file.idx', 'left')
            ->join('iv_report_result', 'iv_applier.idx=iv_report_result.applier_idx', 'left')
            ->join('iv_job_category', 'iv_applier.job_idx=iv_job_category.idx', 'left')
            ->where([
                'iv_applier.app_type' => 'S',
                'iv_applier.app_iv_stat >=' => 3,
                'iv_report_result.que_type' => 'T',
                'iv_applier.delyn' => 'N'
            ]);
        //->whereIn('iv_applier.idx', [35]);
        if ($cateCheck) {
            $cateIdx = [];

            for ($i = 0; $i < count($cateCheck); $i++) {
                array_push($cateIdx, $cateCheck[$i]['job_depth_1']);
            }
            $aSampleInfo->whereIn('iv_job_category.job_depth_1', $cateIdx);
        }

        if ($upDown) {
            if ($upDown == "up") {
                $aSampleInfo->orderBy('repo_analysis', 'DESC');
            } else {
                $aSampleInfo->orderBy('repo_analysis', 'ASC');
            }
        } else {
            $aSampleInfo->orderBy('repo_analysis', 'DESC');
        }
        return $aSampleInfo;
    }

    public function getAppJobIdx(int $appIdx): array
    {
        $aRow = [];
        if (!$appIdx) {
            return $aRow;
        }

        $aRow = $this
            ->select('job_idx')
            ->where([
                "idx" => $appIdx,
                "delyn" => 'N'
            ])
            ->first();

        return $aRow;
    }

    public function getShareJobIdx(int $iMemberIdx) // 면접 공개한것만
    {
        $aResult = [];
        if (!$iMemberIdx) {
            return $aResult;
        }

        $aResult = $this
            ->where([
                'delyn' => 'N',
                'app_iv_stat' => 4,
                'app_share' => 1
            ]);
        return $aResult ?? [];
    }

    public function checkMyapply($memberIdx)
    {
        $aRow = [];
        if (!$memberIdx) {
            return $aRow;
        }

        $aRow = $this
            ->where([
                'mem_idx' => $memberIdx,
                'app_iv_stat' => 4,
                'delyn' => 'N'
            ])
            ->first();

        if (!$aRow) {
            $aRow = 'none';
        }

        return $aRow;
    }

    public function existApply($memIdx)
    {
        $aRow = [];
        if (!$memIdx) {
            return $aRow;
        }

        $aRow = $this
            ->where([
                'mem_idx' => $memIdx,
                'delyn' => 'N',
                'app_iv_stat >=' => 3
            ])
            ->findAll();

        if (!$aRow) {
            $aRow = [];
            return $aRow;
        }

        return $aRow;
    }

    public function getTotalScore(int $iAppIdx = 0): object
    {
        if ($iAppIdx) {
            $objQuery = $this->where(['iv_applier.idx' => $iAppIdx]);
        }
        $objQuery = $this
            ->reportResultBuilder('total')
            ->where(['iv_report_result.que_type' => 'T']);
        return $objQuery;
    }

    public function getScoreVideo(int $iAppIdx = 0): object
    {
        if ($iAppIdx) {
            $objQuery = $this->where(['iv_applier.idx' => $iAppIdx]);
        }
        $objQuery = $this
            ->reportResultBuilder('score')
            ->where(['iv_report_result.que_type' => 'S']);
        return $objQuery;
    }

    public function jobCategoryBuilder(): object
    {
        $objQuery = $this
            ->join('iv_job_category', 'iv_applier.job_idx = iv_job_category.idx', 'left');
        return $objQuery;
    }

    public function thumbNailBuilder(): object
    {
        $objQuery = $this
            ->join('iv_file', 'iv_applier.file_idx_thumb = iv_file.idx', 'left');
        return $objQuery;
    }
    public function memberBuilder(): object
    {
        $objQuery = $this
            ->join('iv_member', 'iv_applier.mem_idx = iv_member.idx', 'left');
        return $objQuery;
    }

    public function videoBuilder(): object
    {
        $objQuery = $this
            ->join('iv_video', 'iv_applier.idx = iv_video.app_idx', 'left');
        return $objQuery;
    }

    public function resumeBuilder(): object
    {
        $objQuery = $this
            ->join('iv_resume', 'iv_applier.res_idx = iv_resume.idx', 'left');
        return $objQuery;
    }

    public function reportResultBuilder($type = 'score'): object
    {
        if ($type === 'score') {
            $objQuery = $this
                ->videoBuilder()
                ->join('iv_report_result', 'iv_video.repo_res_idx = iv_report_result.idx', 'left')
                ->join('iv_question', 'iv_question.idx = iv_report_result.que_idx', 'left');
        } else if ($type === 'total') {
            $objQuery = $this->join('iv_report_result', 'iv_applier.idx = iv_report_result.applier_idx ', 'left');
        }
        return $objQuery;
    }

    public function daysInBullder(int $iDays = 1) // 오늘 - iDays의 값만
    {
        $timestamp = strtotime("Now");
        $today = date('Y-m-d H:i:s', $timestamp);
        $timestamp = strtotime("-{$iDays} days");
        $beforeDay = date('Y-m-d H:i:s', $timestamp);
        $objQuery = $this
            ->where(['iv_applier.app_reg_date <=' => $today, 'iv_applier.app_reg_date >=' => $beforeDay]);
        return $objQuery;
    }

    public function getMyReport(int $iMemIdx): object
    {
        $objQuery = (object)[];
        if (!$iMemIdx) {
            return $objQuery;
        }
        $objQuery = $this
            ->applierBaseCondition()
            ->where(['iv_applier.mem_idx' => $iMemIdx, 'iv_applier.app_iv_stat >=' => '4']);
        return $objQuery;
    }

    public function getApplyPossibleReport(int $iMemIdx): object
    {
        $objQuery = (object)[];
        if (!$iMemIdx) {
            return $objQuery;
        }
        $objQuery = $this
            ->applierBaseCondition()
            ->where(['iv_applier.mem_idx' => $iMemIdx, 'iv_applier.app_iv_stat' => '4', 'iv_applier.app_comprehensive' => '1',]);
        return $objQuery;
    }

    public function getMyData(int $iMemIdx)
    {
        $objQuery = (object)[];
        if (!$iMemIdx) {
            return;
        }
        $objQuery = $this
            ->where(['iv_applier.mem_idx' => $iMemIdx, 'iv_applier.delyn' => 'N',])
            ->whereIn('iv_applier.app_iv_stat', [3, 4, 5]);
        return $objQuery;
    }

    public function checkApplier(int $iMemIdx, int $iDays): bool
    {
        $boolResult = $this->select(['iv_applier.idx'])->daysInBullder($iDays)->getMyData($iMemIdx)->first();
        return $boolResult ? true : false;
    }

    public function checkHaveResume($appIdx): object
    {
        $aRow = [];
        if (!$appIdx) {
            return $aRow;
        }

        $aRow = $this
            ->select('res_idx')
            ->where([
                'idx' => $appIdx,
                'app_comprehensive !=' => '0',
                'delyn' => 'N'
            ]);

        return $aRow;
    }

    public function getAppStatMsg($iStatValue): string
    {
        $strMsg = '';
        if ($iStatValue == 0) {
            $strMsg = '카테고리 선택';
        } else if ($iStatValue == 1) {
            $strMsg = '프로필 촬영';
        } else if ($iStatValue == 2) {
            $strMsg = '마이크 테스트 완료';
        } else if ($iStatValue == 3) {
            $strMsg = '면접 완료';
        } else if ($iStatValue == 4) {
            $strMsg = '채점 완료';
        } else if ($iStatValue == 5) {
            $strMsg = '분석 불가';
        }
        return $strMsg;
    }

    public function getAppTypeMsg($strTypeValue): string
    {
        $strMsg = '';
        if ($strTypeValue === 'C') {
            $strMsg = '기업 인터뷰';
        } else if ($strTypeValue === 'M') {
            $strMsg = '개인 인터뷰';
        } else if ($strTypeValue === 'A') {
            $strMsg = '모의 인터뷰';
        }
        return $strMsg;
    }
}
