<?php

namespace App\Controllers\Interview;

use CodeIgniter\I18n\Time;
use App\Controllers\Interview\WwwController;
use App\Models\{
    MemberRecruitCategoryModel,
    JobCategoryModel,
    RecruitModel,
    CompanyModel,
    MemberRecruitScrapModel,
    ConfigCompanyTagModel,
    BoardModel,
    MemberRecruitKor,
    KoreaAreaModel,
    RecruitNostradamusModel,
    PushModel,
    UniversityModel,
    MemberModel,
    ConfigModel,
};

use App\Libraries\{
    TimeLib
};

use Config\Services;

class MainController extends WwwController
{
    public function index()
    {
        $this->main();
    }

    public function main()
    {
        // data init
        $this->commonData();

        $memberRecruitCategoryModel = new MemberRecruitCategoryModel();
        $memberRecruitScrapModel = new MemberRecruitScrapModel();
        $configCompanyTag = new ConfigCompanyTagModel();
        $jobCategoryModel = new JobCategoryModel();
        $recruitNostradamusModel = new RecruitNostradamusModel();
        $recruitModel = new RecruitModel();
        $companyModel = new CompanyModel();
        $pushModel = new PushModel();
        $memberRecruitKor = new MemberRecruitKor();
        $koreaAreaModel = new KoreaAreaModel();
        $restModel = new BoardModel('rest', 'board');
        $eventModel = new BoardModel('event', 'board');
        $UniversityModel = new UniversityModel();
        $MemberModel = new MemberModel();
        $timeLib = new TimeLib();

        $memIdx = $this->aData['data']['session']['idx'] ?? false;

        if ($this->aData['data']['session']['type'] === 'U') { // 템프유저가 메인 들어왔을때
            if (isset($_SESSION['tempBack'])) {
                $strApplicantIdx = $_SESSION['tempBack'];
                unset($_SESSION['tempBack']);
                return redirect()->to("linkInterview/{$strApplicantIdx}");
            } else {
                return redirect()->to("logout");
            }
        }

        $stuCode = $this->request->getGet('code');

        $this->encrypter = Services::encrypter();   //공고 idx 복호화
        $aUni = $UniversityModel->getAllUniUrl();
        foreach ($aUni as $key => $val) {
            $aUni[$key] = $val['uni_url'];
        }

        $decodeData = null;
        $session = session();
        if (in_array($this->aData['data']['page'], $aUni)) {
            $uniCode = $UniversityModel->getUnicode($this->aData['data']['page']);
            if ($this->aData['data']['page'] == "yuhan") {
                $decodeData = base64url_decode($stuCode);
            }
            $session->set(['stuCode' => $decodeData, 'uniCode' => $uniCode]);
        }

        // if (!$getJobDepthOne = cache('jobcategory.each')) {// 어떤 포지션에서 일하고 싶나요?
            $getJobDepthOne = $jobCategoryModel->getJobCategory('interest');  
            cache()->save('jobcategory.each', $getJobDepthOne, 86400);
        // }

        // ----- 알림 -----
        $getPushOne = $pushModel->getPushOne($memIdx);

        // 관심지역공고
        if ($memIdx) {
            $aRowKor = $memberRecruitKor->getKorArea($memIdx);
            shuffle($aRowKor);

            $aWantJobcateory = $memberRecruitCategoryModel->getJopcategory($memIdx);
            shuffle($aWantJobcateory);

            if ($aRowKor && $aWantJobcateory) {
                foreach ($aWantJobcateory as $wVal) {
                    $wantJobIdx[] = $wVal['job_idx'];
                    $wantJobText[] = $wVal['job_depth_text'];
                }

                $getJobDepthIdx = $jobCategoryModel->getJobDepthIdx($wantJobIdx[0]);
                $getJobRec = $memberRecruitCategoryModel->getJobRec($getJobDepthIdx);

                foreach ($aRowKor as $korVal) {
                    $aKorDepthOne[] = $korVal['area_depth_1'];
                    $aKorDepthOneText[] = $korVal['area_depth_text_1'];
                }

                $getKorIdxs = $koreaAreaModel->getKorIdxs($aKorDepthOne[0]);
                $getKorRec = $memberRecruitKor->getKorRec($getKorIdxs);

                $intersection = array_values(array_intersect($getJobRec, $getKorRec));
                $getRecInfo = $recruitModel->getRecInfo($intersection) ?? [];
                // $jobAreaScrap = $memberRecruitScrapModel->getRecScrap($memIdx, $intersection);    

                if (count($intersection) == 0) {
                    // 관심 직무, 지역은 있지만 관련공고가 없을경우
                    $jobAreaState = 'noRec';
                } else {
                    $jobAreaState = 'haveRec';

                    foreach ($getRecInfo[0] as $recInfoVal) {
                        $aRecInfo[] = $recInfoVal['idx'];
                    }

                    $jobAreaScrap = $memberRecruitScrapModel->getRecScrap($memIdx, $aRecInfo ?? []);
                }
            } else {
                // 관심 직무, 지역이 없을경우
                $jobAreaState = 'none';
            }
        }

        // ----- 내 맘에 쏙 드는 회사 ----- 
        $aConfigTag = $configCompanyTag->getRanTagList(3);
        $today = date('Ymd');
        foreach ($aConfigTag as $tagVal) {
            $companyModel
                ->getTagList([$tagVal['idx']], 'left')
                ->select([
                    'iv_korea_area.area_depth_text_1 as areaDepth1',
                    'iv_korea_area.area_depth_text_2 as areaDepth2',
                    'iv_recruit.rec_career as recCareer',
                    'iv_recruit.rec_title as recTitle'
                ])
                ->join('iv_korea_area', 'iv_korea_area.idx = iv_recruit.kor_area_idx')
                ->where([
                    'iv_recruit.delyn' => "N",
                    'iv_recruit.rec_end_date >=' => $today
                ]);
            $tagIdxs[] = $companyModel->limit(3)->find();
        }

        foreach ($tagIdxs as $key1 => $tagIdxsVal) {
            $tagScrapRec = [];
            foreach ($tagIdxsVal as $key2 => $val) {
                if ($val['areaDepth2']) {
                    $tagIdxs[$key1][$key2]['areaDepth1'] .= ".{$val['areaDepth2']}";
                }
                if ($val['recCareer'] == 'N') {
                    $tagIdxs[$key1][$key2]['recCareer'] = '신입';
                } else if ($val['recCareer'] == 'C') {
                    $tagIdxs[$key1][$key2]['recCareer'] = '경력';
                } else {
                    $tagIdxs[$key1][$key2]['recCareer'] = '경력무관';
                }
                $tagScrapRec[] = $tagIdxs[$key1][$key2]['recIdx'];
            }
            $tagScrap[] = $tagScrapRec;
        }

        //즐겨찾기
        if ($memIdx) {
            foreach ($tagScrap as $tVal) {
                if ($tVal) {
                    $tagRecScrap = $memberRecruitScrapModel->getRecScrap($memIdx, $tVal);
                } else {
                    $tagRecScrap = [];
                }
                $tagRecScraps[] = $tagRecScrap;
            }
        }

        // print_r($tagRecScraps);

        // ----- 요즘 뜨는 기업에서 팀원모집중 -----
        $getIssueRec = $recruitModel->getIssueRec();
        $issuRecIdx = [];
        foreach ($getIssueRec as $issVal) {
            $issuRecIdx[] = $issVal['idx']; //공고idx

            if ($issVal['rec_end_date']) {
                $strDiffDate = $timeLib->makeDay($issVal['rec_end_date']);
            }
            $issueRecDday[] = $strDiffDate;
        }

        if ($memIdx) {
            $issueRecScrap = $memberRecruitScrapModel->getRecScrap($memIdx, $issuRecIdx);
        }

        // ----- 실제 면접 질문 연습하기 -----
        $getNosList = $recruitNostradamusModel->getNosList()->findAll(4);

        // ----- 핏이 잘맞는 기업 -----
        if ($memIdx) {
            $getMyJobCategory = $memberRecruitCategoryModel->getMyJobCategory($memIdx);

            if ($getMyJobCategory) {
                $getJobIdxs = $jobCategoryModel->getJobIdxs($getMyJobCategory['job_depth_1']);  // 관심직무(job_depth_1)에 맞는 job_idx SELECT (모델에 나중에 값바꾸기)
                $getFitRecIdx = $memberRecruitCategoryModel->getFitRecIdx($getJobIdxs);
                if ($getFitRecIdx != '' || $getFitRecIdx != null) {
                    $getComIdxs = $recruitModel->getComIdxs($getFitRecIdx, 2);
                    $getComInfo = $companyModel->getComInfo($getComIdxs);    // 관심직무에 맞는 회사 6개 출력
                    $getMyComScrap = $memberRecruitScrapModel->getMyComScrap($memIdx);  //내가 즐겨찾기한 기업 SELECT

                    $aLikeCom = [];
                    foreach ($getComIdxs as $likeVal) {
                        if (in_array($likeVal, $getMyComScrap)) {
                            $aLikeCom[] = true;
                        } else {
                            $aLikeCom[] = false;
                        }
                    }
                } else {
                    //해당 카테고리의 공고가 없을경우
                }
            }
            $this->aData['data']['comInfo'] = $getComInfo ?? [];
            $this->aData['data']['scrapCom'] = $aLikeCom ?? [];
        }

        // ----- 현재 진행중인 이벤트 -----
        $aEventList = $eventModel
            ->select([
                'iv_board_event.idx',
                'file_save_name'
            ])
            ->join('iv_file', 'iv_file.idx = iv_board_event.file_idx_thumb', 'left')
            ->where('bd_end_date >=', date('Y-m-d'))
            ->getBdList()
            ->findAll();

        //----- 쉬어가는 가벼운글 -----
        $aRestList = $restModel
            ->getBdList()
            ->select([
                'iv_board_rest.idx',
                'bd_title',
                'iv_file.file_save_name'
            ])
            ->join('iv_file', 'iv_board_rest.file_idx_thumb = iv_file.idx', 'left')
            ->findAll(4);

        // -------- 비밀번호를 변경하고 1개월 이상 지났는지 확인 ------------
        $timeCheck = false;
        $sixMonthCheck = false;
        $snsCheck = false;
        if ($memIdx) {
            $aMemberInfo = $MemberModel->getMember2($memIdx);
            if ($aMemberInfo['mem_sns_provider']) {
                $snsCheck = true;
            }

            $time = date("Y-m-d H:i:s");
            if ($aMemberInfo['mem_last_password_date']) {
                $time = $aMemberInfo['mem_last_password_date'];
            } else {
                $time = $aMemberInfo['mem_reg_date'];
            }
            $timeCheck = $this->checkOverMonth($time, 1);
            $sixMonthCheck = $this->checkOverMonth($time, 6);
            if ($sixMonthCheck) {
                $timeCheck = false;
            }

            if ($aMemberInfo['mem_next_password_date']) { // 1달 후에 보기
                if (!(date("Y-m-d H:i:s") >= $aMemberInfo['mem_next_password_date'])) {
                    $timeCheck = false;
                    $sixMonthCheck = false;
                }
            }
        }


        $this->aData['data']['category'] = $getJobDepthOne;
        $this->aData['data']['memIdx'] = $memIdx;
        $this->aData['data']['comTag'] = $aConfigTag;

        $this->aData['data']['jobText'] = $wantJobText[0] ?? '';
        $this->aData['data']['areaText'] = $aKorDepthOneText[0] ?? '';
        $this->aData['data']['jobArea'] = $getRecInfo ?? [];
        $this->aData['data']['jobAreaScrap'] = $jobAreaScrap ?? [];
        $this->aData['data']['jobAreaState'] = $jobAreaState ?? [];

        $this->aData['data']['comTagScrap'] = $tagRecScraps ?? [];
        $this->aData['data']['notice'] = $getPushOne;
        $this->aData['data']['tagInfo'] = $tagIdxs;
        $this->aData['data']['nos'] = $getNosList;
        $this->aData['data']['issue'] = $getIssueRec;
        $this->aData['data']['issueDday'] = $issueRecDday ?? [];
        $this->aData["data"]['issueScrap'] = $issueRecScrap ?? [];

        $this->aData['data']['event'] = $aEventList;
        $this->aData['data']['rest'] = $aRestList;
        $this->aData['data']['resetPwd'] = ['month1' => $timeCheck, 'month6' => $sixMonthCheck];
        $this->aData['data']['sns'] = $snsCheck;
        $this->aData['data']['checkServer'] = $this->globalvar->checkServer;

        $this->header();
        echo view("www/main", $this->aData);
        $this->footer(['home']);
    }

    public function checkOverMonth($time, int $month)
    {
        $time = date("Y-m-d H:i:s", strtotime("+{$month} months", strtotime($time)));
        $now = date("Y-m-d H:i:s");
        $timeCheck = $now >= $time ? true : false;
        return $timeCheck;
    }

    public function link()
    {
        // data init
        $this->commonData();
        echo view("www/link", $this->aData);
    }

    public function quick()
    {
        $this->response->redirect("/");
    }

    private function _email()
    {
        $email = Services::email();
        $email->clear();
        $email->setTo('mseon@naver.com');
        $email->setFrom($this->globalvar->getEmailFromMail(), $this->globalvar->getEmailFromName());
        $email->setSubject('제목');
        $email->setMessage('<p>내용</p>');
        $result = $email->send();
        exit;
    }
    public function privacy(){

        $this->commonData();

        $aConfig = [
            'private' => cache('config.private'),
            'agreement' => cache('config.agreement'),
        ];

        if (!$aConfig['private'] || !$aConfig['agreement']) {
            $strAgreement = '';
            $strPrivate = '';
            $configModel = new ConfigModel();
            $aConfig = $configModel->getConfigType('total');
            foreach ($aConfig as $val) {
                if ($val['cfg_type'] == 'A') {
                    $strAgreement = $val['cfg_content'];
                } else if ($val['cfg_type'] == 'P') {
                    $strPrivate = $val['cfg_content'];
                }
            }
            cache()->save('config.private', $strAgreement, 86400);
            cache()->save('config.agreement', $strPrivate, 86400);
            $aConfig['private'] = $strAgreement;
            $aConfig['agreement'] = $strPrivate;
        }
        $this->aData['data']['config']['agreement'] = $aConfig['agreement'];
        $this->aData['data']['config']['private'] = $aConfig['private'];
        $this->header();
        echo view("www/privacy", $this->aData);
    }
}
