<?php

namespace diplomApp\core;
class Controller {
    public $model;
    public $view;
    
    public function __construct()
    {
        $this->view = new \diplomApp\core\View();
    }
    
    public function actionIndex($db)
    {
    }
}

