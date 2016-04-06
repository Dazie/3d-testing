<?php

class edit_menu extends ACore_Admin
{
    public function get_content(){
        $query = "SELECT id_menu, name_menu FROM menu";
        $result = mysql_query($query);

        echo '<div id="main">';

        if (!$result) {
            mysql_error();
        }
        $row = array();

        echo "<a style='color:red' href='?option=add_menu'>Добавить новый пункт меню</a><hr>";
        if ($_SESSION['res']) {
            echo($_SESSION['res']);
            unset($_SESSION['res']);
        }

        for ($i = 0; $i < mysql_num_rows($result); $i++) {
            $row = mysql_fetch_array($result, MYSQL_ASSOC);
            printf("<p style='font-size:14px; text-align: left;'>
                        <a style='color:#585858;' href='?option=update_menu&id_text=%s'>%s
                        </a>
                        <a style='color: #560001; text-align: right; float: right;' href='?option=delete_menu&del=%s'>Удалить</a>
                        </p>",
                $row['id_menu'], $row['name_menu'], $row['id_menu']);
        }

        echo "</div></div>";
    }
}