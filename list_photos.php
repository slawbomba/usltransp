<?php require_once("includes/initialize.php"); ?>
<?php confirm_logged();?>
<?php
  $photos = Photograph::find_all();
?>
<?php require_once("includes/header.php"); ?>
<div id="content">
<h2>Zdjecia</h2>

<?php echo output_message($message); ?>
<table class="bordered">
  <tr>
    <th>Zdjęcie</th>
    <th>Opis</th>
   	<th>Liczba komentarzy</th>
</tr>
<?php foreach($photos as $photo): ?>
  <tr>
    <td><a href="comments.php?id=<?php echo $photo->id; ?>"><img src="gallery/<?php echo $photo->filename; ?>" width="100" /></a></td>
    <td><?php echo $photo->caption; ?></td>

		<td>
			<a href="comments.php?id=<?php echo $photo->id; ?>">
				<?php echo count($photo->comments()); ?>
			</a>
		</td>
		<td><a href="delete_photo.php?id=<?php echo $photo->id; ?>">Usun</a></td>
  </tr>
<?php endforeach; ?>
</table>
<br />
<a href="photo_upload.php">Dodaj nowe zdjecie</a>
</div>
<aside id="sidebar">
    <?php require_once("sidebar_up.php"); ?>
    <?php require_once("sidebar_down.php"); ?>
</aside>

<?php include("includes/footer.php")?>