<?php

namespace App\Controllers;

use App\Models\UsersModel;
use Zend\Diactoros\ServerRequest;

class UsersController extends BaseController
{
    public function create()
    {
        return $this->view->render('users_register.html');
    }

    public function store(ServerRequest $request)
    {
        if ( $request->getParsedBody()['password'] !== $request->getParsedBody()['repeatPassword']) {
            echo 'Passwords do not match!';
            return;
        }

        echo 'Passwords Match!';
        return;
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
