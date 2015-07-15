<?php

use Core\Language;

?>

<div class="page-header">
  <h1><?php echo $data['title']; ?></h1>
</div>
<?php
	switch (sizeof($data['results'])) {
		case 0:
			$string = "לא נמצאו תוצאות";
		break;

		case 1:
			$string = "נמצאה תוצאה אחת";
		break;

		default:
			$string = "נמצאו " . sizeof($data['results']) . " תוצאות";

	}
	echo "<h3>$string עבור \"" . $data['keyword'] ."\"</h3>";

  if ($data['results']) {
  	echo "
		<table id='dishes-table1' class='table table-hover table-striped'>
			<thead>
				<tr>
					<td>שם המנה</td>
					<td>מחיר</td>
					<td>שם המסעדה</td>
				</tr>
			</thead>
			<tbody>
  	";
    foreach($data['results'] as $row){
      echo "<tr>";
      // echo "<td>";
      // if ($row->dish_image) echo "<a href='$row->dish_image' title='$row->dish_title' data-gallery><img class='img-thumbnail dish_image' src='$row->dish_image' /></a>";
      // echo "</td>";
      echo "<td>$row->dish_title";
      if ($row->dish_desc) echo " - $row->dish_desc";
      if ($row->dish_image) echo "<a href='$row->dish_image' title='$row->dish_title' data-gallery> <span class='glyphicon glyphicon-camera'> </span</a>";
      echo "</td>";
      echo "<td>$row->dish_price</td>";
      echo "<td><a href='" . DIR . "rest/$row->rest_id'>$row->rest_name</a></td>";
      echo "</tr>";
    }
    echo "
			</tbody>
		</table>
    ";
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