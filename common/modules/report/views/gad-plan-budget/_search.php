<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\GadPlanBudgetSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gad-plan-budget-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'region_c') ?>

    <?= $form->field($model, 'province_c') ?>

    <?= $form->field($model, 'citymun_c') ?>

    <?php // echo $form->field($model, 'issue_mandate') ?>

    <?php // echo $form->field($model, 'objective') ?>

    <?php // echo $form->field($model, 'relevant_lgu_program_project') ?>

    <?php // echo $form->field($model, 'activity') ?>

    <?php // echo $form->field($model, 'performance_indicator_target') ?>

    <?php // echo $form->field($model, 'budget_mooe') ?>

    <?php // echo $form->field($model, 'budget_ps') ?>

    <?php // echo $form->field($model, 'budget_co') ?>

    <?php // echo $form->field($model, 'lead_responsible_office_id') ?>

    <?php // echo $form->field($model, 'date_created') ?>

    <?php // echo $form->field($model, 'time_created') ?>

    <?php // echo $form->field($model, 'date_updated') ?>

    <?php // echo $form->field($model, 'time_updated') ?>

    <?php // echo $form->field($model, 'sort') ?>

    <?php // echo $form->field($model, 'tuc_parent') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
