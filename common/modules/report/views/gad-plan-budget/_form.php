<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\GadPlanBudget */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gad-plan-budget-form">

    <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-sm-2">
            </div>
        </div>
    <?= $form->field($model, 'issue_mandate')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'objective')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'relevant_lgu_program_project')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'activity')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'performance_indicator_target')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'budget_mooe')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'budget_ps')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'budget_co')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lead_responsible_office_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
