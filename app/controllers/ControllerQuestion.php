<?php

namespace diplomApp\controllers;

class ControllerQuestion  extends \diplomApp\core\Controller
{
    private function controlQuestion()
    {
        if (empty($_POST['name'])) {
            throw new \Exception('Введите имя');
        }
        if (empty($_POST['email'])) {
            throw new \Exception('Введите e-mail');
        }
    }

    public function actionIndex($model, $view, $dbConnect)
    {
        if (!empty($_POST['question_add'])){
            try {
                self::controlQuestion();
                $model->startIndex($dbConnect);
                header("Location: http://" . self::getServerName() . "/Question");
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
        }
        $data = $model->getData($dbConnect);
        echo $view->getTwig()->render('question.twig', $data);
    }
}

