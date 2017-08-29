<?php

class login extends ACore
{
    protected function obr()
    {

        $login = strip_tags(mysql_real_escape_string($_POST['login']));
        $password = strip_tags(mysql_real_escape_string($_POST['password']));
        if (!empty($login) && !empty($password)) {
            $password = md5($password);

            $query = "SELECT u_id FROM users WHERE login='$login' AND password='$password'";
            $result = mysql_query($query);
            if (!$result) {
                exit(mysql_error());
            }
            if (mysql_num_rows($result) == 1) {
                $_SESSION['user'] = true;
                header("Location:?option=admin");
                exit();
            } else {
                echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Ошибка!</strong> Пользователя с данной парой логин/пароль не существует!
                </div>';
            }
        } else {
            echo '<div class="alert alert-warning alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Внимание!</strong> Заполните все поля!
                </div>';
        }
    }

    public function get_content()
    {
        echo '<head>
                <title>Авторизация</title>
                <link href="plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
                <link href="style/style_login.css" rel="stylesheet" type="text/css" />
                <script type="text/javascript" src="plugins/jquery-3.2.1.min.js"></script>
                <script type="text/javascript" src="plugins/bootstrap/js/bootstrap.js"></script>
                <script type="text/javascript" src="plugins/parallax/jquery.fallings.js"></script>
            </head>';

        echo '<div class="main">';
        print <<<HEREDOC
            <form class="login form-horizontal" action="" method="post">
                <div class = "form-group">
                    <label for="sign-login" class="col-md-3 control-label">Ваш логин:</label>
                    <div class = "col-md-9">
                        <input id="sign-login" type="text" name="login" class="form-control">
                    </div>
                </div>
                <div class = "form-group">
                    <label for="sign-password" class="col-md-3 control-label">Ваш пароль:</label>
                    <div class = "col-md-9">
                        <input id="sign-password" type="password" name="password" class="form-control">
                    </div>
                </div>
                <br>
                <input class="btn btn-primary btn-lg active" type="submit" name="button" value="Войти">
            </form>
HEREDOC;
        echo "</div></div>";
    }
}