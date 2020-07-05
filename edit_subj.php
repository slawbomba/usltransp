<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php confirm_logged();?>


<?php
	if (intval($_GET['subj']) == 0) {
		redirect_to('content.php');
	}

	include_once("includes/form_functions.php");

	if (isset($_POST['submit'])) {
		$errors = array();

		$required_fields = array('menu_name','visible');
		$errors = array_merge($errors, check_required_fields($required_fields));
		
		$fields_with_lengths = array('menu_name' => 30);
		$errors = array_merge($errors, check_max_field_lengths($fields_with_lengths));

		$id = mysql_prep($_GET['subj']);
		$menu_name = trim(mysql_prep($_POST['menu_name']));
        $visible = mysql_prep($_POST['visible']);

		if (empty($errors)) {
			$query = 	"UPDATE subjects SET
							menu_name = '{$menu_name}',
							visible = '{$visible}'
							WHERE id = '{$id}'";
			$result = mysql_query($query);
			if (mysql_affected_rows() == 1) {
				$message = "Edycja zakończona pomyślnie";
                log_action("<a href=\"content.php?subj={$id}\">Edytowano strone ", " </a>");
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
			<h3>Edycja strony:</h3><h2><?php echo $sel_subject['menu_name']; ?></h2>
			<?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
			<?php if (!empty($errors)) { display_errors($errors); } ?>
			
			<form action="edit_subj.php?subj=<?php echo $sel_subject['id']; ?>" method="post">
      

<?php include "subj_form.php" ?>

				<input type="submit" name="submit" value="Edytuj" /><br /><br />
				<?php echo "<a href=\"#\" class=\"del_button_subject\" id=\"del-".$sel_subject["id"]."\">Usuń stronę</a>";?>
				</form>
			<br />
			<a href="index.php">Wyjście</a><br />
		</div>


	<aside id="sidebar">
<?php require_once("sidebar_up.php"); ?>
<?php require_once("sidebar_down.php"); ?>
<?php include("includes/footer.php")?>
    </aside>