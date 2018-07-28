# Диплом по курсу php-20.
#Установка
1. Загружаем файлы проекта с github
git clone https://github.com/AlekseyAbramov/diplom diplom
2. С помощью Composer устанавливаем необходимые библиотеки (autoloader, symfony/yaml и Twig)
cd diplom
composer install
3. Дамп базы данных находится в файле diplom.sql (заведен администратор логин-admin, пароль-admin)
4. Для работы приложения необходим веб сервер apache (используется файл .htaccess). Файл .htaccess 
   необходимо положить в корневой каталог сервера.
5. Основной файл для запуска index.php находится в каталоге public
6. Пример файла с настройками /app/config_demo.yml. Изменяем название на config.yml и 
   изменяем параметры подключения к базе данных на свои(раздел database) и название сервера(раздел server).
