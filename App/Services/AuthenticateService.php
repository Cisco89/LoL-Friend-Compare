<?php

namespace App\Services;

use Cartalyst\Sentinel\Native\SentinelBootstrapper;
use Zend\Diactoros\ServerRequest;
use Cartalyst\Sentinel\Native\Facades\Sentinel;

class AuthenticateService
{
    private $sentinel;

    public function __construct()
    {
        $config = include BASEPATH . '/App/Config/sentinelConfig.php';
        $sentinelBootstrapper = new SentinelBootstrapper($config);
        $facade = new Sentinel($sentinelBootstrapper);
        $this->sentinel = $facade->getSentinel();
    }

    /**
     * @param ServerRequest $request
     * @return bool
     */
    public function register(ServerRequest $request)
    {
        // @todo implement a class to return success/failure and reason for failure

        if ($request->getParsedBody()['password'] !== $request->getParsedBody()['repeatPassword']) {
            return false;
        }

        $credentials = $request->getParsedBody();
        unset($credentials['repeatPassword']);

        return $this->sentinel->register($credentials);


    }

    public function login(ServerRequest $request)
    {
        $credentials = $request->getParsedBody();

        return $this->sentinel->authenticate($credentials, true);


    }

    public function logout()
    {
        // @todo logout user from current session, provide a validation page that states logout was successful
        return $this->sentinel->logout();
    }

    public function resetPassword()
    {
        // @todo reset a user's password via sending and email link,
        // new password should not match immediate previous password
    }
}
