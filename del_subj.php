<?php require_once("includes/initialize.php");

 if( isset($_POST["recordToDelete"]) && strlen($_POST["recordToDelete"])>0 && is_numeric($_POST["recordToDelete"]))
{
$idToDelete = filter_var($_POST["recordToDelete"],FILTER_SANITIZE_NUMBER_INT);
if(mysql_query("DELETE FROM subjects WHERE id='".$idToDelete."'"))
	{
        log_action("Usunieto strone o ID<b>", "{$idToDelete} </b>");
	}

else
{
	header('HTTP/1.1 500 Error occurred, Could not process request!');
    exit();
}
}
?>