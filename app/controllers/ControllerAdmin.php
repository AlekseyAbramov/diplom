<?php

namespace diplomApp\controllers;
class ControllerAdmin  extends \diplomApp\core\Controller {
    public function actionIndex($dat)
    {
        echo $this->twig->render('admin.twig', $dat);
    }
    public function actionSelect($dat)
    {
        echo $this->twig->render('adminSelect.twig', $dat);
    }
    public function actionNot($dat)
    {
        echo $this->twig->render('adminNot.twig', $dat);
    }
    public function actionTheme($dat)
    {
        echo $this->twig->render('adminTheme.twig', $dat);
    }
    public function actionQuestion($dat)
    {
        echo $this->twig->render('adminQuestion.twig', $dat);
    }
    public function actionEdit($dat)
    {
        echo $this->twig->render('adminEdit.twig', $dat);
    }
    public function actionAnswer($dat)
    {
        echo $this->twig->render('adminAnswer.twig', $dat);
    }
    public function actionNoQuestion($dat)
    {
        echo $this->twig->render('adminNoQuestion.twig');
    }
    public function actionExit($dat)
    {
        session_start();
        session_destroy();
    }
}
