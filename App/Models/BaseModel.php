<?php

namespace App\Models;

use Exception;
use PDO;

abstract class BaseModel
{
    protected $table;
    protected $pdo;

    public function __construct()
    {
        $host = 'database';
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

    abstract public function findOne(Array $getParseBody);

    /**
     * @param array $data
     * @throws Exception
     */
    public function create(Array $data) {
        $columns = implode(",", array_keys($data));
        $values = implode("','", $data);
        $query = sprintf("insert into %s (%s) values ('%s')", $this->table, $columns, $values);
        $statement = $this->pdo->prepare($query);
        if (!$statement->execute()){
            throw new Exception('Failed to create entry.');
        }
    }
}
