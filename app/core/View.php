<?php

namespace diplomApp\core;
class View
{
    public function generate($db, $templateView)
    {
        include dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $templateView;
    }
}
