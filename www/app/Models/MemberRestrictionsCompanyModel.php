<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\DatabaseInterview;

class MemberRestrictionsCompanyModel extends Model
{
    protected $table = ''; // 데이터베이스 테이블을 지정
    protected $primaryKey = ''; // 테이블에서 레코드를 고유하게 식별하는 열(column)의 이름
    protected $useAutoIncrement = true; // (auto-increment) 기능을 사용할지 여부
    protected $tempReturnType = 'array'; // 반환되는값 지정 array,object 
    protected $useSoftDeletes = true; // true 일경우 실제로 행을 삭제하는 대신 deleted_at 필드를 설정
    protected $allowedFields = []; //save, insert, update 메소드를 통하여 설정할 수 있는 필드 이름
    protected $useTimestamps = true; // INSERT 및 UPDATE에 자동으로 추가되는지 여부를 결정.
    protected $createdField = 'mem_res_reg_date'; // 데이터 레코드 작성 타임스탬프를 유지하기 위해 사용하는 데이터베이스 필드
    protected $deletedField = 'mem_res_del_date'; // 데이터 레코드 삭제 타임스탬프를 유지하기 위해 사용할 데이터베이스 필드
    protected $validationRules = []; // 유효성 검사 규칙 배열
    protected $validationMessages = []; // 유효성 검증 중에 사용해야하는 사용자 정의 오류 메시지 배열
    protected $skipValidation = false; // 모든 inserts와 updates의 유효성 검사를 하지 않을지 여부 기본값은 false이며 데이터의 유효성 검사를 항상 시도.
    protected $jsonField = [];
    protected $afterFind = [];

    public function __construct()
    {
        parent::__construct();
        $code = 'iv_member_restrictions_company';
        $this->table = $code;
        $this->_db = new DatabaseInterview();
        $this->fields = DatabaseInterview::$code();
        if (is_array($this->fields)) {
            foreach ($this->fields as $key => $row) {
                if (isset($row['auto_increment']) && $row['auto_increment'] === true) {
                    $this->primaryKey = $key;
                } else if (!in_array($key, ['mem_res_reg_date', 'mem_res_del_date'])) {
                    $this->allowedFields[] = $key;
                }
            }
        }
    }

    public function getRestrictionsList(int $memIdx): object
    {
        $aResult = (object)[];

        if (!$memIdx) {
            return $aResult;
        }

        $aResult = $this
            ->join('iv_company', 'iv_company.idx = iv_member_restrictions_company.com_idx', 'inner')
            ->where([
                'iv_member_restrictions_company.mem_idx' => $memIdx,
                'iv_member_restrictions_company.delyn' => 'N'
            ]);

        return $aResult;
    }
}
