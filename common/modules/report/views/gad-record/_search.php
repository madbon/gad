<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;/* @var $this yii\web\View */
/* @var $model common\modules\report\models\GadRecordSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gad-record-search">

    <?php $form = ActiveForm::begin([
        'action' => [Yii::$app->controller->action->id,'report_type' => $report_type],
        'method' => 'get',
    ]); ?>

<div class="row">
    <div class="col-sm-4">
        <?php
            $default = [];
            $urlReg = \yii\helpers\Url::to(['/report/default/find-province-by-region']);
            echo $form->field($model, 'region_c')->widget(Select2::classname(), [
                'data' =>  $region,
                'options' => ['placeholder' => 'Select Region',],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
                'pluginEvents'=>[
                        'select2:select'=>'
                            function(){
                                var region_c = this.value;
                                var province_c = null;
                                var citymun_c = null;

                                $.ajax({
                                    url: "'.$urlReg.'",
                                    data: { region_c:region_c}

                                }).done(function(result) {
                                    $("#gadrecordsearch-province_c").html("").select2({
                                            data:result,
                                            theme:"krajee",
                                            allowClear:true,
                                            width:"100%",
                                            placeholder: "Select province",
                                        });

                                    $(".btn-generate").hide();
                                });

                            }',
                    ]
            ])->label(false);
        ?>
    </div>
     <div class="col-sm-4">
        <?php
            $urlProv = \yii\helpers\Url::to(['/report/default/find-citymun-by-province']);

            echo $form->field($model, 'province_c')->widget(Select2::classname(), [
                'data' =>  $province,
                'options' => ['placeholder' => 'Province'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
                'pluginEvents'=>[
                        'select2:select'=>'
                            function(){
                                var region_c = $("#generatereportssearch-region_c").val();
                                var province_c = this.value;
                                $.ajax({
                                    url: "'.$urlProv.'",
                                    data: { region_c:region_c,
                                            province_c:province_c}

                                }).done(function(result) {
                                    $("#gadrecordsearch-citymun_c").html("").select2({
                                            data:result,
                                            theme:"krajee",
                                            allowClear:true,
                                            width:"100%",
                                            placeholder: "Select city/municipality",
                                        });

                                    $(".btn-generate").hide();
                                });
                            }',
                ]
            ])->label(false);
        ?>
    </div>
     <div class="col-sm-4">
        <?php
            if(!Yii::$app->user->can("gad_lgu_province_permission"))
            {
                echo $form->field($model, 'citymun_c')->widget(Select2::classname(), [
                    'data' => $citymun,
                    'options' => ['placeholder' => 'City/Municipality'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                    'pluginEvents'=>[
                            'select2:select'=>'
                                function(){
                                    
                                }',
                    ]
                ])->label(false);
            }
        ?>
    </div>
    <div class="col-sm-4">
        <?php
            
            echo $form->field($model, 'status')->widget(Select2::classname(), [
                'data' => $statusList,
                'options' => ['placeholder' => 'Report Status'],
                'pluginOptions' => [
                    'allowClear' => true,
                    'multiple' => true,
                ],
                'pluginEvents'=>[
                        'select2:select'=>'
                            function(){
                                
                            }',
                ]
            ])->label(false);
        ?>
    </div>
    <div class="col-sm-4">
        <?php
            echo $form->field($model, 'year')->widget(Select2::classname(), [
                'data' => $arrayYear,
                'options' => ['placeholder' => 'Year'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
                'pluginEvents'=>[
                        'select2:select'=>'
                            function(){
                                
                            }',
                ]
            ])->label(false);
        ?>
    </div>
</div>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
       <?= Html::a('<span class="glyphicon glyphicon-refresh"></span> Reset', ['index','report_type' => $report_type], ['class' => 'btn btn-default','title' => 'Reset']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
