<?php

function redirect_to( $location = NULL ) {
    if ($location != NULL) {
        header("Location: {$location}");
        exit;
    }
}

function strip_zeros_from_date( $marked_string="" ) {

  $no_zeros = str_replace('*0', '', $marked_string);
  $cleaned_string = str_replace('*', '', $no_zeros);
  return $cleaned_string;
}

function output_message($message="") {
  if (!empty($message)) { 
    return "<p class=\"message\">{$message}</p>";
  } else {
    return "";
  }
}

function log_action($action, $message="") {
	$logfile = 'logs/log.txt';
	$new = file_exists($logfile) ? false : true;
  if($handle = fopen($logfile, 'a')) { // append
    $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
		$content = "{$timestamp} | {$action}: {$message}\n";
    fwrite($handle, $content);
    fclose($handle);
    if($new) { chmod($logfile, 0755); }
  } else {
    echo "Could not open log file for writing.";
  }
}

function datetime_to_text($datetime="") {
  $unixdatetime = strtotime($datetime);
  return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
}




function checkEmail($str)
{
    return preg_match("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $str);
}


function mysql_prep( $value ) {
    $magic_quotes_active = get_magic_quotes_gpc();
    $new_enough_php = function_exists( "mysql_real_escape_string" ); // i.e. PHP >= v4.3.0
    if( $new_enough_php ) { // PHP v4.3.0 or higher
// undo any magic quote effects so mysql_real_escape_string can do the work
        if( $magic_quotes_active ) { $value = stripslashes( $value ); }
        $value = mysql_real_escape_string( $value );
    } else { // before PHP v4.3.0
// if magic quotes aren't already on then add slashes manually
        if( !$magic_quotes_active ) { $value = addslashes( $value ); }
// if magic quotes are active, then the slashes already exist
    }
    return $value;
}


function confirm_query($result_set) {
    if (!$result_set) {
        die("Database query failed: " . mysql_error());
    }
}

function get_all_subjects($public = true) {
    global $connection;
    $query = "SELECT *
FROM subjects ";
    if ($public) {
        $query .= "WHERE visible = 1 ";
    }

    $subject_set = mysql_query($query, $connection);
    confirm_query($subject_set);
    return $subject_set;
}

function get_all_users() {
    global $connection;
    global $users_set;
    $query = "SELECT *
FROM users";

    $users_set = mysql_query($query, $connection);
    confirm_query($users_set);
    return $users_set;
}

function get_pages_for_subject($subject_id, $public = true) {
    global $connection;
    $query = "SELECT *
FROM pages ";
    $query .= "WHERE subject_id = {$subject_id} ";


    $page_set = mysql_query($query, $connection);
    confirm_query($page_set);
    return $page_set;
}

function get_article_for_subject($subject_id,$public = true) {
    global $connection;
    $query = "SELECT *
FROM article ";
    $query .= "WHERE subject_id = {$subject_id} ";
    $query .= "ORDER BY data_dodania DESC";

    $article_set = mysql_query($query, $connection);
    confirm_query($article_set);
    return $article_set;
}

function get_subject_by_id($subject_id) {
    global $connection;
    $query = "SELECT * ";
    $query .= "FROM subjects ";
    $query .= "WHERE id=" . $subject_id ." ";
    $query .= "LIMIT 1";
    $result_set = mysql_query($query, $connection);
    confirm_query($result_set);
// REMEMBER:
// if no rows are returned, fetch_array will return false
    if ($subject = mysql_fetch_array($result_set)) {
        return $subject;
    } else {
        return NULL;
    }
}

function get_article_by_id($subject_id) {
    global $connection;
    $query = "SELECT * ";
    $query .= "FROM article ";
    $query .= "WHERE id=" . $subject_id ." ";
    $query .= "LIMIT 1";
    $result_set = mysql_query($query, $connection);
    confirm_query($result_set);
// REMEMBER:
// if no rows are returned, fetch_array will return false
    if ($articles = mysql_fetch_array($result_set)) {
        return $articles;
    } else {
        return NULL;
    }
}

function get_page_by_id($page_id) {
    global $connection;
    $query = "SELECT * ";
    $query .= "FROM pages ";
    $query .= "WHERE id=" . $page_id ." ";
    $query .= "LIMIT 1";
    $result_set = mysql_query($query, $connection);
    confirm_query($result_set);
// REMEMBER:
// if no rows are returned, fetch_array will return false
    if ($page = mysql_fetch_array($result_set)) {
        return $page;
    } else {
        return NULL;
    }
}

function get_default_page($subject_id) {
// Get all visible pages
    $page_set = get_pages_for_subject($subject_id, true);
    if ($first_page = mysql_fetch_array($page_set)) {
        return $first_page;
    } else {
        return NULL;
    }
}
function get_default_article($subject_id) {
// Get all visible article
    $page_set = get_article_for_subject($subject_id, true);
    if ($first_page = mysql_fetch_array($page_set)) {
        return $first_page;
    } else {
        return NULL;
    }
}


function find_selected_page() {
    global $sel_subject;
    global $sel_page;
    global $sel_article;
    if (isset($_GET['subj'])) {
        $sel_subject = get_subject_by_id($_GET['subj']);
        $sel_page = get_default_page($sel_subject['id']);
        $sel_article = get_default_article($sel_subject['id']);
    } elseif (isset($_GET['page'])) {
        $sel_subject = NULL;
        $sel_page = get_page_by_id($_GET['page']);
    }  elseif (isset($_GET['article'])) {
        $sel_subject = NULL;
        $sel_article = get_article_by_id($_GET['article']);
    }else {
        $sel_subject = NULL;
        $sel_page = NULL;
    }
}

function navigation($sel_subject, $sel_page,$public = false) {

    $subject_set = get_all_subjects($public);
    while ($subject = mysql_fetch_array($subject_set)) {
        $output .= "<li id=\"create_article.php?subj=" . urlencode($subject["id"])."\">";
        $output .= "<a href=\"create_article.php?subj=" . urlencode($subject["id"])."\" style=\"color:white;  text-decoration:none;\">
{$subject["menu_name"]}</a><div class=\"dropdown_1column\"><div class =\"box\">";

        $page_set = get_pages_for_subject($subject["id"], $public);
        while ($page = mysql_fetch_array($page_set)) {
            $output .= "<div class=\"menu_dropdown\">";
            $output .= "<a href=\"edit_page.php?page=" . urlencode($page["id"])."\"" .">
            <div class=\"tytul_podstrony\">{$page["menu_name"]}</div></a>

            <div class=\"ikona\">
                <a href=\"edit_page.php?page=" . urlencode($page["id"])."\"" .
                "class=\"edit_button\" id=\"edit-".$page["id"]."\">
                <img src=\"images/icon_edit.png\"/></a>

                <a href=\"#\" class=\"del_button\" id=\"del-".$page["id"]."\">
                <img src=\"images/icon_del.png\"/></a>
            </div>

        </div>";
        }

        $output .= "</div></div>";
        $output .= "</li>";
    }

    $output .=" <form class=\"okno\" style=\"float:right;\"><input type=\"text\"
                                        name=\"okno_dodania_subjects\" id=\"subjectsText\" class=\"o add_button_subjects\" placeholder=\"Dodaj nową stronę\" >
</form>";
    return $output;
}

function public_navigation($sel_subject, $sel_page, $public = true) {

    $subject_set = get_all_subjects($public);
    while ($subject = mysql_fetch_array($subject_set)) {
        $output .= "<li id=\"content.php?subj=" . urlencode($subject["id"])."\">";

        $output .= "<a href=\"content.php?subj=" . urlencode($subject["id"])."\" style=\"color:white;  text-decoration:none;\">
{$subject["menu_name"]}</a><div class=\"dropdown_1column\"><div class =\"box\">";

        $page_set = get_pages_for_subject($subject["id"], $public);
        while ($page = mysql_fetch_array($page_set)) {
            $output .= "<div class=\"menu_dropdown\">";
            $output .= "<a href=\"content.php?page=" . urlencode($page["id"])."\"" .">
            <div class=\"tytul_podstrony\">{$page["menu_name"]}</div></a>
        </div>";
        }$output .= "</div></div>";
        $output .= "</li>";
    }


    return $output;
}


function articles($sel_subject, $sel_page,$public = false){

    $subject_set = get_all_subjects($public);
    while ($subject = mysql_fetch_array($subject_set)) {
        $article_set = get_article_for_subject($subject["id"], $public);

        while ($article = mysql_fetch_array($article_set)) {
            if($article["subject_id"]==$sel_subject["id"]){
                $output .= "<div id=\"article_".$article["id"]."\">";
                $output .= "<input id=".$article["id"]."+".$article["title"]." name=\"article\" type=\"checkbox\"  />";
                $output .= "<label for=".$article["id"]."+".$article["title"]."><div class=\"panel\"><div class=\"title\">{$article["title"]}</div>";
                $output .= "<div style=\"font-size:10px; color:#333;\" align=\"right\" >{$article["data_dodania"]}</div></div></label>";
                $output .= "<article class=\"ac-small\">";
                $output .= "{$article["text"]}" ;
                $output .= "<a href=edit_articles.php?article=".urlencode($article["id"])."><button>Edycja</button></a>";
                $output .= "<a href=\"#\" class=\"del_button_article\" id=\"del-".$article["id"]."\">Usuń artykuł</a>";

                $output .= "</article>";

                $output .= "</div>";

            }
        }
    }
    return $output;
}



function public_articles($sel_subject, $sel_page,$public = true){

    $subject_set = get_all_subjects($public);
    while ($subject = mysql_fetch_array($subject_set)) {
        $article_set = get_article_for_subject($subject["id"], $public);

        while ($article = mysql_fetch_array($article_set)) {
            if($article["subject_id"]==$sel_subject["id"]){
                $output .= "<div>";
                $output .= "<input id=".$article["id"]."+".$article["title"]." name=\"article\" type=\"checkbox\"  />";
                $output .= "<label for=".$article["id"]."+".$article["title"]."><div class=\"panel\"><div class=\"title\">{$article["title"]}</div>";
                $output .= "<div style=\"font-size:10px; color:#333;\" align=\"right\" >{$article["data_dodania"]}</div></div></label>";
                $output .= "<article class=\"ac-small\">";
                $output .= "{$article["text"]}" ;

                $output .= "</article>";

                $output .= "</div>";

            }
        }
    }
    return $output;
}




function users($users_set){
    $users_set = get_all_users();
    while ($users = mysql_fetch_array($users_set)){
        if($users["wait"]==0){
            $output .= "<li id=\"item_".$users["id"]."\"><a href=\"edit_user.php?id=".$users["id"]."\">".$users["username"]."</a>";
            $output .= "<div style=\"width:25px;
                                float:left;\">";
            $output .= "<a href=\"#\" class=\"add_user\" id=\"add-".$users["id"]."\"><img src=\"images/icon_add.png\"/></a>";
            $output .= "</div>";
            $output .= "</li>";
        }
    }
    return $output;
}


function view(){
    global $result;
    global $connection;
    $query = "SELECT text from pages WHERE id='0' OR subject_id='0'";
    $result = mysql_query($query,$connection);
    while($row=mysql_fetch_array($result))
    {echo $row["text"];}
}

?>