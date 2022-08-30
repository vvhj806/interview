<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\DatabaseInterview;

class QuestionModel extends Model
{
    protected $table = ''; // 데이터베이스 테이블을 지정
    protected $primaryKey = ''; // 테이블에서 레코드를 고유하게 식별하는 열(column)의 이름
    protected $useAutoIncrement = true; // (auto-increment) 기능을 사용할지 여부
    protected $tempReturnType = 'array'; // 반환되는값 지정 array,object 
    protected $useSoftDeletes = false; // true 일경우 실제로 행을 삭제하는 대신 deleted_at 필드를 설정
    protected $allowedFields = []; //save, insert, update 메소드를 통하여 설정할 수 있는 필드 이름
    protected $useTimestamps = true; // INSERT 및 UPDATE에 자동으로 추가되는지 여부를 결정.
    protected $createdField = 'que_reg_date'; // 데이터 레코드 작성 타임스탬프를 유지하기 위해 사용하는 데이터베이스 필드
    protected $updatedField = 'que_mod_date'; // 데이터 레코드 업데이트 타임스탬프를 유지하기 위해 사용할 데이터베이스 필드
    protected $deletedField = 'que_del_date'; // 데이터 레코드 삭제 타임스탬프를 유지하기 위해 사용할 데이터베이스 필드
    protected $validationRules = []; // 유효성 검사 규칙 배열
    protected $validationMessages = []; // 유효성 검증 중에 사용해야하는 사용자 정의 오류 메시지 배열
    protected $skipValidation = true; // 모든 inserts와 updates의 유효성 검사를 하지 않을지 여부 기본값은 false이며 데이터의 유효성 검사를 항상 시도.


    public function __construct($code = 'iv_question')
    {
        parent::__construct();
        // $code = 'iv_question';
        $this->table = $code;
        $this->fields = DatabaseInterview::$code();
        if (is_array($this->fields)) {
            foreach ($this->fields as $key => $row) {
                if (isset($row['auto_increment']) && $row['auto_increment'] === true) {
                    $this->primaryKey = $key;
                } else if (!in_array($key, ['que_reg_date', 'que_mod_date', 'que_del_date'])) {
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

    public function getQueCount($recIdx)
    {
        $aRow = [];

        if (!$recIdx) {
            return $aRow;
        }

        $aRow = $this
            ->select('COUNT(idx) as queCnt')
            ->where([
                "rec_idx" => $recIdx,
                "delyn" => 'N'
            ])
            ->first();

        return $aRow;
    }

    public function getQue($aQuestion, $strQuestion)
    {
        $aRow = [];

        if (!$aQuestion) {
            return $aRow;
        }

        $aRow = $this
            ->whereIn('idx', $aQuestion)
            ->where([
                'delyn' => 'N'
            ])
            ->orderBy('FIELD(idx,' . $strQuestion . ')')
            ->findAll();

        return $aRow;
    }

    public function bizQuestion(): array
    {
        $aRow = [];

        // if (!$aQuestion) {
        //     return $aRow;
        // }

        $aRow = $this
            ->select(['idx', 'que_question', 'que_type', 'que_best_answer'])
            ->where([
                'delyn' => 'N'
            ])
            ->findAll();

        return $aRow ?? [];
    }

    public function getQueRandJob($jobIdx) //2.0
    {
        $aRow = [];

        if (!$jobIdx) {
            return $aRow;
        }

        $aRow = $this
            ->where([
                'job_idx' => $jobIdx,
                'que_type' => 'J',
                'delyn' => 'N'
            ])
            ->orderBy('rand()', '', false);
        return $aRow;
    }

    public function getQueRandJobOld($jobIdx) //1.5
    {
        $aRow = [];

        if (!$jobIdx) {
            return $aRow;
        }

        $aRow = $this
            ->where([
                'job_idx' => $jobIdx,
                'que_type' => 'G',
                'delyn' => 'N'
            ])
            ->orderBy('rand()', '', false);

        return $aRow;
    }


    public function getQueRandCommon()
    {
        $aRow = [];

        $aRow = $this
            ->select('iv_question.*')
            ->join('iv_job_category as jc', 'iv_question.job_idx=jc.idx', 'left')
            ->where([
                'jc.job_depth_1' => '33',
                'jc.job_depth_2' => '1',
                'iv_question.que_type' => 'C',
                'iv_question.delyn' => 'N',
                'com_idx' => null
            ])
            ->orderBy('rand()', '', false);
        return $aRow;
    }
}
