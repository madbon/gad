<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
?>
<style>
	.help-block
	{
		/*color:#a94442 !important;*/
	}
</style>
<div class="panel panel-default">
	<div class="panel-heading">
		File Attachement(s) Panel
	</div>
	<div class="panel-body">
		<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
			<?php
		        echo $form->field($upload, 'file_folder_type_id')->widget(Select2::classname(), [
				    'data' => $folder_type,
				    'options' => ['placeholder' => 'Select Attachement(s) Category'],
				    'pluginOptions' => [
				        'allowClear' => false
				    ],
				]);
		    ?>
		    <br/>
		    <?= $form->field($upload, 'file_name[]')->fileInput(['multiple'=>true, 'accept' => 'image/*']) ?>
		    <?= Html::submitButton('Upload', ['class' => 'btn btn-primary']) ?>
		<?php ActiveForm::end() ?>
	</div>
</div>
