<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Вход(Регистрация)</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
        <link rel="stylesheet" href="css/style.css"> <!-- Resource style -->
    </head>
    <body>
        <header>
            <h1>FAQ</h1>
        </header>
        <p>Введите данные для регистрации или войдите, если уже регистрировались:</p>

        <form method="POST" action="user">
            <input type="text" name="login" placeholder="Логин" />
            <input type="password" name="password" placeholder="Пароль" />
            <input type="submit" name="sign_in" value="Вход" />
            <input type="submit" name="register" value="Регистрация" />
        </form>
        <?php
        // put your code here
        ?>
    </body>
</html>