<?php

namespace diplomApp\controllers;

class ControllerIndex extends \diplomApp\core\Controller
{
    public function actionIndex($model, $start, $db)
    {
        $data = $model->getData($db);
        echo $this->twig->render('template.twig', $data);
    }
}

