<?php

class Controller_index extends \DiplomApp\Controller {
	function action_index()
	{	
            $this->view->generate('main_view.php', 'template_view.php');
	}
}

