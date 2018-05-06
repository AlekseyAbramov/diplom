<?php

namespace diplomApp\models;

class ModelIndex {
    static function startIndex($db)
    {
        //Получаем список тем для формирования меню
        $sth = $db->query('SELECT theme FROM themes');
        while ($list = $sth->fetch(\PDO::FETCH_NUM)) {
            $menu[] = implode($list);
        }


        //Получаем вопросы на которые есть ответ
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
