<?php

namespace diplomApp\controllers;

class ControllerAdmin  extends \diplomApp\core\Controller
{
    public function actionIndex($data)
    {
        echo $this->twig->render('admin.twig', $data);
    }
    public function actionSelect($data)
    {
        echo $this->twig->render('adminSelect.twig', $data);
    }
    public function actionNot($data)
    {
        echo $this->twig->render('adminNot.twig', $data);
    }
    public function actionTheme($data)
    {
        echo $this->twig->render('adminTheme.twig', $data);
    }
    public function actionQuestion($data)
    {
        echo $this->twig->render('adminQuestion.twig', $data);
    }
    public function actionEdit($data)
    {
        echo $this->twig->render('adminEdit.twig', $data);
    }
    public function actionAnswer($data)
    {
        echo $this->twig->render('adminAnswer.twig', $data);
    }
    public function actionNoQuestion($data)
    {
        echo $this->twig->render('adminNoQuestion.twig');
    }
    public function actionExit($data)
    {
        session_start();
        session_destroy();
    }
}
