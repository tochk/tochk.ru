<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?> - tochk.ru</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link href="/design/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="/design/images/favicon/favicon.ico" rel="shortcut icon" type="image/x-icon"/>
    <!--script type="text/javascript" src="/engine/js/pjax-standalone.min.js"></script-->
    <!--script type='text/javascript'>pjax.connect();</script-->
</head>
<body>
<div id='topbar'>
    <p class='topbar2'>
        <a href='http://tochk.ru/'><img src='/design/images/toplogo.png'/></a>
    </p>
    <?php
    if (!isset($_SESSION['id']))
        echo "<form action='/login.php' method='post'>
Логин: <input type='text' name='login' />
Пароль:  <input type='password' name='password' />
<input type='submit' value=' Войти ' />
<a style='color: white;' href='/register/' data-pjax='content'>Регистрация</a> 
</form>";
    else {
        echo "<form action='/login.php?logout=1' method='post'>
Вы зашли как: $login.
<a style='color: white;' href='/user/files.php' data-pjax='content'>Файлы</a> 
<a style='color: white;' href='/user/gallery.php' data-pjax='content'>Скриншоты</a> ";
        if ($admin == 1) print "<a style='color: white;' href='/admin/' data-pjax='content'>Админка</a> ";
        echo "<input type='submit' value=' Выход ' />
</form>";
    }
    ?>
</div>
<div id="main">
    <div id="header">
        <a href="/" data-pjax='content'><img src="/design/images/logo.png"/></a>

        <div id="menu">
            <ul>
                <li><a href="/blog/" data-pjax='content'><img src="/design/images/menu/news.png"/></a></li>
                <li><a href="/projects/" data-pjax='content'><img src="/design/images/menu/projects.png"/></a></li>
                <li><a href="/portfolio/" data-pjax='content'><img src="/design/images/menu/services.png"/></a></li>
                <li><a href="/info/" data-pjax='content'><img src="/design/images/menu/sandbox.png"/></a></li>
            </ul>
        </div>
    </div>
    <div id="content">
        <?php echo $content; ?>
    </div>
    <center>
        <div id='footer'>
            <strong>
                <h5 style="margin: 0;">Обо всех найденных багах и уязвимостях вы можете сообщить через <a
                        href="/order/" data-pjax='content' data-title='Обратная связь' style="color: white;">обратную
                        связь</a><br/>
                    Исходный код проекта доступен на <a href="https://github.com/madot/tochk.ru" target="_blank"
                                                        style="color: white;">GitHub</a>.</h5>
                tochk.ru © 2013-2014
            </strong>
        </div>
    </center>
</div>
</body>
</html>