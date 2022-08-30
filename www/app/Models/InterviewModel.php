<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\DatabaseInterview;

class InterviewModel extends Model
{
    protected $table = ''; // 데이터베이스 테이블을 지정
    protected $primaryKey = ''; // 테이블에서 레코드를 고유하게 식별하는 열(column)의 이름
    protected $useAutoIncrement = true; // (auto-increment) 기능을 사용할지 여부
    protected $tempReturnType = 'array'; // 반환되는값 지정 array,object 
    protected $useSoftDeletes; // true 일경우 실제로 행을 삭제하는 대신 deleted_at 필드를 설정
    protected $allowedFields = []; //save, insert, update 메소드를 통하여 설정할 수 있는 필드 이름
    protected $useTimestamps = true; // INSERT 및 UPDATE에 자동으로 추가되는지 여부를 결정.
    protected $createdField = 'inter_reg_date'; // 데이터 레코드 작성 타임스탬프를 유지하기 위해 사용하는 데이터베이스 필드
    protected $updatedField = 'inter_mod_date'; // 데이터 레코드 업데이트 타임스탬프를 유지하기 위해 사용할 데이터베이스 필드
    protected $deletedField = 'inter_del_date'; // 데이터 레코드 삭제 타임스탬프를 유지하기 위해 사용할 데이터베이스 필드
    protected $validationRules = []; // 유효성 검사 규칙 배열
    protected $validationMessages = []; // 유효성 검증 중에 사용해야하는 사용자 정의 오류 메시지 배열
    protected $skipValidation = false; // 모든 inserts와 updates의 유효성 검사를 하지 않을지 여부 기본값은 false이며 데이터의 유효성 검사를 항상 시도.
    protected $jsonField = [];
    protected $afterFind = ['jsonToArray'];

    public function __construct()
    {
        parent::__construct();
        $code = 'iv_interview';
        $this->table = $code;
        $this->fields = DatabaseInterview::$code();
        if (is_array($this->fields)) {
            foreach ($this->fields as $key => $row) {
                if (isset($row['auto_increment']) && $row['auto_increment'] === true) {
                    $this->primaryKey = $key;
                } else if (!in_array($key, ['inter_reg_date', 'inter_mod_date', 'inter_del_date'])) {
                    $this->allowedFields[] = $key;
                }
            }
        }
    }

    public function jsonToArray(array $data): array
    {
        if (isset($data['data'])) {
            foreach ($data['data'] as $key => $val) {
                if (is_array($val)) {
                    foreach ($val as $k_ => $v_)
                        if (in_array($k_, $this->jsonField)) $data['data'][$key][$k_] = json_decode($v_, true);
                } else {
                    if (in_array($key, $this->jsonField)) {
                        $data['data'][$key] = json_decode($val, true);
                    }
                }
            }
        }
        return $data;
    }
    public function save($data): bool
    {
        // $masterDB를 사용해 주세요.
        return false;
    }

    public function getJobcate(int $idx)
    {
        $aRow = $this
            ->select('iv_job_category.job_depth_text')
            ->join('iv_job_category', 'iv_job_category.idx=iv_interview.job_idx_position', 'left')
            ->where([
                'iv_interview.idx' => $idx,
                'iv_interview.delyn' => 'N'
            ])
            ->first();
        return $aRow;
    }

    public function getMock(int $_idx)
    {
        $aMock = [];

        if (!$_idx) {
            return $aMock;
        };

        $aMock = $this
            ->where([
                'idx' => $_idx,
                'delyn' => 'N',
                'inter_type' => 'B',
            ])
            ->first();

        return $aMock;
    }

    public function getMockInterviews(int $infoIdx)
    {
        $aGetInterviews = [];

        if (!$infoIdx) {
            return $aGetInterviews;
        }

        $aGetInterviews = $this
            ->join('iv_interview_info', 'iv_interview_info.idx=iv_interview.info_idx', 'left')
            ->where([
                'iv_interview_info.idx' => $infoIdx,
            ])
            ->findAll();

        return $aGetInterviews;
    }

    public function getRecCate(int $recIdx)
    {
        $aRow = $this
            ->select('iv_job_category.job_depth_text')
            ->join('iv_job_category', 'iv_job_category.idx=iv_interview.job_idx_position', 'left')
            ->where([
                'iv_interview.rec_idx' => $recIdx,
                'iv_interview.delyn' => 'N'
            ])
            ->first();
        return $aRow;
    }

    public function getInterview(int $_idx)
    {
        $aInterview = [];

        if (!$_idx) {
            return $aInterview;
        };

        $aInterview = $this
            ->where([
                'rec_idx' => $_idx,
                'delyn' => 'N',
                'inter_type' => 'C',
            ])
            ->first();

        return $aInterview;
    }

    public function getBizInterInfo(int $_idx)
    {
        $aInterview = [];
        if (!$_idx) {
            return !$aInterview;
        };

        $aInterview = $this
            ->select('iv_company_suggest_applicant.sug_app_title,iv_company_suggest.sug_end_date,iv_company_suggest.sug_start_date')
            ->join('iv_company_suggest_applicant', 'iv_company_suggest_applicant.inter_idx=iv_interview.idx', 'left')
            ->join('iv_company_suggest', 'iv_company_suggest_applicant.sug_idx=iv_company_suggest.idx', 'left')
            ->where([
                'iv_company_suggest_applicant.idx' => $_idx,
                'iv_company_suggest_applicant.delyn' => 'N',
            ])
            ->first();

        return $aInterview;
    }

    public function getBizInterview(int $_idx)
    {
        $aInterview = [];
        if (!$_idx) {
            return !$aInterview;
        };

        $aInterview = $this
            ->select('iv_company_suggest_applicant.old_ap_idx,iv_company_suggest_applicant.job_idx,iv_company_suggest_applicant.sug_app_personal_q_list, iv_interview.*')
            ->join('iv_company_suggest_applicant', 'iv_company_suggest_applicant.inter_idx=iv_interview.idx', 'left')
            ->where([
                'iv_company_suggest_applicant.idx' => $_idx,
                'iv_company_suggest_applicant.delyn' => 'N',
            ])
            ->first();

        return $aInterview;
    }
}
