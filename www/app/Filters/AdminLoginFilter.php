<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Libraries\GlobalvarLib;

class AdminLoginFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Do something here
        $globalvar = new GlobalvarLib();
        // 세션설정
        $session = session();
        if (in_array($session->get('mem_type'), ['A', 'L']) && (in_array($request->getIPAddress(), [$globalvar->getADevIp()]) || in_array($globalvar->getServerHost(), ['webtest', 'test', 'real'])
        )) {
            return redirect($globalvar->getAdminMain());
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
