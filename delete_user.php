<?php require_once("includes/initialize.php"); ?>
<?php
confirm_logged();

if(empty($_GET['id'])) {
    $session->message("Brak uzytkownika o tym ID.");
    redirect_to('index.php');
}

$user = User::find_by_id($_GET['id']);
if($user && $user->delete()) {
    $session->message("Uzytkownik {$user->username} został usunięty");

    log_action("Uzytkownik <b>", "{$user->username} </b>zostal usuniety");
    redirect_to('lista_uzytkownikow.php');
} else {
    $session->message("Uzytkownik nie może zostać usunięty");
    redirect_to('lista_uzytkownikow.php');
}

?>
<?php if(isset($database)) { $database->close_connection(); } ?>
