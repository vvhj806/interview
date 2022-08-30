<?php

namespace App\Controllers\Interview\Help;

use App\Controllers\Interview\WwwController;

use Config\Services;


use App\Models\ApplierModel;
use App\Models\JobCategoryModel;
use App\Models\SetReportScoreRankModel;
use App\Models\FaqModel;
use App\Models\ConfigFaqTypeModel;

class GuideController extends WwwController
{
    public function index()
    {
        $this->interview();
    }

    public function interview()
    {
        // data init
        $this->commonData();

        $cache = \Config\Services::cache();
        $recIdx = $cache->get('is.backUrl.Rec.' . $this->aData['data']['session']['idx']);
        $mockIdx = $cache->get('is.backUrl.Mock.' . $this->aData['data']['session']['idx']);
        $cMockIdx = $cache->get('is.backUrl.cMock.' . $this->aData['data']['session']['idx']);

        if ($recIdx) {
            $this->aData['data']['recIdx'] = $recIdx;
        }

        if ($mockIdx) {
            $this->aData['data']['mockIdx'] = $mockIdx;
        }

        if ($cMockIdx) {
            $this->aData['data']['cMockIdx'] = $cMockIdx;
        }

        $this->header();
        echo view("www/help/guide/interview", $this->aData);
        $this->footer(['guide1']);
    }

    public function faq()
    {
        // data init
        $this->commonData();

        $FaqModel = new FaqModel();
        $ConfigFaqTypeModel = new ConfigFaqTypeModel();

        $getFaqType = $ConfigFaqTypeModel->getFaqType();

        foreach ($getFaqType as $key => $val) {
            $this->aData['data']['faqList' . $val['idx']] = $FaqModel->getGuideFaq($val['idx']);
        }

        $cache = \Config\Services::cache();
        $recIdx = $cache->get('is.backUrl.Rec.' . $this->aData['data']['session']['idx']);
        $mockIdx = $cache->get('is.backUrl.Mock.' . $this->aData['data']['session']['idx']);
        $cMockIdx = $cache->get('is.backUrl.cMock.' . $this->aData['data']['session']['idx']);

        if ($recIdx) {
            $this->aData['data']['recIdx'] = $recIdx;
        }

        if ($mockIdx) {
            $this->aData['data']['mockIdx'] = $mockIdx;
        }

        if ($cMockIdx) {
            $this->aData['data']['cMockIdx'] = $cMockIdx;
        }

        $this->aData['data']['getFaq'] = $getFaqType;

        $this->header();
        echo view("www/help/guide/faq", $this->aData);
        $this->footer(['guide2']);
    }

    public function sampleInterview()
    {
        // data init
        $this->commonData();

        $aCheck = $this->request->getGet('updown');
        $aCateCheck = $this->request->getGet('cateCheck');
        $ApplierModel = new ApplierModel();
        $jobCategoryModel = new JobCategoryModel();
        $SetReportScoreRankModel = new SetReportScoreRankModel();
        $this->encrypter = Services::encrypter();

        $cache = \Config\Services::cache();
        $recIdx = $cache->get('is.backUrl.Rec.' . $this->aData['data']['session']['idx']);
        $mockIdx = $cache->get('is.backUrl.Mock.' . $this->aData['data']['session']['idx']);
        $cMockIdx = $cache->get('is.backUrl.cMock.' . $this->aData['data']['session']['idx']);

        if ($recIdx) {
            $this->aData['data']['recIdx'] = $recIdx;
        }

        if ($mockIdx) {
            $this->aData['data']['mockIdx'] = $mockIdx;
        }

        if ($cMockIdx) {
            $this->aData['data']['cMockIdx'] = $cMockIdx;
        }


        if ($aCheck || $aCateCheck) {
            if ($aCateCheck) {
                $aGetCheckCate = $jobCategoryModel->getCheckCate($aCateCheck);

                $aSampleInfo = $ApplierModel->sampleList($aCheck, $aGetCheckCate);
            } else {
                $aSampleInfo = $ApplierModel->sampleList($aCheck, $aCateCheck);
            }
        } else {
            $aSampleInfo = $ApplierModel->sampleList();
        }

        if (!cache('aAlljobCate.each')) {
            $this->aData['data']['jobCate'] = $jobCategoryModel->getAllcategory();
        } else {
            $this->aData['data']['jobCate'] = cache('aAlljobCate.each');
        }

        $aGetPercent = $SetReportScoreRankModel->getRankScore();

        $aSamples = $aSampleInfo->limit(4, 0)->find();

        foreach ($aSamples as $sampleKey => $Sample) {
            $rankSum = 0;
            $persentSum = 0;
            $aSamples[$sampleKey]['percent'] = "-";
            $aSamples[$sampleKey]['enIdx'] = base64url_encode($this->encrypter->encrypt(json_encode($Sample['idx'])));
            $aSamplesAnal = json_decode($aSamples[$sampleKey]['repo_analysis']);
            $aSamples[$sampleKey]['analy'] = $aSamplesAnal;
            foreach ($aGetPercent as $val) {
                $rankSum = $rankSum + (int)$val['score_rank_count_member'];
            }
            foreach ($aGetPercent as $val) {
                if ($val['score_rank_count_member'] > 0) {
                    $persent = (floatval($val['score_rank_count_member']) / $rankSum) * 100;
                    $persentSum = $persentSum + $persent;
                    if ($aSamplesAnal->grade == $val['score_rank_grade']) {
                        $aSamples[$sampleKey]['percent'] = $persentSum;
                    }
                }
            }
        }
        $this->aData['data']['sampleList'] = $aSamples;
        $this->aData['data']['SampleCount'] = $aSampleInfo->countAllResults();
        $this->aData['data']['get']['cate'] = $aCateCheck;
        $this->aData['data']['get']['updown'] = $aCheck;

        $this->header();
        echo view("www/help/guide/sampleList", $this->aData);
        $this->footer(['guide3']);
    }
}
