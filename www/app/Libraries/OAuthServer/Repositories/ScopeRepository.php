<?php

namespace App\Libraries\OAuthServer\Repositories;

use App\Libraries\OAuthServer\Entities\ScopeEntity;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use Config\Database;

class ScopeRepository implements ScopeRepositoryInterface
{
    public $masterDB;
    public function __construct()
    {
        $this->masterDB = Database::connect('master');
    }
    public function getScopeEntityByIdentifier($scopeIdentifier)
    {
        $scopes = [
            'basic' => [
                'description' => 'Basic information'
            ],
            'email' => [
                'description' => 'wedd4860@naver.com',
            ],
        ];
        if (array_key_exists($scopeIdentifier, $scopes) === false) return null;
        $scope = new ScopeEntity();
        $scope->setIdentifier($scopeIdentifier);
        return $scope;
    }

    public function finalizeScopes(
        array $scopes,
        $grantType,
        ClientEntityInterface $clientEntity,
        $userIdentifier = null
    ) {
        if ((int) $userIdentifier === 1) {
            $scope = new ScopeEntity();
            $scope->setIdentifier('email');
            $scopes[] = $scope;
        }
        return $scopes;
    }

    public function __destruct()
    {
        $this->masterDB->close();
    }
}
