<?php

//Получаем список тем
$menu_list = "SELECT `theme` FROM `themes`";
$list = $db->query($menu_list);
$menu = $list->fetch(PDO::FETCH_NUM);

//формируем страницу с помощью TWIG
$dir = dirname(__DIR__). DIRECTORY_SEPARATOR. 'views'. DIRECTORY_SEPARATOR ;
$loader = new Twig_Loader_Filesystem($dir. 'templates');
$twig = new Twig_Environment($loader, [
    'cache' => $dir. 'tmp',
    'auto_reload' => TRUE
]);
echo $twig->render('question.twig', ['menus' => $menu]);