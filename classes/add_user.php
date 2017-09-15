<?php

class add_user extends ACore_Admin
{
    public function obr()
    {
        $password = md5($_POST['user_password']);
        $login = $_POST['user_login'];
        $right = $_POST['user_rights'] === 'Y'? 'A' : 'U';

        if (!$password) {
            echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Ошибка!</strong> Заполните поле "Пароль"
                </div>';
        }

        if (!$login) {
            echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Ошибка!</strong> Заполните поле "Логин"
                </div>';
        } else {
            if ($this->try_user_name($login)){
                $queryTest = "INSERT INTO users
                    (login, password, rights)
                  VALUES ('$login', '$password', '$right')";
                if (!mysql_query($queryTest)) {
                    exit(mysql_error());
                } else {
                    echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Новый пользователь добавлен!</strong>
                </div>';
                }
            } else{
                echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Ошибка!</strong> Пользователь с таким логином уже существует.
                </div>';
            }
        }

    }

    public function get_content()
    {
        echo '<div id="main" class="main col-md-9">';
        if ($_SESSION['res']) {
            echo($_SESSION['res']);
            unset($_SESSION['res']);
        }
        print <<<HEREDOC
<form id="userAdd" method="post" class="user-add col-md-7">
                        <label for="user_login">Логин</label>
                        <input id="user_login" name="user_login" class="user-login form-control" type="text"
                               value="">
                        <label for="user_pswd">Пароль</label>
                        <input id="user_pswd" name="user_pswd" value="" class="user-pswd form-control" type="password">
                        <label for="user_rights">Админ</label>
                        <input id="user_rights" name="user_rights" value="Y" class="user-rights" type="checkbox">
                        <br>
                        <button name="save" class="save" type="submit">Сохранить</button>
                    </form>
            </div></div>
HEREDOC;
    }
}