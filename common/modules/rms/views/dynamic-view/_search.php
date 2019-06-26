<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\modules\drugaffectation\models\DrugAffectationBarangaySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="drug-affectation-barangay-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="">
        <div class="col-md-6">
            <?php 
                $provincesurl = \yii\helpers\Url::to(['/user/province/province-list']);
                echo $form->field($model, 'region_c')->widget(Select2::classname(), [
                    'data' => $regions,
                    'options' => ['placeholder' => 'Region','multiple' => false,'class'=>'region-select'],
                    'pluginOptions' => [
                        'allowClear' => count($regions) > 1 ? true : false,
                        /*'ajax'=>[
                                    'url'=>$url,
                                    'dataType' => 'json',
                                    'data' => new JsExpression('function(params) { alert(params);}')
                                ],*/
                    ],
                    'pluginEvents'=>[
                        'select2:select'=>'
                            function(){
                                var vals = this.value;
                                $.ajax({
                                    url: "'.$provincesurl.'",
                                    data: {region:vals}
                                    
                                }).done(function(result) {
                                    var h;

                                    /*for(var i=0; i<result.length; i++){
                                        var id = result[i].id;
                                        var text = result[i].text;
                                        h+="<option value=\'"+id+"\' >"+text+"</option>";
                                    }*/
                                   // 
                                   // $("#province-select").select2("destroy");
                                    $(".province-select").html("").select2({ data:result, theme:"krajee", width:"100%",placeholder:"Province",
                                    allowClear: true,});
                                    $(".province-select").select2("val","");
                                });
                            }'
                    ]
                ]);
            ?>
        </div>
        <div class="col-md-6">
            <?php 
                $citymunsurl = \yii\helpers\Url::to(['/user/citymun/citymun-list']);
                echo $form->field($model, 'province_c')->widget(Select2::classname(), [
                    'data' => $provinces,
                    'options' => ['placeholder' => 'Province','multiple' => false,'class'=>'province-select'],
                    'pluginOptions' => [
                        'allowClear' => count($provinces) > 1 ? true : false
                    ],
                    'pluginEvents'=>[
                        'select2:select'=>'
                            function(){
                                var vals = this.value;
                                $.ajax({
                                    url: "'.$citymunsurl.'",
                                    data: {province:vals}
                                    
                                }).done(function(result) {
                                    var h;
                                    $(".citymun-select").html("").select2({ data:result, theme:"krajee", width:"100%",placeholder:"City/Municipality",
                                    allowClear: true,});
                                    $(".citymun-select").select2("val","");
                                });
                            }'

                    ]
                ]);
            ?>
        </div>
    </div>
    <div class="">
        <div class="col-md-6">
            <?php 
                $barangaysurl = \yii\helpers\Url::to(['/user/barangay/barangay-list']);
                echo $form->field($model, 'citymun_c')->widget(Select2::classname(), [
                    'data' => $citymuns,
                    'options' => ['placeholder' => 'City/Municipality','multiple' => false,'class'=>'citymun-select'],
                    'pluginOptions' => [
                        'allowClear' => count($citymuns) > 1 ? true : false
                    ],
                    'pluginEvents'=>[
                        'select2:select'=>'
                            function(){
                                var vals = this.value;
                                var prov = document.getElementById("drugaffectationbarangaysearch-province_c").value;
                                $.ajax({
                                    url: "'.$barangaysurl.'",
                                    data: {citymun:vals, province:prov}
                                    
                                }).done(function(result) {
                                    var h;
                                    $(".barangay-select").html("").select2({ data:result, theme:"krajee", width:"100%",placeholder:"Barangay",
                                    allowClear: true,});
                                    $(".barangay-select").select2("val","");
                                });
                            }'

                    ]
                ]);
            ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'form_type')->widget(Select2::classname(), [
                    'data' => $categories,
                    'options' => ['placeholder' => ' Form Type ','multiple' => false,'class'=>'form_type-select'],
                    'pluginOptions' => [
                        'allowClear' => count($categories) > 1 ? true : false
                    ]
                ]); 
            ?>
        </div>
    </div>
    <div class="">
        <div class="col-md-12">
            <div class="form-group pull-right">
                <?= Html::submitButton('<span class="glyphicon glyphicon-search"></span> Search', ['class' => 'btn btn-sm btn-primary']) ?>
                <?= Html::a('<span class="glyphicon glyphicon-refresh"></span> Reset', ['index'], ['class' => 'btn btn-sm btn-default']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
