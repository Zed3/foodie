<?php
	use Core\Language;
?>

<div class="page-header">
	<h1><?php echo $data['title'] ?></h1>
</div>

<p><?php echo $data['welcome_message'] ?></p>

<?php
      //parse data
      if ($data['deliveries']) {
        foreach ($data['deliveries'] as $rest) {
        	echo "<div class='row'>";
          echo "<a class='btn btn-default' href='#' role='button'>";
          echo "<img src='$rest->rest_logo' class='img-thumbnail' alt='$row->rest_name' />";
          echo "<p>";
          echo "$rest->rest_id $rest->rest_name $rest->total_delivery";
          echo "</p>";
          if ($rest->avg_delivery) echo "<p>זמן הגעה ממוצע: $rest->avg_delivery</p>";
          echo "</a>";
        	echo "</div>";
        }
      } else {
        Url::redirect();
      }
?>