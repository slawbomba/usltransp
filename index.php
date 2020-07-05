<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/header.php"); ?>

<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>

	<div id="content">
<?php

if(!logged_in_admin()){
view();
}
else if(logged_in_admin()){echo view();
    echo "<br /><br /><br /><br /><br /><a href=\"edit_index.php\">Edytuj stronę tytułową</a>";}
?>

</div> 
	<aside id="sidebar">
<?php require_once("sidebar_up.php"); ?>
<?php require_once("sidebar_down.php"); ?>


<?php include("includes/footer.php")?>
    </aside>