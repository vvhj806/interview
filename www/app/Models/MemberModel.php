<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\DatabaseInterview;
use PDO;
use Config\Database;

class MemberModel extends Model
{
    public $masterDB;
    protected $table = ''; // 데이터베이스 테이블을 지정
    protected $primaryKey = ''; // 테이블에서 레코드를 고유하게 식별하는 열(column)의 이름
    protected $useAutoIncrement = true; // (auto-increment) 기능을 사용할지 여부
    protected $tempReturnType = 'array'; // 반환되는값 지정 array,object 
    protected $useSoftDeletes = false; // true 일경우 실제로 행을 삭제하는 대신 deleted_at 필드를 설정
    protected $allowedFields = []; //save, insert, update 메소드를 통하여 설정할 수 있는 필드 이름
    protected $useTimestamps = true; // INSERT 및 UPDATE에 자동으로 추가되는지 여부를 결정.
    protected $createdField = 'mem_reg_date'; // 데이터 레코드 작성 타임스탬프를 유지하기 위해 사용하는 데이터베이스 필드
    protected $updatedField = 'mem_mod_date'; // 데이터 레코드 업데이트 타임스탬프를 유지하기 위해 사용할 데이터베이스 필드
    protected $deletedField = 'mem_del_date'; // 데이터 레코드 삭제 타임스탬프를 유지하기 위해 사용할 데이터베이스 필드
    protected $validationRules = [
        'mem_id' => 'required|valid_email|is_unique[iv_member.mem_id]',
        'mem_password' => 'required|min_length[4]',
    ]; // 유효성 검사 규칙 배열
    protected $validationMessages = []; // 유효성 검증 중에 사용해야하는 사용자 정의 오류 메시지 배열
    protected $skipValidation = false; // 모든 inserts와 updates의 유효성 검사를 하지 않을지 여부 기본값은 false이며 데이터의 유효성 검사를 항상 시도.


    public function __construct()
    {
        parent::__construct();
        $code = 'iv_member';
        $this->table = $code;
        $this->fields = DatabaseInterview::$code();
        $this->masterDB = Database::connect('master');
        if (is_array($this->fields)) {
            foreach ($this->fields as $key => $row) {
                if (isset($row['auto_increment']) && $row['auto_increment'] === true) {
                    $this->primaryKey = $key;
                } else if (!in_array($key, ['mem_reg_date', 'mem_mod_date', 'mem_del_date'])) {
                    $this->allowedFields[] = $key;
                }
            }
        }
    }

    public function memberBaseCondition(): object
    {
        $objQuery = $this->where(['iv_member.delyn' => 'N']);
        return $objQuery;
    }

    public function checkMemberId(string $strId = ''): int
    {
        $iResult = 0;
        if ($strId == '') {
            return $iResult;
        }
        $iResult = $this->selectCount('0')
            ->where('mem_id', $strId)->countAllResults();
        return $iResult;
    }

    public function getList(string $range, string $type): array
    {
        $aResult = [];
        if (!$type) {
            return $aResult;
        }
        if ($range === 'all') {
            $aResult = $this
                ->where('mem_type', $type)
                ->where('delyn', 'N')
                ->orderBy('idx', 'desc')->findAll();
        } else {
            $aResult = $this
                ->where('mem_type', $type)
                ->where('delyn', 'N')
                ->orderBy('idx', 'desc')->first();
        }
        return $aResult ?? [];
    }

    public function getMember(string $strId = ''): array
    {
        $aResult = [];
        if ($strId == '') {
            return $aResult;
        }
        $aResult = $this
            ->where('mem_id', $strId)
            ->where('delyn', 'N')
            ->orderBy('idx', 'desc')->first();
        return $aResult ?? [];
    }

    public function getLeaveMember(string $strId = '')
    {
        $aResult = [];
        if ($strId == '') {
            return $aResult;
        }
        // $aResult = $this
        //     ->select('iv_member.*')
        //     ->join('iv_member_leave', 'iv_member_leave.mem_idx=iv_member.idx')
        //     ->where('iv_member.mem_id', $strId)
        //     ->orderBy('idx', 'desc')->first();
        $aResult = $this
            ->select('*')

            ->where('mem_id', $strId)
            ->where([
                'delyn' => 'Y',
            ])
            ->orderBy('idx', 'desc')->first();
        return $aResult ?? [];
    }

    public function getMemberLink(string $strId = ''): array
    {
        $aResult = [];
        if ($strId == '') {
            return $aResult;
        }
        $aResult = $this
            ->like('mem_id', $strId . '_', 'after')
            ->where('delyn', 'N')
            ->orderBy('idx', 'desc')->first();
        return $aResult ?? [];
    }

    public function getMember2(int $iMemIdx): array
    {
        $aResult = [];
        if ($iMemIdx == '') {
            return $aResult;
        }
        $aResult = $this
            ->where('idx', $iMemIdx)
            ->where('delyn', 'N')
            ->orderBy('idx', 'desc')->first();
        return $aResult ?? [];
    }

    public function getLastPasswordDate(string $strId = '', string $dateIn): array
    {
        //5분이내 이력확인
        $aResult = [];
        if ($strId == '') {
            return $aResult;
        }
        $readySQL = $this
            ->where([
                'mem_id' => $strId,
                'delyn' => 'N'
            ]);
        if ($dateIn) {
            $readySQL->where([
                'mem_last_password_date >' => $dateIn
            ]);
        }
        $aResult = $readySQL->orderBy('idx', 'desc')->first();
        return $aResult ?? [];
    }

    public function getMemberTel(string $strTel, string $type): array
    {
        $aResult = [];
        if (!$strTel || !$type || !in_array($type, ['M', 'C'])) {
            return $aResult;
        }
        $aResult = $this
            ->where([
                'mem_tel' => $strTel,
                'mem_type' => $type,
                'delyn' => 'N',
            ])
            ->orderBy('idx', 'desc')->first();
        return $aResult ?? [];
    }

    public function getLeaveMemberTel(string $strTel, string $type): array //회원탈퇴한 전화번호인지 확인
    {
        $aResult = [];
        if (!$strTel || !$type || !in_array($type, ['M', 'C'])) {
            return $aResult;
        }
        $aResult = $this
            ->where([
                'mem_tel' => $strTel,
                'mem_type' => $type,
                'delyn' => 'Y',
            ])
            ->orderBy('idx', 'desc')->first();
        return $aResult ?? [];
    }

    public function getLeaveMemberSnsKey(string $strKey, string $type): array //회원탈퇴한 sns key 인지 확인
    {
        $aResult = [];
        if (!$strKey || !$type || !in_array($type, ['M', 'C'])) {
            return $aResult;
        }
        $aResult = $this
            ->where([
                'mem_sns_key' => $strKey,
                'mem_type' => $type,
                'delyn' => 'Y',
            ])
            ->orderBy('idx', 'desc')->first();
        return $aResult ?? [];
    }

    /**
     * @brief 하이버프인터뷰1.0 유저 체크
     */
    public function getOldMember(string $strId = '', string $strPw = ''): array
    {
        $aResult = [];
        if ($strId == '' || $strPw == '') {
            return $aResult;
        }
        $strEscPw = $this->escape($strPw);
        $aResult = $this
            ->where('mem_id', $strId)
            ->where('delyn', 'N')
            ->where("mem_password = PASSWORD(${strEscPw})")
            ->orderBy('idx', 'desc')->first();
        return $aResult ?? [];
    }

    //마이페이지 정보 가져오기
    public function MypageMem(int $_idx)
    {
        $aMember = $this->select('*')
            ->where('idx', $_idx)
            ->where('delyn', 'N')
            ->first();

        return $aMember;
    }

    //온라인으로 체크한 라벨러
    public function builderLbStat(): object
    {
        $aResult = (object)[];

        $aResult = $this
            ->join('iv_labeler_stat', 'iv_member.idx = iv_labeler_stat.mem_idx', 'inner')
            ->where(['iv_labeler_stat.lab_stat' => 1]);

        return $aResult;
    }
    //라벨러 id
    public function builderLbCount(): object
    {
        $aResult = (object)[];

        $aResult = $this
            ->join('iv_labeler_count', 'iv_member.idx = iv_labeler_count.mem_idx AND iv_labeler_count.delyn = "N"', 'inner');

        return $aResult;
    }

    // strMemType => C || M : 기업||멤버
    // strDelyn => N || Y : 회원 || 탈퇴회원
    public function getMemCount(string $strMemType, string $strDelyn): array
    {
        $aResult = [];
        if (!in_array($strMemType, ['M', 'C']) || !in_array($strDelyn, ['N', 'Y'])) {
            return $aResult;
        }

        if ($strDelyn === 'N') {
            $strDateColumn = 'mem_reg_date';
        } else if ($strDelyn === 'Y') {
            $strDateColumn = 'mem_del_date';
        }

        $today = date('Y-m-d');
        $year = date('Y');
        $aResult = $this
            ->select("COUNT(*) AS alltime", '', false)
            ->select("COUNT(case when date({$strDateColumn}) = '{$today}' then 1 end) AS day", '', false)
            ->select("COUNT(case when year({$strDateColumn}) = '{$year}' AND week({$strDateColumn}) = week('{$today}') then 1 end) AS week", '', false)
            ->select("COUNT(case when year({$strDateColumn}) = '{$year}' AND month({$strDateColumn}) = month('{$today}') then 1 end) AS month", '', false)
            ->where(['mem_type' => $strMemType, 'delyn' => $strDelyn])->first();
        return $aResult;
    }

    //로그인 실패 로그 확인
    public function getFailLog(string $strId = '')
    {
        $aFail = [];
        if ($strId == '') {
            return $aFail;
        }
        $time = date("Y-m-d H:i:s");
        $time = date("Y-m-d H:i:s", strtotime("-5 minutes", strtotime($time)));

        $aFail = $this
            ->select("COUNT(*) as failcount")
            ->join('log_member_login', 'log_member_login.mem_idx=iv_member.idx', 'left')
            ->where([
                'iv_member.mem_id' => $strId,
                'log_member_login.login_status' => 'login',
                'log_member_login.login_result' => 'F',
                'log_member_login.log_reg_date >=' => $time
            ])
            ->findAll();

        return $aFail;
    }

    //로그아웃 했는지 안했는지(세션이 활성화 되어있는지) 확인
    public function getLogStatus(string $strId = '')
    {
        $aFail = [];
        if ($strId == '') {
            return $aFail;
        }

        $aFail = $this
            ->select("log_member_login.*")
            ->join('log_member_login', 'log_member_login.mem_idx=iv_member.idx', 'left')
            ->where([
                'iv_member.mem_id' => $strId,
            ])
            ->orderBy('log_member_login.idx', 'desc')
            ->first();

        return $aFail;
    }

    public function updateLastPasswordDate(int $memberIdx, string $nextMonth): bool
    {
        $result = false;
        if ($memberIdx) {
            $masterDB = \Config\Database::connect('master');
            $result = $masterDB->table('iv_member')
                ->set(['mem_next_password_date' => $nextMonth])
                ->set(['mem_mod_date' => 'NOW()'], '', false)
                ->where(['idx' => $memberIdx])
                ->update();

            $masterDB->close();
        }

        return $result;
    }

    public function company_member1($comIdx, $sugTel): array
    {
        $aResult = [];
        if ($comIdx == '') {
            return $aResult;
        }

        $aResult = $this
            ->select("mem_id")
            ->where([
                'com_idx' => $comIdx,
                'mem_tel' => $sugTel
            ])
            ->limit(1)
            ->first();

        return $aResult;
    }

    //admin 에 menu idx 를 가져오는 함수
    public function getMenuIdx(int $memberIdx)
    {
        if (!$memberIdx) {
            return [];
        }

        $aResult = $this
            ->select('set_admin_rule.menu_idx')
            ->join('set_admin_rule', 'iv_member.mem_type = set_admin_rule.type and iv_member.mem_level = set_admin_rule.level', 'left')
            ->where([
                'iv_member.idx' => $memberIdx
            ])
            ->first();

        return $aResult;
    }

    private function getMemberInfo(): object
    {
        $aResult = $this
            ->where('delyn', 'N')
            ->orderBy('idx', 'desc');

        return $aResult;
    }

    public function getMemberList($str = '', $type = ''): array
    {

        $aResult = $this->getMemberInfo();

        if ($str != '') {
            $aResult = $aResult
                ->like('mem_id', $str, 'both')
                ->orLike('mem_name', $str, 'both')
                ->orLike('mem_tel', $str, 'both');
        }

        if ($type == 'push') {
            $aResult = $aResult
                ->where([
                    'mem_token IS NOT NULL' => NULL
                ]);
        }

        $aResult = $aResult->findAll();

        return $aResult ?? [];
    }

    public function getMemberAuthInfo(string $searchTxt) //관리자쪽에 아이디 권한 설정 페이지에서 사용
    {
        if (!$searchTxt) {
            return [];
        }

        $result = $this->select('idx, mem_type, mem_level, mem_id, mem_name, mem_tel, mem_reg_date')
            ->like('mem_id', $searchTxt, 'both')
            ->orLike('mem_name', $searchTxt, 'both')
            ->orLike('mem_tel', $searchTxt, 'both')
            ->findAll();

        return $result ?? [];
    }

    public function updateMemberAuth(array $getMemIdxAuth) //아이디 권한 변경 update
    {
        if (!$getMemIdxAuth) {
            return false;
        }

        foreach ($getMemIdxAuth as $key => $val) {
            $result =  $this->masterDB->table('iv_member')
                ->set([
                    'mem_type' => $val['type'],
                    'mem_level' => $val['level'],
                ])
                ->where([
                    'idx' => $val['idx'],
                ])
                ->set(['mem_mod_date' => 'NOW()'], '', false)
                ->update();
        }

        return $result;
    }
}
