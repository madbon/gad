<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\GadAccomplishmentReport */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gad-accomplishment-report-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'record_id')->textInput() ?>

    <?= $form->field($model, 'focused_id')->textInput() ?>

    <?= $form->field($model, 'inner_category_id')->textInput() ?>

    <?= $form->field($model, 'ppa_focused_id')->textInput() ?>

    <?= $form->field($model, 'ppa_value')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'cause_gender_issue')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'objective')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'relevant_lgu_ppa')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'activity')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'performance_indicator')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'target')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'actual_results')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'total_approved_gad_budget')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'actual_cost_expenditure')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'variance_remarks')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'date_created')->textInput() ?>

    <?= $form->field($model, 'time_created')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_updated')->textInput() ?>

    <?= $form->field($model, 'time_updated')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'record_tuc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'this_tuc')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
