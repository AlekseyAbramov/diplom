<?php

namespace diplomApp\models;

class ModelIndex extends \diplomApp\core\Model
{    
    public function getData($dbConnect)
    {
        //Получаем список тем для формирования меню
        $sth = parent::selectThemes($dbConnect);
        while ($list = $sth->fetch(\PDO::FETCH_NUM)) {
            $menu[] = implode($list);
        }


        //Получаем вопросы на которые есть ответ
        $post = [];
        $db = $dbConnect->getDataBase();
        foreach ($menu as $thema){
            $postList = "SELECT question, answers.answer FROM `questions` JOIN themes ON themes.id=theme_id  "
                                                                       . "JOIN answers ON answers.id=answer_id WHERE themes.theme='$thema' AND status='2'";
            $sth = $db->query($postList);
            while ($list = $sth->fetch(\PDO::FETCH_ASSOC)) {
                $post[$thema][] = $list;
            }
        }
        $data = ['menus' => $menu,
                'posts' => $post];
        return $data;
    }
}
