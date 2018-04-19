<?php
      
//Запускаем сессию
session_start();
      
if(!empty($_POST['sign_in'])){
    if(!$_POST['login'] && !$_POST['password']) {
        echo 'Вы не ввели логин и пароль';
    }
    if($_POST['login'] && !$_POST['password']) {
        echo 'Вы не ввели пароль';
    }
    if(!$_POST['login'] && $_POST['password']) {
        echo 'Вы не ввели логин';
    }
    if($_POST['login'] && $_POST['password']) {
        $user = strip_tags($_POST['login']);
        $password = $_POST['password'];
        $sth = $db->prepare("SELECT `id`, `login`, `password` FROM `users` WHERE login=?");
        $sth->execute(array($user));
        $w = $sth->fetch();
        if (!$w) {
            echo 'Такого пользователя нет';
        } else {
            if($w['login'] == $user && password_verify($password, $w['password'])) {
                $_SESSION['user'] = $user;
                $_SESSION['id'] = $w['id'];
                header('Location: http://localhost/diplom/public/admin');
            } else {
                echo 'Вы ввели не правильный пароль';
            }
        }
    }
}
    

