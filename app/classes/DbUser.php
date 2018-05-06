<?php

namespace diplomApp\classes;
class DbUser {
    public static function getUsers($db)
    {
        $sth = $db->query('SELECT id, login FROM `users`');
        while ($list = $sth->fetch(\PDO::FETCH_ASSOC)) {
            $users[] = $list;
        }
        return $users;
    }
}
