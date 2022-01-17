<?php
function LoginVerification($name_page)
{
    session_start();
    
    if(empty($_SESSION['login']) && !empty($_COOKIE['login']))
        $_SESSION['login'] = $_COOKIE['login'];

    if(empty($_SESSION['login']))
    {
        header('Location: Login.php');
        exit();
    }

    // Последняя посещенная пользователем страница
    setcookie('last_page', $name_page, time() + 3600 * 24);
}
    
    LoginVerification('Page1.php');// Проверка входа
?>

<?php
    // Запись в текстовый файл
    function WriteToVisits($name_page)
    {
        $Visits = fopen('Visits.txt', 'a+');
        fwrite($Visits, $_SESSION['login'] . "\n");
        fwrite($Visits, date('d.m.o') . "\n");
        fwrite($Visits, date('G:i:s') . "\n");
        fwrite($Visits, $_SERVER['REMOTE_ADDR'] . "\n");
        fwrite($Visits, 'http://php7/' . $name_page . "\n");
        fwrite($Visits, $_SERVER['HTTP_REFERER'] . "\n");
        fwrite($Visits, $_SERVER['HTTP_USER_AGENT'] . "\n");
        fclose($Visits);
    }

    WriteToVisits('Page1.php');
?>

<html>
    <head>
        <title>
            Сайт №1
        </title>
        <link href="css/main.css" rel="stylesheet">
    </head>
    <body>
    <form action="index.php" method="post" class="topPanel">
            <a href="Home.php" class="titleSite">Dragon Age</a>
            <span class="subtitleSite">web Site № 1</span>
            <input type="submit" name="exit" value="Выход" class="defaultBtn floatRight">
        </form>
    </body>
</html>