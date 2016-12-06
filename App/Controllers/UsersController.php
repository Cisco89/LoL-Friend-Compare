<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Services\AuthenticateService;
use Zend\Diactoros\ServerRequest;

class UsersController extends BaseController
{
    private $authenticateService;

    public function __construct()
    {
        $this->authenticateService = new AuthenticateService();

        parent::__construct();
    }

    public function create()
    {
        return $this->view->render('users_register.html');
    }

    public function store(ServerRequest $request)
    {

        if (!$this->authenticateService->register($request)) {

            header('Location: http://lol-friend-compare.local/users/registration');
            exit();

        }

        header('Location: http://lol-friend-compare.local/users/login');
        exit();
    }

    public function login()
    {
        return $this->view->render('users_login.html');
    }

    public function validate(ServerRequest $request)
    {
        /** @var UsersModel $user */
        $user = $this->authenticateService->login($request);

        if (!$user) {

            header('Location: http://lol-friend-compare.local/users/login');
            exit();
        }
        return $this->view->render('welcome_user.html', ['summoners'=>$user->summoners()]);
    }

    public function logout()
    {
        if (!$this->authenticateService->logout()) {

            throw new \Exception();
        }

        return $this->view->render('successful_logout.html');
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
