<?php

use Core\Language;

?>

<div class="page-header">
  <h1><?php echo $data['title'] ?></h1>
  <p><?php echo $data['rest'][0]->rest_address; ?></p>
</div>
<?php
  if ($data['dishes']) {
    foreach($data['dishes'] as $row){
      $dish_price = number_format($row->dish_price,2);
      echo "<div class='row'>";
      echo "<div class='col-md-9'>";
      echo "<h3>$row->dish_title</h3>";
      echo "<p>$row->dish_desc</p>";
      echo "<div>$dish_price</div>";
      echo "</div>";
      if ($row->dish_image) echo "<a href='$row->dish_image' title='$row->dish_title' data-gallery><img class='img-thumbnail dish_image' src='$row->dish_image' /></a>";
      echo "</div>";
    }
  }
?>

<table id='dishes-table' class='table table-hover table-striped'>
  <thead>
    <tr><th>שם</th><th>תיאור</th><th>מחיר</th><th>תמונה</th></tr>
  </thead>
  <?php
  if ($data['dishes']) {
    foreach($data['dishes'] as $row){
      echo "<tr>";
      echo "<td>$row->dish_title</td>";
      echo "<td>$row->dish_desc</td>";
      echo "<td>$row->dish_price</td>";
      echo "<td>";
      if ($row->dish_image) echo "<a href='$row->dish_image' title='$row->dish_title' data-gallery><img class='img-thumbnail dish_image' src='$row->dish_image' /></a>";
      echo "</td>";
      echo "</tr>";
    }
  }
?>
</table>

<!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
<div id="blueimp-gallery" class="blueimp-gallery" >
    <!-- The container for the modal slides -->
    <div class="slides"></div>
    <!-- Controls for the borderless lightbox -->
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
    <!-- The modal dialog, which will be used to wrap the lightbox content -->
    <div class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body next"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left prev">
                        <i class="glyphicon glyphicon-chevron-left"></i>
                        Previous
                    </button>
                    <button type="button" class="btn btn-primary next">
                        Next
                        <i class="glyphicon glyphicon-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>