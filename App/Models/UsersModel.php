<?php

namespace App\Models;

class UsersModel extends BaseModel
{

    public function __construct()
    {
        parent::__construct();
        $this->table = "users";
    }

    public function findAll()
    {
        // @TODO: Implement findAll() method.
    }

    public function findOne()
    {
        // @TODO: Implement findOne() method.
    }
}
