<?php require_once('includes/initialize.php');?>
<?php
if(empty($_GET['id'])) {
    $session->message("Brak dostepu");
    redirect_to('index.php');
}

$photo = Photograph::find_by_id($_GET['id']);
if(!$photo) {
    $session->message("Zdjecie nie zostalo odnalezione");
    redirect_to('index.php');
}

if(isset($_POST['submit'])) {
    $autor = trim($_POST['autor']);
    $text = trim($_POST['text']);

    $new_comment = Comment::make($photo->id, $autor, $text);
    if($new_comment && $new_comment->save()) {
        $new_comment->try_to_send_notification();
        redirect_to("photo.php?id={$photo->id}");

    } else {
        $message = "There was an error that prevented the comment from being saved.";
    }
} else {
    $autor = "";
    $text = "";
}

$comments = $photo->comments();

?>
<?php require_once('includes/header.php'); ?>

<div id="content">
<a href="gallery.php">&laquo; Wstecz</a><br />
<br />

<div style="margin-left: 20px;">
    <img src="gallery/<?php echo $photo->filename; ?>" />
    <p><?php echo $photo->caption; ?></p>
</div>

<div id="comments">
    <?php foreach($comments as $comment): ?>
        <div class="comment" style="margin-bottom: 2em;">
            <div class="autor">
                <b><?php echo htmlentities($comment->autor); ?></b>  napisał:
            </div>
            <div class="text">
                <?php echo strip_tags($comment->text, '<strong><em><p>'); ?>
            </div>
            <div class="meta-info" style="font-size: 0.8em;">
                <?php echo datetime_to_text($comment->data_dodania); ?>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if(empty($comments)) { echo " Brak komentarzy"; } ?>
</div>
<?php if(logged_in_users()){?>
<div id="comment-form">
    <h3>Nowy Komentarz</h3>

    <?php echo output_message($message); ?>
    <form action="photo.php?id=<?php echo $photo->id; ?>" method="post">
        <table>
            <tr>
                <td>Twoja nazwa:</td>
                <td><input type="text" name="autor"  value="<?php echo $autor; ?>" /></td>
            </tr>
            <tr>
                <td>Komentarz:</td>
                <td><textarea name="text" cols="40" rows="8"><?php echo $text; ?></textarea></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit" value="Dodaj komentarz" /></td>
            </tr>
        </table>
    </form>
</div>
<?php } ?>
</div>
<aside id="sidebar">
    <?php require_once("sidebar_up.php"); ?>
    <?php require_once("sidebar_down.php"); ?>
    <?php include("includes/footer.php")?>
</aside>