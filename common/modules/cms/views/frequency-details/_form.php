<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\bis\models\FrequencyDetails */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="frequency-details-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'frequency_id')->textInput() ?>

    <?= $form->field($model, 'details')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
