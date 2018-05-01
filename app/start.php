<?php

$router = new \diplomApp\core\Router();

//Подключаемся к базе данных
$db = \diplomApp\classes\DataBase::connect();

//Запускаем роутер
$router->start($db);