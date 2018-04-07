<?php

//Подключаемся к базе данных
$config = require_once dirname(__DIR__). DIRECTORY_SEPARATOR. 'app'. DIRECTORY_SEPARATOR. 'config.php';

$db = DiplomApp\DataBase::connect(
        $config['mysql']['host'],
 	$config['mysql']['dbname'],
     	$config['mysql']['user'],
    	$config['mysql']['pass']
);

