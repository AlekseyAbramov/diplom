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
        $dbConnect = new \diplomApp\core\DataBase();
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
                header("Location: http://" . $this->getServerName() . "/Admin");
            } else {
                echo 'Вы ввели не правильный пароль';
            }
        }  
    }
    public function getData()
    {
        
    }
}