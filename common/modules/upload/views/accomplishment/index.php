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


<div class="panel panel-primary">
	<div class="panel-heading">
		<?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Back to GAD Accomplishment Report', ['/report/gad-accomplishment-report/index','ruc' => $ruc, 'onstep' => $onstep, 'tocreate' => $tocreate],['class' => 'btn btn-default btn-md', 'style' => '']); ?>
		<h4>Upload Excel File for Accomplishment Report</h4>
		<?= Html::a('<span class="glyphicon glyphicon-export"></span> Download Excel Template', ['download-template'],['class' => 'btn btn-success btn-md pull-right', 'style' => 'margin-top:-35px;']); ?>
	</div>
	<div class="panel-body">
		<?= $this->render('_upload_form', [
		        'model' => $model,
		        'ruc' => $ruc,
		        'onstep' => $onstep,
		        'tocreate' => $tocreate
		]) ?>
	</div>
</div>

<?php if(!empty($excelData)){ 
	// print_r($excelData); exit;
	?>
	<div class="panel panel-success">
		<div class="panel-heading">
			<h4>Data Preview</h4>
			<?php
				echo Html::a('<span class="glyphicon glyphicon-save"></span> Save Excel Data', 
					[
						'save-excel-data', 'ruc' => $ruc, 'onstep' => $onstep, 'tocreate' => $tocreate
					], 
	           		[
	           			'class' => 'btn btn-md btn-success pull-right', 
	           			'style' => 'margin-top:-35px;',
	           			'data' => ['confirm' => 'Are you sure you want to save this data?','method' => 'post']
		         	]);
			?>
		</div>
		<div class="panel-body">
			<div class="table-responsive" style="overflow-y: scroll; height: 700px;">
				<table class="table table-bordered data_preview table-hover">
					<thead>
						<tr>
							<th style="border-bottom: none; background-color: yellow;">1 = Client-Focused or 2 = Organization-Focused (Choose 1 )</th>
							<th style="border-bottom: none; background-color:yellow;">1 = Gender Issue or 2 = GAD Mandate (Choose 1 )</th>
							<th style="border-bottom: none; background-color: #7e57b1; color: white;">Gender Issue or GAD Mandate (Title/Description)</th>
							<th style="border-bottom: none; background-color: yellow;">Supporting Statistics Data</th>
							<th style="border-bottom: none; background-color: yellow;">Source</th>
							<th style="border-bottom: none; background-color: yellow;">PPA Sectors</th>
							<th style="border-bottom: none; background-color: #7e57b1; color: white;">GAD Objective</th>
							<th style="border-bottom: none; background-color: #7e57b1; color: white;">Relevant LGU Program or Project</th>
							<th style="border-bottom: none; background-color: yellow;">Activity Category</th>
							<th style="border-bottom: none; background-color: #7e57b1; color: white;">GAD Activity</th>
							<th style="border-bottom: none; background-color: #7e57b1; color: white;">Performance Indicator and Target</th>
							<th style="background-color: #7e57b1; color: white;">Actual Results</th>
							<th style="background-color: #7e57b1; color: white;">Approved GAD Budget</th>
							<th style="background-color: #7e57b1; color: white;">Actual Cost or Expenditure</th>
							<th style="border-bottom: none; background-color: #7e57b1; color: white;">Variance or Remarks</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach ($excelData as $row) {
								echo '<tr>';
							  	echo 	'<td style="text-align:center;">' . $row[0] . '</td>';
							  	echo 	'<td style="text-align:center;">' . $row[1] . '</td>';
							  	echo 	'<td style="white-space:pre-line;">' . $row[2] . '</td>';
							  	echo 	'<td>' . $row[3] . '</td>';
							  	echo 	'<td>' . $row[4] . '</td>';
							  	echo 	'<td style="text-align:center;">' . $row[5] . '</td>';
							  	echo 	'<td style="white-space:pre-line;">' . $row[6] . '</td>';
							  	echo 	'<td style="white-space:pre-line;">' . $row[7] . '</td>';
							  	echo 	'<td style="text-align:center;">' . $row[8] . '</td>';
							  	echo 	'<td style="white-space:pre-line;">' . $row[9] . '</td>';
							  	echo 	'<td style="white-space:pre-line;">' . $row[10] . '</td>';
							  	echo 	'<td style="white-space:pre-line;">' . $row[11] . '</td>';
							  	echo 	'<td style="text-align:right;">' . number_format($row[12],2) . '</td>';
							  	echo 	'<td style="text-align:right;">' . number_format($row[13],2) . '</td>';
							  	echo 	'<td>' . $row[14] . '</td>';
							  	echo '</tr>';
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<br/><br/>
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


