<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3>Upload Excel File for GAD Plan and Budget</h3>
	</div>
	<div class="panel-body">
		<?= $this->render('_upload_form', [
		        'model' => $model
		]) ?>
	</div>
</div>

<table>
<?php
	foreach ($excelData as $row) {
		echo '<tr>';
	  	echo 	'<td>' . $row[0] . '</td>';
	  	echo 	'<td>' . $row[1] . '</td>';
	  	echo '</tr>';
	}
?>


