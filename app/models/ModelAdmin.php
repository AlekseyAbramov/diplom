<?php

namespace diplomApp\models;

class ModelAdmin extends \diplomApp\core\Model
{
    public function getThemes($dbConnect)
    {
        $sth = parent::selectAllThemes($dbConnect);
        $themes = [];
        while ($list = $sth->fetch(\PDO::FETCH_ASSOC)) {
            $themes[] = $list;
        }
        return $themes;
    }
    
    public function getData($dbConnect)
    {
        //Получаем список администраторов;
        $users = $this->getUsers($dbConnect);
        $data = ['users' => $users];
        return $data;
    }
    
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
            $sthNo = $db->prepare("SELECT COUNT(*) FROM `questions` WHERE theme_id=? AND status='1'");
            $sthNo->execute(array($id));
            $sumNo[$i]['id'] = $id;
            $sumNo[$i]['sum'] = implode($sthNo->fetch(\PDO::FETCH_NUM));
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
    
    public function getDataThemes($dbConnect)
    {
        //Получаем список тем
        $themes = $this->getThemes($dbConnect);
        $data = ['themes' => $themes];
        return $data;    
    }
    
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
    
    public function getDataAnswerNo($dbConnect)
    {
    //Получаем список тем
        $themes = $this->getThemes($dbConnect);

        //Получаем вопросы без ответа
        $db = $dbConnect->getDataBase();
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
    
    public function passEdit($dbConnect)
    {
        $id = $_POST['editPass_id'];
        $password[] = password_hash(strip_tags($_POST['newPassword']), PASSWORD_DEFAULT);
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("UPDATE `users` SET `password`=? WHERE `id`=($id)");
        $sth->execute($password);
    }
    
    public function dell($dbConnect)
    {
        $id = $_POST['dell_id'];
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("DELETE FROM `users` WHERE `id`=($id)");
        $sth->execute(array($id));
    }

    public function themeAdd($dbConnect)
    {
        $newTheme = $_POST['newTheme'];
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
    
    public function themeDell($dbConnect)
    {
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
    
    public function questionDell($dbConnect)
    {
        $questionIdDell = $_POST['guestion_id'];
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("DELETE FROM `questions` WHERE id=?");
        $sth->execute(array($questionIdDell));//Удаляем вопрос
    }
    
    public function updateStatusUp($dbConnect)
    {
        $questionEditStatusId = $_POST['guestion_id'];
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("UPDATE `questions` SET `status`=3 WHERE id=?");
        $sth->execute(array($questionEditStatusId));
    }
    
    public function updateStatusDown($dbConnect)
    {
        $questionEditStatusId = $_POST['guestion_id'];
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("UPDATE `questions` SET `status`=2 WHERE id=?");
        $sth->execute(array($questionEditStatusId));
    }
    
    public function questionThemeEdit($dbConnect)
    {
        $questionEditStatusId = $_POST['guestion_id'];
        $themeEditId = $_POST['themeEdit'];
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("UPDATE `questions` SET `theme_id`='$themeEditId' WHERE id=?");
        $sth->execute(array($questionEditStatusId));
    }
    
    public function answerId($dbConnect)
    {
        $id = $_POST['question_id'];
        $text = trim($_POST['text']);
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("UPDATE `answers` SET `answer`='$text' WHERE question_id=?");
        $sth->execute(array($id));
    }
    
    public function answerIdNo($dbConnect)
    {
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
    
    public function questionTextEdit($dbConnect)
    {
        $questionEditTextId = $_POST['question_id'];
        $textEdit = trim($_POST['text']);
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("UPDATE `questions` SET `question`='$textEdit' WHERE id=?");
        $sth->execute(array($questionEditTextId));
    }
    
    public function guestionNameEdit($dbConnect)
    {
        $questionEditNameId = $_POST['question_id'];
        $nameEdit = trim($_POST['text']);
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("UPDATE `questions` SET `name`='$nameEdit' WHERE id=?");
        $sth->execute(array($questionEditNameId));
    }           
}



