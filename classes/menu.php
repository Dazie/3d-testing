<?

class menu extends ACore
{
    public function get_content()
    {
        echo '<div id="main">';
        if (!$_GET['id_menu']) {
            echo "Неправильные данные для вывода статьи";
        } else {
            $id_menu = (int)$_GET['id_menu'];
            if (!$id_menu) {
                echo "Неправильные данные для вывода статьи";
            } else {
                $query = "SELECT id_menu, name_menu, text_menu FROM menu WHERE id_menu='$id_menu' ORDER BY date DESC";
                $result = mysql_query($query);
                if (!$result) {
                    exit(mysql_error());
                }
                if (mysql_num_rows($result)) {
                    $row = array();
                    for ($i = 0; $i < mysql_num_rows($result); $i++) {
                        $row = mysql_fetch_array($result, MYSQL_ASSOC);
                        printf("<div style='margin:10px; border-bottom:2px solid #c2c2c2; text-align:left;'>
                        <p style='font-size:18px'>%s</p>
                        <p style='display: inline-block;'>%s</p>
                        <p style='color:red; text-align: right;'><a href='?option=view&id_text=%s'>Читать далее...</a></p>
                    </div>
                    ", $row['title'], $row['description'], $row['id']);
                    }
                } else {
                    echo "В данной категории нет статей";
                }
            }
        }
        echo "</div></div>";
    }
}

;