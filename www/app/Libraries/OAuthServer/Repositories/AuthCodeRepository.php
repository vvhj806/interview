<?php

namespace App\Libraries\OAuthServer\Repositories;

use App\Libraries\OAuthServer\Entities\AuthCodeEntity;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use Config\Database;

class AuthCodeRepository implements AuthCodeRepositoryInterface
{
    public $masterDB;
    public function __construct()
    {
        $this->masterDB = Database::connect('master');
    }

    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity)
    {
        // Some logic to persist the auth code to a database
    }

    public function revokeAuthCode($codeId)
    {
        // Some logic to revoke the auth code in a database
    }

    public function isAuthCodeRevoked($codeId)
    {
        return false; // The auth code has not been revoked
    }

    public function getNewAuthCode()
    {
        return new AuthCodeEntity();
    }

    public function __destruct()
    {
        $this->masterDB->close();
    }
}
