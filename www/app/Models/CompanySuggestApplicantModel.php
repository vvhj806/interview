<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\DatabaseInterview;

class CompanySuggestApplicantModel extends Model
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
        $code = 'iv_company_suggest_applicant';
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

    // copy 다 지우기
    public function getApplicantInfo(int $idx): object
    {
        $aRow = [];
        if (!$idx) {
            return $aRow;
        }

        $aRow = $this
            ->select('iv_company_suggest_applicant.sug_idx, iv_interview.idx, iv_interview.inter_name, iv_company_suggest_applicant.sug_app_phone, iv_company_suggest_applicant.sug_app_name, iv_company_suggest_applicant.sug_app_title, iv_interview.inter_opportunity_yn')
            ->join('iv_interview', 'iv_interview.idx = iv_company_suggest_applicant.inter_idx')
            ->where([
                'iv_company_suggest_applicant.idx' => $idx,
                'iv_company_suggest_applicant.delyn' => 'N'
            ]);

        return $aRow;
    }

    public function getApplicantInfo2(int $idx): object
    {
        $aRow = [];
        if (!$idx) {
            return $aRow;
        }

        $aRow = $this
            ->select('iv_company_suggest_applicant.idx app_idx, iv_company_suggest_applicant.gs_ck, iv_company_suggest_applicant.sug_idx, iv_interview.idx, iv_interview.inter_name, iv_company_suggest_applicant.sug_app_phone, iv_company_suggest_applicant.sug_app_name, iv_company_suggest_applicant.sug_app_title, iv_company_suggest_applicant.old_ap_idx')
            ->join('iv_interview', 'iv_interview.idx = iv_company_suggest_applicant.inter_idx')
            ->where([
                'iv_company_suggest_applicant.app_idx' => $idx,
                'iv_company_suggest_applicant.delyn' => 'N'
            ]);

        return $aRow;
    }

    public function checkAppApplier(int $appIdx): object
    {
        $aRow = [];
        if (!$appIdx) {
            return $aRow;
        }

        $aRow = $this
            ->select('app_idx')
            ->where([
                'idx' => $appIdx
            ]);

        return $aRow ?? [];
    }

    public function checkAppApplierStat(int $appIdx): object
    {
        $aRow = [];
        if (!$appIdx) {
            return $aRow;
        }

        $aRow = $this
            ->select('iv_applier.app_iv_stat')
            ->join('iv_applier', 'iv_company_suggest_applicant.app_idx = iv_applier.idx')
            ->where([
                'iv_company_suggest_applicant.idx' => $appIdx
            ]);

        return $aRow ?? [];
    }

    public function getApplicantIdx(int $_idx)
    {
        $iIdx = "";
        if (!$_idx) {
            return $iIdx;
        }

        $iIdx = $this->select('idx')->where(['app_idx' => $_idx])->first();

        return $iIdx['idx'] ?? "";
    }

    public function getSendSuggestionsList(int $iSugIdx): object
    {
        $aResult = (object)[];
        if (!$iSugIdx) {
            return $aResult;
        }
        $aResult = $this
            ->where(['iv_company_suggest_applicant.idx' => $iSugIdx, 'iv_company_suggest_applicant.delyn' => 'N']);
        return $aResult;
    }

    // 재응시요청 수락된것 -> ag_req_stat = 'Y' AND  ag_req_com = 'Y'
    // 재응시요청 거절 -> ag_req_stat = 'N' AND  ag_req_com = 'Y'
    // 면접관이 요청 들어온것 확인함 -> ag_req_com = 'Y'
    // 면접관이 요청 들어온것 확인전 -> ag_req_com = 'N' (재응시요청한 직후)
    public function applicantRequestBuilder(bool $select = false): object
    {
        $objQuery = $select ? $this->select(['ag_req_stat', 'ag_req_com']) : '';
        $objQuery = $this
            ->join(
                'config_again_request',
                'iv_company_suggest_applicant.idx = config_again_request.sug_app_idx AND config_again_request.delyn = "N"',
                'left'
            );
        return $objQuery;
    }

    public function selectorGsCk(): object
    {
        $objQuery = $this
            ->select(['iv_company_suggest_applicant.gs_ck']);
        return $objQuery;
    }

    public function checkGsCk(int $iIdx): bool
    {
        $boolResult = $this
            ->selectorGsCk()->where(['iv_company_suggest_applicant.idx' => $iIdx, 'iv_company_suggest_applicant.gs_ck' => 'Y'])->first();
        return $boolResult ? true : false;
    }
}
