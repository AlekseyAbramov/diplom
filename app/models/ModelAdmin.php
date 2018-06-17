<?php

namespace diplomApp\models;

class ModelAdmin extends \diplomApp\core\Model
{   
    public function startIndex($db) {
        
    }

    public function getData($db)
    {
        //Получаем список администраторов
        $dbUsers = new \diplomApp\classes\DbUser();
        $users = $dbUsers->getUsers($db);
        $data = ['users' => $users];
        return $data;
    }
    
    public function getDataSumm($db)
    {
        //Получаем список тем
        $dbThemes = new \diplomApp\classes\DbThemes();
        $themes = $dbThemes->getThemes($db);
        $i =0;
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
    
    public function getDataThemes($db)
    {
        //Получаем список тем
        $dbThemes = new \diplomApp\classes\DbThemes();
        $themes = $dbThemes->getThemes($db);
        $data = ['themes' => $themes];
        return $data;    
    }
    
    public function getDataAnswer($db)
    {
        //Получаем список тем
        $dbThemes = new \diplomApp\classes\DbThemes();
        $themes = $dbThemes->getThemes($db);

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
            header("Location: http://" . $_SERVER['SERVER_NAME'] . "/diplom/public/Admin/Not");
        }
    }
    
    public function getDataQuestion($db)
    {
        //Получаем вопрос и ответ для редактирования
        $id = $_SESSION['question_edit'];
        $sth = $db->prepare("SELECT id, question, status, theme_id, name FROM `questions` WHERE id=?");
        $sth->execute(array($id));
        $question = $sth->fetch(\PDO::FETCH_ASSOC);
        $sthAnswer = $db->prepare("SELECT questions.id, answers.answer FROM `questions` JOIN answers ON answers.id=answer_id WHERE questions.id=?");
        $sthAnswer->execute(array($id));
        $answer = $sthAnswer->fetch(\PDO::FETCH_ASSOC);
        //Получаем список тем
        $dbThemes = new \diplomApp\classes\DbThemes();
        $themes = $dbThemes->getThemes($db);
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
    
    public function getDataAnswerNo($db)
    {
    //Получаем список тем
        $dbThemes = new \diplomApp\classes\DbThemes();
        $themes = $dbThemes->getThemes($db);

        //Получаем вопросы без ответа
        $sth = $db->query("SELECT id, question, date_add, status, theme_id FROM `questions` WHERE answer_id='$0' ORDER BY date_add");
        while ($list = $sth->fetch(\PDO::FETCH_ASSOC)) {
            $posts[] = $list;
        }
        if(!empty($posts)) {
            $data = ['posts' => $posts,
                    'themes' => $themes];
            return $data;
        } else {
            header("Location: http://" . $_SERVER['SERVER_NAME'] . "/diplom/public/Admin/NoQuestion");
        }
    }

    public function adminAdd($db)
    {
        $user = strip_tags($_POST['login']);
        $password = password_hash(strip_tags($_POST['password']), PASSWORD_DEFAULT);
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
    
    public function passEdit($db)
    {
        $id = $_POST['editPass_id'];
        $password[] = password_hash(strip_tags($_POST['newPassword']), PASSWORD_DEFAULT);
        $sth = $db->prepare("UPDATE `users` SET `password`=? WHERE `id`=($id)");
        $sth->execute($password);
        header("Location: " . $_SERVER['REQUEST_URI']);
    }
    
    public function dell($db)
    {
        $id = $_POST['dell_id'];
        $sth = $db->prepare("DELETE FROM `users` WHERE `id`=($id)");
        $sth->execute(array($id));
        header("Location: " . $_SERVER['REQUEST_URI']);
    }

    public function themeAdd($db)
    {
        $newTheme = $_POST['newTheme'];
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
    
    public function themeDell($db)
    {
        $themeId = $_POST['theme_id'];
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
    
    public function questionDell($db)
    {
        $questionIdDell = $_POST['guestion_id'];
        $sth = $db->prepare("DELETE FROM `questions` WHERE id=?");
        $sth->execute(array($questionIdDell));//Удаляем вопрос
        header("Location: " . $_SERVER['REQUEST_URI']);
    }
    
    public function updateStatusUp($db)
    {
        $questionEditStatusId = $_POST['guestion_id'];
        $sth = $db->prepare("UPDATE `questions` SET `status`=3 WHERE id=?");
        $sth->execute(array($questionEditStatusId));
        header("Location: " . $_SERVER['REQUEST_URI']);
    }
    
    public function updateStatusDown($db)
    {
        $questionEditStatusId = $_POST['guestion_id'];
        $sth = $db->prepare("UPDATE `questions` SET `status`=2 WHERE id=?");
        $sth->execute(array($questionEditStatusId));
        header("Location: " . $_SERVER['REQUEST_URI']);
    }
    
    public function questionThemeEdit($db)
    {
        $questionEditStatusId = $_POST['guestion_id'];
        $themeEditId = $_POST['themeEdit'];
        $sth = $db->prepare("UPDATE `questions` SET `theme_id`='$themeEditId' WHERE id=?");
        $sth->execute(array($questionEditStatusId));
        header("Location: " . $_SERVER['REQUEST_URI']);
    }
    
    public function answerId($db)
    {
        $id = $_POST['question_id'];
        $text = trim($_POST['text']);
        $sth = $db->prepare("UPDATE `answers` SET `answer`='$text' WHERE question_id=?");
        $sth->execute(array($id));
        header("Location: " . $_SERVER['REQUEST_URI']);
    }
    
    public function answerIdNo($db)
    {
        $id = $_POST['question_id'];
        $text = trim($_POST['text']);
        $data = array($id, $_SESSION['id'], $text);
        $sth = $db->prepare("INSERT INTO `answers`(`question_id`, `admin_id`, `answer`) VALUES (?, ?, ?)");
        $sth->execute($data);
        $newAnswerId = $db->lastInsertId();
        $sth = $db->prepare("UPDATE `questions` SET `answer_id`='$newAnswerId' WHERE id=?");
        $sth->execute(array($id));
        $sth = $db->prepare("UPDATE `questions` SET `status`='2' WHERE id=?");
        $sth->execute(array($id));
        header("Location: " . $_SERVER['REQUEST_URI']);
    }
    
    public function questionTextEdit($db)
    {
        $questionEditTextId = $_POST['question_id'];
        $textEdit = trim($_POST['text']);
        $sth = $db->prepare("UPDATE `questions` SET `question`='$textEdit' WHERE id=?");
        $sth->execute(array($questionEditTextId));
        header("Location: " . $_SERVER['REQUEST_URI']);
    }
    
    public function guestionNameEdit($db)
    {
        $questionEditNameId = $_POST['question_id'];
        $nameEdit = trim($_POST['text']);
        $sth = $db->prepare("UPDATE `questions` SET `name`='$nameEdit' WHERE id=?");
        $sth->execute(array($questionEditNameId));
        header("Location: " . $_SERVER['REQUEST_URI']);
    }           
}



