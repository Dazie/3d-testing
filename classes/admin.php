<?php

class admin extends ACore_Admin
{

    public function get_content()
    {
        $query = "SELECT id, title FROM statti";
        $result = mysql_query($query);

        echo '<div id="main">';

        if (!$result) {
            mysql_error();
        }
        $row = array();

        echo "<a style='color:red' href='?option=add_statti'>Добавить новую статью</a><hr>";

        for ($i = 0; $i < mysql_num_rows($result); $i++) {
            $row = mysql_fetch_array($result, MYSQL_ASSOC);
            printf("<p style='font-size:14px; text-align: left;'>
                        <a style='color:#585858;' href='?option=update_statti&id_text=%s'>%s
                        </a>
                        <a style='color: #560001; text-align: right; float: right;' href='?option=delete_statti&id_text=%s'>Удалить</a>
                        </p>",
                $row['id'], $row['title'], $row['id']);
        }

        echo "</div></div>";
    }
}