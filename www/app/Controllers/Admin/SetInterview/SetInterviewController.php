<?php

namespace App\Controllers\Admin\SetInterview;

use App\Models\{
    ApplierModel,
    CompanyQuestionCategoryModel,
    MemberModel,
    JobCategoryModel,
    InteractiveQuestionModel,
    QuestionModel,
    PhraseModel
};

use App\Libraries\{
    SendLib,
    ShortUrlLib
};
use Config\Services;
use App\Controllers\Admin\AdminController;

class SetInterviewController extends AdminController
{
    public function interactiveList()
    {
        $this->commonData();

        $interactiveQuestionModel = new InteractiveQuestionModel();

        $aInterativeList = $interactiveQuestionModel
            ->orderBy('idx', 'DESC')
            ->paginate(30, 'interactive');

        $this->aData['data']['interactiveList'] = $aInterativeList;
        $this->aData['data']['pager'] = $interactiveQuestionModel->pager;
        $this->aData['data']['count'] = $interactiveQuestionModel->pager->getTotal('interactive');
        $this->header();
        $this->nav();
        echo view('prime/setinterview/interactive', $this->aData);
        $this->footer();
    }

    public function interactiveDeleteAction()
    {
        $this->commonData();

        $aInterativeIdx = $this->request->getPost('interativeIdx');
        if (!$aInterativeIdx) {
            alert_back($this->globalvar->aMsg['error13']);
            exit;
        }

        //트랜잭션 start
        $this->masterDB->transBegin();

        $this->masterDB->table('iv_interactive_question')->whereIn('idx', $aInterativeIdx)->delete();

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

    public function interactiveExcelAction()
    {
        $this->commonData();
        $fileExcel = $this->request->getFile('upload_file');
        if (!$fileExcel->isValid()) {
            alert_back($this->globalvar->aMsg['error13']);
            exit;
        }

        $uploadPath = WRITEPATH . 'uploads/';
        $uploadName = 'excel.csv';

        //CSV데이터 추출시 한글깨짐방지
        setlocale(LC_CTYPE, 'ko_KR.eucKR');
        set_time_limit(0);
        echo ('<meta http-equiv="content-type" content="text/html; charset=utf-8">');

        $fileExcel->move($uploadPath, $uploadName);
        $aCsv = file($uploadPath . $uploadName);
        unlink($uploadPath . $uploadName);

        $columnName = [];
        $temp = [];
        foreach ($aCsv as $key => $val) {
            $val = explode(',', $val);
            if ($key == 0) {
                foreach ($val as $k => $v) {
                    $columnName[$k] = trim($v);
                }
                unset($aCsv[$key]);
                continue;
            }
            foreach ($val as $k => $v) {
                $temp[$columnName[$k]] = $v;
            }
            $aCsv[$key] = $temp;
        }

        //트랜잭션 start
        $this->masterDB->transBegin();

        foreach ($aCsv as $val) {
            $this->masterDB->table('iv_interactive_question')
                ->set([
                    'point_word' => $val['point_word'],
                    'negative_word' => $val['negative_word'],
                    'question' => $val['question'],
                ])
                ->insert();
            // $iInteractiveIdx = $this->masterDB->insertID();
            // $this->masterDB->table('iv_interactive_question_log')
            //     ->set([
            //         'question_idx' => $iInteractiveIdx,
            //         'negative_word' => $val['negative_word'],
            //         'question' => $val['question'],
            //     ])
            //     ->insert();
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

    public function spellList()
    {
        $this->commonData();

        $strKeyword = $this->request->getGet('keyword') ?? '';

        $questionModel = new QuestionModel();

        if ($strKeyword) {
            $questionModel->like('que_question', $strKeyword, 'both');
        }

        $aQueList = $questionModel->select(['idx', 'que_spell_check'])->like('que_spell_check', 201, 'both')
            ->where(['delyn' => 'N'])->paginate(10, 'question');

        foreach ($aQueList as $key => $val) {
            $val['que_spell_check'] = json_decode($val['que_spell_check'], true);

            $aQueList[$key]['que_spell_check'] = $val['que_spell_check']['words'];
            $aQueList[$key]['que_question'] = $val['que_spell_check']['checked'];
        }

        $this->aData['data']['keyword'] = $strKeyword;
        $this->aData['data']['queList'] = $aQueList;
        $this->aData['data']['pager'] = $questionModel->pager;
        $this->aData['data']['count'] = $questionModel->pager->getTotal('question');
        $this->header();
        $this->nav();
        echo view('prime/setinterview/spell', $this->aData);
        $this->footer();
    }

    public function sttList()
    {
        $this->commonData();

        $strKeyword = $this->request->getGet('keyword') ?? '';

        $phraseModel = new PhraseModel();

        if ($strKeyword) {
            $phraseModel->like('phrase', $strKeyword, 'both');
        }

        $aInterativeList = $phraseModel
            ->orderBy('idx', 'DESC')
            ->paginate(30, 'phrase');

        $this->aData['data']['keyword'] = $strKeyword;
        $this->aData['data']['interactiveList'] = $aInterativeList;
        $this->aData['data']['pager'] = $phraseModel->pager;
        $this->aData['data']['count'] = $phraseModel->pager->getTotal('phrase');

        $this->header();
        $this->nav();
        echo view('prime/setinterview/stt', $this->aData);
        $this->footer();
    }

    public function PhraseInsertAction()
    {
        $this->commonData();

        $strPhrase = $this->request->getPost('phrase');
        if (!$strPhrase) {
            alert_back($this->globalvar->aMsg['error13']);
            exit;
        }

        //트랜잭션 start
        $this->masterDB->transBegin();

        $this->masterDB
            ->table('iv_phrase')
            ->set(['phrase' => $strPhrase, 'complete' => 1])
            ->set(['datetime' => 'NOW()'], '', false)
            ->insert();

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

    public function PhraseDeleteAction()
    {
        $this->commonData();

        $aPhraseIdx = $this->request->getPost('phraseIdx');
        if (!$aPhraseIdx) {
            alert_back($this->globalvar->aMsg['error13']);
            exit;
        }

        //트랜잭션 start
        $this->masterDB->transBegin();

        $this->masterDB->table('iv_phrase')->whereIn('idx', $aPhraseIdx)->delete();

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
}
