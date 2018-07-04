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
    
    public function actionIndex($model, $start)
    {
        self::logOn();
        if (!empty($_POST['adminAdd'])) {
            if (!empty($_POST['login']) && !empty($_POST['password'])) {
                $model->adminAdd();
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
                $model->passEdit();
            }
        }

        if (!empty($_POST['dell'])) {
            $model->dell();
        }
        $data = $model->getData();
        echo $this->twig->render('admin.twig', $data);
    }
    
    public function actionSelect($model, $start)
    {
        self::logOn();
        if (!empty($_POST['questionDell'])) {
            $model->questionDell();
        }
        if(!empty($_POST['questionEdit'])) {
            $_SESSION['question_edit'] = $_POST['guestion_id'];
            header("Location: http://" . $_SERVER['SERVER_NAME'] . "/diplom/public/Admin/Edit");
        }
        $data = $model->getDataAnswer();
        echo $this->twig->render('adminSelect.twig', $data);
    }
    
    public function actionNot($model, $start)
    {
        self::logOn();
        if(!empty($_POST['question_select'])) {
            $_SESSION['theme_select'] = $_POST['theme_select'];
            header("Location: http://" . $_SERVER['SERVER_NAME'] . "/diplom/public/Admin/Select");
        }
        $data = $model->getDataThemes();
        echo $this->twig->render('adminNot.twig', $data);
    }
    
    public function actionTheme($model, $start)
    {
        self::logOn();
        if (!empty($_POST['themeAdd'])) {
            $model->themeAdd();
        }
    
        if (!empty($_POST['themeDell'])) {
            $model->themeDell();
        }
        $data = $model->getDataSumm();
        echo $this->twig->render('adminTheme.twig', $data);
    }
    
    public function actionQuestion($model, $start)
    {
        self::logOn();
        if(!empty($_POST['question_select'])) {
            $_SESSION['theme_select'] = $_POST['theme_select'];
            header("Location: http://" . $_SERVER['SERVER_NAME'] . "/diplom/public/Admin/Select");
        }
        $data = $model->getDataThemes();
        echo $this->twig->render('adminQuestion.twig', $data);
    }
    
    public function actionEdit($model, $start)
    {
        self::logOn();
        if (!empty($_POST['questionEditDell'])) {
            $model->questionDell();
        }
        if (!empty($_POST['questionEditStatus'])) {
            if($_POST['guestion_status'] == '2') {
                $model->updateStatusUp();
            }
            if($_POST['guestion_status'] == '3') {
                $model->updateStatusDown();
            }
        }
        if (!empty($_POST['questionThemeEdit'])) {
            $model->questionThemeEdit();
        }
        if(!empty($_POST['answerEdit'])) {
            if(!empty($_POST['answer_id'])) {
                $model->answerId();
            } else {
                $model->answerIdNo();
            }
        }
        if (!empty($_POST['questionTextEdit'])) {
            $model->questionTextEdit();
        }
        if (!empty($_POST['guestionNameEdit'])) {
            $model->guestionNameEdit();
        }
        $data = $model->getDataQuestion();
        echo $this->twig->render('adminEdit.twig', $data);
    }
    
    public function actionAnswer($model, $start)
    {
        self::logOn();
        if (!empty($_POST['questionDell'])) {
            $model->questionDell();
        }
        if(!empty($_POST['questionEdit'])) {
            $_SESSION['question_edit'] = $_POST['guestion_id'];
            header("Location: http://" . $_SERVER['SERVER_NAME'] . "/diplom/public/Admin/Edit");
        }
        $data = $model->getDataAnswerNo();
        echo $this->twig->render('adminAnswer.twig', $data);
    }
    
    public function actionNoQuestion($model, $start)
    {
        self::logOn();
        echo $this->twig->render('adminNoQuestion.twig');
    }
    public function actionExit($model, $start)
    {
        session_start();
        session_destroy();
        header("Location: http://" . $_SERVER['SERVER_NAME'] . "/diplom/public");
    }
}
