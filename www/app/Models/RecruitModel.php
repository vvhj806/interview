<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\DatabaseInterview;
use DateTime;

class RecruitModel extends Model
{
    protected $table = ''; // 데이터베이스 테이블을 지정
    protected $primaryKey = ''; // 테이블에서 레코드를 고유하게 식별하는 열(column)의 이름
    protected $useAutoIncrement = true; // (auto-increment) 기능을 사용할지 여부
    protected $tempReturnType = 'array'; // 반환되는값 지정 array,object 
    protected $useSoftDeletes = false; // true 일경우 실제로 행을 삭제하는 대신 deleted_at 필드를 설정
    protected $allowedFields = []; //save, insert, update 메소드를 통하여 설정할 수 있는 필드 이름
    protected $useTimestamps = true; // INSERT 및 UPDATE에 자동으로 추가되는지 여부를 결정.
    protected $createdField = 'rec_reg_date'; // 데이터 레코드 작성 타임스탬프를 유지하기 위해 사용하는 데이터베이스 필드
    protected $updatedField = 'rec_mod_date'; // 데이터 레코드 업데이트 타임스탬프를 유지하기 위해 사용할 데이터베이스 필드
    protected $deletedField = 'rec_del_date'; // 데이터 레코드 삭제 타임스탬프를 유지하기 위해 사용할 데이터베이스 필드
    protected $validationRules = []; // 유효성 검사 규칙 배열
    protected $validationMessages = []; // 유효성 검증 중에 사용해야하는 사용자 정의 오류 메시지 배열
    protected $skipValidation = false; // 모든 inserts와 updates의 유효성 검사를 하지 않을지 여부 기본값은 false이며 데이터의 유효성 검사를 항상 시도.

    public function __construct()
    {
        parent::__construct();
        $code = 'iv_recruit';
        $this->table = $code;
        $this->fields = DatabaseInterview::$code();
        if (is_array($this->fields)) {
            foreach ($this->fields as $key => $row) {
                if (isset($row['auto_increment']) && $row['auto_increment'] === true) {
                    $this->primaryKey = $key;
                } else if (!in_array($key, ['rec_reg_date', 'rec_mod_date', 'rec_del_date'])) {
                    $this->allowedFields[] = $key;
                }
            }
        }
    }

    public function recruitBaseCondition(): object
    {
        $ymdToday = date('Ymd');
        $objQuery = $this->where([
            'iv_recruit.delyn' => 'N', 'iv_recruit.rec_stat' => 'Y', 'iv_recruit.rec_end_stat' => 'N',
            'iv_recruit.rec_end_date >=' => $ymdToday, 'iv_recruit.rec_start_date <=' => $ymdToday
        ]);
        return $objQuery;
    }

    public function getRecruit(string $_idx): array
    {
        $aResult = [];
        if (!$_idx) {
            return $aResult;
        }

        $aResult = $this
            ->select('iv_recruit.*, iv_company.com_name, iv_company.com_address, iv_company.file_idx_logo, iv_file.file_save_name, iv_interview.inter_question,iv_interview.inter_answer_time')
            ->join('iv_company', 'iv_recruit.com_idx=iv_company.idx', 'left')
            ->join('iv_file', 'iv_recruit.file_idx_recruit = iv_file.idx', 'left')
            ->join('iv_interview', 'iv_interview.rec_idx = iv_recruit.idx', 'left')
            ->where([
                'iv_recruit.idx' => $_idx,
                'iv_recruit.rec_stat' => 'Y',
                'iv_recruit.delyn' => 'N'
            ])
            ->first();
        return $aResult;
    }

    // 공고 여러개 지원할때 여러 회사 값 불러오기
    public function getRecruits(array $_idx): array
    {
        $aResult = [];
        if (!$_idx) {
            return $aResult;
        }

        $aResult = $this->select('iv_recruit.idx as recIdx, iv_company.idx as comIdx, iv_company.com_name, iv_recruit.rec_title, iv_recruit.rec_resume, iv_recruit.rec_end_date')
            ->join('iv_file', 'iv_recruit.file_idx_recruit=iv_file.idx', 'left')
            ->join('iv_company', 'iv_recruit.com_idx=iv_company.idx', 'left')
            ->where(['iv_recruit.rec_stat' => 'Y', 'iv_recruit.delyn' => 'N'])
            ->whereIn('iv_recruit.idx', $_idx)->findAll();

        $aResults = [];
        for ($i = 0; $i < count($aResult); $i++) {
            array_push($aResults, $aResult[$i]);
        }

        return $aResults;
    }

    // 공고태그들 불러오기
    public function getTags(string $_idx): array
    {
        $aRow = [];
        if (!$_idx) {
            return $aRow;
        }

        $aRow = $this
            ->select('config_company_tag.tag_txt')
            ->join('iv_company_tag', 'iv_recruit.com_idx=iv_company_tag.com_idx', 'left')
            ->join('config_company_tag', 'config_company_tag.idx=iv_company_tag.config_tag_idx', 'left')
            ->where([
                'iv_recruit.idx' => $_idx,
                'iv_recruit.rec_stat' => 'Y', 'iv_recruit.delyn' => 'N'
            ])
            ->findAll();
        $aTagRow = [];
        if ($aRow) {
            for ($i = 0; $i < count($aRow); $i++) {
                array_push($aTagRow, $aRow[$i]['tag_txt']);
            }
        }
        return $aTagRow;
    }

    public function getRandomRecInfo(array $ranIdx): array
    {
        $aRanRec = [];

        if (!$ranIdx) {
            return $aRanRec;
        }

        for ($i = 0; $i < count($ranIdx); $i++) {
            array_push($aRanRec, $ranIdx[$i]['rec_idx']);
        }
        $temp = implode(",", $aRanRec);
        $aRow = $this
            ->select('iv_recruit.idx, iv_company.com_name, iv_recruit.rec_title, iv_korea_area.area_depth_text_1, iv_korea_area.area_depth_text_2, iv_recruit.rec_apply, iv_recruit.rec_end_date, iv_recruit.rec_career, iv_file.file_save_name')
            ->join('iv_company', 'iv_recruit.com_idx = iv_company.idx', 'left')
            ->join('iv_member_recruit_kor', 'iv_recruit.idx = iv_member_recruit_kor.rec_idx', 'left')
            ->join('iv_korea_area', 'iv_member_recruit_kor.kor_area_idx = iv_korea_area.idx', 'left')
            ->join('iv_file', 'iv_recruit.file_idx_recruit = iv_file.idx', 'left')
            ->where(['iv_recruit.rec_stat' => 'Y', 'iv_recruit.delyn' => 'N'])
            ->whereIn('iv_member_recruit_kor.rec_idx', $aRanRec)
            ->whereIn('iv_recruit.idx', $aRanRec)
            ->groupBy('iv_recruit.idx')
            ->orderBy('FIELD(iv_recruit.idx,' . $temp . ')')
            ->findAll();
        return $aRow;
    }

    public function getRecruitTitles(array $aIdx): array
    {
        $aRow = [];

        if (!$aIdx) {
            return $aRow;
        }

        $aRow = $this->select('idx, rec_title')
            ->where(['iv_recruit.rec_stat' => 'Y', 'iv_recruit.delyn' => 'N'])
            ->whereIn('idx', $aIdx)
            ->findAll();

        return $aRow;
    }
    // <summary>
    // 지원자의 관심사 조건에 따라 채용공고목록 가져오기
    // 조건1. 공고마감일이 현재날짜보다 같거나 작음
    // 조건2. 공고조회수가 높음  
    // 조건3. 사용자 관심직무가 있을경우 공고의 직무와 사용자 관심직무와 같음
    // <param name="aJobIdx">사용자관심직무배열</param>
    // <param name="strSearchText">검색어</param>
    // <param name="strSearchRecApply">내인터뷰로지원가능한면접여부(M)</param>
    // <param name="strSearchOrder">정렬조건</param>
    // </summary>
    public function getRecruitList(array $aJobIdx  = null, string $strSearchText = null, string $strSearchRecApply = null, string $strSearchOrder = null): object
    {
        $aRow = [];
        $this
            ->select(
                'iv_recruit.idx as recIdx, 
                 iv_recruit.rec_title as recTitle, 
                 iv_recruit.job_idx as jobIdx, 
                 iv_recruit.rec_career as recCareer, 
                 iv_recruit.rec_end_date as recEndDate, 
                 iv_company.com_name as comName, 
                 iv_file.file_save_name as fileComLogo,
                 iv_recruit.rec_apply as recApply, 
                 iv_recruit.rec_work_type as recWorkType, 
                 iv_recruit.rec_work_day as recWorkDay'
            )
            ->select(['area_depth_text_1', 'area_depth_text_2'])
            ->join('iv_korea_area', 'iv_recruit.kor_area_idx = iv_korea_area.idx', 'inner')
            ->join('iv_job_category', 'iv_job_category.idx = iv_recruit.job_idx', 'inner')
            ->join('iv_company', 'iv_recruit.com_idx = iv_company.idx', 'left')
            ->join('iv_file', 'iv_file.idx = iv_company.file_idx_logo', 'left')
            ->where([
                "iv_recruit.rec_end_date >=" => date("Ymd"),
                'iv_recruit.rec_stat' => 'Y',
                'iv_recruit.delyn' => 'N'
            ]);

        if ($strSearchRecApply) { //인터뷰지원타입에 대한 조건이 있으면
            $this->whereIn('iv_recruit.rec_apply', ['A', $strSearchRecApply]);
        }

        // if ($aJobIdx) { //관심직무가 있으면
        //     $aOrWhere = [];
        //     for ($i = 0; $i < count($aJobIdx); $i++) {
        //         array_push($aOrWhere, $aJobIdx[$i]);
        //     }
        //     $this->whereIn('iv_job_category.idx', $aOrWhere);
        // }

        if ($strSearchText) { //검색어가 있으면
            $this->groupStart()
                ->like('iv_recruit.rec_title', $strSearchText, 'both')
                ->orLike('iv_company.com_name', $strSearchText, 'both')
                ->orLike('iv_job_category.job_depth_text', $strSearchText, 'both')
                ->groupEnd();
        }

        if ($strSearchOrder) { //정렬조건이 있으면
            if ($strSearchOrder === 'rec_reg_date') {
                $aRow = $this->orderBy($strSearchOrder, 'DESC');
            } else {
                $aRow = $this->orderBy($strSearchOrder, 'ASC');
            }
        } else {
            $aRow = $this->orderBy('rec_hit', 'DESC');
        }
        return $aRow;
    }

    public function getRecruitListPure(): object
    {
        $aResult = (object)[];

        $aResult = $this
            ->select(['area_depth_text_1', 'area_depth_text_2'])
            ->join('iv_company', 'iv_recruit.com_idx=iv_company.idx', 'left')
            ->join('iv_korea_area', 'iv_recruit.kor_area_idx = iv_korea_area.idx', 'inner')
            ->join('iv_file', 'iv_recruit.file_idx_recruit = iv_file.idx', 'left');
        return $aResult;
    }

    public function getCurrentRecruit(int $comIdx): array
    {
        $aRow = [];
        if (!$comIdx) {
            return $aRow;
        }

        $aRow = $this
            ->select('iv_recruit.idx, iv_recruit.rec_title, iv_file.file_save_name')
            ->join('iv_company', 'iv_company.idx = iv_recruit.com_idx', 'left')
            ->join('iv_file', 'iv_file.idx = iv_company.file_idx_logo', 'left')
            ->where([
                'iv_recruit.com_idx' => $comIdx,
                'iv_recruit.rec_stat' => 'Y',
                'iv_recruit.delyn' => 'N',
                'iv_recruit.rec_end_date >=' => date("Ymd")
            ])
            ->orderBy('idx', 'asc')
            ->findAll(2);

        return $aRow ?? [];
    }

    public function getCompany(int $recIdx)
    {

        $aRow = $this
            ->select('iv_company.idx, iv_company.com_name')
            ->join('iv_company', 'iv_company.idx=iv_recruit.com_idx', 'left')
            ->where([
                'iv_recruit.idx' => $recIdx,
                'iv_recruit.rec_stat' => 'Y',
                'iv_recruit.delyn' => 'N',
                'iv_recruit.rec_end_date >=' => date("Ymd")
            ])
            ->first();

        return $aRow;
    }

    public function getComIdxs(array $fitRecIdx, $limit): array
    {
        $aRow = [];
        if (!$fitRecIdx) {
            return $aRow;
        }

        $today = date("Ymd");

        $aRow = $this
            ->distinct()
            ->select('com_idx')
            ->where([
                'rec_end_date >=' => $today,
                'rec_stat' => 'Y',
                'iv_recruit.delyn' => 'N'
            ])
            ->whereIn('idx', $fitRecIdx)
            ->orderBy('com_idx', 'RANDOM')
            ->limit($limit)
            ->findColumn('com_idx');

        return $aRow ?? [];
    }

    public function getIssueRec(): array
    {
        $aRow = [];

        $today = date('Ymd');
        $aRow = $this
            ->select('iv_recruit.idx, iv_recruit.rec_title, iv_recruit.rec_apply, iv_recruit.rec_career, iv_recruit.rec_end_date, iv_company.com_name, iv_korea_area.area_depth_text_1, iv_korea_area.area_depth_text_2, iv_file.file_save_name')
            ->join('iv_company', 'iv_company.idx = iv_recruit.com_idx', 'left')
            ->join('iv_file', 'iv_file.idx = iv_company.file_idx_logo', 'left')
            ->join('iv_member_recruit_kor', 'iv_member_recruit_kor.rec_idx = iv_recruit.idx', 'left')
            ->join('iv_korea_area', 'iv_korea_area.idx = iv_member_recruit_kor.kor_area_idx', 'left')
            ->where([
                'iv_recruit.delyn' => 'N',
                'iv_recruit.rec_issue_com' => 'Y',
                'iv_recruit.rec_stat' => 'Y',
                'iv_recruit.rec_end_date >=' => $today
            ])
            ->groupBy('iv_recruit.idx')
            ->orderBy('iv_recruit.idx', 'desc')
            ->findAll(3);

        return $aRow;
    }

    public function getRecInfo(array $recIdxs)
    {
        $aRow = [];
        if (!$recIdxs) {
            return $aRow;
        }

        $today = date('Ymd');

        $aRow = $this
            ->select('iv_recruit.idx, iv_recruit.rec_title, iv_recruit.rec_apply, iv_recruit.rec_career, iv_recruit.rec_end_date, iv_company.com_name, iv_korea_area.area_depth_text_1, iv_korea_area.area_depth_text_2, iv_file.file_save_name')
            ->join('iv_company', 'iv_company.idx = iv_recruit.com_idx', 'left')
            ->join('iv_file', 'iv_file.idx = iv_company.file_idx_logo', 'left')
            ->join('iv_member_recruit_kor', 'iv_member_recruit_kor.rec_idx = iv_recruit.idx', 'left')
            ->join('iv_korea_area', 'iv_korea_area.idx = iv_member_recruit_kor.kor_area_idx', 'left')
            ->where([
                'iv_recruit.delyn' => 'N',
                'iv_recruit.rec_stat' => 'Y',
                'iv_recruit.rec_end_date >=' => $today
            ])
            ->whereIn('iv_recruit.idx', $recIdxs)
            ->groupBy('iv_recruit.idx')
            ->findAll();

        $aInfo[] = $aRow;


        return $aInfo;
    }

    public function getRecApplyCount(array $recIdxs)
    {
        $aRow = [];
        if (!$recIdxs) {
            return $aRow;
        }

        foreach ($recIdxs as $val) {
            $aRow = $this
                ->select('rec_apply_count')
                ->where([
                    'idx' => $val,
                    'delyn' => 'N',
                    'rec_stat' => 'Y'
                ])
                ->first();

            $aApplyCount[] = $aRow;
        }

        return $aApplyCount;
    }

    public function buildeRecruitList(): object
    {
        $aResult = (object)[];
        $aResult = $this->select([
            'iv_recruit.idx as recIdx', 'iv_recruit.rec_title as recTitle',
            'iv_recruit.rec_apply as recApply', 'iv_recruit.rec_end_date as recEndDate', 'iv_recruit.rec_hit as recHit',
            'iv_recruit.rec_reg_date as recRegDate', 'iv_recruit.rec_stat as recStat',
            'iv_company.com_name as comName', 'iv_job_category.job_depth_text',
            'iv_korea_area.area_depth_text_1', 'iv_korea_area.area_depth_text_2',
        ])
            ->select('count(iv_recruit_info.idx) as recCnt')
            ->join('iv_company', 'iv_company.idx = iv_recruit.com_idx', 'left')
            ->join('iv_job_category', 'iv_job_category.idx = iv_recruit.job_idx', 'left')
            ->join('iv_korea_area', 'iv_korea_area.idx = iv_recruit.kor_area_idx', 'left')
            ->join(
                'iv_recruit_info',
                "iv_recruit.idx = iv_recruit_info.rec_idx
                AND iv_recruit_info.delyn = 'N'
                AND iv_recruit_info.res_info_ing_mem = 'C'",
                'left'
            )
            ->groupBy('recIdx')
            ->orderBy('recIdx', 'desc');

        return $aResult;
    }

    public function getRecruitStat(int $iComIdx = null): array
    {
        $aResult = [];
        $aResult = $this
            ->select("COUNT(*) AS total", '', false)
            ->select("COUNT(case when iv_recruit.rec_stat = 'Y' AND iv_recruit.rec_end_date > now() then 1 end) AS ing", '', false)
            ->select("COUNT(case when iv_recruit.rec_stat = 'I' then 1 end) AS wait", '', false)
            ->select("COUNT(case when iv_recruit.rec_stat = 'Y' AND iv_recruit.rec_end_date < now() then 1 end) AS end", '', false)
            ->select("COUNT(case when iv_recruit.rec_stat = 'M' then 1 end) AS no", '', false)
            ->where(['iv_recruit.delyn' => 'N']);

        if ($iComIdx) {
            $aResult = $this
                ->where(['iv_recruit.com_idx' => $iComIdx]);
        }

        $aResult = $this
            ->first();

        return $aResult;
    }

    public function jobCategoryBuilder(): object
    {
        $objQuery = $this
            ->join('iv_job_category', 'iv_recruit.job_idx = iv_job_category.idx', 'left');
        return $objQuery;
    }

    public function koreaAreaBuilder(): object
    {
        $objQuery = $this
            ->join('iv_korea_area', 'iv_recruit.kor_area_idx = iv_korea_area.idx', 'left');
        return $objQuery;
    }

    public function companyBuilder(): object
    {
        $objQuery = $this
            ->join('iv_company', 'iv_recruit.com_idx = iv_company.idx', 'left');
        return $objQuery;
    }

    public function getRecCnt($comIdx): int
    {
        $iResult = 0;
        if (!$comIdx) {
            return $iResult;
        }

        $iResult = $this
            ->where(['com_idx' => $comIdx, 'delyn' => 'N'])
            ->countAllResults();

        return $iResult;
    }
    public function getApplyMsg($strApplyValue): string
    {
        $strMsg = '';
        if ($strApplyValue === 'M') {
            $strMsg = '지원자';
        } else if ($strApplyValue === 'C') {
            $strMsg = '기업';
        } else if ($strApplyValue === 'A') {
            $strMsg = '무관';
        }
        return $strMsg;
    }

    public function getStatMsg($strStatValue): string
    {
        $strMsg = '';
        if ($strStatValue === 'I') {
            $strMsg = '대기 중';
        } else if ($strStatValue === 'Y') {
            $strMsg = '승인완료';
        } else if ($strStatValue === 'N') {
            $strMsg = '승인거절';
        }

        return $strMsg;
    }
}
