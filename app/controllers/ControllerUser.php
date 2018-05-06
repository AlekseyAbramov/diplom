<?php

namespace diplomApp\controllers;
class ControllerUser  extends \diplomApp\core\Controller {
    public function actionIndex($data)
    {
        echo $this->twig->render('login.twig');
    }
}
