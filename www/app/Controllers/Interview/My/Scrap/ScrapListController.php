<?php

namespace App\Controllers\Interview\My\Scrap;

use App\Controllers\Interview\WwwController;
use App\Models\MemberRecruitScrapModel;
use CodeIgniter\I18n\Time;

use App\Libraries\{
    TimeLib
};

class ScrapListController extends WwwController
{
    private $backUrlList = '/';

    public function list(string $type)
    {
        if (!in_array($type, ['recruit', 'company'])) {
            alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
            exit;
        }

        $strRecruit = $this->request->getGet('recruit');
        $strPractice = $this->request->getGet('practice');
        $strRecruitType = $this->request->getGet('type') ?? 'jobs';
        if (in_array($strRecruitType, ['jobs, time, end'])) {
            $strType = 'jobs';
        }

        $strType = $type == 'recruit' ? 'R' : 'C';

        $this->commonData();

        $iMemIdx = $this->aData['data']['session']['idx'];
        $memberRecruitScrapModel = new MemberRecruitScrapModel();
        $timeLib = new TimeLib();
        
        $aRowCount = [
            'C' => $memberRecruitScrapModel
                ->join('iv_company', "iv_company.idx = iv_member_recruit_scrap.com_idx AND iv_company.delyn = 'N'", "inner")
                ->where(['iv_member_recruit_scrap.scr_type' => "C", 'iv_member_recruit_scrap.mem_idx' => $iMemIdx, 'iv_member_recruit_scrap.delyn' => 'N'])->countAllResults(),
            'R' => $memberRecruitScrapModel
                ->join('iv_recruit', "iv_recruit.idx = iv_member_recruit_scrap.rec_idx AND iv_recruit.delyn = 'N'", "inner")
                ->where(['iv_member_recruit_scrap.scr_type' => "R", 'iv_member_recruit_scrap.mem_idx' => $iMemIdx, 'iv_member_recruit_scrap.delyn' => 'N'])->countAllResults()
        ];

        if ($strType == 'R') {
            //채용공고
            $memberRecruitScrapModel
                ->select([
                    'iv_member_recruit_scrap.idx as scrapIdx',
                    'iv_recruit.idx as recIdx', 'iv_recruit.rec_title as recTitle', 'iv_recruit.rec_start_date as recStartDate',
                    'iv_recruit.rec_end_date as recEndDate',
                    'iv_recruit.rec_career as recCareer', 'iv_recruit.rec_apply as recApply',
                    'iv_korea_area.area_depth_text_1 as areaDepth1', 'iv_korea_area.area_depth_text_2 as areaDepth2',
                    'iv_company.com_name as comName', 'iv_file.file_save_name as fileComLogo',
                    'iv_job_category.idx as jobIdx', 'iv_job_category.job_depth_text as jobText'
                ])
                ->join('iv_recruit', 'iv_recruit.idx = iv_member_recruit_scrap.rec_idx', 'left')
                ->join('iv_job_category', 'iv_recruit.job_idx = iv_job_category.idx', 'left')
                ->join('iv_company', 'iv_company.idx = iv_recruit.com_idx', 'left')
                ->join('iv_korea_area', 'iv_korea_area.idx = iv_recruit.kor_area_idx', 'left');
            if ($strRecruitType === 'end') {
                $memberRecruitScrapModel->orderBy('iv_recruit.rec_end_date', 'ASC'); // 마감임박순
            } else {
                $memberRecruitScrapModel->orderBy('iv_member_recruit_scrap.idx', 'desc'); // 즐겨찾기순
            }
        } else if ($strType == 'C') {
            //기업
            $memberRecruitScrapModel
                ->select([
                    'iv_member_recruit_scrap.rec_idx as scrapIdx',
                    'iv_company.idx as comIdx', 'iv_company.com_name as comName', 'iv_company.com_industry as comIndustry', 'iv_company.com_address as comAddress',
                    'iv_company.com_practice_interview as comPractice',
                    'iv_file.file_save_name as fileComLogo',
                    'iv_recruit.idx as recIdx'
                ])
                ->join('iv_company', 'iv_company.idx = iv_member_recruit_scrap.com_idx', 'left')
                ->join('iv_recruit', 'iv_recruit.com_idx = iv_company.idx', 'left');
        }
        //공통
        $memberRecruitScrapModel
            ->join('iv_file', 'iv_file.idx = iv_company.file_idx_logo', 'left')
            ->where(['iv_member_recruit_scrap.mem_idx' => $iMemIdx, 'iv_member_recruit_scrap.scr_type' => $strType, 'iv_member_recruit_scrap.delyn' => 'N', 'iv_company.delyn' => 'N']);

        if ($strType == 'C') {
            $this->aData['data']['get']['recruit'] = '';
            $this->aData['data']['get']['practice'] = '';
            if ($strRecruit == 'Y') {
                //기업, 지금채용중
                $memberRecruitScrapModel
                    ->where(['iv_recruit.rec_end_date >=' => Date('Ymd')]);
                $this->aData['data']['get']['recruit'] = 'Y';
            } else if ($strPractice == 'Y') {
                //기업, 모의인터뷰 응시 가능
                $memberRecruitScrapModel
                    ->where(['iv_company.com_practice_interview' => 'Y']);
                $this->aData['data']['get']['practice'] = 'Y';
            }
            $memberRecruitScrapModel->groupBy('comIdx');
        }
        if ($strRecruitType === 'jobs') {
            $aList  = $memberRecruitScrapModel->paginate(20, 'scrap');
        } else {
            $aList  = $memberRecruitScrapModel->paginate(10, 'scrap');
        }
        // $aList = $memberRecruitScrapModel->findAll();
        $this->aData['data']['pager'] = $memberRecruitScrapModel->pager;
        $this->aData['data']['count'] = $aRowCount;
        //타입정보
        $this->aData['data']['aData'] = [
            'type' => $type,
        ];

        if ($strType == 'R') {
            $aTemp = $aList;
            $aList = [];
            foreach ($aTemp as $key => $val) {
                if ($val['recCareer'] == 'N') {
                    $aTemp[$key]['recCareer'] = '신입';
                } else if ($val['recCareer'] == 'C') {
                    $aTemp[$key]['recCareer'] = '경력';
                } else {
                    $aTemp[$key]['recCareer'] = '경력무관';
                }

                // if($val['area_depth_text_2']){ // 공고 지역
                //     $aTemp[$key]['area_depth_text_1'] .= ".{$val['area_depth_text_2']}";
                // }

                if ($val['recEndDate']) {
                    $aTemp[$key]['recEndDate'] = $timeLib->makeDay($val['recEndDate']);
                }

                if ($strRecruitType === 'jobs') {
                    $aList[$val['jobIdx']][] = $aTemp[$key];
                } else {
                    $aList[] = $aTemp[$key];
                }
            }
            if ($strRecruitType === 'jobs') {
                unset($aTemp);
            }
        }

        $this->aData['data']['recruitType'] = $strRecruitType;
        $this->aData['data']['list'] = $aList;

        // view
        $this->header();
        echo view('www/my/scrap/list', $this->aData);
        $this->footer(['scrap']);
    }
}
