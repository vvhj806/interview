<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\DatabaseInterview;

class RecruitInfoModel extends Model
{
    protected $table = ''; // 데이터베이스 테이블을 지정
    protected $primaryKey = ''; // 테이블에서 레코드를 고유하게 식별하는 열(column)의 이름
    protected $useAutoIncrement = true; // (auto-increment) 기능을 사용할지 여부
    protected $tempReturnType = 'array'; // 반환되는값 지정 array,object 
    protected $useSoftDeletes = false; // true 일경우 실제로 행을 삭제하는 대신 deleted_at 필드를 설정
    protected $allowedFields = []; //save, insert, update 메소드를 통하여 설정할 수 있는 필드 이름
    protected $useTimestamps = true; // INSERT 및 UPDATE에 자동으로 추가되는지 여부를 결정.
    protected $createdField = 'res_info_reg_date'; // 데이터 레코드 작성 타임스탬프를 유지하기 위해 사용하는 데이터베이스 필드
    protected $updatedField = 'res_info_mod_date'; // 데이터 레코드 업데이트 타임스탬프를 유지하기 위해 사용할 데이터베이스 필드
    protected $deletedField = 'res_info_del_date'; // 데이터 레코드 삭제 타임스탬프를 유지하기 위해 사용할 데이터베이스 필드
    protected $validationRules = []; // 유효성 검사 규칙 배열
    protected $validationMessages = []; // 유효성 검증 중에 사용해야하는 사용자 정의 오류 메시지 배열
    protected $skipValidation = true; // 모든 inserts와 updates의 유효성 검사를 하지 않을지 여부 기본값은 false이며 데이터의 유효성 검사를 항상 시도.


    public function __construct()
    {
        parent::__construct();
        $code = 'iv_recruit_info';
        $this->table = $code;
        $this->fields = DatabaseInterview::$code();
        if (is_array($this->fields)) {
            foreach ($this->fields as $key => $row) {
                if (isset($row['auto_increment']) && $row['auto_increment'] === true) {
                    $this->primaryKey = $key;
                } else if (!in_array($key, ['res_info_reg_date', 'res_info_mod_date', 'res_info_del_date'])) {
                    $this->allowedFields[] = $key;
                }
            }
        }
    }

    public function alreadyApply($memIdx, $recIdx): array
    {
        $aRow = [];

        if (!$memIdx || !$recIdx) {
            return $aRow;
        }

        $aRow = $this->select('idx')
            ->where('mem_idx', $memIdx)
            ->where('rec_idx', $recIdx)
            ->where('delyn', 'N')
            ->orderBy('idx', 'DESC')
            ->findAll();
        return $aRow ?? [];
    }

    public function getMyApply(int $memIdx): object
    {
        $aRow = [];
        if (!$memIdx) {
            return $aRow;
        }

        $aRow = $this
            ->distinct()
            ->select('rec_idx')
            ->where([
                'mem_idx' => $memIdx,
                'rec_idx !=' => null,
                'delyn' => 'N',
            ]);
        return $aRow;
    }

    public function getList(int $memIdx): object
    {
        $aRow = (object)[];
        if (!$memIdx) {
            return $aRow;
        }

        $aRow = $this
            ->join('iv_recruit', 'iv_recruit_info.rec_idx = iv_recruit.idx', 'inner')
            ->join('iv_company', 'iv_company.idx = iv_recruit.com_idx', 'left')
            ->where([
                'iv_recruit_info.mem_idx' => $memIdx,
                'iv_recruit_info.delyn' => 'N',
                'iv_recruit.delyn' => 'N',
                'iv_recruit.rec_stat' => 'Y'
            ])
            ->orderBy('iv_recruit_info.res_info_reg_date', 'desc');
        return $aRow;
    }

    public function getMyApplys(int $memIdx, int $recIdx): object
    {
        $aRow = [];
        if (!$memIdx) {
            return $aRow;
        }

        $aRow = $this
            ->select('iv_recruit_info.idx')
            ->join('config_again_request', 'config_again_request.rec_info_idx = iv_recruit_info.idx', 'left')
            ->where(['ag_req_stat !=' => 'Y'])
            ->where([
                'mem_idx' => $memIdx,
                'rec_idx' => $recIdx,
                'iv_recruit_info.delyn' => 'N',
            ]);
        return $aRow;
    }

    public function getInfoTimes($memIdx, array $recIdxs): array
    {
        $aRow = [];
        if (!$memIdx || !$recIdxs) {
            return $aRow;
        }

        foreach ($recIdxs as $val) {
            $aRow = $this
                ->select('count(idx) as cnt')
                ->where([
                    'mem_idx' => $memIdx,
                    'rec_idx' => $val,
                    'delyn' => 'N'
                ])
                ->first();

            $aCnt[] = $aRow;
        }

        return $aCnt;
    }

    public function requestBuilder(): object
    {
        $aRow = $this
            ->join('iv_config_again_request', 'iv_recruit_info.idx = iv_config_again_request.rec_info_idx', 'left')
            ->where(['iv_config_again_request.ag_req_stat !=' => 'Y']);
        return $aRow;
    }

    public function getRecruitList(): object
    {
        $aRow = (object)[];

        $aRow = $this
            ->join('iv_recruit', 'iv_recruit_info.rec_idx = iv_recruit.idx', 'left')
            ->join('iv_company', 'iv_company.idx = iv_recruit.com_idx', 'left')
            ->join('iv_member', 'iv_recruit_info.mem_idx = iv_member.idx', 'left')
            ->join('iv_file', 'iv_company.file_idx_logo = iv_file.idx', 'left')
            ->join('config_again_request', 'config_again_request.rec_info_idx = iv_recruit_info.idx', 'left')
            ->join('iv_applier', 'iv_applier.idx = iv_recruit_info.app_idx', 'left')
            ->where([
                'iv_recruit_info.delyn' => 'N',
                'iv_recruit.delyn' => 'N',
                'iv_recruit.rec_stat' => 'Y',
                'iv_member.delyn' => 'N',
                'iv_file.delyn' => 'N',
            ]);
        return $aRow;
    }

    public function getRecInfoDetail($recIdx)
    {
        $aRow = [];
        if (!$recIdx) {
            return $aRow;
        }

        $aRow = $this
            ->join('iv_recruit', 'iv_recruit.idx = iv_recruit_info.rec_idx', 'left')
            ->join('iv_company', 'iv_company.idx = iv_recruit_info.com_idx', 'left')
            ->join('iv_file', 'iv_file.idx = iv_company.file_idx_logo', 'left')
            ->where([
                'iv_recruit_info.rec_idx' => $recIdx
            ]);

        return $aRow;
    }

    public function getRecruitInfoDetail($recIdx)
    {
        $aRow = [];
        if (!$recIdx) {
            return $aRow;
        }

        $aRow = $this
            ->join('iv_member', 'iv_member.idx = iv_recruit_info.mem_idx', 'left')
            ->join('config_again_request', 'config_again_request.rec_info_idx = iv_recruit_info.idx', 'left')
            ->where([
                'iv_recruit_info.rec_idx' => $recIdx
            ]);

        return $aRow;
    }

    public function daysInBullder(int $iDays = 1) // 오늘 - iDays의 값만
    {
        $timestamp = strtotime("Now");
        $today = date('Y-m-d H:i:s', $timestamp);
        $timestamp = strtotime("-{$iDays} days");
        $beforeDay = date('Y-m-d H:i:s', $timestamp);
        $objQuery = $this
            ->where(['iv_recruit_info.res_info_reg_date <=' => $today, 'iv_recruit_info.res_info_reg_date >=' => $beforeDay]);
        return $objQuery;
    }

    public function getMyData(int $iMemIdx)
    {
        $objQuery = (object)[];
        if (!$iMemIdx) {
            return;
        }
        $objQuery = $this
            ->where(['iv_recruit_info.mem_idx' => $iMemIdx, 'iv_recruit_info.delyn' => 'N']);
        return $objQuery;
    }

    public function checkRecruitInfo(int $iMemIdx, int $iDays): bool
    {
        $boolResult = $this->select(['iv_recruit_info.idx'])->daysInBullder($iDays)->getMyData($iMemIdx)->first();
        return $boolResult ? true : false;
    }
}
