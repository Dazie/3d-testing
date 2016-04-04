<?php

abstract class ACore_Admin
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

    protected function get_leftbar()
    {
        echo '<div class="quick-bg">
					<div id="spacer" style="margin-bottom:15px;">
						<div id="rc-bg" style="overflow: hidden; font-size:14px;">Разделы админки</div>
					</div>;';

        echo '<div class="quick-links" >
					<a href="?option=edit_statti">Статьи</a>
					</div>';

        echo '<div class="quick-links" >
					<a href="?option=edit_menu">Меню</a>
					</div>';

        echo '<div class="quick-links" >
					<a href="?option=edit_category">Категории</a>
					</div>';

        echo '</div>';
    }

    protected function get_menu()
    {
        echo '
				<div id="mainarea">
					<div class="heading"></div>
				';
    }

    protected function get_footer()
    {
        echo '<div id="bottom">';

        $j = 1;

        echo "</div>
		            <div class='copy'><span class='style1'> Copyright 2010 Тртрррт тртртрт </span>
		            </div>
		        </div>
		    </center>
		    </body>
		    </html>";
    }

    public function get_body()
    {
        $this->get_header();
        $this->get_leftbar();
        $this->get_menu();
        $this->get_content();
        $this->get_footer();
    }

    abstract function get_content();
}