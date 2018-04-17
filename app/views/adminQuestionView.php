<?php

//Получаем список тем
$sth = $db->query('SELECT * FROM `themes`');
while ($list = $sth->fetch(PDO::FETCH_ASSOC)) {
    $themes[] = $list;
}

$dir = dirname(__DIR__). DIRECTORY_SEPARATOR. 'views'. DIRECTORY_SEPARATOR ;
$loader = new Twig_Loader_Filesystem($dir. 'templates');
$twig = new Twig_Environment($loader, [
    'cache' => $dir. 'tmp',
    'auto_reload' => TRUE
]);
echo $twig->render('adminQuestion.twig', ['themes' => $themes]);

