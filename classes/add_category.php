<?php

class add_category extends ACore_Admin
{
    public function obr()
    {
        $name_cat = $_POST['name_cat'];

        if (!$name_cat) {
            exit("Вы не ввели название категории!");
        }

        if (!$this->try_category_name($name_cat)){
            exit("Такая категория уже существует!");
        }

        $query = "INSERT INTO category
                    (name_category)
                  VALUES ('$name_cat')";
        if (!mysql_query($query)) {
            exit(mysql_error());
        } else {
            $_SESSION['res'] = "Категория добавлена";
            header("Location:?option=edit_category");
            exit();
        }
    }

    public function get_content()
    {
        echo '<div id="main" class="col-md-9">';
        if ($_SESSION['res']) {
            echo($_SESSION['res']);
            unset($_SESSION['res']);
        }

        print <<<HEREDOC
            <form class="add_statti"  action="" method="post">
                <label>Наименование категории: <br>
                    <input type="text" name="name_cat">
                </label>
                <input type="submit" name="button" value="Сохранить">
            </form>
            </div></div>
HEREDOC;
    }
}