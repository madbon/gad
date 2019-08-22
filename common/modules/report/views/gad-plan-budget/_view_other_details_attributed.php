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
						<td>Title of LGU Program of Porject</td>
						<td>".($row['lgu_program_project'])."</td>
					</tr>
					<tr>
						<td>PPA Sectors</td>
						<td>".(DefaultController::PpaSectorsTagView($row['ppa_attributed_program_id']))."</td>
					</tr>
					<tr>
						<td>Checklist</td>
						<td>".(DefaultController::ChecklistViewPlan($row['checklist_id']))."</td>
					</tr>
				";
			}
		?>
	</tbody>
</table>

<div class="panel panel-primary">
	<div class="panel-heading">
		Update Other Details Form
	</div>
	<div class="panel-body">
		<?php $form = ActiveForm::begin(); ?>

		<?php
			echo $form->field($modelUpdate, 'ppa_attributed_program_id')->widget(Select2::classname(), [
			    'data' => $tags_ppaSectors,
			    'options' => ['placeholder' => 'Tag PPA Sectors'],
			    'pluginOptions' => [
			        'allowClear' => true,
			        'multiple' => true,
			    ],
			]);
		?>

		<?php
			echo $form->field($modelUpdate, 'checklist_id')->widget(Select2::classname(), [
			    'data' => $tags_checkList,
			    'options' => ['placeholder' => 'Tag Activity Category'],
			    'pluginOptions' => [
			        'allowClear' => true,
			    ],
			]);
		?>

		<br/>
		<?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
		<?php ActiveForm::end(); ?>
	</div>
</div>
