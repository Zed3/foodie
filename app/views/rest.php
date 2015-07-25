<?php

use Core\Language;

?>

<div class="page-header">
  <img class='img-thumbnail rest_logo' src='<?php echo $data['rest'][0]->rest_logo; ?>' />
  <h1><?php echo $data['title'] ?></h1>
  <p><?php echo $data['rest'][0]->rest_address; ?></p>
</div>
<?php
  if ($data['dishes']) {
    $user_id = $data['user_id'];
    //TODO: fix this datatable
    echo "<table id='rest-dishes1' class='table-hover'>";
      echo "<thead>";
      echo "<tr><th></th><th></th><th></th><th></th></tr>";
      echo "</thead>";
    foreach($data['dishes'] as $row){
      $dish_price = number_format($row->dish_price,2);
      $dish_price = $row->dish_price;
      $dish_title = $row->dish_title;

      if ($data['user_id']) {
        if ($data['fav_dishes'][$row->rest_id][$row->dish_id] == true) {
          //TODO: make this better, add ajax here
          // mark as fav
          $fav = "<a href='#'  onclick='manage_favorite($row->rest_id, $row->dish_id)' title='לחץ כדי להסיר מנה זו מהמועדפים'><span class='glyphicon glyphicon-heart heart' aria-hidden='true'></span></a>";
        } else {
          //show add to favs
          $fav = "<a href='#'  onclick='manage_favorite($row->rest_id, $row->dish_id)' title='לחץ כדי להוסיף מנה זו למועדפים'><span class='glyphicon glyphicon-heart-empty' aria-hidden='true'></span></a>";
        }
      } else {
        $fav = "<a href='/login' title='לחץ כדי להוסיף מנה זו למועדפים'><span class='glyphicon glyphicon-heart-empty' aria-hidden='true'></span></a>";        
      }

      echo "<tr class='rest-dish'>";
      echo "<td class='title-desc'>
        <h3>$dish_title</h3>
        <p>$row->dish_desc</p>
      </td>";
      echo "<td class='price'>$dish_price</td>";
      echo "<td class='fav'>$fav</td>";

      echo "<td>";
      if ($row->dish_image) echo "<a href='$row->dish_image' title='$row->dish_title' data-gallery><img class='img-thumbnail dish_image' src='$row->dish_image' /></a>";
      echo "</td>";

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