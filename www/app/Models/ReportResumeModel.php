<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\DatabaseInterview;

class ReportResumeModel extends Model
{
    protected $table = ''; // 데이터베이스 테이블을 지정
    protected $primaryKey = ''; // 테이블에서 레코드를 고유하게 식별하는 열(column)의 이름
    protected $useAutoIncrement = true; // (auto-increment) 기능을 사용할지 여부
    protected $tempReturnType = 'array'; // 반환되는값 지정 array,object 
    protected $useSoftDeletes = false; // true 일경우 실제로 행을 삭제하는 대신 deleted_at 필드를 설정
    protected $allowedFields = []; //save, insert, update 메소드를 통하여 설정할 수 있는 필드 이름
    protected $useTimestamps = true; // INSERT 및 UPDATE에 자동으로 추가되는지 여부를 결정.
    protected $createdField = 'res_reg_date'; // 데이터 레코드 작성 타임스탬프를 유지하기 위해 사용하는 데이터베이스 필드
    protected $updatedField = 'res_mod_date'; // 데이터 레코드 업데이트 타임스탬프를 유지하기 위해 사용할 데이터베이스 필드
    protected $deletedField = 'res_del_date'; // 데이터 레코드 삭제 타임스탬프를 유지하기 위해 사용할 데이터베이스 필드
    protected $validationRules = []; // 유효성 검사 규칙 배열
    protected $validationMessages = []; // 유효성 검증 중에 사용해야하는 사용자 정의 오류 메시지 배열
    protected $skipValidation = false; // 모든 inserts와 updates의 유효성 검사를 하지 않을지 여부 기본값은 false이며 데이터의 유효성 검사를 항상 시도.


    public function __construct()
    {
        parent::__construct();
        $code = 'iv_resume';
        $this->table = $code;
        $this->fields = DatabaseInterview::$code();
        if (is_array($this->fields)) {
            foreach ($this->fields as $key => $row) {
                if (isset($row['auto_increment']) && $row['auto_increment'] === true) {
                    $this->primaryKey = $key;
                } else if (!in_array($key, ['res_reg_date', 'res_mod_date', 'res_del_date'])) {
                    $this->allowedFields[] = $key;
                }
            }
        }
    }

    public function save($data): bool
    {
        // $masterDB를 사용해 주세요.
        return false;
    }

    public function getJobcategory($idx): array //이력서 직무 검색
    {
        $this->table = 'iv_applier';

        $aRow = $this
            ->select('iv_job_category.idx, iv_job_category.job_depth_text')
            ->join('iv_resume', 'iv_applier.res_idx = iv_resume.idx', 'left')
            ->join('iv_resume_category', 'iv_resume.idx = iv_resume_category.res_idx', 'left')
            ->join('iv_job_category', 'iv_job_category.idx = iv_resume_category.job_idx', 'left')
            ->where([
                'iv_applier.idx' => $idx,
                'iv_applier.delyn' => 'N',
                'iv_resume.delyn' => 'N',
            ])
            ->orderBy('idx', 'DESC')
            ->first();

        if ($aRow == "" || $aRow == null) {
            $aRow = [];
        }

        return $aRow;
    }

    public function getTotal($idx): object //해당 직무 이력서 총 수
    {
        $sql = "SELECT COUNT(a.idx) cnt FROM iv_resume a
        LEFT JOIN iv_resume_category b
        ON a.idx = b.res_idx
        WHERE b.job_idx = {$idx}
        ";

        $aRow = $this
            ->query($sql)
            ->getRow();

        if ($aRow == "" || $aRow == null) {
            $aRow = [];
        }

        return $aRow;
    }

    public function getTotalEdu($idx): array //학력별 현황
    {
        $sql = "SELECT 
        ROUND(COUNT(CASE WHEN res_edu_school_type = 'H' THEN 1 END) / COUNT(res_edu_school_type) * 100 , 2) a1,
        ROUND(COUNT(CASE WHEN res_edu_school_type = 'C' THEN 1 END) / COUNT(res_edu_school_type) * 100 , 2) a2,
        ROUND(COUNT(CASE WHEN res_edu_school_type = 'U' THEN 1 END) / COUNT(res_edu_school_type) * 100 , 2) a3,
        ROUND(COUNT(CASE WHEN res_edu_school_type = 'M' THEN 1 END) / COUNT(res_edu_school_type) * 100 , 2) a4,
        ROUND(COUNT(CASE WHEN res_edu_school_type = 'D' THEN 1 END) / COUNT(res_edu_school_type) * 100 , 2) a5
        FROM
        (SELECT res_idx , res_edu_school, res_edu_school_type , MAX(res_edu_graduate) FROM 
        (SELECT * FROM iv_resume_education ORDER BY res_edu_graduate DESC) d GROUP BY res_idx) e
        WHERE res_idx IN (SELECT a.idx FROM iv_resume a
        LEFT JOIN iv_resume_category b
        ON a.idx = b.res_idx
        WHERE b.job_idx = {$idx})";


        $aRow = $this
            ->query($sql)
            ->getResult();

        if ($aRow == "" || $aRow == null) {
            $aRow = [];
        }

        return $aRow;
    }

    public function getTotalCareer($idx): array //경력별 현황
    {
 
        $sql = "SELECT 
        ROUND(COUNT(CASE WHEN cy = 0 THEN 1 END) / COUNT(cy) * 100 , 2) a1,
        ROUND(COUNT(CASE WHEN cy > 0 AND cy < 1 THEN 1 END) / COUNT(cy) * 100 , 2) a2,
        ROUND(COUNT(CASE WHEN cy >= 1 AND cy < 3 THEN 1 END) / COUNT(cy) * 100 , 2) a3,
        ROUND(COUNT(CASE WHEN cy >= 3 AND cy < 5 THEN 1 END) / COUNT(cy) * 100 , 2) a4,
        ROUND(COUNT(CASE WHEN cy >= 5 THEN 1 END) / COUNT(cy) * 100 , 2) a5
        FROM
        (SELECT SUM(cm)/12 cy, res_idx FROM 
        (SELECT PERIOD_DIFF(edate,sdate) cm, res_idx FROM
        (SELECT res_idx , res_career_join_date sdate, 
        IF(res_career_leave_date IS NULL , DATE_FORMAT(NOW(), '%Y%m'), res_career_leave_date) edate
        FROM iv_resume_career 
        ORDER BY edate) d
        ) e
        GROUP BY res_idx
        ) f
        WHERE res_idx IN 
        (SELECT a.idx FROM iv_resume a
        LEFT JOIN iv_resume_category b
        ON a.idx = b.res_idx WHERE b.job_idx = {$idx})";


        $aRow = $this
            ->query($sql)
            ->getResult();

        if ($aRow == "" || $aRow == null) {
            $aRow = [];
        }

        return $aRow;
    }

    public function getTotalLanguage($idx): array //외국어 현황
    {
        $sql = "SELECT 
        ROUND(COUNT(CASE WHEN res_language_name = 'TOEIC' THEN 1 END) / COUNT(res_language_name) * 100 , 2) a1,
        ROUND(COUNT(CASE WHEN res_language_name = 'TOFEL' THEN 1 END) / COUNT(res_language_name) * 100 , 2) a2,
        ROUND(COUNT(CASE WHEN res_language_name = 'TEPS' THEN 1 END) / COUNT(res_language_name) * 100 , 2) a3,
        ROUND(COUNT(CASE WHEN res_language_name = 'OPIC' THEN 1 END) / COUNT(res_language_name) * 100 , 2) a4,
        ROUND(COUNT(CASE WHEN res_language_name = 'JPT' THEN 1 END) / COUNT(res_language_name) * 100 , 2) a5,
        ROUND(COUNT(CASE WHEN res_language_name = 'HSK' THEN 1 END) / COUNT(res_language_name) * 100 , 2) a6
         FROM iv_resume_language 
        WHERE res_idx IN 
        (SELECT a.idx FROM iv_resume a
        LEFT JOIN iv_resume_category b
        ON a.idx = b.res_idx WHERE b.job_idx = {$idx})";

        $aRow = $this
            ->query($sql)
            ->getResult();

        if ($aRow == "" || $aRow == null) {
            $aRow = [];
        }

        return $aRow;
    }

    public function getTotalToeicscore($idx): array //TOEIC점수 현황
    {
        $sql = "SELECT 
        ROUND(COUNT(CASE WHEN res_language_score < 600 THEN 1 END) / COUNT(res_language_score) * 100 , 2) a1,
        ROUND(COUNT(CASE WHEN res_language_score >= 600 AND res_language_score < 700 THEN 1 END) / COUNT(res_language_score) * 100 , 2) a2,
        ROUND(COUNT(CASE WHEN res_language_score >= 700 AND res_language_score < 800 THEN 1 END) / COUNT(res_language_score) * 100 , 2) a3,
        ROUND(COUNT(CASE WHEN res_language_score >= 800 AND res_language_score < 900 THEN 1 END) / COUNT(res_language_score) * 100 , 2) a4,
        ROUND(COUNT(CASE WHEN res_language_score > 900 THEN 1 END) / COUNT(res_language_score) * 100 , 2) a5
         FROM iv_resume_language 
        WHERE 
        res_language_name = 'TOEIC' AND 
        res_idx IN 
        (SELECT a.idx FROM iv_resume a
        LEFT JOIN iv_resume_category b
        ON a.idx = b.res_idx WHERE b.job_idx = {$idx})";

        $aRow = $this
            ->query($sql)
            ->getResult();

        if ($aRow == "" || $aRow == null) {
            $aRow = [];
        }

        return $aRow;
    }

    public function getTotalLicense($idx): array //자격증 개수 현황
    {

        $sql = "SELECT
        ROUND(COUNT(CASE WHEN  cnt = 0 THEN 1 END) / COUNT(cnt) * 100 , 2) a1,
        ROUND(COUNT(CASE WHEN  cnt = 1 THEN 1 END) / COUNT(cnt) * 100 , 2) a2,
        ROUND(COUNT(CASE WHEN  cnt = 2 THEN 1 END) / COUNT(cnt) * 100 , 2) a3,
        ROUND(COUNT(CASE WHEN  cnt = 3 THEN 1 END) / COUNT(cnt) * 100 , 2) a4,
        ROUND(COUNT(CASE WHEN  cnt >= 4 THEN 1 END) / COUNT(cnt) * 100 , 2) a5
        FROM
        (SELECT res_idx ,COUNT(res_idx) cnt
         FROM iv_resume_license
        WHERE 
        res_idx IN 
        (SELECT a.idx FROM iv_resume a
        LEFT JOIN iv_resume_category b
        ON a.idx = b.res_idx WHERE b.job_idx = {$idx})
        GROUP BY res_idx
        ) c";

        $aRow = $this
            ->query($sql)
            ->getResult();


        if ($aRow == "" || $aRow == null) {
            $aRow = [];
        }

        return $aRow;
    }

    public function getTotalActivity($idx): array //활동지수 현황
    {

        $sql = "SELECT
        ROUND(COUNT(CASE WHEN  cnt = 0 THEN 1 END) / COUNT(cnt) * 100 , 2) a1,
        ROUND(COUNT(CASE WHEN  cnt = 1 THEN 1 END) / COUNT(cnt) * 100 , 2) a2,
        ROUND(COUNT(CASE WHEN  cnt = 2 THEN 1 END) / COUNT(cnt) * 100 , 2) a3,
        ROUND(COUNT(CASE WHEN  cnt = 3 THEN 1 END) / COUNT(cnt) * 100 , 2) a4,
        ROUND(COUNT(CASE WHEN  cnt >= 4 THEN 1 END) / COUNT(cnt) * 100 , 2) a5
        FROM
        (SELECT res_idx ,COUNT(res_idx) cnt
         FROM iv_resume_activity
        WHERE 
        res_idx IN 
        (SELECT a.idx FROM iv_resume a
        LEFT JOIN iv_resume_category b
        ON a.idx = b.res_idx WHERE b.job_idx = {$idx})
        GROUP BY res_idx
        ) c";

        $aRow = $this
            ->query($sql)
            ->getResult();

        if ($aRow == "" || $aRow == null) {
            $aRow = [];
        }

        return $aRow;
    }
}
