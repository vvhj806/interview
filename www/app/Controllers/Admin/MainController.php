<?php

namespace App\Controllers\Admin;

use App\Models\MemberModel;

use App\Controllers\Admin\AdminController;

class MainController extends AdminController
{
    public function index()
    {
        $this->main();
    }

    public function main()
    {
        // data init
        $this->commonData();

        $memberModel = new MemberModel();

        $this->aData['data']['m'] = ['join' => $memberModel->getMemCount('M', 'N'), 'leave' => $memberModel->getMemCount('M', 'Y')];
        $this->aData['data']['c'] = ['join' => $memberModel->getMemCount('C', 'N'), 'leave' => $memberModel->getMemCount('C', 'Y')];

        // view
        $this->header();
        $this->nav();
        echo view('prime/index', $this->aData);
        $this->footer();
    }
}
