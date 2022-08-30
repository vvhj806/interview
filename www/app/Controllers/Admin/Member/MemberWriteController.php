<?php

namespace App\Controllers\Admin\Member;

use App\Models\{
    MemberModel,
    MemberRecruitCategoryModel,
    MemberRecruitKor,
    RecruitInfoModel,
    KoreaAreaModel,
    RecruitModel,
};

use App\Controllers\Admin\AdminController;

class MemberWriteController extends AdminController
{
    private $backUrlList = '/prime/qna/list';
    public $privacy = ['memName', 'memTel', 'fileSaveName'];
    public function index()
    {
        alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
        exit;
    }

    public function write(string $code = null, int $idx = null)
    {
        $this->commonData();

        if (!$aCacheKoreaarea = cache('koreaarea.each')) {
            $aKoreaarea = [];
            $koreaAreaModel = new KoreaAreaModel();
            $aKoreaarea = $koreaAreaModel->getKoreaArea('interest');
            cache()->save('koreaarea.each', $aKoreaarea, 86400);
            $aCache['koreaarea'] = $aKoreaarea;
            $aCacheKoreaarea = $aKoreaarea;
        }

        if (!$idx) {    //회원등록
            $this->aData['data']['state'] = 'write';
        } else {
            //model
            $memberModel = new MemberModel();
            $aMemberRow = $memberModel
                ->select([
                    'iv_member.idx as memIdx', 'iv_member.com_idx as comIdx',
                    'iv_member.mem_id as memId',  'iv_member.mem_name as memName', 'iv_member.mem_tel as memTel', 'iv_member.mem_type as memType',
                    'iv_member.mem_age as memAge', 'iv_member.mem_gender as memGender', 'iv_member.mem_career as memCareer', 'iv_member.mem_work_state as memWorkState',
                    'iv_member.mem_pay as memPay', 'iv_member.mem_education as memEducation', 'iv_member.mem_address as memAddress', 'iv_member.mem_major as memMajor',
                    'iv_member.mem_personal_type_1 as memPersonalType1', 'iv_member.mem_personal_type_2 as memPersonalType2', 'iv_member.mem_personal_type_3 as memPersonalType3',  'iv_member.mem_personal_type_4 as memPersonalType4', 'iv_member.com_idx as comIdx', 'iv_member.delyn',
                    'iv_member.mem_personal_type_5 as memPersonalType5', 'iv_member.mem_personal_type_6 as memPersonalType6', 'iv_member.mem_personal_type_7 as memPersonalType7',
                    'iv_member.mem_visit_count as memVisitCount', 'iv_member.mem_last_password_date as memLastPasswordDate',
                    'iv_member.mem_address_postcode as memAddressPostcode', 'iv_member.mem_address_detail memAddressDetail', 'iv_member.mem_visit_date as memVisitDate',
                    'iv_file.idx as fileIdx', 'iv_file.file_org_name as fileOrgName', 'iv_file.file_save_name as fileSaveName', 'iv_company.com_name'
                ])
                ->join('iv_file', 'iv_file.idx = iv_member.file_idx_profile', 'left')
                ->join('iv_company', 'iv_company.idx = iv_member.com_idx', 'left')
                ->where(['iv_member.idx' => $idx,])->first();

            if ($aMemberRow['delyn'] === 'Y') {
                foreach ($this->privacy as $val) {
                    $aMemberRow[$val] = '탈퇴한 회원입니다';
                }
            }

            if ($aMemberRow['memPay']) {
                $aMemberRow['memPay'] = str_replace(',', '', $aMemberRow['memPay']);
                $aMemberRow['memPay'] = explode('~', $aMemberRow['memPay']);
            }

            $memberRecruitCategory = new MemberRecruitCategoryModel();
            $memberRecruitKor = new MemberRecruitKor();
            $recruitInfoModel = new RecruitInfoModel();
            $recruitModel = new RecruitModel();

            if ($aMemberRow['memType'] === 'M') {
                $aMemberRow['applyCount'] = $recruitInfoModel->getMyApply($idx)->countAllResults() ?? 0;
                // $aMemberRow['applyCount'] = $recruitInfoModel
                //     ->select("COUNT(*) AS cnt1", '', false)
                //     ->select("COUNT(case when app_share = '1' then 1 end) AS cnt2", '', false)
                //     ->where(['mem_idx' => $idx])
                //     ->findAll();
            } elseif ($aMemberRow['memType'] === 'C') {
                $getRecCnt = $recruitModel->getRecCnt($idx);
            }

            $this->aData['data']['state'] = 'update';
            $this->aData['data']['list'] = $aMemberRow;

            foreach ($memberRecruitCategory->getJoinType('M', $idx) as $val) {
                $this->aData['data']['category'][] = $val['job_idx'];
            }

            foreach ($memberRecruitKor->getJoinType('M', $idx) as $val) {
                $this->aData['data']['myArea'][] = $val['kor_area_idx'];
            }
        }

        $this->aData['data']['code'] = $code;
        $this->aData['data']['area'] = $aCacheKoreaarea;
        $this->aData['data']['recCnt'] = $getRecCnt[0]['recCnt'] ?? '';

        $this->aData['data']['education'] = $this->globalvar->aConfig['recruit']['education'];

        // view
        $this->header();
        $this->nav();
        echo view('prime/member/write', $this->aData);
        $this->footer();
    }
}
