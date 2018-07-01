<?php

$router = new \diplomApp\core\Router();

//Подключаемся к базе данных
if(!file_exists('../app/config.yml')) {
            throw new \Exception ('Отсутствует файл app/config.yml с настройками подключения к БД');
        }

use Symfony\Component\Yaml\Yaml;

$config = Yaml::parseFile('../app/config.yml');
$db = \diplomApp\core\DataBase::connect($config);

//Запускаем роутер
$router->start($db);