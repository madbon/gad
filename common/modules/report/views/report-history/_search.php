<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\report\models\GadReportHistorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gad-report-history-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'remarks') ?>

    <?= $form->field($model, 'tuc') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'responsible_office_c') ?>

    <?php // echo $form->field($model, 'responsible_user_id') ?>

    <?php // echo $form->field($model, 'responsible_region_c') ?>

    <?php // echo $form->field($model, 'responsible_province_c') ?>

    <?php // echo $form->field($model, 'responsible_citymun_c') ?>

    <?php // echo $form->field($model, 'fullname') ?>

    <?php // echo $form->field($model, 'date_created') ?>

    <?php // echo $form->field($model, 'time_created') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
