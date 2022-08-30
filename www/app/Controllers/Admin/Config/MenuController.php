<?php

namespace App\Controllers\Admin\Config;

use App\Models\{
    SetAdminRuleModel,
    SetAdminMenuModel,
};
use App\Controllers\Admin\AdminController;

class  MenuController extends AdminController
{
    private $backUrlList = '/prime/config/menu';

    public function index()
    {
        alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
        exit;
    }

    public function main()
    {
        // data init
        $this->commonData();

        //model
        $SetAdminMenuModel = new SetAdminMenuModel();

        $aMenuList = $SetAdminMenuModel->getMenu();

        // // view
        $this->aData['data']['menuList'] = $aMenuList; //menu

        $this->header();
        $this->nav();
        echo view('prime/config/menu', $this->aData);
        $this->footer();
    }
}
