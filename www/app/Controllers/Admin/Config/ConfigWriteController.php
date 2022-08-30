<?php

namespace App\Controllers\Admin\Config;

use App\Models\ConfigModel;
use App\Controllers\Admin\AdminController;

class ConfigWriteController extends AdminController
{
    private $backUrlList = '/prime/config/terms';

    public function index()
    {
        alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
        exit;
    }

    public function configWrite(string $code)
    {
        if (!in_array($code, ['terms', 'agreement', 'private'])) {
            alert_url($this->globalvar->aMsg['error1'], $this->backUrlList);
            exit;
        }

        // data init
        $this->commonData();
        $configModel = new ConfigModel();
        $aConfigRow = $configModel->getConfigType($code);

        $this->aData['data']['list'] = $aConfigRow;
        $this->aData['data']['aData'] = [
            'code' => $code
        ];

        // view
        $this->header();
        $this->nav();
        echo view('prime/config/write', $this->aData);
        $this->footer();
    }

    public function configSettings() {

        // data init
        $this->commonData();
        $configModel = new ConfigModel();
        $agreement = $configModel->getConfigType('agreement');
        $terms = $configModel->getConfigType('terms');
        $private = $configModel->getConfigType('private');

        $this->aData['data']['agreement'] = $agreement;
        $this->aData['data']['terms'] = $terms;
        $this->aData['data']['private'] = $private;

        $this->aData['data']['aData'] = [
            'code' => 'agreement'
        ];

        // view
        $this->header();
        $this->nav();
        echo view('prime/config/settings', $this->aData);
        $this->footer();
    }
}
