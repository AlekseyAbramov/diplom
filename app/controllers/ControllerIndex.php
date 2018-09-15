<?php

namespace diplomApp\controllers;

class ControllerIndex extends \diplomApp\core\Controller
{
    public function actionIndex()
    {
        $data = $this->model->getData();
        echo $this->view->getTwig()->render('template.twig', $data);
    }
}