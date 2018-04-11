<?php
// Подключаемся к базе данных
require_once dirname(__DIR__). DIRECTORY_SEPARATOR. 'db_connect.php';
$menu_list = "SELECT `theme` FROM `themes`";
$list = $db->query($menu_list);
$menu = $list->fetch(PDO::FETCH_NUM);

