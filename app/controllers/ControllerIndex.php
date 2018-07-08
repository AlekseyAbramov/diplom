<?php

namespace diplomApp\controllers;

class ControllerIndex extends \diplomApp\core\Controller
{
    public function actionIndex($model, $start)
    {
        $data = $model->getData();
        $view = new \diplomApp\core\View();
        echo $view->getTwig()->render('template.twig', $data);
    }
}

