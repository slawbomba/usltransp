<?php require_once("includes/functions.php"); ?>
<?php
		session_start();

log_action('Uzytkownik<b>', "{$_SESSION['users.username']} </b>wylogowal sie");
		$_SESSION = array();

		if(isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-42000, '/');
		}
		session_destroy();

		header("Location:index.php");
?>