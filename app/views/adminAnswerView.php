<?php

//Получаем список тем
$sth = $db->query('SELECT * FROM `themes`');
while ($list = $sth->fetch(PDO::FETCH_ASSOC)) {
    $themes[] = $list;
}

//Получаем вопросы без ответа
$sth = $db->query("SELECT id, question, date_add, status, theme_id FROM `questions` WHERE answer_id='$0' ORDER BY date_add");
while ($list = $sth->fetch(PDO::FETCH_ASSOC)) {
    $posts[] = $list;
}

//формируем страницу с помощью TWIG
$dir = dirname(__DIR__). DIRECTORY_SEPARATOR. 'views'. DIRECTORY_SEPARATOR ;
$loader = new Twig_Loader_Filesystem($dir. 'templates');
$twig = new Twig_Environment($loader, [
    'cache' => $dir. 'tmp',
    'auto_reload' => TRUE
]);

if(!empty($posts)) {
    echo $twig->render('adminAnswer.twig', ['posts' => $posts,
                                            'themes' => $themes]);
} else {
    echo $twig->render('adminNoQuestion.twig');
}


