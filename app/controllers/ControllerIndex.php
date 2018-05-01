<?php

namespace diplomApp\controllers;
class ControllerIndex extends \diplomApp\core\Controller {
    public function actionIndex($db, $dat)
    {
        echo $this->twig->render('template.twig', $dat);
    }
}

