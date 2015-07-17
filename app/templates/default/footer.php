<?php

use Helpers\Assets;
use Helpers\Url;
use Helpers\Hooks;

//initialise hooks
$hooks = Hooks::get();
?>

</div>

<!-- JS -->
<?php
Assets::js(array(
	Url::templatePath() . 'js/jquery.js',
	'//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js',
  '//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js',
  '//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.js',
  'https://code.jquery.com/ui/1.11.3/jquery-ui.min.js',
  '//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js',
  Url::templatePath() . 'js/site.js'
));

//hook for plugging in javascript
$hooks->run('js');

//hook for plugging in code into the footer
$hooks->run('footer');
?>

</body>
</html>
