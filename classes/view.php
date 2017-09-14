<?

class view extends ACore
{
    public function get_content()
    {
        echo "<div id='main' class='col-md-7'>";
        if(!$_GET['id_text']) {
            echo "Неправильные данные для вывода статьи";
        }else{

            $id_text = (int)$_GET['id_text'];
            if(!$id_text) {
                echo "Неправильные данные для вывода статьи";
            }else{
                $query = "SELECT title, text, date, id, img_src FROM statti WHERE id='$id_text'";
                $result = mysql_query($query);
                if (!$result) {
                    exit(mysql_error());
                }
                $row = mysql_fetch_array($result, MYSQL_ASSOC);
                printf("<p>
                            <p style='font-size:18px'>%s</p>
                            <p>%s</p>
                            <p style='display: inline-block;'><img width='160px' align='left' style='margin-right:5px;' src='%s'>%s</p>
                        </p>", $row['title'], $row['date'], $row['img_src'], $row['text']);
            }
        }
        
        echo "    </div>
                </div>";
    }
};