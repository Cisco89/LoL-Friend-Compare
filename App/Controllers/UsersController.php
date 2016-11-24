<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Services\Authenticate;
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
        $authenticate = new Authenticate();

        if (!$authenticate->register($request)){

            header('Location: http://lol-friend-compare.local/users/registration');
            exit();

        }

        // @todo implement view
        header('Location: http://lol-friend-compare.local/users/login');
        exit();
    }

    public function show()
    {

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
