<?php

class update_menu extends ACore_Admin
{
    protected function obr()
    {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $text = $_POST['text_menu'];
        if (empty($title) || empty($text)) {
            exit("Не заполнены обязательные поля!");
        }

        $query = "UPDATE menu SET name_menu='$title', text_menu='$text' WHERE id_menu='$id'";

        if (!mysql_query($query)) {
            exit(mysql_error());
        } else {
            $_SESSION['res'] = "Изменения сохранены";
            header("Location:?option=edit_menu");
            exit;
        }
    }

    public function get_content()
    {
        echo '<div id="main">';

        if ($_GET['id_text']) {
            $id_text = (int)$_GET['id_text'];
        } else {
            exit("Неверные данные для страницы!");
        }

        if ($_SESSION['res']) {
            echo($_SESSION['res']);
            unset($_SESSION['res']);
        }

        $text = $this->get_text_menu($id_text);

        print <<<HEREDOC
            <form class="add_statti"  action="" method="post">
                <label>Наименование пункта меню<br>
                    <input type="text" name="title" value="$text[name_menu]">
                    <input type="hidden" name="id" value="$text[id_menu]">
                </label>
                <label>Текст:<br>
                    <textarea name="text_menu" cols="50" rows="7">$text[text_menu]</textarea>
                </label>
                <input type="submit" name="button" value="Сохранить">
            </form>
            </div></div>
HEREDOC;
    }
}