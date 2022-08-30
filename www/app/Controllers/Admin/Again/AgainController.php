<?php

namespace App\Controllers\Admin\Again;

use App\Models\{
    CompnaySuggestModel,
    ConfigCompnaySuggestModel,
    CompanySuggestApplicantModel,
    ConfigAgainRequestModel
};
use App\Controllers\Admin\AdminController;

class AgainController extends AdminController
{
    public function mList()
    {
        //get
        $strSearchText = $this->request->getGet('searchText') ?? '';
        $straAgainType = $this->request->getGet('againType') ?? 'recruit';
        $strOrder = $this->request->getGet('order') ?? 'ag_req_idx';
        $strOrderType = $this->request->getGet('orderType') ?? 'DESC';
        //init
        $this->commonData();

        //model
        $configAgainRequestModel = new ConfigAgainRequestModel();

        $configAgainRequestModel->againRequestList();

        if ($straAgainType == 'recruit') {
            $configAgainRequestModel
                ->memberBuilder()
                ->groupStart()
                ->orLike('iv_member.mem_tel', $strSearchText, 'both')
                ->orLike('iv_member.mem_id', $strSearchText, 'both')
                ->orLike('iv_member.mem_name', $strSearchText, 'both')
                ->groupEnd()
                ->orderBy($strOrder, $strOrderType);
        } else if ($straAgainType == 'biz') {
            if ($strOrder == 'mem_name') {
                $strOrder = 'sug_app_name';
            }

            $configAgainRequestModel
                ->suggestApplicantBuilder()
                ->groupStart()
                ->orLike('iv_company_suggest_applicant.sug_app_name', $strSearchText, 'both')
                ->orLike('iv_company_suggest_applicant.sug_app_phone', $strSearchText, 'both')
                ->groupEnd()
                ->orderBy($strOrder, $strOrderType);
        }

        $againRequestList = $configAgainRequestModel->paginate(10, 'again');

        $this->aData['data']['searchText'] = $strSearchText;
        $this->aData['data']['againType'] = $straAgainType;
        $this->aData['data']['order'] = ['column' => $strOrder, 'type' => $strOrderType];
        $this->aData['data']['pager'] = $configAgainRequestModel->pager;
        $this->aData['data']['count'] = $configAgainRequestModel->pager->getTotal('again');
        $this->aData['data']['list'] = $againRequestList;

        // view
        $this->header();
        $this->nav();
        echo view('prime/again/mlist', $this->aData);
        $this->footer();
    }

    public function mWrite($againType, $iIdx)
    {
        // init
        $this->commonData();

        //model
        $configAgainRequestModel = new ConfigAgainRequestModel();

        $againRequestList = $configAgainRequestModel->againRequestList($iIdx);

        if ($againType === 'recruit') {
            $againRequestList->memberBuilder();
        } else if ($againType == 'biz') {
            $againRequestList->suggestApplicantBuilder();
        }

        $againRequestList = $againRequestList->first();

        $this->aData['data']['list'] = $againRequestList ?? [];
        $this->aData['data']['suggestIdx'] = $iIdx;
        $this->aData['data']['againType'] = $againType ?? '';
        // view
        $this->header();
        $this->nav();
        echo view('prime/again/mwrite', $this->aData);
        $this->footer();
    }

    public function cList()
    {
        //get
        $strSearchText = $this->request->getGet('searchText') ?? '';
        $straAgainType = $this->request->getGet('againType') ?? 'recruit';
        $strOrder = $this->request->getGet('order') ?? 'ag_req_idx';
        $strOrderType = $this->request->getGet('orderType') ?? 'DESC';
        //init
        $this->commonData();

        //model
        $configAgainRequestModel = new ConfigAgainRequestModel();

        $againRequestList = $configAgainRequestModel->againRequestList();

        if ($straAgainType == 'recruit') {
            $againRequestList->memberBuilder();
            $againRequestList
                ->groupStart()
                ->orLike('iv_member.mem_tel', $strSearchText, 'both')
                ->orLike('iv_member.mem_id', $strSearchText, 'both')
                ->orLike('iv_member.mem_name', $strSearchText, 'both')
                ->groupEnd()
                ->groupBy('com_idx')
                ->orderBy($strOrder, $strOrderType);
        } else if ($straAgainType == 'biz') {
            if ($strOrder == 'mem_name') {
                $strOrder = 'sug_app_name';
            }

            $againRequestList->suggestApplicantBuilder();
            $againRequestList
                ->groupStart()
                ->orLike('iv_company_suggest_applicant.sug_app_name', $strSearchText, 'both')
                ->orLike('iv_company_suggest_applicant.sug_app_phone', $strSearchText, 'both')
                ->groupEnd()
                ->groupBy('com_idx')
                ->orderBy($strOrder, $strOrderType);
        }

        $againRequestList = $againRequestList->paginate(10, 'again');

        $this->aData['data']['searchText'] = $strSearchText;
        $this->aData['data']['againType'] = $straAgainType;
        $this->aData['data']['order'] = ['column' => $strOrder, 'type' => $strOrderType];
        $this->aData['data']['pager'] = $configAgainRequestModel->pager;
        // $this->aData['data']['count'] = $aList ? $againRequestList->pager->getTotal($straAgainType) : '';
        $this->aData['data']['list'] = $againRequestList;
        // view
        $this->header();
        $this->nav();
        echo view('prime/again/clist', $this->aData);
        $this->footer();
    }

    public function cWrite($iIdx)
    {
        // init
        $this->commonData();

        //model
        $configAgainRequestModel = new ConfigAgainRequestModel();
        $getAgainCompanyInfo =  $configAgainRequestModel->getAgainCompanyInfo($iIdx)->findAll();

        // print_r($getAgainCompanyInfo);
        // return;

        $this->aData['data']['list'] = $getAgainCompanyInfo;
        $this->aData['data']['comName'] = $getAgainCompanyInfo[0]['com_name'];
        $this->aData['data']['comIdx'] = $getAgainCompanyInfo[0]['com_idx'];

        // view
        $this->header();
        $this->nav();
        echo view('prime/again/cwrite', $this->aData);
        $this->footer();


        // // init
        // $this->commonData();

        // //model
        // $compnaySuggestModel = new CompnaySuggestModel();
        // $configCompnaySuggestModel = new ConfigCompnaySuggestModel();
        // $companySuggestApplicantModel = new CompanySuggestApplicantModel();

        // $compnaySuggestModel
        //     ->select([
        //         'iv_company_suggest.idx AS sugIdx', 'iv_company_suggest.sug_type AS sugType',
        //         'iv_company_suggest.sug_massage AS msg', 'iv_company_suggest.sug_manager AS managerStat',
        //         'iv_company_suggest.sug_manager_name AS managerName', 'iv_company_suggest.sug_manager_tel AS managerTel',
        //         'iv_company_suggest.sug_start_date AS sugStartDate', 'iv_company_suggest.sug_end_date AS sugEndDate',
        //     ])
        //     ->where(['iv_company_suggest.idx' => $iIdx]);

        // $aList = $compnaySuggestModel->first();
        // $aList['sugStartDate'] = date('Y-m-d', strtotime($aList['sugStartDate']));
        // $aList['sugEndDate'] = date('Y-m-d', strtotime($aList['sugEndDate']));

        // $aConfigList = $configCompnaySuggestModel
        //     ->select(['iv_member.mem_name AS memName', 'iv_member.mem_Tel AS memTel',])
        //     ->getSendSuggestionsList($iIdx)->memberBuilder()->configRequestBuilder(true)->findAll();
        // $aApplicantList = $companySuggestApplicantModel
        //     ->select(['sug_app_name AS memName', 'sug_app_phone AS memTel', 'iv_company_suggest_applicant.idx AS appSugIdx'])
        //     ->getSendSuggestionsList($iIdx)->applicantRequestBuilder(true)->findAll();

        // foreach ($aConfigList as $key => $val) {
        //     $aConfigList[$key]['againStat'] = $this->getAgainMsg($val['ag_req_com'], $val['ag_req_stat']);
        //     unset($aConfigList[$key]['ag_req_com'], $aConfigList[$key]['ag_req_stat']);
        // }
        // foreach ($aApplicantList as $key => $val) {
        //     $aApplicantList[$key]['againStat'] = $this->getAgainMsg($val['ag_req_com'], $val['ag_req_stat']);
        //     unset($aApplicantList[$key]['ag_req_com'], $aApplicantList[$key]['ag_req_stat']);
        // }

        // $this->aData['data']['suggestList'] = $aList;
        // $this->aData['data']['configList'] = $aConfigList ?? [];
        // $this->aData['data']['applicantList'] = $aApplicantList ?? [];
        // $this->aData['data']['suggestIdx'] = $iIdx;

        // // view
        // $this->header();
        // $this->nav();
        // echo view('prime/again/cwrite', $this->aData);
        // $this->footer();
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
                'sug_massage' => $sug_massage, 'sug_manager' => $sug_manager,
                'sug_manager_name' => $sug_manager_name, 'sug_start_date' => $sug_start_date,
                'sug_end_date' => $sug_end_date
            ]);

        $result = $readyDB->where('idx', $iIdx)->update();

        if ($result) {
            alert_back($this->globalvar->aMsg['success1']);
            exit;
        } else {
            alert_back($this->globalvar->aMsg['error3']);
            exit;
        }
    }

    public function getAgainMsg($ag_req_com, $ag_req_stat)
    {
        // 재응시요청 수락된것 -> ag_req_stat = 'Y' AND  ag_req_com = 'Y'
        // 재응시요청 거절 -> ag_req_stat = 'N' AND  ag_req_com = 'Y'
        // 면접관이 요청 들어온것 확인함 -> ag_req_com = 'Y'
        // 면접관이 요청 들어온것 확인전 -> ag_req_com = 'N' (재응시요청한 직후)

        $strMsg = '요청 없음'; //재응시 요청 상태
        if ($ag_req_com === 'N') {
            $strMsg = '재응시 요청 보냄 확인 전';
        } else if ($ag_req_com === 'Y') {
            $strMsg = '재응시 요청 확인 중';
            if ($ag_req_stat === 'N') {
                $strMsg = '재응시 요청 거절';
            } else if ($ag_req_stat === 'Y') {
                $strMsg = '재응시 요청 수락';
            }
        }
        return $strMsg;
    }
}
