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
		
		<div class="row">
			<div class="col-sm-6">
				<h4>Upload Excel Data <b>(GAD Plan and Budget)</b></h4>
			</div>
			<div class="col-sm-6">
				<div class="btn-group pull-right">
				<?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Back to GAD Plan and Budget', ['/report/gad-plan-budget/index','ruc' => $ruc, 'onstep' => $onstep, 'tocreate' => $tocreate],['class' => 'btn btn-default btn-md', ]); ?>
				<?= Html::a('<span class="glyphicon glyphicon-save"></span> Download Excel Template', ['download-template'],['class' => 'btn btn-success btn-md']); ?>
				<?= Html::a('<span class="glyphicon glyphicon-refresh"></span> Reset', ['index', 'ruc' => $ruc, 'onstep' => $onstep, 'tocreate' => $tocreate],['class' => 'btn btn-default',]); ?>
			</div>
			</div>
		</div>
		
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
	<div class="panel panel-info">
		<div class="panel-heading">
			<h4>Data Preview</h4>
			<?php
				echo Html::a('<span class="glyphicon glyphicon-floppy-disk"></span> Save Excel Data', 
					[
						'save-excel-data', 'ruc' => $ruc, 'onstep' => $onstep, 'tocreate' => $tocreate
					], 
	           		[
	           			'class' => 'btn btn-md btn-primary pull-right', 
	           			'style' => 'margin-top:-35px;',
	           			'data' => ['confirm' => 'Are you sure you want to save this data?','method' => 'post']
		         	]);
			?>
		</div>
		<div class="panel-body">
			<div class="table-responsive" style="overflow-y: scroll; height: 700px;">
				<table class="table table-bordered data_preview">
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
							<th style="border-bottom: none; background-color: yellow;">Target Date of Implementation (START) <br/>(YYYY-MM-DD)</th>
							<th style="border-bottom: none; background-color: yellow;">Target Date of Implementation (END) <br/> (YYYY-MM-DD)</th>
							<th colspan="3" style="background-color: #7e57b1; color: white;">GAD Budget</th>
							<th style="border-bottom: none; background-color: #7e57b1; color: white;">Lead or Responsible Office</th>
						</tr>
						<tr>
							<th style="border-top: none; background-color: yellow;"></th>
							<th style="border-top: none; background-color: yellow;"></th>
							<th style="border-top: none; background-color: #7e57b1; color: white;"></th>
							<th style="border-top: none; background-color: yellow;"></th>
							<th style="border-top: none; background-color: yellow;"></th>
							<th style="border-top: none; background-color: yellow;"></th>
							<th style="border-top: none; background-color: #7e57b1; color: white;"></th>
							<th style="border-top: none; background-color: #7e57b1; color: white;"></th>
							<th style="border-top: none; background-color: yellow;"></th>
							<th style="border-top: none; background-color: #7e57b1; color: white;"></th>
							<th style="border-top: none; background-color: #7e57b1; color: white;"></th>
							<th style="border-top: none; background-color: yellow;"></th>
							<th style="border-top: none; background-color: yellow;"></th>
							<th style="background-color: #7e57b1; color: white;">MOOE</th>
							<th style="background-color: #7e57b1; color: white;">PS</th>
							<th style="background-color: #7e57b1; color: white;">CO</th>
							<th style="border-top: none; background-color: #7e57b1; color: white;"></th>
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


