<?php

namespace diplomApp\controllers;

class ControllerIndex extends \diplomApp\core\Controller
{
    // @todo может $model, $view и $dbConnect правильнее присваивать в свойство например в конструкторе?
    public function actionIndex($model, $view, $dbConnect)
    {
        $data = $model->getData($dbConnect);
        echo $view->getTwig()->render('template.twig', $data);
    }
}

