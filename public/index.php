<?php

//Включаем отображение ошибок
ini_set('display_errors', 1);

//Подключаем библиотеки установленные composer
require_once dirname(__DIR__). DIRECTORY_SEPARATOR. 'vendor'. DIRECTORY_SEPARATOR. 'autoload.php';

//Создаем массив глобальных значений
            $registry = new DiplomApp\Registry;

//Подключаем файл инициализации
require_once dirname(__DIR__). DIRECTORY_SEPARATOR. 'app'. DIRECTORY_SEPARATOR. 'start.php';




