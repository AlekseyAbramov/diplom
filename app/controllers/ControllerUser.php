<?php

namespace diplomApp\controllers;
class ControllerUser  extends \diplomApp\core\Controller {
    public function actionIndex($db, $dat)
    {
        echo $this->twig->render('login.twig');
    }
}
