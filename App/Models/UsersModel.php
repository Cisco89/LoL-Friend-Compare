<?php
/**
 * Created by PhpStorm.
 * User: cisco
 * Date: 11/12/16
 * Time: 1:11 AM
 */

namespace App\Models;


class UsersModel extends BaseModel
{

    public function __construct()
    {
        $this->table = "users";
    }

    public function findAll()
    {
        // TODO: Implement findAll() method.

    }

    public function findOne()
    {
        // TODO: Implement findOne() method.
    }
}