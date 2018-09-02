<?php

$router = new \diplomApp\core\Router();

//Подключаемся к базе данных
$config = new \diplomApp\core\Config();
$dbConnect = new \diplomApp\core\DataBase();
$dbConnect::connect($config);
//Запускаем роутер
$router->start($dbConnect);