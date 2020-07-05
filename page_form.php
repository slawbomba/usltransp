
<p>Nazwa strony: <input type="text" name="menu_name"
value="<?php echo $sel_page['menu_name']; ?>" id="menu_name" />
</p>

<p>Pozycja :
<select name="subject_id">
	<?php

		$subject_set = get_all_subjects($public);
		while ($subject = mysql_fetch_array($subject_set)) {
		echo "<option value=\"{$subject['id']}\"";
		if ($sel_page['subject_id'] == $subject['id']) { echo " selected"; }
		echo "> {$subject['menu_name']} </option>";
		}
	?>
	</select></p>

	<p>Treść:<br />
 <textarea name="text" class="jqte-test" rows="20" cols="80"><?php echo $sel_page['text']; ?></textarea>
    </p>