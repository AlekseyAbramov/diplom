<?php
//Получаем список администраторов
$sth = $db->query('SELECT id, login FROM `users`');
while ($list = $sth->fetch(PDO::FETCH_ASSOC)) {
    $users[] = $list;
}

//формируем страницу с помощью TWIG
$dir = dirname(__DIR__). DIRECTORY_SEPARATOR. 'views'. DIRECTORY_SEPARATOR ;
$loader = new Twig_Loader_Filesystem($dir. 'templates');
$twig = new Twig_Environment($loader, [
    'cache' => $dir. 'tmp',
    'auto_reload' => TRUE
]);
echo $twig->render('admin.twig', ['users' => $users]);
