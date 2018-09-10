<?php

namespace diplomApp\core;

class Router
{
    // @todo может $dbConnect через конструктор класть в свойство?
    static function start($dbConnect)
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
        
        $model = new $modelClass;
        $view = new \diplomApp\core\View();
        
        $controller = new $controllerClass;
        if(!method_exists($controller, $action)) {
            throw new \Exception ('Отсутствует действие ' . $action . ' контроллера: `' . $controllerName . '`');
        }
        
        $controller->$action($model, $view, $dbConnect);
    }
    
    public function errorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $host . '404');
    }
}