<?php

namespace diplomApp\models;

class ModelAdmin extends \diplomApp\core\Model
{
    private function getServerName()
    {
        $config = new \diplomApp\core\Config();
        return $config->getServerName();
    }
    
    public function startIndex() {
        
    }

    public function getData()
    {
        //Получаем список администраторов;
        $users = $this->getUsers();
        $data = ['users' => $users];
        return $data;
    }
    
    private function getThemes()
    {
        $dbConnect = new \diplomApp\core\DataBase();
        $db = $dbConnect->getDataBase();
        $sth = $db->query('SELECT * FROM `themes`');
        while ($list = $sth->fetch(\PDO::FETCH_ASSOC)) {
            $themes[] = $list;
        }
        return $themes;
    }
    
    private function getUsers()
    {
        $dbConnect = new \diplomApp\core\DataBase();
        $db = $dbConnect->getDataBase();
        $sth = $db->query('SELECT id, login FROM `users`');
        while ($list = $sth->fetch(\PDO::FETCH_ASSOC)) {
            $users[] = $list;
        }
        return $users;
    }

    public function getDataSumm()
    {
        //Получаем список тем
        $themes = $this->getThemes();
        $i =0;
        $dbConnect = new \diplomApp\core\DataBase();
        $db = $dbConnect->getDataBase();
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
    
    public function getDataThemes()
    {
        //Получаем список тем
        $themes = $this->getThemes();
        $data = ['themes' => $themes];
        return $data;    
    }
    
    public function getDataAnswer()
    {
        //Получаем список тем
        $themes = $this->getThemes();
        $dbConnect = new \diplomApp\core\DataBase();
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
            header("Location: http://" . $this->getServerName() . "/diplom/public/Admin/Not");
        }
    }
    
    public function getDataQuestion()
    {
        //Получаем вопрос и ответ для редактирования
        $id = $_SESSION['question_edit'];
        $dbConnect = new \diplomApp\core\DataBase();
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("SELECT id, question, status, theme_id, name FROM `questions` WHERE id=?");
        $sth->execute(array($id));
        $question = $sth->fetch(\PDO::FETCH_ASSOC);
        $sthAnswer = $db->prepare("SELECT questions.id, answers.answer FROM `questions` JOIN answers ON answers.id=answer_id WHERE questions.id=?");
        $sthAnswer->execute(array($id));
        $answer = $sthAnswer->fetch(\PDO::FETCH_ASSOC);
        //Получаем список тем
        $themes = $this->getThemes($db);
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
    
    public function getDataAnswerNo()
    {
    //Получаем список тем
        $themes = $this->getThemes();

        //Получаем вопросы без ответа
        $dbConnect = new \diplomApp\core\DataBase();
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
            header("Location: http://" . $this->getServerName() . "/diplom/public/Admin/NoQuestion");
        }
    }

    public function adminAdd()
    {
        $user = strip_tags($_POST['login']);
        $password = password_hash(strip_tags($_POST['password']), PASSWORD_DEFAULT);
        $dbConnect = new \diplomApp\core\DataBase();
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("SELECT `login` FROM `users` WHERE login=?");
        $sth->execute(array($user));
        $w = $sth->fetchColumn();
        if($w) {
            echo 'Такой пользователь уже есть. Введите другой логин.';
        } else {
            $names = [$user, $password];
            $sth = $db->prepare("INSERT INTO `users`(`login`, `password`) VALUES (?, ?)");
            $sth->execute($names);
            header("Location: " . $_SERVER['REQUEST_URI']);
        }
    }    
    
    public function passEdit()
    {
        $id = $_POST['editPass_id'];
        $password[] = password_hash(strip_tags($_POST['newPassword']), PASSWORD_DEFAULT);
        $dbConnect = new \diplomApp\core\DataBase();
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("UPDATE `users` SET `password`=? WHERE `id`=($id)");
        $sth->execute($password);
        header("Location: " . $_SERVER['REQUEST_URI']);
    }
    
    public function dell()
    {
        $id = $_POST['dell_id'];
        $dbConnect = new \diplomApp\core\DataBase();
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("DELETE FROM `users` WHERE `id`=($id)");
        $sth->execute(array($id));
        header("Location: " . $_SERVER['REQUEST_URI']);
    }

    public function themeAdd()
    {
        $newTheme = $_POST['newTheme'];
        $dbConnect = new \diplomApp\core\DataBase();
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("SELECT `theme` FROM `themes` WHERE theme=?");
        $sth->execute(array($newTheme));
        $w = $sth->fetchColumn();
        if($w) {
            echo 'Такая тема уже есть. Введите другую.';
        } else {
            if(strlen($newTheme) == 0){
                header("Location: " . $_SERVER['REQUEST_URI']);
                die();
            }
            $sth = $db->prepare("INSERT INTO `themes`(`theme`) VALUES (?)");
            $sth->execute(array($newTheme));
            header("Location: ".$_SERVER['REQUEST_URI']);
        }
    }
    
    public function themeDell()
    {
        $themeId = $_POST['theme_id'];
        $dbConnect = new \diplomApp\core\DataBase();
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
            header("Location: " . $_SERVER['REQUEST_URI']);
        }
    }
    
    public function questionDell()
    {
        $questionIdDell = $_POST['guestion_id'];
        $dbConnect = new \diplomApp\core\DataBase();
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("DELETE FROM `questions` WHERE id=?");
        $sth->execute(array($questionIdDell));//Удаляем вопрос
        header("Location: " . $_SERVER['REQUEST_URI']);
    }
    
    public function updateStatusUp()
    {
        $questionEditStatusId = $_POST['guestion_id'];
        $dbConnect = new \diplomApp\core\DataBase();
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("UPDATE `questions` SET `status`=3 WHERE id=?");
        $sth->execute(array($questionEditStatusId));
        header("Location: " . $_SERVER['REQUEST_URI']);
    }
    
    public function updateStatusDown()
    {
        $questionEditStatusId = $_POST['guestion_id'];
        $dbConnect = new \diplomApp\core\DataBase();
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("UPDATE `questions` SET `status`=2 WHERE id=?");
        $sth->execute(array($questionEditStatusId));
        header("Location: " . $_SERVER['REQUEST_URI']);
    }
    
    public function questionThemeEdit()
    {
        $questionEditStatusId = $_POST['guestion_id'];
        $themeEditId = $_POST['themeEdit'];
        $dbConnect = new \diplomApp\core\DataBase();
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("UPDATE `questions` SET `theme_id`='$themeEditId' WHERE id=?");
        $sth->execute(array($questionEditStatusId));
        header("Location: " . $_SERVER['REQUEST_URI']);
    }
    
    public function answerId()
    {
        $id = $_POST['question_id'];
        $text = trim($_POST['text']);
        $dbConnect = new \diplomApp\core\DataBase();
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("UPDATE `answers` SET `answer`='$text' WHERE question_id=?");
        $sth->execute(array($id));
        header("Location: " . $_SERVER['REQUEST_URI']);
    }
    
    public function answerIdNo()
    {
        $id = $_POST['question_id'];
        $text = trim($_POST['text']);
        $data = array($id, $_SESSION['id'], $text);
        $dbConnect = new \diplomApp\core\DataBase();
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("INSERT INTO `answers`(`question_id`, `admin_id`, `answer`) VALUES (?, ?, ?)");
        $sth->execute($data);
        $newAnswerId = $db->lastInsertId();
        $sth = $db->prepare("UPDATE `questions` SET `answer_id`='$newAnswerId' WHERE id=?");
        $sth->execute(array($id));
        $sth = $db->prepare("UPDATE `questions` SET `status`='2' WHERE id=?");
        $sth->execute(array($id));
        header("Location: " . $_SERVER['REQUEST_URI']);
    }
    
    public function questionTextEdit()
    {
        $questionEditTextId = $_POST['question_id'];
        $textEdit = trim($_POST['text']);
        $dbConnect = new \diplomApp\core\DataBase();
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("UPDATE `questions` SET `question`='$textEdit' WHERE id=?");
        $sth->execute(array($questionEditTextId));
        header("Location: " . $_SERVER['REQUEST_URI']);
    }
    
    public function guestionNameEdit()
    {
        $questionEditNameId = $_POST['question_id'];
        $nameEdit = trim($_POST['text']);
        $dbConnect = new \diplomApp\core\DataBase();
        $db = $dbConnect->getDataBase();
        $sth = $db->prepare("UPDATE `questions` SET `name`='$nameEdit' WHERE id=?");
        $sth->execute(array($questionEditNameId));
        header("Location: " . $_SERVER['REQUEST_URI']);
    }           
}



