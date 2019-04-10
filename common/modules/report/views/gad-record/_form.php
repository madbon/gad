<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model common\models\GadRecord */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gad-record-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'total_lgu_budget')->textInput(['maxlength' => 18]) ?>

            <!-- <?php // $form->field($model, 'total_gad_budget')->textInput(['maxlength' => 18]) ?> -->

            <?php
                echo $form->field($model, 'year')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Select Year'],
                    'pluginOptions' => [
                        'format' => 'yyyy',
                        'autoclose' => true,
                        'minViewMode' => 'years',
                        'viewmode' => 'years',
                        'endDate' => "-0d",
                        'orientation' => 'bottom',
                    ],
                ]);
            ?>
        </div>
    </div>

    

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
