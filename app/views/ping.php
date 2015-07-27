<?php
	use Core\Language,
      Helpers\Url;

?>

<div class="page-header">
	<h1><?php echo $data['title'] ?></h1>
</div>

<p><?php echo $data['welcome_message'] ?></p>

<?php
      //parse data
      if ($data['deliveries']) {
        echo "<table class='table-hover ping-table' ><tbody>";
        foreach ($data['deliveries'] as $rest) {
          echo "<tr onclick='report_delivery($rest->report_id)'>";
//          echo "<a class='btn btn-default' href='#' onclick='report_delivery($rest->report_id)' role='button'>";
          echo "<td><img src='$rest->rest_logo' class='img-thumbnail' alt='$row->rest_name' /></td>";
          echo "<td><h3>$rest->rest_name</h3></td>";
          echo "<td><h3>$rest->total_delivery</h3></td>";
          echo "<td>";
          if ($rest->avg_delivery) echo "זמן הגעה ממוצע: $rest->avg_delivery";
          echo "</td>";
//          echo "</a>";
          echo "</tr>";
        }
        echo "</tbody></table>";
      }
?>