<?php

namespace diplomApp\models;

class ModelUser extends \diplomApp\core\Model
{
    private function getServerName()
    {
        $config = new \diplomApp\core\Config();
        return $config->getServerName();
    }
    
    public function startIndex()
    {
        session_start();
        $user = strip_tags($_POST['login']);
        $password = $_POST['password'];
        $dbConnect = new \diplomApp\core\DataBase(); // @todo перенести в свойство и передавать через конструктор
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("SELECT `id`, `login`, `password` FROM `users` WHERE login=?");
        $sth->execute(array($user));
        $w = $sth->fetch();
        if (!$w) {
            echo 'Такого пользователя нет';
        } else {
            if($w['login'] == $user && password_verify($password, $w['password'])) {
                $_SESSION['user'] = $user;
                $_SESSION['id'] = $w['id'];
                // @todo в моделе не должно быть редиректов. Переделать на возврат данных
                //выбрасывать Exception если ошибка, а в контроллере обрабатывать
                header("Location: http://" . $this->getServerName() . "/Admin");
            } else {
                echo 'Вы ввели не правильный пароль';
            }
        }  
    }

    // @todo не используется
    public function getData()
    {
        
    }
}