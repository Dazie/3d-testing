<?php

class update_statti extends ACore_Admin
{
    protected function obr()
    {
        if (!empty($_FILES['img_src']['tmp_name'])) {
            if (!move_uploaded_file($_FILES['img_src']['tmp_name'], 'file/' . $_FILES['img_src']['name'])) {
                exit("Не удалось загрузить изображение!");
            }
            $img_src = 'file/' . $_FILES['img_src']['name'];
        }

        $id = $_POST['id'];
        $title = $_POST['title'];
        $date = date("Y-m-d", time());
        $description = $_POST['description'];
        $text = $_POST['text'];
        $cat = $_POST['cat'];
        if (empty($title) || empty($text) || empty($description)) {
            exit("Не заполнены обязательные поля!");
        }

        if($img_src!=''){
            $query = "UPDATE statti SET title='$title', img_src='$img_src', date='$date', text='$text', description='$description', cat='$cat' WHERE id='$id'";
        }else{
            $query = "UPDATE statti SET title='$title', date='$date', text='$text', description='$description', cat='$cat' WHERE id='$id'";
        }


        if (!mysql_query($query)) {
            exit(mysql_error());
        } else {
            $_SESSION['res'] = "Изменения сохранены";
            header("Location:?option=admin");
            exit;
        }
    }

    public function get_content()
    {
        if ($_GET['id_text']) {
            $id_text = (int)$_GET['id_text'];
        } else {
            exit("Неверные данные для страницы!");
        }

        $text = $this->get_text_statti($id_text);
        echo '<div id="main">';
        if ($_SESSION['res']) {
            echo($_SESSION['res']);
            unset($_SESSION['res']);
        }
        $cat = $this->get_categories();

        print <<<HEREDOC
            <form class="add_statti" enctype="multipart/form-data" action="" method="post">
                <label>Заголовок статьи<br>
                    <input type="text" name="title" value="$text[title]">
                    <input type="hidden" name="id" value="$text[id]">
                </label>
                <label>Изображение:
                    <input type="file" name="img_src" value="$text[img_src]">
                </label>
                <label>Краткое описание:<br>
                    <textarea name="description" cols="50" rows="7">$text[description]</textarea>
                </label>
                <label>Текст:<br>
                    <textarea name="text" cols="50" rows="7">$text[text]</textarea>
                </label>
                <label>Выберите категорию:
                <select name="cat">

HEREDOC;
        foreach ($cat as $item) {
            if ($text['cat'] == $item['id_category']) {
                echo "<option selected value='" . $item['id_category'] . "'>" . $item['name_category'] . "</option>";
            } else {
                echo "<option value='" . $item['id_category'] . "'>" . $item['name_category'] . "</option>";
            }
        }

        echo '</select></label>
                <br>
                <input type="submit" name="button" value="Сохранить">
            </form></div></div>';
    }
}