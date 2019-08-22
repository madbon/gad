<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\report\models\GadCommentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gad-comment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'resp_user_id') ?>

    <?= $form->field($model, 'resp_office_c') ?>

    <?= $form->field($model, 'record_id') ?>

    <?= $form->field($model, 'plan_budget_id') ?>

    <?php // echo $form->field($model, 'resp_region_c') ?>

    <?php // echo $form->field($model, 'resp_province_c') ?>

    <?php // echo $form->field($model, 'resp_citymun_c') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'row_no') ?>

    <?php // echo $form->field($model, 'column_no') ?>

    <?php // echo $form->field($model, 'row_value') ?>

    <?php // echo $form->field($model, 'column_value') ?>

    <?php // echo $form->field($model, 'model_name') ?>

    <?php // echo $form->field($model, 'attribute_name') ?>

    <?php // echo $form->field($model, 'date_created') ?>

    <?php // echo $form->field($model, 'time_created') ?>

    <?php // echo $form->field($model, 'date_updated') ?>

    <?php // echo $form->field($model, 'time_updated') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
