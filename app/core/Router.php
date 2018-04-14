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
        var_dump($routes);
        
        if (!empty($routes[3])) {
            $name = explode(".",$routes[3]);
            $controllerName = $name[0];
        }
        
        // получаем имя контроллера и экшена
        if ( !empty($routes[4]) ) {
            $actionName = $routes[4];
        }
        
        // добавляем префиксы
        $modelName = 'model'.$controllerName;
        $controllerName = 'Controller'.$controllerName;
        $actionName = 'action'.$actionName;
        
        // подцепляем файл с классом модели (файла модели может и не быть)
        $modelFile = strtolower($modelName).'.php';
        $modelPath = dirname(__DIR__). DIRECTORY_SEPARATOR. 'models'. DIRECTORY_SEPARATOR. $modelFile;
        var_dump($modelPath);
        if(file_exists($modelPath)) {
            include $modelPath;
            echo 'Есть файл модели';
        } else {
            //throw new Exception ('Отсутствует файл модели: `' . $model_file . '`');
        }
        
        // подцепляем файл с классом контроллера
        $controllerFile = strtolower($controllerName).'.php';
        $controllerPath = dirname(__DIR__). DIRECTORY_SEPARATOR. 'controllers'. DIRECTORY_SEPARATOR. $controllerFile;
        if(file_exists($controllerPath)) {
            include $controllerPath;
            echo 'есть файл контроллера';
        } else {
            throw new Exception ('Отсутствует файл контроллера: `' . $controllerFile . '`');
        }
        
        // создаем контроллер
        $controller = new $controllerName();
        $action = $actionName;
        if(method_exists($controller, $action)) {
            $controller->$action($db);
        } else {
            throw new Exception ('Отсутствует действие '. $action. ' контроллера: `' . $controller . '`');
        }
    }
    
    public function errorPage404()
    {
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:'.$host.'404');
    }
}