<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php include("includes/header.php"); ?>
<?php confirm_logged();?>

<?php find_selected_page(); ?>

<div id="content">

	<section class="artykul">
<?php
echo "
        <textarea style=\"height:3%; width:100%;\" type=\"text\" name=\"nazwa\" id=\"add-".$sel_subject["id"]."\"
                  			class=\"contentText".$sel_subject["id"]." add_button_page o\"  placeholder=\"Dodaj nową podstronę\"></textarea>
";?>
    <div>

<input id="dodaj" name="article" type="radio" checked />
					<label for="dodaj"><div class="panel" >Dodaj nowy artykuł
                            </div></label>
					<article class="ac-small">
<textarea name="text" style="height:7%; width:100%;" class="contenttytul" placeholder="Wpisz tytuł"></textarea>
<textarea name="text" class="contenttext" ></textarea>
<script>

	$('.contenttext').jqte();
	var jqteStatus = true;

	$(".status").click(function()
	{
	if(jqteStatus){return false;}
	else {return true;}

		$('.contenttext').jqte({"status" : jqteStatus})
	});
</script>

<?php
 if($sel_subject["id"]!=''){
 echo "
 <button class=\"add_button_article_subj\" id=\"add-".$sel_subject["id"]."\">Dodaj artykuł</button><br /><br />
 <a href=\"edit_subj.php?subj=" . urlencode($sel_subject["id"])."\"" ."class=\"edit_button\" id=\"edit-".$sel_subject["id"]."\">Edytuj stronę</a><br />
 <a href=\"#\" class=\"del_button_subject\" id=\"del-".$sel_subject["id"]."\">Usuń stronę</a>
 ";
 }
 else{
echo "
<button class=\"add_button_article_page\" id=\"add-".$sel_page["id"]."\">Dodaj artykuł</button><br /><br />
<a href=\"edit_page.php?page=" . urlencode($sel_page["id"])."\"" ."class=\"edit_button\" id=\"edit-".$sel_page["id"]."\">Edytuj podstronę</a><br />
<a href=\"#\" class=\"del_button\" id=\"del-".$sel_page["id"]."\">Usuń podstronę</a>
";
}?>


</article>
				</div>

        <?php
        if(!logged_in_admin())
        {
            if($sel_subject["id"]!='')  echo public_articles($sel_subject, $sel_article);
            else echo $sel_page["text"];
        }
        else if(logged_in_admin())
        {
            if($sel_subject["id"]!='')    echo articles($sel_subject, $sel_article);
            else echo $sel_page["text"];
        }?>


    </section>
			</div>
	


	<aside id="sidebar">
<?php require_once("sidebar_up.php"); ?>
<?php require_once("sidebar_down.php"); ?>

<?php include("includes/footer.php")?>
    </aside>