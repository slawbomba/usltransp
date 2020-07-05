<?php
require_once("initialize.php");?>


    <?php		 if(!logged_in_admin() && !logged_in_users()) {?>
    <div id="content">
        <form method="post" action="../login.php">
            <div id="login_block">
                <h4>Aby miec dostep musisz sie zalogowac</h4>
                <label>Nazwa uzytkownika</label>
                <div class="okno"><input type="text" name="username" class="o"/></div>
                <label><br />
                    <br />
                    Haslo</label>
                <div class="okno"><input type="password" name="hashed_password" class="o"/></div>
                <div class="button">
                    <p>&nbsp;</p>
                    <button type="submit" name="Zaloguj">Zaloguj</button></div>
            </div></form>
</div>

    <?php }?>

    <?php

    if($_SESSION['login-errors'])
    {
        echo '<div class="errors">'.$_SESSION['login-errors'].'</div>';
        unset($_SESSION['login-errors']);
    }
    else if($_SESSION['reg-errors'])
    {
        echo '<div class="errors">'.$_SESSION['reg-errors'].'</div>';
        unset($_SESSION['reg-errors']);
    }

    else if($_SESSION['reg-success'])
    {
        echo '<div class="success">'.$_SESSION['reg-success'].'</div>';
        unset($_SESSION['reg-success']);
    }
    ?>