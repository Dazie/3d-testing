<?php

class admin extends ACore_Admin
{

    public function get_content()
    {
        $userID=$_SESSION['userID'];
        $query = "SELECT u_id, rights FROM users WHERE u_id='$userID'";
        $result = mysql_query($query);
        if (!$result) {
            exit(mysql_error());
        }
        if (mysql_num_rows($result) == 1) {
            if(mysql_fetch_array($result, MYSQL_ASSOC)['rights'] === 'U'){
                echo '<div class="alert alert-danger alert-dismissible fade in col-md-8" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Ошибка!</strong> Отказано в доступе!
                </div>';
                exit();
            }
        }
        $query = "SELECT id, title FROM statti";
        $result = mysql_query($query);

        echo '<div id="main">';

        if (!$result) {
            mysql_error();
        }
        $row = array();

        echo "<a class='add-cat' href='?option=add_statti'>Добавить новую статью</a><hr>";
        if ($_SESSION['res']) {
            echo($_SESSION['res']);
            unset($_SESSION['res']);
        }

        for ($i = 0; $i < mysql_num_rows($result); $i++) {
            $row = mysql_fetch_array($result, MYSQL_ASSOC);
            printf("<div class='add-cat-block'><p style='font-size:14px; text-align: left;'>
                        <a  href='?option=update_statti&id_text=%s'>%s
                        </a>
                        <a class='del' href='?option=delete_statti&del=%s'>Удалить</a>
                        </p></div>",
                $row['id'], $row['title'], $row['id']);
        }

        echo "</div></div>";
    }
}