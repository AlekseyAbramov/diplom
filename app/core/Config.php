<?php

namespace diplomApp\core;

use Symfony\Component\Yaml\Yaml;

class Config
{
    private $values = [];
    
    public function __construct()
    {
        if(!file_exists('../app/config.yml')) {
            throw new \Exception ('Отсутствует файл app/config.yml с настройками подключения к БД');
        }
        $this->values = Yaml::parseFile('../app/config.yml');;
    }
    
    public function getConfig($key)
    {
        if (!array_key_exists($key, $this->values['database'])) {
            throw new \Exception ('Отсутствует ключ ' . $key . ' в разделе database файла app/config.yml');
        }
        return $this->values['database'][$key];
    }
    
    public function getServerName()
    {
        return $this->values['server']['host'];
    }
}
