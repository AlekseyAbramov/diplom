<?php

namespace diplomApp\controllers;

class ControllerIndex extends \diplomApp\core\Controller
{
    public function actionIndex($model, $start)
    {
        $data = $model->getData();
        echo $this->twig->render('template.twig', $data);
    }
}

