<?php

namespace diplomApp\controllers;

class ControllerIndex extends \diplomApp\core\Controller
{
    // @todo не используемая переменная $start
    public function actionIndex($model, $start)
    {
        $data = $model->getData();
        $view = new \diplomApp\core\View(); // @todo перенести в свойство и передавать через конструктор
        echo $view->getTwig()->render('template.twig', $data);
    }
}

