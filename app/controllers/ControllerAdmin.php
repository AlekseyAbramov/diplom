<?php

namespace diplomApp\controllers;

class ControllerAdmin  extends \diplomApp\core\Controller
{
    private function logOn()
    {
        session_start();
        if (empty($_SESSION['user'])) {
            header("Location: http://" . $_SERVER['SERVER_NAME'] . "/diplom/public");
            die();
        }
    }
    
    public function actionIndex($model, $start, $db)
    {
        self::logOn();
        if (!empty($_POST['adminAdd'])) {
            if (!empty($_POST['login']) && !empty($_POST['password'])) {
                $model->adminAdd($db);
            }
            if (!empty($_POST['login']) && empty($_POST['password'])) {
                echo 'Вы на ввели пароль';
            }
            if (empty($_POST['login']) && !empty($_POST['password'])) {
                echo 'Вы не ввели логин';
            }
            if (empty($_POST['login']) && empty($_POST['password'])) {
                echo 'Вы не ввели логин и пароль';
            }
        }
                        
        if (!empty($_POST['passEdit'])) {
            if (!empty($_POST['newPassword'])) {
                $model->passEdit($db);
            }
        }

        if (!empty($_POST['dell'])) {
            $model->dell($db);
        }
        $data = $model->getData($db);
        echo $this->twig->render('admin.twig', $data);
    }
    
    public function actionSelect($model, $start, $db)
    {
        self::logOn();
        if (!empty($_POST['questionDell'])) {
            $model->questionDell($db);
        }
        if(!empty($_POST['questionEdit'])) {
            $_SESSION['question_edit'] = $_POST['guestion_id'];
            header("Location: http://" . $_SERVER['SERVER_NAME'] . "/diplom/public/Admin/Edit");
        }
        $data = $model->getDataAnswer($db);
        echo $this->twig->render('adminSelect.twig', $data);
    }
    
    public function actionNot($model, $start, $db)
    {
        self::logOn();
        if(!empty($_POST['question_select'])) {
            $_SESSION['theme_select'] = $_POST['theme_select'];
            header("Location: http://" . $_SERVER['SERVER_NAME'] . "/diplom/public/Admin/Select");
        }
        $data = $model->getDataThemes($db);
        echo $this->twig->render('adminNot.twig', $data);
    }
    
    public function actionTheme($model, $start, $db)
    {
        self::logOn();
        if (!empty($_POST['themeAdd'])) {
            $model->themeAdd($db);
        }
    
        if (!empty($_POST['themeDell'])) {
            $model->themeDell($db);
        }
        $data = $model->getDataSumm($db);
        echo $this->twig->render('adminTheme.twig', $data);
    }
    
    public function actionQuestion($model, $start, $db)
    {
        self::logOn();
        if(!empty($_POST['question_select'])) {
            $_SESSION['theme_select'] = $_POST['theme_select'];
            header("Location: http://" . $_SERVER['SERVER_NAME'] . "/diplom/public/Admin/Select");
        }
        $data = $model->getDataThemes($db);
        echo $this->twig->render('adminQuestion.twig', $data);
    }
    
    public function actionEdit($model, $start, $db)
    {
        self::logOn();
        if (!empty($_POST['questionEditDell'])) {
            $model->questionDell($db);
        }
        if (!empty($_POST['questionEditStatus'])) {
            if($_POST['guestion_status'] == '2') {
                $model->updateStatusUp($db);
            }
            if($_POST['guestion_status'] == '3') {
                $model->updateStatusDown($db);
            }
        }
        if (!empty($_POST['questionThemeEdit'])) {
            $model->questionThemeEdit($db);
        }
        if(!empty($_POST['answerEdit'])) {
            if(!empty($_POST['answer_id'])) {
                $model->answerId($db);
            } else {
                $model->answerIdNo($db);
            }
        }
        if (!empty($_POST['questionTextEdit'])) {
            $model->questionTextEdit($db);
        }
        if (!empty($_POST['guestionNameEdit'])) {
            $model->guestionNameEdit($db);
        }
        $data = $model->getDataQuestion($db);
        echo $this->twig->render('adminEdit.twig', $data);
    }
    
    public function actionAnswer($model, $start, $db)
    {
        self::logOn();
        if (!empty($_POST['questionDell'])) {
            $model->questionDell($db);
        }
        if(!empty($_POST['questionEdit'])) {
            $_SESSION['question_edit'] = $_POST['guestion_id'];
            header("Location: http://" . $_SERVER['SERVER_NAME'] . "/diplom/public/Admin/Edit");
        }
        $data = $model->getDataAnswerNo($db);
        echo $this->twig->render('adminAnswer.twig', $data);
    }
    
    public function actionNoQuestion($model, $start, $db)
    {
        self::logOn();
        echo $this->twig->render('adminNoQuestion.twig');
    }
    public function actionExit($model, $start, $db)
    {
        session_start();
        session_destroy();
        header("Location: http://" . $_SERVER['SERVER_NAME'] . "/diplom/public");
    }
}
