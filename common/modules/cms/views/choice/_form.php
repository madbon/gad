<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model common\modules\bis\models\Choice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="choice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'indicator_id')->widget(Select2::classname(), [
                'data' => $indicator,
                'options' => ['placeholder' => 'Select an indicator that default choices is under'],
                'pluginOptions' => [
                    'allowClear' => true
            ],]);?>

    <?= $form->field($model, 'default_choice_id')->widget(Select2::classname(), [
                'data' => $default_choices,
                'options' => ['placeholder' => 'Select a default choice that you want to create a choices'],
                'pluginOptions' => [
                    'allowClear' => true
            ],]);?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true, 'placeholder' => 'Type here the value of default choices']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
