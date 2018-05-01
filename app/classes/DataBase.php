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
    private static $host = 'localhost';
    private static $dbname = 'diplom';
    private static $user = 'root';
    private static $pass = '';
    
    public static function connect()
    {
        try {
            $db = new \PDO('mysql:host='. self::$host.';dbname='. self::$dbname.';charset=utf8', self::$user, self::$pass);
            } catch (PDOException $e) {
                die('Database error: '.$e->getMessage().'<br/>');
            }
            return $db;
        }
}