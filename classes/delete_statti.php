<?php

class delete_statti extends ACore_Admin{
    public function get_content(){}
    public function obr(){
        if($_GET['del']){
            $id_text=(int)$_GET['del'];

            $query = "DELETE FROM statti WHERE id='$id_text'";
            if(!mysql_query($query)) {
                exit(mysql_error());
            }else{
                $_SESSION['res']="Статья удалена";
                header("Location:?option=admin");
                exit;
            }
        }else{
            exit("Неверные даные!");
        }
    }
}