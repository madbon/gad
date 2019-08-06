<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
?>
<style>
table.data_preview thead tr th
{
	text-align: center;
}
</style>
<div class="panel panel-default">
	<div class="panel-heading">
		Upload Excel File for GAD Plan and Budget
	</div>
	<div class="panel-body">
		<?= $this->render('_upload_form', [
		        'model' => $model
		]) ?>
	</div>
</div>

<?php if(!empty($excelData)){ ?>
	<div class="panel panel-warning">
		<div class="panel-heading">
			Data Preview
			<?php
				echo Html::a('<span class="glyphicon glyphicon-save"></span> Save', 
					[
						'save-excel-data'
					], 
	           		[
	           			'class' => 'btn btn-sm btn-success pull-right', 
	           			'style' => 'margin-top:-5px;',
	           			'data' => ['confirm' => 'Are you sure you want to save this data?','method' => 'post']
		         	]);
			?>
		</div>
		<div class="panel-body">
			<table class="table table-responsive table-bordered data_preview">
				<thead>
					<tr>
						<th style="border-bottom: none;">Gender Issue or GAD Mandate</th>
						<th style="border-bottom: none;">GAD Objective</th>
						<th style="border-bottom: none;">Relevant LGU Program or Project</th>
						<th style="border-bottom: none;">GAD Activity</th>
						<th style="border-bottom: none;">Performance Indicator and Target</th>
						<th colspan="3">GAD Budget</th>
						<th style="border-bottom: none;">Lead or Responsible Office</th>
					</tr>
					<tr>
						<th style="border-top: none;"></th>
						<th style="border-top: none;"></th>
						<th style="border-top: none;"></th>
						<th style="border-top: none;"></th>
						<th style="border-top: none;"></th>
						<th>MOOE</th>
						<th>PS</th>
						<th>CO</th>
						<th style="border-top: none;"></th>
					</tr>
				</thead>
				<tbody>
					<?php
						foreach ($excelData as $row) {
							echo '<tr>';
						  	echo 	'<td>' . $row[0] . '</td>';
						  	echo 	'<td>' . $row[1] . '</td>';
						  	echo 	'<td>' . $row[2] . '</td>';
						  	echo 	'<td>' . $row[3] . '</td>';
						  	echo 	'<td>' . $row[4] . '</td>';
						  	echo 	'<td>' . (number_format($row[5],2)) . '</td>';
						  	echo 	'<td>' . (number_format($row[6],2)) . '</td>';
						  	echo 	'<td>' . (number_format($row[7],2)) . '</td>';
						  	echo 	'<td>' . $row[8] . '</td>';
						  	echo '</tr>';
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
<?php } ?>
<?php 
// Html::a('<span class="glyphicon glyphicon-remove"></span> Cancel', ['index'], 
          // ['class' => 'btn btn-sm btn-danger pull-left',
          //  'data' => ['confirm' => 'Are you sure you want to perform this action?','method' => 'post']
        // ])
?>

        <?php
        //  Html::a('<span class="glyphicon glyphicon-save"></span> Save', ['save-excel-data', 'hc' => $hris_id], 
        //   ['class' => 'btn btn-sm btn-success pull-right',
        //    'data' => ['confirm' => 'Are you sure you want to upload this data?','method' => 'post']
        // ])
        ?>


