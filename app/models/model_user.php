<?php

// Подключаемся к базе данных
require_once dirname(__DIR__). DIRECTORY_SEPARATOR. 'db_connect.php';

//Запускаем сессию
session_start();
var_dump($_POST);

if (!empty($_POST)) {
        if(!empty($_POST['register'])) {
             if ($_POST['login'] && !$_POST['password']) {
                 echo 'Вы не ввели пароль';
             }
             if (!$_POST['login'] && $_POST['password']) {
                  echo 'Вы не ввели логин';
             }
             if (!$_POST['login'] && !$_POST['password']) {
                   echo 'Вы не ввели лигин и пароль';
             }
             if ($_POST['login'] && $_POST['password']) {
                  $user = strip_tags($_POST['login']);
                  $password = password_hash(strip_tags($_POST['password']), PASSWORD_DEFAULT);
                  $sth = $db->prepare("SELECT `login` FROM `users` WHERE login=?");
                  $sth->execute(array($user));
                  $w = $sth->fetchColumn();
                  if($w) {
                     echo 'Такой пользователь уже есть. Введите другой логин.';
                 } else {
                     $names = $user. ','. $password;
                     $names = explode(',', $names);
                     var_dump($names);
                     $placeholder = implode(',', array_fill(0, count($names), '?'));
                     var_dump($placeholder);
                     $sth = $db->prepare("INSERT INTO `users`(`login`, `password`) VALUES ($placeholder)");
                     $sth->execute($names);
                     echo 'Вы успешно зарегистрировались, можите войти в систему.';
                  }
             }   
        }
        
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
                        header('Location: admin');
                    } else {
                        echo 'Вы ввели не правильный пароль';
                    }
                }
            }
        }
    }

