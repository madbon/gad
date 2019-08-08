<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;
use kartik\select2\Select2;
use yii\web\JsExpression;
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?> 
    <?php echo $form->field($model, 'imageFile')->widget(FileInput::classname(), [
        'pluginOptions' => [
            'browseClass' => "btn btn-primary btn-file",
            'showPreview' => true,
            'showCaption' => true,
            'showRemove' => false,
            'showUpload' => false,
            'browseLabel' => 'Browse',
            'maxFileCount' => 1,
            'allowedFileExtensions' => ["xlsx", "xls", "csv"],
        ],
        'options'=>[
            'multiple'=>false,
        ],
    ]); ?>
    <hr style="border: 1px solid #d2d6de;margin-top: 10px;">
    <?= Html::a('<span class="glyphicon glyphicon-refresh"></span> Refresh', ['index', 'ruc' => $ruc, 'onstep' => $onstep, 'tocreate' => $tocreate],['class' => 'btn btn-default btn-md', 'style' => '']); ?>
    <button class="btn btn-md btn-success pull-right"><i class="glyphicon glyphicon-upload"></i> Preview</button>
    <br><br>
<?php ActiveForm::end(); ?>
