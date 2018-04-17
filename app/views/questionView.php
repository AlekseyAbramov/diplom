<?php

//Получаем список тем для формирования меню
$sth = $db->query('SELECT theme FROM themes');
while ($list = $sth->fetch(PDO::FETCH_NUM)) {
    $menu[] = implode($list);
}

//формируем страницу с помощью TWIG
$dir = dirname(__DIR__). DIRECTORY_SEPARATOR. 'views'. DIRECTORY_SEPARATOR ;
$loader = new Twig_Loader_Filesystem($dir. 'templates');
$twig = new Twig_Environment($loader, [
    'cache' => $dir. 'tmp',
    'auto_reload' => TRUE
]);
echo $twig->render('question.twig', ['menus' => $menu]);