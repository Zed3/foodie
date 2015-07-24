<?php

use Helpers\Assets;
use Helpers\Url;
use Helpers\Hooks;

//initialise hooks
$hooks = Hooks::get();
?>
<!DOCTYPE html>
<html lang="<?php echo LANGUAGE_CODE; ?>">
<head>

	<!-- Site meta -->
	<meta charset="utf-8">
	<?php
	//hook for plugging in meta tags
	$hooks->run('meta');
	?>
	<title><?php echo $data['title'].' - '.SITETITLE; //SITETITLE defined in app/Core/Config.php ?></title>

	<!-- CSS -->
	<?php
	Assets::css(array(
		'//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css',
		'//cdn.datatables.net/plug-ins/1.10.7/integration/bootstrap/3/dataTables.bootstrap.css',
		'//blueimp.github.io/Gallery/css/blueimp-gallery.min.css',
    'https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css',
		Url::templatePath() . 'css/style.css',
	));

	//hook for plugging in css
	$hooks->run('css');
	?>

</head>
<body>
<?php
//hook for running code after body tag
$hooks->run('afterBody');
?>

<div class="container">

	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="<?php echo DIR;?>"><?php echo SITETITLE;?></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="<?php echo DIR;?>rests">מסעדות</a></li>
      </ul>
      <form class="navbar-form navbar-left" role="search" action="<?php echo DIR;?>search" method="">
        <div class="form-group">
          <input type="text" id="navbar-search" class="form-control" name='q' placeholder="Search" value="<?php if (isset($data['keyword'])) echo $data['keyword'];?>">
        </div>
        <button type="submit" class="btn btn-default">חיפוש</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
      	<li><a href="<?php echo DIR;?>logout">Logout</a></li>
      </ul>


    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>