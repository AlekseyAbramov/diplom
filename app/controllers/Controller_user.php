<?php

class Controller_user  extends \DiplomApp\Controller {
    function action_index()
    {
        $this->view->generate('login_view.php', 'login_view.php');
    }
}
