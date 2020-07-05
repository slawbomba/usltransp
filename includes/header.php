<!doctype html>
<html>
<head>
<meta charset="utf-8">

<meta name="viewport" content="width=device-width; initial-scale=1.0">

<title>Osobowe Usługi Transportowe</title>

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/app2.js"></script>
<script type="text/javascript" src="js/jquery-te-1.4.0.min.js" charset="utf-8"></script>

<link href="stylesheet/style.css" rel="stylesheet" type="text/css">
<link href="stylesheet/article.css" rel="stylesheet" type="text/css">
<link href="stylesheet/media-queries.css" rel="stylesheet" type="text/css">
<link href="stylesheet/jquery-te-1.4.0.css" rel="stylesheet" type="text/css">

</head>

<body>

<div id="pagewrap">

	<header id="header">

<div id="pasek">
<div class="menu_pasek"><div class="logo"><a href="index.php"><img alt="" /></a></div></div>

<ul id="menu">
<ul id="navigation">

    <?php require_once('session.php'); require_once('connection.php');?>
<?php
if(!logged_in_admin() && !logged_in_users()){ echo public_navigation($sel_subject, $sel_page, $public = true); }
else if(logged_in_admin() ){echo navigation($sel_subject, $sel_page, $public = false); }
else if(logged_in_users() ){echo public_navigation($sel_subject, $sel_page, $public = false); }?>

    <li id="">
        <?php if(logged_in_admin()){ ?>
        <a href="list_photos.php" style="color:white;  text-decoration:none;">Galeria</a>
        <?php } else if(!logged_in_admin()){   ?>
        <a href="gallery.php" style="color:white;  text-decoration:none;">Galeria</a>
        <?php } ?>
    </li>
</ul>
    </ul> </div><
  </header>
