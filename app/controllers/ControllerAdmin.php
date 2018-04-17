<?php

class ControllerAdmin  extends \diplomApp\core\Controller {
    public function actionIndex($db)
    {
        $this->view->generate($db, 'adminView.php');
    }
    public function actionSelect($db)
    {
        $this->view->generate($db, 'adminSelectView.php');
    }
    public function actionTheme($db)
    {
        $this->view->generate($db, 'adminThemeView.php');
    }
    public function actionQuestion($db)
    {
        $this->view->generate($db, 'adminQuestionView.php');
    }
    public function actionEdit($db)
    {
        $this->view->generate($db, 'adminEditView.php');
    }
}
