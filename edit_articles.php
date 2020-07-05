<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged();?>


<?php


	include_once("includes/form_functions.php");

	if (isset($_POST['submit'])) {
		$errors = array();
		$required_fields = array('title', 'text');
		$errors = array_merge($errors, check_required_fields($required_fields));

		$fields_with_lengths = array('title' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths));

		$id = mysql_prep($_GET['page']);
		$title = trim(mysql_prep($_POST['title']));
		$text = mysql_prep($_POST['text']);

		if (empty($errors)) {
			$query = 	"UPDATE article SET
							title = '{$title}',
							text = '{$text}'
						WHERE id = {$id}";
			$result = mysql_query($query);
			if (mysql_affected_rows() == 1) {
				$message = "Edycja zakończona pomyslnie";
                log_action("Edytowano artykul o tytule<b>", "{$title} </b>");
                redirect_to("index.php");
			} else {
				$message = "Błąd! Nie udała się edycja";
				$message .= "<br />" . mysql_error();
			}
		} else {
			if (count($errors) == 1) {
				$message = "There was 1 error in the form.";
			} else {
				$message = "There were " . count($errors) . " errors in the form.";
			}
		}
	}
?>
<?php find_selected_page(); ?>
<?php include("includes/header.php"); ?>


		<div id="content">
			<h2>Edycja artykułu: <?php echo $sel_article['title']; ?></h2>
			<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>

			<form action="edit_articles.php?page=<?php echo $sel_article['id']; ?>" method="post">



<?php if (!isset($new_page)) {$new_page = false;} ?>



<p>Tytuł: <input type="text" name="title" value="<?php echo $sel_article['title']; ?>" id="title" /></p>


<p>Treść:<br />
	    <textarea name="text" class="jqte-test" rows="20" cols="80"><?php echo $sel_article['text']; ?></textarea>
</p>

          <script>
	$('.jqte-test').jqte();
	var jqteStatus = true;
	$(".status").click(function()
	{
		jqteStatus = jqteStatus ? false : true;
		$('.jqte-test').jqte({"status" : jqteStatus})
	});
</script>

				<input type="submit" name="submit" value="Aktualizuj artykuł" />&nbsp;&nbsp;
					</form>
			<br />
			<a href="index.php">Wyjście</a><br />
		</div>

<aside id="sidebar">
    <?php require_once("sidebar_up.php"); ?>
    <?php require_once("sidebar_down.php"); ?>
    <?php include("includes/footer.php")?>
</aside>