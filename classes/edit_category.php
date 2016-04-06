<?php

class edit_category extends ACore_Admin
{
    public function get_content(){
        $query = "SELECT id_category, name_category FROM category";
        $result = mysql_query($query);

        echo '<div id="main">';

        if (!$result) {
            mysql_error();
        }
        $row = array();

        echo "<a style='color:red' href='?option=add_category'>Добавить новую категорию</a><hr>";
        if ($_SESSION['res']) {
            echo($_SESSION['res']);
            unset($_SESSION['res']);
        }

        for ($i = 0; $i < mysql_num_rows($result); $i++) {
            $row = mysql_fetch_array($result, MYSQL_ASSOC);
            printf("<div style='font-size:14px; text-align: left; margin: 1em 0; position: relative;'>
                        <a style='color:#585858;' href='?option=update_category&id_text=%s'>%s
                        </a>", $row['id_category'], $row['name_category']);

            $use=$this->try_category_use($row['id_category']);
            if(!$use) {
                printf("<a style='color: #560001; text-align: right; float: right;' href='?option=delete_category&del=%s'>Удалить</a></div>
                        ", $row['id_category']);
            }else{
                printf("<a class='unactive'>Удалить</a>
                        <div class='unactive_info'>Невозможно удалить статью, так как она используется в статьях: %s</div></div>", $use['title']);
            }
        }
        echo "</div></div>";
    }
}