<?php

namespace diplomApp\controllers;

class ControllerQuestion  extends \diplomApp\core\Controller
{
    public function actionIndex($model, $start, $db)
    {
        if (!empty($_POST['question_add'])){
            if (!empty($_POST['name'])) {
                if (!empty($_POST['email'])) {
                    $model->$start($db);
                } else {
                    echo 'Введите e-mail';
                }
            } else {
                echo 'Введите имя';
            }
        }
        $data = $model->getData($db);
        echo $this->twig->render('question.twig', $data);
    }
}

