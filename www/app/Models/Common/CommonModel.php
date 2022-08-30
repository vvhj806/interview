<?php

namespace App\Models\Common;

use CodeIgniter\Model;
use App\Models\DatabaseInterview;

class CommonModel extends Model
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
        // $code = 'iv_alarm';
        // $this->table = $code;
        // $this->fields = DatabaseInterview::$code();
        // if (is_array($this->fields)) {
        //     foreach ($this->fields as $key => $row) {
        //         if (isset($row['auto_increment']) && $row['auto_increment'] === true) {
        //             $this->primaryKey = $key;
        //         } else {
        //             $this->allowedFields[] = $key;
        //         }
        //     }
        // }
    }

    public function setAlarm($memIdx = '', $type1, $type2, $link = '', $title = '', $message = '', $linkType)
    {
        // $masterDB
        $masterDB = \Config\Database::connect('master');
        // //트랜잭션 start
        // $masterDB->transBegin();

        if ($type1 == 'A') { //전체
            $addwhere = "mem_type IN ('M','C')";
        } else if ($type1 == 'G') { //일반
            $addwhere = "mem_type IN ('M')";
        } else if ($type1 == 'B') { //기업
            $addwhere = "mem_type IN ('C')";
        } else if ($type1 == 'I') { //개별 - 사용안함
            //   $addwhere = "mem_idx IN ({$memIdx})";
        }

        $type2_arr_in = ['S', 'P', 'R']; //지원, 제안, 재응시
        if (in_array($type2, $type2_arr_in)) {
            $addwhere .= " AND idx IN({$memIdx})";
        }

        if ($linkType == 'I') {
            $pageIdx = $link;
            $link = '';
        } else if ($linkType == 'O') {
            $pageIdx = '';
        }

        $sql = "INSERT INTO iv_alarm (mem_idx, alarm_type1, alarm_type2, alarm_page_idx, alarm_link, alarm_title, alarm_message, reg_date, delyn)
            (SELECT idx mem_idx, '{$type1}' AS alarm_type1, '{$type2}' AS alarm_type2, '{$pageIdx}' AS alarm_page_idx, 
                    '$link' AS alarm_link, '{$title}' AS alarm_title, '{$message}' AS alarm_message, NOW() AS reg_date , 'N' AS delyn
                    FROM iv_member 
                    WHERE {$addwhere} AND delyn = 'N' AND mem_id NOT LIKE '%@highbuff.com' AND mem_id LIKE '%@%')";
        
        $masterDB->query($sql);

        // //알림 추가
        // $masterDB->table('iv_alarm')
        //     ->set([
        //         'mem_idx' => $memIdx,
        //         'alarm_type1' => $type1,
        //         'alarm_type2' => $type2,
        //         'alarm_page_idx' => $pageIdx,
        //         'alarm_link' => $link,
        //         'alarm_title' => $title,
        //         'delyn' => 'N'
        //     ])
        //     ->set(['reg_date' => 'NOW()'], '', false)
        //     //->set(['mod_date' => 'NOW()'], '', false)
        //     ->insert();
        // 트랜잭션 end
        // if ($masterDB->transStatus() === false) {
        //     $masterDB->transRollback();
        // } else {
        //     $masterDB->transCommit();
        // }

        $masterDB->close();
    }
}
