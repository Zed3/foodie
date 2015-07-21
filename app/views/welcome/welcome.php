<?php

use Core\Language;

?>

<div class="page-header">
	<h1><?php echo $data['title'] ?></h1>
</div>

<p><?php echo $data['welcome_message'] ?></p>

<a class="btn btn-md btn-success" href="<?php echo DIR;?>subpage">
	<?php echo Language::show('open_subpage', 'Welcome'); ?>
</a>


<table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>שם המנה</th>
                <th>תיאור</th>
                <th>מחיר</th>
                <th>מסעדה</th>
            </tr>
        </thead>

        <tfoot>
            <tr>
                <th>שם המנה</th>
                <th>תיאור</th>
                <th>מחיר</th>
                <th>מסעדה</th>
            </tr>
        </tfoot>
    </table>
