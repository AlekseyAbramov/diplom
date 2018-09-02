<?php

namespace diplomApp\controllers;

class ControllerAdmin  extends \diplomApp\core\Controller
{
    private function logOn()
    {
        session_start();
        if (empty($_SESSION['user'])) {
            header("Location: http://" . parent::getServerName());
            die();
        }
    }
    
    public function actionIndex($model, $view, $dbConnect)
    {
        if (!empty($_POST['adminAdd'])) {
            self::logOn();
            try {
                parent::userControl();
                $model->adminAdd($dbConnect);
                header("Location: " . $_SERVER['REQUEST_URI']);
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
        }
                        
        if (!empty($_POST['passEdit'])) {
            if (!empty($_POST['newPassword'])) {
                $model->passEdit($dbConnect);
                header("Location: " . $_SERVER['REQUEST_URI']);
            }
        }

        if (!empty($_POST['dell'])) {
            $model->dell($dbConnect);
            header("Location: " . $_SERVER['REQUEST_URI']);
        }
        $data = $model->getData($dbConnect);
        echo $view->getTwig()->render('admin.twig', $data);
    }
    
    public function actionSelect($model, $view, $dbConnect)
    {
        self::logOn();
        if (!empty($_POST['questionDell'])) {
            $model->questionDell($dbConnect);
            header("Location: " . $_SERVER['REQUEST_URI']);
        }
        if(!empty($_POST['questionEdit'])) {
            $_SESSION['question_edit'] = $_POST['guestion_id'];
            header("Location: http://" . parent::getServerName() . "/Admin/Edit");
        }
        try {
            $data = $model->getDataAnswer($dbConnect);
            echo $view->getTwig()->render('adminSelect.twig', $data);
        } catch (\Exception $ex) {
            header("Location: http://" . parent::getServerName() . "/Admin/Not");
        }
    }
    
    public function actionNot($model, $view, $dbConnect)
    {
        self::logOn();
        if(!empty($_POST['question_select'])) {
            $_SESSION['theme_select'] = $_POST['theme_select'];
            header("Location: http://" . parent::getServerName() . "/Admin/Select");
        }
        $data = $model->getDataThemes($dbConnect);
        echo $view->getTwig()->render('adminNot.twig', $data);
    }
    
    public function actionTheme($model, $view, $dbConnect)
    {
        self::logOn();
        if (!empty($_POST['themeAdd'])) {
            try {
                $model->themeAdd($dbConnect);
                header("Location: ".$_SERVER['REQUEST_URI']);
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
        }
    
        if (!empty($_POST['themeDell'])) {
            $model->themeDell($dbConnect);
            header("Location: " . $_SERVER['REQUEST_URI']);
        }
        $data = $model->getDataSumm($dbConnect);
        echo $view->getTwig()->render('adminTheme.twig', $data);
    }
    
    public function actionQuestion($model, $view, $dbConnect)
    {
        self::logOn();
        if(!empty($_POST['question_select'])) {
            $_SESSION['theme_select'] = $_POST['theme_select'];
            header("Location: http://" . parent::getServerName() . "/Admin/Select");
        }
        $data = $model->getDataThemes($dbConnect);
        echo $view->getTwig()->render('adminQuestion.twig', $data);
    }
    
    public function actionEdit($model, $view, $dbConnect)
    {
        self::logOn();
        if (!empty($_POST['questionEditDell'])) {
            $model->questionDell($dbConnect);
            header("Location: " . $_SERVER['REQUEST_URI']);
        }
        if (!empty($_POST['questionEditStatus'])) {
            if($_POST['guestion_status'] == '2') {
                $model->updateStatusUp($dbConnect);
                header("Location: " . $_SERVER['REQUEST_URI']);
            }
            if($_POST['guestion_status'] == '3') {
                $model->updateStatusDown($dbConnect);
                header("Location: " . $_SERVER['REQUEST_URI']);
            }
        }
        if (!empty($_POST['questionThemeEdit'])) {
            $model->questionThemeEdit($dbConnect);
            header("Location: " . $_SERVER['REQUEST_URI']);
        }
        if(!empty($_POST['answerEdit'])) {
            if(!empty($_POST['answer_id'])) {
                $model->answerId($dbConnect);
                header("Location: " . $_SERVER['REQUEST_URI']);
            } else {
                $model->answerIdNo($dbConnect);
                header("Location: " . $_SERVER['REQUEST_URI']);
            }
        }
        if (!empty($_POST['questionTextEdit'])) {
            $model->questionTextEdit($dbConnect);
            header("Location: " . $_SERVER['REQUEST_URI']);
        }
        if (!empty($_POST['guestionNameEdit'])) {
            $model->guestionNameEdit($dbConnect);
            header("Location: " . $_SERVER['REQUEST_URI']);
        }
        $data = $model->getDataQuestion($dbConnect);
        echo $view->getTwig()->render('adminEdit.twig', $data);
    }
    
    public function actionAnswer($model, $view, $dbConnect)
    {
        self::logOn();
        if (!empty($_POST['questionDell'])) {
            $model->questionDell($dbConnect);
            header("Location: " . $_SERVER['REQUEST_URI']);
        }
        if(!empty($_POST['questionEdit'])) {
            $_SESSION['question_edit'] = $_POST['guestion_id'];
            header("Location: http://" . parent::getServerName() . "/Admin/Edit");
        }
        try {
            $data = $model->getDataAnswerNo($dbConnect);
            echo $view->getTwig()->render('adminAnswer.twig', $data);
        } catch (\Exception $ex) {
            echo '';
            header("Location: http://" . parent::getServerName() . "/Admin/NoQuestion");
        }
    }
    
    public function actionNoQuestion($model, $view, $dbConnect)
    {
        self::logOn();
        echo $view->getTwig()->render('adminNoQuestion.twig');
    }
    
    public function actionExit($model, $view, $dbConnect)
    {
        session_start();
        session_destroy();
        header("Location: http://" . parent::getServerName());
    }
}
