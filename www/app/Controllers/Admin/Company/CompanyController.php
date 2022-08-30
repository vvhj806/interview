<?php

namespace App\Controllers\Admin\Company;

use App\Models\{
    CompanyModel,
    CompanyTagModel,
    TagModel,
    ConfigCompanyTagModel,
    RecruitModel,
    ConfigCompnaySuggestModel,
    CompnaySuggestModel
};
use  App\Libraries\{
    GlobalvarLib
};
use App\Controllers\Admin\AdminController;

class CompanyController extends AdminController
{
    public function index()
    {
        $this->list();
    }

    public function list()
    {
        $this->commonData();

        $strSearchText = $this->request->getGet('searchText') ?? '';
        $companyModel = new CompanyModel();
        $today = date('Ymd');

        if ($strSearchText) {
            $companyModel
                ->groupStart() // 키워드
                ->like('iv_member.mem_id', $strSearchText, 'both')
                ->orLike('com_name', $strSearchText, 'both')
                ->orLike('iv_company.com_tel', $strSearchText, 'both')
                ->groupEnd();
        }
        $aList = $companyModel
            ->select([
                'iv_company.idx AS comIdx', 'iv_company.com_name as comName',
                'iv_company.com_industry', 'iv_company.com_address',
                'iv_company.com_tel AS comTel', 'iv_company.com_reg_date AS regDate',
                'iv_member.mem_name AS memName', 'iv_member.mem_id AS memId',
                'iv_file.file_save_name AS fileName'
            ])
            ->select("COUNT(case when iv_recruit.rec_stat = 'Y' AND iv_recruit.rec_end_date > {$today} then 1 end) AS ingCnt", '', false) // 진행중인 공고
            ->select('COUNT(iv_recruit.idx) AS recCnt', '', false) // 총 공고 수
            ->join('iv_member', 'iv_member.idx = iv_company.mem_idx', 'left')
            ->join('iv_recruit', 'iv_recruit.com_idx = iv_company.idx', 'left')
            ->join('iv_file', 'iv_file.idx = iv_company.file_idx_logo', 'left')
            ->where('iv_recruit.delyn', 'N')
            ->groupBy('iv_company.idx')
            ->orderBy('comIdx', 'DESC')->paginate(10, 'company');

        $this->aData['data']['list'] = $aList;
        $this->aData['data']['pager'] = $companyModel->pager;
        $this->aData['data']['searchText'] = $strSearchText;

        // view
        $this->header();
        $this->nav();
        echo view('prime/company/list', $this->aData);
        $this->footer();
    }

    public function write($iComIdx = null)
    {
        $this->commonData();

        $companyModel = new CompanyModel();
        $configCompanyTagModel = new ConfigCompanyTagModel();
        $globalvarLib = new GlobalvarLib();
        $aCompanyInfo = $globalvarLib->getConfig();
        $strComRegApiKey = $globalvarLib->getComRegAPIKey();
        $configCompanyTagModel->select(['idx', 'tag_txt']);

        if ($iComIdx) {
            $apply = ['M' => '지원자', 'C' => '기업', 'A' => '무관'];
            $stat = ['I' => '대기중', 'Y' => '승인완료', 'N' => '승인거절'];
            $companyTagModel = new CompanyTagModel();
            $recruitModel = new RecruitModel();
            $compnaySuggestModel = new CompnaySuggestModel();
            $companyModel->select([
                'com_reg_number as comRegNum', 'com_tel as comTel', 'com_reg_date as comRegDate', 'com_ceo_name as comCeoName', 'com_address as comAddress', 'com_form as comForm', 'com_anniversary as comAnniversary', 'com_head_count as comHeadCount', 'com_introduce as comIntroduce'
            ]);
            $aList = $companyModel->getCompanyInfo($iComIdx); // first()
            $aList['comTag'] = $companyTagModel->getCompanyTagIdx($iComIdx);
            $aList['comAnniversary'] = date('Y-m-d', strtotime($aList['comAnniversary']));

            $aSuggestList = $compnaySuggestModel
                ->select("COUNT(*) AS total", '', false)
                ->select("COUNT(case when iv_company_suggest.sug_type = 'A' OR iv_company_suggest.sug_type = 'B' then 1 end) AS ai", '', false)
                ->select("COUNT(case when iv_company_suggest.sug_type = 'I' OR iv_company_suggest.sug_type = 'J' then 1 end) AS meet", '', false)
                ->select("COUNT(case when iv_company_suggest.sug_type = 'O' then 1 end) AS position", '', false)
                ->join('config_company_suggest', 'iv_company_suggest.idx = config_company_suggest.sug_idx', 'left')
                ->join('iv_company_suggest_applicant', 'iv_company_suggest.idx = iv_company_suggest_applicant.sug_idx', 'left')
                ->join('config_again_request', 'config_company_suggest.idx = config_again_request.config_sug_idx OR iv_company_suggest_applicant.idx = config_again_request.sug_app_idx', 'left')
                ->where(['iv_company_suggest.com_idx' => $iComIdx, 'iv_company_suggest.delyn' => 'N', 'config_again_request.idx' => null])->first();

            $aRecStat = $recruitModel->getRecruitStat($iComIdx);
            $aRecList = $recruitModel->buildeRecruitList()->where(['iv_recruit.com_idx' => $iComIdx])->findAll();
            foreach ($aRecList as $key => $val) {
                $aRecList[$key]['recStat'] = $stat[$val['recStat']];
                $aRecList[$key]['recApply'] = $apply[$val['recApply']];
            }
        }

        $this->aData['data']['comIdx'] = $iComIdx ?? '';
        $this->aData['data']['comList'] = $aList ?? [];
        $this->aData['data']['recStat'] = $aRecStat ?? [];
        $this->aData['data']['recList'] = $aRecList ?? [];
        $this->aData['data']['suggestList'] = $aSuggestList ?? [];

        $this->aData['data']['comRegApiKey'] = $strComRegApiKey;
        $this->aData['data']['tagCategory'] = $configCompanyTagModel->getTagList();
        $this->aData['data']['companyInfo'] = $aCompanyInfo['company'];
        $this->aData['data']['getMemIdx'] = $this->request->getGet('memIdx') ?? '';

        // view
        $this->header();
        $this->nav();
        echo view('prime/company/write', $this->aData);
        $this->footer();
    }

    public function create()
    {
        $this->commonData();

        $strComName = $this->request->getPost('com_name'); // 제목
        $strComRegNumber = $this->request->getPost('com_reg_number'); // 정규직,계약직, 등

        $strComCeoName = $this->request->getPost('com_ceo_name'); // ceo이름
        $iComHeadCount = $this->request->getPost('com_head_count'); // 직원수
        $strComAnniversary = $this->request->getPost('com_anniversary'); // 설립년도
        $strComAnniversary = str_replace('-', '', $strComAnniversary);
        $iComTel = $this->request->getPost('com_tel'); // 전화번호

        $strComIndustry = $this->request->getPost('com_industry'); // 산업군
        $strComForm = $this->request->getPost('com_form'); // 기업형태

        $strProfileFile = $this->request->getPost('profileFile'); // 썸네일
        $strFilePath = $this->request->getPost('filePath');
        $strFileSize = $this->request->getPost('fileSize');

        $iMemIdx =  $this->request->getPost('memIdx');
        $aComTag = $this->request->getPost('comTag');
        print_R($strComAnniversary);

        if (!$strComName || !$strComRegNumber || !$strComCeoName || !$iComHeadCount || !$strComAnniversary || !$iComTel || !$strComIndustry || !$strComForm) {
            alert_back($this->globalvar->aMsg['error1']);
            exit;
        }

        //트랜잭션 start
        $this->masterDB->transBegin();

        if ($strProfileFile && $strFilePath && $strFileSize) {
            $this->masterDB->table('iv_file')
                ->set([
                    'file_type' => 'C',
                    'file_org_name' => $strProfileFile,
                    'file_save_name' => $strFilePath,
                    'file_size' => $strFileSize,
                ])
                ->set(['file_reg_date' => 'NOW()'], '', false)
                ->set(['file_mod_date' => 'NOW()'], '', false)
                ->insert();
            $iFileIdx = $this->masterDB->insertID();
        }

        if (isset($iFileIdx)) {
            $this->masterDB->table('iv_company')->set(['file_idx_logo' => $iFileIdx]);
        }

        $this->masterDB->table('iv_company')
            ->set([
                'com_name' => $strComName,
                'com_reg_number' => $strComRegNumber,
                'com_ceo_name' => $strComCeoName,
                'com_head_count' => $iComHeadCount,
                'com_anniversary' => $strComAnniversary,
                'com_tel' => $iComTel,
                'com_industry' => $strComIndustry,
                'com_form' => $strComForm,
                'mem_idx' => $iMemIdx ?? null
            ])
            ->set(['com_mod_date' => 'NOW()'], '', false)
            ->set(['com_reg_date' => 'NOW()'], '', false)
            ->insert();
        $iComIdx = $this->masterDB->insertID();

        foreach ($aComTag as $val) {
            $this->masterDB->table('iv_company_tag')
                ->set([
                    'com_idx' => $iComIdx,
                    'config_tag_idx' => $val,
                    'delyn' => 'N'
                ])
                ->insert();
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

    public function action($iComIdx)
    {
        $this->commonData();

        $strComName = $this->request->getPost('com_name'); // 제목
        $strComRegNumber = $this->request->getPost('com_reg_number'); // 정규직,계약직, 등

        $strComCeoName = $this->request->getPost('com_ceo_name'); // ceo이름
        $iComHeadCount = $this->request->getPost('com_head_count'); // 직원수
        $strComAnniversary = $this->request->getPost('com_anniversary'); // 설립년도
        $iComTel = $this->request->getPost('com_tel'); // 설립년도

        $strComIndustry = $this->request->getPost('com_industry'); // 산업군
        $strComForm = $this->request->getPost('com_form'); // 기업형태

        $strProfileFile = $this->request->getPost('profileFile'); // 썸네일
        $strFilePath = $this->request->getPost('filePath');
        $strFileSize = $this->request->getPost('fileSize');

        $aComTag = $this->request->getPost('comTag') ?? [];

        //트랜잭션 start
        $this->masterDB->transBegin();

        if ($strProfileFile && $strFilePath && $strFileSize) {
            $this->masterDB->table('iv_file')
                ->set([
                    'file_type' => 'C',
                    'file_org_name' => $strProfileFile,
                    'file_save_name' => $strFilePath,
                    'file_size' => $strFileSize,
                ])
                ->set(['file_reg_date' => 'NOW()'], '', false)
                ->set(['file_mod_date' => 'NOW()'], '', false)
                ->insert();
            $iFileIdx = $this->masterDB->insertID();
        }

        if (isset($iFileIdx)) {
            $this->masterDB->table('iv_company')->set(['file_idx_logo' => $iFileIdx]);
        }

        $this->masterDB->table('iv_company')
            ->set([
                'com_name' => $strComName,
                'com_reg_number' => $strComRegNumber,
                'com_ceo_name' => $strComCeoName,
                'com_head_count' => $iComHeadCount,
                'com_anniversary' => $strComAnniversary,
                'com_tel' => $iComTel,
                'com_industry' => $strComIndustry,
                'com_form' => $strComForm
            ])
            ->set(['com_mod_date' => 'NOW()'], '', false)
            ->where(['idx' => $iComIdx])
            ->update();

        $this->masterDB->table('iv_company_tag')
            ->set([
                'delyn' => 'Y'
            ])
            ->where(['com_idx' => $iComIdx])
            ->update();

        foreach ($aComTag as $val) {
            $this->masterDB->table('iv_company_tag')
                ->set([
                    'com_idx' => $iComIdx,
                    'config_tag_idx' => $val,
                    'delyn' => 'N'
                ])
                ->insert();
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
}
