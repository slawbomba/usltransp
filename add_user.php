
<?php
require_once 'includes/initialize.php';


if(is_numeric($_POST['q1']) )
{

$idToAdd = filter_var($_POST['q1'],FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM users where id=".$idToAdd."";
    $users_set = mysql_query($query, $connection);

    while ($email = mysql_fetch_array($users_set)){
        $mail = new PHPMailer(true); 

        $mail->IsSMTP(); 
        try {
            $mail->Host       = "localhost"; 
            $mail->SMTPDebug  = 2;                    
            $mail->SMTPAuth   = true;                  
            $mail->SMTPSecure = "ssl";                 
            $mail->Host       = "smtp.gmail.com";      
            $mail->Port       = 465;                   
            $mail->Username   = "b0mb3lus@gmail.com";  
            $mail->Password   = "Chelsea1988@@";           
            $mail->AddAddress($email["email"], $email["username"]);
            $mail->SetFrom('b0mb3lus@gmail.com', 'Centrum Usług Osobowo-Transportowych');

            $mail->Subject = 'Usługi osobowo-transportowe - rejestracja';

            $mail->MsgHTML('Konto zostało potwierdzone prez administratora.
Możesz się zalogować.
Zapraszamy na <a href="">Strone usług osobowo-transportowych</a>');
            $mail->Send();
        } catch (phpmailerException $e) {
            echo $e->errorMessage();
            echo "Aby przejść na stronę główną kliknij<a href=\"index.php\"> tutaj</a>";
        } catch (Exception $e) {
            echo $e->getMessage();
            echo "Aby przejść na stronę główną kliknij<a href=\"index.php\"> tutaj</a>";
        }
        log_action('E-mail potwierdzajacy zostal wyslany na adres<b>', "{$email["username"]} </b>");
    }

	if(!mysql_query("UPDATE users SET wait='1' where id = ".$idToAdd.""))
	{
        header('HTTP/1.1 500 Błąd! Spróbuj później.');
		exit();
    }

}

?>