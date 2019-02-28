<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\GadPlanBudget */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gad-plan-budget-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'region_c')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'province_c')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'citymun_c')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'issue_mandate')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'objective')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'relevant_lgu_program_project')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'activity')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'performance_indicator_target')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'budget_mooe')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'budget_ps')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'budget_co')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lead_responsible_office_id')->textInput() ?>

    <?= $form->field($model, 'date_created')->textInput() ?>

    <?= $form->field($model, 'time_created')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_updated')->textInput() ?>

    <?= $form->field($model, 'time_updated')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tuc_parent')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
