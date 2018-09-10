<?php

namespace diplomApp\models;

class ModelAdmin extends \diplomApp\core\Model
{
    // @todo может $dbConnect через конструктор класть в свойство?
    public function getThemes($dbConnect)
    {
        // @todo надо через $this
        $sth = parent::selectAllThemes($dbConnect);
        $themes = [];
        while ($list = $sth->fetch(\PDO::FETCH_ASSOC)) {
            $themes[] = $list;
        }
        return $themes;
    }

    // @todo может $dbConnect через конструктор класть в свойство?
    public function getData($dbConnect)
    {
        //Получаем список администраторов;
        $users = $this->getUsers($dbConnect);
        $data = ['users' => $users];
        return $data;
    }

    // @todo может $dbConnect через конструктор класть в свойство?
    private function getUsers($dbConnect)
    {
        $db = $dbConnect->getDataBase();
        $sth = $db->query('SELECT id, login FROM `users`');
        $users = [];
        while ($list = $sth->fetch(\PDO::FETCH_ASSOC)) {
            $users[] = $list;
        }
        return $users;
    }

    // @todo может $dbConnect через конструктор класть в свойство?
    public function getDataSumm($dbConnect)
    {
        //Получаем список тем
        $themes = $this->getThemes($dbConnect);
        $i =0;
        $db = $dbConnect->getDataBase();
        $sum = [];//Общее количество вопросов
        $sumNo = [];//Вопросы без ответа
        $sumYes = [];//Вопросы с ответами
        foreach ($themes as $theme) {
            $id = $theme['id'];
            $sth = $db->prepare("SELECT COUNT(*) FROM `questions` WHERE theme_id=?");
            $sth->execute(array($id));
            $sum[$i]['id'] = $id;
            $sum[$i]['sum'] = implode($sth->fetch(\PDO::FETCH_NUM));
            // @todo что такое status=1? Может в константу?
            $sthNo = $db->prepare("SELECT COUNT(*) FROM `questions` WHERE theme_id=? AND status='1'");
            $sthNo->execute(array($id));
            $sumNo[$i]['id'] = $id;
            $sumNo[$i]['sum'] = implode($sthNo->fetch(\PDO::FETCH_NUM));
            // @todo что такое status=2? Может в константу?
            $sthYes = $db->prepare("SELECT COUNT(*) FROM `questions` WHERE theme_id=? AND status='2'");
            $sthYes->execute(array($id));
            $sumYes[$i]['id'] = $id;
            $sumYes[$i]['sum'] = implode($sthYes->fetch(\PDO::FETCH_NUM));
            $i++;
        }
        $data = ['themes' => $themes,
                'sum' => $sum,
                'sumYes' => $sumYes,
                'sumNo' => $sumNo];
        return $data;
    }

    // @todo может $dbConnect через конструктор класть в свойство?
    public function getDataThemes($dbConnect)
    {
        //Получаем список тем
        $themes = $this->getThemes($dbConnect);
        $data = ['themes' => $themes];
        return $data;    
    }

    // @todo может $dbConnect через конструктор класть в свойство?
    public function getDataAnswer($dbConnect)
    {
        //Получаем список тем
        $themes = $this->getThemes($dbConnect);
        $db = $dbConnect->getDataBase();
        //Получаем список вопросов и ответов
        foreach ($themes as $theme) {
            if($theme['id'] == $_SESSION['theme_select']){
                $id = $theme['id'];
                $sth = $db->prepare("SELECT id, question, date_add, status, theme_id FROM `questions` WHERE theme_id=?");
                $sth->execute(array($id));
                while ($list = $sth->fetch(\PDO::FETCH_ASSOC)) {
                    $posts[] = $list;
                }
                $sthAnswer = $db->prepare("SELECT questions.id, answers.answer FROM `questions` JOIN answers ON answers.id=answer_id WHERE theme_id=?");
                $sthAnswer->execute(array($id));
                while ($list = $sthAnswer->fetch(\PDO::FETCH_ASSOC)) {
                    $answers[] = $list;
                }
            }
        }
        if(empty($answers)) {
            $answers[] = "Нет ответа";
        }
        if(!empty($posts)) {
            $data = ['posts' => $posts,
                    'answers' => $answers,
                    'themes' => $themes];
            return $data;
        } else {
            throw new \Exception('Нет данных');
        }
    }

    // @todo может $dbConnect через конструктор класть в свойство?
    public function getDataQuestion($dbConnect)
    {
        //Получаем вопрос и ответ для редактирования
        $id = $_SESSION['question_edit'];
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("SELECT id, question, status, theme_id, name FROM `questions` WHERE id=?");
        $sth->execute(array($id));
        $question = $sth->fetch(\PDO::FETCH_ASSOC);
        $sthAnswer = $db->prepare("SELECT questions.id, answers.answer FROM `questions` JOIN answers ON answers.id=answer_id WHERE questions.id=?");
        $sthAnswer->execute(array($id));
        $answer = $sthAnswer->fetch(\PDO::FETCH_ASSOC);
        //Получаем список тем
        $themes = $this->getThemes($dbConnect);
        //Находим тему вопроса
        foreach ($themes as $teme) {
            if($teme['id'] == $question['theme_id']) {
                $question['theme'] = $teme['theme'];
            }
        }
        if(!empty($answer)) {
            $data = ['question' => $question,
                    'answer' => $answer,
                    'themes' => $themes];
            return $data;
        } else {
            $data = ['question' => $question,
                    'themes' => $themes];
            return $data;
        }
    }

    // @todo может $dbConnect через конструктор класть в свойство?
    public function getDataAnswerNo($dbConnect)
    {
    //Получаем список тем
        $themes = $this->getThemes($dbConnect);

        //Получаем вопросы без ответа
        $db = $dbConnect->getDataBase();
        // @todo вместо подстановки через переменную лучше через prepare(), как в других местах
        $sth = $db->query("SELECT id, question, date_add, status, theme_id FROM `questions` WHERE answer_id='$0' ORDER BY date_add");
        while ($list = $sth->fetch(\PDO::FETCH_ASSOC)) {
            $posts[] = $list;
        }
        if(!empty($posts)) {
            $data = ['posts' => $posts,
                    'themes' => $themes];
            return $data;
        } else {
            throw new \Exception('Нет данных');
        }
    }

    // @todo может $dbConnect через конструктор класть в свойство?
    public function adminAdd($dbConnect)
    {
        $user = strip_tags($_POST['login']);
        $password = password_hash(strip_tags($_POST['password']), PASSWORD_DEFAULT);
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("SELECT `login` FROM `users` WHERE login=?");
        $sth->execute(array($user));
        $w = $sth->fetchColumn();
        if($w) {
            throw new \Exception('Такой пользователь уже есть. Введите другой логин.');
        } else {
            $names = [$user, $password];
            $sth = $db->prepare("INSERT INTO `users`(`login`, `password`) VALUES (?, ?)");
            $sth->execute($names);
        }
    }

    // @todo может $dbConnect через конструктор класть в свойство?
    public function passEdit($dbConnect)
    {
        $id = $_POST['editPass_id'];
        $password[] = password_hash(strip_tags($_POST['newPassword']), PASSWORD_DEFAULT);
        $db = $dbConnect->getDataBase();
        // @todo вместо подстановки через переменную лучше через prepare(), как в других местах
        $sth = $db->prepare("UPDATE `users` SET `password`=? WHERE `id`=($id)");
        $sth->execute($password);
    }

    // @todo может $dbConnect через конструктор класть в свойство?
    public function dell($dbConnect)
    {
        $id = $_POST['dell_id'];
        $db = $dbConnect->getDataBase();
        // @todo вместо подстановки через переменную лучше через prepare(), как в других местах
        $sth = $db->prepare("DELETE FROM `users` WHERE `id`=($id)");
        $sth->execute(array($id));
    }

    // @todo может $dbConnect через конструктор класть в свойство?
    public function themeAdd($dbConnect)
    {
        // @todo лучше приводить в строке вот так $newTheme = (string) $_POST['newTheme']
        $newTheme = $_POST['newTheme'];
        // @todo надо использовать mb_strlen()
        if(strlen($newTheme) == 0){
            throw new \Exception('Тема не задана');
        }
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("SELECT `theme` FROM `themes` WHERE theme=?");
        $sth->execute(array($newTheme));
        $w = $sth->fetchColumn();
        if($w) {
            throw new \Exception('Такая тема уже есть. Введите другую.');
        } else {
            $sth = $db->prepare("INSERT INTO `themes`(`theme`) VALUES (?)");
            $sth->execute(array($newTheme));
        }
    }

    // @todo может $dbConnect через конструктор класть в свойство?
    public function themeDell($dbConnect)
    {
        // @todo лучше приводить в числу вот так $themeId = (int) $_POST['theme_id']
        $themeId = $_POST['theme_id'];
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("DELETE FROM `themes` WHERE id=?");
        $sth->execute(array($themeId));//Удаляем тему
        $sth = $db->prepare("SELECT `id` FROM `questions` WHERE theme_id=?");//Ищем ответы которые будем удалять
        $sth->execute(array($themeId));
        while ($list = $sth->fetch(\PDO::FETCH_NUM)) {
            $questionId = $list;
        }
        $st = $db->prepare("DELETE FROM `questions` WHERE theme_id=?");
        $st->execute(array($themeId));//Удаляем вопросы
        $sthh = $db->prepare("DELETE FROM `answers` WHERE question_id=?");
        if (!empty($questionId)) {
            $sthh->execute($questionId);//Удаляем ответы
        }
    }

    // @todo может $dbConnect через конструктор класть в свойство?
    public function questionDell($dbConnect)
    {
        // @todo лучше приводить в числу вот так $questionIdDell = (int) $_POST['guestion_id']
        $questionIdDell = $_POST['guestion_id'];
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("DELETE FROM `questions` WHERE id=?");
        $sth->execute(array($questionIdDell));//Удаляем вопрос
    }

    // @todo может $dbConnect через конструктор класть в свойство?
    public function updateStatusUp($dbConnect)
    {
        // @todo лучше приводить в числу вот так $questionEditStatusId = (int) $_POST['guestion_id']
        $questionEditStatusId = $_POST['guestion_id'];
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("UPDATE `questions` SET `status`=3 WHERE id=?");
        $sth->execute(array($questionEditStatusId));
    }

    // @todo может $dbConnect через конструктор класть в свойство?
    public function updateStatusDown($dbConnect)
    {
        // @todo лучше приводить в числу вот так $questionEditStatusId = (int) $_POST['guestion_id']
        $questionEditStatusId = $_POST['guestion_id'];
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("UPDATE `questions` SET `status`=2 WHERE id=?");
        $sth->execute(array($questionEditStatusId));
    }

    // @todo может $dbConnect через конструктор класть в свойство?
    public function questionThemeEdit($dbConnect)
    {
        // @todo лучше приводить в числу вот так $questionEditStatusId = (int) $_POST['guestion_id']
        $questionEditStatusId = $_POST['guestion_id'];
        $themeEditId = $_POST['themeEdit'];
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("UPDATE `questions` SET `theme_id`='$themeEditId' WHERE id=?");
        $sth->execute(array($questionEditStatusId));
    }

    // @todo может $dbConnect через конструктор класть в свойство?
    public function answerId($dbConnect)
    {
        // @todo лучше приводить в числу вот так $id = (int) $_POST['guestion_id']
        $id = $_POST['question_id'];
        $text = trim($_POST['text']);
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("UPDATE `answers` SET `answer`='$text' WHERE question_id=?");
        $sth->execute(array($id));
    }

    // @todo может $dbConnect через конструктор класть в свойство?
    public function answerIdNo($dbConnect)
    {
        // @todo лучше приводить в числу вот так $id = (int) $_POST['guestion_id']
        $id = $_POST['question_id'];
        $text = trim($_POST['text']);
        $data = array($id, $_SESSION['id'], $text);
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("INSERT INTO `answers`(`question_id`, `admin_id`, `answer`) VALUES (?, ?, ?)");
        $sth->execute($data);
        $newAnswerId = $db->lastInsertId();
        $sth = $db->prepare("UPDATE `questions` SET `answer_id`='$newAnswerId' WHERE id=?");
        $sth->execute(array($id));
        $sth = $db->prepare("UPDATE `questions` SET `status`='2' WHERE id=?");
        $sth->execute(array($id));
    }

    // @todo может $dbConnect через конструктор класть в свойство?
    public function questionTextEdit($dbConnect)
    {
        // @todo лучше приводить в числу вот так $questionEditTextId = (int) $_POST['guestion_id']
        $questionEditTextId = $_POST['question_id'];
        $textEdit = trim($_POST['text']);
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("UPDATE `questions` SET `question`='$textEdit' WHERE id=?");
        $sth->execute(array($questionEditTextId));
    }

    // @todo может $dbConnect через конструктор класть в свойство?
    public function guestionNameEdit($dbConnect)
    {
        // @todo лучше приводить в числу вот так $questionEditNameId = (int) $_POST['guestion_id']
        $questionEditNameId = $_POST['question_id'];
        $nameEdit = trim($_POST['text']);
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("UPDATE `questions` SET `name`='$nameEdit' WHERE id=?");
        $sth->execute(array($questionEditNameId));
    }           
}



