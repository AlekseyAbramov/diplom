<?php

namespace diplomApp\controllers;

class ControllerQuestion  extends \diplomApp\core\Controller
{
    public function actionIndex($data)
    {
        echo $this->twig->render('question.twig', $data);
    }
}

