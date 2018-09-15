<?php
// Можно отдельный класс сделать для хранения всех классов
// Например App или DependencyInjection или Registry или ServiceContainer

//Подключаемся к базе данных
$config = new \diplomApp\core\Config();
$dbConnect = new \diplomApp\core\DataBase();
$dbConnect::connect($config);
//Запускаем роутер
$router = new \diplomApp\core\Router($dbConnect, $config);
$router->start();