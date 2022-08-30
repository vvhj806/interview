<?php

namespace App\Controllers\Interview\jobs;

use CodeIgniter\I18n\Time;
use App\Controllers\Interview\WwwController;
use App\Models\{
    RecruitModel,
    MemberModel,
    ApplierModel,
    MemberRecruitCategoryModel,
    ReportResultModel,
    ResumeModel,
    RecruitInfoModel,
    MemberRecruitScrapModel,
    QuestionModel,
    FileModel,
};

use App\Controllers\Interview\My\ChangeController;
use Config\Services;

use App\Libraries\{
    SendLib,
    TimeLib
};

class JobsController extends WwwController
{
    private $encrypter;
    private $backUrlList = '/jobs/list';

    public function index()
    {
        $this->list();
    }

    public function list()
    {
        $strSearchText = $this->request->getGet('searchText');
        $strSearchMyApply = $this->request->getGet('searchMyApply');
        $strSearchOrder = $this->request->getGet('searchOrder');

        if ($strSearchMyApply && $strSearchMyApply != 'M') {
            alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
            exit;
        }

        if ($strSearchOrder && !in_array($strSearchOrder, ['rec_hit', 'rec_end_date', 'rec_reg_date'])) {
            alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
            exit;
        }

        $timeLib = new TimeLib();

        //[1] 사용자 정보 가져오기
        $this->commonData();
        $iMemIdx = dot_array_search('data.session.idx', $this->aData);
        $strMemberType = 'guest';
        $aJobIdx = [];

        if ($iMemIdx) {
            $memberRecruitCategory = new MemberRecruitCategoryModel();
            $aCategoryInterview = $memberRecruitCategory->getJoinTypeInterview($iMemIdx);

            $tmpCate = dot_array_search('0.job_depth_1', $aCategoryInterview);
            $tmpInter = dot_array_search('0.inter_type', $aCategoryInterview);
            if (!$tmpCate && !$tmpCate) {
                //2.회원+관심사없음
                $strMemberType = 'login';
            } else if ($tmpCate && !$tmpInter) {
                //3.회원+관심사 있음
                $strMemberType = 'loginCate';
                foreach ($aCategoryInterview as $val) {
                    $aJobIdx[] = $val['job_idx'];
                }
            } else {
                //4.회원+관심사있음 +인터뷰있음
                $strMemberType = 'loginAll';
            }

            $memberRecruitScrapModel = new MemberRecruitScrapModel();
            $aScrap = $memberRecruitScrapModel // 스크랩한 recruit idx 가져오기
                ->where('scr_type', 'R')
                ->getMyScrap($iMemIdx)
                ->findColumn('rec_idx');
            $this->aData['data']['memberIdx'] = $iMemIdx;
        }

        //[2] 관심직무 정보 가져오기 
        $recruitModel = new RecruitModel();
        if (in_array($strMemberType, ['guest', 'login'])) {
            $this->aData['data']['interest'] = false; //직무관심사없음
        } else if (in_array($strMemberType, ['loginCate', 'loginAll'])) {
            $this->aData['data']['interest'] = true; //직무관심사있음    
        }

        //[3] 채용정보목록  가져오기 
        $recruitModel->getRecruitList($aJobIdx, $strSearchText, $strSearchMyApply, $strSearchOrder);

        $this->aData['data']['recruit'] = $recruitModel->paginate(5, 'jobsList');
        $this->aData['data']['pager'] = $recruitModel->pager;
        $this->aData['data']['search'] = ['text' => $strSearchText];
        $this->aData['data']['searchMyApply'] = $strSearchMyApply;
        $this->aData['data']['searchOrder'] = $strSearchOrder;

        $aConfig = $this->globalvar->getConfig();
        $arrWorkDayKind = $aConfig['recruit']['work_day'];

        //[4] 채용정보목록데이터 가공
        foreach ($this->aData['data']['recruit'] as $key => $val) {
            $recCareer = ''; //[고용형태에따라 요일 or 경력 표시]
            if (in_array("3", explode(',', $val['recWorkType']))) { //고용형태가 아르바이트면 요일을 표시                
                $arrWorkDayConvert = [];
                $arrWorkDay = explode(',', $val['recWorkDay']); //근무요일가져오기 
                foreach ($arrWorkDay as $workDay) {
                    $arrWorkDayConvert[] = $arrWorkDayKind[$workDay];
                }
                $recCareer = implode(',', $arrWorkDayConvert); //ex 월,수
            } else { //고용형태가 아르바이트가 아니면 경력을 표시
                if ($val['recCareer'] == 'N') {
                    $recCareer  = '신입';
                } else if ($val['recCareer'] == 'C') {
                    $recCareer  = '경력';
                } else {
                    $recCareer  = '경력무관';
                }
            }
            $this->aData['data']['recruit'][$key]['recCareer'] =  $recCareer;

            //[마감일 Dday표시]
            if ($val['recEndDate']) {
                $this->aData['data']['recruit'][$key]['recEndDate'] = $timeLib->makeDay($val['recEndDate']);
            }
            //[내인터뷰로 지원가능한 면접 표시]
            if ($val['recApply']) {
                if (in_array($val['recApply'], ['M', 'A'])) { //기업면접이면
                    $this->aData['data']['recruit'][$key]['recApply'] = '내인터뷰지원가능';
                } else {
                    $this->aData['data']['recruit'][$key]['recApply'] = '';
                }
            }
            //[스크랩 목록 찾기]
            if (isset($aScrap)) {
                if (in_array($val['recIdx'], $aScrap)) {
                    $this->aData['data']['recruit'][$key]['scrap'] = true;
                }
            }
            //공고 지역 서울.강남 형식으로 바꾸기
            if ($val['area_depth_text_2']) {
                $this->aData['data']['recruit'][$key]['area_depth_text_1'] .= ".{$val['area_depth_text_2']}";
            }
        }
        $this->header();
        echo view("www/jobs/list", $this->aData);
        $this->footer(['recruit']);
    }

    public function detail(int $_idx)
    {
        $this->encrypter = Services::encrypter();
        $this->commonData();

        // setcookie('recently', '', time() -1);

        if ($cookie = get_cookie('recently') ?? false) {
            $aCookie = json_decode($cookie);
            $aTempList[] = $_idx;

            foreach ($aCookie as $val) {
                if ($val === $_idx) {
                    continue;
                }
                $aTempList[] = $val;
            }

            $aTempList = array_unique($aTempList);
            if (count($aTempList) > 10) {
                while (true) {
                    if (count($aTempList) == 10) {
                        break;
                    }
                    array_pop($aTempList);
                }
            }

            $aTempList = json_encode($aTempList);
            setcookie('recently', $aTempList, time() + 86400, '/');
            unset($aTempList);
        } else {
            $cookie = json_encode([0 => $_idx]);
            setcookie('recently', $cookie, time() + 86400, '/');
        }

        // 공고 조회수
        $cookie = get_cookie('rec') ?? false;
        if ($cookie == $_idx) {
            setcookie('rec', $_idx, time() + 600, '/');
        } else {
            setcookie('rec', $_idx, time() + 600, '/');
            $this->masterDB->table('iv_recruit')
                ->set('rec_hit', 'rec_hit + 1', false)
                ->where([
                    'idx' => $_idx
                ])
                ->update();
        }

        $session = session();
        $isLogin = false;
        if ($session->has('idx')) {
            $memIdx = $session->get('idx');
            $isLogin = true;
        }

        $recruitModel = new RecruitModel();
        $questionModel = new QuestionModel();
        $fileModel = new FileModel();
        $memberRecruitCategoryModel = new MemberRecruitCategoryModel();
        $memberRecruitScrapModel = new MemberRecruitScrapModel();
        $recruitInfoModel = new RecruitInfoModel();
        $timeLib = new TimeLib();

        $recruitRow = $recruitModel->getRecruit($_idx);
        $getQueCount = $questionModel->getQueCount($_idx);
        $categories = $memberRecruitCategoryModel->getCategory($_idx);
        $aCategoryIdx = $memberRecruitCategoryModel->getCategoryIdx([$_idx]); //해당 공고의 job_category 추출
        $sameCategoryRec = $memberRecruitCategoryModel->getSameCategoryRec($aCategoryIdx, $_idx, 2);  //이공고어때요?(해당공고와 카테고리가 일치하는 공고 랜덤2개뽑기)
        $ranRecInfo = $recruitModel->getRandomRecInfo($sameCategoryRec);  //랜덤으로 뽑은 공고 정보 가져오기
        $getComImg = $fileModel->getComImg($recruitRow['file_idx_logo']);   //공고를 올린 기업 이미지

        $interQuestion = explode(',', $recruitRow['inter_question']);
        $queCnt = count($interQuestion);
        $answerTime = $recruitRow['inter_answer_time'];

        $applierCategoryRow = [];
        $alreadyApplyRow = [];
        if ($isLogin) {
            $applierModel = new ApplierModel();
            $recruitInfoModel = new RecruitInfoModel();
            $memberIdx = $session->get('idx');
            $memberName = $session->get('mem_name');

            $getMyApply = $recruitInfoModel->getMyApplys($memIdx, $_idx)->findAll();
            $applyCnt = count($getMyApply);

            $checkMyapply = $applierModel->checkMyapply($memberIdx);

            if ($checkMyapply == 'none') {
                $applierCategoryRow = $checkMyapply;
            } else {
                $applierCategoryRow = $applierModel->getMemberCategoty($memberIdx, $categories);
            }

            $alreadyApplyRow = $recruitInfoModel->alreadyApply($memberIdx, $_idx); //이미 지원한 공고인지 체크

            $aRandomIdx = [];
            foreach ($ranRecInfo as $randomKey => $randomVal) {
                array_push($aRandomIdx, $ranRecInfo[$randomKey]['idx']);
            }

            $getRecScrap = $memberRecruitScrapModel->getRecScrap($memIdx, $aRandomIdx); //공고 즐겨찾기 여부
            $pageRecScrap = $memberRecruitScrapModel->getRecScrapOne($memIdx, $_idx);

            $this->aData['data']['recScrap'] = $getRecScrap;
            $this->aData['data']['memIdx'] = $memIdx;
            $this->aData['data']['pageRecScrap'] = $pageRecScrap;
        } else {
            $applierCategoryRow = 'beforeLogin';
            $this->aData['data']['memIdx'] = '';
        }

        $this->aData['data']['aData'] = [
            'idx' => $_idx
        ];

        // 고용형태 explode
        $aWorkType = [];
        $aWorkType = explode(',', $recruitRow['rec_work_type']);

        $startYear = substr($recruitRow['rec_start_date'], 0, 4);
        $startMonth = substr($recruitRow['rec_start_date'], 4, 2);
        $startDate = substr($recruitRow['rec_start_date'], 6, 2);

        $endYear = substr($recruitRow['rec_end_date'], 0, 4);
        $endtMonth = substr($recruitRow['rec_end_date'], 4, 2);
        $endDate = substr($recruitRow['rec_end_date'], 6, 2);

        //날짜 디데이 계산
        $today = date("Ymd");
        foreach ($ranRecInfo as $diffKey => $diffVal) {
            $ranRecInfo[$diffKey]['rec_end_date'] = $timeLib->makeDay($diffVal['rec_end_date']);
        }

        $str_now = strtotime($today);
        $str_target = strtotime($recruitRow['rec_end_date']);

        if ($str_now > $str_target) {
            $applyState = 'N';
        } else {
            $applyState = 'Y';
        }

        //채용공고 상세보기=>HTML 개행 코드 변경
        $recruitRow['rec_info'] = preg_replace('/[가-핳|a-z|A-Z|0-9|\.|\)]+\r/', '$0<br>', $recruitRow['rec_info']);

        $this->aData['data']['workType'] = $aWorkType;
        $this->aData['data']['randomInfo'] = $ranRecInfo;
        $this->aData['data']['categories'] = $categories;
        $this->aData['data']['job'] = $recruitRow;
        $this->aData['data']['tag'] = $recruitModel->getTags($_idx);
        $this->aData['data']['categoryIdx'] = $aCategoryIdx;
        $this->aData['data']['applierCategory'] = $applierCategoryRow;
        $this->aData['data']['alreadyApply'] = $alreadyApplyRow;
        $this->aData['data']['memberName'] = $memberName ?? '';
        $this->aData['data']['queCnt'] = $queCnt;
        $this->aData['data']['answerTime'] = $answerTime;
        $this->aData['data']['recIdx'] = $_idx;
        $this->aData['data']['comImg'] = $getComImg['file_save_name'];
        $this->aData['data']['recStartDate'] = $startYear . '.' . $startMonth . '.' . $startDate;
        $this->aData['data']['recEndtDate'] = $endYear . '.' . $endtMonth . '.' . $endDate;
        $this->aData['data']['isLogin'] = $isLogin;
        $this->aData['data']['currentRecidx'] = $_idx;
        $this->aData['data']['applyState'] = $applyState;
        $this->aData['data']['applyCnt'] = $applyCnt ?? '';

        $this->header();
        echo view("www/jobs/detail", $this->aData);
    }

    public function detailAction()
    {
        $_idx = $this->request->getPost('recIdx');
        $srtState = $this->request->getPost('state');
        $backUrl = $this->request->getPost('backUrl');
        $postCase = $this->request->getPost('postCase');

        if ((!in_array($postCase, ['detail_view', 'scrap_write'])) || !$_idx || !$srtState) {
            alert_url($this->globalvar->aMsg['error1'], $backUrl ? $backUrl : "/");
            exit;
        }

        if ($srtState == 'M' || $srtState == 'C' || $srtState == 'A') {
            $aData = [
                'idx' => $_idx,
                'state' => $srtState,
            ];

            //암호화
            $this->encrypter = Services::encrypter();
            $encodeData = base64url_encode($this->encrypter->encrypt(json_encode($aData)));
            return redirect()->to('/jobs/apply/?data=' . $encodeData);
        } else {
            alert_url($this->globalvar->aMsg['error1'], $backUrl ? $backUrl : "/");
            exit;
        }
    }

    public function apply()
    {
        $this->commonData();
        $aData = $this->request->getGet('data');
        $getAppIdx = $this->request->getGet('app');
        $aData = $aData ?? [];
        $this->encrypter = Services::encrypter();   //공고 idx 복호화
        $decodeData = json_decode(
            $this->encrypter->decrypt(base64url_decode($aData)),
            true
        );

        $aIdx = $decodeData['idx'];
        $this->aData['data']['aData'] = [
            'get' => [
                'recIdx' => $aData,
                'state' => $decodeData['state']
            ]
        ];

        $recruitModel = new RecruitModel();
        $memberRecruitCategoryModel = new MemberRecruitCategoryModel();
        $resumeModel = new ResumeModel();
        $applierModel = new ApplierModel();
        $reportResultModel = new ReportResultModel();
        $changeController = new ChangeController();
        $recruitInfoModel = new RecruitInfoModel();

        $memIdx = $this->aData['data']['session']['idx'];

        // 인터뷰가 있는지 없는지
        $existApply = $applierModel->existApply($memIdx);

        if (!$existApply) {
            alert_url($this->globalvar->aMsg['error14'], $this->backUrlList);
            exit;
        }

        // 지원횟수 초과된 공고의 지원인지 체크
        $getInfoTimes = $recruitInfoModel->getInfoTimes($memIdx, $decodeData['idx']);
        $getRecApply = $recruitModel->getRecApplyCount($decodeData['idx']);

        foreach ($decodeData['idx'] as $ckKey => $ckVal) {
            if (!$getRecApply[$ckKey]) {
                $getRecApply[$ckKey]['rec_apply_count'] = 100;
            }

            if ($getInfoTimes[$ckKey]['cnt'] >= $getRecApply[$ckKey]['rec_apply_count']) {
                alert_url($this->globalvar->aMsg['error19'], $this->backUrlList);
                exit;
            }
        }

        $applyRecruitInfo = $recruitModel->getRecruits($aIdx);
        $this->aData['data']['job'] = $applyRecruitInfo;

        $today = date("Ymd");

        $str_now = strtotime($today);
        $str_target = strtotime($applyRecruitInfo[0]['rec_end_date']);

        if ($str_now > $str_target) {
            alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
            exit;
        }

        $rCount = 0;
        foreach ($this->aData['data']['job'] as $key => $val) {
            if ($this->aData['data']['job'][$key]['rec_resume'] == 'R') {
                $rCount++;
            }
        }

        $this->aData['data']['rCount'] = $rCount;
        $aCategoryIdx = $memberRecruitCategoryModel->getCategoryIdx($aIdx); //해당 공고의 job_category 추출
        $applierIdxInfo = $this->aData['data']['applier'] = $applierModel->getApplierData($memIdx, $aCategoryIdx);  //로그인한 회원의 동일 카테고리 인터뷰 job_category

        // get으로 받은 app이 있으면
        if ($getAppIdx) {
            $getAppJobIdx = $applierModel->getAppJobIdx($getAppIdx);

            $appArr = [];
            array_push($appArr, array("idx" => $getAppIdx, "job_idx" => $getAppJobIdx['job_idx']));
            $applierIdxInfo = $appArr;
        }

        //해당공고 job_idx
        $recruitApplierJobIdx = [];
        for ($i = 0; $i < count($aCategoryIdx); $i++) {
            array_push($recruitApplierJobIdx, $aCategoryIdx[$i]['job_idx']);
        }
        $this->aData['data']['jobIdx'] = $recruitApplierJobIdx;

        //회원의 job_idx
        $aplierJobIdx = [];
        for ($i = 0; $i < count($applierIdxInfo); $i++) {
            array_push($aplierJobIdx, $applierIdxInfo[$i]['job_idx']);
        }

        // 공고의 job_idx와 회원의 job_idx 비교(직무가 일치한지 안한지 체크)
        $iCompareCnt = 0;
        for ($i = 0; $i < count($recruitApplierJobIdx); $i++) {
            for ($j = 0; $j < count($aplierJobIdx); $j++) {
                if ($recruitApplierJobIdx[$i] == $aplierJobIdx[$j]) {
                    $iCompareCnt++;
                }
            }
        }

        //회원의 idx만 추출
        $applierIdx = [];
        for ($i = 0; $i < count($applierIdxInfo); $i++) {
            array_push($applierIdx, $applierIdxInfo[$i]['idx']);
        }

        if ($getAppIdx) {
            $maxApplierIdx = $getAppIdx;
        } else {
            $maxApplierIdx = $reportResultModel->getMaxScoreInterview($applierIdx);
            if ($maxApplierIdx === 0) {
                alert_back($this->globalvar->aMsg['error16']);
            }
        }
        $applyResume = $resumeModel->applyResume($memIdx);
        $getApplierInfo = $applierModel->getApplierInfo($maxApplierIdx);

        if (!$getApplierInfo) {
            $getApplierInfo = 'N';
        }

        if (!$applyResume) {
            $applyResume = 'N';
        }

        if ($applyResume != 'N') {
            $appEnResume = base64url_encode($this->encrypter->encrypt($applyResume['idx']));
        }

        $appEnIdx = base64url_encode($this->encrypter->encrypt($maxApplierIdx));
        $reportInfo = $reportResultModel->getReportInfo($maxApplierIdx);

        if ($getApplierInfo != 'N') {
            $this->encrypter = Services::encrypter();
            $strEnIdx = base64url_encode($this->encrypter->encrypt($getApplierInfo[4]));
        }

        $this->aData['data']['_idx'] = $aIdx;
        $this->aData['data']['categoryIdx'] = $aCategoryIdx;
        $this->aData['data']['interviewInfo'] = $getApplierInfo;  //최고점수 인터뷰정보 (날짜, 카테고리, 프로필, 공개여부, iv_applier idx)
        $this->aData['data']['reportInfo'] = $reportInfo;  //최고점수 인터뷰정보 (질문개수(3), 등급(A))
        $this->aData['data']['resume'] = $applyResume;    //이력서(제일 최근 1개)
        $this->aData['data']['enResume'] = $appEnResume ?? '';    //이력서(제일 최근 1개) 암호화
        $this->aData['data']['compareCnt'] = $iCompareCnt;  //compareCnt가 0이면 일치하는 job_idx가 없음 -> 직무가 일치하지 않음
        $this->aData['data']['maxApplierIdx'] = $maxApplierIdx; //관련직무 인터뷰중 점수가 제일높은 applier_idx
        $this->aData['data']['decodeData'] = $decodeData;
        $this->aData['data']['appEnIdx'] = $appEnIdx;
        $this->aData['data']['enIdx'] = $strEnIdx ?? '';
        $this->aData['data']['getData'] = $aData;
        $this->aData['data']['getAppIdx'] = $getAppIdx;

        $this->header();
        echo view("www/jobs/apply_interview", $this->aData);
        $changeController->index('report');
        $changeController->index('resume');
    }

    public function complete()
    {
        $this->commonData();
        $aData = $this->request->getGet('data');
        if (!$aData) {
            alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
            exit;
        }

        //공고 idx 복호화
        $this->encrypter = Services::encrypter();
        $decodeData = json_decode(
            $this->encrypter->decrypt(base64url_decode($aData)),
            true
        );
        $recIdx = $decodeData['idx'];
        $recState = $decodeData['state'];

        //model
        $recruitModel = new RecruitModel();
        $recruitInfoModel = new RecruitInfoModel();
        $memberRecruitCategoryModel = new MemberRecruitCategoryModel();
        $memberRecruitScrapModel = new MemberRecruitScrapModel();

        $myApplyRow = $recruitInfoModel->getMyApply($this->aData['data']['session']['idx'])->findAll(); // 내가 지원한 공고 idx
        $aCategoryIdx = $memberRecruitCategoryModel->getCategoryIdx($recIdx); //해당 공고의 job_category 추출
        //이공고어때요? (해당공고와 카테고리가 일치하는 공고 랜덤으로 5개뽑기)
        $sameCategoryRec = $memberRecruitCategoryModel->getSameCategoryRecs($aCategoryIdx, $myApplyRow, 5);
        //랜덤으로 뽑은 공고 즐겨찾기 여부
        $aRandomRcruitScrap = $memberRecruitScrapModel->getRecScrap($this->aData['data']['session']['idx'], $sameCategoryRec);

        $this->aData['data']['categoryIdx'] = $aCategoryIdx;
        $this->aData['data']['randomInfo'] = $recruitModel->getRandomRecInfo($sameCategoryRec); //랜덤으로 뽑은 공고 정보 가져오기        
        $this->aData['data']['recruitTitles'] = $recruitModel->getRecruitTitles($recIdx); //지원완료한 공고표시
        $this->aData['data']['scrap'] = $aRandomRcruitScrap;
        $this->aData['data']['aData'] = [
            'get' => [
                'idx' => $recIdx,
                'state' => $recState
            ]
        ];

        //view
        $this->header();
        echo view("www/jobs/complete_apply", $this->aData);
    }

    public function jobApplyAction()
    {
        $recState = $this->request->getPost('applyState');
        $enData = $this->request->getPost('enData');    // 암호화된 data
        $memIdx = $this->request->getPost('memIdx');    // 멤버 idx
        $comIdx = $this->request->getPost('comIdx');    // 회사 idx
        $recIdx = $this->request->getPost('recIdx');    // 공고 idx
        $resIdx = $this->request->getPost('resIdx');    // 이력서 idx
        $appIdx = $this->request->getPost('appIdx');    // 인터뷰 idx
        $recFile = $this->request->getFiles('file');       // 파일
        $code = 'applyFiles';

        $appFiles = $this->request->getPost('appFiles');    //첨부파일
        $appFiles = json_decode($appFiles);

        //링크암호화 데이터
        $aData = [
            'idx' => $recIdx,
            'state' => $recState,
        ];

        //암호화
        $this->encrypter = Services::encrypter();
        $MemberModel = new MemberModel();
        $recruitModel = new RecruitModel();
        $sendLib = new sendLib();
        $aIdx = json_encode($aData);
        $strEnIdx = base64url_encode($this->encrypter->encrypt($aIdx));

        $this->backUrl = '/';

        if (!$enData || !$memIdx || !$comIdx || !$recIdx) {
            alert_url($this->globalvar->aMsg['error1'], $this->backUrl);
            exit;
        }

        $aFileIdx = [];

        // 인터뷰 idx 복호화
        $appIdx = $this->encrypter->decrypt(base64url_decode($appIdx));
        $appIdx = str_replace("\"", "", $appIdx);

        // 이력서 idx 복호화
        if ($resIdx) {
            $resIdx = $this->encrypter->decrypt(base64url_decode($resIdx));
            $resIdx = str_replace("\"", "", $resIdx);
        } else {
            $resIdx = '';
        }

        //트랜잭션 start
        $this->masterDB->transBegin();

        //첨부파일
        if ($appFiles) {
            foreach ($appFiles as $fileVal) {
                // iv_file로 INSERT
                $this->masterDB->table('iv_file')
                    ->set([
                        'file_type' => 'O',
                        'file_org_name' => "{$fileVal->originName}",
                        'file_save_name' => "{$fileVal->saveName}",
                        'file_size' => "{$fileVal->fileSize}",
                    ])
                    ->set(['file_mod_date' => 'NOW()'], '', false)
                    ->set(['file_reg_date' => 'NOW()'], '', false)
                    ->insert();

                $fileIdx = $this->masterDB->insertID();
                $aFileIdx[] = $fileIdx;
            }
        }

        // INSERT iv_recruit_info
        foreach ($recIdx as $key => $val) {
            $readyDB = $this->masterDB->table('iv_recruit_info')
                ->set([
                    'mem_idx' => $memIdx,
                    'com_idx' => $comIdx[$key],
                    'rec_idx' => $recIdx[$key],
                    'res_idx' => $resIdx,
                    'app_idx' => $appIdx,
                    'res_info_ing_mem' => 'C'
                ])
                ->set(['res_info_reg_date' => 'NOW()'], '', false)
                ->set(['res_info_mod_date' => 'NOW()'], '', false);

            foreach ($aFileIdx as $aFileKey => $aFileVal) {
                $readyDB->set(['file_idx_data_' . ($aFileKey + 1) => $aFileIdx[$aFileKey]]);
            }
            $readyDB->insert();
        }

        // 트랜잭션 end
        if ($this->masterDB->transStatus() === false) {
            $this->masterDB->transRollback();
            alert_url($this->globalvar->aMsg['error3'], '/jobs/apply?data=' . $strEnIdx);
        } else {
            $this->masterDB->transCommit();
        }

        // 트랜잭션 검사
        if ($this->masterDB->transStatus()) {
            $aMember = $MemberModel->getMember2($memIdx);
            $strRecIdx = "";
            foreach ($recIdx as $key => $val) {

                $strRecIdx = $strRecIdx . $val . ",";
            }

            $str = "[하이버프인터뷰_지원_알림]\n유저명: " .  $aMember['mem_name'] . "(" . $aMember['mem_id'] . ")\n연락처: " . $aMember['mem_tel'] . "\n지원공고(rec_idx): " . rtrim($strRecIdx, ',');
            $sendLib->telegramSend($str, 'DEV');
        } else {
            alert_url($this->globalvar->aMsg['error3'], $this->backUrl);
            exit;
        }

        return redirect()->to('/jobs/complete?data=' . $strEnIdx);
    }

    public function applyAtOnce()
    {
        $recState = $this->request->getPost('state');    // 지원상태(M:내인터뷰, C:기업인터뷰)
        $recIdxs = $this->request->getPost('recIdx');    // 멤버 idx

        if (!$recState || !$recIdxs) {
            alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
        }

        $aData = [
            'idx' => $recIdxs,
            'state' => $recState,
        ];

        //암호화
        $this->encrypter = Services::encrypter();
        $aIdx = json_encode($aData);
        $strEnIdx = base64url_encode($this->encrypter->encrypt($aIdx));

        return redirect()->to('/jobs/apply?data=' . $strEnIdx);
    }
}
