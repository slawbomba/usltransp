<?php require_once("includes/initialize.php"); ?>
<?php
confirm_logged();
  $logfile = 'logs/log.txt';
  
  if($_GET['clear'] == 'true') {
		file_put_contents($logfile, '');
	  log_action('Logi wyczyszczone', "przez uzytkownika {$_SESSION['users.username']}");

    redirect_to('logfile.php');
  }
?>

<?php require_once('includes/header.php'); ?>
<div id="content">
<a href="index.php">&laquo; Wstecz</a><br />
<br />

<h2>Logi</h2>

<p><a href="logfile.php?clear=true">Wyczyść plik z logami</a></p>

<?php

  if( file_exists($logfile) && is_readable($logfile) && 
			$handle = fopen($logfile, 'r')) {  
    echo "<ul class=\"log-entries\">";
		while(!feof($handle)) {
			$entry = fgets($handle);
			if(trim($entry) != "") {
				echo "<li>{$entry}</li>";
			}
		}
		echo "</ul>";
    fclose($handle);
  } else {
    echo "Nie można odczytać pliku {$logfile}.";
  }

?>
</div>

<aside id="sidebar">
    <?php require_once("sidebar_up.php"); ?>
    <?php require_once("sidebar_down.php"); ?>
    <?php include("includes/footer.php")?>
</aside>