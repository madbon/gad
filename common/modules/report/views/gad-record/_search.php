<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\report\models\GadRecordSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gad-record-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'region_c') ?>

    <?= $form->field($model, 'province_c') ?>

    <?= $form->field($model, 'citymun_c') ?>

    <?php // echo $form->field($model, 'total_lgu_budget') ?>

    <?php // echo $form->field($model, 'total_gad_budget') ?>

    <?php // echo $form->field($model, 'year') ?>

    <?php // echo $form->field($model, 'form_type') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'is_archive') ?>

    <?php // echo $form->field($model, 'date_created') ?>

    <?php // echo $form->field($model, 'time_created') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
