<?php

namespace App\Models;

use PDO;

abstract class BaseModel
{
    protected $table;
    protected $pdo;

    public function __construct()
    {
        $host = '127.0.0.1';
        $db = 'lol_friend_compare';
        $user = 'developer';
        $pass = 'developer';
        $charset = 'utf8';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        $opt = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false
        ];

        $this->pdo = new PDO($dsn, $user, $pass, $opt);
    }

    abstract public function findAll();

    abstract public function findOne();

    public function insert($data) {
        var_dump($this->pdo);
        die();
    }
}
