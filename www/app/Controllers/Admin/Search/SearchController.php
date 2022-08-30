<?php

namespace App\Controllers\Admin\Search;

use App\Models\{
    SearchKeywordModel,
};
use App\Controllers\Admin\AdminController;

class SearchController extends AdminController
{
    public function index()
    {
        $this->list();
    }

    public function list()
    {
        $this->commonData();
        $searchKeywordModel = new SearchKeywordModel();

        $aList = $searchKeywordModel->getSearchKeyword()->paginate(50, 'search');

        $this->aData['data']['count'] = $searchKeywordModel->pager->getTotal('search');
        $this->aData['data']['list'] = $aList;
        // view
        $this->header();
        $this->nav();
        echo view('prime/search/list', $this->aData);
        $this->footer();
    }

    public function write()
    {
        $this->commonData();

        $strKeyword = $this->request->getPost('keyword') ?? false;

        if ($strKeyword) {
            //트랜잭션 start
            $this->masterDB->transBegin();

            $this->masterDB->table('iv_search_keyword')
                ->set('order_index', 'order_index + 1', false) //log update -> member table
                ->where(['delyn' => 'N'])
                ->update();

            $this->masterDB->table('iv_search_keyword')
                ->set(['order_index' => 1, 'text' => $strKeyword])
                ->where(['delyn' => 'N'])
                ->insert();
            // 트랜잭션 end

            if ($this->masterDB->transStatus() === false) {
                $this->masterDB->transRollback();
                alert_back($this->globalvar->aMsg['error2']);
                exit;
            } else {
                $this->masterDB->transCommit();
                alert_back($this->globalvar->aMsg['success1']);
                exit;
            }
        }
    }

    public function update()
    {
        $this->commonData();

        $aKeywordIdx = $this->request->getPost('update_idx[]') ?? false;

        //트랜잭션 start
        $this->masterDB->transBegin();

        for ($i = 0, $max = count($aKeywordIdx); $i < $max; $i++) {
            $this->masterDB->table('iv_search_keyword')
                ->set('order_index', $i + 1)
                ->where(['idx' => $aKeywordIdx[$i], 'delyn' => 'N'])
                ->update();
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

    public function delete()
    {
        $this->commonData();

        $iKeywordIdx = $this->request->getPost('idx') ?? false;

        if ($iKeywordIdx) {
            $result = $this->masterDB->table('iv_search_keyword')
                ->set('delyn', 'Y')
                ->where(['idx' => $iKeywordIdx])
                ->update();

            if ($result) {
                alert_back($this->globalvar->aMsg['success1']);
                exit;
            }
        }
        alert_back($this->globalvar->aMsg['error2']);
        exit;
    }
}
