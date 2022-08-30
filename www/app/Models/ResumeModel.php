<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\DatabaseInterview;

class ResumeModel extends Model
{
    protected $table = ''; // 데이터베이스 테이블을 지정
    protected $primaryKey = ''; // 테이블에서 레코드를 고유하게 식별하는 열(column)의 이름
    protected $useAutoIncrement = true; // (auto-increment) 기능을 사용할지 여부
    protected $tempReturnType = 'array'; // 반환되는값 지정 array,object 
    protected $useSoftDeletes = false; // true 일경우 실제로 행을 삭제하는 대신 deleted_at 필드를 설정
    protected $allowedFields = []; //save, insert, update 메소드를 통하여 설정할 수 있는 필드 이름
    protected $useTimestamps = true; // INSERT 및 UPDATE에 자동으로 추가되는지 여부를 결정.
    protected $createdField = 'res_reg_date'; // 데이터 레코드 작성 타임스탬프를 유지하기 위해 사용하는 데이터베이스 필드
    protected $updatedField = 'res_mod_date'; // 데이터 레코드 업데이트 타임스탬프를 유지하기 위해 사용할 데이터베이스 필드
    protected $deletedField = 'res_del_date'; // 데이터 레코드 삭제 타임스탬프를 유지하기 위해 사용할 데이터베이스 필드
    protected $validationRules = []; // 유효성 검사 규칙 배열
    protected $validationMessages = []; // 유효성 검증 중에 사용해야하는 사용자 정의 오류 메시지 배열
    protected $skipValidation = false; // 모든 inserts와 updates의 유효성 검사를 하지 않을지 여부 기본값은 false이며 데이터의 유효성 검사를 항상 시도.


    public function __construct()
    {
        parent::__construct();
        $code = 'iv_resume';
        $this->table = $code;
        $this->fields = DatabaseInterview::$code();
        if (is_array($this->fields)) {
            foreach ($this->fields as $key => $row) {
                if (isset($row['auto_increment']) && $row['auto_increment'] === true) {
                    $this->primaryKey = $key;
                } else if (!in_array($key, ['res_reg_date', 'res_mod_date', 'res_del_date'])) {
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

    public function applyResume($id): array
    {
        $aRow = [];
        if (!$id) {
            return $aRow;
        }

        $aRow = $this
            ->select('idx, res_title, res_reg_date')
            ->where('mem_idx', $id)
            ->orderBy('idx', 'DESC')
            ->first();

        if ($aRow == "" || $aRow == null) {
            $aRow = [];
        }

        // print_r($aRow);
        // exit;

        return $aRow;
    }

    public function getResumeList($memIdx): array
    {
        $aRow = [];
        if (!$memIdx) {
            return $aRow;
        }

        $aRow = $this
            ->select('idx, res_title, res_jobportal, res_reg_date')
            ->where([
                'mem_idx' => $memIdx,
                'delyn' => 'N',
            ])
            ->orderBy('idx', 'desc')
            ->findAll();

        return $aRow;
    }

    public function getResume($rIdx, $rType = 'modify'): array
    {
        $aRow = [];
        if (!$rIdx) {
            return $aRow;
        }
        switch ($rType) {
            case 'modify': //이력서 - 사용안함
                $aRow = $this
                    ->select('iv_resume.idx, iv_resume.res_title, iv_resume.file_idx_profile, iv_resume.res_intro_contents, iv_resume.res_reg_date,
                    iv_file.file_org_name, iv_file.file_save_name')
                    ->join('iv_file', 'iv_resume.file_idx_profile = iv_file.idx', 'left')
                    ->where([
                        'iv_resume.idx' => $rIdx,
                        'iv_resume.delyn' => 'N'
                    ])
                    ->first();
                break;
            case 'base': //이력서 기본 프로필
                $aRow = $this
                    ->select('iv_resume.idx, iv_resume.res_title, iv_resume.file_idx_profile, iv_resume.res_birth, iv_resume.res_name, iv_resume.res_tel, iv_resume.res_email,
                    iv_resume.res_gender, iv_resume.res_bohun_yn, iv_resume.res_military_type, iv_resume.res_military_start_date, 
                    iv_resume.res_military_end_date, iv_resume.res_address, iv_resume.res_address_postcode, iv_resume.res_address_detail, 
                    iv_resume.res_career_profile, iv_resume.res_intro_contents, iv_resume.res_reg_date, iv_file.file_org_name, iv_file.file_save_name, iv_file.file_size')
                    ->join('iv_file', 'iv_resume.file_idx_profile = iv_file.idx', 'left')
                    ->where([
                        'iv_resume.idx' => $rIdx,
                        'iv_resume.delyn' => 'N'
                    ])
                    ->first();
                break;
            case 'interest': //관심직무
                $aRow = $this
                    ->select('irc.idx, ijc.job_depth_text, irc.job_idx')
                    ->join('iv_resume_category irc', 'iv_resume.idx = irc.res_idx', 'left')
                    ->join('iv_job_category ijc', 'irc.job_idx = ijc.idx', 'left')
                    ->where([
                        'irc.res_idx' => $rIdx,
                        'irc.delyn' => 'N'
                    ])
                    ->findAll();
                break;
            case 'education': //학력 
                $aRow = $this
                    ->select('ire.idx, ire.res_edu_school, ire.res_edu_score, ire.res_edu_tscore, ire.res_edu_department, ire.res_edu_admission, 
                    ire.res_edu_graduate, ire.res_edu_school_type, ire.res_edu_graduate_type')
                    ->join('iv_resume_education ire', 'iv_resume.idx = ire.res_idx', 'left')
                    ->where([
                        'ire.res_idx' => $rIdx,
                        'ire.delyn' => 'N'
                    ])
                    ->findAll();
                break;
            case 'career': //경력
                $aRow = $this
                    ->select('irc.idx, irc.res_career_company_name, irc.res_career_join_date, irc.res_career_leave_date, irc.res_career_dept, irc.res_career_contents, irc.res_career_pay')
                    ->join('iv_resume_career irc', 'iv_resume.idx = irc.res_idx', 'left')
                    ->where([
                        'irc.res_idx' => $rIdx,
                        'irc.delyn' => 'N'
                    ])
                    ->findAll();
                break;
                break;
            case 'language': //외국어 
                $aRow = $this
                    ->select('irl.idx, irl.res_language_name, irl.res_language_score, irl.res_language_level, irl.res_language_obtain_date')
                    ->join('iv_resume_language irl', 'iv_resume.idx = irl.res_idx', 'left')
                    ->where([
                        'irl.res_idx' => $rIdx,
                        'irl.delyn' => 'N'
                    ])
                    ->findAll();
                break;
            case 'license': //자격증 
                $aRow = $this
                    ->select('irl.idx, irl.res_license_name, irl.res_license_public_org, irl.res_license_level, irl.res_license_obtain_date')
                    ->join('iv_resume_license irl', 'iv_resume.idx = irl.res_idx', 'left')
                    ->where([
                        'irl.res_idx' => $rIdx,
                        'irl.delyn' => 'N'
                    ])
                    ->findAll();
                break;
            case 'activity': //기타활동 
                $aRow = $this
                    ->select('ira.idx, ira.res_activity_name, ira.res_activity_score, ira.res_activity_start_date, ira.res_activity_end_date')
                    ->join('iv_resume_activity ira', 'iv_resume.idx = ira.res_idx', 'left')
                    ->where([
                        'ira.res_idx' => $rIdx,
                        'ira.delyn' => 'N'
                    ])
                    ->findAll();
                break;
            case 'portfolio': //첨부파일
                $aRow = $this
                    ->select('irp.idx, irp.file_idx, ivf.file_org_name, ivf.file_save_name, ivf.file_size')
                    ->join('iv_resume_portfolio irp', 'iv_resume.idx = irp.res_idx', 'left')
                    ->join('iv_file ivf', 'irp.file_idx = ivf.idx', 'left')
                    ->where([
                        'irp.res_idx' => $rIdx,
                        'irp.delyn' => 'N'
                    ])
                    ->findAll();
                break;
        }

        return $aRow;
    }

    public function jobportalResume($memIdx, $rData)
    {
        $aRow = [];
        if (!$memIdx) {
            return $aRow;
        }

        // $masterDB
        $masterDB = \Config\Database::connect('master');
        //트랜잭션 start
        $masterDB->transBegin();

        $masterDB->table('iv_resume')
            ->set([
                'mem_idx' => $memIdx,
                'file_idx_profile' => 0 ?? '',
                'res_title' => '취업 사이트 이력서' ?? '',
                'res_jobportal' => $rData['jobportal'] . '/0' ?? '',
            ])
            ->set(['res_reg_date' => 'NOW()'], '', false)
            ->set(['res_mod_date' => 'NOW()'], '', false)
            ->insert();

        // 트랜잭션 end
        if ($masterDB->transStatus() === false) {
            $masterDB->transRollback();
        } else {
            $masterDB->transCommit();
        }

        $masterDB->close();
    }

    public function setResume($memIdx, $rIdx, $rData): int
    {
        $aRow = [];
        if (!$memIdx) {
            return $aRow;
        }

        // $masterDB
        $masterDB = \Config\Database::connect('master');
        //트랜잭션 start
        $masterDB->transBegin();

        if ($rIdx == 0) { //신규작성 insert
            //Base
            if (!empty($rData['base']['profileFile'])) {
                if (!empty($rData['base']['fileIdx'])) {
                    $fileBaseIdx = $rData['base']['fileIdx'];
                } else {
                    $masterDB->table('iv_file')
                        ->set([
                            'file_type' => 'R',
                            'file_org_name' => $rData['base']['profileFile'],
                            'file_save_name' => $rData['base']['file_save_name'],
                            'file_size' => $rData['base']['fileSize'],
                        ])
                        ->set(['file_reg_date' => 'NOW()'], '', false)
                        ->set(['file_mod_date' => 'NOW()'], '', false)
                        ->insert();

                    $fileBaseIdx = $masterDB->insertID();
                }
            }
            $masterDB->table('iv_resume')
                ->set([
                    'mem_idx' => $memIdx,
                    'file_idx_profile' => $fileBaseIdx ?? '',
                    'res_title' => $rData['base']['res_title'] ?? '',
                    'res_birth' => $rData['base']['bBirth'] ?? '',
                    'res_name' => $rData['base']['bName'] ?? '',
                    'res_tel' => $rData['base']['bTel'] ?? '',
                    'res_email' => $rData['base']['bEmail'] ?? '',
                    'res_gender' => $rData['base']['bGender'] ?? '',
                    'res_bohun_yn' => $rData['base']['bBohun'] ?? '',
                    'res_military_type' => $rData['base']['bMilitaryType'] ?? '',
                    'res_military_start_date' => $rData['base']['bMilitaryStartDate'] ?? '',
                    'res_military_end_date' => $rData['base']['bMilitaryEndDate'] ?? '',
                    'res_address' => $rData['base']['input_address'] ?? '',
                    'res_address_postcode' => $rData['base']['input_postcode'] ?? '',
                    'res_address_detail' => $rData['base']['input_detailAddress'] ?? '',
                    'res_career_profile' => $rData['base']['careerProfile'] ?? '',
                    'res_intro_contents' => $rData['base']['rIntro_contents'] ?? '',
                ])
                ->set(['res_reg_date' => 'NOW()'], '', false)
                ->set(['res_mod_date' => 'NOW()'], '', false)
                ->insert();
            $resumeIdx = $masterDB->insertID();
            //interest
            if (!empty($rData['interest'])) {
                foreach ($rData['interest'] as $key => $val) {
                    $masterDB->table('iv_resume_category')
                        ->set([
                            'res_idx' => $resumeIdx,
                            'job_idx' => $val,
                        ])
                        ->set(['res_interest_reg_date' => 'NOW()'], '', false)
                        ->set(['res_interest_mod_date' => 'NOW()'], '', false)
                        ->insert();
                }
            }
            //education
            if (!empty($rData['education'])) {
                foreach ($rData['education'] as $key => $val) {
                    $masterDB->table('iv_resume_education')
                        ->set([
                            'res_idx' => $resumeIdx,
                            'res_edu_school' => $rData['education'][$key]['eName'] ?? '',
                            'res_edu_score' => $rData['education'][$key]['score'] ?? '',
                            'res_edu_tscore' => $rData['education'][$key]['tscore'] ?? '',
                            'res_edu_department' => $rData['education'][$key]['cName'] ?? '',
                            'res_edu_admission' => $rData['education'][$key]['sYearMonth'] ?? '',
                            'res_edu_graduate' => $rData['education'][$key]['eYearMonth'] ?? '',
                            'res_edu_school_type' => $rData['education'][$key]['eSchoolType'] ?? '',
                            'res_edu_graduate_type' => $rData['education'][$key]['eGradType'] ?? '',
                        ])
                        ->set(['res_edu_reg_date' => 'NOW()'], '', false)
                        ->set(['res_edu_mod_date' => 'NOW()'], '', false)
                        ->insert();
                }
            }
            //career
            if (!empty($rData['career'])) {
                foreach ($rData['career'] as $key => $val) {
                    $masterDB->table('iv_resume_career')
                        ->set([
                            'res_idx' => $resumeIdx,
                            'res_career_company_name' => $rData['career'][$key]['cName'] ?? '',
                            'res_career_join_date' => $rData['career'][$key]['sDate'] ?? '',
                            'res_career_leave_date' => $rData['career'][$key]['eDate'] ?? '',
                            'res_career_dept' => $rData['career'][$key]['depName'] ?? '',
                            'res_career_contents' => $rData['career'][$key]['business'] ?? '',
                            'res_career_pay' => $rData['career'][$key]['cpay'] ?? '',
                        ])
                        ->set(['res_career_reg_date' => 'NOW()'], '', false)
                        ->set(['res_career_mod_date' => 'NOW()'], '', false)
                        ->insert();
                }
            }
            //language
            if (!empty($rData['language'])) {
                foreach ($rData['language'] as $key => $val) {
                    $masterDB->table('iv_resume_language')
                        ->set([
                            'res_idx' => $resumeIdx,
                            'res_language_name' => $rData['language'][$key]['lName'] ?? '',
                            'res_language_score' => $rData['language'][$key]['lScore'] ?? '',
                            'res_language_level' => $rData['language'][$key]['lLever'] ?? '',
                            'res_language_obtain_date' => $rData['language'][$key]['lObtainDate'] ?? '',
                        ])
                        ->set(['res_language_reg_date' => 'NOW()'], '', false)
                        ->set(['res_language_mod_date' => 'NOW()'], '', false)
                        ->insert();
                }
            }
            //license
            if (!empty($rData['license'])) {
                foreach ($rData['license'] as $key => $val) {
                    $masterDB->table('iv_resume_license')
                        ->set([
                            'res_idx' => $resumeIdx,
                            'res_license_name' => $rData['license'][$key]['lName'] ?? '',
                            'res_license_public_org' => $rData['license'][$key]['lPublicOrg'] ?? '',
                            'res_license_level' => $rData['license'][$key]['lLevel'] ?? '',
                            'res_license_obtain_date' => $rData['license'][$key]['lObtainDate'] ?? '',
                        ])
                        ->set(['res_license_reg_date' => 'NOW()'], '', false)
                        ->set(['res_license_mod_date' => 'NOW()'], '', false)
                        ->insert();
                }
            }
            //activity
            if (!empty($rData['activity'])) {
                foreach ($rData['activity'] as $key => $val) {
                    $masterDB->table('iv_resume_activity')
                        ->set([
                            'res_idx' => $resumeIdx,
                            'res_activity_name' => $rData['activity'][$key]['actName'] ?? '',
                            'res_activity_score' => $rData['activity'][$key]['detail'] ?? '',
                            'res_activity_start_date' => $rData['activity'][$key]['aStartDate'] ?? '',
                            'res_activity_end_date' => $rData['activity'][$key]['aEndDate'] ?? '',
                        ])
                        ->set(['res_activity_reg_date' => 'NOW()'], '', false)
                        ->set(['res_activity_mod_date' => 'NOW()'], '', false)
                        ->insert();
                }
            }
            //rPortfolio
            if (!empty($rData['rPortfolio'])) {

                foreach ($rData['rPortfolio'] as $key => $val) {

                    $masterDB->table('iv_file')
                        ->set([
                            'file_type' => 'P',
                            'file_org_name' => $rData['rPortfolio'][$key]['file_save_name'],
                            'file_save_name' => $rData['rPortfolio'][$key]['profileFile'],
                            'file_size' => $rData['rPortfolio'][$key]['fileSize'],
                        ])
                        ->set(['file_reg_date' => 'NOW()'], '', false)
                        ->set(['file_mod_date' => 'NOW()'], '', false)
                        ->insert();

                    $filePortflioIdx = $masterDB->insertID();

                    $masterDB->table('iv_resume_portfolio')
                        ->set([
                            'res_idx' => $resumeIdx,
                            'file_idx' => $filePortflioIdx,
                            'res_portfolio_type' => 'F',
                        ])
                        ->set(['res_portfolio_reg_date' => 'NOW()'], '', false)
                        ->set(['res_portfolio_mod_date' => 'NOW()'], '', false)
                        ->insert();
                }
            }
        } else { //기존 정보 update, 추가 정보 insert, 없어진 정보 delyn = n
            //Base
            $baseRow = $this->getResume($rIdx, 'base');
            if (!empty($rData['base']['file_save_name'])) {
                if (!empty($rData['base']['fileIdx'])) {
                    $fileBaseIdx = $rData['base']['fileIdx'];
                    $masterDB->table('iv_file')
                        ->set([
                            'file_org_name' => $rData['base']['profileFile'],
                            'file_save_name' => $rData['base']['file_save_name'],
                            'file_size' => $rData['base']['fileSize'],
                        ])
                        ->set(['file_mod_date' => 'NOW()'], '', false)
                        ->where('idx', $rData['base']['fileIdx'])
                        ->update();
                } else {
                    if ($rData['base']['file_save_name'] != $baseRow['file_save_name']) {
                        if (!empty($rData['base']['fileIdx'])) {
                            $masterDB->table('iv_file')
                                ->set([
                                    'file_org_name' => $rData['base']['profileFile'],
                                    'file_save_name' => $rData['base']['file_save_name'],
                                    'file_size' => $rData['base']['fileSize'],
                                ])
                                ->set(['file_mod_date' => 'NOW()'], '', false)
                                ->where('idx', $baseRow['file_idx_profile'])
                                ->update();
                            $fileBaseIdx = $baseRow['file_idx_profile'];
                        } else {
                            $masterDB->table('iv_file')
                                ->set([
                                    'file_type' => 'R',
                                    'file_org_name' => $rData['base']['profileFile'],
                                    'file_save_name' => $rData['base']['file_save_name'],
                                    'file_size' => $rData['base']['fileSize'],
                                ])
                                ->set(['file_reg_date' => 'NOW()'], '', false)
                                ->set(['file_mod_date' => 'NOW()'], '', false)
                                ->insert();

                            $fileBaseIdx = $masterDB->insertID();
                        }
                    }
                }
            }

            $masterDB->table('iv_resume')
                ->set([
                    'file_idx_profile' => $fileBaseIdx ?? '',
                    'res_title' => $rData['base']['res_title'] ?? '',
                    'res_birth' => $rData['base']['bBirth'] ?? '',
                    'res_name' => $rData['base']['bName'] ?? '',
                    'res_tel' => $rData['base']['bTel'] ?? '',
                    'res_email' => $rData['base']['bEmail'] ?? '',
                    'res_gender' => $rData['base']['bGender'] ?? '',
                    'res_bohun_yn' => $rData['base']['bBohun'] ?? '',
                    'res_military_type' => $rData['base']['bMilitaryType'] ?? '',
                    'res_military_start_date' => $rData['base']['bMilitaryStartDate'] ?? '',
                    'res_military_end_date' => $rData['base']['bMilitaryEndDate'] ?? '',
                    'res_address' => $rData['base']['input_address'] ?? '',
                    'res_address_postcode' => $rData['base']['input_postcode'] ?? '',
                    'res_address_detail' => $rData['base']['input_detailAddress'] ?? '',
                    'res_career_profile' => $rData['base']['careerProfile'] ?? '',
                    'res_intro_contents' => $rData['base']['rIntro_contents'] ?? '',
                ])
                ->set(['res_mod_date' => 'NOW()'], '', false)
                ->where('idx', $rIdx)
                ->update();
            //interest
            if (!empty($rData['interest'])) {
                $interestRow = [];
                $interestRow = $this->getResume($rIdx, 'interest');
                $rowCnt = count($interestRow);
                $rDataCnt = count($rData['interest']);

                if ($rowCnt == $rDataCnt) { //기존 데이터와 같을 때 update
                    $iCnt = 0;


                    foreach ($rData['interest'] as $key => $val) {

                        $masterDB->table('iv_resume_category')
                            ->set([
                                'job_idx' => $val,
                                'delyn' => 'N',
                            ])
                            ->set(['res_interest_mod_date' => 'NOW()'], '', false)
                            ->where([
                                'idx' => $interestRow[$iCnt]['idx'],
                                'res_idx' => $rIdx,
                            ])
                            ->update();
                        $iCnt++;
                    }
                } else if ($rowCnt < $rDataCnt) { //신규 데이터가 있을때 update insert
                    $rDcnt = 0;
                    $rRcnt = 0;
                    foreach ($rData['interest'] as $key => $val) {

                        if ($rDcnt < $rowCnt && $rowCnt != 0) {
                            if (isset($interestRow[$rRcnt]['idx'])) {

                                $masterDB->table('iv_resume_category')
                                    ->set([
                                        'job_idx' => $val,
                                        'delyn' => 'N',
                                    ])
                                    ->set(['res_interest_mod_date' => 'NOW()'], '', false)
                                    ->where([
                                        'idx' => $interestRow[$rRcnt]['idx'],
                                        'res_idx' => $rIdx,
                                    ])
                                    ->update();
                                $rRcnt++;
                            }
                        } else {

                            $masterDB->table('iv_resume_category')
                                ->set([
                                    'res_idx' => $rIdx,
                                    'job_idx' => $val,
                                    'delyn' => 'N',
                                ])
                                ->set(['res_interest_reg_date' => 'NOW()'], '', false)
                                ->set(['res_interest_mod_date' => 'NOW()'], '', false)
                                ->insert();
                        }
                        $rDcnt++;
                    }
                } else { //기존 데이터가 지워젔을 때 update delyn = n
                    $rUpDcnt = 0;
                    $rUpcnt = 0;
                    foreach ($interestRow as $key => $val) {
                        if ($key < $rDataCnt && $rowCnt != 0) {
                            if (isset($interestRow[$rUpcnt]['idx'])) {

                                $masterDB->table('iv_resume_category')
                                    ->set([
                                        'job_idx' => array_values($rData['interest'])[$key],
                                        'delyn' => 'N',
                                    ])
                                    ->set(['res_interest_mod_date' => 'NOW()'], '', false)
                                    ->where([
                                        'idx' => $interestRow[$rUpcnt]['idx'],
                                        'res_idx' => $rIdx,
                                    ])
                                    ->update();
                                $rUpcnt++;
                            }
                        } else {
                            if (isset($interestRow[$rUpDcnt]['idx'])) {
                                $masterDB->table('iv_resume_category')
                                    ->set([
                                        'delyn' => 'Y',
                                    ])
                                    ->set(['res_interest_del_date' => 'NOW()'], '', false)
                                    ->where([
                                        'idx' => $interestRow[$rUpDcnt]['idx'],
                                        'res_idx' => $rIdx,
                                    ])
                                    ->update();
                                $rUpDcnt++;
                            }
                        }
                    }
                }
            }
            //education
            if (!empty($rData['education'])) {
                $educationRow = $this->getResume($rIdx, 'education');
                $rowCnt = count($educationRow);
                $rDataCnt = count($rData['education']);

                if ($rowCnt == $rDataCnt) { //기존 데이터와 같을 때 update
                    foreach ($rData['education'] as $key => $val) {
                        $masterDB->table('iv_resume_education')
                            ->set([
                                'res_edu_school' => $rData['education'][$key]['eName'] ?? '',
                                'res_edu_score' => $rData['education'][$key]['score'] ?? '',
                                'res_edu_tscore' => $rData['education'][$key]['tscore'] ?? '',
                                'res_edu_department' => $rData['education'][$key]['cName'] ?? '',
                                'res_edu_admission' => $rData['education'][$key]['sYearMonth'] ?? '',
                                'res_edu_graduate' => $rData['education'][$key]['eYearMonth'] ?? '',
                                'res_edu_school_type' => $rData['education'][$key]['eSchoolType'] ?? '',
                                'res_edu_graduate_type' => $rData['education'][$key]['eGradType'] ?? '',
                                'delyn' => 'N',
                            ])
                            ->set(['res_edu_mod_date' => 'NOW()'], '', false)
                            ->where([
                                'idx' => $educationRow[$key]['idx'],
                                'res_idx' => $rIdx,
                            ])
                            ->update();
                    }
                } else if ($rowCnt < $rDataCnt) { //신규 데이터가 있을때 update insert
                    foreach ($rData['education'] as $key => $val) {
                        if ($key < $rowCnt && $rowCnt != 0) {
                            $masterDB->table('iv_resume_education')
                                ->set([
                                    'res_edu_school' => $rData['education'][$key]['eName'] ?? '',
                                    'res_edu_score' => $rData['education'][$key]['score'] ?? '',
                                    'res_edu_tscore' => $rData['education'][$key]['tscore'] ?? '',
                                    'res_edu_department' => $rData['education'][$key]['cName'] ?? '',
                                    'res_edu_admission' => $rData['education'][$key]['sYearMonth'] ?? '',
                                    'res_edu_graduate' => $rData['education'][$key]['eYearMonth'] ?? '',
                                    'res_edu_school_type' => $rData['education'][$key]['eSchoolType'] ?? '',
                                    'res_edu_graduate_type' => $rData['education'][$key]['eGradType'] ?? '',
                                    'delyn' => 'N',
                                ])
                                ->set(['res_edu_mod_date' => 'NOW()'], '', false)
                                ->where([
                                    'idx' => $educationRow[$key]['idx'],
                                    'res_idx' => $rIdx,
                                ])
                                ->update();
                        } else {
                            $masterDB->table('iv_resume_education')
                                ->set([
                                    'res_idx' => $rIdx,
                                    'res_edu_school' => $rData['education'][$key]['eName'] ?? '',
                                    'res_edu_score' => $rData['education'][$key]['score'] ?? '',
                                    'res_edu_tscore' => $rData['education'][$key]['tscore'] ?? '',
                                    'res_edu_department' => $rData['education'][$key]['cName'] ?? '',
                                    'res_edu_admission' => $rData['education'][$key]['sYearMonth'] ?? '',
                                    'res_edu_graduate' => $rData['education'][$key]['eYearMonth'] ?? '',
                                    'res_edu_school_type' => $rData['education'][$key]['eSchoolType'] ?? '',
                                    'res_edu_graduate_type' => $rData['education'][$key]['eGradType'] ?? '',
                                    'delyn' => 'N',
                                ])
                                ->set(['res_edu_reg_date' => 'NOW()'], '', false)
                                ->set(['res_edu_mod_date' => 'NOW()'], '', false)
                                ->insert();
                        }
                    }
                } else { //기존 데이터가 지워젔을 때 update delyn = n
                    foreach ($educationRow as $key => $val) {
                        if ($key < $rDataCnt && $rDataCnt != 0) {
                            $masterDB->table('iv_resume_education')
                                ->set([
                                    'res_edu_school' => $rData['education'][$key]['eName'] ?? '',
                                    'res_edu_score' => $rData['education'][$key]['score'] ?? '',
                                    'res_edu_tscore' => $rData['education'][$key]['tscore'] ?? '',
                                    'res_edu_department' => $rData['education'][$key]['cName'] ?? '',
                                    'res_edu_admission' => $rData['education'][$key]['sYearMonth'] ?? '',
                                    'res_edu_graduate' => $rData['education'][$key]['eYearMonth'] ?? '',
                                    'res_edu_school_type' => $rData['education'][$key]['eSchoolType'] ?? '',
                                    'res_edu_graduate_type' => $rData['education'][$key]['eGradType'] ?? '',
                                    'delyn' => 'N',
                                ])
                                ->set(['res_edu_mod_date' => 'NOW()'], '', false)
                                ->where([
                                    'idx' => $educationRow[$key]['idx'],
                                    'res_idx' => $rIdx,
                                ])
                                ->update();
                        } else {
                            $masterDB->table('iv_resume_education')
                                ->set([
                                    'delyn' => 'Y',
                                ])
                                ->set(['res_edu_del_date' => 'NOW()'], '', false)
                                ->where([
                                    'idx' => $educationRow[$key]['idx'],
                                    'res_idx' => $rIdx,
                                ])
                                ->update();
                        }
                    }
                }
            }
            //career
            if (!empty($rData['career'])) {
                $careerRow = $this->getResume($rIdx, 'career');
                $rowCnt = count($careerRow);
                $rDataCnt = count($rData['career']);

                if ($rowCnt == $rDataCnt) { //기존 데이터와 같을 때 update
                    foreach ($rData['career'] as $key => $val) {
                        $masterDB->table('iv_resume_career')
                            ->set([
                                'res_career_company_name' => $rData['career'][$key]['cName'] ?? '',
                                'res_career_join_date' => $rData['career'][$key]['sDate'] ?? '',
                                'res_career_leave_date' => $rData['career'][$key]['eDate'] ?? '',
                                'res_career_dept' => $rData['career'][$key]['depName'] ?? '',
                                'res_career_contents' => $rData['career'][$key]['business'] ?? '',
                                'res_career_pay' => $rData['career'][$key]['cpay'] ?? '',
                                'delyn' => 'N',
                            ])
                            ->set(['res_career_mod_date' => 'NOW()'], '', false)
                            ->where([
                                'idx' => $careerRow[$key]['idx'],
                                'res_idx' => $rIdx,
                            ])
                            ->update();
                    }
                } else if ($rowCnt < $rDataCnt) { //신규 데이터가 있을때 update insert
                    foreach ($rData['career'] as $key => $val) {
                        if ($key < $rowCnt && $rowCnt != 0) {
                            $masterDB->table('iv_resume_career')
                                ->set([
                                    'res_career_company_name' => $rData['career'][$key]['cName'] ?? '',
                                    'res_career_join_date' => $rData['career'][$key]['sDate'] ?? '',
                                    'res_career_leave_date' => $rData['career'][$key]['eDate'] ?? '',
                                    'res_career_dept' => $rData['career'][$key]['depName'] ?? '',
                                    'res_career_contents' => $rData['career'][$key]['business'] ?? '',
                                    'res_career_pay' => $rData['career'][$key]['cpay'] ?? '',
                                    'delyn' => 'N',
                                ])
                                ->set(['res_career_mod_date' => 'NOW()'], '', false)
                                ->where([
                                    'idx' => $careerRow[$key]['idx'],
                                    'res_idx' => $rIdx,
                                ])
                                ->update();
                        } else {
                            $masterDB->table('iv_resume_career')
                                ->set([
                                    'res_idx' => $rIdx,
                                    'res_career_company_name' => $rData['career'][$key]['cName'] ?? '',
                                    'res_career_join_date' => $rData['career'][$key]['sDate'] ?? '',
                                    'res_career_leave_date' => $rData['career'][$key]['eDate'] ?? '',
                                    'res_career_dept' => $rData['career'][$key]['depName'] ?? '',
                                    'res_career_contents' => $rData['career'][$key]['business'] ?? '',
                                    'res_career_pay' => $rData['career'][$key]['cpay'] ?? '',
                                    'delyn' => 'N',
                                ])
                                ->set(['res_career_reg_date' => 'NOW()'], '', false)
                                ->set(['res_career_mod_date' => 'NOW()'], '', false)
                                ->insert();
                        }
                    }
                } else { //기존 데이터가 지워젔을 때 update delyn = n
                    foreach ($careerRow as $key => $val) {
                        if ($key < $rDataCnt && $rDataCnt != 0) {
                            $masterDB->table('iv_resume_career')
                                ->set([
                                    'res_career_company_name' => $rData['career'][$key]['cName'] ?? '',
                                    'res_career_join_date' => $rData['career'][$key]['sDate'] ?? '',
                                    'res_career_leave_date' => $rData['career'][$key]['eDate'] ?? '',
                                    'res_career_dept' => $rData['career'][$key]['depName'] ?? '',
                                    'res_career_contents' => $rData['career'][$key]['business'] ?? '',
                                    'res_career_pay' => $rData['career'][$key]['cpay'] ?? '',
                                    'delyn' => 'N',
                                ])
                                ->set(['res_career_mod_date' => 'NOW()'], '', false)
                                ->where([
                                    'idx' => $careerRow[$key]['idx'],
                                    'res_idx' => $rIdx,
                                ])
                                ->update();
                        } else {
                            $masterDB->table('iv_resume_career')
                                ->set([
                                    'delyn' => 'Y',
                                ])
                                ->set(['res_career_del_date' => 'NOW()'], '', false)
                                ->where([
                                    'idx' => $careerRow[$key]['idx'],
                                    'res_idx' => $rIdx,
                                ])
                                ->update();
                        }
                    }
                }
            }
            //language
            if (!empty($rData['language'])) {
                $languageRow = $this->getResume($rIdx, 'language');
                $rowCnt = count($languageRow);
                $rDataCnt = count($rData['language']);

                if ($rowCnt == $rDataCnt) { //기존 데이터와 같을 때 update
                    foreach ($rData['language'] as $key => $val) {
                        $masterDB->table('iv_resume_language')
                            ->set([
                                'res_language_name' => $rData['language'][$key]['lName'] ?? '',
                                'res_language_score' => $rData['language'][$key]['lScore'] ?? '',
                                'res_language_level' => $rData['language'][$key]['lLever'] ?? '',
                                'res_language_obtain_date' => $rData['language'][$key]['lObtainDate'] ?? '',
                                'delyn' => 'N',
                            ])
                            ->set(['res_language_mod_date' => 'NOW()'], '', false)
                            ->where([
                                'idx' => $languageRow[$key]['idx'],
                                'res_idx' => $rIdx,
                            ])
                            ->update();
                    }
                } else if ($rowCnt < $rDataCnt) { //신규 데이터가 있을때 update insert
                    foreach ($rData['language'] as $key => $val) {
                        if ($key < $rowCnt && $rowCnt != 0) {
                            $masterDB->table('iv_resume_language')
                                ->set([
                                    'res_language_name' => $rData['language'][$key]['lName'] ?? '',
                                    'res_language_score' => $rData['language'][$key]['lScore'] ?? '',
                                    'res_language_level' => $rData['language'][$key]['lLever'] ?? '',
                                    'res_language_obtain_date' => $rData['language'][$key]['lObtainDate'] ?? '',
                                    'delyn' => 'N',
                                ])
                                ->set(['res_language_mod_date' => 'NOW()'], '', false)
                                ->where([
                                    'idx' => $languageRow[$key]['idx'],
                                    'res_idx' => $rIdx,
                                ])
                                ->update();
                        } else {
                            $masterDB->table('iv_resume_language')
                                ->set([
                                    'res_idx' => $rIdx,
                                    'res_language_name' => $rData['language'][$key]['lName'] ?? '',
                                    'res_language_score' => $rData['language'][$key]['lScore'] ?? '',
                                    'res_language_level' => $rData['language'][$key]['lLever'] ?? '',
                                    'res_language_obtain_date' => $rData['language'][$key]['lObtainDate'] ?? '',
                                    'delyn' => 'N',
                                ])
                                ->set(['res_language_reg_date' => 'NOW()'], '', false)
                                ->set(['res_language_mod_date' => 'NOW()'], '', false)
                                ->insert();
                        }
                    }
                } else { //기존 데이터가 지워젔을 때 update delyn = n
                    foreach ($languageRow as $key => $val) {
                        if ($key < $rDataCnt && $rDataCnt != 0) {
                            $masterDB->table('iv_resume_language')
                                ->set([
                                    'res_language_name' => $rData['language'][$key]['lName'] ?? '',
                                    'res_language_score' => $rData['language'][$key]['lScore'] ?? '',
                                    'res_language_level' => $rData['language'][$key]['lLever'] ?? '',
                                    'res_language_obtain_date' => $rData['language'][$key]['lObtainDate'],
                                    'delyn' => 'N',
                                ])
                                ->set(['res_language_mod_date' => 'NOW()'], '', false)
                                ->where([
                                    'idx' => $languageRow[$key]['idx'],
                                    'res_idx' => $rIdx,
                                ])
                                ->update();
                        } else {
                            $masterDB->table('iv_resume_language')
                                ->set([
                                    'delyn' => 'Y',
                                ])
                                ->set(['res_language_del_date' => 'NOW()'], '', false)
                                ->where([
                                    'idx' => $languageRow[$key]['idx'],
                                    'res_idx' => $rIdx,
                                ])
                                ->update();
                        }
                    }
                }
            }
            //license
            if (!empty($rData['license'])) {
                $licenseRow = $this->getResume($rIdx, 'license');
                $rowCnt = count($licenseRow);
                $rDataCnt = count($rData['license']);

                if ($rowCnt == $rDataCnt) { //기존 데이터와 같을 때 update
                    foreach ($rData['license'] as $key => $val) {
                        $masterDB->table('iv_resume_license')
                            ->set([
                                'res_license_name' => $rData['license'][$key]['lName'] ?? '',
                                'res_license_public_org' => $rData['license'][$key]['lPublicOrg'] ?? '',
                                'res_license_level' => $rData['license'][$key]['lLevel'] ?? '',
                                'res_license_obtain_date' => $rData['license'][$key]['lObtainDate'] ?? '',
                                'delyn' => 'N',
                            ])
                            ->set(['res_license_mod_date' => 'NOW()'], '', false)
                            ->where([
                                'idx' => $licenseRow[$key]['idx'],
                                'res_idx' => $rIdx,
                            ])
                            ->update();
                    }
                } else if ($rowCnt < $rDataCnt) { //신규 데이터가 있을때 update insert
                    foreach ($rData['license'] as $key => $val) {
                        if ($key < $rowCnt && $rowCnt != 0) {


                            $masterDB->table('iv_resume_license')
                                ->set([
                                    'res_license_name' => $rData['license'][$key]['lName'] ?? '',
                                    'res_license_public_org' => $rData['license'][$key]['lPublicOrg'] ?? '',
                                    'res_license_level' => $rData['license'][$key]['lLevel'] ?? '',
                                    'res_license_obtain_date' => $rData['license'][$key]['lObtainDate'] ?? '',
                                    'delyn' => 'N',
                                ])
                                ->set(['res_license_mod_date' => 'NOW()'], '', false)
                                ->where([
                                    'idx' => $licenseRow[$key]['idx'],
                                    'res_idx' => $rIdx,
                                ])
                                ->update();
                        } else {
                            $masterDB->table('iv_resume_license')
                                ->set([
                                    'res_idx' => $rIdx,
                                    'res_license_name' => $rData['license'][$key]['lName'] ?? '',
                                    'res_license_public_org' => $rData['license'][$key]['lPublicOrg'] ?? '',
                                    'res_license_level' => $rData['license'][$key]['lLevel'] ?? '',
                                    'res_license_obtain_date' => $rData['license'][$key]['lObtainDate'] ?? '',
                                    'delyn' => 'N',
                                ])
                                ->set(['res_license_reg_date' => 'NOW()'], '', false)
                                ->set(['res_license_mod_date' => 'NOW()'], '', false)
                                ->insert();
                        }
                    }
                } else { //기존 데이터가 지워젔을 때 update delyn = n
                    foreach ($licenseRow as $key => $val) {
                        if ($key < $rDataCnt && $rDataCnt != 0) {
                            $masterDB->table('iv_resume_license')
                                ->set([
                                    'res_license_name' => $rData['license'][$key]['lName'] ?? '',
                                    'res_license_public_org' => $rData['license'][$key]['lPublicOrg'] ?? '',
                                    'res_license_level' => $rData['license'][$key]['lLevel'] ?? '',
                                    'res_license_obtain_date' => $rData['license'][$key]['lObtainDate'] ?? '',
                                    'delyn' => 'N',
                                ])
                                ->set(['res_license_mod_date' => 'NOW()'], '', false)
                                ->where([
                                    'idx' => $licenseRow[$key]['idx'],
                                    'res_idx' => $rIdx,
                                ])
                                ->update();
                        } else {
                            $masterDB->table('iv_resume_license')
                                ->set([
                                    'delyn' => 'Y',
                                ])
                                ->set(['res_license_del_date' => 'NOW()'], '', false)
                                ->where([
                                    'idx' => $licenseRow[$key]['idx'],
                                    'res_idx' => $rIdx,
                                ])
                                ->update();
                        }
                    }
                }
            }
            //activity
            if (!empty($rData['activity'])) {
                $activitytRow = $this->getResume($rIdx, 'activity');
                $rowCnt = count($activitytRow);
                $rDataCnt = count($rData['activity']);

                if ($rowCnt == $rDataCnt) { //기존 데이터와 같을 때 update
                    foreach ($rData['activity'] as $key => $val) {
                        $masterDB->table('iv_resume_activity')
                            ->set([
                                'res_activity_name' => $rData['activity'][$key]['actName'] ?? '',
                                'res_activity_score' => $rData['activity'][$key]['detail'] ?? '',
                                'res_activity_start_date' => $rData['activity'][$key]['aStartDate'] ?? '',
                                'res_activity_end_date' => $rData['activity'][$key]['aEndDate'] ?? '',
                                'delyn' => 'N',
                            ])
                            ->set(['res_activity_mod_date' => 'NOW()'], '', false)
                            ->where([
                                'idx' => $activitytRow[$key]['idx'],
                                'res_idx' => $rIdx,
                            ])
                            ->update();
                    }
                } else if ($rowCnt < $rDataCnt) { //신규 데이터가 있을때 update insert
                    foreach ($rData['activity'] as $key => $val) {
                        if ($key < $rowCnt && $rowCnt != 0) {
                            $masterDB->table('iv_resume_activity')
                                ->set([
                                    'res_activity_name' => $rData['activity'][$key]['actName'] ?? '',
                                    'res_activity_score' => $rData['activity'][$key]['detail'] ?? '',
                                    'res_activity_start_date' => $rData['activity'][$key]['aStartDate'] ?? '',
                                    'res_activity_end_date' => $rData['activity'][$key]['aEndDate'] ?? '',
                                    'delyn' => 'N',
                                ])
                                ->set(['res_activity_mod_date' => 'NOW()'], '', false)
                                ->where([
                                    'idx' => $activitytRow[$key]['idx'],
                                    'res_idx' => $rIdx,
                                ])
                                ->update();
                        } else {
                            $masterDB->table('iv_resume_activity')
                                ->set([
                                    'res_idx' => $rIdx,
                                    'res_activity_name' => $rData['activity'][$key]['actName'] ?? '',
                                    'res_activity_score' => $rData['activity'][$key]['detail'] ?? '',
                                    'res_activity_start_date' => $rData['activity'][$key]['aStartDate'] ?? '',
                                    'res_activity_end_date' => $rData['activity'][$key]['aEndDate'] ?? '',
                                    'delyn' => 'N',
                                ])
                                ->set(['res_activity_reg_date' => 'NOW()'], '', false)
                                ->set(['res_activity_mod_date' => 'NOW()'], '', false)
                                ->insert();
                        }
                    }
                } else { //기존 데이터가 지워젔을 때 update delyn = n
                    foreach ($activitytRow as $key => $val) {
                        if ($key < $rDataCnt && $rDataCnt != 0) {
                            $masterDB->table('iv_resume_activity')
                                ->set([
                                    'res_activity_name' => $rData['activity'][$key]['actName'] ?? '',
                                    'res_activity_score' => $rData['activity'][$key]['detail'] ?? '',
                                    'res_activity_start_date' => $rData['activity'][$key]['aStartDate'] ?? '',
                                    'res_activity_end_date' => $rData['activity'][$key]['aEndDate'] ?? '',
                                    'delyn' => 'N',
                                ])
                                ->set(['res_activity_mod_date' => 'NOW()'], '', false)
                                ->where([
                                    'idx' => $activitytRow[$key]['idx'],
                                    'res_idx' => $rIdx,
                                ])
                                ->update();
                        } else {
                            $masterDB->table('iv_resume_activity')
                                ->set([
                                    'delyn' => 'Y',
                                ])
                                ->set(['res_activity_del_date' => 'NOW()'], '', false)
                                ->where([
                                    'idx' => $activitytRow[$key]['idx'],
                                    'res_idx' => $rIdx,
                                ])
                                ->update();
                        }
                    }
                }
            }
            //rPortfolio
            if (!empty($rData['rPortfolio'])) {
                $portfolioRow = $this->getResume($rIdx, 'portfolio');
                $rowCnt = count($portfolioRow);
                $rDataCnt = count($rData['rPortfolio']);

                if ($rowCnt == $rDataCnt) { //기존 데이터와 같을 때 update
                    foreach ($rData['rPortfolio'] as $key => $val) {
                        if ($rData['rPortfolio'][$key]['profileFile'] != $portfolioRow[$key]['file_save_name']) {
                            $masterDB->table('iv_file')
                                ->set([
                                    'file_org_name' => $rData['rPortfolio'][$key]['file_save_name'],
                                    'file_save_name' => $rData['rPortfolio'][$key]['profileFile'],
                                    'file_size' => $rData['rPortfolio'][$key]['fileSize'],
                                    'delyn' => 'N',
                                ])
                                ->where('idx', $portfolioRow[$key]['file_idx'])
                                ->update();
                        }

                        $masterDB->table('iv_resume_portfolio')
                            ->set(['res_portfolio_mod_date' => 'NOW()'], '', false)
                            ->where([
                                'idx' => $portfolioRow[$key]['idx'],
                                'res_idx' => $rIdx,
                            ])
                            ->update();
                    }
                } else if ($rowCnt < $rDataCnt) { //신규 데이터가 있을때 update insert
                    foreach ($rData['rPortfolio'] as $key => $val) {
                        if ($key <= $rowCnt && $rowCnt != 0) {
                            if ($rData['rPortfolio'][$key]['profileFile'] != $portfolioRow[$key]['file_save_name']) {
                                $masterDB->table('iv_file')
                                    ->set([
                                        'file_org_name' => $rData['rPortfolio'][$key]['file_save_name'],
                                        'file_save_name' => $rData['rPortfolio'][$key]['profileFile'],
                                        'file_size' => $rData['rPortfolio'][$key]['fileSize'],
                                        'delyn' => 'N',
                                    ])
                                    ->set(['file_mod_date' => 'NOW()'], '', false)
                                    ->where('idx', $portfolioRow[$key]['file_idx'])
                                    ->update();
                            }

                            $masterDB->table('iv_resume_portfolio')
                                ->set(['res_portfolio_mod_date' => 'NOW()'], '', false)
                                ->where([
                                    'idx' => $portfolioRow[$key]['idx'],
                                    'res_idx' => $rIdx,
                                ])
                                ->update();
                        } else {
                            $masterDB->table('iv_file')
                                ->set([
                                    'file_type' => 'P',
                                    'file_org_name' => $rData['rPortfolio'][$key]['file_save_name'],
                                    'file_save_name' => $rData['rPortfolio'][$key]['profileFile'],
                                    'file_size' => $rData['rPortfolio'][$key]['fileSize'],
                                    'delyn' => 'N',
                                ])
                                ->set(['file_reg_date' => 'NOW()'], '', false)
                                ->set(['file_mod_date' => 'NOW()'], '', false)
                                ->insert();

                            $filePortflioIdx = $masterDB->insertID();

                            $masterDB->table('iv_resume_portfolio')
                                ->set([
                                    'res_idx' => $rIdx,
                                    'file_idx' => $filePortflioIdx,
                                    'res_portfolio_type' => 'F',
                                    'delyn' => 'N',
                                ])
                                ->set(['res_portfolio_reg_date' => 'NOW()'], '', false)
                                ->set(['res_portfolio_mod_date' => 'NOW()'], '', false)
                                ->insert();
                        }
                    }
                } else { //기존 데이터가 지워젔을 때 update delyn = n
                    foreach ($portfolioRow as $key => $val) {
                        if ($key < $rDataCnt && $rDataCnt != 0) {
                            if ($rData['rPortfolio'][$key]['profileFile'] != $portfolioRow[$key]['file_save_name']) {
                                $masterDB->table('iv_file')
                                    ->set([
                                        'file_org_name' => $rData['rPortfolio'][$key]['file_save_name'],
                                        'file_save_name' => $rData['rPortfolio'][$key]['profileFile'],
                                        'file_size' => $rData['rPortfolio'][$key]['fileSize'],
                                        'delyn' => 'N',
                                    ])
                                    ->set(['file_mod_date' => 'NOW()'], '', false)
                                    ->where('idx', $portfolioRow[$key]['file_idx'])
                                    ->update();
                            }

                            $masterDB->table('iv_resume_portfolio')
                                ->set(['res_portfolio_mod_date' => 'NOW()'], '', false)
                                ->where([
                                    'idx' => $portfolioRow[$key]['idx'],
                                    'res_idx' => $rIdx,
                                ])
                                ->update();
                        } else {
                            $masterDB->table('iv_file')
                                ->set([
                                    'delyn' => 'Y',
                                ])
                                ->set(['file_del_date' => 'NOW()'], '', false)
                                ->where('idx', $portfolioRow[$key]['file_idx'])
                                ->update();

                            $masterDB->table('iv_resume_portfolio')
                                ->set([
                                    'delyn' => 'Y',
                                ])
                                ->set(['res_portfolio_del_date' => 'NOW()'], '', false)
                                ->where([
                                    'idx' => $portfolioRow[$key]['idx'],
                                    'res_idx' => $rIdx,
                                ])
                                ->update();
                        }
                    }
                }
            }
        }


        // 트랜잭션 end
        if ($masterDB->transStatus() === false) {
            $masterDB->transRollback();
        } else {
            $masterDB->transCommit();
        }

        $masterDB->close();

        if ($rIdx != 0) {
            $resumeIdx = $rIdx;
        }

        return $resumeIdx;
    }

    public function resetResume($memIdx, $rIdx)
    {
        $aRow = [];
        if (!$memIdx) {
            return $aRow;
        }

        // $masterDB
        $masterDB = \Config\Database::connect('master');
        //트랜잭션 start
        $masterDB->transBegin();

        //iv_resume
        $baseRow = $this->getResume($rIdx, 'base');

        $masterDB->table('iv_file')
            ->set([
                'delyn' => 'Y',
            ])
            ->set(['file_del_date' => 'NOW()'], '', false)
            ->where('idx', $baseRow['file_idx_profile'])
            ->update();
        $masterDB->table('iv_resume')
            ->set([
                'delyn' => 'Y',
            ])
            ->set(['res_del_date' => 'NOW()'], '', false)
            ->where([
                'idx' => $rIdx,
            ])
            ->update();
        //iv_resume_category
        $masterDB->table('iv_resume_category')
            ->set([
                'delyn' => 'Y',
            ])
            ->set(['res_interest_del_date' => 'NOW()'], '', false)
            ->where([
                'res_idx' => $rIdx,
            ])
            ->update();
        //iv_resume_education
        $masterDB->table('iv_resume_education')
            ->set([
                'delyn' => 'Y',
            ])
            ->set(['res_edu_del_date' => 'NOW()'], '', false)
            ->where([
                'res_idx' => $rIdx,
            ])
            ->update();
        //iv_resume_career
        $masterDB->table('iv_resume_career')
            ->set([
                'delyn' => 'Y',
            ])
            ->set(['res_career_del_date' => 'NOW()'], '', false)
            ->where([
                'res_idx' => $rIdx,
            ])
            ->update();
        //iv_resume_language
        $masterDB->table('iv_resume_language')
            ->set([
                'delyn' => 'Y',
            ])
            ->set(['res_language_del_date' => 'NOW()'], '', false)
            ->where([
                'res_idx' => $rIdx,
            ])
            ->update();
        //iv_resume_license
        $masterDB->table('iv_resume_license')
            ->set([
                'delyn' => 'Y',
            ])
            ->set(['res_license_del_date' => 'NOW()'], '', false)
            ->where([
                'res_idx' => $rIdx,
            ])
            ->update();
        //iv_resume_activity
        $masterDB->table('iv_resume_activity')
            ->set([
                'delyn' => 'Y',
            ])
            ->set(['res_activity_del_date' => 'NOW()'], '', false)
            ->where([
                'res_idx' => $rIdx,
            ])
            ->update();
        //iv_resume_portfolio
        $portfolioRow = $this->getResume($rIdx, 'portfolio');

        foreach ($portfolioRow as $key => $val) {

            $masterDB->table('iv_file')
                ->set([
                    'delyn' => 'Y',
                ])
                ->set(['file_del_date' => 'NOW()'], '', false)
                ->where('idx', $portfolioRow[$key]['file_idx'])
                ->update();
        }
        $masterDB->table('iv_resume_portfolio')
            ->set([
                'delyn' => 'Y',
            ])
            ->set(['res_portfolio_del_date' => 'NOW()'], '', false)
            ->where([
                'res_idx' => $rIdx,
            ])
            ->update();
        // 트랜잭션 end
        if ($masterDB->transStatus() === false) {
            $masterDB->transRollback();
        } else {
            $masterDB->transCommit();
        }

        $masterDB->close();
    }


    public function reportResumeTotalCount($jobIdx): array
    {
        $aRow = [];
        if (!$jobIdx) {
            return $aRow;
        }

        $aRow = $this
            ->select('COUNT(*) jobCnt')
            ->join('iv_resume_category', 'iv_resume.idx=iv_resume_category.res_idx', 'inner')
            ->where([
                'iv_resume_category.job_idx' => $jobIdx,
            ])
            ->first();

        if ($aRow == "" || $aRow == null) {
            $aRow = [];
        }

        return $aRow;
    }

    public function reportResumeGenderCount($jobIdx): array
    {
        $aRow = [];
        if (!$jobIdx) {
            return $aRow;
        }

        $sql = "SELECT 
        SUM(IF(res_gender='M' OR res_gender='W', genderCount,0)) genderAll, 
        SUM(IF(res_gender='M', genderCount,0)) genderM, 
        SUM(IF(res_gender='W', genderCount,0)) genderW 
        FROM 
        (SELECT iv_resume.res_gender, COUNT(iv_resume.res_gender) genderCount 
        FROM iv_resume INNER JOIN iv_resume_category ON iv_resume.idx = iv_resume_category.res_idx 
        WHERE iv_resume_category.job_idx = {$jobIdx} AND iv_resume_category.delyn = 'N' GROUP BY iv_resume.res_gender) A";
        $aRow = $this
            ->query($sql)
            ->getResult();

        if ($aRow == "" || $aRow == null) {
            $aRow = [];
        }

        return $aRow;
    }

    public function reportResumeAgeCount($rIdx, $jobIdx, $my = null): array
    {
        /* 0~150 대 나이 전체 출력 - 쿼리 잘못됨 limit가 안먹음
        SELECT * FROM 
        (SELECT @N := @N +10 AS n FROM 
        (SELECT iv_resume.res_birth FROM iv_resume 
        INNER JOIN iv_resume_category 
        ON iv_resume.idx = iv_resume_category.res_idx
        WHERE iv_resume_category.job_idx = 3) AS A,
        (SELECT @N :=-10 FROM DUAL) NN LIMIT 100
        ) AS T  
        LEFT JOIN
        (SELECT FLOOR((DATE_FORMAT(NOW(),'%Y')-res_birth)/10)*10 AS age,
        COUNT(*) AS total
        FROM 
        (SELECT iv_resume.res_birth FROM iv_resume 
        INNER JOIN iv_resume_category 
        ON iv_resume.idx = iv_resume_category.res_idx
        WHERE iv_resume_category.job_idx = 3) AS B
        GROUP BY age
        ) S 
        ON T.n=S.age
        */
        $aRow = [];
        if (!$jobIdx) {
            return $aRow;
        }
        if ($my == null) {
            $sql = "SELECT * FROM 
        (SELECT FLOOR((DATE_FORMAT(NOW(),'%Y')-res_birth)/10)*10 AS age,
        COUNT(*) AS total, res_idx FROM 
        (SELECT iv_resume.res_birth, iv_resume_category.res_idx FROM iv_resume 
        INNER JOIN iv_resume_category 
        ON iv_resume.idx = iv_resume_category.res_idx
        WHERE iv_resume_category.job_idx = {$jobIdx} AND iv_resume_category.delyn = 'N') AS B
        GROUP BY age) S 
        WHERE S.age>=0 AND S.age<=150";
        } else {
            $sql = " SELECT FLOOR((DATE_FORMAT(NOW(),'%Y')-res_birth)/10)*10 AS age, res_idx FROM 
        (SELECT iv_resume.res_birth, iv_resume_category.res_idx 
        FROM iv_resume INNER JOIN iv_resume_category ON iv_resume.idx = iv_resume_category.res_idx 
        WHERE iv_resume_category.job_idx = {$jobIdx} AND iv_resume.idx={$rIdx} AND iv_resume_category.delyn = 'N') AS B 
        GROUP BY age";
        }
        $aRow = $this
            ->query($sql)
            ->getResult();

        if ($aRow == "" || $aRow == null) {
            $aRow = [];
        }

        return $aRow;
    }

    public function reportResumeEduCount($jobIdx): array
    {
        $aRow = [];
        if (!$jobIdx) {
            return $aRow;
        }

        $sql = "";
        $aRow = $this
            ->query($sql)
            ->getResult();

        if ($aRow == "" || $aRow == null) {
            $aRow = [];
        }

        return $aRow;
    }

    public function reportResumeCareerCount($rIdx, $jobIdx, $my = null): object
    {
        $aRow = [];
        if (!$rIdx) {
            return $aRow;
        }

        if (!$jobIdx) {
            return $aRow;
        }
        if ($my == null) {
            //모든 경력 산출 - 직무 연관 경력 안됨
            $sql = "SELECT 
            COUNT(IF(mm <= 0, mm, NULL)) c0,
            COUNT(IF(mm > 0 AND mm < 1, mm, NULL)) c1,
            COUNT(IF(mm >= 1 AND mm < 3, mm, NULL)) c3,
            COUNT(IF(mm >= 3 AND mm < 5, mm, NULL)) c5,
            COUNT(IF(mm >= 5, mm, NULL)) c10
            FROM
            (SELECT SUM(TIMESTAMPDIFF(MONTH , STR_TO_DATE(CONCAT(res_career_join_date,'01'),'%Y%m%d'), STR_TO_DATE(CONCAT(res_career_leave_date,'01'),'%Y%m%d'))) / 12 mm
            FROM
            (SELECT  A.res_idx, B.res_career_join_date, B.res_career_leave_date
            FROM
            (SELECT iv_resume_category.res_idx 
            FROM iv_resume 
            INNER JOIN iv_resume_category 
            ON iv_resume.idx = iv_resume_category.res_idx
            WHERE iv_resume_category.job_idx = {$jobIdx} AND iv_resume_category.delyn = 'N') A
            LEFT JOIN 
            iv_resume_career B
            ON A.res_idx = B.res_idx) C
            GROUP BY res_idx) D";
        } else {
            $sql = "SELECT SUM(TIMESTAMPDIFF(MONTH , STR_TO_DATE(CONCAT(res_career_join_date,'01'),'%Y%m%d'), STR_TO_DATE(CONCAT(res_career_leave_date,'01'),'%Y%m%d'))) / 12 mm
            FROM
            (SELECT  A.res_idx, B.res_career_join_date, B.res_career_leave_date
            FROM
            (SELECT iv_resume_category.res_idx 
            FROM iv_resume 
            INNER JOIN iv_resume_category 
            ON iv_resume.idx = iv_resume_category.res_idx
            WHERE iv_resume_category.job_idx = {$jobIdx} AND iv_resume.idx = {$rIdx} AND iv_resume_category.delyn = 'N') A
            LEFT JOIN 
            iv_resume_career B
            ON A.res_idx = B.res_idx) C
            GROUP BY res_idx";
        }
        $aRow = $this
            ->query($sql)
            ->getRow();

        if ($aRow == "" || $aRow == null) {
            $aRow = [];
        }

        return $aRow;
    }

    public function reportResumeLnagCount($rIdx, $jobIdx, $my = null): array
    {
        $aRow = [];
        if (!$rIdx) {
            return $aRow;
        }
        if (!$jobIdx) {
            return $aRow;
        }
        if ($my == null) {
            $sql = "SELECT res_language_name, COUNT(res_language_name) lang_cnt, AVG(res_language_score) lang_score FROM
                    (SELECT  A.res_idx, B.res_language_name, B.res_language_score  
                    FROM
                    (SELECT iv_resume_category.res_idx 
                    FROM iv_resume 
                    INNER JOIN iv_resume_category 
                    ON iv_resume.idx = iv_resume_category.res_idx
                    WHERE iv_resume_category.job_idx = {$jobIdx} AND iv_resume_category.delyn = 'N') A
                    LEFT JOIN 
                    iv_resume_language B
                    ON A.res_idx = B.res_idx WHERE res_language_name IS NOT NULL) C
                    GROUP BY res_language_name";
        } else {
            $sql = "SELECT  A.res_idx, B.res_language_name, B.res_language_score  
                    FROM
                    (SELECT iv_resume_category.res_idx 
                    FROM iv_resume 
                    INNER JOIN iv_resume_category 
                    ON iv_resume.idx = iv_resume_category.res_idx
                    WHERE iv_resume_category.job_idx = {$jobIdx} AND iv_resume_category.delyn = 'N') A
                    LEFT JOIN 
                    iv_resume_language B
                    ON A.res_idx = B.res_idx WHERE A.res_idx={$rIdx} AND B.res_language_name IS NOT NULL";
        }
        $aRow = $this
            ->query($sql)
            ->getResult();

        if ($aRow == "" || $aRow == null) {
            $aRow = [];
        }

        return $aRow;
    }

    public function reportResumeLangToeicCount($rIdx, $jobIdx, $my = null): array
    {
        $aRow = [];
        if (!$rIdx) {
            return $aRow;
        }
        if (!$jobIdx) {
            return $aRow;
        }
        if ($my == null) {
            $sql = "SELECT * FROM
            (SELECT COUNT(*) AS total, FLOOR(res_language_score/100)*100 AS score FROM
            (SELECT  A.res_idx, B.res_language_name, B.res_language_score  
            FROM
            (SELECT iv_resume_category.res_idx 
            FROM iv_resume 
            INNER JOIN iv_resume_category 
            ON iv_resume.idx = iv_resume_category.res_idx
            WHERE iv_resume_category.job_idx = {$jobIdx} AND iv_resume_category.delyn = 'N') A
            LEFT JOIN 
            iv_resume_language B
            ON A.res_idx = B.res_idx WHERE res_language_name = 'TOEIC') C
            GROUP BY score) D
                                ";
        } else {
            $sql = "SELECT  A.res_idx, B.res_language_name, FLOOR(B.res_language_score/100)*100 AS score  
            FROM
            (SELECT iv_resume_category.res_idx 
            FROM iv_resume 
            INNER JOIN iv_resume_category 
            ON iv_resume.idx = iv_resume_category.res_idx
            WHERE iv_resume_category.job_idx = {$jobIdx} AND iv_resume.idx = {$rIdx} AND iv_resume_category.delyn = 'N') A
            LEFT JOIN 
            iv_resume_language B
            ON A.res_idx = B.res_idx WHERE res_language_name = 'TOEIC'";
        }

        $aRow = $this
            ->query($sql)
            ->getResult();

        if ($aRow == "" || $aRow == null) {
            $aRow = [];
        }

        return $aRow;
    }

    public function reportResumeLicenseTotleCount($rIdx, $jobIdx, $my = null): array
    {
        $aRow = [];
        if (!$rIdx) {
            return $aRow;
        }
        if (!$jobIdx) {
            return $aRow;
        }
        if ($my == null) {
            $sql = "SELECT COUNT(*) cnt, res_cnt FROM
            (SELECT  COUNT(A.res_idx) res_cnt, A.res_idx
            FROM
            (SELECT iv_resume_category.res_idx 
            FROM iv_resume 
            INNER JOIN iv_resume_category 
            ON iv_resume.idx = iv_resume_category.res_idx
            WHERE iv_resume_category.job_idx = {$jobIdx} AND iv_resume_category.delyn = 'N') A
            LEFT JOIN 
            iv_resume_license B
            ON A.res_idx = B.res_idx
            WHERE B.res_license_level = '최종합격' AND B.delyn = 'N'
            GROUP BY B.res_idx) C GROUP BY C.res_cnt";
        } else if ($my == 'total') {
            $sql = "SELECT COUNT(*) total FROM
            (SELECT iv_resume_category.res_idx 
            FROM iv_resume 
            INNER JOIN iv_resume_category 
            ON iv_resume.idx = iv_resume_category.res_idx
            WHERE iv_resume_category.job_idx = {$jobIdx} AND iv_resume_category.delyn = 'N') A
            LEFT OUTER JOIN 
            iv_resume_license B
            ON A.res_idx = B.res_idx";
        } else if ($my == "ftotal") {
            $sql = "SELECT COUNT(*) total FROM
            (SELECT iv_resume_category.res_idx 
            FROM iv_resume 
            INNER JOIN iv_resume_category 
            ON iv_resume.idx = iv_resume_category.res_idx
            WHERE iv_resume_category.job_idx = {$jobIdx} AND iv_resume_category.delyn = 'N') A
            LEFT OUTER JOIN 
            iv_resume_license B
            ON A.res_idx = B.res_idx WHERE B.res_license_level = '최종합격' AND B.delyn = 'N'";
        } else {
            $sql = "SELECT  COUNT(A.res_idx) res_cnt, A.res_idx
            FROM
            (SELECT iv_resume_category.res_idx 
            FROM iv_resume 
            INNER JOIN iv_resume_category 
            ON iv_resume.idx = iv_resume_category.res_idx
            WHERE iv_resume_category.job_idx = {$jobIdx} AND iv_resume_category.delyn = 'N') A
            LEFT JOIN 
            iv_resume_license B
            ON A.res_idx = B.res_idx
            WHERE B.res_license_level = '최종합격' AND B.res_idx={$rIdx} AND B.delyn = 'N'
            GROUP BY B.res_idx";
        }
        $aRow = $this
            ->query($sql)
            ->getResult();



        if ($aRow == "" || $aRow == null) {
            $aRow = [];
        }

        return $aRow;
    }

    public function reportResumeLicenseCount($rIdx, $jobIdx, $my = null): array
    {
        $aRow = [];
        if (!$rIdx) {
            return $aRow;
        }
        if (!$jobIdx) {
            return $aRow;
        }
        if ($my == null) {
            $sql = "";
        } else {
            $sql = "";
        }
        $aRow = $this
            ->query($sql)
            ->getResult();

        if ($aRow == "" || $aRow == null) {
            $aRow = [];
        }

        return $aRow;
    }

    public function reportResumeActivityCount($rIdx, $jobIdx, $my = null): array
    {
        $aRow = [];
        if (!$rIdx) {
            return $aRow;
        }
        if (!$jobIdx) {
            return $aRow;
        }
        if ($my == null) {
            $sql = "";
        } else {
            $sql = "";
        }
        $aRow = $this
            ->query($sql)
            ->getResult();

        if ($aRow == "" || $aRow == null) {
            $aRow = [];
        }

        return $aRow;
    }

    public function reportResumePortfolioCount($rIdx, $jobIdx, $my = null): array
    {
        $aRow = [];
        if (!$rIdx) {
            return $aRow;
        }
        if (!$jobIdx) {
            return $aRow;
        }
        if ($my == null) {
            $sql = "";
        } else {
            $sql = "";
        }
        $aRow = $this
            ->query($sql)
            ->getResult();

        if ($aRow == "" || $aRow == null) {
            $aRow = [];
        }

        return $aRow;
    }

    public function memberBuilder(): object
    {
        $objQuery = $this
            ->join('iv_member', 'iv_resume.mem_idx = iv_member.idx', 'left');
        return $objQuery;
    }

    public function getAnalysisEdu($rIdx): array
    {
        $sql = "SELECT res_edu_school, res_edu_school_type, res_edu_department, type_score, school_rank, grade_score,
        ((type_score / 10 * 100) + (100 - (school_rank / 1355 * 100)) + grade_score) / 3 AS t_score
        FROM
        (
        SELECT res_idx , res_edu_school, res_edu_school_type , MAX(res_edu_graduate) , res_edu_department, res_edu_tscore, res_edu_score, 
        CASE 
        WHEN res_edu_school_type = 'H' THEN 2 
        WHEN res_edu_school_type = 'C' THEN 4 
        WHEN res_edu_school_type = 'U' THEN 6 
        WHEN res_edu_school_type = 'M' THEN 8 
        WHEN res_edu_school_type = 'D' THEN 10 
        END type_score,
        (SELECT IFNULL(
        (SELECT MIN(idx) idx FROM (SELECT * FROM report_school WHERE a2 LIKE IF(CONCAT(SUBSTRING_INDEX((
        SELECT res_edu_school FROM 
        (SELECT * FROM iv_resume_education WHERE res_idx = {$rIdx} AND res_edu_graduate_type = 'B' ORDER BY res_edu_graduate DESC) a 
        GROUP BY res_idx
        ),'대', 1),'대%') = '대%' , '대학교' , CONCAT(SUBSTRING_INDEX((
        SELECT res_edu_school FROM 
        (SELECT * FROM iv_resume_education WHERE res_idx = {$rIdx} AND res_edu_graduate_type = 'B' ORDER BY res_edu_graduate DESC) a 
        GROUP BY res_idx
        ),'대', 1),'대%')) ORDER BY idx) mindate GROUP BY a2)
        , 1355 )) school_rank,
        IF(res_edu_score > 0 , 
        (SELECT a4 FROM report_grade WHERE 
        (CASE 
        WHEN res_edu_tscore = 4.0 THEN `a1` 
        WHEN res_edu_tscore = 4.3 THEN `a2` 
        WHEN res_edu_tscore = 4.5 THEN `a3`
        END)  = res_edu_score
        ) , 0 ) grade_score
        FROM 
        (SELECT * FROM iv_resume_education WHERE res_idx = {$rIdx} AND res_edu_graduate_type = 'B' ORDER BY res_edu_graduate DESC) b
        GROUP BY res_idx
        ) c";

        $aRow = $this
            ->query($sql)
            ->getResult();

        if ($aRow == "" || $aRow == null) {
            $aRow = [];
        }

        return $aRow;
    }

    public function getAnalysisCareer($rIdx): array
    {
        $sql = "SELECT *, 
        ((c_score / 10 * 100) + (l_score / 10 * 100) + (r_score / 10 * 100)) / 3 t_score
        FROM
        (SELECT *,
        CASE 
        WHEN cm3 = 0 THEN 10 
        WHEN cm3 > 0 AND cm3 < 3 THEN 8
        WHEN cm3 >= 3 AND cm3 < 6 THEN 6
        WHEN cm3 >= 6 AND cm3 < 12 THEN 4
        WHEN cm3 >= 12 THEN 2
        END l_score 
        FROM
        (SELECT *, (cm2 - cm1) cm3,
        CASE 
        WHEN t_year = 0 THEN 0 
        WHEN t_year > 0 AND t_year < 1 THEN 2
        WHEN t_year >= 1 AND t_year < 3 THEN 4
        WHEN t_year >= 3 AND t_year < 5 THEN 6
        WHEN t_year >= 5 AND t_year < 10 THEN 8
        WHEN t_year >= 10 THEN 10 
        END c_score,
        CASE 
        WHEN rcnt = 0 THEN 10 
        WHEN rcnt = 1 THEN 9
        WHEN rcnt = 2 THEN 8
        WHEN rcnt = 3 THEN 7
        WHEN rcnt = 4 THEN 6
        WHEN rcnt >= 5 THEN 5
        END r_score
        FROM (
        SELECT 
        res_career_company_name, res_career_pay, res_career_leave_date, 
        IF(res_career_leave_date > 0 , 0 , 1) c_type,
        (SELECT IFNULL(
        (SELECT SUM(cm)/12 cy FROM 
        (SELECT PERIOD_DIFF(edate,sdate) cm, res_idx FROM
        (SELECT res_idx , res_career_join_date sdate, 
        IF(res_career_leave_date IS NULL , DATE_FORMAT(NOW(), '%Y%m'), res_career_leave_date) edate
        FROM iv_resume_career WHERE res_idx = {$rIdx}
        ORDER BY edate) a
        ) b
        GROUP BY res_idx)
        , 0)) t_year,
        (SELECT SUM(cm) cm FROM 
        (SELECT PERIOD_DIFF(edate,sdate) cm, res_idx FROM
        (SELECT res_idx , res_career_join_date sdate, 
        IF(res_career_leave_date IS NULL , DATE_FORMAT(NOW(), '%Y%m'), res_career_leave_date) edate
        FROM iv_resume_career WHERE res_idx = {$rIdx}
        ORDER BY edate) a
        ) b
        GROUP BY res_idx) cm1,
        (SELECT PERIOD_DIFF(
        (SELECT MAX(edate) edate FROM 
        (SELECT res_idx,IF(res_career_leave_date IS NULL , DATE_FORMAT(NOW(), '%Y%m'), res_career_leave_date) edate FROM iv_resume_career 
        WHERE res_idx = {$rIdx} ORDER BY res_career_join_date) bb 
        GROUP BY res_idx),
        (SELECT MIN(sdate) sdate FROM 
        (SELECT res_idx,res_career_join_date sdate FROM iv_resume_career WHERE res_idx = {$rIdx} ORDER BY res_career_join_date) aa 
        GROUP BY res_idx)
        ) cm2 ) cm2,
        (SELECT COUNT(res_idx) rcnt FROM iv_resume_career WHERE res_idx = {$rIdx}) rcnt
        FROM 
        (SELECT * FROM iv_resume_career WHERE res_idx = {$rIdx} ORDER BY res_career_join_date DESC) bbb
        GROUP BY res_idx
        ) careerdate ) careerdate) careerdate
            ";

        $aRow = $this
            ->query($sql)
            ->getResult();

        if ($aRow == "" || $aRow == null) {
            $aRow = [];
        }

        return $aRow;
    }

    public function getAnalysisLanguage($rIdx): array
    {
        $sql = "SELECT res_language_name, res_language_score, aa ,cnt,
        (l_score / 5 * 100) AS l_score
        FROM
        (SELECT res_language_name, res_language_score, aa, cnt,
        CASE 
                WHEN cnt = 0 THEN 0 
                WHEN cnt = 1 THEN 1
                WHEN cnt = 2 THEN 2
                WHEN cnt = 3 THEN 3
                WHEN cnt = 4 THEN 4
                WHEN cnt >= 5 THEN 5
                END l_score
        FROM
        (SELECT  'T' AS res_language_name, 0 AS res_language_score , 0 AS aa, COUNT(res_idx) cnt, 0 AS l_score FROM iv_resume_language WHERE res_idx = {$rIdx}) dd) dd
                UNION ALL
                SELECT * , 
                aa / cnt * 100 l_score
                FROM
                (SELECT res_language_name, res_language_score, 
                (SELECT a3 FROM (SELECT *, SUBSTRING_INDEX(a2, '~',1) b1, SUBSTRING_INDEX(a2, '~',-1) b2 FROM report_language_license) aa
                WHERE b1 <= res_language_score AND b2 >= res_language_score AND a1 = res_language_name
                ) aa,
                (SELECT COUNT(a1) FROM report_language_license WHERE a1 = res_language_name) cnt
                FROM iv_resume_language WHERE res_idx = {$rIdx}) cc";

        $aRow = $this
            ->query($sql)
            ->getResult();

        if ($aRow == "" || $aRow == null) {
            $aRow = [];
        }

        return $aRow;
    }

    public function getAnalysisLicense($rIdx): array
    {
        $sql = "SELECT l_name, l_type, (l_score / 5 * 100) AS l_score , cnt
        FROM
        (SELECT l_name, l_type, 
        CASE 
                WHEN cnt = 0 THEN 0 
                WHEN cnt = 1 THEN 1
                WHEN cnt = 2 THEN 2
                WHEN cnt = 3 THEN 3
                WHEN cnt = 4 THEN 4
                WHEN cnt >= 5 THEN 5
                END l_score, cnt
        FROM
        (SELECT 'T' l_name, '' l_type, '' l_score, COUNT(res_idx) cnt FROM iv_resume_license WHERE res_idx = {$rIdx} ) dd ) dd
                UNION ALL
                SELECT l_name, l_type, 
                CASE 
                WHEN a1 > 0 THEN 100 
                WHEN a2 > 0 THEN 70
                WHEN a1 = 0 AND a2 = 0 THEN 40
                END l_score, '' cnt
                FROM
                (SELECT res_license_name l_name,
                IFNULL((SELECT a1 FROM report_suitability_license WHERE a2 = res_license_name), 0) l_type,
                IF((SELECT a2 FROM report_suitability_license WHERE a2 = res_license_name) = 0, 1, 0) a1,
                IF((SELECT a2 FROM report_priority_license WHERE a2 = res_license_name) = 0, 1, 0) a2
                FROM iv_resume_license WHERE res_idx = {$rIdx}) a";

        $aRow = $this
            ->query($sql)
            ->getResult();

        if ($aRow == "" || $aRow == null) {
            $aRow = [];
        }

        return $aRow;
    }

    public function setAnalysis($rIdx, $jsonData)
    {
        // $masterDB
        $masterDB = \Config\Database::connect('master');
        //트랜잭션 start
        $masterDB->transBegin();

        $masterDB->table('iv_resume')
            ->set([
                'res_analysis' => $jsonData,
            ])
            ->where('idx', $rIdx)
            ->update();

        // 트랜잭션 end
        if ($masterDB->transStatus() === false) {
            $masterDB->transRollback();
        } else {
            $masterDB->transCommit();
        }

        $masterDB->close();
    }

    public function getResumeScore($appIdx)
    {
        $aRow = [];
        if (!$appIdx) {
            return $aRow;
        }

        $aRow = $this
            ->join('iv_applier', 'iv_applier.res_idx = iv_resume.idx', 'left')
            ->where([
                'iv_applier.idx' => $appIdx
            ]);

        return $aRow;
    }

    public function getResumeSpecAvg($appIdx)
    {
        $aRow = [];
        if (!$appIdx) {
            return $aRow;
        }

        $sql = "SELECT iv_resume.idx, iv_resume_category.`job_idx`, iv_resume.res_analysis FROM iv_resume
                LEFT JOIN iv_resume_category
                ON iv_resume.idx = iv_resume_category.res_idx
                WHERE iv_resume_category.`job_idx` = (SELECT iv_resume_category.`job_idx` FROM iv_resume
                LEFT JOIN iv_resume_category
                ON iv_resume.idx = iv_resume_category.res_idx
                WHERE iv_resume.idx = (SELECT res_idx FROM iv_applier WHERE idx = {$appIdx}))";

        $aRow = $this
            ->query($sql)
            ->getResult();

        if ($aRow == "" || $aRow == null) {
            $aRow = [];
        }

        return $aRow;
    }

    public function daysInBullder(int $iDays = 1) // 오늘 - iDays의 값만
    {
        $timestamp = strtotime("Now");
        $today = date('Y-m-d H:i:s', $timestamp);
        $timestamp = strtotime("-{$iDays} days");
        $beforeDay = date('Y-m-d H:i:s', $timestamp);
        $objQuery = $this
            ->where(['iv_resume.res_reg_date <=' => $today, 'iv_resume.res_reg_date >=' => $beforeDay]);
        return $objQuery;
    }

    public function getMyData(int $iMemIdx)
    {
        $objQuery = (object)[];
        if (!$iMemIdx) {
            return;
        }
        $objQuery = $this
            ->where(['iv_resume.mem_idx' => $iMemIdx, 'iv_resume.delyn' => 'N']);
        return $objQuery;
    }

    public function checkResume(int $iMemIdx, int $iDays): bool
    {
        $boolResult = $this->select(['iv_resume.idx'])->daysInBullder($iDays)->getMyData($iMemIdx)->first();
        return $boolResult ? true : false;
    }
}
