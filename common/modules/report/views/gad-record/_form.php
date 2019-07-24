<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use common\modules\report\controllers\GadRecordController;
use common\modules\report\controllers\GadPlanBudgetController;
use common\modules\report\controllers\DefaultController;
/* @var $this yii\web\View */
/* @var $model common\models\GadRecord */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    table.table thead tr th
    {
        background-color: whitesmoke;
        border-bottom: 2px solid black;
    }
    table.table
    {
        border:1px solid black;
    }
    .btnselect
    {
        border-radius: 5px;
        border:none;
        padding: 3px;
        border:1px solid gray;
        padding-left: 10px;
        padding-right: 10px;
    }
</style>
<div class="gad-record-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-4">
            <?php 
                
                $urlLoadRecord = yii\helpers\Url::to(['/report/default/load-record-by-status']);
                echo $form->field($model, 'create_status_id')->widget(Select2::classname(), [
                'data' =>  $create_plan_status,
                'options' => ['placeholder' => 'Nothing Selected'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
                'pluginEvents'=>[
                        'select2:select'=>'
                            function(){
                                var status = 0;
                                var thisvalue = this.value;
                                if(thisvalue == 1)
                                {

                                }
                                else
                                {
                                    $.ajax({
                                        url: "'.$urlLoadRecord.'",
                                        data: { 
                                                status:thisvalue
                                                }
                                        
                                        }).done(function(data) {
                                            $("#table_records tbody").html("");
                                            $.each(data, function(key, value){
                                                var ruc_value = value.ruc;
                                                var cols = "";
                                                var btn_id = "btnselect"+value.record_id;
                                                cols += "<tr>";
                                                cols +=     "<td>"+value.office_name+"</td>";
                                                cols +=     "<td>"+value.citymun_name+"</td>";
                                                cols +=     "<td>"+value.year+"</td>";
                                                cols +=     "<td>"+value.total_lgu_budget+"</td>";
                                                cols +=     "<td>"+value.total_gad_budget+"</td>";
                                                cols +=     "<td>"+value.status_name+"</td>";
                                                cols +=     "<td>"+value.remarks+"</td>";
                                                cols +=     "<td><button class=btnselect type=button id="+btn_id+">Select</button></td>";
                                                cols += "</tr>";
                                                $("#table_records tbody").append(cols);
                                                $("#"+btn_id).click(function(){
                                                    $("#gadrecord-for_revision_record_id").val(value.record_id);
                                                    $(".btnselect").text("Select");
                                                    $(this).text("Selected");
                                                    
                                                });
                                                
                                        });
                                    });
                                }
                            }
                        ',
                ]
            ])->label("Plan Category");
            ?>
            <?= $form->field($model, 'total_lgu_budget')->textInput(['maxlength' => 18]) ?>

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
        <div class="col-sm-8 table-responsive">
            <?= $form->field($model, 'for_revision_record_id')->textInput(['maxlength' => 18]) ?>
            <table class="table table-responsive table-hover"  id="table_records">
                <thead>
                    <tr>
                        <th>Office</th>
                        <th>City/Municipality</th>
                        <th>Year</th>
                        <th>Total LGU Budget</th>
                        <th>Total GAD Budget</th>
                        <th>Status</th>
                        <th>Remarks</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
