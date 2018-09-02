<?php

namespace diplomApp\core;

abstract class Controller
{
    public function userControl()
    {
        if(!$_POST['login'] && !$_POST['password']) {
            throw new \Exception('Вы не ввели логин и пароль');
        }
        if($_POST['login'] && !$_POST['password']) {
            throw new \Exception('Вы не ввели пароль');
        }
        if(!$_POST['login'] && $_POST['password']) {
            throw new \Exception('Вы не ввели логин');
        }
    }

    public function getServerName()
    {
        $config = new \diplomApp\core\Config();
        return $config->getServerName();
    }
    
    abstract function actionIndex($model, $view, $dbConnect);
}

