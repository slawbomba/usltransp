<?php require_once("includes/initialize.php"); ?>
<?php confirm_logged();?>


<?php
	if (intval($_GET['page']) == 0) {
		redirect_to('content.php');
	}

	if (isset($_POST['submit'])) {
		$errors = array();

		$required_fields = array('menu_name', 'subject_id', 'text');
		$errors = array_merge($errors, check_required_fields($required_fields));
		
		$fields_with_lengths = array('menu_name' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths));

		$id = mysql_prep($_GET['page']);
		$menu_name = trim(mysql_prep($_POST['menu_name']));
		$subject_id = mysql_prep($_POST['subject_id']);
		$text = mysql_prep($_POST['text']);

		if (empty($errors)) {
			$query = 	"UPDATE pages SET 
							menu_name = '{$menu_name}',
							subject_id = {$subject_id},
							text = '{$text}'
						WHERE id = {$id}";
			$result = mysql_query($query);
			if (mysql_affected_rows() == 1) {
				$message = "Edycja zakończona pomyslnie";

                log_action("<a href=\"content.php?page={$id}\">Edytowano podstrone ", " </a>");
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
			<h2>Edycja podstrony: <?php echo $sel_page['menu_name']; ?></h2>
			<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>
			
			<form action="edit_page.php?page=<?php echo $sel_page['id']; ?>" method="post">
      

<?php include "page_form.php" ?>
<script>
	$('.jqte-test').jqte();
	var jqteStatus = true;
	$(".status").click(function()
	{
		jqteStatus = jqteStatus ? false : true;
		$('.jqte-test').jqte({"status" : jqteStatus})
	});
</script>
				<input type="submit" name="submit" value="Edytuj" /><br /><br />
				 <a href="#" class="del_button" id="del-<?php echo $sel_page['id'] ?>">Usuń podstronę</a><br />
			</form>
			<br />
			<a href="content.php?page=<?php echo $sel_page['id']; ?>">Wyjście</a><br />
		</div>

<aside id="sidebar">
    <?php require_once("sidebar_up.php"); ?>
    <?php require_once("sidebar_down.php"); ?>
    <?php include("includes/footer.php")?>
</aside>