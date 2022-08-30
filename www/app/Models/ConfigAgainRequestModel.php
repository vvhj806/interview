<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\DatabaseInterview;

class ConfigAgainRequestModel extends Model
{
    protected $table = ''; // 데이터베이스 테이블을 지정
    protected $primaryKey = ''; // 테이블에서 레코드를 고유하게 식별하는 열(column)의 이름
    protected $useAutoIncrement = true; // (auto-increment) 기능을 사용할지 여부
    protected $tempReturnType = 'array'; // 반환되는값 지정 array,object 
    protected $useSoftDeletes = false; // true 일경우 실제로 행을 삭제하는 대신 deleted_at 필드를 설정
    protected $allowedFields = []; //save, insert, update 메소드를 통하여 설정할 수 있는 필드 이름
    protected $useTimestamps = true; // INSERT 및 UPDATE에 자동으로 추가되는지 여부를 결정.
    protected $createdField = ''; // 데이터 레코드 작성 타임스탬프를 유지하기 위해 사용하는 데이터베이스 필드
    protected $updatedField = ''; // 데이터 레코드 업데이트 타임스탬프를 유지하기 위해 사용할 데이터베이스 필드
    protected $deletedField = ''; // 데이터 레코드 삭제 타임스탬프를 유지하기 위해 사용할 데이터베이스 필드
    protected $validationRules = []; // 유효성 검사 규칙 배열
    protected $validationMessages = []; // 유효성 검증 중에 사용해야하는 사용자 정의 오류 메시지 배열
    protected $skipValidation = false; // 모든 inserts와 updates의 유효성 검사를 하지 않을지 여부 기본값은 false이며 데이터의 유효성 검사를 항상 시도.


    public function __construct()
    {
        parent::__construct();
        $code = 'config_again_request';
        $this->table = $code;
        $this->fields = DatabaseInterview::$code();
        if (is_array($this->fields)) {
            foreach ($this->fields as $key => $row) {
                if (isset($row['auto_increment']) && $row['auto_increment'] === true) {
                    $this->primaryKey = $key;
                } else if (!in_array($key, [''])) {
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

    public function againRequest(int $sugAppIdx)
    {
        $aRow = [];
        if (!$sugAppIdx) {
            return $aRow;
        }

        $aRow = $this
            ->where([
                'sug_app_idx' => $sugAppIdx,
                'ag_req_com' => 'N'
            ]);

        return $aRow;
    }

    public function againRequestList($ag_req_idx = null): object
    {
        $aRow = [];
        $aRow = $this
            ->select('config_again_request.idx as ag_req_idx, config_again_request.ag_req_stat, config_again_request.ag_req_com, config_again_request.ag_req_reg_date, iv_company.idx as com_idx, iv_company.com_name, config_again_request.ag_req_reason')
            ->join('iv_company', 'iv_company.idx = config_again_request.com_idx', 'left')
            ->where([
                'config_again_request.delyn' => 'N'
            ]);

        if ($ag_req_idx != null) {
            $aRow = $this->where('config_again_request.idx', $ag_req_idx);
        }
        return $aRow;
    }

    public function memberBuilder(): object
    {
        $aRow = $this
            ->select('iv_member.mem_id, iv_member.mem_name, iv_member.mem_tel, iv_recruit.rec_title as title, iv_member.idx as mem_idx, iv_recruit.idx as rec_idx, iv_recruit_info.app_idx')
            ->join('iv_recruit_info', 'iv_recruit_info.idx = config_again_request.rec_info_idx', 'left')
            ->join('iv_member', 'iv_member.idx = iv_recruit_info.mem_idx', 'left')
            ->join('iv_recruit', 'iv_recruit.idx = iv_recruit_info.rec_idx', 'left')
            ->where('config_again_request.rec_info_idx is not', null);
        return $aRow;
    }

    public function suggestApplicantBuilder(): object
    {
        $aRow = $this
            ->select('iv_company_suggest_applicant.sug_app_name as mem_name, iv_company_suggest_applicant.sug_app_phone as mem_tel, iv_company_suggest_applicant.sug_app_title as title, iv_company_suggest_applicant.app_idx')
            ->join('iv_company_suggest_applicant', 'iv_company_suggest_applicant.idx = config_again_request.sug_app_idx', 'left')
            ->where('config_again_request.sug_app_idx is not', null);
        return $aRow;
    }

    public function getAgainCompanyInfo($comIdx)
    {
        $aRow = [];
        if (!$comIdx) {
            return $aRow;
        }

        $aRow = $this
            ->select('iv_company.idx as com_idx, config_again_request.idx as ag_req_idx, iv_company.com_name, config_again_request.rec_info_idx, config_again_request.sug_app_idx')
            ->join('iv_company', 'iv_company.idx = config_again_request.com_idx', 'left')
            ->where(['config_again_request.com_idx' => $comIdx, 'config_again_request.delyn' => 'N']);

        return $aRow;
    }

    public function getAgainMsg($ag_req_com, $ag_req_stat): string
    {
        // 재응시요청 수락된것 -> ag_req_stat = 'Y' AND  ag_req_com = 'Y'
        // 재응시요청 거절 -> ag_req_stat = 'N' AND  ag_req_com = 'Y'
        // 면접관이 요청 들어온것 확인함 -> ag_req_com = 'Y'
        // 면접관이 요청 들어온것 확인전 -> ag_req_com = 'N' (재응시요청한 직후)

        $strMsg = '요청 없음'; //재응시 요청 상태
        if ($ag_req_com === 'N') {
            $strMsg = '재응시 요청 보냄 확인 전';
        } else if ($ag_req_com === 'Y') {
            $strMsg = '재응시 요청 확인 중';
            if ($ag_req_stat === 'N') {
                $strMsg = '재응시 요청 거절';
            } else if ($ag_req_stat === 'Y') {
                $strMsg = '재응시 요청 수락';
            }
        }
        return $strMsg;
    }
}
