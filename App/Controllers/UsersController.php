<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Services\AuthenticateService;
use Zend\Diactoros\ServerRequest;

class UsersController extends BaseController
{
    public function create()
    {
        return $this->view->render('users_register.html');
    }

    public function store(ServerRequest $request)
    {
        // @todo evaluate scope
        $authenticate = new AuthenticateService();

        if (!$authenticate->register($request)){

            header('Location: http://lol-friend-compare.local/users/registration');
            exit();

        }

        // @todo implement view
        header('Location: http://lol-friend-compare.local/users/login');
        exit();
    }

    public function login()
    {
        session_start();
        return $this->view->render('users_login.html');
    }

    public function validate(ServerRequest $request)
    {
        $validate = new AuthenticateService();

        if (!$validate->login($request)){

            header('Location: http://lol-friend-compare.local/users/login');
            exit();
        }
        return $this->view->render('welcome_user.html');
    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
