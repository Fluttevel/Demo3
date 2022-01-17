<?php
    session_start();

    // Если user нажал Выход => Очистить Cookies
    if(!empty($_POST['exit']))
    {
        setcookie('login', '', time() - 1);
        setcookie('last_page', '', time() - 1);
    }

    
    // При входе в index.php => Очистить сессию
    unset($_SESSION['login']);

    // Переопределить Авторизацию
    // Переход на последнюю посещенную страницу сайта
    // Если таковой нет, то перенаправлять на Главную
    if(!empty($_COOKIE['last_page']) && !empty($_COOKIE['login']))
    {
        header('Location: ' . $_COOKIE['last_page']);
        exit();
    }

    // Если пользователь ввёл логин и нажал войти
    if(!empty($_POST['signin']) && !empty($_POST['login']))
    {
        $_SESSION['login'] = $_POST['login'];
        if($_POST['remember'] == 'on')
            setcookie('login', $_POST['login'], time() + 3600 * 24);

        header('Location: Home.php');
        exit();
    }
    else
    {
        header('Location: Login.php');
        exit();
    }
?>