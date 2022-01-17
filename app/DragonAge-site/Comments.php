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
    
    LoginVerification('Comments.php');// Проверка входа
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

    WriteToVisits('Comments.php');
?>

<?php
    $idConnect = mysqli_connect('localhost', 'root', '', 'comments');

    mysqli_query($idConnect, "SET NAMES 'cp1251' COLLATE 'cp1251_general_cs'");

    if(!empty($_POST['userName']) && !empty($_POST['commentText']) && !empty($_POST['confirmComment']))
    {
        $user = trim($_POST['userName']);
        $comments = trim($_POST['commentText']);

        if($user != null && $comments != null)
        {
            $user = mysqli_real_escape_string($idConnect, $user);
            $comments = mysqli_real_escape_string($idConnect, $comments);
            $time = time() + 7 * 60 * 60;
            echo $user . "<br>";
            $today = date("H:i:s", $time);
            mysqli_query($idConnect, "INSERT INTO tablecomments (userName, comment) VALUES ('$user', '$comments')");
        }
    }

    function ShowComments($idConnect)
    {
        if (!empty($_POST['sorting-comment']))
        {
            switch($_POST['sorting-comment'])
            {
                case 'По номеру ID':
                    $allComments = mysqli_query($idConnect, "SELECT * FROM tablecomments ORDER BY commentID ASC");
                    $_POST['confirmComment'] = null;
                break;
                case 'Время (По возрастанию)': 
                    $allComments = mysqli_query($idConnect, "SELECT * FROM tablecomments ORDER BY dateTime ASC");
                    $_POST['confirmComment'] = null;
                break;
                case 'Время (По убыванию)': 
                    $allComments = mysqli_query($idConnect, "SELECT * FROM tablecomments ORDER BY dateTime DESC");
                    $_POST['confirmComment'] = null;
                break;
            }
        }
        else
            $allComments = mysqli_query($idConnect, "SELECT * FROM tablecomments");

        while($rowTable = mysqli_fetch_assoc($allComments))
        {
            echo "<div class=\"commentUser\">";
            echo "<h1 class=\"commentText\">#" . $rowTable['commentID'] . " " . $rowTable['userName'] . "</h1>";
            echo $rowTable['comment'] . "<br><br>";
            echo $rowTable['dateTime'];
            echo "</div>";
        }
    }
?>

<html>
    <head>
        <title>
            Комментарии
        </title>
        <link href="css/main.css" rel="stylesheet">
    </head>
    <body>
        <form action="index.php" method="post" class="topPanel">
            <a href="Home.php" class="titleSite">Dragon Age</a>
            <span class="subtitleSite">Comments</span>
            <input type="submit" name="exit" value="Выход" class="defaultBtn floatRight">
        </form>
        <form action="" method="post">
            <div class="commentLeftPanel">
                <img src="img/user.png" class="commentImg"><br>
                <h1 class="commentText">Имя пользователя</h1>
                <input type="text" name="userName" class="commentInput"><br>
                <input type="submit" name="confirmComment" value="Отправить" class="defaultBtn">
            </div>
            <textarea rows="14" cols="90" maxlength="500" name="commentText" placeholder="Введите свой комментарий" class="commentTextarea"></textarea><br>
        </form>
        <hr>
        <form action="Comments.php" method="post" class="commentSorting">
            <input type="submit" name="sorting-comment" value="По номеру ID" class="defaultBtn width-400">
            <input type="submit" name="sorting-comment" value="Время (По возрастанию)" class="defaultBtn width-400">
            <input type="submit" name="sorting-comment" value="Время (По убыванию)" class="defaultBtn width-400">
        </form>

        <?php ShowComments($idConnect); ?>
    </body>
</html>