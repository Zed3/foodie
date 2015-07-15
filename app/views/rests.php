<?php

use Core\Language;

?>

<div class="page-header">
  <h1><?php echo $data['title']; ?></h1>
</div>
<?php
  if ($data['rests']) {
    foreach($data['rests'] as $row){
    	echo "<div class='rest_box'/>";
    	echo "<a href='" . DIR . "rests/$row->rest_id' class='btn'>";
      	echo "<img src='$row->rest_logo' class='img-thumbnail' alt='$row->rest_name' />";
      	echo "$row->rest_name";
    	echo "</a>";
    	echo "</div>";
    }
  }
?>