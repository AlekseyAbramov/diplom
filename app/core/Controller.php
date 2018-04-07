<?php

namespace DiplomApp;
class Controller {
	
	public $model;
	public $view;
	
	function __construct()
	{
		$this->view = new \DiplomApp\View();
	}
	
	function action_index()
	{
	}
}

