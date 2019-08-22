<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model common\modules\bis\models\Indicator */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Indicators', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="indicator-view">
    <h3 class="page-header">Indicator: <strong><?= $model->title; ?></strong></h3>
        <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title"></h3>
            </div><!-- /.box-header -->

            <div class="box-body">  
                <?= $model->type_id == 2 ? $model->unit_id == 7 ? 
                DetailView::widget([
                    'model' => $model,
                    'options' => ['class' => 'table table-responsive table-bordered'],
                    'attributes' => [
                        'categoryTitle',
                        'title:ntext',
                        'typeTitle',
                        'frequencyTitle',
                        'unitTitle',
                        ['attribute' => 'choices',
                        'value' => $model->choicesList,
                        'format' => 'raw'],
                    ],
                ])
                : 
                DetailView::widget([
                    'model' => $model,
                    'options' => ['class' => 'table table-responsive table-bordered'],
                    'attributes' => [
                        'categoryTitle',
                        'title:ntext',
                        'typeTitle',
                        'frequencyTitle',
                        'unitTitle',
                    ],
                ]) : 
                DetailView::widget([
                    'model' => $model,
                    'options' => ['class' => 'table table-responsive table-bordered'],
                    'attributes' => [
                        'categoryTitle',
                        'title:ntext',
                        'typeTitle',
                    ],
                ])?>
                <br><br>

                <?php if($model->unit_id == 7){ ?>
                        <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>
                
                        <label>INSTRUCTIONS: <i style="color:blue; font-style:italic; font-size:13px;">
                            Indicate the sub-question under the selected possible answer.</i>
                        </label>
                        <?= $form->field($cs, 'answer')->dropDownList($chs, ['prompt'=>'Nothing Selected'])->label(false) ?>

                            <?php DynamicFormWidget::begin([
                                    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                    'widgetBody' => '.container-items', // required: css class selector
                                    'widgetItem' => '.item', // required: css class
                                    'limit' => 5, // the maximum times, an element can be cloned (default 999)
                                    'min' => 1, // 0 or 1 (default 1)
                                    'insertButton' => '.add-item', // css class
                                    'deleteButton' => '.remove-item', // css class
                                    'model' => $subquestions[0],
                                    'formId' => 'dynamic-form',
                                    'formFields' => [
                                        'id',
                                        'sub_question',
                                        'type'
                                    ],
                                ]); ?>

                            <h4 class="page-header">&nbsp;
                                <button type="button" class="btn btn-primary btn-flat btn-sm pull-right add-item ui teal button">Add Sub-Question</button>
                            </h4> 

                                    <div class="container-items"><!-- widgetContainer -->
                                        <?php foreach ($subquestions as $index => $subquestion): ?>
                                            <div class="item">
                                                    <?php
                                                        // necessary for update action.
                                                        if (!$subquestion->isNewRecord) {
                                                            echo Html::activeHiddenInput($subquestion, "[{$index}]id");
                                                        }
                                                    ?>

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                            &nbsp;
                                                                <div class="form-group pull-right">
                                                                    <button type="button" class="remove-item btn btn-flat btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></button>
                                                                </div>
                                                        </div>
                                                        <div class="panel-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <?= $form->field($subquestion, "[{$index}]sub_question")->textInput(['maxlength' => true]) ?>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <?= $form->field($subquestion, "[{$index}]type")->dropDownList($units, ['prompt'=>'Nothing Selected']) ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                            <?php DynamicFormWidget::end(); ?>

                        <div class="form-group">
                            <?= Html::submitButton('Add', ['class' => 'btn btn-flat btn-primary']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                <?php } ?>

            </div>
        </div>
</div>
