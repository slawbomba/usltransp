
<?php require_once('includes/initialize.php');?>
<?php

session_name('login');
session_set_cookie_params(2*7*24*60*60);


include_once("includes/form_functions.php");

if (isset($_POST['Zaloguj'])) {
    $errors = array();

    if(!$_POST['username'] || !$_POST['hashed_password'])
        $errors[] = 'Oba pola musza zostac wpisane';

    if ( empty($errors) ) {

        $required_fields = array('username', 'hashed_password');
        $errors = array_merge($errors, check_required_fields($required_fields, $_POST));

        $fields_with_lengths = array('username' => 30, 'hashed_password' => 30);
        $errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));

        $username = trim(mysql_prep($_POST['username']));
        $hashed_password = sha1(trim(mysql_prep($_POST['hashed_password'])));


        $query = "SELECT users.id, users.username, users.wait FROM users WHERE username = '{$username}' AND hashed_password = '{$hashed_password}'  AND wait != '0' LIMIT 1";

        $result_set = mysql_query($query);

        confirm_query($result_set);

        if (mysql_num_rows($result_set) == 1) {

            $found_user = mysql_fetch_array($result_set);

            $_SESSION['users.id'] = $found_user['id'];
            $_SESSION['users.username'] = $found_user['username'];
            $_SESSION['users.wait'] = $found_user['wait'];
            log_action("Uzytkownik<b>", "{$found_user['username']} </b>zalogowal sie.");
        }

        else {
            $errors[]='Złe hasło lub nazwa użytkownika lub konto nie potwierdzone przez administratora';
        }
    }

    if($errors)
        $_SESSION['login-errors'] = implode('<br />',$errors);

    redirect_to("index.php");
    exit;
}


?>
