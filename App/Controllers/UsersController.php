<?php

namespace App\Controllers;

use App\Models\UsersModel;
use Zend\Diactoros\Request;

class UsersController extends BaseController
{
    public function create()
    {
        return $this->view->render('users_register.html');
    }

    public function store(Request $request)
    {
        $model = new UsersModel();
        $model->insert();

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
