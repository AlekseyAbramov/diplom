<?php

namespace diplomApp\models;

class ModelQuestion
{
    static function startIndex($db)
    {
        if (!empty($_POST['question_add'])){
            if (!empty($_POST['name'])) {
                if (!empty($_POST['email'])) {
                    $theme = $_POST['theme'];
                    $text = $_POST['text'];
                    $name = $_POST['name'];
                    $mail = $_POST['email'];
                    $sth = $db->query('SELECT * FROM themes');
                    while ($list = $sth->fetch(\PDO::FETCH_NUM)) {
                        if ($list['1'] == $theme) {
                            $themeId = $list['0'];
                        }
                    }
                    $sql = "INSERT INTO `questions`(`theme_id`, `question`, `name`, `mail`, `date_add`) VALUES (?,?,?,?,?)";
                    $dat = array($themeId, $text, $name, $mail, 'NOW()');
                    $sth = $db->prepare($sql);
                    $sth->execute($dat);
                    header("Location: http://" . $_SERVER['SERVER_NAME'] . "/diplom/public/Question");
                } else {
                    echo 'Введите e-mail';
                }
            } else {
                echo 'Введите имя';
            }
        }
        //Получаем список тем для формирования меню
        $sth = $db->query('SELECT theme FROM themes');
        while ($list = $sth->fetch(\PDO::FETCH_NUM)) {
            $menu[] = implode($list);
        }
        $data = ['menus' => $menu];
        return $data;
    }
}

