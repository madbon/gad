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
<?php if(Yii::$app->user->can("gad_upload_files_endorsing")){ ?>
<!-- File Upload Form Start -->
<div class="panel panel-default">
    <div class="panel-heading">
        File Attachment Panel
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
            <?= $form->field($upload, 'file_name[]')->fileInput(['multiple'=>true, 'accept' => '*']) ?>
            <?= $form->field($upload, 'remarks')->textInput() ?>
            <?= Html::submitButton('<span class="glyphicon glyphicon-upload"></span> Upload', ['class' => 'btn btn-success btn-sm','style']) ?>
        <?php ActiveForm::end() ?>
    </div>
</div>
<!-- File Upload Form End -->
<?php } ?>
<?php
    echo $this->render('view_uploaded_files_endorsing', [
            'qry' => $qry,
            'ruc' => $ruc,
            'onstep' => $onstep,
            'tocreate' => $tocreate
        ]);
?>