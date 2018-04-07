<?php

class Router
{
	static function start()
	{
                // контроллер и действие по умолчанию
		$controller_name = 'index';
		$action_name = 'index';
		
		$routes = explode('/', $_SERVER['REQUEST_URI']);
                var_dump($routes);
                
                if (!empty($routes[3])) {
                    $name = explode(".",$routes[3]);
                    $controller_name = $name[0];
                }

		
		// получаем имя контроллера и экшена
		if ( !empty($routes[4]) ) {
                    $action_name = $routes[4];
		}

		// добавляем префиксы
		$model_name = 'Model_'.$controller_name;
		$controller_name = 'Controller_'.$controller_name;
		$action_name = 'action_'.$action_name;

		// подцепляем файл с классом модели (файла модели может и не быть)

		$model_file = strtolower($model_name).'.php';
		$model_path = dirname(__DIR__). DIRECTORY_SEPARATOR. 'models'. DIRECTORY_SEPARATOR. $model_file;
                var_dump($model_path);
		if(file_exists($model_path)) {
                    include $model_path;
                    echo 'Есть файл модели';
		} else {
                    //throw new Exception ('Отсутствует файл модели: `' . $model_file . '`');
                  }

		// подцепляем файл с классом контроллера
		$controller_file = strtolower($controller_name).'.php';
		$controller_path = dirname(__DIR__). DIRECTORY_SEPARATOR. 'controllers'. DIRECTORY_SEPARATOR. $controller_file;
		if(file_exists($controller_path)) {
			include $controller_path;
                        echo 'есть файл контроллера';
		} else {
                    throw new Exception ('Отсутствует файл контроллера: `' . $controller_file . '`');
                  }
		
		// создаем контроллер
		$controller = new $controller_name();
		$action = $action_name;
		
		if(method_exists($controller, $action)) {
                    // вызываем действие контроллера
                    $controller->$action();
		} else {
                    throw new Exception ('Отсутствует действие '. $action. ' контроллера: `' . $controller . '`');
		  }
	
	}
	
	function ErrorPage404()
	{
            $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
            header('HTTP/1.1 404 Not Found');
            header("Status: 404 Not Found");
            header('Location:'.$host.'404');
        }
}