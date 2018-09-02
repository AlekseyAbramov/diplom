<?php

namespace diplomApp\models;

class ModelQuestion extends \diplomApp\core\Model
{    
    public function startIndex($dbConnect)
    {
        $theme = $_POST['theme'];
        $text = $_POST['text'];
        $name = $_POST['name'];
        $mail = $_POST['email'];
        $sth = parent::selectAllThemes($dbConnect);
        while ($list = $sth->fetch(\PDO::FETCH_NUM)) {
            if ($list['1'] == $theme) {
                $themeId = $list['0'];
            }
        }
        $sql = "INSERT INTO `questions`(`theme_id`, `question`, `name`, `mail`, `date_add`) VALUES (?,?,?,?,NOW())";
        $dat = array($themeId, $text, $name, $mail);
        $db = $dbConnect->getDataBase();
        $st = $db->prepare($sql);
        $st->execute($dat);
    }
    
    public function getData($dbConnect)
    {
        //Получаем список тем для формирования меню
        $sth = parent::selectThemes($dbConnect);
        $menu = [];
        while ($list = $sth->fetch(\PDO::FETCH_NUM)) {
            $menu[] = implode($list);
        }
        $data = ['menus' => $menu];
        return $data;
    }
}

