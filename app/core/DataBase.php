<?php

namespace diplomApp\core;

class DataBase
{
    private static $db;

    // @todo добавляем type hinting для объекта класс diplomApp\core\Config
    public static function connect($config)
    {
        try {
            if (!self::$db) {
                self::$db = new \PDO('mysql:host=' . $config->getConfig('host') . ';dbname=' . $config->getConfig('dbname') . ';charset=utf8', $config->getConfig('login'), $config->getConfig('pass'));
            }
        } catch (\PDOException $e) {
            // @todo поправить форматирование
                die('Database error: ' . $e->getMessage() . '<br/>');
            }
    }

    public function getDataBase()
    {
        return self::$db;
    }
}