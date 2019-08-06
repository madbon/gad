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

<?= Html::a('<span class="glyphicon glyphicon-remove"></span> Cancel', ['training'], 
          ['class' => 'btn btn-sm btn-danger pull-left',
           'data' => ['confirm' => 'Are you sure you want to perform this action?','method' => 'post']
        ])?>

        <?= Html::a('<span class="glyphicon glyphicon-save"></span> Save', ['save-excel-data', 'hc' => $hris_id], 
          ['class' => 'btn btn-sm btn-success pull-right',
           'data' => ['confirm' => 'Are you sure you want to upload this data?','method' => 'post']
        ])?>


