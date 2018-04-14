<?php

namespace diplomApp\core;
class View
{
    public function generate($db, $contentView, $templateView)
    {
        include dirname(__DIR__). DIRECTORY_SEPARATOR. 'views'. DIRECTORY_SEPARATOR. $templateView;
    }
}
