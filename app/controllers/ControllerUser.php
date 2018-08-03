<?php

namespace diplomApp\controllers;

class ControllerUser  extends \diplomApp\core\Controller
{
    // @todo не используемая переменная $start
    // @todo дублирование логики с \diplomApp\controllers\ControllerAdmin::actionIndex
    public function actionIndex($model, $start)
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
                $model->$start();
            }
        }
        $view = new \diplomApp\core\View(); // @todo перенести в свойство и передавать через конструктор
        echo $view->getTwig()->render('login.twig');
    }
}
