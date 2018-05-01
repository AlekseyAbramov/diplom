<?php

namespace diplomApp\core;
class Controller {
    public $model;
    public $view;
    public $twig;


    public function __construct()
    {
        $this->view = new \diplomApp\core\View();
        $dir = dirname(__DIR__). DIRECTORY_SEPARATOR. 'views'. DIRECTORY_SEPARATOR ;
        $loader = new \Twig_Loader_Filesystem($dir. 'templates');
        $this->twig = new \Twig_Environment($loader, ['cache' => $dir. 'tmp',
                                                     'auto_reload' => TRUE]);
    }
    
    public function actionIndex($db, $dat)
    {
    }
}

