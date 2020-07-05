<?php
 require_once('includes/initialize.php');
?>
<?php
	$max_file_size = 12582912;

	if(isset($_POST['submit'])) {
		$photo = new Photograph();
		$photo->caption = $_POST['caption'];
		$photo->attach_file($_FILES['file_upload']);
		if($photo->save()) {
      $session->message("Prawidłowo dodano zdjęcie");
            log_action("Dodano zdjęcie");
			redirect_to('list_photos.php');
		} else {
      $message = join("<br />", $photo->errors);
		}
	}
	
?>

<?php require_once('includes/header.php'); ?>
<div id="content">
	<h2>Dodaj nowe zdjęcie</h2>

	<?php echo output_message($message); ?>
  <form action="photo_upload.php" enctype="multipart/form-data" method="POST">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>" />
    <p><input type="file" name="file_upload" /></p>
    <p>Opis zdjęcia: <input type="text" name="caption" value="" /></p>
    <input type="submit" name="submit" value="Upload" />
  </form>
</div>

<aside id="sidebar">
    <?php require_once("sidebar_up.php"); ?>
    <?php require_once("sidebar_down.php"); ?>
    <?php include("includes/footer.php")?>
</aside>