<?php

namespace App\Controllers\Admin\Member;

use App\Controllers\Admin\AdminController;
use App\Models\{
    MemberModel,
    ApplierModel,
    RecruitInfoModel,
    RecruitModel
};

class MemberListController extends AdminController
{
    private $backUrlList = '/prime/member/list';

    public function index()
    {
        alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
        exit;
    }

    public function list(string $code = 'm')
    {
        //get
        $strSearchText = $this->request->getGet('searchText');
        $strOrder = $this->request->getGet('order') ?? 'idx';
        $strOrderType = $this->request->getGet('orderType') ?? 'DESC';
        $strMem = $this->request->getGet('mem') ?? 'all';
        $strMou = $this->request->getGet('mou') ?? '';  //기업회원은 MOU 구분 불가 -> 일반회원일때 mou 쿼리 조건 추가하기
        $strWorknet = $this->request->getGet('worknet') ?? '';
        $strGeneral = $this->request->getGet('general') ?? '';
        $strStartDate = $this->request->getGet('startDate') ?? '0000-00-00';
        $strEndDate = $this->request->getGet('endDate') ??  date("Y-m-d");

        $strType = $code;
        if (!$strType || !in_array($strType, ['m', 'c', 'a', 'l'])) {
            alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
            exit;
        }
        // data init
        $this->commonData();
        $strType = strtoupper($strType);

        //model
        $recruitInfoModel = new RecruitInfoModel();
        $applierModel = new ApplierModel();
        $memberModel = new MemberModel();
        $recruitModel = new RecruitModel();

        // 검색조건
        if ($strMem == 'mou') {
            $sort = ['mem_ex_3 is not' => null];
        } else if ($strMem == 'leave') {
            $sort = [
                'mem_del_date is not' => null,
                'delyn' => 'Y'
            ];
        } else {
            $sort = [];
        }

        if ($strType == 'C') {
            $memberModel
                ->select('iv_member.idx as idx, iv_member.delyn as delyn, iv_member.mem_id, iv_member.mem_name, iv_member.mem_tel, iv_member.mem_type, iv_member.mem_reg_date, iv_company.com_name, iv_company.idx as comIdx');

            if ($strWorknet == 'worknet') { //숫자 정규식 추가해야함 12345@highbuff.com
                $memberModel
                    ->groupStart()
                    // ->where(['mem_id REGEXP' => '^[0-9]+$']) 
                    ->like('mem_id', '@highbuff.com', 'before')
                    ->groupEnd();
            }
        }

        if ($strMou == 'mou') {
            $memberModel->where(['mem_ex_3 is not' => null]);
        }

        if ($strGeneral == 'general') {
            $memberModel
                ->orGroupStart()
                ->where([
                    'mem_ex_3' => null,
                ])
                ->notLike('mem_id', '@highbuff.com', 'before')
                ->groupEnd();
        }

        $memberModel
            ->where($sort)
            ->where(['mem_type' => $strType])
            ->orderBy('iv_member.' . $strOrder, $strOrderType);

        if ($strType == 'C') {
            $memberModel
                ->join('iv_company', 'iv_member.com_idx = iv_company.idx', 'left');
        }

        if ($strSearchText) {
            $memberModel
                ->groupStart() // 키워드
                ->like('mem_id', $strSearchText, 'both')
                ->orLike('mem_name', $strSearchText, 'both')
                ->orLike('mem_tel', $strSearchText, 'both');
            if ($strType == 'C') {
                $memberModel->orLike('com_name', $strSearchText, 'both');
            }
            $memberModel->groupEnd();
        }

        $memberModel->where([
            'mem_reg_date >=' => $strStartDate,
            'mem_reg_date <=' => $strEndDate.' 23:59:59'
        ]);

        $aMemberList = $memberModel->paginate(10, 'member');

        // if ($strType == 'C') {
        //     $recCntArr = array();
        //     foreach($aMemberList as $key => $val) {
        //         $recCnt = $recruitModel->getRecCnt($val['comIdx']);
        //         if(count($recCnt) == 0) {
        //             $recCnt[0]['recCnt'] = 0;
        //         }
        //         $recCntArr[] = $recCnt[0]['recCnt'];
        //     }
        // }

        foreach ($aMemberList as $key => $val) {
            if ($strType == 'C') {
            $aMemberList[$key]['recCnt'] = $recruitModel->getRecCnt($val['comIdx']);
            }
            $aMemberList[$key]['report'] = $applierModel
                ->select("COUNT(*) AS cnt1", '', false)
                ->select("COUNT(case when app_share = '1' then 1 end) AS cnt2", '', false)
                ->where(['app_iv_stat' => 4, 'delyn' => 'N', 'mem_idx' => $val['idx'],])->first();
            $aMemberList[$key]['recruit_info'] = $recruitInfoModel
                ->select("COUNT(*) AS cnt1", '', false)
                ->where(['mem_idx' => $val['idx'], 'delyn' => 'N'])->first();
        }

        $this->aData['data']['count'] = $memberModel->getMemCount($strType, 'N');
        $this->aData['data']['lcount'] = $memberModel->getMemCount($strType, 'Y');
        $this->aData['data']['list'] = $aMemberList;
        $this->aData['data']['pager'] = $memberModel->pager;
        $this->aData['data']['recCnt'] = $recCntArr ?? 0;

        //검색정보
        $this->aData['data']['aData'] = [
            'code' => $code,
        ];

        //검색
        $this->aData['data']['search'] = [
            'text' => $strSearchText
        ];

        //정렬
        $this->aData['data']['order'] = [
            'column' => $strOrder,
            'type' => $strOrderType
        ];

        //회원정렬
        $this->aData['data']['mem'] = [
            'column' => $strMem,
        ];

        //체크박스
        $this->aData['data']['sort'] = [
            'mou' => $strMou,
            'worknet' => $strWorknet,
            'general' => $strGeneral,
        ];

        $this->aData['data']['date'] = [
            'startDate' => $strStartDate,
            'endDate' => $strEndDate,
        ];

        // view
        $this->header();
        $this->nav();
        echo view('prime/member/list', $this->aData);
        $this->footer();
    }
}
