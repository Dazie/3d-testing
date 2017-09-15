<?php

class update_category extends ACore_Admin
{
    public function obr(){
        $id_cat = $_POST['id_category'];
        $name_cat = $_POST['name_cat'];

        if(!$name_cat){
            exit("Введите наименование категории!");
        }

        $query = "UPDATE category SET name_category='$name_cat' WHERE id_category='$id_cat'";

        if(!mysql_query($query)){
            exit(mysql_error());
        } else {
            $_SESSION['res']='Изменения сохранены';
            header("Location:?option=edit_category");
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

        if($_GET['id_text']) {
            $id_text = (int)$_GET['id_text'];
        } else {
            exit("Неверные данные");
        }

        $cats = $this->get_categories_by_id($id_text);

        print <<<HEREDOC
            <form class="add_statti"  action="" method="post">
                <label>Наименование категории: <br>
                    <input class="form-control" type="text" name="name_cat" value="$cats[name_category]">
                    <input type="hidden" name="id_category" value="$cats[id_category]">
                </label>
                <input type="submit" name="button" value="Сохранить">
            </form>
            </div></div>
HEREDOC;
    }
}