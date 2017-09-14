<?

class cabinet extends ACore
{
    public function obr()
    {
        if (!empty($_POST)) {
            $userID = $_SESSION['userID'];
            $new_login = trim($_POST['user_login']);
            $new_pswd = $_POST['user_pswd'] === '' ? '' : md5(trim($_POST['user_pswd']));
            if ($new_login !== '') {
                if ($new_pswd != '') {
                    $query = "UPDATE users SET login='$new_login' password='$new_pswd' WHERE u_id='$userID'";
                } else {
                    $query = "UPDATE users SET login='$new_login' WHERE u_id='$userID'";
                }
                if (!mysql_query($query)) {
                    exit(mysql_error());
                } else {
                    echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Обновление успешно!</strong>
                </div>';
                }
            } else {
                echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Ошибка!</strong> Логин не может быть пустым!
                </div>';
            }
        }
    }

    public function get_content()
    {
        echo '<div class="main col-md-9">';

        $userID = $_SESSION['userID'];
        if ($userID) {
            $query = "SELECT u_id, login, password FROM users WHERE u_id='$userID'";
            $result = mysql_query($query);
            if (!$result) {
                exit(mysql_error());
            }
            if (mysql_num_rows($result)) {
                $row = array();
                for ($i = 0; $i < mysql_num_rows($result); $i++) {
                    $arResult = mysql_fetch_array($result, MYSQL_ASSOC);
                    ?>
                    <form id="userProfile" method="post" class="user-card col-md-5">
                        <label for="user_login">Логин</label>
                        <input id="user_login" name="user_login" class="user-login form-control" type="text"
                               value="<?= $arResult['login'] ?>" disabled>
                        <label for="user_pswd">Пароль</label>
                        <input id="user_pswd" name="user_pswd" value="" class="user-pswd form-control" type="password"
                               disabled>
                        <button name="edit" class="edit">Редактировать</button>
                        <button name="save" class="save" type="submit" disabled>Сохранить</button>
                    </form>
                    <?
                }
            }

            $querySt = "SELECT right_q, errors, test_id, time_test FROM statistics WHERE u_id='$userID'";
            $resultSt = mysql_query($querySt);
            if (!$resultSt) {
                exit(mysql_error());
            }
            echo '<div class="col-md-7">
                    <h2 class="header-statistic">Статистика пользователя</h2>
                    <table class="table table-responsive table-bordered test-result test-statistics">';
            echo '<tr><th>Название теста</th><th>Правильных ответов</th><th>Ошибок</th><th>Затрачено времени</th></tr>';
            if (mysql_num_rows($resultSt)) {
                for ($i = 0; $i < mysql_num_rows($resultSt); $i++) {
                    $arResultSt = mysql_fetch_array($resultSt, MYSQL_ASSOC);
                    $test_id = $arResultSt['test_id'];
                    $queryTest = "SELECT test_id, test_name FROM tests WHERE test_id='$test_id'";
                    $resQuTest = mysql_query($queryTest);
                    for ($j = 0; $j < mysql_num_rows($resQuTest); $j++) {
                        $arTestName = mysql_fetch_array($resQuTest, MYSQL_ASSOC);
                        $quTestName = $arTestName['test_name'];
                    }
                    ?>
                    <tr>
                        <td><?= $quTestName ?></td>
                        <td><?= $arResultSt['right_q'] ?></td>
                        <td><?= $arResultSt['errors'] ?></td>
                        <td><?= $arResultSt['time_test']?> м.</td>
                    </tr>
                    <?
                }
                echo '</table></div>';
            }
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Ошибка!</strong> Невозможно загрузить профиль для неавторизованного поьзователя!
                </div>';
        }

    }
}