<?php

class edit_tests extends ACore_Admin
{
    public function get_content()
    {
        $query = "SELECT test_id, test_name, test_descr FROM tests";
        $result = mysql_query($query);

        echo '<div id="main" class="col-md-9">';

        if (!$result) {
            mysql_error();
        }

        $arTests = [];

        for ($i = 0; $i < mysql_num_rows($result); $i++) {
            $arTests [] = mysql_fetch_array($result, MYSQL_ASSOC);
        }

        echo "<a class='add-button' href='?option=add_test'>Создать новый тест</a>";
        if ($_SESSION['res']) {
            echo($_SESSION['res']);
            unset($_SESSION['res']);
        }
        if (!empty($arTests)) {
            echo '<div class="tests_list"><ul>';
            foreach ($arTests as $arTestItem) {
                echo '<li><span class="test_name">' . $arTestItem['test_name'] . '</span>';
                if (!empty($arTestItem['test_descr'])) {
                    echo ' - <span>' . $arTestItem['test_descr'] . '</span></li>';
                } else {
                    echo '</li>';
                };
            }
            echo '</ul></div>';
        }

        /*for ($i = 0; $i < mysql_num_rows($result); $i++) {
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
        }*/
        echo "</div>";
    }
}