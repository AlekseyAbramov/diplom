<?php

class Controller_question  extends \DiplomApp\Controller {
    function action_index()
    {
        $this->view->generate('question_view.php', 'template_view.php');
    }
}

