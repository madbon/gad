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
		<h4>Upload Excel File for GAD Plan and Budget</h4>
		<?= Html::a('<span class="glyphicon glyphicon-export"></span> Download Excel Template', ['download-template'],['class' => 'btn btn-success btn-md pull-right', 'style' => 'margin-top:-35px;']); ?>
	</div>
	<div class="panel-body">
		<?= $this->render('_upload_form', [
		        'model' => $model
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
			<div class="table-responsive">
				<table class="table table-bordered data_preview">
					<thead>
						<tr>
							<th style="border-bottom: none;">1 = Client-Focused or 2 = Organization-Focused (Choose 1 )</th>
							<th style="border-bottom: none;">1 = Gender Issue or 2 = GAD Mandate (Choose 1 )</th>
							<th style="border-bottom: none;">Gender Issue or GAD Mandate (Title/Description)</th>
							<th style="border-bottom: none;">Supporting Statistics Data</th>
							<th style="border-bottom: none;">Source</th>
							<th style="border-bottom: none;">PPA Sectors</th>
							<th style="border-bottom: none;">GAD Objective</th>
							<th style="border-bottom: none;">Relevant LGU Program or Project</th>
							<th style="border-bottom: none;">Activity Category</th>
							<th style="border-bottom: none;">GAD Activity</th>
							<th style="border-bottom: none;">Performance Indicator and Target</th>
							<th style="border-bottom: none;">Target Date of Implementation (START) <br/>(YYYY-MM-DD)</th>
							<th style="border-bottom: none;">Target Date of Implementation (END) <br/> (YYYY-MM-DD)</th>
							<th colspan="3">GAD Budget</th>
							<th style="border-bottom: none;">Lead or Responsible Office</th>
						</tr>
						<tr>
							<th style="border-top: none;"></th>
							<th style="border-top: none;"></th>
							<th style="border-top: none;"></th>
							<th style="border-top: none;"></th>
							<th style="border-top: none;"></th>
							<th style="border-top: none;"></th>
							<th style="border-top: none;"></th>
							<th style="border-top: none;"></th>
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
							  	echo 	'<td style="white-space:pre-line;">' . $row[2] . '</td>';
							  	echo 	'<td style="white-space:pre-line;">' . $row[3] . '</td>';
							  	echo 	'<td style="white-space:pre-line;">' . $row[4] . '</td>';
							  	echo 	'<td>' . $row[5] . '</td>';
							  	echo 	'<td style="white-space:pre-line;">' . $row[6] . '</td>';
							  	echo 	'<td style="white-space:pre-line;">' . $row[7] . '</td>';
							  	echo 	'<td>' . $row[8] . '</td>';
							  	echo 	'<td style="white-space:pre-line;">' . $row[9] . '</td>';
							  	echo 	'<td style="white-space:pre-line;">' . $row[10] . '</td>';
							  	echo 	'<td>' . $row[11] . '</td>';
							  	echo 	'<td>' . $row[12] . '</td>';
							  	echo 	'<td>' . number_format($row[13],2) . '</td>';
							  	echo 	'<td>' . number_format($row[14],2) . '</td>';
							  	echo 	'<td>' . (number_format($row[15],2)) . '</td>';
							  	echo 	'<td>' . $row[16] . '</td>';
							  	echo '</tr>';
							}
						?>
					</tbody>
				</table>
			</div>
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


