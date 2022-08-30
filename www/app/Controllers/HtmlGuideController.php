<?php

namespace App\Controllers;

use App\Models\MemberModel;
use \App\Libraries\Encrypt;

class HtmlGuideController extends BaseController
{
    public function index()
    {
        return view('dev/index.php');
    }
}
