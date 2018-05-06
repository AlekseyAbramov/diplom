<?php

namespace diplomApp\classes;
/**
     * Подключение к базе данных mysql
     * @param $host адрес
     * @param $dbname название базы
     * @param $user пользователь
     * @param $pass пароль
     */
class DataBase
{
    public static function connect($config)
    {
        try {
            $db = new \PDO('mysql:host=' . $config::$host . ';dbname=' . $config::$dbname . ';charset=utf8', $config::$user, $config::$pass);
            } catch (PDOException $e) {
                die('Database error: '.$e->getMessage().'<br/>');
            }
            return $db;
        }
}