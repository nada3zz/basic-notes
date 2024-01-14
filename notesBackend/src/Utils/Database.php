<?php

namespace NotesApp\Utils;

class Database
{
    public static function connect()
    {
        $config = include_once(__DIR__ . '/../Config/env.php');

        $host = $config['host'];
        $dbname = $config['dbname'];
        $user = $config['user'];
        $password = $config['password'];

        $dsn = "mysql:host=$host;dbname=$dbname";
        $pdo = new \PDO($dsn, $user, $password);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }
}
