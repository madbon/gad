<?php

use yii\helpers\Html;
use common\modules\report\controllers\DefaultController;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
?>

<table class="table table-responsive table-bordered">
	<thead>
		<tr>
			<th>Other Details Title</th>
			<th>Value</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($model as $key => $row) {
				echo "
					<tr>
						<td>Gender Issue/GAD Mandate Supporting Data</td>
						<td>".($row['gi_sup_data'])."</td>
					</tr>
					<tr>
						<td>Source of supporting data</td>
						<td>".($row['source'])."</td>
					</tr>
					<tr>
						<td>PPA Sectors</td>
						<td>".(DefaultController::PpaSectorsTagView($row['cliorg_ppa_attributed_program_id']))."</td>
					</tr>
					<tr>
						<td>Activity Category</td>
						<td>".(DefaultController::ActivityCategoryIdView($row['activity_category_id']))."</td>
					</tr>
					<tr>
						<td>Target Date of Implementation (Start and End)</td>
						<td>".(date("F j, Y", strtotime($row['date_implement_start'])))." to ".(date("F j, Y", strtotime($row['date_implement_end'])))."</td>
					</tr>
				";
			}
		?>
	</tbody>
</table>

<?php if(in_array($status,DefaultController::Can("edit_plan"))) { ?>
<div class="panel panel-primary">
	<div class="panel-heading">
		Update Other Details Form
	</div>
	<div class="panel-body">
		<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($modelUpdate, 'source')->textInput() ?>

		<?= $form->field($modelUpdate, 'gi_sup_data')->textInput() ?>

		<?php
			echo $form->field($modelUpdate, 'cliorg_ppa_attributed_program_id')->widget(Select2::classname(), [
			    'data' => $tags_ppaSectors,
			    'options' => ['placeholder' => 'Tag PPA Sectors'],
			    'pluginOptions' => [
			        'allowClear' => true,
			        'multiple' => true,
			    ],
			]);
		?>

		<?php
			echo $form->field($modelUpdate, 'activity_category_id')->widget(Select2::classname(), [
			    'data' => $tags_activityCategory,
			    'options' => ['placeholder' => 'Tag Activity Category'],
			    'pluginOptions' => [
			        'allowClear' => true,
			        'multiple' => true,
			    ],
			]);
		?>

		<div class="row">
			<div class="col-sm-6">
				<?php
					echo "<label>Target date of Implementation (Start) YYYY-MM-DD</label>";
					echo DatePicker::widget([
					    'model' => $modelUpdate, 
					    'attribute' => 'date_implement_start',
					    'options' => ['placeholder' => ''],
					    'pluginOptions' => [
					        'autoclose'=>true,
					        'format' => 'yyyy-mm-dd'
					    ]
					]);
				?>
			</div>
			<div class="col-sm-6">
				<?php
					echo "<label>Target date of Implementation (End) YYYY-MM-DD</label>";
					echo DatePicker::widget([
					    'model' => $modelUpdate, 
					    'attribute' => 'date_implement_end',
					    'options' => ['placeholder' => ''],
					    'pluginOptions' => [
					        'autoclose'=>true,
					        'format' => 'yyyy-mm-dd'
					    ]
					]);
				?>
			</div>
		</div>
		<br/>
		<?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
		<?php ActiveForm::end(); ?>
	</div>
</div>
<?php } ?>