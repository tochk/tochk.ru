<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <link href="/design/css/style.css" rel="stylesheet" type="text/css"/>
    <script src="/engine/js/login_register.js" async="async"></script>
    <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon"/>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
</head>
<body>
<header>
    <div id="header_for_buttons">
        <div id="logo_name" onclick="window.location.href='/'"><h1>TOCHK.RU</h1></div>
        <div id="buttons">
            <?php if($user->isAdmin == 1) { ?>
            <div id="button" onclick="window.location.href='/admin/'">АДМИНКА</div> <?php } ?>
            <div id="button" onclick="window.location.href='/projects/'">ПРОЕКТЫ</div>
            <div id="button" onclick="window.location.href='/portfolio/'">НАШИ РАБОТЫ</div>
            <div id="button" onclick="window.location.href='/info/'" style=" height: 41px; padding-top: 9px;">РАЗРАБОТКА САЙТОВ</div>
            <div id="button" onclick="window.location.href='/blog/'">СТАТЬИ</div>
            <div id="button" onclick="window.location.href='/'">ГЛАВНАЯ</div>
        </div>
    </div>
</header>
<main>
    <div id="top_menu">
            <div id="header_top"></div>
    </div>
    <div id="left_menu">
        <?php if (isset($_SESSION['id'])) { ?>
        <div id="block_for_left">
            <div id="head_left_menu"><?php echo $user->login; ?></div>
            <div id="info_left_menu" style="font-size:16px;">
                * - Любимые теги <br>
                * - Сохранненые статьи <br>
                * - Текущие заказы <br>
                * - Настройки <br>
            </div>
        </div> <?php } else { ?>
        <div id="block_for_left" class="login">
            <div id="button_login_reg">SIGN IN</div>
            <form action="/login.php" method="post">
                <input id="field_log_reg" type="text" placeholder="Логин" name="login" size=28/>
                <input id="field_log_reg" type="password" placeholder="Пароль" name="password" size=28/>
                <div id="new_text"><a href="javascript:void(0)">Забыл пароль</a> | <a href="javascript:void(0)" onclick="loginRegister();">Регистрация</a></div>
                <input id="button_log" type="submit" style="font-size:15px;" value=" Войти "/>
            </form>

        </div>
        <div id="block_for_left" class="register" style="display: none">
            <div id="button_login_reg">SIGN UP</div>
            <form action="/register/query.php" method="post">
                <input id="field_log_reg" type="text" placeholder="Логин" name="login" size=28/>
                <input id="field_log_reg" type="text" placeholder="E-mail" name="email" size=28/>
                <input id="field_log_reg" type="password" placeholder="Пароль" name="password" size=28/>
                <input id="field_log_reg" type="password" placeholder="Повторите пароль" name="password2" size=28/>
                <div id="new_text"><a href="javascript:void(0)" >Забыл пароль</a> | <a href="javascript:void(0)" onclick="loginRegister();">Вход</a></div>
                <input id="button_reg" type="submit" style="font-size:15px;" value=" Зарегистрироваться "/>
            </form>

        </div>
        <?php } ?>
        <div id="block_for_left">
            <div id="head_left_menu">TAGS</div>
            <div id="info_left_menu"><?php echo getPostTags($mysql); ?></div>
        </div>
    </div>
    <div id="right_menu">
        <content>
            <?php echo $content; ?>
        </content>
    </div>
</main>
<footer>
    powered on tochk.ru<br>
    design by lenokh
</footer>
</body>
</html>