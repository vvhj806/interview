<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\DatabaseInterview;

class RecruitNostradamusModel extends Model
{
    protected $table = ''; // 데이터베이스 테이블을 지정
    protected $primaryKey = ''; // 테이블에서 레코드를 고유하게 식별하는 열(column)의 이름
    protected $useAutoIncrement = true; // (auto-increment) 기능을 사용할지 여부
    protected $tempReturnType = 'array'; // 반환되는값 지정 array,object 
    protected $useSoftDeletes = false; // true 일경우 실제로 행을 삭제하는 대신 deleted_at 필드를 설정
    protected $allowedFields = []; //save, insert, update 메소드를 통하여 설정할 수 있는 필드 이름
    protected $useTimestamps = true; // INSERT 및 UPDATE에 자동으로 추가되는지 여부를 결정.
    protected $createdField = 'rec_nos_reg_date'; // 데이터 레코드 작성 타임스탬프를 유지하기 위해 사용하는 데이터베이스 필드
    protected $updatedField = 'rec_nos_mod_date'; // 데이터 레코드 업데이트 타임스탬프를 유지하기 위해 사용할 데이터베이스 필드
    protected $deletedField = 'rec_nos_del_date'; // 데이터 레코드 삭제 타임스탬프를 유지하기 위해 사용할 데이터베이스 필드
    protected $validationRules = []; // 유효성 검사 규칙 배열
    protected $validationMessages = []; // 유효성 검증 중에 사용해야하는 사용자 정의 오류 메시지 배열
    protected $skipValidation = true; // 모든 inserts와 updates의 유효성 검사를 하지 않을지 여부 기본값은 false이며 데이터의 유효성 검사를 항상 시도.


    public function __construct()
    {
        parent::__construct();
        $code = 'iv_recruit_nostradamus';
        $this->table = $code;
        $this->fields = DatabaseInterview::$code();
        if (is_array($this->fields)) {
            foreach ($this->fields as $key => $row) {
                if (isset($row['auto_increment']) && $row['auto_increment'] === true) {
                    $this->primaryKey = $key;
                } else if (!in_array($key, ['rec_nos_reg_date', 'rec_nos_mod_date', 'rec_nos_del_date'])) {
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


    public function getMock(int $_idx): array
    {
        $aMock = [];

        if (!$_idx) {
            return $aMock;
        };

        $aMock = $this
            ->where([
                'idx' => $_idx,
                'delyn' => 'N'
            ])
            ->first();

        return $aMock;
    }

    public function getCompanyName(int $_idx)
    {
        $aCompany = [];

        if (!$_idx) {
            return $aCompany;
        };

        $aCompany = $this
            ->select('iv_company.idx, iv_company.com_name')
            ->join('iv_company', 'iv_company.idx=iv_recruit_nostradamus.com_idx', 'left')
            ->where([
                'iv_recruit_nostradamus.idx' => $_idx,
                'iv_recruit_nostradamus.delyn' => 'N'
            ])
            ->first();

        return $aCompany;
    }

    public function getJobcate(int $idx)
    {
        $aRow = $this
            ->select('iv_job_category.job_depth_text')
            ->join('iv_job_category', 'iv_job_category.idx=iv_recruit_nostradamus.job_idx', 'left')
            ->where([
                'iv_recruit_nostradamus.idx' => $idx,
                'iv_recruit_nostradamus.delyn' => 'N'
            ])
            ->first();
        return $aRow;
    }
    public function getNosList()
    {
        $aRow = [];

        $aRow = $this
            ->where([
                'delyn' => 'N'
            ])
            ->orderBy('idx', 'desc');

        return $aRow;
    }
}
