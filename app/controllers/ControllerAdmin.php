<?php

namespace diplomApp\controllers;
class ControllerAdmin  extends \diplomApp\core\Controller {
    public function actionIndex($db, $dat)
    {
        echo $this->twig->render('admin.twig', $dat);
    }
    public function actionSelect($db, $dat)
    {
        echo $this->twig->render('adminSelect.twig', $dat);
    }
    public function actionNot($db, $dat)
    {
        echo $this->twig->render('adminNot.twig', $dat);
    }
    public function actionTheme($db, $dat)
    {
        echo $this->twig->render('adminTheme.twig', $dat);
    }
    public function actionQuestion($db, $dat)
    {
        echo $this->twig->render('adminQuestion.twig', $dat);
    }
    public function actionEdit($db, $dat)
    {
        echo $this->twig->render('adminEdit.twig', $dat);
    }
    public function actionAnswer($db, $dat)
    {
        echo $this->twig->render('adminAnswer.twig', $dat);
    }
    public function actionNoQuestion($db)
    {
        echo $this->twig->render('adminNoQuestion.twig');
    }
    public function actionExit($db, $dat)
    {
        session_start();
        session_destroy();
        //header('Location: /diplom/public/');
    }
}
