<?php

class Controller_User  extends \DiplomApp\Controller {
    function action_index()
    {
        $this->view->generate('user_view.php', 'login_view.php');
    }
}
