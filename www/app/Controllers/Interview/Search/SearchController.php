<?php

namespace App\Controllers\Interview\Search;

use App\Controllers\Interview\WwwController;

use App\Models\{
    SearchModel,
    SearchKeywordModel,
    TagModel,
    KoreaAreaModel,
    MemberRecruitKor,
    MemberRecruitCategoryModel,
    ConfigCompanyTagModel,
    MemberRecruitScrapModel
};

use App\Libraries\{
    TimeLib
};

class SearchController extends WwwController
{

    public function search()
    {
        // data init
        $this->commonData();

        $cookie = get_cookie('keyword');

        if ($cookie) {
            $cookie = (json_decode($cookie));
        }

        $searchKeywordModel = new SearchKeywordModel();
        $aList = $searchKeywordModel->getSearchKeyword()->findAll();

        $this->aData['data']['keyword'] = $cookie;
        $this->aData['data']['list'] = $aList;

        $this->header();
        echo view("www/search/index", $this->aData);
        $this->footer(['search_index']);
    }

    public function searchAction()
    {
        // data init
        $this->commonData();
        $strType = $this->request->getGet('type') ?? 'recruit';
        $keyword = $this->request->getGet('keyword') ?? 'd';
        $pureKeyword = $this->request->getGet('keyword');
        $deepSearchChk = $this->request->getGet('deepSearchChk');
        $boolApplied = $this->request->getGet('applied') ?? false;
        $boolHire = $this->request->getGet('hire') ?? false;
        if ($strType === 'company') {
            $deepSearchChk = null;
        }

        $timeLib = new Timelib();

        if ($this->aData['data']['session']['id'] ?? false) {
            $iMemberIdx = $this->aData['data']['session']['idx'];

            $memberRecruitScrapModel = new MemberRecruitScrapModel();
            if ($strType === 'company') {
                $aScrap = $memberRecruitScrapModel
                    ->where('scr_type', 'C')
                    ->getMyScrap($iMemberIdx)
                    ->findColumn('com_idx');
            } else if (in_array($strType, ['recruit', 'deepSearch'])) {
                $aScrap = $memberRecruitScrapModel
                    ->where('scr_type', 'R')
                    ->getMyScrap($iMemberIdx)
                    ->findColumn('rec_idx');
            }
        }

        // $keyword = trim($keyword, '/[0-9\@\.\;\" "]+/');
        if (!$keyword) {
            if ($strType === 'deepSearch') {
                if ($deepSearchChk) { // deepSearchChk가 있으면 검색 안되도록
                    $keyword = '$!@^#%#$#$%@^%^$';
                }
            } else {
                $keyword = '';
            }
        } else {
            $cookie = get_cookie('keyword');
            if ($cookie) {
                $aCookie = json_decode($cookie);
                $aTempList[] = $keyword;

                foreach ($aCookie as $key => $val) {
                    if ($val === $keyword) {
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
                setcookie('keyword', $aTempList, time() + 2592000, '/');
            } else {
                $list = json_encode([0 => $keyword]);
                setcookie('keyword', $list, time() + 2592000, '/');
            }
        }

        //상세검색어 가공시작
        $deepSearch = [];
        $deepSearch['aWorkType'] = $this->request->getGet('aWorkType') ?? ''; // like
        $deepSearch['aArea'] = $this->request->getGet('aArea') ?? [];
        $deepSearch['aJobs'] = $this->request->getGet('depth3') ?? [];
        $deepSearch['strCareer'] = $this->request->getGet('strCareer') ?? '';
        $deepSearch['iCareerMonth'] = $this->request->getGet('iCareerMonth') ?? 0;
        $deepSearch['strApply'] = $this->request->getGet('strApply') ?? '';
        $deepSearch['iQueCount'] = $this->request->getGet('iQueCount') ?? 0;
        $deepSearch['aTag'] = $this->request->getGet('aTag') ?? [];
        $deepSearch['strPayType'] = $this->request->getGet('strPayType') ?? '';
        $deepSearch['iPayUnit'] = $this->request->getGet('iPayUnit') ?? 0;
        $deepSearch['strPeriod'] = $this->request->getGet('strPeriod') ?? '';
        $deepSearch['aGender'] = $this->request->getGet('aGender') ?? [];
        $deepSearch['aWorkDay'] = $this->request->getGet('aWorkDay') ?? []; // like
        $deepSearch['aEducation'] = $this->request->getGet('aEducation') ?? [];
        if (count($deepSearch['aArea']) > 10 || count($deepSearch['aJobs']) > 10) {
            alert_back($this->globalvar->aMsg['error1']);
            exit;
        }

        $deepSearch['iCareerMonth'] = intval($deepSearch['iCareerMonth']);
        $deepSearch['iQueCount'] = intval($deepSearch['iQueCount']);
        $deepSearch['iPayUnit'] = intval($deepSearch['iPayUnit']) * 10000;

        $chk = [ // 받은 값 유효성 체크
            'fullTime' => 0, 'halfTime' => 1, 'intern' => 3, 'foreign' => 5,
            'new' => 'N', 'old' => 'C', 'my' => 'M', 'you' => 'C', 'month' => 'M', 'year' => 'Y', 'after' => 'N',
            'none' => 0, 'middle' => 1, 'high' => 2, 'college' => 3, 'university' => 4,  'master' => 5, 'doctor' => 6,
        ];

        $koreaAreaModel = new KoreaAreaModel();
        if (!$aKoreaArea = cache("search.korea.area")) {
            $aKoreaArea = $koreaAreaModel->getKoreaArea();
            cache()->save("search.korea.area", $aKoreaArea, 86400);
        }
        foreach ($aKoreaArea as $v) {  //ex} "A(서울의IDX)" => (서울의IDX)
            if ($v['area_depth_2'] === null) {
                $aAllArea['idx'][] = $v['idx'];
                $aAllArea['depth'][$v['idx']] = $v['area_depth_1'];
            }
            $strCityValue = $v['idx'];
            $chk["A{$strCityValue}"] = $v['idx'];
        }

        $tagModel = new TagModel('config_company_tag');
        $aTagList = $tagModel->getTag();

        foreach ($aTagList as $tagRow) { //ex} "T자율복장" => (tag의IDX)
            $strTagValue = $tagRow['tag_txt'];
            $chk["T{$strTagValue}"] = $tagRow['idx'];
        }

        $filter = [ // get값의 KEY => 검색할 컬럼
            'aWorkType' => 'rec_work_type', 'aArea' => 'tempIdx1', 'aJobs' => 'tempIdx2', 'strCareer' => 'rec_career',
            'iCareerMonth' => 'rec_career_month >=', 'strApply' => 'rec_apply', 'iQueCount' => 'que_count', 'aTag' => 'tempIdx3',
            'strPayType' => 'rec_pay_type', 'iPayUnit' => 'rec_pay_unit >=', 'strPeriod' => 'rec_period ', 'aEducation' => 'rec_education',
            'iv_recruit.delyn' => 'iv_recruit.delyn',
        ];

        foreach ($deepSearch as $key => $value) {
            if ($value) {
                if (is_array($value)) {
                    foreach ($value as $k => $v) {
                        if (in_array($key, ['aJobs'])) {
                            $aDeepSearchList[$filter[$key]][] = $v;
                            $this->aData['data'][$key][] = $v;
                        } else {
                            if (($chk[$k] ?? false) || $chk[$k] === 0 ? true : false) {
                                $aDeepSearchList[$filter[$key]][] = $chk[$k];
                                $this->aData['data'][$key][$k] = 'on';
                            } else {
                                alert_back($this->globalvar->aMsg['error1']);
                                exit;
                            }
                        }
                    }
                } elseif (is_int($value)) {
                    if ($key === 'iCareerMonth') {
                        if ($deepSearch['strCareer'] === 'old') {
                        } else {
                            alert_back($this->globalvar->aMsg['error1']);
                            exit;
                        }
                    } else if ($key === 'iPayUnit') {
                        if ($deepSearch['strPayType'] === 'after') {
                            alert_back($this->globalvar->aMsg['error1']);
                            exit;
                        }
                        $value = $value / 10000;
                    }
                    $aDeepSearchList[$filter[$key]] = $value;
                    $this->aData['data'][$key] = $value;
                } else {
                    if ($chk[$value] ?? false) {
                        $aDeepSearchList[$filter[$key]] = $chk[$value];
                        $this->aData['data'][$key] = $value;
                    } else {
                        alert_back($this->globalvar->aMsg['error1']);
                        exit;
                    }
                }
            }
        }
        $aDeepSearchList ?? $aDeepSearchList['iv_recruit.delyn'] = 'N';

        if (isset($aDeepSearchList['tempIdx1'])) { // area
            $companyTag = new MemberRecruitKor();
            if ($temp = array_intersect($aDeepSearchList['tempIdx1'], $aAllArea['idx'])) {
                foreach ($temp as $val) {
                    $depth[] = $aAllArea['depth'][$val];
                }
                $aDeepSearchList['iv_recruit.idx1'] = $companyTag
                    ->join('iv_korea_area', 'iv_korea_area.idx = iv_member_recruit_kor.kor_area_idx', 'left')
                    ->whereIn('area_depth_1', $depth)
                    ->getCompanyIdx([]);
                unset($temp, $depth);
            } else {
                $aDeepSearchList['iv_recruit.idx1'] = $companyTag->getCompanyIdx($aDeepSearchList['tempIdx1']);
            }
            unset($aDeepSearchList['tempIdx1']);
        }

        if (isset($aDeepSearchList['tempIdx2'])) { // jobs카테고리
            $companyTag = new MemberRecruitCategoryModel();
            $aDeepSearchList['iv_recruit.idx2'] = $companyTag->getCompanyIdx($aDeepSearchList['tempIdx2']);
            unset($aDeepSearchList['tempIdx2']);
        }

        if (isset($aDeepSearchList['tempIdx3'])) {
            $companyTag = new TagModel('iv_company_tag');
            $aDeepSearchList['iv_recruit.com_idx'] = array_unique($companyTag->getCompanyIdx($aDeepSearchList['tempIdx3']));
            unset($aDeepSearchList['tempIdx3']);
        }
        //상세검색어 가공끝

        if ($strType === 'recruit') {  // 통합 검색
            $sortChk = [
                '1' => 'rec_title',  '2' => 'rec_start_date',  '3' => 'rec_end_date', '4' => 'rec_pay_unit',  '5' => 'kor_area_idx',
            ];
            $sort = $this->request->getGet('sort') ?? '1';
            $strSortValue = $sortChk[$sort] ?? 'rec_title'; // sort에 이상한 값이 들어오면 rec_title로 고정

            $searchModel = new SearchModel('iv_recruit');
            $searchModel->select([
                'iv_recruit.idx', 'rec_career', 'rec_end_date', 'iv_company.com_name', 'rec_title',
                'rec_apply', 'job_idx', 'com_address',  'iv_recruit.idx as rec_idx'
            ]);
            if ($boolApplied) {
                $searchModel->whereIn('rec_apply', ['M', 'A']);
            }
            $searchModel
                ->orderBy($strSortValue, $strSortValue === 'rec_start_date' || $strSortValue === 'rec_pay_unit' ? 'DESC' : 'ASC')
                ->getRecruit($keyword);
        } else if ($strType === 'company') {  // 기업 검색
            $sortChk = [
                '6' => 'rec_title', '7' => 'rec_start_date', '8' => 'rec_end_date',
            ];
            $sort = $this->request->getGet('sort') ?? '6';
            $strSortValue = $sortChk[$sort] ?? 'rec_title'; // sort에 이상한 값이 들어오면 rec_title로 고정

            $strJoinName = 'left';
            if ($boolHire) {
                $strJoinName = 'inner';
            }

            $today = date('Ymd');
            $searchModel = new SearchModel('iv_company');
            $searchModel
                ->select(['iv_company.idx', 'com_name', 'com_address', 'iv_company.idx as com_idx', 'iv_recruit.idx as r_idx',  'com_practice_interview'])
                ->join(
                    'iv_recruit',
                    "iv_company.idx = iv_recruit.com_idx 
                    AND iv_recruit.delyn = 'N' 
                    AND iv_recruit.rec_end_date >= {$today}
                    AND iv_recruit.rec_stat = 'Y'",
                    $strJoinName
                )
                ->getCompany($keyword)
                ->groupBy('iv_company.idx');
        } else if ($strType === 'deepSearch') {  // 상세 검색
            $sortChk = ['1' => 'rec_title', '2' => 'rec_start_date', '3' => 'rec_end_date', '4' => 'rec_pay_unit', '5' => 'kor_area_idx',];
            $sort = $this->request->getGet('sort') ?? '1';
            $strSortValue = $sortChk[$sort] ?? 'rec_title'; // sort에 이상한 값이 들어오면 rec_title로 고정

            $searchModel = new SearchModel('iv_recruit');
            $searchModel->select([
                'iv_recruit.idx', 'rec_career', 'rec_end_date', 'rec_apply', 'job_idx',
                'iv_company.com_name', 'rec_title', 'com_address', 'iv_recruit.idx as rec_idx'
            ]);

            $searchModel->getRecruitDetail($keyword, $strSortValue, $aDeepSearchList);
        } else {
            alert_back($this->globalvar->aMsg['error1']);
            exit;
        }

        $aRecruitList = $searchModel->paginate(10, 'search');

        if ($aRecruitList && $strType != 'company') {
            $change = ['C' => '경력', 'N' => '신입', 'A' => '경력무관'];
            foreach ($aRecruitList as $key => $val) {
                if (in_array($val['rec_apply'], ['A', 'M'])) {
                    $aRecruitList[$key]['applied'] = true;
                }
                if ($aScrap ?? false) {
                    if (in_array($val['rec_idx'], $aScrap)) {
                        $aRecruitList[$key]['scrap'] = true;
                    }
                }
                $aRecruitList[$key]['rec_career'] = $change[$val['rec_career']] ?? '';

                $aRecruitList[$key]['rec_end_date'] = $timeLib->makeDay($val['rec_end_date']);

                if ($val['area_depth_text_1'] ?? false) {
                    $aRecruitList[$key]['com_address'] = "{$val['area_depth_text_1']}";
                    if ($val['area_depth_text_2'] ?? false) { // 공고 지역
                        $aRecruitList[$key]['com_address'] .= ".{$val['area_depth_text_2']}";
                    }
                }
            }
        } else if ($aRecruitList && $strType === 'company') {
            foreach ($aRecruitList as $key => $val) {
                if ($aScrap ?? false) {
                    if (in_array($val['idx'], $aScrap)) {
                        $aRecruitList[$key]['scrap'] = true;
                    }
                }
            }
        } else {
            if ($strType != 'company') {
                $aOtherList = $searchModel // otherList = 이건 어떠세요? 하고 띄워주는공고
                    ->select(['iv_recruit.idx', 'iv_recruit.idx as rec_idx', 'com_name', 'rec_title'])
                    ->getRecruit('')
                    ->orderBy('rand()', '', false)
                    ->limit(3)
                    ->find();
            } else if ($strType === 'company') {
                $aOtherList = $searchModel
                    ->select(['iv_company.idx', 'iv_company.idx as com_idx', 'com_name', 'com_industry', 'com_address'])
                    ->getCompany('')
                    ->orderBy('rand()', '', false)
                    ->limit(3)
                    ->find();
            }
            foreach ($aOtherList as $key => $val) {
                if ($val['area_depth_text_1'] ?? false) {
                    $aOtherList[$key]['com_address'] = "{$val['area_depth_text_1']}";
                    if ($val['area_depth_text_2'] ?? false) { // 공고 지역
                        $aOtherList[$key]['com_address'] .= ".{$val['area_depth_text_2']}";
                    }
                }
                if ($aScrap ?? false) {
                    if (in_array($val['idx'], $aScrap)) {
                        $aOtherList[$key]['scrap'] = true;
                    }
                }
            }
            $this->aData['data']['otherList'] = $aOtherList ?? [];
        }

        $this->aData['data']['recruitList'] = $aRecruitList;
        $this->aData['data']['count'][$strType] = $searchModel->pager->getTotal('search') ?? 0;
        $this->aData['data']['pager'] = $searchModel->pager;
        if ($strType === 'company') {
            $searchModel = new SearchModel('iv_recruit');
            $this->aData['data']['count']['recruit'] = $searchModel->getRecruit($keyword)->countAllResults();
        } else if ($strType === 'recruit') {
            $searchModel = new SearchModel('iv_company');
            $this->aData['data']['count']['company'] = $searchModel->getCompany($keyword)->countAllResults();
        }

        $this->aData['data']['type'] = $strType;
        $this->aData['data']['applied'] = $boolApplied;
        $this->aData['data']['hire'] = $boolHire;
        $this->aData['data']['keyword'] = $pureKeyword;
        $this->aData['data']['deepSearchChk'] = $deepSearchChk;
        $this->aData['data']['sort'] = $sort;
        $this->header();
        echo view("www/search/search", $this->aData);
        $this->searchModal();
        $this->footer(['search']);
    }

    public function areaModal()
    {
        // data init
        $koreaAreaModel = new KoreaAreaModel();
        if (!$aKoreaArea = cache("search.korea.area")) {
            $aKoreaArea = $koreaAreaModel->getKoreaArea();
            cache()->save("search.korea.area", $aKoreaArea, 86400);
        }
        $aAreaCategory = [];
        foreach ($aKoreaArea as $val) {
            if ($val['area_depth_2'] == null) {
                $aAreaCategory[$val['area_depth_1']]['all'] = ['areaName' => $val['area_depth_text_1'], 'idx' => $val['idx']];
            } else {
                $aAreaCategory[$val['area_depth_1']][] = ['areaName' => $val['area_depth_text_2'], 'idx' => $val['idx']];
            }
        }
        $this->aData['data']['areaCategory'] = $aAreaCategory;
        echo view("www/search/areaModal", $this->aData);
    }

    public function jobCategoryModal()
    {
        echo view("www/search/jobCategoryModal", $this->aData);
    }

    public function searchModal()
    {
        // data init
        $configCompanyTagModel = new ConfigCompanyTagModel();
        $configCompanyTagModel->select(['idx', 'tag_txt']);
        $this->aData['data']['tagCategory'] = $configCompanyTagModel->getTagList();

        echo view("www/search/searchModal", $this->aData);
        $this->areaModal();
        $this->jobCategoryModal();
    }
}
