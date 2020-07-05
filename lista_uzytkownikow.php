<?php require_once("includes/initialize.php"); ?>
<?php
confirm_logged();

$users = User::find_all();
?>
<?php require_once("includes/header.php");
confirm_logged();?>
<div id="content">
    <h2>Lista użytowników</h2>

    <?php echo output_message($message); ?>
    <table class="bordered">
        <tr>
            <th>Nazwa użytkownika</th>
            <th>Adres e-mail</th>
            <th>Uprawnienia</th>
        </tr>
        <?php foreach($users as $user): ?>
            <tr><?php if($user->id != "0") { ?>
                <td><?php echo $user->username; ?></td>
                <td><?php echo $user->email; ?></td>
                <td><?php
                    if ($user->wait=='2')echo Administracyjne;
                    else if($user->wait=='1')echo Moderator;
                    else if($user->wait=='0')echo Podstawowe; ?></td>
                <td><a href="edit_user.php?id=<?php echo $user->id; ?>">Edytuj</a></td>
                <td><a href="delete_user.php?id=<?php echo $user->id; ?>">Usuń</a></td>
            </tr>
        <?php } endforeach; ?>
    </table>

</div>
<aside id="sidebar">
    <?php require_once("sidebar_up.php"); ?>
    <?php require_once("sidebar_down.php"); ?>
</aside>

<?php include("includes/footer.php")?>