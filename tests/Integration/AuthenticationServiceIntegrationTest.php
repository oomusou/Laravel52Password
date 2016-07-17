<?php

use App\Services\AuthClient;
use App\Services\AuthenticationService;
use App\Services\AuthToken;
use App\Services\AuthUser;


class AuthenticationServiceTest extends TestCase
{
    /** @test */
    public function 拿到Token()
    {
        /** arrange */
        $expected = [1];

        /** act */
        $clientId = 1;
        $clientSecret = 1;
        $account = 1;
        $password = 1;

        $actual = App::make(AuthenticationService::class)
            ->verifyAuth($clientId, $clientSecret)
            ->verifyUser($account, $password)
            ->getAccessToken();

        /** assert */
        $this->assertEquals($expected, $actual);
    }
}
