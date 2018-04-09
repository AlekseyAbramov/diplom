<?php

class Controller_Admin  extends \DiplomApp\Controller {
    function action_index()
    {
        $this->view->generate('admin_view.php', 'admin_view.php');
    }
}
