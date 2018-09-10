<?php

namespace diplomApp\core;

abstract class Model
{
    // @todo может $dbConnect через конструктор класть в свойство?
    public function selectAllThemes($dbConnect)
    {
        $db = $dbConnect->getDataBase();
        return $sth = $db->query('SELECT * FROM `themes`');
    }

    // @todo может $dbConnect через конструктор класть в свойство?
    public function selectThemes($dbConnect)
    {
        $db = $dbConnect->getDataBase();
        return $sth = $db->query('SELECT theme FROM themes');
    }
}
