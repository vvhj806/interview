<?php

namespace App\Controllers\Interview\My\Perfit;

use CodeIgniter\I18n\Time;
use App\Controllers\Interview\WwwController;;

use App\Models\MemberRecruitCategoryModel;
use App\Models\JobCategoryModel;
use App\Models\RecruitModel;
use App\Models\CompanyModel;
use App\Models\MemberRecruitScrapModel;
use Config\Services;

class PerfitController extends WwwController
{
    private $encrypter;
    private $backUrlList = '/';

    public function index()
    {
        $this->commonData();
        $this->encrypter = Services::encrypter();

        $memberRecruitCategoryModel = new MemberRecruitCategoryModel();
        $memberRecruitScrapModel = new MemberRecruitScrapModel();
        $jobCategoryModel = new JobCategoryModel();
        $recruitModel = new RecruitModel();
        $companyModel = new CompanyModel();

        $session = session();
        $memIdx = $session->get('idx');

        if (!$session->has('idx')){
            alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
            exit;
        }

        // 내 관심직무 찾기 ($getMyJobCategory 가 없으면 관심직무가 없는거여서 리스트를 띄울 수 없음)
        $getMyJobCategory = $memberRecruitCategoryModel->getMyJobCategory($memIdx);

        if ($getMyJobCategory != '' || $getMyJobCategory = null) {
            $getJobIdxs = $jobCategoryModel->getJobIdxs($getMyJobCategory['job_depth_1']);  // 관심직무(job_depth_1)에 맞는 job_idx SELECT (모델에 나중에 값바꾸기)
            $getFitRecIdx = $memberRecruitCategoryModel->getFitRecIdx($getJobIdxs);
            if ($getFitRecIdx != '' || $getFitRecIdx != null) {
                $getComIdxs = $recruitModel->getComIdxs($getFitRecIdx, 6);
                $getComInfo = $companyModel->getComInfo($getComIdxs);    // 관심직무에 맞는 회사 6개 출력
                $getMyComScrap = $memberRecruitScrapModel->getMyComScrap($memIdx);  //내가 즐겨찾기한 기업 SELECT
                
                $aLikeCom = [];
                foreach($getComIdxs as $likeKey => $likeVal){
                    if(in_array($likeVal, $getMyComScrap)){
                        $aLikeCom[] = 1;
                    } else{
                        $aLikeCom[] = 0;
                    }
                }
            } else {
                //해당 카테고리의 공고가 없을경우
            }
        }

        // print_r($getMyJobCategory['job_depth_text']);
        // echo '<br>';
        // print_r($getJobIdxs);
        // echo '<br>';
        // print_r($getFitRecIdx); 
        // echo '<br>';
        // print_r($getComIdxs);  //띄워진 공고 6개 idx
        // echo '<br>';
        // print_r($getComInfo);   
        // echo '<br>'; 
        // print_r($getMyComScrap);
        // echo '<br>';
        // print_r($aLikeCom);
        // return;

        $this->aData['data']['jobText'] = $getMyJobCategory['job_depth_text'];
        $this->aData['data']['comInfo'] = $getComInfo;
        $this->aData['data']['scrapCom'] = $aLikeCom;
        $this->aData['data']['memIdx'] = $memIdx;

        $this->header();
        echo view("www/my/perfit/perfit", $this->aData);
        $this->footer(['company']);
    }
}
