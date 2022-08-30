<?php

namespace App\Filters;

use App\Libraries\OAuthServer\OAuthServer;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Exception;

class ResourceFilter implements FilterInterface
{

    private $heimdall;

    function __construct()
    {
        // get a new HeimdallResourceServer instance
        $this->heimdall = OAuthServer::createResourceServer();
    }

    // apply a access token verification on codeigniter's request action
    function before(RequestInterface $request, $arguments = null)
    {
        try {
            $this->heimdall->validate($request);
        } catch (Exception $exception) {
            $this->heimdall->handleException($exception);
        }
    }

    function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
