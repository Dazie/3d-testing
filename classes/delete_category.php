<?php

class delete_category extends ACore_Admin
{
    public function get_content(){}
    public function obr(){
        if($_GET['del']){
            $id_text=(int)$_GET['del'];

            $query = "DELETE FROM category WHERE id_category='$id_text'";
            if(!mysql_query($query)) {
                exit(mysql_error());
            }else{
                $_SESSION['res']="Категория удалена";
                header("Location:?option=edit_category");
                exit;
            }
        }else{
            exit("Неверные даные!");
        }
    }
}