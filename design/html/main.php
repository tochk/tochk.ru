<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?> - tochk.ru</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link href="/design/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon"/>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
</head>
<body>
<header>
    <div id="header_for_buttons">
        <div id="logo_name"><h1>TOCHK.RU</h1></div>
        <div id="buttons">
            <div id="button">Настройки</div>
            <div id="button">КОНТАКТЫ</div>
            <div id="button">НАШИ РАБОТЫ</div>
            <div id="button" style=" height: 41px; padding-top: 9px;">РАЗРАБОТКА САЙТОВ</div>
            <div id="button">БЛОГ</div>
            <div id="button">ГЛАВНАЯ</div>
        </div>
    </div>
</header>
<main>
    <div id="top_menu">
        <div id="header_top"></div>
    </div>
    <div id="left_menu">
        <div id="block_for_left">
            <div id="head_left_menu">User_name</div>
            <div id="info_left_menu" style="font-size:16px;">
                * - Любимые теги <br>
                * - Сохранненые статьи <br>
                * - Текущие заказы <br>
                * - Настройки <br>
            </div>
        </div>
        <div id="block_for_left">
            <div id="button_login_reg">SIGN IN</div>
            <form action="/login.php" method="post">
                <input id="field_log_reg" type="text" placeholder="Логин" name="login" size=28/>
                <input id="field_log_reg" type="password" placeholder="Пароль" name="password" size=28/>
                <input id="button_log" type="submit" style="font-size:15px;" value=" Войти "/>
            </form>
        </div>
        <div id="block_for_left">
            <div id="button_login_reg">SIGN UP</div>
            <form action="/login.php" method="post">
                <input id="field_log_reg" type="text" placeholder="Логин" name="login" size=28/>
                <input id="field_log_reg" type="text" placeholder="E-mail" name="email" size=28/>
                <input id="field_log_reg" type="password" placeholder="Пароль" name="password1" size=28/>
                <input id="field_log_reg" type="password" placeholder="Повторите пароль" name="password2" size=28/>
                <input id="button_reg" type="submit" style="font-size:15px;" value=" Зарегистрироваться "/>
            </form>
        </div>
        <div id="block_for_left">
            <div id="head_left_menu">TAGS</div>
            <div id="info_left_menu">PHP, LINUX, CSS, bla, bla, bla, bla, bla, bla, bla, bla, bla</div>
        </div>
        <div id="block_for_left">
            <div id="head_left_menu">НЕКИЙ БЛОК</div>
            <div id="info_left_menu" style="font-size:16px;">Текст Текст Текст Текст Текст Текст Текст Текст Текст Текст
                Текст Текст Текст Текст Текст Текст Текст Текст Текст Текст Текст Текст Текст Текст Текст Текст Текст
                Текст Текст Текст Текст Текст Текст
            </div>
        </div>
    </div>
    <div id="right_menu">
        <content>
            <?php echo $content; ?>
        </content>
    </div>
</main>
<footer>
    (c) lenok
</footer>
</body>
</html>