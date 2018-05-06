<?php

$router = new \diplomApp\core\Router();

//Подключаемся к базе данных
$config = new \diplomApp\classes\Config();
$db = \diplomApp\classes\DataBase::connect($config);

//Запускаем роутер
$router->start($db);