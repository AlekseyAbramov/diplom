<?php

class ControllerIndex extends \diplomApp\core\Controller {
    public function actionIndex($db)
    {
        $this->view->generate($db, 'templateView.php');
    }
}

