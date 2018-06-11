<?php

namespace diplomApp\core;

class Router
{
    static function start($db)
    {
        // контроллер и действие по умолчанию
        $controllerName = 'Index';
        $actionName = 'Index';
        $routes = explode('/', $_SERVER['REQUEST_URI']);
        
        if (!empty($routes[3])) {
            $name = explode(".", $routes[3]);
            $controllerName = $name[0];
        }
        
        // получаем имя контроллера и экшена
        if (!empty($routes[4])) {
            $actionName = $routes[4];
        }
        
        // добавляем префиксы
        $modelName = implode('', ['Model', $controllerName]);
        $controllerName = implode('', ['Controller', $controllerName]);
        $start = implode('', ['start', $actionName]);
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
        if (!method_exists($model, $start)) {
            throw new \Exception ('Отсутствует действие модели: `' . $start . '`');
        }
        
        $controller = new $controllerClass;
        if(!method_exists($controller, $action)) {
            throw new \Exception ('Отсутствует действие ' . $action . ' контроллера: `' . $controllerName . '`');
        }
        
        $data = $model->$start($db);
        $controller->$action($data);
    }
    
    public function errorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:' . $host . '404');
    }
}