<?php

class Controller_admin  extends \DiplomApp\Controller {
    function action_index()
    {
        $this->view->generate('admin_view.php', 'admin_view.php');
    }
}
