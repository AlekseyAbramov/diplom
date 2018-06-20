<?php

$router = new \diplomApp\core\Router();

//Подключаемся к базе данных
if(!file_exists('../app/config.json')) {
            throw new \Exception ('Отсутствует файл app/config.json с настройками подключения к БД');
        }
$file_config = file_get_contents('../app/config.json');
$config = json_decode($file_config, TRUE);
$db = \diplomApp\classes\DataBase::connect($config);

//Запускаем роутер
$router->start($db);