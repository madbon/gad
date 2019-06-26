<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\modules\rms\models\UploadedClient */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box box-primary">
    <div class="box-body">
        <div class="row">   
            <p style="margin-left: 14px;font-size: 16px;"><strong><?= Yii::$app->controller->action->id == 'create' ? 'Add Registered Business':'Update Registered Business' ?> <?= $model->business_name ?></strong></p> 
            <div class="col-md-12">     
                <hr style="border: 1px solid #d2d6de;margin-top: -3px;">   
            </div> 
            <div class="col-md-12">
                <div class="uploaded-client-form">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'business_name')->textInput(['maxlength' => true]) ?>
                    

                    <?= $form->field($model, 'application_no')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'business_tin')->textInput(['maxlength' => true]) ?>

                    <?php // $form->field($model, 'business_tin')->widget(MaskedInput::className(), ['mask' => '999-999-999-999']) ?>

                    <?= $form->field($model, 'application_date')->widget(
                        DatePicker::className(), [
                            'name' => 'date_filed', 
                            'value' => date('yyyy-mm-dd'),
                            'type' => DatePicker::TYPE_COMPONENT_APPEND,
                            'options' => ['placeholder' => 'Select Date'],
                            'pluginOptions' => [
                                'format' => 'yyyy-mm-dd',
                                'autoclose'=>true,
                                'todayHighlight' => true
                            ]
                        ]);
                    ?>

                    <?= $form->field($model, 'business_type')->dropDownList($type) ?>

                    <div class="row">
                        <div class="col-md-12">
                            <p><strong>Applicant's Name (Optional)</strong></p>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
                        </div>    
                        <div class="col-md-4">
                            <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>
                        </div>    
                        <div class="col-md-4">
                            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
                        </div>                        
                    </div>
                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>
