<?php

namespace App\Controllers\Interview\My\recruit_info;

use Config\Services;
use App\Controllers\Interview\WwwController;
use App\Models\{RecruitInfoModel, ApplierModel};
use CodeIgniter\I18n\Time;
use App\Libraries\{
    TimeLib
};

class RecruitInfoController extends WwwController
{
    private $backUrlList = '/';

    public function recruitInfoList(string $type)
    {
        // data init
        $this->commonData();
        if (!in_array($type, ['completed', 'again'])) {
            alert_back($this->globalvar->aMsg['error1']);
            exit;
        }
        $iMemIdx = $this->aData['data']['session']['idx'];
        $this->encrypter = Services::encrypter();
        $recruitInfoModel = new RecruitInfoModel();
        $timeLib = new TimeLib();
        $recruitInfoModel // 공통
            ->select([
                'iv_recruit.idx as recIdx',
                'iv_recruit_info.idx as recInfoIdx',
                'iv_recruit.rec_title as recTitle',
                'iv_recruit.rec_start_date as recStartDate',
                'iv_company.com_name as comName',
                'config_again_request.idx as againReqIdx'
            ])
            ->getList($iMemIdx);

        if ($type === 'completed') { // 지원완료
            $recruitInfoModel
                ->select([
                    'iv_korea_area.area_depth_text_1 as areaDepth1',
                    'iv_korea_area.area_depth_text_2 as areaDepth2',
                    'iv_recruit.rec_career as recCareer',
                    'iv_recruit.rec_end_date as recEndDate',
                    'iv_applier.app_type as appType'
                ])
                ->join('iv_applier', 'iv_applier.idx = iv_recruit_info.app_idx', 'inner')
                ->join('config_again_request', 'config_again_request.rec_info_idx = iv_recruit_info.idx', 'left')
                ->join('iv_korea_area', 'iv_korea_area.idx = iv_recruit.kor_area_idx', 'left')
                ->where([
                    'res_info_ing_mem' => 'C'
                ]);
        } else if ($type === 'again') { // 재응시요청
            $recruitInfoModel
                ->select([
                    'config_again_request.ag_req_com as reCom',
                    'config_again_request.ag_req_stat as ingCom',
                    'config_again_request.ag_req_reason as textMem',
                    'iv_recruit_info.res_info_re_reg_date as againDate',
                    'iv_recruit_info.res_info_re_end_date as endDate',
                    'iv_interview.inter_question as queCount'
                ])
                ->join('iv_interview', 'iv_interview.rec_idx = iv_recruit.idx', 'left')
                ->join('config_again_request', 'config_again_request.rec_info_idx = iv_recruit_info.idx', 'inner')
                ->where([
                    'res_info_ing_mem' => 'C'
                ]);
        }

        $aList = $recruitInfoModel->paginate(5, $type); // 공통

        if ($type === 'completed') {
            foreach ($aList as $key => $val) {
                $aList[$key]['recInfoIdx'] = base64url_encode($this->encrypter->encrypt(json_encode($val['recInfoIdx'])));
                if ($val['recCareer'] === 'N') {
                    $aList[$key]['recCareer'] = '신입';
                } else if ($val['recCareer'] === 'C') {
                    $aList[$key]['recCareer'] = '경력';
                } else {
                    $aList[$key]['recCareer'] = '경력무관';
                }

                if ($val['areaDepth2']) {
                    $aList[$key]['areaDepth1'] .= ".{$val['areaDepth2']}";
                }

                if ($val['recEndDate']) {
                    $aList[$key]['recEndDate'] = $timeLib->makeDay($val['recEndDate']);
                }
            }
        } else if ($type === 'again') {
            foreach ($aList as $key => $val) {
                $aList[$key]['recInfoIdx'] = base64url_encode($this->encrypter->encrypt(json_encode($val['recInfoIdx'])));
                if ($val['reCom'] === 'Y') {
                    $aList[$key]['hrState'] = '확인함';
                    $aList[$key]['hrStateCode'] = 'st02';
                    if ($val['ingCom'] === 'Y') {
                        $aList[$key]['hrState'] = '요청';
                        $aList[$key]['hrStateCode'] = 'st03';
                        if ($val['endDate'] < date('Ymd')) {
                            $aList[$key]['hrState'] = '마감';
                            $aList[$key]['hrStateCode'] = 'st04';
                        }
                    } else if ($val['reCom'] === 'N') {
                        $aList[$key]['hrState'] = '요청 거절';
                        $aList[$key]['hrStateCode'] = 'st04';
                    }
                } else {
                    $aList[$key]['hrState'] = '확인 대기 중';
                    $aList[$key]['hrStateCode'] = 'st01';
                }
                $aList[$key]['queCount'] = count(explode(',', $val['queCount']));

                unset($aList[$key]['reCom']);
                unset($aList[$key]['ingCom']);
            }
        }

        $this->aData['data']['list'] = $aList;
        $this->aData['data']['pager'] = $recruitInfoModel->pager;

        $this->header();
        echo view("www/my/recruit_info/{$type}", $this->aData);
        echo view("www/my/recruit_info/modal", $this->aData);
        $this->footer(['recruit_info']);
    }

    public function deleteAction()
    {
        // data init
        $this->commonData();
        $this->encrypter = Services::encrypter();

        $strRecInfoIdx = $this->request->getPost('recInfoIdx') ?? '';

        if (!$strRecInfoIdx) {
            alert_back($this->globalvar->aMsg['error2']);
            exit;
        }

        $iRecInfoIdx = $this->encrypter->decrypt(base64url_decode($strRecInfoIdx)); //복호화
        $iRecInfoIdx = str_replace('"', '', $iRecInfoIdx);

        $result = $this->masterDB->table('iv_recruit_info')
            ->set([
                'res_info_ing_mem' => 'I'
            ])
            ->where('idx', $iRecInfoIdx)
            ->update();
        if ($result) {
            alert_back($this->globalvar->aMsg['success4']);
            exit;
        } else {
            alert_back($this->globalvar->aMsg['error2']);
            exit;
        }
    }

    public function againRequest()
    {
        // data init
        $this->commonData();
        $this->encrypter = Services::encrypter();

        $strRecInfoIdx = $this->request->getPost('recInfoIdx') ?? '';
        $strMemText = $this->request->getPost('memText') ?? '';

        if (!$strRecInfoIdx) {
            alert_back($this->globalvar->aMsg['error1']);
            exit;
        }

        $iRecInfoIdx = $this->encrypter->decrypt(base64url_decode($strRecInfoIdx)); //복호화
        $iRecInfoIdx = str_replace('"', '', $iRecInfoIdx);

        $recruitInfoModel = new RecruitInfoModel();
        $aList = $recruitInfoModel
            ->select(['iv_applier.app_type', 'iv_recruit.com_idx'])
            ->where([
                'iv_recruit_info.idx' => $iRecInfoIdx,
                'iv_recruit_info.delyn' => 'N',
                'iv_applier.delyn' => 'N'
            ])
            ->join('iv_applier', 'iv_applier.idx = iv_recruit_info.app_idx', 'inner')
            ->join('iv_recruit', 'iv_recruit.idx = iv_recruit_info.rec_idx', 'inner')
            ->first();

        if ($aList['app_type'] != 'C') {
            alert_back($this->globalvar->aMsg['error1']);
            exit;
        }

        $result = $this->masterDB->table('config_again_request')
            ->set([
                'rec_info_idx' => $iRecInfoIdx, // info idx
                'com_idx' => $aList['app_type'], // 회사idx
                'ag_req_reason' => $strMemText, // 재응시 사유 text
            ])
            ->set(['ag_req_reg_date' => 'NOW()'], '', false) // 재응시 요청일
            ->insert();
        if ($result) {
            alert_back($this->globalvar->aMsg['success4']);
            exit;
        } else {
            alert_back($this->globalvar->aMsg['error3']);
            exit;
        }
    }
}
