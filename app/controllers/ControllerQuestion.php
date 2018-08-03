<?php

namespace diplomApp\controllers;

class ControllerQuestion  extends \diplomApp\core\Controller
{
    // @todo не используемая переменная $start
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
        $view = new \diplomApp\core\View(); // перенести в свойство и передавать через конструктор
        echo $view->getTwig()->render('question.twig', $data);
    }
}

