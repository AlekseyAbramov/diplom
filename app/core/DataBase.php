<?php

namespace diplomApp\core;

class DataBase
{
    public static function connect($config)
    {
        try {
            $db = new \PDO('mysql:host=' . $config["database"]["host"] . ';dbname=' . $config["database"]["dbname"] . ';charset=utf8', $config["database"]["login"], $config["database"]["pass"]);
            } catch (\PDOException $e) {
                die('Database error: ' . $e->getMessage() . '<br/>');
            }
            return $db;
    }
}