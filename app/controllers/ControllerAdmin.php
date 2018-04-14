<?php

class ControllerAdmin  extends \diplomApp\core\Controller {
    public function actionIndex($db)
    {
        $this->view->generate($db, 'adminView.php', 'adminView.php');
    }
}
