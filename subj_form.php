
<p>Nazwa strony:<input type="text" name="menu_name"
value="<?php echo $sel_subject['menu_name']; ?>" id="menu_name" />
</p>


<p>Strona ma być widoczna dla wszystkich:
	<input type="radio" name="visible" value="0"<?php 
	if ($sel_subject['visible'] == 0) { echo " checked"; }
	?> /> Nie
	&nbsp;
	<input type="radio" name="visible" value="1"<?php 
	if ($sel_subject['visible'] == 1) { echo " checked"; }
	?> /> Tak
</p>
