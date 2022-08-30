<?php

namespace App\Controllers\Rest;

use Heimdall\Interfaces\AuthorizationController;
use App\Controllers\BaseController;
use App\Libraries\OAuthServer\Entities\UserEntity;
use App\Libraries\OAuthServer\OAuthServer;
use Exception;

class Authorization extends BaseController implements AuthorizationController
{

    private $heimdall;

    function __construct()
    {
        // get a new instance of HeimdallAuthorizationServer
        $this->heimdall = OAuthServer::createAuthorizationServer();

        // bootsrap heimdall with the codeigniter's request & response
        $this->heimdall->bootstrap($this->request, $this->response);
    }

    // authorization code generation endpoint
    function authorize()
    {
        //인증코드 생성 엔드포인트
        try {
            $authRequest = $this->heimdall->validateAuth();
            $authRequest->setUser(new UserEntity());
            $this->heimdall->completeAuth($authRequest);
        } catch (Exception $exception) {
            $this->heimdall->handleException($exception);
        }
    }

    // access token generation endpoint
    function token()
    {
        try {
            $this->heimdall->createToken();
        } catch (Exception $exception) {
            $this->heimdall->handleException($exception);
        }
    }
}
