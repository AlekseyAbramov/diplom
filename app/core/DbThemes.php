<?php

namespace diplomApp\core;

class DbThemes
{
    public static function getThemes($db)
    {
        $sth = $db->query('SELECT * FROM `themes`');
        while ($list = $sth->fetch(\PDO::FETCH_ASSOC)) {
            $themes[] = $list;
        }
        return $themes;
    }
}