<?php

namespace DiplomApp;
class View
{           
    function generate($content_view, $template_view)
    {		
	include dirname(__DIR__). DIRECTORY_SEPARATOR. 'views'. DIRECTORY_SEPARATOR. $template_view;
    }
}
