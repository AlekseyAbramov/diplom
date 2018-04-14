<?php

class ControllerQuestion  extends \diplomApp\core\Controller {
    public function actionIndex($db)
    {
        $this->view->generate($db, 'questionView.php', 'questionView.php');
    }
}

