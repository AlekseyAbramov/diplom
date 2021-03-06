<?php

namespace diplomApp\models;

class ModelUser extends \diplomApp\core\Model
{
    public function startIndex()
    {
        session_start();
        $user = strip_tags($_POST['login']);
        $password = $_POST['password'];
        $db = $this->dbConnect->getDataBase();
        $sth = $db->prepare("SELECT `id`, `login`, `password` FROM `users` WHERE login=?");
        $sth->execute(array($user));
        $w = $sth->fetch();
        if (!$w) {
            throw new \Exception('Такого пользователя нет');
        } else {
            if($w['login'] == $user && password_verify($password, $w['password'])) {
                $_SESSION['user'] = $user;
                $_SESSION['id'] = $w['id'];
            } else {
                throw new \Exception('Вы ввели не правильный пароль');
            }
        }  
    }
}