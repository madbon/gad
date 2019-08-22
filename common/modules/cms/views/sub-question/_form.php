<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\bis\models\SubQuestion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sub-question-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'indicator_id')->textInput() ?>

    <?php // $form->field($model, 'compare_value')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sub_question')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
