<?php

namespace App\Libraries\OAuthServer\Repositories;

use App\Libraries\OAuthServer\Entities\ClientEntity;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use Config\Database;

class ClientRepository implements ClientRepositoryInterface
{
    public $masterDB;

    public function __construct()
    {
        $this->masterDB = Database::connect('master');
    }

    // change this to your authorization url
    const REDIRECT_URI = 'https://localinterviewr.highbuff.com/sns/highbuff/web/call';

    public function getClientEntity($clientIdentifier)
    {
        $client = new ClientEntity();
        $client->setIdentifier($clientIdentifier);
        $client->setName(getenv('app.name'));
        $client->setRedirectUri(ClientRepository::REDIRECT_URI);
        $client->setConfidential();
        return $client;
    }

    public function validateClient($clientIdentifier, $clientSecret, $grantType)
    {
        $clients = [
            'test' => [
                'secret'          => password_hash('test123', PASSWORD_BCRYPT),
                'name'            => getenv('app.name'),
                'redirect_uri'    => ClientRepository::REDIRECT_URI,
                'is_confidential' => true,
            ],
        ];

        if (array_key_exists($clientIdentifier, $clients) === false) {
            return false;
        }

        if (
            $clients[$clientIdentifier]['is_confidential'] === true
            && password_verify($clientSecret, $clients[$clientIdentifier]['secret']) === false
        ) {
            return false;
        }

        return true;
    }
}
