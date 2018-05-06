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
        $modelName = 'Model'. $controllerName;
        $controllerName = 'Controller'. $controllerName;
        $start = 'start'. $actionName;
        $actionName = 'action'. $actionName;
        
        $modelClass = '\\diplomApp\\models\\'. $modelName;
        if(class_exists($modelClass)) {
            $model = new $modelClass();
        } else {
            throw new \Exception ('Отсутствует файл модели: `'. $modelName. '`');
        }

        if (method_exists($model, $start)) {
            $dat = $model->$start($db);
        } else {
            throw new \Exception ('Отсутствует действие модели: `'. $start. '`');
        }
        
        // создаем контроллер
        $controllerClass = '\\diplomApp\\controllers\\'. $controllerName;
        if(class_exists($controllerClass)) {
            $controller = new $controllerClass();
        } else {
            throw new \Exception ('Отсутствует файл контроллера: `' . $controllerFile . '`');
        }
        //Проверяем экшен
        $action = $actionName;
        if(method_exists($controller, $action)) {
            $controller->$action($db, $dat);
        } else {
            throw new \Exception ('Отсутствует действие '. $action. ' контроллера: `' . $controller . '`');
        }
    }
    
    public function errorPage404()
    {
        $host = 'http://'. $_SERVER['HTTP_HOST']. '/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:'. $host. '404');
    }
}