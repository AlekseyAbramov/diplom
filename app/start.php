<?php

$router = new \diplomApp\core\Router();

//Подключаемся к базе данных
$dbConnect = new \diplomApp\core\DataBase();
$dbConnect::connect();
//Запускаем роутер
$router->start();