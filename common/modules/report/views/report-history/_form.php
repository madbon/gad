<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\GadReportHistory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gad-report-history-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'remarks')->textarea(['rows' => 3]) ?>
    <!-- <?php // $form->field($model, 'tuc')->textInput(['maxlength' => true]) ?> -->

    <?php 
       echo $form->field($model, 'status')->widget(Select2::classname(), [
            'data' =>  $status,
            'options' => ['placeholder' => 'Select action'],
            'pluginOptions' => [
                'allowClear' => false,
            ],
        ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
