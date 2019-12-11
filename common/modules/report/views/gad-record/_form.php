<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use common\modules\report\controllers\GadRecordController;
use common\modules\report\controllers\GadPlanBudgetController as PlanActions;
use common\modules\report\controllers\DefaultController as Tools;
use common\modules\report\controllers\GadRecordController as RecordActions;
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
                if($tocreate == "gad_plan_budget")
                {
                    echo $form->field($model, 'plan_type_code')->widget(Select2::classname(), [
                        'data' =>  $plan_type,
                        'options' => ['placeholder' => 'Nothing Selected'],
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                        'pluginEvents'=>[
                            'select2:select'=>'
                                function(){
                                    var val = this.value;
                                    if(val == 1) // new plan
                                    {
                                        $("#new_plan").slideDown(300);
                                        $("#table_records").slideUp(300);
                                        $("#div_has_additional_lgu_budget").slideUp(300);
                                        $("#div_total_lgu_budget").slideDown(300);
                                        $("#label_total_lgu_budget").text("Total LGU Budget");
                                    }
                                    else
                                    {
                                        $("#new_plan").slideUp(300);
                                        $("#table_records").slideDown(300);

                                        if(val == 2) // supplemental
                                        {
                                            $("#div_has_additional_lgu_budget").slideDown(300);
                                            $("#label_total_lgu_budget").text("Additional LGU Budget");
                                        }
                                        else // for revision
                                        {
                                            $("#div_has_additional_lgu_budget").slideUp(300);
                                            $("#div_total_lgu_budget").slideUp(300);
                                            $("#gadrecord-total_lgu_budget").val("");
                                        }
                                    }
                                }',
                        ],
                    ]);
                }
            ?>

            <?php  
                if($tocreate == "accomp_report"){
                    echo "<div id='new_accomp'>";
                }
                else{
                    echo '<div id="new_plan" style="display: none;" >';
                }
            ?>

            <?php
                echo $form->field($model, 'year')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Select Year'],
                    'pluginOptions' => [
                        'format' => 'yyyy',
                        'autoclose' => true,
                        'minViewMode' => 'years',
                        'viewmode' => 'years',
                        // 'endDate' => "-0d",
                        'orientation' => 'bottom',
                    ],
                ]);
            ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4" id="div_has_additional_lgu_budget" style="display: none;">
            <?php
                echo $form->field($model, 'has_additional_lgu_budget')->widget(Select2::classname(), [
                    'data' =>  ["yes" => "Yes", "no" => "No"],
                    'options' => ['placeholder' => 'Nothing Selected (Yes or No)'],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                    'pluginEvents'=>[
                        'select2:select'=>'
                            function(){
                                var val = this.value;
                                if(val == "yes") // new plan
                                {
                                    $("#div_total_lgu_budget").slideDown(300);
                                }
                                else
                                {
                                    $("#div_total_lgu_budget").slideUp(300);
                                    $("#gadrecord-total_lgu_budget").val("");
                                }
                            }',
                    ],
                ]);
            ?>
        </div>
        <div class="col-sm-4" id="div_total_lgu_budget" style="display: none;">
            <label id="label_total_lgu_budget">Total LGU Budget</label>
            <?= $form->field($model, 'total_lgu_budget')->textInput(['maxlength' => 18])->label(false) ?>
        </div>
    </div>

    <?= $form->field($model, 'supplemental_record_id')->hiddenInput()->label(false) ?>
    <?php // $form->field($model, 'for_revision_record_id')->textInput()->label() ?>
    <?php if($tocreate != "accomp_report"){ ?>
        <div class="table-responsive"  id="table_records" style="display: none;">
             <p style="font-size: 15px;"><span class="fa fa-info-o"></span> Important note : <i style="color:red;">Select an endorsed GAD plan that needs to be supplemented.</i></p> 
            <table class="table table-hover" >
                <thead>
                    <tr>
                        <th></th>
                        <th>Type of Plan</th>
                        <?php
                            if(Yii::$app->user->can("gad_lgu"))
                            {
                                echo "<th>City/Municipality</th>";
                            }
                            else if(Yii::$app->user->can("gad_lgu_province"))
                            {
                                echo "<th>Province</th>";
                            }
                        ?>
                        
                        <th>Year</th>
                        <th>Total LGU Budget</th>
                        <th>Total GAD Budget</th>
                        <th>Status</th>
                        <th>Remarks</th>
                        <th>Date Processed</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(!empty($query_all_existing_plan))
                        {
                            foreach ($query_all_existing_plan as $key => $row) 
                            {
                                if($model->supplemental_record_id == $row["id"])
                                {
                                    echo 
                                    "
                                    <tr id='tr-".($row['id'])."'>
                                        <td>
                                            <button type='button' class='btn btn-success btn-sm selectbuttons' id='select-button-".$row['id']."'>
                                                <span class='fa fa-circle icon' id='span-icon-".$row['id']."'></span> <span class='button-title' id='button-title-".$row['id']."'>Selected</span>
                                            </button>
                                        </td>
                                    ";
                                }
                                else
                                {
                                    echo 
                                    "
                                    <tr>
                                        <td>
                                            <button type='button' class='btn btn-success btn-sm selectbuttons' id='select-button-".$row['id']."'>
                                                <span class='fa fa-circle-o icon' id='span-icon-".$row['id']."'></span> <span class='button-title' id='button-title-".$row['id']."'>Select</span>
                                            </button>
                                        </td>
                                    ";
                                }

                                // Click action select button
                                $this->registerJs("
                                    $('#select-button-".$row['id']."').click(function(){
                                        
                                        $('.button-title').text('Select');

                                        if($('#span-icon-".$row['id']."').hasClass('fa-circle')) // if selected
                                        {
                                            $('.icon').removeClass('fa-circle').addClass('fa-circle-o');
                                            $('#span-icon-".$row['id']."').removeClass('fa-circle').addClass('fa-circle-o');
                                            $('#gadrecord-supplemental_record_id').val('');
                                            $('#button-title-".$row['id']."').text('Select');
                                        }
                                        else 
                                        {
                                            $('.icon').removeClass('fa-circle').addClass('fa-circle-o');
                                            $('#span-icon-".$row['id']."').removeClass('fa-circle-o').addClass('fa-circle');
                                            $('#gadrecord-supplemental_record_id').val(".($row['id']).");
                                            $('#button-title-".$row['id']."').text('Selected');
                                        }

                                    });
                                ");
                                
                                echo "<td>".(Tools::GetPlanTypeTitle($row['plan_type_code']))."</td>";
                                if(Yii::$app->user->can("gad_lgu"))
                                {
                                    echo "<td>".(Tools::GetCitymunName($row['tuc']))."</td>";
                                }
                                else if(Yii::$app->user->can("gad_lgu_province"))
                                {
                                    echo "<td>".(Tools::GetProvinceName($row['tuc']))."</td>";
                                }
                                echo "

                                    <td>".($row['year'])."</td>
                                    <td> Php ".(number_format($row['total_lgu_budget'],2))."</td>
                                    <td>".(PlanActions::ComputeGadBudget($row['tuc']))."</td>
                                    <td>".(Tools::DisplayStatus($row['status']))."</td>
                                    <td style='font-size:10px;'>".(RecordActions::GenerateRemarks($row["tuc"]))."</td>
                                    <td>".(RecordActions::GenerateLatestDate($row['tuc']))."</td>
                                </tr>
                                ";
                            }
                        }
                        else
                        {
                            echo "<tr><td style='color:red;' colspan='9'><span class='fa fa-warning'></span> No endorsed GAD plan found.</td></tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    <?php } ?>

    <?php
        $this->registerJs("
            if($('#gadrecord-plan_type_code').val() == 1 || $('#gadrecord-plan_type_code').val() == '')
            {
                $('#table_records').slideUp(300);
                $('#new_plan').slideDown(300);
                $('#div_total_lgu_budget').slideDown(300);
                $('#div_has_additional_lgu_budget').slideUp(300);
            }
            else
            {
                $('#table_records').slideDown(300);
                if($('#gadrecord-plan_type_code').val() == '3')
                {
                    $('#div_has_additional_lgu_budget').slideUp(300);
                    $('#div_total_lgu_budget').slideUp(300);
                }
                else
                {
                    $('#table_records').slideDown(300);
                    $('#new_plan').slideUp(300);
                    $('#div_has_additional_lgu_budget').slideDown(300);

                    if($('#gadrecord-has_additional_lgu_budget').val() == 'yes' || $('#gadrecord-has_additional_lgu_budget').val() == '')
                    {
                        $('#div_total_lgu_budget').slideDown(300);
                    }
                    else 
                    {
                        $('#div_total_lgu_budget').slideUp(300);
                    }
                }
            }

            
        ");
    ?>

    <div class="form-group">
        <?= Html::submitButton('<span class="fa fa-save"></span> Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
