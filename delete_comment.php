<?php require_once("includes/initialize.php");
confirm_logged();?>
<?php if (!logged_in_admin()) { redirect_to("login.php"); } ?>
<?php
	
  if(empty($_GET['id'])) {
  	$session->message("Brak komentarzy");
    redirect_to('index.php');
  }

  $comment = Comment::find_by_id($_GET['id']);
  if($comment && $comment->delete()) {
    $session->message("Komentarz zostal usuniety");
    redirect_to("comments.php?id={$comment->photograph_id}");
  } else {
    $session->message("Komentarz nie moze zostac usuniety");
    redirect_to('list_photos.php');
  }
  
?>
<?php if(isset($database)) { $database->close_connection(); } ?>
