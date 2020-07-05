<?php require_once('includes/initialize.php');?>
<?php

$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 10;
$total_count = Photograph::count_all();
$pagination = new Pagination($page, $per_page, $total_count);
$sql = "SELECT * FROM photographs ";
$sql .= "LIMIT {$per_page} ";
$sql .= "OFFSET {$pagination->offset()}";
$photos = Photograph::find_by_sql($sql);

?>

<?php require_once("includes/header.php"); ?>

<div id="content">

<?php foreach($photos as $photo): ?>
    <div style="float: left; margin-left: 30px; ">
        <a href="photo.php?id=<?php echo $photo->id; ?>">

            <img src="gallery/<?php echo $photo->filename; ?>" width="250" />
        </a>
        <p><?php echo $photo->caption; ?></p>
    </div>
<?php endforeach; ?>

<div id="pagination" style="clear: both;">
    <?php
    if($pagination->total_pages() > 1) {

        if($pagination->has_previous_page()) {
            echo "<a href=\"gallery.php?page=";
            echo $pagination->previous_page();
            echo "\">&laquo; Previous</a> ";
        }

        for($i=1; $i <= $pagination->total_pages(); $i++) {
            if($i == $page) {
                echo " <span class=\"selected\">{$i}</span> ";
            } else {
                echo " <a href=\"gallery.php?page={$i}\">{$i}</a> ";
            }
        }

        if($pagination->has_next_page()) {
            echo " <a href=\"gallery.php?page=";
            echo $pagination->next_page();
            echo "\">Next &raquo;</a> ";
        }
    }

    ?>
    </div>
</div>
<aside id="sidebar">
    <?php require_once("sidebar_up.php"); ?>
    <?php require_once("sidebar_down.php"); ?>

    <?php include("includes/footer.php")?>
</aside>