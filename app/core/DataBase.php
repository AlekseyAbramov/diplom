<?php

namespace diplomApp\core;

class DataBase
{
    private static $db;

    public static function connect(\diplomApp\core\Config $config)
    {
        try {
            if (!self::$db) {
                self::$db = new \PDO('mysql:host=' . $config->getConfig('host') . ';dbname=' . $config->getConfig('dbname') . ';charset=utf8', $config->getConfig('login'), $config->getConfig('pass'));
            }
        } catch (\PDOException $e) {
            die('Database error: ' . $e->getMessage() . '<br/>');
        }
    }
    
    public function getDataBase()
    {
        return self::$db;
    }
}