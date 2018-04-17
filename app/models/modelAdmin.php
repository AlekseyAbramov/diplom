<?php
session_start();

if (!empty($_SESSION['user'])) {
    if (!empty($_POST)) {
        if (!empty($_POST['adminAdd'])) {
            if (!empty($_POST['login']) && !empty($_POST['password'])) {
                $user = strip_tags($_POST['login']);
                $password = password_hash(strip_tags($_POST['password']), PASSWORD_DEFAULT);
                $sth = $db->prepare("SELECT `login` FROM `users` WHERE login=?");
                $sth->execute(array($user));
                $w = $sth->fetchColumn();
                if($w) {
                   echo 'Такой пользователь уже есть. Введите другой логин.';
                } else {
                    $names = $user. ','. $password;
                    $names = explode(',', $names);
                    $placeholder = implode(',', array_fill(0, count($names), '?'));
                    $sth = $db->prepare("INSERT INTO `users`(`login`, `password`) VALUES ($placeholder)");
                    $sth->execute($names);
                    echo 'Вы создали нового администратора';
                    header("Location: /diplom/public/admin");
                }
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
        if (!empty($_POST['passEdit'])){
            if (!empty($_POST['newPassword'])) {
                $id = $_POST['editPass_id'];
                $password[] = password_hash(strip_tags($_POST['newPassword']), PASSWORD_DEFAULT);
                $sth = $db->prepare("UPDATE `users` SET `password`=? WHERE `id`=($id)");
                $sth->execute($password);
                header("Location: /diplom/public/admin");
            }
        }
        if (!empty($_POST['dell'])) {
            $id = $_POST['dell_id'];
            $sth = $db->prepare("DELETE FROM `users` WHERE `id`=($id)");
            $sth->execute(array($id));
            header("Location: /diplom/public/admin");
        }
        if (!empty($_POST['themeAdd'])) {
            $newTheme = $_POST['newTheme'];
            $sth = $db->prepare("SELECT `theme` FROM `themes` WHERE theme=?");
            $sth->execute(array($newTheme));
            $w = $sth->fetchColumn();
            if($w) {
                echo 'Такая тема уже есть. Введите другую.';
            } else {
                if($newTheme == 0){
                    header("Location: /diplom/public/admin");
                    die();
                }
                $sth = $db->prepare("INSERT INTO `themes`(`theme`) VALUES (?)");
                $sth->execute(array($newTheme));
                echo 'Вы создали новую тему';
                header("Location: /diplom/public/admin");
            }
        }
        if (!empty($_POST['themeDell'])) {
            $themeId = $_POST['theme_id'];
            $sth = $db->prepare("DELETE FROM `themes` WHERE id=?");
            $sth->execute(array($themeId));//Удаляем тему
            $sth = $db->prepare("SELECT `id` FROM `questions` WHERE theme_id=?");//Ищем ответы которые будем удалять
            $sth->execute(array($themeId));
            while ($list = $sth->fetch(PDO::FETCH_NUM)) {
                $questionId = $list;
            }
            $sth = $db->prepare("DELETE FROM `questions` WHERE theme_id=?");
            $sth->execute(array($themeId));//Удаляем вопросы
            $sth = $db->prepare("DELETE FROM `answers` WHERE question_id=?");
            $sth->execute($questionId);//Удаляем ответы
            header("Location: /diplom/public/admin");
        }
        if(!empty($_POST['question_select'])) {
            $_SESSION['theme_select'] = $_POST['theme_select'];
            header("Location: /diplom/public/admin/select");
        }
        if (!empty($_POST['questionDell'])) {
            $questionIdDell = $_POST['guestion_id'];
            $sth = $db->prepare("DELETE FROM `questions` WHERE id=?");
            $sth->execute(array($questionIdDell));//Удаляем вопрос
            header("Location: /diplom/public/admin/select");
        }
        if(!empty($_POST['questionEdit'])) {
            $_SESSION['question_edit'] = $_POST['guestion_id'];
            header("Location: /diplom/public/admin/edit");
        }
        if (!empty($_POST['questionEditDell'])) {
            $questionIdDell = $_POST['guestion_id'];
            $sth = $db->prepare("DELETE FROM `questions` WHERE id=?");
            $sth->execute(array($questionIdDell));//Удаляем вопрос
            header("Location: /diplom/public/admin/select");
        }
        if (!empty($_POST['questionEditStatus'])) {
            $questionEditStatusId = $_POST['guestion_id'];
            if($_POST['guestion_status'] == '2') {
                $sth = $db->prepare("UPDATE `questions` SET `status`=3 WHERE id=?");
                $sth->execute(array($questionEditStatusId));
                header("Location: /diplom/public/admin/edit");
            }
            if($_POST['guestion_status'] == '3') {
                $sth = $db->prepare("UPDATE `questions` SET `status`=2 WHERE id=?");
                $sth->execute(array($questionEditStatusId));
                header("Location: /diplom/public/admin/edit");
            }
        }
        if (!empty($_POST['questionThemeEdit'])) {
            $questionEditStatusId = $_POST['guestion_id'];
            $themeEditId = $_POST['themeEdit'];
            $sth = $db->prepare("UPDATE `questions` SET `theme_id`='$themeEditId' WHERE id=?");
            $sth->execute(array($questionEditStatusId));
            header("Location: /diplom/public/admin/edit");
        }
        if(!empty($_POST['answerEdit'])){
            $id = $_POST['question_id'];
            $text = trim($_POST['text']);
            if(!empty($_POST['answer_id'])){
                $sth = $db->prepare("UPDATE `answers` SET `answer`='$text' WHERE question_id=?");
                $sth->execute(array($id));
                header("Location: /diplom/public/admin/edit");
            } else {
                $data = array($id, $_SESSION['id'], $text);
                $sth = $db->prepare("INSERT INTO `answers`(`question_id`, `admin_id`, `answer`) VALUES (?, ?, ?)");
                $sth->execute($data);
                $newAnswerId = $db->lastInsertId();
                $sth = $db->prepare("UPDATE `questions` SET `answer_id`='$newAnswerId' WHERE id=?");
                $sth->execute(array($id));
                header("Location: /diplom/public/admin/edit");
            }
        }
    }
} else {
    header("Location: /diplom/public/");
}
