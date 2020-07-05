
<section class="sidebar_down">
<?php
    if(!logged_in_admin())
    {
    echo "<h4 class=\"widgettitle\">Pomocne linki</h4>";
        ?>
<li><a href="http://transportoweprawo.pl/akty-prawne/przepisy-krajowe">Polskie prawo transportowe</a></li>
     <li>  <a href="http://www.portal-transportowy.pl/ciekawostki-ze-swiata-transportu/">Ciekawostki transportowe</a></li>
        
  <?  }
  elseif(logged_in_admin())
    {
    if(users($users) != ""){echo "<h4 class=\"widgettitle\">Dodaj użytkowników</h4><ul>";
    echo users($users_set);
    echo "</ul>";}
        echo "<h4 class=\"widgettitle\"><a href=\"lista_uzytkownikow.php\">Lista użytkowników</a></h4>";
        echo "<h4 class=\"widgettitle\"><a href=\"logfile.php\">Logi systemu</a></h4>";

        ?>
        <h4 class=\"widgettitle\">Pomocne linki</h4>
        <l<li><a href="http://transportoweprawo.pl/akty-prawne/przepisy-krajowe">Polskie prawo transportowe</a></li>
        <<li>  <a href="http://www.portal-transportowy.pl/ciekawostki-ze-swiata-transportu/">Ciekawostki transportowe</a></li>
    
    <?php
    }?>


		</section>