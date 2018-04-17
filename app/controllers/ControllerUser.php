<?php

class ControllerUser  extends \diplomApp\core\Controller {
    public function actionIndex($db)
    {
        $this->view->generate($db, 'loginView.php');
    }
}
