<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\GadPlanBudgetSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gad-plan-budget-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index','ruc' => $ruc,'onstep'=>$onstep,'tocreate'=>$tocreate],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-sm-6">
            <?php    
                echo $form->field($model, 'focused_id')->widget(Select2::classname(), [
                    'data' =>  $select_GadFocused,
                    'options' => ['placeholder' => 'Nothing Selected'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                    'pluginEvents'=>[
                            'select2:select'=>'
                                function(){
                                    
                                }
                            ',
                    ]
                ])->label("Focused");
            ?>
        </div>
        <div class="col-sm-6">
            <?php    
                echo $form->field($model, 'inner_category_id')->widget(Select2::classname(), [
                    'data' =>  $select_gadMandateGenderIssue,
                    'options' => ['placeholder' => 'Nothing Selected'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                    'pluginEvents'=>[
                            'select2:select'=>'
                                function(){
                                    
                                }
                            ',
                    ]
                ])->label("GAD Mandate or Gender issue");
            ?>
        </div>
        
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'ppa_value')->textArea() ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'objective')->textArea() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'relevant_lgu_program_project')->textArea() ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'activity')->textArea() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'performance_target')->textArea() ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'lead_responsible_office')->textArea() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'budget_mooe')->textInput() ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'budget_ps')->textInput() ?>
        </div>
        <div class="col-sm-4">
            <?= $form->field($model, 'budget_co')->textInput() ?>
        </div>
    </div>
    
    

    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-filter"></span> Filter', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
