<section class="sidebar_up">
			<?php if(!logged_in_admin() && !logged_in_users()){ ?><h4 class="widgettitle">Zaloguj się</h4><?php }
            if(logged_in_admin()){?> <h4 class="widgettitle">Jesteś zalogowany jako ADMINISTRATOR </h4><a href="logout.php">Wyloguj</a><?php }
            if(logged_in_users()){?>
                <h4 class="widgettitle">Jesteś zalogowany jako </h4><h2><?php echo $_SESSION['users.username'];?></h2> <a href="logout.php">Wyloguj</a> <?php } ?>




    <?php		 if(!logged_in_admin() && !logged_in_users()) {?>
<div>
   <input type="radio" name="choose" id="login" checked="checked"/> Mam już konto <br />
   <input type="radio" name="choose" id="signup" /> Załóż konto
</div>

<form method="post" action="login.php">
<div id="login_block">
<label>Nazwa użytkownika</label>
   <div class="okno"><input type="text" name="username" class="o" autocomplete="off"/></div>
   <label><br />
     <br />
     Hasło</label>
    <div class="okno"><input type="password" name="hashed_password" class="o"/></div>
<div class="button">
  <p>&nbsp;</p>
  <button type="submit" name="Zaloguj">Zaloguj</button></div>
</div></form>


<form method="post" action="register.php">
<div id="signup_block" style="display:none">
  <label>Nazwa użytkownika</label>
   <div class="okno"> <input type="text" name="username_check" id="username_check" class="o"/></div>
<label><br />
  <br />
  Adres email</label>
   <div class="okno"> <input type="text" name="email" id="email" class="o"/></div>
   <label><br />
     <br />
     Hasło</label>
    <div class="okno"><input type="password" name="hashed_password" id="hashed_password" class="o"/></div>
   <div class="button">
     <p>&nbsp;</p>
     <button type="submit" name="Zarejestruj" id="Zarejestruj">Zarejestruj</button></div>
</div></form>
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
		
		</section>