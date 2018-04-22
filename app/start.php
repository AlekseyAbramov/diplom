<?php

$view = new \diplomApp\core\View();
$controller = new \diplomApp\core\Controller();
$router = new \diplomApp\core\Router();

//Подключаемся к базе данных
$config = require_once 'config.php';
$db = \diplomApp\classes\DataBase::connect(
        $config['mysql']['host'],
        $config['mysql']['dbname'],
        $config['mysql']['user'],
        $config['mysql']['pass']
);

//Запускаем роутер
$router->start($db);