<?php require_once("includes/initialize.php");

 if(is_numeric($_POST["recordToDelete"]))
{	
	$idToDelete = filter_var($_POST["recordToDelete"],FILTER_SANITIZE_NUMBER_INT);

	
	if(mysql_query("DELETE FROM article WHERE id=".$idToDelete))
	{
        log_action("Usunieto artykul o ID<b>", "{$idToDelete} </b>");

    }else	{header('HTTP/1.1 Nie można usunąć rekordu');
		return false;
        exit();
	}

}

?>