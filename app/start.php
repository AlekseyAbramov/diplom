<?php
//Подключаемся к базе данных
$config = new \diplomApp\core\Config();
$dbConnect = new \diplomApp\core\DataBase($config);
//Запускаем роутер
$router = new \diplomApp\core\Router($dbConnect, $config);
$router->start();