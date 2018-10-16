<?php

namespace diplomApp\controllers;

use diplomApp\models\ModelAdmin;

class ControllerAdmin extends \diplomApp\core\Controller
{
    /** @var  ModelAdmin */
    protected $model;

    public function actionIndex()
    {
        $this->logOn();
        if (!empty($_POST['adminAdd'])) {
            try {
                $this->userControl();
                $this->model->adminAdd();
                $this->redirect();
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
        }

        if (!empty($_POST['passEdit'])) {
            if (!empty($_POST['newPassword'])) {
                $this->model->passEdit();
                $this->redirect();
            }
        }

        if (!empty($_POST['dell'])) {
            $this->model->dell();
            $this->redirect();
        }
        $data = $this->model->getData();
        echo $this->view->getTwig()->render('admin.twig', $data);
    }

    public function actionSelect()
    {
        $this->logOn();
        if (!empty($_POST['questionDell'])) {
            $this->model->questionDell();
            $this->redirect();
        }
        if(!empty($_POST['questionEdit'])) {
            $_SESSION['question_edit'] = $_POST['guestion_id'];
            $page = '/Admin/Edit';
            $this->redirectTo($page);
        }
        try {
            $data = $this->model->getDataAnswer();
            echo $this->view->getTwig()->render('adminSelect.twig', $data);
        } catch (\Exception $ex) {
            $page = '/Admin/Not';
            $this->redirectTo($page);
        }
    }

    public function actionNot()
    {
        $this->logOn();
        if(!empty($_POST['question_select'])) {
            $_SESSION['theme_select'] = $_POST['theme_select'];
            $page = '/Admin/Select';
            $this->redirectTo($page);
        }
        $data = $this->model->getDataThemes();
        echo $this->view->getTwig()->render('adminNot.twig', $data);
    }

    public function actionTheme()
    {
        $this->logOn();
        if (!empty($_POST['themeAdd'])) {
            try {
                $this->model->themeAdd();
                $this->redirect();
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
        }

        if (!empty($_POST['themeDell'])) {
            $this->model->themeDell();
            $this->redirect();
        }
        $data = $this->model->getDataSumm();
        echo $this->view->getTwig()->render('adminTheme.twig', $data);
    }

    public function actionQuestion()
    {
        $this->logOn();
        if(!empty($_POST['question_select'])) {
            $_SESSION['theme_select'] = $_POST['theme_select'];
            $page = '/Admin/Select';
            $this->redirectTo($page);
        }
        $data = $this->model->getDataThemes();
        echo $this->view->getTwig()->render('adminQuestion.twig', $data);
    }

    public function actionEdit()
    {
        $this->logOn();
        if (!empty($_POST['questionEditDell'])) {
            $this->model->questionDell();
            $this->redirect();
        }
        if (!empty($_POST['questionEditStatus'])) {
            if($_POST['guestion_status'] == '2') {
                $this->model->updateStatusUp();
                $this->redirect();
            }
            if($_POST['guestion_status'] == '3') {
                $this->model->updateStatusDown();
                $this->redirect();
            }
        }
        if (!empty($_POST['questionThemeEdit'])) {
            $this->model->questionThemeEdit();
            $this->redirect();
        }
        if(!empty($_POST['answerEdit'])) {
            if(!empty($_POST['answer_id'])) {
                $this->model->answerId();
                $this->redirect();
            } else {
                $this->model->answerIdNo();
                $this->redirect();
            }
        }
        if (!empty($_POST['questionTextEdit'])) {
            $this->model->questionTextEdit();
            $this->redirect();
        }
        if (!empty($_POST['guestionNameEdit'])) {
            $this->model->guestionNameEdit();
            $this->redirect();
        }
        $data = $this->model->getDataQuestion();
        echo $this->view->getTwig()->render('adminEdit.twig', $data);
    }

    public function actionAnswer()
    {
        $this->logOn();
        if (!empty($_POST['questionDell'])) {
            $this->model->questionDell();
            $this->redirect();
        }
        if(!empty($_POST['questionEdit'])) {
            $_SESSION['question_edit'] = $_POST['guestion_id'];
            $page = '/Admin/Edit';
            $this->redirectTo($page);
        }
        try {
            $data = $this->model->getDataAnswerNo();
            echo $this->view->getTwig()->render('adminAnswer.twig', $data);
        } catch (\Exception $ex) {
            $page = '/Admin/NoQuestion';
            $this->redirectTo($page);
        }
    }

    public function actionNoQuestion()
    {
        $this->logOn();
        echo $this->view->getTwig()->render('adminNoQuestion.twig');
    }

    public function actionExit()
    {
        session_start();
        session_destroy();
        $page = '';
        $this->redirectTo($page);
    }
}
