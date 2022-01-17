<html>
    <head>
        <title>
            Вход
        </title>
        <link href="css/main.css" rel="stylesheet">
    </head>
    <body>
        <div>
            <form class="loginBorder" action="index.php" method="post">
                <span class="titleSite">Dragon Age</span><br>
                <h1 class="subtitleSite">Вход</h1>
                <input type="text" name="login" placeholder="Логин, телефон или адрес эл. почты" class="loginInput">
                <div class="">
                    <input type="checkbox" name="remember" id="checkBox">
                    <label for="checkBox">ЗАПОМНИТЬ МЕНЯ</label>
                </div>
                <div class="">
                    <!--<a href="CreateAccount.php">Создать аккаунт</a>-->
                    <input type="submit" name="signin" value="Войти" class="defaultBtn">
                </div>
            </form>
        </div>
    </body>
</html>