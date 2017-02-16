<?php

namespace App\Services;

use Cartalyst\Sentinel\Native\SentinelBootstrapper;
use Zend\Diactoros\ServerRequest;
use Cartalyst\Sentinel\Native\Facades\Sentinel;

class AuthenticateService
{
    /**
     * @var \Cartalyst\Sentinel\Sentinel
     */
    private $sentinel;

    // @todo leverage dependency injection here

    /**
     * AuthenticateService constructor.
     */
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

    /**
     * @param ServerRequest $request
     * @return bool
     */
    public function login(ServerRequest $request)
    {
        session_start();

        $credentials = $request->getParsedBody();

        if(!$user = $this->sentinel->authenticate($credentials, true)) {
            return false;
        }

        $_SESSION['user'] = [
            'id' => $user->getUserId(),
            'name' => $user->getUserLogin(),
        ];

        return true;
    }

    /**
     * @return bool
     */
    public function logout()
    {
        // @todo logout user from current session, provide a validation page that states logout was successful
        session_unset();
        session_destroy();

        return $this->sentinel->logout();
    }

    public function update($credentials)
    {
        $user = $_SESSION['user']['id'];

        $this->sentinel->update($user, $credentials);
    }

    public function resetPassword()
    {
        // @todo reset a user's password via sending and email link,
        // new password should not match immediate previous password
    }
}
