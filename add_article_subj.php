
<?php 
require_once 'includes/connection.php';
require_once 'includes/functions.php';
find_selected_page(); 

if((isset($_POST['q1']) && strlen($_POST['q1'])>0))
 {
$title = filter_var($_POST['q1']);
	$text = filter_var($_POST['q2']);
	$idTo = filter_var($_POST["q3"],FILTER_SANITIZE_NUMBER_INT);
	$data_dodania = strftime("%Y-%m-%d %H:%M:%S", time());

	if(mysql_query("INSERT INTO article(title,text,subject_id,data_dodania) VALUES('".$title."','".$text."','".$idTo."','".$data_dodania."')"))
	{
        log_action('Artykuł o tytule', "{$title} zostal dodany.");
    }
	}
else 		{	header('HTTP/1.1 500 Błąd! Spróbuj później.');
		exit();}

?>