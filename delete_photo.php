<?php require_once("includes/initialize.php"); ?>
<?php
	
  if(empty($_GET['id'])) {
  	$session->message("No photograph ID was provided.");
    redirect_to('index.php');
  }

  $photo = Photograph::find_by_id($_GET['id']);
  if($photo && $photo->destroy()) {
    $session->message("Zdjecie {$photo->filename} zostalo usuniete");

    redirect_to('list_photos.php');
  } else {
    $session->message("The photo could not be deleted.");
    redirect_to('list_photos.php');
  }
  
?>
<?php if(isset($database)) { $database->close_connection(); } ?>
