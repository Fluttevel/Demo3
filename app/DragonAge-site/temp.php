<?php
    function Login($username, $remember)
    {
        // имя не должно быть пустым строкой
        if ($ username == '')
            return false;
        
        // запоминаем имя в сессии ...
        $ _SESSION ['username'] = $username;
        
        // и в cookies, Если пользователь пожелал запомнить его (в неделю)
        if ($remember)
            setcookie ( 'username', $username, time() + 3600 * 24 * 7)
        // успешная авторизация
        return true;
    }

    // функция сброса авторизации
    function Logout()
    {
        // делаем cookies устаревшими (единственный способ их удаления)
        setcookie('username',' ', time() - 1);
        // сброс сессии
        unset($ _SESSION ['username']);
    }
?>

<?php
    // точка входа
    session_start();
    $enter_site = false;
    // попадая на страницу login.php, авторизация сбрасывается
    Logout();
    // если массив POST НЕ пуст, Значит, обрабатываем отправки формы
    if (count($ _POST)> 0)
        $enter_site = Login($ _POST [ 'username'], $ _POST [ 'remember'] =='on');
    // если авторизация пройдена, переадресуем пользователя
    // на одну из страниц сайта.
    if ($enter_site)
    {
        header( "Location: a.php");
        exit();
    }
?>

<?php
    // точка входа
    session_start ();
    // ясли в контексте сессии не установлено имя пользователя, то
    // пытаемся взять его с cookies.
    if (!isset($ _SESSION ['username']) && isset($ _COOKIE ['username']))
        $ _SESSION ['username'] = $ _COOKIE ['username'];
    // еще раз ищем имя пользователя в контексте сессии
    $username = $ _SESSION ['username'];
    // неавторизованного пользователей отправляем на страницу регистрации
    if($username == null)
    {
        header( "Location: login.php");
        exit();
    }
?>