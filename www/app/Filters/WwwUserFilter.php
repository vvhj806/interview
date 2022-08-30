<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Libraries\GlobalvarLib;

class WwwUserFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Do something here
        $globalvar = new GlobalvarLib();
        helper(['alert']);

        // if ($globalvar->getServerHost() != 'test') {
        //     if (!in_array($request->getIPAddress(), $globalvar->getADevIp())) { //점검 todo
        //         echo view('notice');
        //         exit;
        //     }
        // }

        // 로그인 체크
        $session = session();
        if ($session->has('idx')) {
            if (!in_array($type = $session->get('mem_type'), ['M', 'U'])) {
                if ($type === 'C') {
                    // alert_url($globalvar->aMsg['error1'], "/biz/login");
                } else if ($type === 'A') {
                    alert_url($globalvar->aMsg['error1'], "/prime/login");
                    exit;
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
