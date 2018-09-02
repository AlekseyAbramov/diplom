<?php

namespace diplomApp\controllers;

class ControllerUser  extends \diplomApp\core\Controller
{
    public function actionIndex($model, $view, $dbConnect)
    {
        if(!empty($_POST['sign_in'])){
            try {
                parent::userControl();
                $model->startIndex($dbConnect);
                header("Location: http://" . self::getServerName() . "/Admin");
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
        }
        echo $view->getTwig()->render('login.twig');
    }
}
