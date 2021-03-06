<?php

abstract class ACore_Admin
{

    protected $db;

    public function __construct()
    {
        if (!$_SESSION['user']) {
            header("Location:?option=login");
        }

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

    protected function get_leftbar()
    {
        echo '<div class="left-menu">';

        echo '<h2 class="to-site"><a href="?option=main">На сайт</a></h2>';

        echo '<h2>Изменить</h2>';

        echo '<div class="left-menu__item" >
					<a href="?option=edit_menu">Меню</a>
					</div>';

        echo '<div class="left-menu__item" >
					<a href="?option=edit_category">Категории</a>
					</div>';
        echo '<div class="left-menu__item" >
					<a href="?option=add_statti">Добавить статью</a>
					</div>';
        echo '<div class="left-menu__item" >
					<a href="?option=edit_tests">Тесты</a>
					</div>';
        echo '<h2>Пользователи</h2>';
        echo '<div class="left-menu__item" >
					<a href="?option=add_user">Добавить пользователя</a>
					</div>';
        echo '<h2>Информация</h2>';
        echo '<div class="left-menu__item" >
					<a href="?option=statistics">Статистика</a>
					</div>';
        echo '</div>';

        echo '</div>';
    }

    protected function get_workarea()
    {
        echo '<div id="mainarea"><div class="wrapper"> <div class="col-md-3">';

    }

    protected function get_footer()
    {
        include("footer.php");
    }

    protected function get_categories()
    {
        $query = "SELECT id_category, name_category FROM category";
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

    protected function get_users()
    {
        $query = "SELECT u_id, login FROM users";
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

    protected function get_tests()
    {
        $query = "SELECT test_name, test_descr FROM tests";
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

    protected function get_test_by_name($name)
    {
        $query = "SELECT test_id FROM tests WHERE test_name='$name'";
        $result = mysql_query($query);

        if (!$result) {
            exit(mysql_error());
        }

        $id = mysql_fetch_array($result, MYSQL_ASSOC);

        return $id['test_id'];
    }

    protected function get_question_by_text($text)
    {
        $query = "SELECT q_id FROM test_questions WHERE q_text='$text'";
        $result = mysql_query($query);

        if (!$result) {
            exit(mysql_error());
        }

        $id = mysql_fetch_array($result, MYSQL_ASSOC);

        return $id['q_id'];
    }

    protected function get_text_statti($id)
    {
        $query = "SELECT id, title, description, text, date, img_src, cat FROM statti WHERE id='$id'";
        $result = mysql_query($query);

        if (!$result) {
            exit(mysql_error());
        }

        $row = array();
        $row = mysql_fetch_array($result, MYSQL_ASSOC);

        return $row;
    }

    protected function get_text_menu($id)
    {
        $query = "SELECT id_menu, name_menu, text_menu FROM menu WHERE id_menu='$id'";
        $result = mysql_query($query);

        if (!$result) {
            exit(mysql_error());
        }

        $row = array();
        $row = mysql_fetch_array($result, MYSQL_ASSOC);

        return $row;
    }

    protected function get_categories_by_id($id)
    {
        $query = "SELECT id_category, name_category FROM category WHERE id_category='$id'";
        $result = mysql_query($query);

        if (!$result) {
            exit(mysql_error());
        }

        $row = array();
        $row = mysql_fetch_array($result, MYSQL_ASSOC);

        return $row;
    }

    protected function try_category_name($name)
    {
        $cats = $this->get_categories();
        foreach ($cats as $item) {
            if ($name == $item['name_category']) {
                return false;
            }
        }
        return true;
    }

    protected function try_test_name($name)
    {
        $tests = $this->get_tests();
        foreach ($tests as $item) {
            if ($name == $item['test_name']) {
                return false;
            }
        }
        return true;
    }

    protected function try_user_name($name)
    {
        $tests = $this->get_users();
        foreach ($tests as $item) {
            if ($name == $item['login']) {
                return false;
            }
        }
        return true;
    }

    protected function try_category_use($id_category)
    {
        $query = "SELECT id, title FROM statti WHERE cat='$id_category'";
        $result = mysql_query($query);

        if (!$result) {
            return true;
        } else {
            $row = array();
            $row = mysql_fetch_array($result, MYSQL_ASSOC);

            return $row;
        }
    }

    public function get_body()
    {
        if ($_POST || $_GET['del']) {
            $this->obr();
        }
        $this->get_header();
        $userID = $_SESSION['userID'];
        $query = "SELECT u_id, rights FROM users WHERE u_id='$userID'";
        $result = mysql_query($query);
        if (!$result) {
            exit(mysql_error());
        }
        if (mysql_num_rows($result) == 1) {
            if (mysql_fetch_array($result, MYSQL_ASSOC)['rights'] === 'U') {
                echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Ошибка!</strong> Отказано в доступе! <a href="/?option=main"> Вернуться на сайт</a>
                </div>';
            } else {

                $this->get_workarea();
                $this->get_leftbar();
                $this->get_content();
                $this->get_footer();
            }
        }

    }

    abstract function get_content();
}