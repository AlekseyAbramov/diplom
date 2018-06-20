<?php

$router = new \diplomApp\core\Router();

//Подключаемся к базе данных
$file_config = file_get_contents('../app/config.json');
$config = json_decode($file_config, TRUE);
var_dump($config);
$db = \diplomApp\classes\DataBase::connect($config);

//Запускаем роутер
$router->start($db);