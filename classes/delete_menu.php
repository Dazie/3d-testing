<?php

class delete_menu extends ACore_Admin
{
    public function get_content(){}
    public function obr(){
        if($_GET['del']){
            $id_text=(int)$_GET['del'];

            $query = "DELETE FROM menu WHERE id_menu='$id_text'";
            if(!mysql_query($query)) {
                exit(mysql_error());
            }else{
                $_SESSION['res']="Пункт меню удален";
                header("Location:?option=edit_menu");
                exit;
            }
        }else{
            exit("Неверные даные!");
        }
    }
}