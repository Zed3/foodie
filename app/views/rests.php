<?php

use Core\Language;

?>

<div class="page-header">
  <h1><?php echo $data['title']; ?></h1>
</div>
<table class='table table-hover table-striped'>
<?php
  if ($data['rests']) {
    foreach($data['rests'] as $row){
      echo "<tr>";
      echo "<td><a href='" . DIR . "rests/$row->rest_id'>$row->rest_name</a></td>";
      //echo "<td><img src='$row->rest_logo' class='img-thumbnail' alt='$row->rest_name' /></td>";
      echo "</tr>";
    }
  }
?>
</table>