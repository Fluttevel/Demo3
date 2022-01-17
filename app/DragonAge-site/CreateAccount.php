<html>
    <head>
        <title>
            Создание аккаунта
        </title>
        
        <link href="css/login.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
    </head>
    <body>
        <div>
            <form action="index.php" method="post">
                <img src="img/">
                <h1>Создайте аккаунт</h1>
                <div class="">
                    <input type="text" name="user_firstname" placeholder="Имя">
                    <input type="text" name="user_lastname" placeholder="Фамилия">
                </div>
                <div class="">
                    <input type="text" name="user_login" placeholder="Логин" id="Login">
                </div>
                <span>Можно использовать буквы латинского алфавита, цифры и точки.</span>

                <div class="">
                    <input type="password" name="password" placeholder="Пароль">
                    <input type="password" name="confirm_password" placeholder="Подтвердить">
                    <input type="checkbox" name="show_password">
                </div>
                <span>Пароль должен содержать не менее восьми знаков, включать буквы, цифры и специальные символы</span>
                
                <div class="">
                    <a href="Login.php">Войти</a>
                    <input type="submit" name="confirm_next" value="Далее">
                </div>
            </form>
        </div>
    </body>
</html>