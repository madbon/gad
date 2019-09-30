<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\GadStatusAssignment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gad-status-assignment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'role')->textInput(['maxlength' => true]) ?>

    <?php
		echo $form->field($model, 'status')->widget(Select2::classname(), [
		    'data' => $tags_status,
		    'options' => ['placeholder' => 'Tag Status'],
		    'pluginOptions' => [
		        'allowClear' => true,
		        'multiple' => true,
		    ],
		]);
	?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
