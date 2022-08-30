<?php

namespace App\Controllers\Interview\Board;

use App\Controllers\Interview\WwwController;
use App\Models\BoardModel;
use App\Models\ConfigBoardModel;

class BoardController extends WwwController
{
    public function eventList()
    {
        // data init
        $this->commonData();
        $strEventStat = $this->request->getGet('stat') ?? 'ing';

        if (!in_array($strEventStat, ['ing', 'end'])) {
            alert_back($this->globalvar->aMsg['error1']);
            exit;
        }

        $boardModel = new BoardModel('event', 'board');

        switch ($strEventStat) {
            case 'ing':
                $boardModel->where('bd_end_date >=', date('Y-m-d'));
                break;
            case 'end':
                $boardModel->where('bd_end_date <', date('Y-m-d'));
                break;
        }

        $boardModel
            ->select([
                'iv_board_event.idx',
                'file_save_name',
                'bd_start_date',
                'bd_end_date'
            ])
            ->join('iv_file', 'iv_file.idx = iv_board_event.file_idx_thumb', 'left')
            ->getBdList();
        $eventList = $boardModel->paginate(10, 'event');

        $this->aData['data']['stat'] = $strEventStat;
        $this->aData['data']['eventList'] = $eventList;
        $this->aData['data']['pager'] = $boardModel->pager;

        $this->header();
        echo view("www/board/event/list", $this->aData);
        $this->footer(['event']);
    }

    public function eventDetail($iEventIdx)
    {
        // data init
        $this->commonData();

        $boardModel = new BoardModel('event', 'board');
        $eventList = $boardModel->getBdListRow($iEventIdx);

        $falg = $this->masterDB->table('iv_board_event')
            ->set('bd_hit', 'bd_hit + 1', false)
            ->where([
                'idx' => $iEventIdx,
            ])
            ->update();

        if (!$falg) {
            alert_back($this->globalvar->aMsg['error1']);
            exit;
        }

        $this->aData['data']['eventList'] = $eventList;

        $this->header();
        echo view("www/board/event/detail", $this->aData);
        $this->footer(['quick']);
    }

    public function noticeList()
    {
        // data init
        $this->commonData();

        $boardModel = new BoardModel('notice', 'board');

        $boardModel
            ->select(['idx', 'bd_title', 'bd_reg_date', 'bd_content'])
            ->getBdList();
        $noticeList = $boardModel->paginate(10, 'notice');

        $this->aData['data']['noticeList'] = $noticeList;
        $this->aData['data']['pager'] = $boardModel->pager;

        $this->header();
        echo view('www/board/notice/list', $this->aData);
        $this->footer(['notice']);
    }

    public function restList()
    {
        // data init
        $this->commonData();
        $aTemp = [];

        $configBoardModel = new ConfigBoardModel('rest');
        $aCategory = $configBoardModel
            ->select(['idx', 'rest_txt'])
            ->getList()
            ->findAll();

        foreach ($aCategory as $val) {
            $aTemp[] = $val['idx'];
        }

        $strSelectCategory = $this->request->getGet('category') ?? 'all';
        if (!in_array($strSelectCategory, $aTemp)) {
            $strSelectCategory = 'all';
        }

        $boardModel = new BoardModel('rest', 'board');
        $boardModel
            ->getBdList()
            ->select(['iv_board_rest.idx', 'bd_title', 'bd_reg_date', 'iv_file.file_save_name'])
            ->join('iv_file', 'iv_board_rest.file_idx_thumb = iv_file.idx', 'left');
        if ($strSelectCategory != 'all') {
            $boardModel
                ->where('iv_board_rest.bd_category_idx', $strSelectCategory);
        }

        $aRestList = $boardModel->paginate(10, 'rest');

        $this->aData['data']['selectCategory'] = $strSelectCategory;
        $this->aData['data']['category'] = $aCategory;
        $this->aData['data']['list'] = $aRestList;
        $this->header();
        echo view("www/rest/list", $this->aData);
        $this->footer(['rest']);
    }

    public function restDetail(int $restIdx)
    {
        // data init
        $this->commonData();

        $boardModel = new BoardModel('rest', 'board');
        $aList = $boardModel
            ->getBdList()
            ->select(['bd_title', 'bd_content', 'bd_reg_date', 'iv_file.file_save_name', 'config_board_rest.rest_txt'])
            ->join('iv_file', 'iv_board_rest.file_idx_thumb = iv_file.idx', 'left')
            ->join('config_board_rest', 'iv_board_rest.bd_category_idx = config_board_rest.idx', 'inner')
            ->where(['iv_board_rest.idx' => $restIdx])
            ->first();
        if (!$aList) {
            return redirect($this->globalvar->getMain());
        }

        $this->aData['data']['list'] = $aList;
        $this->header();
        echo view("www/rest/detail", $this->aData);
        $this->footer(['quick']);
    }
}
