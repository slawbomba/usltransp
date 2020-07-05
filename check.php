<?php
require_once 'includes/connection.php';
require_once 'includes/functions.php';

$username = trim(($_POST['username_check']));

$result = mysql_query("SELECT username FROM users WHERE username = '$username' LIMIT 1" ,$connection);

$num = mysql_num_rows($result);

echo $num;
mysql_close();