<?php

namespace App\Services;

use Exception;

class AuthenticationService
{
    /** @var  AuthClient */
    private $authClient;
    /** @var  AuthUser */
    private $authUser;
    /** @var  AuthToken */
    private $authToken;

    protected $client;
    protected $user;

    /**
     * AuthenticationService constructor.
     * @param AuthClient $authClient
     * @param AuthUser $authUser
     * @param AuthToken $authToken
     */
    public function __construct(AuthClient $authClient, AuthUser $authUser, AuthToken $authToken)
    {
        $this->authClient = $authClient;
        $this->authUser = $authUser;
        $this->authToken = $authToken;
    }


    public function verifyAuth($clientId, $clientSecret)
    {
        $this->client = $this->authClient->findByIdSecret($clientId, $clientSecret);

        if (!$this->client) {
            throw new Exception();
        }

        return $this;
    }

    public function verifyUser($account, $password)
    {
        $this->user = $this->authUser->findByAccountPassword($account, $password);

        if (!$this->user) {
            throw new Exception();
        }

        return $this;
    }

    public function getAccessToken()
    {
        return $this->authToken
            ->create([
                'client_id' => $this->client,
                'user_id'   => $this->user
            ]);
    }
}