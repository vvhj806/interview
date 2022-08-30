<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\DatabaseInterview;

class AlarmModel extends Model
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
    protected $skipValidation = true; // 모든 inserts와 updates의 유효성 검사를 하지 않을지 여부 기본값은 false이며 데이터의 유효성 검사를 항상 시도.


    public function __construct()
    {
        parent::__construct();
        $code = 'iv_alarm';
        $this->table = $code;
        $this->fields = DatabaseInterview::$code();
        if (is_array($this->fields)) {
            foreach ($this->fields as $key => $row) {
                if (isset($row['auto_increment']) && $row['auto_increment'] === true) {
                    $this->primaryKey = $key;
                } else {
                    $this->allowedFields[] = $key;
                }
            }
        }
    }

    public function selectAlarm($memIdx, $alarmType = []): array
    {
        $aRow = [];
        if (!$memIdx) {
            return $aRow;
        }
        $aRow = $this
            ->select(['alarm_type1', 'alarm_type2', 'alarm_page_idx', 'alarm_link', 'alarm_title', 'reg_date', 'mod_date'])
            ->where(['delyn' => 'N', 'mem_idx' => $memIdx]);
        if (!empty($alarmType)) {
            $aRow = $this->whereIn('alarm_type2', $alarmType);
        }
        $aRow = $this->orderBy('idx', 'desc');
        $aRow = $this->findAll();

        return $aRow;
    }

    public function selectPage($pageIdx, $alarmType): array
    {
        $aRow = [];
        if (!$pageIdx) {
            return $aRow;
        }
        $aRow = $this;


        if ($alarmType == 'A') { //기업 - 제안(제안타입, applier, 메시지, 담당자 정보 상태, 담당자명, 담당자 연락처, 연락처, 제안마감일)
            $aRow
                ->table('iv_company_suggest')
                ->select(['sug_type', 'app_idx', 'sug_massage', 'sug_manager', 'sug_manager_name', 'sug_manager_tel', 'sug_tel', 'sug_end_date'])
                ->where([
                    'idx' => $pageIdx,
                    'delyn' => 'N'
                ])
                ->first();
        } else if ($alarmType == 'B') { //기업 - 재응시(applier, 재응시 요청 상태, 요청 확인일, 요청사유)
            $aRow
                ->table('iv_recruit_info')
                ->select(['app_idx', 'res_info_re_com', 'res_info_re_mod_date', 'res_info_re_reason'])
                ->where([
                    'idx' => $pageIdx,
                    'delyn' => 'N'
                ])
                ->first();
        } else if ($alarmType == 'C') { //일반 - 공지(제목, 내용)
            $aRow
                ->table('iv_board_notice')
                ->select(['bd_title', 'bd_content'])
                ->where([
                    'idx' => $pageIdx,
                    'delyn' => 'N'
                ])
                ->first();
        } else if ($alarmType == 'C') { //일반 - 이벤트(제목, 내용)
            $aRow
                ->table('iv_board_event')
                ->select(['bd_title', 'bd_content'])
                ->where([
                    'idx' => $pageIdx,
                    'delyn' => 'N'
                ])
                ->first();
        }

        return $aRow ?? [];
    }

    public function updateAlarm($alarmIdx, $updateType)
    {
        // $masterDB
        $masterDB = \Config\Database::connect('master');
        //트랜잭션 start
        $masterDB->transBegin();

        if ($updateType == 'delete') {
            //알림 삭제
            $masterDB->table('iv_alarm')
                ->set([
                    'delyn' => 'Y',
                ])
                ->set(['del_date' => 'NOW()'], '', false)
                ->where([
                    'idx' => $alarmIdx,
                ])
                ->update();
        } else if ($updateType == 'update') {
            //알림 확인 시
            $masterDB->table('iv_alarm')
                ->set(['mod_date' => 'NOW()'], '', false)
                ->where([
                    'idx' => $alarmIdx,
                ])
                ->update();
        }
        // 트랜잭션 end
        if ($masterDB->transStatus() === false) {
            $masterDB->transRollback();
        } else {
            $masterDB->transCommit();
        }

        $masterDB->close();
    }

    public function insertAlarm($memIdx, $alarmType, $alarmPageIdx, $alarmtitle)
    {
        // $masterDB
        $masterDB = \Config\Database::connect('master');
        //트랜잭션 start
        $masterDB->transBegin();

        //알림 추가
        $masterDB->table('iv_alarm')
            ->set([
                'mem_idx' => $memIdx,
                'alarm_type' => $alarmType,
                'alarm_page_idx' => $alarmPageIdx,
                'alarm_link' => '',
                'alarm_title' => $alarmtitle,
                'delyn' => 'N'
            ])
            ->set(['reg_date' => 'NOW()'], '', false)
            ->set(['mod_date' => 'NOW()'], '', false)
            ->insert();
        // 트랜잭션 end
        if ($masterDB->transStatus() === false) {
            $masterDB->transRollback();
        } else {
            $masterDB->transCommit();
        }

        $masterDB->close();
    }

    public function daysInBullder(int $iDays = 1) // 오늘 - iDays의 값만
    {
        $timestamp = strtotime("Now");
        $today = date('Y-m-d H:i:s', $timestamp);
        $timestamp = strtotime("-{$iDays} days");
        $beforeDay = date('Y-m-d H:i:s', $timestamp);
        $objQuery = $this
            ->where(['iv_alarm.reg_date <=' => $today, 'iv_alarm.reg_date >=' => $beforeDay]);
        return $objQuery;
    }

    public function getMyData(int $iMemIdx)
    {
        $objQuery = (object)[];
        if (!$iMemIdx) {
            return;
        }
        $objQuery = $this
            ->where(['iv_alarm.mem_idx' => $iMemIdx, 'iv_alarm.delyn' => 'N']);
        return $objQuery;
    }

    public function checkAlarm(int $iMemIdx, int $iDays): bool
    {
        $boolResult = $this->select(['iv_alarm.idx'])->daysInBullder($iDays)->getMyData($iMemIdx)->first();
        return $boolResult ? true : false;
    }
}
