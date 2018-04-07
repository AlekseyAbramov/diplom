<!DOCTYPE html>
<html>
    <head>
        <title>Главная</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/reset.css"> <!-- CSS reset -->
        <link rel="stylesheet" href="css/style.css"> <!-- Resource style -->
        <script src="js/modernizr.js"></script> <!-- Modernizr -->
    </head>
    <body>
        <header>
            <h1>FAQ</h1>
        </header>
        <a href="user">Войти(Зарегистрироваться)</a>
        <a href="question/add">Задать вопрос</a>
        <section class="cd-faq">
            <ul class="cd-faq-categories">
                <?php include dirname(__DIR__). DIRECTORY_SEPARATOR. 'views'. DIRECTORY_SEPARATOR. 'menu_view.php'; ?>
            </ul>
            
            <div class="cd-faq-items">
                <?php include dirname(__DIR__). DIRECTORY_SEPARATOR. 'views'. DIRECTORY_SEPARATOR. $content_view; ?>
            </div>
        </section>
        <script src="js/jquery-2.1.1.js"></script>
        <script src="js/jquery.mobile.custom.min.js"></script>
        <script src="js/main.js"></script> <!-- Resource jQuery -->
    </body>
</html>
