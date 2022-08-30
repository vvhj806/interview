<?php

namespace App\Libraries\OAuthServer\Repositories;

use App\Libraries\OAuthServer\Entities\RefreshTokenEntity;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use Config\Database;

class RefreshTokenRepository implements RefreshTokenRepositoryInterface
{
    public $masterDB;
    public function __construct()
    {
        $this->masterDB = Database::connect('master');
    }
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity)
    {
        // Some logic to persist the refresh token in a database
    }

    public function revokeRefreshToken($tokenId)
    {
        // Some logic to revoke the refresh token in a database
    }

    public function isRefreshTokenRevoked($tokenId)
    {
        return false; // The refresh token has not been revoked
    }

    public function getNewRefreshToken()
    {
        return new RefreshTokenEntity();
    }

    public function __destruct()
    {
        $this->masterDB->close();
    }
}
