<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model common\models\GadAccomplishmentReport */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gad-accomplishment-report-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-6">
            <?php
                echo $form->field($model, 'year')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Select Year'],
                    'pluginOptions' => [
                        'format' => 'yyyy',
                        'autoclose' => true,
                        'minViewMode' => 'years',
                        'viewmode' => 'years',
                        // 'endDate' => "-0d",
                        'orientation' => 'bottom',
                    ],
                ]);
            ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'total_lgu_budget')->textInput(['maxlength' => 18]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Update', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
