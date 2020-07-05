<?php
require("constants.php");

global $connection;
$connection = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
if (!$connection) {
	die("Błąd bazy danych. Spróbuj później " . mysql_error());
}

$db_select = mysql_select_db(DB_NAME,$connection);
if (!$db_select) {
	die("Baza danych nie istnieje " . mysql_error());
}
?>
