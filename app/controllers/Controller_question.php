<?php

class Controller_Question  extends \DiplomApp\Controller {
    function action_add()
    {
        $this->view->generate('question_view.php', 'question_view.php');
    }
}

