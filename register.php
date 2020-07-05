<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php

session_name('register');
session_set_cookie_params(2*7*24*60*60); 



session_start();

include_once("includes/form_functions.php");
if (isset($_POST['Zarejestruj'])) { 


    $errors = array();

    if(strlen($_POST['username_check'])<3 || strlen($_POST['username_check'])>32)
    {
        $errors[]='Twoja nazwa użytkownika musi mieć od 3-32 znaków';
    }

    if(preg_match('/[^a-z0-9\-\_\.]+/i',$_POST['username_check']))
    {
        $errors[]='Taka nazwa użytkownika już istnieje';
    }

    if(!checkEmail($_POST['email']))
    {
        $errors[]='Źle wpisany adres e-mail';
    }


    if ( empty($errors) ) {

        $required_fields = array('username_check', 'hashed_password', 'email');
        $errors = array_merge($errors, check_required_fields($required_fields, $_POST));

        $fields_with_lengths = array('username_check' => 30, 'hashed_password' => 30);
        $errors = array_merge($errors, check_max_field_lengths($fields_with_lengths, $_POST));

        $username_check = trim(mysql_prep($_POST['username_check']));
        $email = trim(mysql_prep($_POST['email']));
        $hashed_password = sha1(trim(mysql_prep($_POST['hashed_password'])));


        $query = "INSERT INTO users(username,hashed_password,wait,email) VALUES('{$username_check}','{$hashed_password}', '0','{$email}')";


        $result_set = mysql_query($query, $connection);

        if ($result_set) {
            $_SESSION['reg-success']='Konto założone. O potwierdzeniu konta przez administratora zostaniesz poinformowany e-mailem';
        }
        else $errors[]='Podana nazwa użytkownika już istnieje';
    }

    if($errors)
        $_SESSION['reg-errors'] = implode('<br />',$errors);

    redirect_to("index.php");
    exit;
}

if(isset($_GET['logout']))
{
    $_SESSION = array();
    session_destroy();

    redirect_to("index.php");
    exit;
}

?>
