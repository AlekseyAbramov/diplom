<?php

namespace diplomApp\controllers;

class ControllerUser  extends \diplomApp\core\Controller
{
    public function actionIndex()
    {
        if(!empty($_POST['sign_in'])){
            try {
                parent::userControl();
                $this->model->startIndex();
                $page = '/Admin';
               $this->redirectTo($page);
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
        }
        echo $this->view->getTwig()->render('login.twig');
    }
}
