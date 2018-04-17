<?php

if (!empty($_POST['question_add'])){
    if (!empty($_POST['name'])) {
        if (!empty($_POST['email'])) {
            $theme = $_POST['theme'];
            $text = $_POST['text'];
            $name = $_POST['name'];
            $mail = $_POST['email'];
            $sth = $db->query('SELECT * FROM themes');
            while ($list = $sth->fetch(PDO::FETCH_NUM)) {
                if ($list['1'] == $theme) {
                    $themeId = $list['0'];
                }
            }
            $sql = "INSERT INTO `questions`(`theme_id`, `question`, `name`, `mail`, `date_add`) VALUES (?,?,?,?,?)";
            $dat = array($themeId, $text, $name, $mail, 'NOW()');
            $sth = $db->prepare($sql);
            $sth->execute($dat);
            header("Location: /diplom/public/question");
        } else {
            echo 'Введите e-mail';
        }
    } else {
        echo 'Введите имя';
    }
}

