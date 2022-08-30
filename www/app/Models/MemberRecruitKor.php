<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\DatabaseInterview;

class MemberRecruitKor extends Model
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
        $code = 'iv_member_recruit_kor';
        $this->table = $code;
        $this->fields = DatabaseInterview::$code();
        if (is_array($this->fields)) {
            foreach ($this->fields as $key => $row) {
                if (isset($row['auto_increment']) && $row['auto_increment'] === true) {
                    $this->primaryKey = $key;
                }
            }
        }
    }

    public function save($data): bool
    {
        // $masterDB를 사용해 주세요.
        return false;
    }

    public function getJoinType($type, $idx): array
    {
        //type R:recruit, M:member, S:resume
        $aResult = [];
        if (!in_array($type, ['R', 'M', 'S']) || !$idx) {
            return $aResult;
        }

        $aResult = $this->where(['iv_member_recruit_kor.delyn' => 'N']);
        switch ($type) {
            case 'R':
                $aResult = $this->join('iv_korea_area', 'iv_member_recruit_kor.kor_area_idx = iv_korea_area.idx', 'left')
                    ->where(['mem_rec_type' => $type, 'iv_member_recruit_kor.rec_idx' => $idx])->findAll();
                break;
            case 'M':
                $aResult = $this->join('iv_korea_area', 'iv_member_recruit_kor.kor_area_idx = iv_korea_area.idx', 'left')
                    ->where(['mem_rec_type' => $type, 'iv_member_recruit_kor.mem_idx' => $idx])->findAll();
                break;
            case 'S':
                $aResult = $this->join('iv_korea_area', 'iv_member_recruit_kor.kor_area_idx = iv_korea_area.idx', 'left')
                    ->where(['mem_rec_type' => $type, 'iv_member_recruit_kor.res_idx' => $idx])->findAll();
                break;
        }
        return $aResult;
    }

    public function getRecruitKor(array $recIdx): array
    {
        $aRow = [];
        if (!$recIdx) {
            return $aRow;
        }

        $aRecKor = [];

        foreach ($recIdx as $val) {
            $aRow = $this
                ->select('iv_korea_area.area_depth_text_1, iv_korea_area.area_depth_text_2')
                ->join('iv_korea_area', 'iv_member_recruit_kor.kor_area_idx = iv_korea_area.idx', 'left')
                ->where([
                    'iv_member_recruit_kor.rec_idx' => $val,
                    'iv_member_recruit_kor.mem_rec_type' => 'R',
                    'iv_member_recruit_kor.delyn' => 'N'
                ])
                ->findAll();
            array_push($aRecKor, array('recIdx' => $val, 'area' => $aRow));
        }

        return $aRecKor ?? [];
    }

    public function getCompanyIdx(array $aAreaIdx): array
    {
        $aResult = [];

        if ($aAreaIdx) {
            $aResult = $this
                ->whereIn('kor_area_idx', $aAreaIdx);
        }
        $aResult = $this
            ->where(['mem_rec_type' => 'R', 'iv_member_recruit_kor.delyn' => 'N']);

        $aResult = $this
            ->groupBy('rec_idx')
            ->findColumn('rec_idx');
        return $aResult ?? [-1];
    }

    //희망직무로 선택한 카테고리 가져오기
    public function getKorArea(int $_idx)
    {
        $aCategory = $this->select('*')
            ->join('iv_korea_area', 'iv_korea_area.idx=iv_member_recruit_kor.kor_area_idx', 'left')
            ->where('iv_member_recruit_kor.delyn', 'N')
            ->where('iv_member_recruit_kor.mem_idx', $_idx)
            ->findAll();

        return $aCategory;
    }

    public function getRecIdxs(array $korIdx): array
    {
        $aRow = [];
        if (!$korIdx) {
            return $aRow;
        }

        $aRow = $this
            ->select('rec_idx')
            ->where([
                'mem_rec_type' => 'R',
                'delyn' => 'N',
            ])
            ->whereIn('kor_area_idx', $korIdx)
            ->findAll();

        return $aRow;
    }

    public function getKorRec(array $getKorIdxs): array
    {
        $aRow = [];
        if (!$getKorIdxs) {
            return $aRow;
        }

        $aRow = $this
            ->distinct()
            ->where([
                'mem_rec_type' => 'R',
                'delyn' => 'N'
            ])
            ->whereIn('kor_area_idx', $getKorIdxs)
            ->orderBy('rec_idx', 'random')
            // ->limit(3)
            ->findColumn('rec_idx');

        return $aRow ?? [];
    }

    public function getRecKor(int $iRecIdx): array
    {
        $aRow = [];
        if (!$iRecIdx) {
            return $aRow;
        }

        $aRow = $this
            ->where([
                'rec_idx' => $iRecIdx,
                'mem_rec_type' => 'R',
                'delyn' => 'N'
            ])
            ->findColumn('kor_area_idx');

        return $aRow ?? [];
    }
}
