<?php

namespace diplomApp\controllers;
class ControllerQuestion  extends \diplomApp\core\Controller {
    public function actionIndex($dat)
    {
        echo $this->twig->render('question.twig', $dat);
    }
}

