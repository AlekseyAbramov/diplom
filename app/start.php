<?php

// Можно отдельный класс сделать для хранения всех классов
// Например App или DependencyInjection или Registry или ServiceContainer

$router = new \diplomApp\core\Router();

//Подключаемся к базе данных
$config = new \diplomApp\core\Config();
$dbConnect = new \diplomApp\core\DataBase();
$dbConnect::connect($config);
//Запускаем роутер
$router->start($dbConnect);