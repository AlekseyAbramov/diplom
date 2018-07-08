<?php

namespace diplomApp\controllers;

class ControllerQuestion  extends \diplomApp\core\Controller
{
    public function actionIndex($model, $start)
    {
        if (!empty($_POST['question_add'])){
            if (!empty($_POST['name'])) {
                if (!empty($_POST['email'])) {
                    $model->$start();
                } else {
                    echo 'Введите e-mail';
                }
            } else {
                echo 'Введите имя';
            }
        }
        $data = $model->getData();
        $view = new \diplomApp\core\View();
        echo $view->getTwig()->render('question.twig', $data);
    }
}

