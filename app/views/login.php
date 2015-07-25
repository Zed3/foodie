<?php
	use Core\Language;	
?>

<div class="page-header">
	<h1><?php echo $data['title'] ?></h1>
</div>
<p><?php echo $data['welcome_message'] ?></p>
<?php echo \Core\Error::display($error); ?>
<form class="form-horizontal" method="POST">
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">שם משתמש</label>
    <div class="col-sm-10">
      <input type="username" class="form-control" id="inputEmail3" placeholder="Username" name="username">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">סיסמה</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="password">
    </div>
  </div>
<!--   <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div class="checkbox">
        <label>
          <input type="checkbox"> Remember me
        </label>
      </div>
    </div>
  </div> -->
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default" name="submit">התחבר</button>
    </div>
  </div>
</form>
<p><a href="<?php echo DIR;?>register">איך לך חשבון? הירשם כאן</a></p>