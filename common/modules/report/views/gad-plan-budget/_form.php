<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\GadPlanBudget */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="gad-plan-budget-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= \file\components\AttachmentsInput::widget([
        'id' => 'file-input', // Optional
        'model' => $model,
        'options' => [ // Options of the Kartik's FileInput widget
            'multiple' => true, // If you want to allow multiple upload, default to false
        ],
        'pluginOptions' => [ // Plugin options of the Kartik's FileInput widget 
            'maxFileCount' => 10, // Client max files
            'allowedFileExtensions' => ["jpg", "jpeg", "png","pdf","doc","docx","xlsx","xlsm"],
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
