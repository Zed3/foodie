<h3><?php echo $data["title"];?></h3>
<p>לא יודע מה להזמין? אל דאגה! אנחנו נבחר בשבילך...</p>
<div id="venues" style="float: right">
<?php
	foreach($data['random_dishes'] as $row){
		//echo  "<li><input id='venue-" . $row->dish_id . "' name='" . $row->dish_title . "' value='" . $row->dish_title . "' type='checkbox' checked='checked'>
			//<label for='venue-" . $row->dish_id . "'>" . $row->dish_title . "</label>
		//</li>";
		echo '<label class="checkbox">
		  <input checked type="checkbox" id="venue-' . $row->dish_id . '" value="' . $row->dish_title . '">' . $row->dish_title . '
		</label>';
	}
?>

</div>
<div id="wheel"  style="float: right">
<canvas id="canvas" width="800" height="600"></canvas>
</div>
<div id="stats">
<div id="counter"></div>
</div>
