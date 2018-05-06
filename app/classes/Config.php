<?php

namespace diplomApp\classes;
/**
     * Подключение к базе данных mysql
     * @param $host адрес
     * @param $dbname название базы
     * @param $user пользователь
     * @param $pass пароль
     */
class Config {
    public static $host = 'localhost';
    public static $dbname = 'diplom';
    public static $user = 'root';
    public static $pass = '';
}
