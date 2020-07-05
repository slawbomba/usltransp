<?php require_once('includes/initialize.php');?>
<?php
	if(empty($_GET['id'])) {
	  $session->message("Zdjęcie niedostępne");
	  redirect_to('index.php');
	}
	
  $photo = Photograph::find_by_id($_GET['id']);
  if(!$photo) {
    $session->message("Nie znaleziono zdjęcia");
    redirect_to('index.php');
  }

	$comments = $photo->comments();
	
?>
<?php require_once('includes/header.php'); ?>
<div id="content">
<a href="list_photos.php">&laquo; Wstecz</a><br />
<br />

<h2>Komentarze obrazu</h2>
    <img src="gallery/<?php echo $photo->filename; ?>"  />

<?php echo output_message($message); ?>
<div id="comments">
  <?php foreach($comments as $comment): ?>
    <div class="comment" style="margin-bottom: 2em;">
	    <div class="author">
	      Użytkownik<b><?php echo htmlentities($comment->autor); ?> </b>napisał:
	    </div>
      <div class="body">
				<?php echo strip_tags($comment->text, '<strong><em><p>'); ?>
			</div>
	    <div class="meta-info" style="font-size: 0.8em;">
	      <?php echo datetime_to_text($comment->data_dodania); ?>
	    </div>
			<div class="actions" style="font-size: 0.8em;">
				<a href="delete_comment.php?id=<?php echo $comment->id; ?>">Usuń komentarz</a>
			</div>
    </div>
  <?php endforeach; ?>
  <?php if(empty($comments)) { echo "Brak komentarzy"; } ?>
</div>
</div>

<aside id="sidebar">
    <?php require_once("sidebar_up.php"); ?>
    <?php require_once("sidebar_down.php"); ?>

    <?php include("includes/footer.php")?>
</aside>