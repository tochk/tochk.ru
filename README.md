tochk.ru
=======

Используемые библиотеки:<br />
PJAX standalone : https://github.com/thybag/PJAX-Standalone<br />
pChart v 1.27d : http://pchart.sourceforge.net/<br />
reCAPTCHA : https://developers.google.com/recaptcha/<br />

Для того, чтобы сделать пользователя администратором необходимо поменять в таблице `users` значение колонки `admin` с `0` на `1`

Базы данных:<br />

 - https://github.com/madot/tochk.ru/blob/master/docs/db/main.sql
 - https://github.com/madot/tochk.ru/blob/master/docs/db/files.sql
 - https://github.com/madot/tochk.ru/blob/master/docs/db/logs.sql
 - https://github.com/madot/tochk.ru/blob/master/docs/db/screenshots.sql
 
<br />
Дизайн можно изменить в файле `/design/html/main.php`

<br />
Для корректной работы регистрации в файлы `/register/index.php : 30` и `/register/query.php : 13` нужно подставить свои значения публичного и приватного ключей для reCaptcha.

Для корректной работы необходимо в файл `/engine/mysql_connect.php` ввести свой логин и пароль от СУБД.

<br />
Необходимо запретить доступ к директориям с пользовательскими файлами: /upload/<br />
Файлхостинг будет работать корректно при нахождении файлов в папке `C:/Program Files (x86)/Apache Software Foundation/Apache2.2/htdocs/`<br />

Чтобы создать новую страницу нужно вставить в файл код:

    <?php
    session_start();
    $title = "Главная"; //название страницы
    include ('./engine/timer_init.php');
    include ('./engine/mysql_connect.php');
    include ('./engine/mysql_main_query.php');
    include ('./engine/history.php');
    
    $content = "content"; //содержимое страницы
    
    include ('./engine/main_stat.php');
    if(isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == 'true')
    {
        echo $content;
        echo "<title>$title - tochk.ru</title>";
    }
    else
    {
    	include ('./design/html/main.php');
    }
    ?>

http://tochk.ru/