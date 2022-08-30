<?php

namespace App\Libraries\OAuthServer\Entities;

use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\UserEntityInterface;

class UserEntity implements UserEntityInterface
{
    use EntityTrait;

    public function __construct($identifier = 1)
    {
        $this->setIdentifier($identifier);
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }
}
