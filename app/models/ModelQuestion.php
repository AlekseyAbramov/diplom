<?php

namespace diplomApp\models;

class ModelQuestion extends \diplomApp\core\Model
{
    public function startIndex()
    {
        $theme = (string) $_POST['theme'];
        $text = (string) $_POST['text'];
        $name = (string) $_POST['name'];
        $mail = (string) $_POST['email'];
        $db = $this->dbConnect->getDataBase();
        $sth = $db->prepare("SELECT id FROM `themes` WHERE theme=?");
        $sth->execute(array($theme));
        $themeId = $sth->fetch(\PDO::FETCH_NUM);
        $sql = "INSERT INTO `questions`(`theme_id`, `question`, `name`, `mail`, `date_add`) VALUES (?,?,?,?,NOW())";
        $dat = array($themeId, $text, $name, $mail);
        $st = $db->prepare($sql);
        $st->execute($dat);
    }

    public function getData()
    {
        //Получаем список тем для формирования меню
        $sth = $this->selectThemes();
        $menu = [];
        while ($list = $sth->fetch(\PDO::FETCH_NUM)) {
            $menu[] = implode($list);
        }
        $data = ['menus' => $menu];
        return $data;
    }
}

