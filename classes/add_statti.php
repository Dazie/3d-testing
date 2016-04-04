<?php

class add_statti extends ACore_Admin
{

    public function get_content()
    {

        echo '<div id="main">';

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
        foreach($cat as $item){
            echo "<option value=''>".$item['name_category']."</option>";
        }

        echo '</select></label>
                <br>
                <input type="submit" name="button" value="Сохранить">
            </form></div></div>';
    }
}