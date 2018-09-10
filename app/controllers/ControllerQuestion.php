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

    // @todo может $view правильнее присваивать в свойство например в конструкторе?
    public function actionIndex($model, $view, $dbConnect)
    {
        if (!empty($_POST['question_add'])){
            try {
                // @todo обращаться надо через $this
                self::controlQuestion();
                $model->startIndex($dbConnect);
                // @todo может вынести в родительский метод например $this->redirectTo()
                header("Location: http://" . self::getServerName() . "/Question");
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
        }
        $data = $model->getData($dbConnect);
        echo $view->getTwig()->render('question.twig', $data);
    }
}

