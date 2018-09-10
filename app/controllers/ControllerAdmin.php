<?php

namespace diplomApp\controllers;

class ControllerAdmin  extends \diplomApp\core\Controller
{
    // @todo может этот метод в конструктор, раз он используется везде?
    private function logOn()
    {
        session_start();
        if (empty($_SESSION['user'])) {
            // @todo может вынести в родительский метод например $this->redirectTo()
            // и надо вместо parent использовать $this->getServerName();
            // и протокол лучше не хардкодить, а брать из переменной $_SERVER
            header("Location: http://" . parent::getServerName());
            die();
        }
    }

    // @todo может $model, $view и $dbConnect правильнее присваивать в свойство например в конструкторе?
    public function actionIndex($model, $view, $dbConnect)
    {
        if (!empty($_POST['adminAdd'])) {
            // @todo обращаться надо через $this
            self::logOn();
            try {
                // @todo обращаться надо через $this
                parent::userControl();
                $model->adminAdd($dbConnect);
                // @todo может вынести в родительский метод например $this->redirectTo()
                header("Location: " . $_SERVER['REQUEST_URI']);
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
        }

        if (!empty($_POST['passEdit'])) {
            if (!empty($_POST['newPassword'])) {
                $model->passEdit($dbConnect);
                // @todo может вынести в родительский метод например $this->redirectTo()
                header("Location: " . $_SERVER['REQUEST_URI']);
            }
        }

        if (!empty($_POST['dell'])) {
            $model->dell($dbConnect);
            // @todo может вынести в родительский метод например $this->redirectTo()
            header("Location: " . $_SERVER['REQUEST_URI']);
        }
        $data = $model->getData($dbConnect);
        echo $view->getTwig()->render('admin.twig', $data);
    }

    // @todo может $model, $view и $dbConnect правильнее присваивать в свойство например в конструкторе?
    public function actionSelect($model, $view, $dbConnect)
    {
        // @todo обращаться надо через $this
        self::logOn();
        if (!empty($_POST['questionDell'])) {
            $model->questionDell($dbConnect);
            // @todo может вынести в родительский метод например $this->redirectTo()
            header("Location: " . $_SERVER['REQUEST_URI']);
        }
        if(!empty($_POST['questionEdit'])) {
            $_SESSION['question_edit'] = $_POST['guestion_id'];
            // @todo может вынести в родительский метод например $this->redirectTo()
            header("Location: http://" . parent::getServerName() . "/Admin/Edit");
        }
        try {
            $data = $model->getDataAnswer($dbConnect);
            echo $view->getTwig()->render('adminSelect.twig', $data);
        } catch (\Exception $ex) {
            // @todo может вынести в родительский метод например $this->redirectTo()
            header("Location: http://" . parent::getServerName() . "/Admin/Not");
        }
    }

    // @todo может $model, $view и $dbConnect правильнее присваивать в свойство например в конструкторе?
    public function actionNot($model, $view, $dbConnect)
    {
        // @todo обращаться надо через $this
        self::logOn();
        if(!empty($_POST['question_select'])) {
            $_SESSION['theme_select'] = $_POST['theme_select'];
            // @todo может вынести в родительский метод например $this->redirectTo()
            header("Location: http://" . parent::getServerName() . "/Admin/Select");
        }
        $data = $model->getDataThemes($dbConnect);
        echo $view->getTwig()->render('adminNot.twig', $data);
    }

    // @todo может $model, $view и $dbConnect правильнее присваивать в свойство например в конструкторе?
    public function actionTheme($model, $view, $dbConnect)
    {
        // @todo обращаться надо через $this
        self::logOn();
        if (!empty($_POST['themeAdd'])) {
            try {
                $model->themeAdd($dbConnect);
                // @todo может вынести в родительский метод например $this->redirectTo()
                header("Location: ".$_SERVER['REQUEST_URI']);
            } catch (\Exception $ex) {
                echo $ex->getMessage();
            }
        }

        if (!empty($_POST['themeDell'])) {
            $model->themeDell($dbConnect);
            // @todo может вынести в родительский метод например $this->redirectTo()
            header("Location: " . $_SERVER['REQUEST_URI']);
        }
        $data = $model->getDataSumm($dbConnect);
        echo $view->getTwig()->render('adminTheme.twig', $data);
    }

    // @todo может $model, $view и $dbConnect правильнее присваивать в свойство например в конструкторе?
    public function actionQuestion($model, $view, $dbConnect)
    {
        // @todo обращаться надо через $this
        self::logOn();
        if(!empty($_POST['question_select'])) {
            $_SESSION['theme_select'] = $_POST['theme_select'];
            // @todo может вынести в родительский метод например $this->redirectTo()
            header("Location: http://" . parent::getServerName() . "/Admin/Select");
        }
        $data = $model->getDataThemes($dbConnect);
        echo $view->getTwig()->render('adminQuestion.twig', $data);
    }

    // @todo может $model, $view и $dbConnect правильнее присваивать в свойство например в конструкторе?
    public function actionEdit($model, $view, $dbConnect)
    {
        // @todo обращаться надо через $this
        self::logOn();
        if (!empty($_POST['questionEditDell'])) {
            $model->questionDell($dbConnect);
            // @todo может вынести в родительский метод например $this->redirectTo()
            header("Location: " . $_SERVER['REQUEST_URI']);
        }
        if (!empty($_POST['questionEditStatus'])) {
            if($_POST['guestion_status'] == '2') {
                $model->updateStatusUp($dbConnect);
                // @todo может вынести в родительский метод например $this->redirectTo()
                header("Location: " . $_SERVER['REQUEST_URI']);
            }
            if($_POST['guestion_status'] == '3') {
                $model->updateStatusDown($dbConnect);
                // @todo может вынести в родительский метод например $this->redirectTo()
                header("Location: " . $_SERVER['REQUEST_URI']);
            }
        }
        if (!empty($_POST['questionThemeEdit'])) {
            $model->questionThemeEdit($dbConnect);
            // @todo может вынести в родительский метод например $this->redirectTo()
            header("Location: " . $_SERVER['REQUEST_URI']);
        }
        if(!empty($_POST['answerEdit'])) {
            if(!empty($_POST['answer_id'])) {
                $model->answerId($dbConnect);
                // @todo может вынести в родительский метод например $this->redirectTo()
                header("Location: " . $_SERVER['REQUEST_URI']);
            } else {
                $model->answerIdNo($dbConnect);
                // @todo может вынести в родительский метод например $this->redirectTo()
                header("Location: " . $_SERVER['REQUEST_URI']);
            }
        }
        if (!empty($_POST['questionTextEdit'])) {
            $model->questionTextEdit($dbConnect);
            // @todo может вынести в родительский метод например $this->redirectTo()
            header("Location: " . $_SERVER['REQUEST_URI']);
        }
        if (!empty($_POST['guestionNameEdit'])) {
            $model->guestionNameEdit($dbConnect);
            // @todo может вынести в родительский метод например $this->redirectTo()
            header("Location: " . $_SERVER['REQUEST_URI']);
        }
        $data = $model->getDataQuestion($dbConnect);
        echo $view->getTwig()->render('adminEdit.twig', $data);
    }

    // @todo может $model, $view и $dbConnect правильнее присваивать в свойство например в конструкторе?
    public function actionAnswer($model, $view, $dbConnect)
    {
        // @todo обращаться надо через $this
        self::logOn();
        if (!empty($_POST['questionDell'])) {
            $model->questionDell($dbConnect);
            // @todo может вынести в родительский метод например $this->redirectTo()
            header("Location: " . $_SERVER['REQUEST_URI']);
        }
        if(!empty($_POST['questionEdit'])) {
            $_SESSION['question_edit'] = $_POST['guestion_id'];
            // @todo может вынести в родительский метод например $this->redirectTo()
            header("Location: http://" . parent::getServerName() . "/Admin/Edit");
        }
        try {
            $data = $model->getDataAnswerNo($dbConnect);
            echo $view->getTwig()->render('adminAnswer.twig', $data);
        } catch (\Exception $ex) {
            // @todo зачем пустая строка?
            echo '';
            // @todo может вынести в родительский метод например $this->redirectTo()
            header("Location: http://" . parent::getServerName() . "/Admin/NoQuestion");
        }
    }

    // @todo может $model, $view и $dbConnect правильнее присваивать в свойство например в конструкторе?
    public function actionNoQuestion($model, $view, $dbConnect)
    {
        // @todo обращаться надо через $this
        self::logOn();
        echo $view->getTwig()->render('adminNoQuestion.twig');
    }

    // @todo может $model, $view и $dbConnect правильнее присваивать в свойство например в конструкторе?
    public function actionExit($model, $view, $dbConnect)
    {
        session_start();
        session_destroy();
        header("Location: http://" . parent::getServerName());
    }
}
