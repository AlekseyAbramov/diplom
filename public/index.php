<?php
//Включаем отображение ошибок
ini_set('display_errors', 1); // отображение ошибок лучше вынести в конфиг
error_reporting(E_ALL); // отображение ошибок лучше вынести в конфиг

//Подключаем библиотеки установленные composer
require_once '../vendor/autoload.php';

//Подключаем файл инициализации
require_once '../app/start.php';
