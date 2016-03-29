<?php

class login extends ACore{
	public function get_content() {
		echo "<div id='main'>";
		
print <<<ECHO
<form action='' method='POST'>
<p>Login:<br />
<input type='text' name='login'>
</p>
<p>Password:<br />
<input type='password' name='password'>
</p>
<p>
<p><input type='submit' name='button' value='Войти'></p></form>
ECHO;
		echo "</div></div>";		
	}
}
?>