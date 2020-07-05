<?php
require_once 'includes/connection.php';
require_once 'includes/functions.php';

if(isset($_POST['add_subject']) && strlen($_POST['add_subject'])>0 )
{	

	$contentToSave1 = filter_var($_POST['add_subject']);

	if(mysql_query("INSERT INTO subjects(menu_name) VALUES('".$contentToSave1."')"))
	{
        log_action("Dodano nowa strone");
    }else{
        header('HTTP/1.1 500 Błąd. Sprobuj pozniej.');
		exit();
	}

}
?>