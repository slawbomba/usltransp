
<?php 
require_once 'includes/connection.php';
require_once 'includes/functions.php';


if(isset($_POST['q1']) && strlen($_POST['q1'])>0)
{	
if(is_numeric($_POST['q2']) )
{
	$contentToSave = filter_var($_POST['q1']);
	$idToAdd = filter_var($_POST['q2'],FILTER_SANITIZE_NUMBER_INT); 

	if(mysql_query("INSERT INTO pages(menu_name,subject_id) VALUES('".$contentToSave."','".$idToAdd."')"))
	{
        log_action("Nowa podstrona została dodana");

       }
		else
	{    header('HTTP/1.1 500 Błąd. Sprobuj pozniej.);
		exit();
	}
	
}
	
}

?>