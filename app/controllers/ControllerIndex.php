<?php

namespace diplomApp\controllers;
class ControllerIndex extends \diplomApp\core\Controller {
    public function actionIndex($data)
    {
        echo $this->twig->render('template.twig', $data);
    }
}

