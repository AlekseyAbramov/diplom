<?php

var_dump($_SESSION);

//Получаем список тем
$sth = $db->query('SELECT * FROM `themes`');
while ($list = $sth->fetch(PDO::FETCH_ASSOC)) {
    $themes[] = $list;
}

foreach ($themes as $theme) {
    if($theme['id'] == $_SESSION['theme_select']){
        $id = $theme['id'];
        $st = $db->query("SELECT id, question, date_add, status, theme_id FROM `questions` WHERE theme_id='$id'");
        while ($list = $st->fetch(PDO::FETCH_ASSOC)) {
            $posts[] = $list;
        }
        $sthAnswer = $db->query("SELECT questions.id, answers.answer FROM `questions` JOIN answers ON answers.id=answer_id WHERE theme_id='$id'");
        while ($list = $sthAnswer->fetch(PDO::FETCH_ASSOC)) {
            $answers[] = $list;
        }
    }
}

$dir = dirname(__DIR__). DIRECTORY_SEPARATOR. 'views'. DIRECTORY_SEPARATOR ;
$loader = new Twig_Loader_Filesystem($dir. 'templates');
$twig = new Twig_Environment($loader, [
    'cache' => $dir. 'tmp',
    'auto_reload' => TRUE
]);
if(!empty($posts)) {
    echo $twig->render('adminSelect.twig', ['posts' => $posts,
                                            'answers' => $answers,
                                            'themes' => $themes]);
} else {
    echo $twig->render('adminNot.twig', ['themes' => $themes]);
}

