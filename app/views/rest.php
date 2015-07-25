<?php

use Core\Language;

?>

<div class="page-header">
  <h1><?php echo $data['title'] ?></h1>
  <p><?php echo $data['rest'][0]->rest_address; ?></p>
</div>
<?php
  if ($data['dishes']) {
    echo "<table class='table-hover'>";
    foreach($data['dishes'] as $row){
      $dish_price = number_format($row->dish_price,2);
      $dish_title = $row->dish_title;

      if ($data['fav_dishes'][$row->rest_id][$row->dish_id] == true) {
        //TODO: make this better, add ajax here
        // mark as fav
        $fav = '<span class="glyphicon glyphicon-heart heart" aria-hidden="true"></span>';
      } else {
        //show add to favs
        $fav = '<span class="glyphicon glyphicon-heart-empty" aria-hidden="true"></span>';
      }

      echo "<tr class='rest-dish'>";
      echo "<td class='title-desc'>
        <h3>$dish_title</h3>
        <p>$row->dish_desc</p>
      </td>";
      echo "<td class='price'>$dish_price</td>";
      echo "<td class='fav'>$fav</td>";

      if ($row->dish_image) echo "<td><a href='$row->dish_image' title='$row->dish_title' data-gallery><img class='img-thumbnail dish_image' src='$row->dish_image' /></a></td>";
      echo "</tr>";
    }
    echo "</table>";
  }
?>

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