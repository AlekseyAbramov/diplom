<?php

namespace diplomApp\controllers;
class ControllerQuestion  extends \diplomApp\core\Controller {
    public function actionIndex($db, $dat)
    {
        echo $this->twig->render('question.twig', $dat);
    }
}

