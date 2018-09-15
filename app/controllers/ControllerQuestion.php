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

    public function actionIndex()
    {
        if (!empty($_POST['question_add'])){
            try {
                $this->controlQuestion();
                $this->model->startIndex();
                $page = '/Question';
                $this->redirectTo($page);
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
        }
        $data = $this->model->getData();
        echo $this->view->getTwig()->render('question.twig', $data);
    }
}

