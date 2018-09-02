<?php

namespace diplomApp\controllers;

class ControllerIndex extends \diplomApp\core\Controller
{
    public function actionIndex($model, $view, $dbConnect)
    {
        $data = $model->getData($dbConnect);
        echo $view->getTwig()->render('template.twig', $data);
    }
}

