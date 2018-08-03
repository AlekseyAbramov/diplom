<?php

namespace diplomApp\models;

class ModelQuestion extends \diplomApp\core\Model
{
    private function getServerName()
    {
        $config = new \diplomApp\core\Config();
        return $config->getServerName();
    }
    
    public function startIndex()
    {
        $theme = $_POST['theme'];
        $text = $_POST['text'];
        $name = $_POST['name'];
        $mail = $_POST['email'];
        $dbConnect = new \diplomApp\core\DataBase(); // @todo перенести в свойство и передавать через конструктор
        $db = $dbConnect->getDataBase();
        $sth = $db->query('SELECT * FROM themes');
        while ($list = $sth->fetch(\PDO::FETCH_NUM)) {
            if ($list['1'] == $theme) {
                $themeId = $list['0'];
            }
        }
        $sql = "INSERT INTO `questions`(`theme_id`, `question`, `name`, `mail`, `date_add`) VALUES (?,?,?,?,NOW())";
        $dat = array($themeId, $text, $name, $mail);
        $st = $db->prepare($sql);
        $st->execute($dat);
        // @todo в моделе не должно быть редиректов. Переделать на возврат данных
        //выбрасывать Exception если ошибка, а в контроллере обрабатывать
        header("Location: http://" . $this->getServerName() . "/Question");
    }
    
    public function getData()
    {
        //Получаем список тем для формирования меню
        $dbConnect = new \diplomApp\core\DataBase(); // @todo перенести в свойство и передавать через конструктор
        $db = $dbConnect->getDataBase();
        $sth = $db->query('SELECT theme FROM themes');
        while ($list = $sth->fetch(\PDO::FETCH_NUM)) {
            $menu[] = implode($list);
        }
        // @todo в начале нужно $menu переменную объявить как пустой массив
        $data = ['menus' => $menu];
        return $data;
    }
}

