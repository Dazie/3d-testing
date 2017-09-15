<?

class statistics extends ACore_Admin
{
    public function get_content()
    {
        echo '<div class="main col-md-9">';

        $querySt = "SELECT u_id, right_q, errors, test_id, time_test FROM statistics";
        $resultSt = mysql_query($querySt);
        if (!$resultSt) {
            exit(mysql_error());
        }
        echo '<div class="col-md-12">
                    <h2 class="header-statistic">Статистика пользователей</h2>
                    <table class="table table-responsive table-bordered test-result test-statistics">';
        echo '<tr><th>Название теста</th><th>Пользователь</th><th>Правильных ответов</th><th>Ошибок</th><th>Затрачено времени</th></tr>';
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

                $userID = $arResultSt['u_id'];
                $queryUser = "SELECT u_id, login FROM users WHERE u_id='$userID'";
                $resUTest = mysql_query($queryUser);
                for ($j = 0; $j < mysql_num_rows($resUTest); $j++) {

                    $arULogin = mysql_fetch_array($resUTest, MYSQL_ASSOC);
                    $userLogin = $arULogin['login'];
                }
                ?>
                <tr>
                    <td><?= $quTestName ?></td>
                    <td><?= $userLogin ?></td>
                    <td><?= $arResultSt['right_q'] ?></td>
                    <td><?= $arResultSt['errors'] ?></td>
                    <td><?= $arResultSt['time_test'] ?> м.</td>
                </tr>
                <?
            }
            echo '</table></div>';
        }
    }
}