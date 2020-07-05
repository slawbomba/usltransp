<?php require_once("includes/initialize.php"); ?>
<?php
confirm_logged();

$user = User::find_by_id($_GET['id']);


if(isset($_POST['submit'])) {
    $wait = trim($_POST['wait']);
    $id = $user->id;

    if (empty($errors)) {
        $query = "UPDATE users
					 SET wait = '{$wait}' WHERE id = {$id}";
        $result = mysql_query($query, $connection);
        if (mysql_affected_rows() == 1) {
            $message = "Zmiana urawnień wykonana pomyślnie";
            log_action("Zmieniono uprawnienia dla uzytkownika <b>", "{$user->username} </b>");
            redirect_to("lista_uzytkownikow.php");
        } else {
            $message = "Nie udało się zmienić uprawnień";
            $message .= "<br />". mysql_error();
        }

    } else {
        $message = "There were " . count($errors) . " errors in the form.";
    }
} else {
    $wait = "";
}


?>

<?php require_once('includes/header.php'); ?>

<div id="content">
    <a href="lista_uzytkownikow.php">&laquo; Wstecz</a><br />
    <br />

        <?php if(logged_in_admin()){?>
            <h3>Zmiana uprawnień dla:  <?php echo $user->username; ?></h3>

            <?php echo output_message($message); ?>
            <form action="edit_user.php?id=<?php echo $user->id; ?>" method="post">
                <table>
<tr>
       <td>             <input type="radio" name="wait" value="0"<?php
                    if ($user->wait=='0') { echo " checked"; }
                    ?> /> Podstawowe
                    &nbsp;
                    <input type="radio" name="wait" value="1"<?php
                    if ($user->wait=='1') { echo " checked"; }
                    ?> /> Moderator
                    &nbsp;
                    <input type="radio" name="wait" value="2"<?php
                    if ($user->wait=='2') { echo " checked"; }
                    ?> /> Administracyjne
                    </td></tr>

                        <td>&nbsp;</td>
                        <td><input type="submit" name="submit" value="Zmień" /></td>
                    </tr>
                </table>
            </form>
        </div>
    <?php } ?>
<aside id="sidebar">
    <?php require_once("sidebar_up.php"); ?>
    <?php require_once("sidebar_down.php"); ?>
    <?php include("includes/footer.php")?>
</aside>