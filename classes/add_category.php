<?php

class add_category extends ACore_Admin
{
    public function obr()
    {
        $name_cat = $_POST['name_cat'];

        if (!$name_cat) {
            echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Введите название категории!</strong>
                </div>';
        }

        if (!$this->try_category_name($name_cat)){
            echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Ошибка!</strong> Такая категория уже существует!
                </div>';
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
                    <input class="form-control" type="text" name="name_cat">
                </label>
                <input type="submit" name="button" value="Сохранить">
            </form>
            </div></div>
HEREDOC;
    }
}