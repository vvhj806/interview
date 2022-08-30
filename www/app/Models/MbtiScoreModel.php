<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\DatabaseInterview;

class MbtiScoreModel extends Model
{
    protected $table = ''; // 데이터베이스 테이블을 지정

    public function __construct()
    {
        parent::__construct();
        $code = 'iv_mbti_score';
        $this->table = $code;
        $this->fields = DatabaseInterview::$code();
        if (is_array($this->fields)) {
            foreach ($this->fields as $columnName => $row) {
                if (isset($row['auto_increment']) && $row['auto_increment'] === true) {
                    $this->primaryKey = $columnName;
                }
            }
        }
    }

    public function mbtiMsgBuilder(): object
    {
        $objQuery = $this->join('iv_mbti_msg', 'iv_mbti_msg.mbti = iv_mbti_score.mbti', 'left');
        return $objQuery;
    }

    public function mbtiRecommendBuilder(): object
    {
        $objQuery = $this->join('iv_mbti_recommend_job', 'iv_mbti_recommend_job.mbti = iv_mbti_score.mbti', 'left');
        return $objQuery;
    }

    public function mbtiSelector(): object
    {
        $objQuery = $this->select([
            'iv_mbti_score.mbti AS mbtiValue', 'iv_mbti_score.value AS mbtiScore', 'iv_mbti_msg.msg as mbtiMsg',
            'iv_mbti_recommend_job.job1 as recommendJob1', 'iv_mbti_recommend_job.job2 as recommendJob2', 'iv_mbti_recommend_job.job3 as recommendJob3'
        ]);
        return $objQuery;
    }

    public function baseTerm(int $iJobIdx): object
    {
        $objQuery = $this
            ->where(['iv_mbti_score.job_idx' => $iJobIdx]);
        return $objQuery;
    }

    public function getMbtiData(int $iJobIdx): array
    {
        $aResult = [];
        $aResult = $this->mbtiSelector()->mbtiMsgBuilder()->mbtiRecommendBuilder()->baseTerm($iJobIdx)->findAll();
        return $aResult;
    }
}
