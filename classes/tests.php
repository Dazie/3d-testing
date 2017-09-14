<?

class tests extends ACore
{
    public function get_content()
    {
        echo '<div class="main col-md-9">';

        $query = "SELECT test_id, test_name, test_descr FROM tests ORDER BY test_id ASC";
        $result = mysql_query($query);
        if (!$result) {
            exit(mysql_error());
        }
        if (mysql_num_rows($result)) {
            $row = array();
            for ($i = 0; $i < mysql_num_rows($result); $i++) {
                $row = mysql_fetch_array($result, MYSQL_ASSOC);
                printf("<div class='test-block'>
<p class='test-go col-md-2'><a href='?option=test&id_test=%s'>Пройти</a></p>
                        <p class='col-md-10 test-name'>Название теста: %s</p>
                        <p class='col-md-10 test-desc'>%s</p>
                        <div class='clearfix'></div>
                    </div>
                    ", $row['test_id'], $row['test_name'], $row['test_descr']);
            }
            echo "</div></div>";
        }
    }
}