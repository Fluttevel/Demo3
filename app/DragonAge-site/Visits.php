<?php
    $ArrVisits = file('Visits.txt');

    if(!empty($_POST['clean_visits']))
    {
        $tempfile = fopen('Visits.txt', 'w');
        fclose($tempfile);
        $ArrVisits = null;
        $_POST['clean_visits'] = null;
    }
?>

<html>
    <head>
        <title>
            Посещения
        </title>
        <link href="css/main.css" rel="stylesheet">
    </head>
    <body>
        <form action="Visits.php" method="post" class="topPanel">
            <a href="Home.php" class="titleSite">Dragon Age</a>
            <span class="subtitleSite">Attendance log</span>
            <input type="submit" name="clean_visits" value="Очистить журнал" class="defaultBtn floatRight"><br>
        </form>
        
        <table class="tableVisits">
            <?php
                // Верхушка таблицы
                if($ArrVisits != null)
                {
                    echo "<tr>
                            <td>Имя пользователя</td>
                            <td>Дата</td>
                            <td>Время</td>
                            <td>IP-адрес</td>
                            <td>Адрес сайта</td>
                            <td>С какого адреса перешел</td>
                            <td>Браузер</td>
                        </tr>";
                }
                else
                    echo "Журнал посещений пуст!<br>";

                $size = count($ArrVisits);
                for($i = 0; $i < $size; $i += 7)
                {
                    echo '<tr>';
                    echo "<td>{$ArrVisits[$i + 0]}</td>
                          <td>{$ArrVisits[$i + 1]}</td>
                          <td>{$ArrVisits[$i + 2]}</td>
                          <td>{$ArrVisits[$i + 3]}</td>
                          <td>{$ArrVisits[$i + 4]}</td>
                          <td>{$ArrVisits[$i + 5]}</td>
                          <td>{$ArrVisits[$i + 6]}</td>";
                    echo '</tr>';
                }
            ?>
        </table>
    </body>
</html>