<?php

namespace diplomApp\core;

abstract class Model
{
    public function selectAllThemes($dbConnect)
    {
        $db = $dbConnect->getDataBase();
        return $sth = $db->query('SELECT * FROM `themes`');
    }
    
    public function selectThemes($dbConnect)
    {
        $db = $dbConnect->getDataBase();
        return $sth = $db->query('SELECT theme FROM themes');
    }
}
