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
    
    LoginVerification('Home.php');// Проверка входа
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

    WriteToVisits('Home.php');
?>

<html>
    <head>
        <title>
            Главная
        </title>
        <link href="css/main.css" rel="stylesheet">
    </head>
    <body>
        <form action="index.php" method="post" class="topPanel">
            <a href="" class="titleSite">Dragon Age</a>
            <span class="subtitleSite">home</span>
            <input type="submit" name="exit" value="Выход" class="defaultBtn floatRight">
            <span class="subtitleSite floatRight"><?php echo $_SESSION['login']; ?></span>
            
        </form>
        <div class="homeBorder">
            <a href="Visits.php" class="homeLink">
                <p class="subtitleSite">Посмотреть статистику</p>
                <img class="homeImg" src="img/Statistics.png">
            </a>
            <a href="Page1.php" class="homeLink">
                <p class="subtitleSite">Перейти на сайт №1</p>
                <img class="homeImg" src="img/WebSite1.jpg">
            </a>
            <a href="Page2.php" class="homeLink">
                <p class="subtitleSite">Перейти на сайт №2</p>
                <img class="homeImg" src="img/WebSite2.jpg">
            </a>
            <a href="Gallery.php" class="homeLink">
                <p class="subtitleSite">Перейти в галерею</p>
                <img class="homeImg" src="img/Gallery.jpg">
            </a>
            <a href="Comments.php" class="homeLink">
                <p class="subtitleSite">Перейти в комментарии</p>
                <img class="homeImg" src="img/Comments.png">
            </a>
        </div>
    </body>
</html>