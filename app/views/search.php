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
    <label for="dish_title" class="col-sm-2 control-label">שם המנה</label>
    <div class="col-sm-4">
      <input class="form-control" id="dish_title" name="dish_title" value="<?php if(isset($_REQUEST['dish_title'])){ echo $_REQUEST['dish_title']; }?>">
    </div>
  </div>
  <div class="form-group">
    <label for="price_from" class="col-sm-2 control-label">מחיר</label>
    <div class="col-sm-2">
      <input class="form-control" id="price_from"  name="price_from" value="<?php if(isset($_REQUEST['price_from'])){ echo $_REQUEST['price_from']; }?>">
    </div>
    <div class="col-sm-2">
      <input class="form-control" id="price_to"  name="price_to" value="<?php if(isset($_REQUEST['price_to'])){ echo $_REQUEST['price_to']; }?>">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div class="checkbox">
        <label>
          <input type="checkbox" name="is_kosher" <?php if($_REQUEST['is_kosher']){ echo ' checked '; }?>> מסעדה כשרה
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div class="checkbox">
        <label>
          <input type="checkbox" name="dish_image" <?php if($_REQUEST['dish_image']){ echo ' checked '; }?>> מנות עם תמונות בלבד
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default" name="submit">חיפוש</button>
    </div>
  </div>
</form>