<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use common\modules\report\controllers\DefaultController;
?>
<style>
	.help-block
	{
		/*color:#a94442 !important;*/
	}
</style>
<!-- File Upload Form Start -->
<br/><br/>
<div class="panel panel-default">
    <div class="panel-heading">
        File Attachment Panel :
        <?php
            echo DefaultController::FileCatName($file_cat);
        ?>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
            <?php
                // echo $form->field($upload, 'file_folder_type_id')->widget(Select2::classname(), [
                //     'data' => $folder_type,
                //     'options' => ['placeholder' => 'Select Attachement(s) Category'],
                //     'pluginOptions' => [
                //         'allowClear' => false
                //     ],
                // ]);
            ?>
            <?= $form->field($upload, 'file_name[]')->fileInput(['multiple'=>true, 'accept' => '*']) ?>
            <?= $form->field($upload, 'remarks')->textInput() ?>
            <?= Html::submitButton('<span class="glyphicon glyphicon-upload"></span> Upload', ['class' => 'btn btn-success btn-sm','style']) ?>
        <?php ActiveForm::end() ?>
    </div>
</div>
<!-- File Upload Form End -->