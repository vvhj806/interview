<?php

namespace App\Controllers\Interview\My;

use CodeIgniter\I18n\Time;
use App\Controllers\Interview\WwwController;
use App\Models\ApplierModel;
use App\Models\ReportResultModel;
use App\Models\ResumeModel;
use Config\Services;

class ChangeController extends WwwController
{
    private $encrypter;
    private $backUrlList = '/';

    public function index($state, $data = null, $appIdx = null)
    {
        $this->encrypter = Services::encrypter();
        $session = session();
        $iMemberIdx = $session->get('idx');

        if ($state === 'report') {
            $applierModel = new ApplierModel();
            $reportResultModel = new ReportResultModel();

            $applierModel
                ->getApplierAllList2($iMemberIdx, 4)
                ->where(['iv_applier.app_type' => 'M']);
            $aReport = $applierModel->paginate(8, 'report');

            foreach ($aReport as $key => $val) {
                $aReport[$key]['repo_analysis'] = json_decode($val['repo_analysis'], true);
                $aReport[$key]['repo_analysis'] = $aReport[$key]['repo_analysis']['grade'] ?? '';
                $aReport[$key]['queCount'] = $reportResultModel->getQueCount($val['idx']);
                $aReport[$key]['idx'] = base64url_encode($this->encrypter->encrypt(json_encode($val['idx'])));
            }

            $last = $applierModel->pager->getLastPage('report');
            $curr = $applierModel->pager->getCurrentPage('report');
            $page = null;
            if ($last > $curr) {
                $page = $curr + 1;
            } else {
                $page = $curr + 0;
            }

            $this->aData['data']['report'] = $aReport;
            $this->aData['data']['pager'] = $page;
            echo view("www/report/change", $this->aData);
        } else if ($state === 'resume') {
            $resumeModel = new ResumeModel();

            $getResumeList = $resumeModel->getResumeList($iMemberIdx);
            foreach ($getResumeList as $key => $val) {
                $getResumeList[$key]['res_idx'] =  base64url_encode($this->encrypter->encrypt(json_encode(preg_replace('/[\@\.\;\" "]+/', '', json_encode($val['idx'])))));;
                $getResumeList[$key]['idx'] =  base64url_encode($this->encrypter->encrypt(json_encode($val['idx'])));
                $getResumeList[$key]['res_reg_date'] =  date('Y.m.d', strtotime($val['res_reg_date']));
            }

            $this->aData['data']['resumeList'] = $getResumeList;

            echo view("www/my/resume/change", $this->aData);
        }

        $this->aData['data']['page'] = $data['data']['page'];
        $this->aData['data']['appIdx'] = $appIdx;
    }

    public function scroll()
    {
        if (!$this->request->isAJAX()) {
            return;
        }

        $this->encrypter = Services::encrypter();

        $applierModel = new ApplierModel();
        $reportResultModel = new ReportResultModel();

        $session = session();
        $iMemberIdx = $session->get('idx');

        $applierModel->getApplierAllList2($iMemberIdx, 4);
        $aReport = $applierModel->paginate(4, 'report');

        foreach ($aReport as $key => $val) {
            $aReport[$key]['repo_analysis'] = json_decode($val['repo_analysis'], true);
            $aReport[$key]['repo_analysis'] = $aReport[$key]['repo_analysis']['grade'] ?? '';
            $aReport[$key]['queCount'] = $reportResultModel->getQueCount($val['idx']);
            $aReport[$key]['idx'] = base64url_encode($this->encrypter->encrypt(json_encode($val['idx'])));
            unset($aReport[$key]['app_count']);
            unset($aReport[$key]['app_like_count']);
            unset($aReport[$key]['app_type']);
        }

        $last = $applierModel->pager->getLastPage('report');
        $curr = $applierModel->pager->getCurrentPage('report');
        $page = null;

        $this->aData['data']['report'] = $aReport;

        if ($last > $curr) {
            $page = $curr + 1;
            $stat = 'success';
        } else {
            $page = $curr + 0;
            $stat = 'last';
        }

        echo json_encode([
            'view' => $aReport,
            'next' => $page,
            'code'     => [
                'stat' => $stat,
                'token' => csrf_hash()
            ],
        ]);
    }
}
