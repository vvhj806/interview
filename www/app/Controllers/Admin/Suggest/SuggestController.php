<?php

namespace App\Controllers\Admin\Suggest;

use App\Models\{
    CompnaySuggestModel,
    ConfigCompnaySuggestModel,
    CompanySuggestApplicantModel,
    ConfigAgainRequestModel
};
use App\Controllers\Admin\AdminController;

class SuggestController extends AdminController
{
    public function mList()
    {
        //get
        $iGetMemIdx = $this->request->getGet('memIdx') ?? '';
        $strSearchText = $this->request->getGet('searchText') ?? '';
        $strUserType = $this->request->getGet('userType') ?? 'user';
        $strOrder = $this->request->getGet('order') ?? 'idx';
        $strOrderType = $this->request->getGet('orderType') ?? 'DESC';
        $strAgainType = $this->request->getGet('againType') ?? '';
        $aList = [];
        //init
        $this->commonData();
        $phonePattern = '/^(010|011|016|017|018|019)[0-9]{3,4}[0-9]{4}$/';

        //model
        $compnaySuggestModel = new CompnaySuggestModel();
        $configAgainRequestModel = new ConfigAgainRequestModel();

        $again = '';
        if ($strAgainType == 'again') {
            $again = 'config_again_request.ag_req_com is not';
        } else if ($strAgainType == 'noAgain') {
            $again = 'config_again_request.ag_req_com';
        }

        $compnaySuggestModel
            ->select(['iv_company_suggest.idx AS sugIdx'])->where('iv_company_suggest.delyn', 'N');

        if ($strUserType === 'user') {
            $compnaySuggestModel
                ->select([
                    'iv_member.idx AS memIdx', 'iv_member.mem_name AS memName', 'iv_member.mem_id AS memId',
                    'iv_member.mem_tel AS memTel', 'iv_company_suggest.sug_reg_date AS sugRegDate',
                    'config_company_suggest.cfg_sug_mem_app_stat AS memStat', 'config_company_suggest.idx AS lowSugIdx'
                ])
                ->configSuggestBuilder()->configRequestBuilder(true);
            if ($again != '') {
                $compnaySuggestModel->where($again, null);
            }
            if (is_numeric($strSearchText)) {
                if (preg_match($phonePattern, $strSearchText)) { // 폰번호면 폰
                    $compnaySuggestModel->where(['iv_member.mem_tel' => $strSearchText]);
                } else {
                    $compnaySuggestModel // 그냥 숫자면 memtel 검색
                        ->groupStart()
                        ->orLike('iv_member.mem_tel', $strSearchText, 'both')
                        ->groupEnd();
                }
            } else { // 스트링일시 id, name 검색
                // return;
                $compnaySuggestModel
                    ->groupStart()
                    ->orLike('iv_member.mem_id', $strSearchText, 'both')
                    ->orLike('iv_member.mem_name', $strSearchText, 'both')
                    ->groupEnd();
            }
            if ($iGetMemIdx) {
                $compnaySuggestModel
                    ->where(['iv_member.idx' => $iGetMemIdx]);
            }
        } else if ($strUserType === 'notUser') {
            $compnaySuggestModel
                ->select([
                    'iv_company_suggest_applicant.sug_app_name AS memName', 'iv_company_suggest_applicant.sug_app_phone AS memTel',
                    'iv_company_suggest.sug_reg_date AS sugRegDate', 'iv_company_suggest_applicant.app_idx AS memStat',
                    'iv_company_suggest_applicant.idx AS lowSugIdx'
                ])
                ->applicantSuggestBuilder()->applicantRequestBuilder(true);
            if ($again != '') {
                $compnaySuggestModel->where($again, null);
            }
            if (is_numeric($strSearchText)) {
                if (preg_match($phonePattern, $strSearchText)) { // 폰번호면 폰
                    $compnaySuggestModel->where(['iv_company_suggest_applicant.sug_app_phone' => $strSearchText]);
                } else {
                    $compnaySuggestModel // 그냥 숫자면 memtel 검색
                        ->groupStart()
                        ->orLike('iv_company_suggest_applicant.sug_app_phone', $strSearchText, 'both')
                        ->groupEnd();
                }
            } else { // 스트링일시 name 검색
                $compnaySuggestModel
                    ->groupStart()
                    ->orLike('iv_company_suggest_applicant.sug_app_name', $strSearchText, 'both')
                    ->groupEnd();
            }
        }

        if ($strSearchText) {
            $aList = $compnaySuggestModel->paginate(10, $strUserType);

            foreach ($aList as $key => $val) {
                $strMsg = '확인중'; // 지원자 상태
                if (is_numeric($val['memStat']) || $val['memStat'] === 'Y') {
                    $strMsg = '수락함';
                } else if ($val['memStat'] === 'N') {
                    $strMsg = '거절함';
                }
                $aList[$key]['memStat'] = $strMsg;

                $aList[$key]['request'] = $configAgainRequestModel->getAgainMsg($val['ag_req_com'], $val['ag_req_stat']);
                unset($aList[$key]['ag_req_com'], $aList[$key]['ag_req_stat']);
            }
        }

        $this->aData['data']['getMemIdx'] = $iGetMemIdx;
        $this->aData['data']['searchText'] = $strSearchText;
        $this->aData['data']['userType'] = $strUserType;
        $this->aData['data']['againType'] = $strAgainType;
        $this->aData['data']['order'] = ['column' => $strOrder, 'type' => $strOrderType];
        $this->aData['data']['pager'] = $compnaySuggestModel->pager;
        $this->aData['data']['count'] = $aList ? $compnaySuggestModel->pager->getTotal($strUserType) : '';
        $this->aData['data']['suggestList'] = $aList;

        // view
        $this->header();
        $this->nav();
        echo view('prime/suggest/mlist', $this->aData);
        $this->footer();
    }

    public function mWrite($strUserType, $iIdx)
    {
        // init
        $this->commonData();

        //model
        $compnaySuggestModel = new CompnaySuggestModel();
        $compnaySuggestModel
            ->selectorAdminWrite()->select([
                'config_again_request.ag_req_reason', 'config_again_request.ag_req_reg_date', 'config_again_request.ag_req_com', 'config_again_request.ag_req_stat'
            ]);
        if ($strUserType === 'user') {
            $compnaySuggestModel
                ->select([
                    'config_company_suggest.mem_idx AS memIdx', 'config_company_suggest.app_idx AS appIdx',
                    'config_company_suggest.cfg_sug_mem_app_stat AS appStat', 'config_company_suggest.cfg_sug_mem_app_massage AS appMsg',
                    'config_company_suggest.cfg_sug_mem_app_type AS appType', 'config_company_suggest.cfg_sug_address AS address',
                    'config_company_suggest.cfg_sug_promise_date AS promiseDate', 'config_company_suggest.app_idx_received AS recAppIdx',
                ])
                ->configSuggestBuilder()->configRequestBuilder(true)
                ->where(['config_company_suggest.idx' => $iIdx]);
        } else if ($strUserType === 'notUser') {
            $compnaySuggestModel
                ->select([
                    'iv_company_suggest_applicant.app_idx AS appIdx', 'iv_company_suggest_applicant.sug_app_title AS appTitle',
                    'iv_company_suggest_applicant.sug_app_name AS memName', 'iv_company_suggest_applicant.sug_app_phone AS memTel'
                ])
                ->applicantSuggestBuilder()->applicantRequestBuilder(true)
                ->where(['iv_company_suggest_applicant.idx' => $iIdx]);
        }

        $aList = $compnaySuggestModel->orderBy('config_again_request.idx', 'desc')->first();
        $this->aData['data']['suggestList'] = $aList;
        $this->aData['data']['suggestIdx'] = $iIdx;
        $this->aData['data']['userType'] = $strUserType;
        // view
        $this->header();
        $this->nav();
        echo view('prime/suggest/mwrite', $this->aData);
        $this->footer();
    }

    public function mAction($strUserType, $iIdx)
    {
        // init
        $this->commonData();

        if ($strUserType === 'user') {
            //post
            $cfg_sug_mem_app_stat = $this->request->getPost('cfg_sug_mem_app_stat'); // 제안 지원자 확인 상태값
            $cfg_sug_mem_app_massage = $this->request->getPost('cfg_sug_mem_app_massage'); // 메세지 내용
            $cfg_sug_mem_app_type = $this->request->getPost('cfg_sug_mem_app_type'); // 거절사유
            $cfg_sug_address = $this->request->getPost('cfg_sug_address'); // 면접볼장소
            $cfg_sug_promise_date = $this->request->getPost('cfg_sug_promise_date'); // 면접볼날짜 or 첫출근날짜

            $readyDB = $this->masterDB->table('config_company_suggest')
                ->set([
                    'cfg_sug_mem_app_stat' => $cfg_sug_mem_app_stat, 'cfg_sug_mem_app_massage' => $cfg_sug_mem_app_massage,
                    'cfg_sug_mem_app_type' => $cfg_sug_mem_app_type, 'cfg_sug_address' => $cfg_sug_address,
                    'cfg_sug_promise_date' => $cfg_sug_promise_date
                ]);
        } else if ($strUserType === 'notUser') {
            //post
            $sug_app_title = $this->request->getPost('sug_app_title');
            $app_idx = $this->request->getPost('app_idx');
            $sug_app_name = $this->request->getPost('sug_app_name');
            $sug_app_phone = $this->request->getPost('sug_app_phone');

            $readyDB = $this->masterDB->table('iv_company_suggest_applicant')
                ->set([
                    'sug_app_title' => $sug_app_title, 'app_idx' => $app_idx,
                    'sug_app_name' => $sug_app_name, 'sug_app_phone' => $sug_app_phone,
                ])
                ->set(['sug_app_mod_date' => 'NOW()'], '', false);
        }

        $result = $readyDB->where('idx', $iIdx)->update();

        if ($result) {
            alert_back($this->globalvar->aMsg['success1']);
            exit;
        } else {
            alert_back($this->globalvar->aMsg['error3']);
            exit;
        }
    }

    public function mAgainAction($strUserType, $iIdx)
    {
        // init
        $this->commonData();

        $reason = $this->request->getPost('reason');
        if ($reason == '' || $reason == null) {
            $reason = '관리자 재응시요청';
        }

        if ($strUserType === 'user') {
            $readyDB = $this->masterDB->table('config_again_request')
                ->set([
                    'config_sug_idx' => $iIdx,
                    'ag_req_reason' => $reason
                ])
                ->set(['ag_req_reg_date' => 'NOW()'], '', false);
        } else if ($strUserType === 'notUser') {
            $readyDB = $this->masterDB->table('config_again_request')
                ->set([
                    'sug_app_idx' => $iIdx,
                    'ag_req_reason' => $reason
                ])
                ->set(['ag_req_reg_date' => 'NOW()'], '', false);
        } else if ($strUserType === 'recruit') {
            $readyDB = $this->masterDB->table('config_again_request')
                ->set([
                    'rec_info_idx' => $iIdx,
                    'ag_req_reason' => $reason
                ])
                ->set(['ag_req_reg_date' => 'NOW()'], '', false);
        }

        $result = $readyDB->insert();

        if ($result) {
            alert_back($this->globalvar->aMsg['success5']);
            exit;
        } else {
            alert_back($this->globalvar->aMsg['error3']);
            exit;
        }
    }

    public function cList()
    {
        //get
        $strSearchText = $this->request->getGet('searchText') ?? '';
        $strOrder = $this->request->getGet('order') ?? 'sugIdx';
        $strOrderType = $this->request->getGet('orderType') ?? 'DESC';
        //init
        $this->commonData();
        //model
        $compnaySuggestModel = new CompnaySuggestModel();

        if ($strSearchText) {
            if (is_numeric($strSearchText)) {
                $compnaySuggestModel // 숫자면 idx검색
                    ->where(['iv_company_suggest.idx' => $strSearchText]);
            } else {
                $compnaySuggestModel // 숫자면 idx검색
                    ->groupStart()
                    ->like(['iv_company.com_name' => $strSearchText])
                    ->groupEnd();
            }
        }

        $compnaySuggestModel
            ->select([
                'iv_company_suggest.idx AS sugIdx', 'iv_company_suggest.sug_type AS sugType', 'iv_company_suggest.rec_idx AS recIdx',
                'iv_company_suggest.sug_end_date AS sugEndDate', 'iv_company.com_name AS comName', 'iv_company.idx AS comIdx',
            ])
            ->select('COUNT(config_company_suggest.idx) AS conCnt', '', false) // 회원 제안수
            ->select('COUNT(iv_company_suggest_applicant.idx) AS appCnt', '', false) // 비회원 제안수
            ->configSuggestBuilder()->applicantSuggestBuilder()->companyBuilder()
            ->groupBy('sugIdx')->orderBy($strOrder, $strOrderType);

        $aList = $compnaySuggestModel->paginate(10, 'suggest');

        foreach ($aList as $key => $val) {
            $aList[$key]['sugType'] = $compnaySuggestModel->getSuggestTypeMsg($val['sugType']);
        }

        $this->aData['data']['searchText'] = $strSearchText;
        $this->aData['data']['order'] = ['column' => $strOrder, 'type' => $strOrderType];
        $this->aData['data']['pager'] = $compnaySuggestModel->pager;
        $this->aData['data']['count'] = $compnaySuggestModel->pager->getTotal('suggest');
        $this->aData['data']['suggestList'] = $aList;
        // view
        $this->header();
        $this->nav();
        echo view('prime/suggest/clist', $this->aData);
        $this->footer();
    }

    public function cWrite($iIdx = null)
    {
        // init
        $this->commonData();

        //model
        $compnaySuggestModel = new CompnaySuggestModel();
        $configCompnaySuggestModel = new ConfigCompnaySuggestModel();
        $companySuggestApplicantModel = new CompanySuggestApplicantModel();
        $configAgainRequestModel = new ConfigAgainRequestModel();

        $compnaySuggestModel->selectorAdminWrite()->where(['iv_company_suggest.idx' => $iIdx]);

        $aList = $compnaySuggestModel->first();
        $aList['sugStartDate'] = date('Y-m-d', strtotime($aList['sugStartDate']));
        $aList['sugEndDate'] = date('Y-m-d', strtotime($aList['sugEndDate']));

        //회원
        $aConfigList = $configCompnaySuggestModel
            ->select(['iv_member.mem_name AS memName', 'iv_member.mem_Tel AS memTel', 'config_again_request.ag_req_reason', 'config_again_request.idx as ag_req_idx'])
            ->getSendSuggestionsList($iIdx)->memberBuilder()->configRequestBuilder(true)->findAll();
        //비회원
        $aApplicantList = $companySuggestApplicantModel
            ->select(['sug_app_name AS memName', 'sug_app_phone AS memTel', 'iv_company_suggest_applicant.idx AS appSugIdx', 'config_again_request.ag_req_reason', 'config_again_request.idx as ag_req_idx'])
            ->getSendSuggestionsList($iIdx)->applicantRequestBuilder(true)->findAll();

        foreach ($aConfigList as $key => $val) {
            $aConfigList[$key]['againStat'] = $configAgainRequestModel->getAgainMsg($val['ag_req_com'], $val['ag_req_stat']);
            unset($aConfigList[$key]['ag_req_com'], $aConfigList[$key]['ag_req_stat']);
        }
        foreach ($aApplicantList as $key => $val) {
            $aApplicantList[$key]['againStat'] = $configAgainRequestModel->getAgainMsg($val['ag_req_com'], $val['ag_req_stat']);
            unset($aApplicantList[$key]['ag_req_com'], $aApplicantList[$key]['ag_req_stat']);
        }

        $this->aData['data']['suggestList'] = $aList ?? [];
        $this->aData['data']['configList'] = $aConfigList ?? [];
        $this->aData['data']['applicantList'] = $aApplicantList ?? [];

        $this->aData['data']['suggestIdx'] = $iIdx;

        // view
        $this->header();
        $this->nav();
        echo view('prime/suggest/cwrite', $this->aData);
        $this->footer();
    }

    public function cAction($iIdx)
    {
        // init
        $this->commonData();

        //post
        $sug_massage = $this->request->getPost('sug_massage'); // 메세지 내용
        $sug_manager = $this->request->getPost('sug_manager'); // 담당자상태
        $sug_manager_name = $this->request->getPost('sug_manager_name'); // 담당자 이름
        $sug_start_date = $this->request->getPost('sug_start_date'); // 제안 시작일
        $sug_end_date = $this->request->getPost('sug_end_date'); // 제안 종료일

        $sug_start_date = date('Ymd', strtotime($sug_start_date));
        $sug_end_date = date('Ymd', strtotime($sug_end_date));

        $readyDB = $this->masterDB->table('iv_company_suggest')
            ->set([
                'sug_massage' => $sug_massage, 'sug_manager' => $sug_manager, 'sug_manager_name' => $sug_manager_name,
                'sug_start_date' => $sug_start_date, 'sug_end_date' => $sug_end_date
            ]);

        if ($iIdx) {
            $result = $readyDB->where('idx', $iIdx)->update();
        } else {
            $result = $readyDB->insert();
        }

        if ($result) {
            alert_back($this->globalvar->aMsg['success1']);
            exit;
        } else {
            alert_back($this->globalvar->aMsg['error3']);
            exit;
        }
    }

    public function cAgainAction($strState)
    {
        if (!$strState) {
            alert_back($this->globalvar->aMsg['error1']);
            exit;
        }

        $agRecidx = $this->request->getPost('ag_rec_idx');
        $sugAppIdx = $this->request->getPost('sug_app_idx');

        if ($strState == 'confirm') {
            $readyDB = $this->masterDB->table('config_again_request')
                ->set([
                    'ag_req_com' => 'Y'
                ]);
        } else if ($strState == 'accept') {
            $readyDB = $this->masterDB->table('config_again_request')
                ->set([
                    'ag_req_com' => 'Y',
                    'ag_req_stat' => 'Y'
                ]);
        } else if ($strState == 'refuse') {
            $readyDB = $this->masterDB->table('config_again_request')
                ->set([
                    'ag_req_com' => 'Y',
                    'ag_req_stat' => 'N'
                ]);
        }

        $result = $readyDB->where('idx', $agRecidx)->update();

        if ($result) {
            alert_back($this->globalvar->aMsg['success1']);
            exit;
        } else {
            alert_back($this->globalvar->aMsg['error3']);
            exit;
        }
    }
}
