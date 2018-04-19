<?php

//Получаем вопрос и ответ для редактирования
$id = $_SESSION['question_edit'];
$sth = $db->query("SELECT id, question, status, theme_id, name FROM `questions` WHERE id='$id'");
$question = $sth->fetch(PDO::FETCH_ASSOC);
$sthAnswer = $db->query("SELECT questions.id, answers.answer FROM `questions` JOIN answers ON answers.id=answer_id WHERE questions.id='$id'");
$answer = $sthAnswer->fetch(PDO::FETCH_ASSOC);

//Получаем список тем
$sth = $db->query('SELECT * FROM `themes`');
while ($list = $sth->fetch(PDO::FETCH_ASSOC)) {
    $themes[] = $list;
}

//Находим тему вопроса
foreach ($themes as $teme) {
    if($teme['id'] == $question['theme_id']) {
        $question['theme'] = $teme['theme'];
    }
}

//формируем страницу с помощью TWIG
$dir = dirname(__DIR__). DIRECTORY_SEPARATOR. 'views'. DIRECTORY_SEPARATOR ;
$loader = new Twig_Loader_Filesystem($dir. 'templates');
$twig = new Twig_Environment($loader, [
    'cache' => $dir. 'tmp',
    'auto_reload' => TRUE
]);


if(!empty($answer)) {
    echo $twig->render('adminEdit.twig', ['question' => $question,
                                          'answer' => $answer,
                                          'themes' => $themes]);
} else {
    echo $twig->render('adminEdit.twig', ['question' => $question,
                                          'themes' => $themes]);
}

