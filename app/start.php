<?php

$router = new \diplomApp\core\Router();

//Подключаемся к базе данных
$config = new \diplomApp\Config();
$db = \diplomApp\classes\DataBase::connect(
        $config['mysql']['host'],
        $config['mysql']['dbname'],
        $config['mysql']['user'],
        $config['mysql']['pass']
);

//Запускаем роутер
$router->start($db);