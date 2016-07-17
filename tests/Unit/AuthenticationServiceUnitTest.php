<?php

use App\Services\AuthClient;
use App\Services\AuthenticationService;
use App\Services\AuthToken;
use App\Services\AuthUser;


class AuthenticationServiceUnitTest extends TestCase
{
    private $mockAuth;
    private $mockUser;
    private $mockToken;

    protected function setUp()
    {
        parent::setUp();
        $this->mockAuth = Mockery::mock(AuthClient::class);
        App::instance(AuthClient::class, $this->mockAuth);

        $this->mockUser = Mockery::mock(AuthUser::class);
        App::instance(AuthUser::class, $this->mockUser);

        $this->mockToken = Mockery::mock(AuthToken::class);
        App::instance(AuthToken::class, $this->mockToken);
    }

    /** @test */
    public function Auth成功()
    {
        /** arrange */
        $expected = 1;

        $this->mockAuth->shouldReceive('findByIdSecret')
            ->once()
            ->withAnyArgs()
            ->andReturn($expected);

        /** act */
        $clientId = 1;
        $clientSecret = 1;
        $actual = App::make(AuthenticationService::class)
            ->verifyAuth($clientId, $clientSecret);

        /** assert */
        $this->assertAttributeEquals($expected, 'client', $actual);
    }

    /**
     * @test
     * @expectedException Exception
     */
    public function Auth失敗()
    {
        /** arranage */
        $expected = null;

        $this->mockAuth->shouldReceive('findByIdSecret')
            ->once()
            ->withAnyArgs()
            ->andReturn($expected);

        /** act */
        $clientId = 1;
        $clientSecret = 1;
        App::make(AuthenticationService::class)
            ->verifyAuth($clientId, $clientSecret);

        /** assert */

    }

    /** @test */
    public function User密碼成功()
    {
        /** arrange */
        $expected = 1;
        $this->mockUser->shouldReceive('findByAccountPassword')
            ->once()
            ->withAnyArgs()
            ->andReturn($expected);


        /** act */
        $account = 1;
        $password = 1;
        $actual = App::make(AuthenticationService::class)
            ->verifyUser($account, $password);

        /** assert */
        $this->assertAttributeEquals($expected, 'user', $actual);
    }

    /**
     * @test
     ** @expectedException Exception
     */
    public function User密碼失敗()
    {
        /** arrange */
        $expected = null;

        $this->mockUser->shouldReceive('findByAccountPassword')
            ->once()
            ->withAnyArgs()
            ->andReturn($expected);

        /** act */
        $account = 1;
        $password = 1;
        App::make(AuthenticationService::class)
            ->verifyUser($account, $password);

        /** assert */

    }

    /** @test */
    public function 取得Token()
    {
        /** arrange */
        $expected = [1];

        $this->mockToken->shouldReceive('create')
            ->once()
            ->withAnyArgs()
            ->andReturn($expected);

        /** act */
        $actual = App::make(AuthenticationService::class)
            ->getAccessToken();

        /** assert */
        $this->assertEquals($expected, $actual);
    }
}
