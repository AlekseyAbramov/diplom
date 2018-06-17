<?php

namespace diplomApp\core;

class Controller
{
    public $twig;
    
    public function __construct()
    {
        $dir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR ;
        $loader = new \Twig_Loader_Filesystem($dir . 'templates');
        $this->twig = new \Twig_Environment($loader, ['cache' => $dir . 'tmp',
                                                      'auto_reload' => TRUE]);
    }
    
    public function actionIndex($model, $start, $db)
    {
    }
}

