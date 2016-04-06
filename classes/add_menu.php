<?php

class add_menu extends ACore_Admin
{
    protected function obr()
    {
        $title = $_POST['title'];
        $text = $_POST['text'];
        if (empty($title) || empty($text)) {
            exit("Не заполнены обязательные поля!");
        }

        $query = " INSERT INTO menu
						(name_menu,text_menu)
					VALUES ('$title','$text')";
        if (!mysql_query($query)) {
            exit(mysql_error());
        } else {
            $_SESSION['res'] = "Изменения сохранены";
            header("Location:?option=add_menu");
            exit();
        }

    }

    public function get_content()
    {

        echo '<div id="main">';
        if ($_SESSION['res']) {
            echo($_SESSION['res']);
            unset($_SESSION['res']);
        }

        print <<<HEREDOC
            <form class="add_statti"  action="" method="post">
                <label>Наименование пункта меню<br>
                    <input type="text" name="title">
                </label>
                <label>Текст:<br>
                    <textarea name="text" cols="50" rows="7"></textarea>
                </label>
                <input type="submit" name="button" value="Сохранить">
            </form>
            </div></div>
HEREDOC;
    }
}