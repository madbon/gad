<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\GadChecklist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gad-checklist-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'report_type_id')->textInput()->label("Report Type (Plan and Budget = 1 / Accomplishment = 2)") ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_hidden')->textInput()->label("Visible? (Yes = 0 / No = 1)") ?>

    <?= $form->field($model, 'sort')->textInput()->label("Order") ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
