<?php

namespace App\Controllers\Admin\Tool;

use App\Models\{ApplierModel};
use Config\{Database, Services};
use App\Libraries\{
    GlobalvarLib,
    EncryptLib
};

use App\Controllers\Admin\AdminController;

class ToolController extends AdminController
{
    public function decrypt()
    {
        //get
        $strEncode1 = $this->request->getGet('encode1');
        $strDecode1 = $this->request->getGet('decode1');
        $strEncode2 = $this->request->getGet('encode2');
        $strDecode2 = $this->request->getGet('decode2');
        //init
        $this->commonData();
        //model
        $this->encrypter = Services::encrypter();
        $encryptLib = new EncryptLib();

        if ($strEncode1) {
            $strEncode1After = base64url_encode($this->encrypter->encrypt($strEncode1));
        }
        if ($strDecode1) {
            $strDecode1After = $this->encrypter->decrypt(base64url_decode($strDecode1));
            $strDecode1After = str_replace('"', '', $strDecode1After);
        }

        if ($strEncode2) {
            $strEncode2After = $encryptLib->setEncrypt($strEncode2, 'bluevisorencrypt');
        }
        if ($strDecode2) {
            $strDecode2After = $encryptLib->setDecrypt($strDecode2, 'bluevisorencrypt');
        }

        $this->aData['data']['encode1'] = ['before' => $strEncode1, 'after' => $strEncode1After ?? ''];
        $this->aData['data']['decode1'] = ['before' => $strDecode1, 'after' => $strDecode1After ?? ''];
        $this->aData['data']['encode2'] = ['before' => $strEncode2, 'after' => $strEncode2After ?? ''];
        $this->aData['data']['decode2'] = ['before' => $strDecode2, 'after' => $strDecode2After ?? ''];

        // view
        $this->header();
        $this->nav();
        echo view('prime/tool/decrypt', $this->aData);
        $this->footer();
    }
}
