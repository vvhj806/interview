<?php

namespace App\Controllers\Admin\Member;

use App\Models\MemberModel;
use App\Controllers\Admin\AdminController;

use App\Libraries\EncryptLib;

class MemberActionController extends AdminController
{
    private $backUrlList = '/prime/main';
    public function index()
    {
        alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
        exit;
    }

    public function memberAction()
    {
        $strPostCase = $this->request->getPost('postCase');
        $iMemIdx = $this->request->getPost('memIdx');
        $strBackUrl = $this->request->getPost('backUrl');
        $strMemType = $this->request->getPost('memType');
        $strMemAge = $this->request->getPost('memAge');
        $strMemWorkState = $this->request->getPost('memWorkState');
        $strMemGender = $this->request->getPost('memGender');
        $strMemCareer = $this->request->getPost('memCareer');
        $strMemEducation = $this->request->getPost('memEducation');
        $strMemAddressPostcode = $this->request->getPost('memAddressPostcode');
        $strMemAddress = $this->request->getPost('memAddress');
        $strMemAddressDetail = $this->request->getPost('memAddressDetail');
        $strMemMajor = $this->request->getPost('memMajor');
        $strMemPersonalType1 = $this->request->getPost('memPersonalType1');
        $strMemPersonalType2 = $this->request->getPost('memPersonalType2');
        $strMemPersonalType3 = $this->request->getPost('memPersonalType3');
        $strMemPersonalType4 = $this->request->getPost('memPersonalType4');
        $strMemPersonalType5 = $this->request->getPost('memPersonalType5');
        $iMemPay = '';
        $iMemPayLeft = $this->request->getPost('left');
        $iMemPayRight = $this->request->getPost('right');
        $aJob = $this->request->getPost('depth1');
        $aArea = $this->request->getPost('area');
        $iComIdx = $this->request->getPost('comIdx');
        //INSERT DATA
        $strMemId = $this->request->getPost('memId');
        $strMemPass = $this->request->getPost('memPass');
        $strMemName = $this->request->getPost('memName');
        $strMemTel = $this->request->getPost('memTel');


        $backUrlList = '/prime/member/' . $strMemType . '/list';
        if (!$strMemType) {
            alert_url($this->globalvar->aMsg['error1'], $strBackUrl);
            exit;
        }
        if (!in_array($strMemType, ['M', 'A', 'L', 'C']) || !in_array($strMemWorkState, ['Y', 'N', ''])) {
            alert_url($this->globalvar->aMsg['error1'], $strBackUrl);
            exit;
        }

        if (!in_array($strMemPersonalType1, ['Y', 'N', '']) || !in_array($strMemPersonalType2, ['Y', 'N', '']) || !in_array($strMemPersonalType3, ['Y', 'N', '']) || !in_array($strMemPersonalType4, ['Y', 'N', '']) || !in_array($strMemPersonalType5, ['Y', 'N', ''])) {
            alert_url($this->globalvar->aMsg['error1'], $strBackUrl);
            exit;
        }

        if ($iMemPayLeft && $iMemPayRight) {
            $iMemPayLeft = number_format($iMemPayLeft);
            $iMemPayRight = number_format($iMemPayRight);
            $iMemPay = "{$iMemPayLeft}~{$iMemPayRight}";
        }

        $this->commonData();

        $encryptLib = new EncryptLib();
        $strMemPass = $encryptLib->makePassword($strMemPass);

        $insertData = [
            'mem_id' => $strMemId,
            'mem_password' => $strMemPass,
            'mem_name' => $strMemName,
            'mem_tel' => $strMemTel
        ];

        $updateData = [
            'mem_type' => $strMemType,
            'mem_age' => $strMemAge,
            'mem_work_state' => $strMemWorkState,
            'mem_gender' => $strMemGender,
            'mem_career' => $strMemCareer,
            'mem_pay' => $iMemPay,
            'mem_education' => $strMemEducation,
            'mem_address_postcode' => $strMemAddressPostcode,
            'mem_address' => $strMemAddress,
            'mem_address_detail' => $strMemAddressDetail,
            'mem_major' => $strMemMajor,
            'mem_personal_type_1' => $strMemPersonalType1,
            'mem_personal_type_2' => $strMemPersonalType2,
            'mem_personal_type_3' => $strMemPersonalType3,
            'mem_personal_type_4' => $strMemPersonalType4,
            'mem_personal_type_5' => $strMemPersonalType5,
            'com_idx' => $iComIdx,
            'mem_tel' => $strMemTel,
        ];
        //트랜잭션 start
        $this->masterDB->transBegin();

        if ($strPostCase == 'member_update') {
            if (!$iMemIdx) {
                alert_url($this->globalvar->aMsg['error1'], $strBackUrl);
                exit;
            }
            $this->masterDB->table('iv_member')
                ->set($updateData)
                ->set(['mem_mod_date' => 'NOW()'], '', false)
                ->where(['idx' => $iMemIdx])
                ->update();

            if ($aJob) {
                // iv_member_recruit_category delyn = 'Y'
                $this->masterDB->table('iv_member_recruit_category')
                    ->set(['delyn' => 'Y'])
                    ->where('mem_idx', $iMemIdx)
                    ->update();
                foreach ($aJob as $val) {
                    $aMemRecCate[] = [
                        'mem_idx' => $iMemIdx,
                        'job_idx' => $val,
                        'mem_rec_type' => 'M',
                    ];
                }
                $this->masterDB->table('iv_member_recruit_category')
                    ->insertBatch($aMemRecCate);
            }

            if ($aArea) {
                // iv_member_recruit_kor delyn = 'Y'
                $this->masterDB->table('iv_member_recruit_kor')
                    ->set(['delyn' => 'Y'])
                    ->where('mem_idx', $iMemIdx)
                    ->update();
                foreach ($aArea as $val) {
                    $aMemRecKor[] = [
                        'mem_idx' => $iMemIdx,
                        'kor_area_idx' => $val,
                        'mem_rec_type' => 'M',
                    ];
                }
                $this->masterDB->table('iv_member_recruit_kor')
                    ->insertBatch($aMemRecKor);
            }
        } else if ($strPostCase == 'member_write') {
            $this->masterDB->table('iv_member')
                ->set($insertData)
                ->set($updateData)
                ->set(['mem_reg_date' => 'NOW()'], '', false)
                ->insert();
        } else {
            alert_back($this->globalvar->aMsg['error1'], $strBackUrl);
            exit;
        }

        // 트랜잭션 end
        if ($this->masterDB->transStatus() === false) {
            $this->masterDB->transRollback();
            return alert_back($this->globalvar->aMsg['error3']);
        } else {
            $this->masterDB->transCommit();
            return alert_url($this->globalvar->aMsg['success1'], $strBackUrl);
        }
    }

    public function memberDeleteAction()
    {
        $strPostCase = $this->request->getPost('postCase');
        $iMemIdx = $this->request->getPost('memIdx');
        $strBackUrl = $this->request->getPost('backUrl');

        if (!$strBackUrl || !$iMemIdx || $strPostCase != 'member_delete') {
            alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
            exit;
        }

        $this->commonData();

        //트랜잭션 start
        $this->masterDB->transBegin();

        $this->masterDB->table('iv_member')
            ->set('delyn', 'Y')
            ->set(['mem_del_date' => 'NOW()'], '', false)
            ->where('idx', $iMemIdx)
            ->update();

        $this->masterDB->table('iv_member_leave')
            ->set([
                'mem_idx' => $iMemIdx,
                'mem_leave_reason_memo' => '관리자 삭제'
            ])
            ->set(['mem_leave_reg_date' => 'NOW()'], '', false)
            ->insert();

        // 트랜잭션 end
        if ($this->masterDB->transStatus() === false) {
            $this->masterDB->transRollback();
            alert_back($this->globalvar->aMsg['error2']);
            exit;
        } else {
            $this->masterDB->transCommit();
            alert_url($this->globalvar->aMsg['success10'], $strBackUrl != '' ? $strBackUrl : $this->backUrlList);
            exit;
        }
    }
}
