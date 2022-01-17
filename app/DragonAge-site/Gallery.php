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
    
    LoginVerification('Gallery.php');// Проверка входа
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

    WriteToVisits('Gallery.php');
?>

<?php
    function AddPicture($picture)
    {
        if($picture['name'] == null || $picture['size'] == 0)
        {
            return false;
        }

        if(CheckPictureType($picture['type']))
        {
            srand();
            $namePicture = date('dmogis') . rand(10, 99);
            $namePicture = md5($namePicture) . rand(10, 99) . '.jpg';
            rename($picture['tmp_name'], 'img original/' . $namePicture);
            
            ResizedPicture('img original/' . $namePicture, 'img small/' . $namePicture, 300, $picture['type']);
        }
    }

    function CheckPictureType($pictureType)
    {
        switch($pictureType)
        {
            case 'image/gif':
            case 'image/png':
            case 'image/jpg':
            case 'image/jpeg': return true; break;
            default: return false; break;
        }
    }

    function ResizedPicture($oldPath, $newPath, $newSize, $pictureType)
    {
        list($width, $height) = getimagesize($oldPath);
        $newHeight = $height * $newSize;
        $newWidth = $newHeight / $width;
        $thumb = imagecreatetruecolor($newSize, $newWidth);
        // imagejpeg($thumb, "$newPath", "100");
        switch($pictureType)
        {
            case 'image/gif': 
                $source = imagecreatefromgif($oldPath);
                imagecopyresized($thumb, $source, 0, 0, 0, 0, $newSize, $newWidth, $width, $height);        
                imagegif($thumb, "$newPath", "100");
            break;
            case 'image/png':
                $source = imagecreatefrompng($oldPath);
                imagecopyresized($thumb, $source, 0, 0, 0, 0, $newSize, $newWidth, $width, $height);
                imagepng($thumb, "$newPath", "9"); 
            break;
            case 'image/jpg':
            case 'image/jpeg': 
                $source = imagecreatefromjpeg($oldPath);
                imagecopyresized($thumb, $source, 0, 0, 0, 0, $newSize, $newWidth, $width, $height);
                imagejpeg($thumb, "$newPath", "100"); 
            break;
        }
    }

    function ShowGallery($directory)
    {
        $pictures = scandir($directory); // Массив имен изображений
        
        for ($i = 0; $i < count($pictures); $i++)
            if ($pictures[$i] != "." && $pictures[$i] != "..")
                echo "<a rel=\"gallery\" href=\"img original/$pictures[$i]\" class=\"picture\">
                        <img class=\"imgLink\" src=\"$directory/$pictures[$i]\">
                    </a>";
    }
?>

<?php
    if(!empty($_POST['upload_confirm']))
    {
        AddPicture($_FILES['picture']);
        $_POST['upload_confirm'] = null;
    }
?>

<html>
    <head>
        <title>
            Галерея
        </title>
        <link rel="stylesheet" href="/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
        <link href="css/main.css" rel="stylesheet">
        <link href="css/gallery.css" rel="stylesheet">
    </head>
    <body>
        <form action="Gallery.php" method="post" enctype="multipart/form-data" class="topPanel">
            <a href="Home.php" class="titleSite">Dragon Age</a>
            <span class="subtitleSite">Gallery</span>
            <input type="submit" name="upload_confirm" value="Загрузить файл" class="defaultBtn floatRight">
            <input type="file" name="picture" accept="image/*" class="addPanel floatRight">
        </form>

        <?php ShowGallery("img small"); ?>
        
        <!-- Scripts -->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
        <script type="text/javascript" src="/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
        <script type="text/javascript" src="/fancybox/jquery.easing-1.4.pack.js"></script>
        <script type="text/javascript" src="/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
        <script>
            $(document).ready(function(){
                $("a.picture").fancybox();
            });
        </script>
    </body>
</html>