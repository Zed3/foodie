<?php
	use Core\Language;
?>

<div class="page-header">
	<h1><?php echo $data['title'] ?></h1>
</div>

<p><?php echo $data['welcome_message'] ?></p>

<?php
      //parse data
      foreach ($data['restaurants'] as $rest) {
      	if (rand(0,15)) continue;
        if ($rest->PoolSumNumber || 0==0) {
        	echo "<div class='row'>";
          echo "<a class='btn btn-default' href='#' role='button'>";
          echo "<img src='$rest->RestaurantLogoUrl' class='img-thumbnail' alt='$row->rest_name' />";
          echo "<p>";
          echo "$rest->rest_id $rest->RestaurantName $rest->PoolSumNumber";
          echo "</p>";
          if ($rest->avg_delivery) echo "<p>זמן הגעה ממוצע: $rest->avg_delivery</p>";
          echo "</a>";
          	echo "</div>";
        }
      }
?>