<?php

namespace diplomApp\classes;

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