<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Libraries\GlobalvarLib;

class WwwTempUserFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Do something here
        $globalvar = new GlobalvarLib();
        helper(['alert', 'uri']);
        $uri = uri_string();
        // 로그인 체크
        $session = session();
        if (!in_array($session->get('mem_type'), ['M', 'U', 'A', 'L'])) {
            $_SESSION['backLogin'] = $uri;
            alert_url($globalvar->aMsg['error11'], "/login");
            exit;
            // return redirect()->to($globalvar->getWwwUrl());
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
