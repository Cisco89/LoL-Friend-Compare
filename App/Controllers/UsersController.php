<?php

namespace App\Controllers;

use App\Models\UsersModel;

class UsersController extends BaseController
{
    public function create()
    {
        $model = new UsersModel();
        $model->insert(1);
        return $this->view->render('users_register.html', [
            'user' => 'Cisco'
        ]);
    }

    public function store()
    {

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
