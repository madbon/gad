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
				<h4>Upload Excel Data of GAD Plan and Budget <b>(ATTRIBUTED PROGRAMS)</b></h4>
			</div>
			<div class="col-sm-6">
				<div class="btn-group pull-right">
					<?= Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Back to GAD Plan and Budget', ['/report/gad-plan-budget/index','ruc' => $ruc, 'onstep' => $onstep, 'tocreate' => $tocreate],['class' => 'btn btn-default btn-md', 'style' => '']); ?>
					<?= Html::a('<span class="glyphicon glyphicon-save"></span> Download Excel Template', ['download-template'],['class' => 'btn btn-success btn-md', 'style' => '']); ?>
					<?= Html::a('<span class="glyphicon glyphicon-refresh"></span> Reset', ['index', 'ruc' => $ruc, 'onstep' => $onstep, 'tocreate' => $tocreate],['class' => 'btn btn-default btn-md', 'style' => '']); ?>
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
			<div class="table-responsive" style="overflow-y: scroll; max-height: 500px;">
				<table class="table table-bordered data_preview table-hover">
					<thead>
						<tr>
							<th style="background-color: yellow;">PPA Sectors</th>
							<th style="background-color: #7e57b1; color: white;">Title of LGU Program or Project</th>
							<th style="background-color: yellow;">Checklist</th>
							<th style="background-color: #7e57b1; color: white;">HGDG Design/ Funding Facility/ Generic Checklist Score</th>
							<th style="background-color: #7e57b1; color: white;">Total Annual Program/ Project Budget</th>
							<th style="background-color: #7e57b1; color: white;">Lead or Responsible Office</th>
						</tr>
					</thead>
					<tbody>
						<?php
							foreach ($excelData as $row) {
								echo '<tr>';
							  	echo 	'<td style="text-align:center;">' . $row[0] . '</td>';
							  	echo 	'<td>' . $row[1] . '</td>';
							  	echo 	'<td style="text-align:center;">' . $row[2] . '</td>';
							  	echo 	'<td style="text-align:center;">' . $row[3] . '</td>';
							  	echo 	'<td style="text-align:right;">' . number_format($row[4],2) . '</td>';
							  	echo 	'<td style="text-align:center;">' . $row[5] . '</td>';
							  	echo '</tr>';
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php } ?>


