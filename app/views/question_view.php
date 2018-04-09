<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Задать вопрос</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
        <link rel="stylesheet" href="css/style.css"> <!-- Resource style -->
    </head>
    <body>
        <header>
            <h1>FAQ</h1>
        </header>
        <form method="POST">
            <input type="text" name="name" placeholder="Имя" />
            <input type="text" name="email" placeholder="e-mail" />
            <label for="theme">Тема вопроса</label>
            <select name="sort_by">
               <option value="date_added">Дате добавления</option>
                <option value="is_done">Статусу</option>
                <option value="description">Описанию</option>
            </select>
            <input type="submit" name="theme" value="Отправить" />
        </form>
        <?php
        // put your code here
        ?>
    </body>
</html>
