<?php

abstract class ACore
{

    protected $db;

    public function __construct()
    {
        $this->db = mysql_connect(HOST, USER, PASSWORD);
        if (!$this->db) {
            exit("Ошибка соединения с базой данных" . mysql_error());
        }
        if (!mysql_select_db(DB, $this->db)) {
            exit("Нет такой бд" . mysql_error());
        }
        mysql_query("SET NAMES 'UTF8'");
    }

    protected function get_header()
    {
        include("header.php");
    }

    protected function get_menu()
    {
        $menuArray = $this->menu_array();

        if (!empty($menuArray)) {
            echo '<div class = "top-panel"><div class="wrapper"><div class="col-md-9 top-panel__menu"><ul class="list-unstyled"><li><a href="/" >Главная</a></li>';
            foreach ($menuArray as $arMenuItem) {
                echo '<li><a href="?option=menu&id_menu=' . $arMenuItem['id_menu'] . '">' . $arMenuItem['name_menu'] . '</a>';
            }

            if($_SESSION['user'] === true){
                echo '</ul></div><div class="col-md-3 top-panel__login">
                <a href="?option=cabinet">Вход</a>
                <div class="separator"></div>
                <a href="?option=exit">Выход</a>
                </div></div></div>';
            } else {
                echo '</ul></div><div class="col-md-3 top-panel__login">
            <a href="?option=login">Войти</a>
            <div class="separator"></div>
            <a href="?option=register">Зарегистрироваться</a>
            </div></div></div>';
            }

        }
    }

    protected function menu_array()
    {
        $query = "SELECT id_menu, name_menu FROM menu";
        $result = mysql_query($query);
        if (!$result) {
            exit(mysql_error());
        }

        $row = array();
        for ($i = 0; $i < mysql_num_rows($result); $i++) {
            $row[] = mysql_fetch_array($result, MYSQL_ASSOC);
        }

        return $row;
    }

    protected function get_workarea()
    {
        echo '<div id="mainarea"><div class="wrapper"> <div class="col-md-3"> ';
        $this->get_left_menu();
        echo '</div>';

    }

    protected function get_left_menu()
    {
        $query = "SELECT id_category, name_category FROM category";
        $result = mysql_query($query);
        if (!$result) {
            exit(mysql_error());
        };
        $arCategories = [];
        for ($i = 0; $i < mysql_num_rows($result); $i++) {
            $row = mysql_fetch_array($result, MYSQL_ASSOC);
            $arCategories[] = $row;
        }

        echo '<div class="left-menu">
					<h2>Меню</h2>';
        foreach ($arCategories as $arCategoryItem) {
            echo '<div class = "left-menu__item"><a href="?option=category&id_cat=' .
                $arCategoryItem['id_category'] .
                '">' .
                $arCategoryItem['name_category'] .
                '</a></div>';
        }
        echo "</div>";
    }

    protected function get_footer()
    {
        include("footer.php");
    }

    public function get_body()
    {
        if ($_GET['option'] === 'login' || $_GET['option'] === 'register') {

            if ($_POST || $_GET['del']) {
                $this->obr();
            }
            $this->get_content();
        } else {
            if ($_POST || $_GET['del']) {
                $this->obr();
            }

            $this->get_header();
            $this->get_menu();
            $this->get_workarea();
            $this->get_content();
            $this->get_footer();
        }

    }

    abstract function get_content();
}