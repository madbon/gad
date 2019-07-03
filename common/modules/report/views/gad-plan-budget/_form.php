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

    <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

    <p style="background-color: #f57070; color: white; padding:5px; border-radius: 3px;">WARNING : When you click this button <button class="btn btn-default btn-sm"><span class="glyphicon glyphicon-trash"></span></button> the uploaded file from the database will be permanently removed.</p>

    <?= \file\components\AttachmentsInput::widget([
        'id' => 'file-input', // Optional
        'model' => $model,
        'options' => [ // Options of the Kartik's FileInput widget
            'multiple' => true, // If you want to allow multiple upload, default to false
        ],
        'pluginOptions' => [ // Plugin options of the Kartik's FileInput widget 
            'maxFileCount' => 10, // Client max files
            'allowedFileExtensions' => ["jpg", "jpeg", "png","pdf","doc","docx","xlsx","xlsm","xls"],
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
