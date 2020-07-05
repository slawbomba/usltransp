
<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php find_selected_page(); ?>
<?php require_once("includes/header.php"); ?>


<div id="content">  <section class="artykul">
				  <?php
                      if(!logged_in_admin() && !logged_in_users())
                      {
                       if($sel_subject["id"]!='')  echo public_articles($sel_subject, $sel_article, $public = true);
                       else echo $sel_page["text"];
                      }
                      else if(logged_in_admin())
                      {
                      if($sel_subject["id"]!='')    echo articles($sel_subject, $sel_article, $public = false);
                       else echo $sel_page["text"];
                      }
                      else if(logged_in_users())
                      {
                          if($sel_subject["id"]!='')    echo public_articles($sel_subject, $sel_article, $public = false);
                          else echo $sel_page["text"];
                      }?>
				 </section>
                                                                   			</div>

	
	
	<aside id="sidebar">
<?php require_once("sidebar_up.php"); ?>
<?php require_once("sidebar_down.php"); ?>

<?php include("includes/footer.php")?>
    </aside>