<?php

namespace diplomApp\core;

class Router
{
    protected $dbConnect, $config;
    
    public function __construct($dbConnect, $config)
    {
        $this->dbConnect = $dbConnect;
        $this->config = $config;
    }

    public function start()
    {
        // контроллер и действие по умолчанию
        $controllerName = 'Index';
        $actionName = 'Index';
        $routes = explode('/', $_SERVER['REQUEST_URI']);
        
        if (!empty($routes[1])) {
            $name = explode(".", $routes[1]);
            $controllerName = $name[0];
        }
        
        // получаем имя контроллера и экшена
        if (!empty($routes[2])) {
            $actionName = $routes[2];
        }
        
        // добавляем префиксы
        $modelName = implode('', ['Model', $controllerName]);
        $controllerName = implode('', ['Controller', $controllerName]);
        $action = implode('', ['action', $actionName]);
        
        $modelClass = implode('\\', ['\diplomApp\models', $modelName]);
        $controllerClass = implode('\\', ['\diplomApp\controllers', $controllerName]);
        
        if(!class_exists($modelClass)) {
            throw new \Exception ('Отсутствует файл модели: `' . $modelName . '`');
        }
        
        if(!class_exists($controllerClass)) {
            throw new \Exception ('Отсутствует файл контроллера: `' . $controllerName . '`');
        }
        
        $model = new $modelClass($this->dbConnect);
        $view = new \diplomApp\core\View(); // достаточно указать класс View т.к. неймспейс тот же
        
        $controller = new $controllerClass($this->config, $view, $model);
        if(!method_exists($controller, $action)) {
            throw new \Exception ('Отсутствует действие ' . $action . ' контроллера: `' . $controllerName . '`');
        }
        
        $controller->$action();
    }
    
    public function errorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $host . '404');
    }
}