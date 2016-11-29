<?php

namespace App\Models;

use Exception;

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

    public function findOne(Array $userData)
    {
        $query = "select `password` from `users` where `username` = '{$userData['username']}';";
        $statement = $this->pdo->prepare($query);
        if (!$statement->execute()) {
            throw new Exception('Failed to create entry.');
        }
        return $statement->fetch();
    }
}
