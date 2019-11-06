<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\GadStatusAssignment */
/* @var $form yii\widgets\ActiveForm */
?>

<style>
.select2-container--krajee .select2-selection--multiple .select2-selection__choice
{
	float: none;
	margin:5px 50px 0 5px;
}

</style>

<div class="gad-status-assignment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'role')->textInput(['maxlength' => true]) ?>

    <?php

		echo $form->field($model, 'rbac_role')->widget(Select2::classname(), [
		    'data' => $auth_item,
		    'options' => ['placeholder' => 'Nothing Selected'],
		    'pluginOptions' => [
		        'allowClear' => true,
		    ],
		]);
	?>

    <?php
    	
		echo $form->field($model, 'status_code')->widget(Select2::classname(), [
		    'data' => $tags_status,
		    'options' => ['placeholder' => 'Nothing Selected'],
		    'pluginOptions' => [
		        'allowClear' => true,
		    ],
		]);
	?>

    <?= $form->field($model, 'description')->textInput() ?>

    <?php
    	echo "<label>Status <i style='font-weight:normal; font-size:11px; font-style:normal; color:red;'>These are the available action status for the <b>Current Report Status</b> or <b>Permission</b> </i></label>"; 
		echo $form->field($model, 'status')->widget(Select2::classname(), [
		    'data' => $tags_status,
		    'options' => ['placeholder' => 'Tag Status'],
		    'pluginOptions' => [
		        'allowClear' => true,
		        'multiple' => true,
		    ],
		])->label(false);
	?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
