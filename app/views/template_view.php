<?php

require_once 'menu_view.php';
require_once 'post_view.php';
$dir = dirname(__DIR__). DIRECTORY_SEPARATOR. 'views'. DIRECTORY_SEPARATOR ;
$loader = new Twig_Loader_Filesystem($dir. 'templates');
$twig = new Twig_Environment($loader, [
    'cache' => $dir. 'tmp',
    'auto_reload' => TRUE
]);
echo $twig->render('template.twig', ['menus' => $menu,
                                     'posts' => $post]);
