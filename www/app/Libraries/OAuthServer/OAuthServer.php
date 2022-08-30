<?php

namespace App\Libraries\OAuthServer;

use Heimdall\Heimdall;
use Heimdall\Server\HeimdallAuthorizationServer;
use Heimdall\Server\HeimdallResourceServer;
use App\Libraries\OAuthServer\Repositories\AccessTokenRepository;
use App\Libraries\OAuthServer\Repositories\AuthCodeRepository;
use App\Libraries\OAuthServer\Repositories\ClientRepository;
use App\Libraries\OAuthServer\Repositories\IdentityRepository;
use App\Libraries\OAuthServer\Repositories\RefreshTokenRepository;
use App\Libraries\OAuthServer\Repositories\ScopeRepository;

abstract class OAuthServer
{

    // function to create a new instance of HeimdallAuthorizationServer
    static function createAuthorizationServer()
    {
        // creating HeimdallAuthorizationServer config
        $config = Heimdall::withAuthorizationConfig(
            new ClientRepository(),
            new AccessTokenRepository(),
            new ScopeRepository(),
            __DIR__ . '/private.key'
        );

        // creating HeimdallAuthorizationServer grant
        $grant = Heimdall::withAuthorizationCodeGrant(
            new AuthCodeRepository(),
            new RefreshTokenRepository()
            // 'PT10M'
            // 'PT10M' : 10분 동안 지속
            // 'P1M' : 1개월 지속
            // 'PT1H' : 1시간 지속
        );

        // return a new instance of HeimdallAuthorizationServer
        return Heimdall::initializeAuthorizationServer($config, $grant);
    }

    // function to create a new instance of HeimdallResourceServer
    static function createResourceServer()
    {
        // creating HeimdallResourceServer config
        $config = Heimdall::withResourceConfig(
            new AccessTokenRepository(),
            __DIR__ . '/public.key'
        );

        // return a new instance of HeimdallResourceServer
        return Heimdall::initializeResourceServer($config);
    }
}
