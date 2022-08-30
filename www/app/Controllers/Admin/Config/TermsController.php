<?php

namespace App\Controllers\Admin\Config;

use App\Controllers\BaseController;

use Config\Database;
use App\Models\ConfigModel;
use Config\Services;

class TermsController extends BaseController
{
    public $db;
    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function commonData(): array
    {
        // data init
        $aData = [];
        $aData['data'] = $this->viewData;

        $session = session();
        $aData['data']['session'] = [
            'id' => $session->get('mem_id')
        ];
        return $aData;
    }


    public function header()
    {
        // data init
        $aData = $this->commonData();
        echo view('prime/templates/header', $aData);
    }

    public function nav()
    {
        // data init
        $aData = $this->commonData();
        echo view('prime/templates/topNav', $aData);
        echo view('prime/templates/leftNav', $aData);
        echo view('prime/templates/contentHeader.php', $aData);
    }

    public function footer()
    {
        // data init
        $aData = $this->commonData();
        echo view('prime/templates/contentFooter.php', $aData);
        echo view('prime/templates/footer.php', $aData);
    }

    public function index()
    {
        $this->terms();
    }

    public function terms()
    {
        // data init
        $aData = $this->commonData();
        $configModel = new ConfigModel('iv_config');
        $aRow = $configModel->getConfigType('T');
        $tmpArrData = [];
        foreach ($aRow[0] as $key => $val) {
            if (in_array($key, ['idx', 'cfg_reg_date', 'cfg_mod_date', 'cfg_del_date', 'delyn'])) {
                continue;
            }
            $tmpArrData[$key] = $val;
        }
        $aData['data']['terms'] = $tmpArrData;
        // view
        $this->header();
        $this->nav();
        echo view('prime/config/terms', $aData);
        $this->footer();
    }

    public function termsAction()
    {
        //action page
        $strType = $this->request->getPost('cfg_type');
        $strUseYN = $this->request->getPost('cfg_useYN');
        $strContent = $this->request->getPost('cfg_content');
        if (!$strType || !$strUseYN || !$strContent || $strType != 'T') {
            return alert_back('잘못된접근입니다.');
        }
        $configModel = new ConfigModel('iv_config');
        $saveData = [
            'cfg_type' => $strType,
            'cfg_useYN' => $strUseYN,
            'cfg_content' => $strContent,
        ];
        $configModel->save($saveData);
        return alert_url('저장하였습니다.','/prime/config/terms');
    }

    public function __destruct()
    {
        $this->db->close();
    }
}
