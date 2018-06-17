<?php

namespace diplomApp\controllers;

class ControllerUser  extends \diplomApp\core\Controller
{
    public function actionIndex($model, $start, $db)
    {
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
                $model->$start($db);
            }
        }
        echo $this->twig->render('login.twig');
    }
}
