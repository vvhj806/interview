<?php

namespace App\Controllers\Admin\Recruit;

use App\Models\{
    RecruitModel,
    CompanyModel
};
use App\Controllers\Admin\AdminController;

class RecruitActionController extends AdminController
{
    private $backUrlList = '/prime/recruit/list';

    public function write()
    {
        $this->commonData();
        $iComIdx = $this->request->getPost('com_idx'); // 회사번호
        $strRecTitle = $this->request->getPost('rec_title'); // 제목
        $aRecWorkType = $this->request->getPost('rec_work_type'); // 정규직,계약직, 등

        $aRecJobs = $this->request->getPost('depth3'); // 직무 카테고리
        $aRecArea = $this->request->getPost('rec_area'); // 지역 카테고리
        $iRecEndDate = $this->request->getPost('rec_end_date'); // 종료일
        $iRecEndDate = str_replace("-", "", $iRecEndDate);
        $iRecEdu = $this->request->getPost('rec_education'); // 학력

        $strRecCareer = $this->request->getPost('rec_career'); // 경력
        $iRecCareer = $this->request->getPost('rec_career_month') ?? null;

        $strRecPay = $this->request->getPost('rec_pay_type'); //돈
        $iRecPay = $this->request->getPost('rec_pay_unit') ?? null;

        $iRecApply = $this->request->getPost('rec_apply'); //지원유형
        $aRecInterIdx = $this->request->getPost('rec_inter') ?? '';

        $strProfileFile = $this->request->getPost('profileFile'); // 썸네일
        $strFilePath = $this->request->getPost('filePath');
        $strFileSize = $this->request->getPost('fileSize');

        $strRecInfo = $this->request->getPost('rec_info') ?? ''; //공고 내용

        if (array_intersect($aRecWorkType, ['0', '1', '3', '5'])) {
            $aRecWorkType = implode(',', $aRecWorkType);
        } else {
            alert_back($this->globalvar->aMsg['error1']);
            exit;
        }

        if (in_array($iRecApply, ['C', 'A'])) {
            if (!$aRecInterIdx) {
                alert_back($this->globalvar->aMsg['error1']);
                exit;
            }
        }

        //트랜잭션 start
        $this->masterDB->transBegin();

        $this->masterDB->table('iv_file')
            ->set([
                'file_type' => 'E',
                'file_org_name' => $strProfileFile,
                'file_save_name' => $strFilePath,
                'file_size' => $strFileSize,
            ])
            ->set(['file_reg_date' => 'NOW()'], '', false)
            ->set(['file_mod_date' => 'NOW()'], '', false)
            ->insert();

        $strFileIdx = $this->masterDB->insertID();

        $this->masterDB->table('iv_recruit')
            ->set([
                'com_idx' => $iComIdx,
                'rec_title' => $strRecTitle,
                'rec_work_type' => $aRecWorkType,
                'job_idx' => $aRecJobs[0],
                'kor_area_idx' => $aRecArea[0],
                'rec_end_date' => $iRecEndDate,
                'rec_education' => $iRecEdu,

                'rec_career' => $strRecCareer,
                'rec_career_month' => $iRecCareer,

                'rec_pay_type' => $strRecPay,
                'rec_pay_unit' => $iRecPay,

                'rec_apply' => $iRecApply,

                'file_idx_recruit' => $strFileIdx,

                'rec_info' => $strRecInfo,
                'rec_start_date' => "DATE_FORMAT(NOW(), '%Y-%m-%d')"
            ])
            ->set(['rec_mod_date' => 'NOW()'], '', false)
            ->set(['rec_reg_date' => 'NOW()'], '', false)
            ->insert();
        $recIdx = $this->masterDB->insertID();


        if (in_array($iRecApply, ['C', 'A'])) {
            $this->masterDB->table('iv_interview')
                ->set([
                    'rec_idx' => $recIdx
                ])
                ->whereIn('idx', $aRecInterIdx)
                ->update();
        }

        foreach ($aRecJobs as $val) {
            $this->masterDB->table('iv_member_recruit_category')
                ->set([
                    'rec_idx' => $recIdx,
                    'job_idx' => $val,
                    'mem_rec_type' => 'R',
                    'delyn' => 'N'
                ])
                ->insert();
        }

        foreach ($aRecArea as $val) {
            $this->masterDB->table('iv_member_recruit_kor')
                ->set([
                    'rec_idx' => $recIdx,
                    'kor_area_idx' => $val,
                    'mem_rec_type' => 'R',
                    'delyn' => 'N'
                ])
                ->insert();
        }

        // 트랜잭션 end
        if ($this->masterDB->transStatus() === false) {
            $this->masterDB->transRollback();
            alert_back($this->globalvar->aMsg['error1']);
            exit;
        } else {
            $this->masterDB->transCommit();
            alert_url($this->globalvar->aMsg['success1'], '/prime/recruit/list');
            exit;
        }
    }

    public function update(int $recIdx)
    {

        $this->commonData();

        $strRecTitle = $this->request->getPost('rec_title'); // 제목
        $aRecWorkType = $this->request->getPost('rec_work_type'); // 정규직,계약직, 등

        $aRecJobs = $this->request->getPost('depth3'); // 직무 카테고리
        $aRecArea = $this->request->getPost('rec_area'); // 지역 카테고리
        $iRecEndDate = $this->request->getPost('rec_end_date'); // 종료일
        $iRecEndDate = str_replace("-", "", $iRecEndDate);
        $iRecEdu = $this->request->getPost('rec_education'); // 학력

        $strRecCareer = $this->request->getPost('rec_career'); // 경력
        $iRecCareer = $this->request->getPost('rec_career_month') ?? null;

        $strRecPay = $this->request->getPost('rec_pay_type'); //돈
        $iRecPay = $this->request->getPost('rec_pay_unit') ?? null;

        $iRecApply = $this->request->getPost('rec_apply'); //지원유형
        $aRecInterIdx = $this->request->getPost('rec_inter') ?? '';

        $strProfileFile = $this->request->getPost('profileFile'); // 썸네일
        $strFilePath = $this->request->getPost('filePath');
        $strFileSize = $this->request->getPost('fileSize');

        $strRecInfo = $this->request->getPost('rec_info') ?? ''; //공고 내용


        if (array_intersect($aRecWorkType, ['0', '1', '3', '5'])) {
            $aRecWorkType = implode(',', $aRecWorkType);
        } else {
            alert_back($this->globalvar->aMsg['error1']);
            exit;
        }

        if (in_array($iRecApply, ['C', 'A'])) {
            if (!$aRecInterIdx) {
                alert_back($this->globalvar->aMsg['error1']);
                exit;
            }
        }

        //트랜잭션 start
        $this->masterDB->transBegin();

        if ($strProfileFile && $strFilePath && $strFileSize) {
            $this->masterDB->table('iv_file')
                ->set([
                    'file_type' => 'E',
                    'file_org_name' => $strProfileFile,
                    'file_save_name' => $strFilePath,
                    'file_size' => $strFileSize,
                ])
                ->set(['file_reg_date' => 'NOW()'], '', false)
                ->set(['file_mod_date' => 'NOW()'], '', false)
                ->insert();

            $iFileIdx = $this->masterDB->insertID();

            $readyDB = $this->masterDB->table('iv_recruit')
                ->set([
                    'file_idx_recruit' => $iFileIdx
                ]);
        } else {
            $iProfileFileIdx = $this->request->getPost('profileIdx'); // 기존 썸네일 idx
            $readyDB = $this->masterDB->table('iv_recruit')
                ->set([
                    'file_idx_recruit' => $iProfileFileIdx
                ]);
        }

        $readyDB
            ->set([
                'rec_title' => $strRecTitle,
                'rec_work_type' => $aRecWorkType,
                'job_idx' => $aRecJobs[0],
                'kor_area_idx' => $aRecArea[0],
                'rec_end_date' => $iRecEndDate,
                'rec_education' => $iRecEdu,

                'rec_career' => $strRecCareer,
                'rec_career_month' => $iRecCareer,

                'rec_pay_type' => $strRecPay,
                'rec_pay_unit' => $iRecPay,

                'rec_apply' => $iRecApply,

                'rec_info' => $strRecInfo,
                'rec_start_date' => "DATE_FORMAT(NOW(), '%Y-%m-%d')",

            ])
            ->set(['rec_mod_date' => 'NOW()'], '', false)
            ->set(['rec_reg_date' => 'NOW()'], '', false)
            ->where(['idx' => $recIdx])
            ->update();

        if (in_array($iRecApply, ['C', 'A'])) {

            $this->masterDB->table('iv_interview')
                ->set([
                    'rec_idx' => null
                ])
                ->where('rec_idx', $recIdx)
                ->update();

            $this->masterDB->table('iv_interview')
                ->set([
                    'rec_idx' => $recIdx
                ])
                ->whereIn('idx', $aRecInterIdx)
                ->update();
        }

        $this->masterDB->table('iv_member_recruit_category')
            ->set(['delyn' => 'Y'])
            ->where('rec_idx', $recIdx)
            ->update();
        foreach ($aRecJobs as $val) {
            $this->masterDB->table('iv_member_recruit_category')
                ->set([
                    'rec_idx' => $recIdx,
                    'job_idx' => $val,
                    'mem_rec_type' => 'R',
                    'delyn' => 'N'
                ])
                ->insert();
        }

        $this->masterDB->table('iv_member_recruit_kor')
            ->set(['delyn' => 'Y'])
            ->where('rec_idx', $recIdx)
            ->update();
        foreach ($aRecArea as $val) {
            $this->masterDB->table('iv_member_recruit_kor')
                ->set([
                    'rec_idx' => $recIdx,
                    'kor_area_idx' => $val,
                    'mem_rec_type' => 'R',
                    'delyn' => 'N'
                ])
                ->insert();
        }

        // 트랜잭션 end
        if ($this->masterDB->transStatus() === false) {
            $this->masterDB->transRollback();
            alert_back($this->globalvar->aMsg['error3']);
            exit;
        } else {
            $this->masterDB->transCommit();
            alert_back($this->globalvar->aMsg['success1']);
            exit;
        }
    }

    public function accept()
    {
        $this->commonData();
        $aRecIdx = $this->request->getPost('recIdx');

        if (!$aRecIdx) {
            alert_back($this->globalvar->aMsg['error1']);
            exit;
        }

        //트랜잭션 start
        $this->masterDB->transBegin();

        $this->masterDB->table('iv_recruit')
            ->set([
                'rec_stat' => 'Y',
            ])
            ->whereIn('idx', $aRecIdx)
            ->update();

        //트랜잭션 end
        if ($this->masterDB->transStatus() === false) {
            $this->masterDB->transRollback();
            alert_back($this->globalvar->aMsg['error3']);
            exit;
        } else {
            $this->masterDB->transCommit();
            alert_back($this->globalvar->aMsg['success1']);
            exit;
        }
    }
}
