<?php

namespace diplomApp\core;

abstract class Model
{
    protected $dbConnect;
    
    public function __construct($dbConnect)
    {
        $this->dbConnect = $dbConnect;
    }

    public function selectAllThemes()
    {
        $db = $this->dbConnect->getDataBase();
        return $sth = $db->query('SELECT * FROM `themes`');
    }

    public function selectThemes()
    {
        $db = $this->dbConnect->getDataBase();
        return $sth = $db->query('SELECT theme FROM themes');
    }
}
