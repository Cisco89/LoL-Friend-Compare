<?php

namespace App\Services;

use App\Models\UsersModel;
use League\Route\Http\Exception;
use Zend\Diactoros\ServerRequest;

class AuthenticateService
{
    /**
     * @param ServerRequest $request
     * @return bool
     */
    public function register(ServerRequest $request)
    {
        // @todo implement a class to return success/failure and reason for failure

        try {

            if ( $request->getParsedBody()['password'] !== $request->getParsedBody()['repeatPassword']) {
                return false;
            }
            // @todo do not allow duplicate accounts
            // @todo talk about injection
            $model = new UsersModel();

            $data = $request->getParsedBody();
            unset($data['repeatPassword']);

            $model->create($data);
            return true;

        } catch (Exception $exception) {
            return false;
        }

    }

    public function login(ServerRequest $request)
    {
        // @todo validate entries to a registered user
        try {

            if ( $request->getParsedBody()['username'] === ''
                || $request->getParsedBody()['password'] === '') {
                return false;
            }
            // @todo do not allow duplicate accounts
            // @todo talk about injection
            $model = new UsersModel();

            $user = $model->findOne( $request->getParsedBody());

            if ( $request->getParsedBody()['password'] !== $user['password']) {
                return false;
            }
            return true;

        } catch (Exception $exception) {
            return false;
        }
    }

    public function resetPassword()
    {
        // @todo reset a user's password via sending and email link,
        // new password should not match immediate previous password
    }

    public function logout()
    {
        // @todo logout user from current session, provide a validation page that states logout was successful
    }
}
