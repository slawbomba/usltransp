<?php require_once("includes/initialize.php"); ?>
<?php confirm_logged();?>


<?php

if (isset($_POST['submit'])) {
    $errors = array();

    $required_fields = array('text');
    $errors = array_merge($errors, check_required_fields($required_fields));


    $text = mysql_prep($_POST['text']);

    if (empty($errors)) {
        $query = 	"UPDATE pages SET
							text = '{$text}'
						WHERE id = '0' OR subject_id='0'";
        $result = mysql_query($query);
        if (mysql_affected_rows() == 1) {
            $message = "Edycja zakończona pomyslnie";
redirect_to("index.php");
            log_action("<a href=\"index.php\">Edytowano strone tytulowa ", " </a>");
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
    <h2>Edycja strony tytułowej</h2>
    <?php if (!empty($message)) {echo "<p class=\"message\">" . $message . "</p>";} ?>
    <?php if (!empty($errors)) { display_errors($errors); } ?>

    <form action="edit_index.php" method="post">
 <p>Treść:<br />
            <textarea name="text" class="jqte-test" rows="20" cols="80"><?php echo view(); ?></textarea>
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
        <input type="submit" name="submit" value="Edytuj" /><br /><br />
           </form>
    <br />
    <a href="index.php">Wyjście</a><br />
</div>

<aside id="sidebar">
    <?php require_once("sidebar_up.php"); ?>
    <?php require_once("sidebar_down.php"); ?>
    <?php include("includes/footer.php")?>
</aside>