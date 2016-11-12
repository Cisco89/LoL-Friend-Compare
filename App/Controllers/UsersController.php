<?php

namespace App\Controllers;

class UsersController extends BaseController
{
    public function create()
    {
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
