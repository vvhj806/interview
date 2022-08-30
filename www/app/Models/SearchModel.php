<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\DatabaseInterview;

class SearchModel extends Model
{
    protected $table = ''; // 데이터베이스 테이블을 지정

    public function __construct(string $table)
    {
        parent::__construct();
        $this->table = $table;
        $this->fields = DatabaseInterview::$table();
        if (is_array($this->fields)) {
            foreach ($this->fields as $columnName => $row) {
                if (isset($row['auto_increment']) && $row['auto_increment'] === true) {
                    $this->primaryKey = $columnName;
                } else if (!in_array($columnName, ['mem_reg_date', 'mem_mod_date', 'mem_del_date'])) {
                    $this->allowedFields[] = $columnName;
                }
            }
        }
    }

    public function getRecruit(string $keyword): object
    {
        $aResult = (object)[];
        $today = date('Ymd');
        $aResult = $this
            ->select(['area_depth_text_1', 'area_depth_text_2', 'iv_file.file_save_name'])
            ->join('iv_korea_area', 'iv_recruit.kor_area_idx = iv_korea_area.idx', 'inner')
            ->join('iv_company', 'iv_recruit.com_idx = iv_company.idx', 'inner')
            ->join('iv_job_category', 'iv_recruit.job_idx = iv_job_category.idx', 'inner')
            ->join('iv_file', 'iv_company.file_idx_logo = iv_file.idx', 'left')
            ->where([
                'iv_recruit.delyn' => 'N',
                'iv_recruit.rec_stat' => 'Y',
                'iv_recruit.rec_end_date >=' => $today
            ])

            ->groupStart() // 키워드
            ->like('rec_title', $keyword, 'both')
            ->orLike('com_name', $keyword, 'both')
            ->orLike('job_depth_text', $keyword, 'both')
            ->groupEnd();

        return $aResult;
    }

    public function getRecruitDetail(string $keyword, string $sort, array $deepSearch): object
    {
        $aResult = (object)[];
        if (!$sort || !$deepSearch) {
            return $aResult;
        }
        $today = date('Ymd');

        $aResult = $this
            ->select(['area_depth_text_1', 'area_depth_text_2', 'iv_file.file_save_name'])
            ->join('iv_korea_area', 'iv_recruit.kor_area_idx = iv_korea_area.idx', 'inner')
            ->join('iv_company', 'iv_recruit.com_idx = iv_company.idx', 'inner')
            ->join('iv_job_category', 'iv_recruit.job_idx = iv_job_category.idx', 'inner')
            ->join('iv_file', 'iv_company.file_idx_logo = iv_file.idx', 'left');

        $aResult = $this
            ->where([
                'iv_recruit.delyn' => 'N',
                'iv_recruit.rec_stat' => 'Y',
                'iv_recruit.rec_end_date >=' => $today
            ])
            ->groupStart() // 키워드
            ->like('rec_title', $keyword, 'both')
            ->orLike('com_name', $keyword, 'both')
            ->orLike('job_depth_text', $keyword, 'both')
            ->groupEnd();

        foreach ($deepSearch as $columnName => $data) {
            if ($columnName === 'rec_work_type' || $columnName === 'rec_work_day') {
                $aResult = $this
                    ->groupStart();
                foreach ($data as $v) {
                    $aResult = $this
                        ->orLike($columnName, $v);
                }
                $aResult = $this
                    ->groupEnd();
            } else if ($columnName === 'iv_recruit.idx1' || $columnName === 'iv_recruit.idx2') {
                $aResult = $this
                    ->groupStart()
                    ->whereIn('iv_recruit.idx', $data)
                    ->groupEnd();
            } else if ($columnName === 'rec_apply') {
                $aResult = $this
                    ->groupStart()
                    ->whereIn($columnName, [$data, 'A'])
                    ->groupEnd();
            } else if ($columnName === 'que_count') {
                $aResult = $this
                    ->select('iv_interview.inter_question as queCount')
                    ->join('iv_interview', 'iv_recruit.idx = iv_interview.rec_idx', 'inner');
            } else {
                if (is_array($data)) {
                    $aResult = $this
                        ->groupStart()
                        ->whereIn($columnName, $data)
                        ->groupEnd();
                } else {
                    $aResult = $this
                        ->groupStart()
                        ->where($columnName, $data)
                        ->groupEnd();
                }
            }
        }

        $aResult = $this->orderBy($sort, $sort === 'rec_start_date' || $sort === 'rec_pay_unit' ? 'DESC' : 'ASC');

        return $aResult;
    }

    public function getCompany(string $keyword): object
    {
        $aResult = (object)[];

        $aResult = $this
            ->select(['iv_file.file_save_name'])
            ->join('iv_file', 'iv_company.file_idx_logo = iv_file.idx', 'left')
            ->groupStart()
            ->where('iv_company.delyn', 'N')
            ->like('com_name', $keyword, 'both')
            ->orLike('com_industry', $keyword, 'both')
            ->groupEnd();
        return $aResult;
    }
}
