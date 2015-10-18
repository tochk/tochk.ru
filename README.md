tochk.ru
=======


Для того, чтобы сделать пользователя администратором необходимо поменять в таблице `users` значение колонки `admin` с `0` на `1`

<br />
Дизайн можно изменить в файле `/design/html/main.php`



Чтобы создать новую страницу нужно вставить в файл код:

    <?php
    session_start();
    $title = "Главная"; //Заголовок страницы
    require($_SERVER['DOCUMENT_ROOT'] . '/config.php');
    function __autoload($class_name)
    {
        include $_SERVER['DOCUMENT_ROOT'] . '/engine/classes/' . $class_name . '.php';
    }

    $main = new page_init();
    $main->std_page_init();

    $content = ""; //Содержимое страницы

    $main->timer_save();
    $main->pjax_init($content, $_SERVER['DOCUMENT_ROOT'] . '/design/html/main.php', $title);

http://tochk.ru/