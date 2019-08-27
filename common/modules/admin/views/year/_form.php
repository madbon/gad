<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\GadYear */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gad-year-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'value')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
