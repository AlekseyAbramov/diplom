<?php

namespace diplomApp\models;

class ModelQuestion extends \diplomApp\core\Model
{
    public function startIndex()
    {
        $theme = $_POST['theme'];
        $text = $_POST['text'];
        $name = $_POST['name'];
        $mail = $_POST['email'];
        $dbConnect = new \diplomApp\core\DataBase();
        $db = $dbConnect->getDataBase();
        $sth = $db->query('SELECT * FROM themes');
        while ($list = $sth->fetch(\PDO::FETCH_NUM)) {
            if ($list['1'] == $theme) {
                $themeId = $list['0'];
            }
        }
        $sql = "INSERT INTO `questions`(`theme_id`, `question`, `name`, `mail`, `date_add`) VALUES (?,?,?,?,?)";
        $dat = array($themeId, $text, $name, $mail, 'NOW()');
        $st = $db->prepare($sql);
        $st->execute($dat);
        header("Location: http://" . $_SERVER['SERVER_NAME'] . "/diplom/public/Question");
    }
    
    public function getData()
    {
        //Получаем список тем для формирования меню
        $dbConnect = new \diplomApp\core\DataBase();
        $db = $dbConnect->getDataBase();
        $sth = $db->query('SELECT theme FROM themes');
        while ($list = $sth->fetch(\PDO::FETCH_NUM)) {
            $menu[] = implode($list);
        }
        $data = ['menus' => $menu];
        return $data;
    }
}

