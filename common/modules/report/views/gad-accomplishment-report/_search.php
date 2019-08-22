<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\report\models\GadAccomplishmentReportSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gad-accomplishment-report-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'record_id') ?>

    <?= $form->field($model, 'focused_id') ?>

    <?= $form->field($model, 'inner_category_id') ?>

    <?php // echo $form->field($model, 'ppa_focused_id') ?>

    <?php // echo $form->field($model, 'ppa_value') ?>

    <?php // echo $form->field($model, 'cause_gender_issue') ?>

    <?php // echo $form->field($model, 'objective') ?>

    <?php // echo $form->field($model, 'relevant_lgu_ppa') ?>

    <?php // echo $form->field($model, 'activity') ?>

    <?php // echo $form->field($model, 'performance_indicator') ?>

    <?php // echo $form->field($model, 'target') ?>

    <?php // echo $form->field($model, 'actual_results') ?>

    <?php // echo $form->field($model, 'total_approved_gad_budget') ?>

    <?php // echo $form->field($model, 'actual_cost_expenditure') ?>

    <?php // echo $form->field($model, 'variance_remarks') ?>

    <?php // echo $form->field($model, 'date_created') ?>

    <?php // echo $form->field($model, 'time_created') ?>

    <?php // echo $form->field($model, 'date_updated') ?>

    <?php // echo $form->field($model, 'time_updated') ?>

    <?php // echo $form->field($model, 'record_tuc') ?>

    <?php // echo $form->field($model, 'this_tuc') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
