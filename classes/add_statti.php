<?php

class add_statti extends ACore_Admin
{
    protected function obr()
    {
        if (!empty($_FILES['img_src']['tmp_name'])) {
            if (!move_uploaded_file($_FILES['img_src']['tmp_name'], 'file/' . $_FILES['img_src']['name'])) {
                exit("Не удалось загрузить изображение!");
            }
            $img_src = 'file/' . $_FILES['img_src']['name'];
        } else {
            //exit("Необходимо загрузить изображение");
            echo "<script>";
            echo "alert('Необходимо загрузить изображение')";
            echo "</script>";
        }
        $title = $_POST['title'];
        $date = date("Y-m-d",time());
        $description = $_POST['description'];
        $text = $_POST['text'];
        $cat = $_POST['cat'];
        if (empty($title) || empty($text) || empty($description)) {
            exit("Не заполнены обязательные поля!");
        }

        $query = " INSERT INTO statti
						(title,img_src,date,text,description,cat)
					VALUES ('$title','$img_src','$date','$text','$description','$cat')";
        if (!mysql_query($query)) {
            exit(mysql_error());
        } else {
            $_SESSION['res'] = "Изменения сохранены";
            header("Location:?option=add_statti");
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
        $cat = $this->get_categories();

        print <<<HEREDOC
            <form class="add_statti" enctype="multipart/form-data" action="" method="post">
                <label>Заголовок статьи<br>
                    <input type="text" name="title">
                </label>
                <label>Изображение:
                    <input type="file" name="img_src">
                </label>
                <label>Краткое описание:<br>
                    <textarea name="description" cols="50" rows="7"></textarea>
                </label>
                <label>Текст:<br>
                    <textarea name="text" cols="50" rows="7"></textarea>
                </label>
                <label>Выберите категорию:
                <select name="cat">

HEREDOC;
        foreach ($cat as $item) {
            echo "<option value='".$item['id_category']."'>" . $item['name_category'] . "</option>";
        }

        echo '</select></label>
                <br>
                <input type="submit" name="button" value="Сохранить">
            </form></div></div>';
    }
}