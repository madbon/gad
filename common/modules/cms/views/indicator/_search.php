<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model common\modules\bis\models\IndicatorSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="indicator-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <hr/>
    <?php echo $form->field($model, 'title')->label("Search Indicator Title") ?>
    <hr/>
    <?php
    $url = \yii\helpers\Url::to(['dropdown-json/find-indicator-by-category-id']);
    echo $form->field($model, 'category_id')->widget(Select2::classname(), 
        [
            'data' => $category,
            'options' => ['placeholder' => '-'],
            'pluginOptions' => [
                'allowClear' => true
            ],
            'pluginEvents'=>
            [
                'select2:select'=>'
                    function()
                    {
                        var category_id = this.value;
                        $.ajax({
                            url: "'.$url.'",
                            data: 
                            { 
                                category_id:category_id
                            }
                        }).done(function(result) {
                            $("#indicatorsearch-id").html("").select2({
                                data:result, 
                                theme:"krajee", 
                                allowClear:true, 
                                width:"100%",
                                placeholder: "Select Indicator",
                            });
                        });

                    }
                ',
            ] 
        ]);
    ?>

    

    <?= $form->field($model, 'id')->widget(Select2::classname(), [
                'data' => $indicator,
                'options' => ['placeholder' => '-'],
                'pluginOptions' => [
                    'allowClear' => true
    ],])->label("Select Indicator Title");?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'type_id')->widget(Select2::classname(), [
                'data' => $type,
                'options' => ['placeholder' => '-'],
                'pluginOptions' => [
                    'allowClear' => true
            ],])->label("Type");?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'unit_id')->widget(Select2::classname(), [
                'data' => $unit,
                'options' => ['placeholder' => '-'],
                'pluginOptions' => [
                    'allowClear' => true
            ],])->label("Unit");?>
        </div>
        <!-- <div class="col-sm-3">
        </div> -->

    </div>
    

  

    

    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-filter"></span> &nbsp;Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-refresh"></span> &nbsp;Reset', ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<hr/>