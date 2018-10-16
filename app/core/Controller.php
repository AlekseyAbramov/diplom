<?php

namespace diplomApp\core;

abstract class Controller
{
    protected $config, $view, $model, $protocol;

    /*
     * @param $config Config
     * @param $view View
     * @param $model Model
     */
    public function __construct($config, $view, $model)
    {
        $this->config = $config;
        $this->view = $view;
        $this->model = $model;
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $this->protocol = 'https://';
        } else {
            $this->protocol = 'http://';
        }
    }

    public function userControl()
    {
        if(!$_POST['login'] && !$_POST['password']) {
            throw new \Exception('Вы не ввели логин и пароль');
        }
        if($_POST['login'] && !$_POST['password']) {
            throw new \Exception('Вы не ввели пароль');
        }
        if(!$_POST['login'] && $_POST['password']) {
            throw new \Exception('Вы не ввели логин');
        }
    }

    public function getServerName()
    {
        return $this->config->getServerName();
    }
    
    public function redirect()
    {
        header('Location: ' . $this->protocol . $this->getServerName() . $_SERVER['REQUEST_URI']);
    }
    
    public function redirectTo($page)
    {
        header('Location: ' . $this->protocol . $this->getServerName() . $page);
    }
    
    public function logOn()
    {
        session_start();
        if (empty($_SESSION['user'])) {
            $page ='';
            $this->redirectTo($page);
            die();
        }
    }

    abstract function actionIndex();
}

