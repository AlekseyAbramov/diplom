<?php

//Получаем список тем для формирования меню
$sth = $db->query('SELECT theme FROM themes');
while ($list = $sth->fetch(PDO::FETCH_NUM)) {
    $menu[] = implode($list);
}


//Получаем вопросы на которые есть ответ
foreach ($menu as $thema){
    $postList = "SELECT question, answers.answer FROM `questions` JOIN themes ON themes.id=theme_id  "
                                                               . "JOIN answers ON answers.id=answer_id WHERE themes.theme='$thema' AND status='2'";
    $sth = $db->query($postList);
    while ($list = $sth->fetch(PDO::FETCH_ASSOC)) {
        $post[$thema][] = $list;
    }
}

//формируем страницу с помощью TWIG
$dir = dirname(__DIR__). DIRECTORY_SEPARATOR. 'views'. DIRECTORY_SEPARATOR ;
$loader = new Twig_Loader_Filesystem($dir. 'templates');
$twig = new Twig_Environment($loader, [
    'cache' => $dir. 'tmp',
    'auto_reload' => TRUE
]);
echo $twig->render('template.twig', ['menus' => $menu,
                                     'posts' => $post]);
