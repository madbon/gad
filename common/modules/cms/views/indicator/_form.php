<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\modules\bis\models\Indicator */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="indicator-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <?php
        $url = \yii\helpers\Url::to(['dropdown-json/get-cat-content-type-id']);
        $urlFillCatSelectType = \yii\helpers\Url::to(['dropdown-json/fill-cat-select-type']);
        $urlFillCatSelectUnit = \yii\helpers\Url::to(['dropdown-json/fill-cat-select-unit']);
        echo $form->field($model, 'category_id')->widget(Select2::classname(), [
            'data' => $categories,
            'options' => ['placeholder' => 'Category','multiple' => false,'class'=>'category-select'],
            'pluginOptions' => [
                'allowClear' => count($categories) > 1 ? true : false
            ],
            'pluginEvents'=>
            [
            'select2:select'=>'
				function(){
                var category_id = $("#indicator-category_id").val();
                $.ajax({
                    url: "'.$url.'",
                    data: { 
                            category_id:category_id,
                            }
                    
                    }).done(function(result) {

                        // 4 - image / 5 - slide images / 6 - pdf / 11 - downloadables 

                        if(result == "4" || result == "5" || result == "6" || result == "11")
                        {
                             $("#divFreq").show();
                             $("#divUnit").show();
                            // $("#divDefaultChoice").hide();
                             $("#divType").show();
                             $("#partof_chart").hide();
                        }
                        else if(result == "9" || result == "10")
                        {
                            // alert("Hello");
                            $("#divDefaultChoice").hide();
                            $("#divUnit").hide();
                            $("#divType").hide();
                            $("#divDefaultChoice").show();
                            $("#divInnerDefaultChoice").hide();
                            $("#divChoice").show();
                            $("#partof_chart").slideDown(300);
                            
                        }
                        else if(result == "8")
                        {
                            $("#divUnit").hide();
                            $("#divType").hide();
                            $("#divDefaultChoice").hide();
                            $("#partof_chart").slideDown(300);
                        }
                        else
                        {
                            $("#divType").show();
                            $("#partof_chart").hide();
                        }

                        
                        $("#indicator-temp_content_type_id").val(result);
                        
                });

                $.ajax({
                        url: "'.$urlFillCatSelectType.'",
                        data: { 
                                category_id:category_id,
                                }
                        
                        }).done(function(result) {

                            $("#indicator-type_id").html("").select2({
                                data:result, 
                                theme:"krajee", 
                                allowClear:true, 
                                width:"100%",
                                placeholder: "-",
                        });
                });

                $.ajax({
                        url: "'.$urlFillCatSelectUnit.'",
                        data: { 
                                category_id:category_id,
                                }
                        
                        }).done(function(result) {

                            $("#indicator-unit_id").html("").select2({
                                data:result, 
                                theme:"krajee", 
                                allowClear:true, 
                                width:"100%",
                                placeholder: "-",
                        });
                });
            }'
            ]
        ]);
    ?>

    <?= $form->field($model, 'title')->textArea(['row' => 2]); ?>

    <?= $form->field($model, 'temp_content_type_id')->hiddenInput()->label(false); ?>
    
    <?= $form->field($model, 'sort')->textInput()->label("Sort"); ?>

    <div id="partof_chart" style="display: none;">
        <?php
            echo $form->field($model, 'in_chart')->widget(Select2::classname(), [
                'data' => $in_chart,
                'options' => ['placeholder' => 'Type','multiple' => false,'class'=>'type-select'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ])->label("Part of the Chart?");
        ?>
    </div>

    <div id="divType">
        <?php
            echo $form->field($model, 'type_id')->widget(Select2::classname(), [
                'data' => $types,
                'options' => ['placeholder' => 'Type','multiple' => false,'class'=>'type-select'],
                'pluginOptions' => [
                    'allowClear' => count($types) > 1 ? true : false
                ],
            ]);
        ?>
    </div>

   

    <div id="divUnit">
        <?php
            echo $form->field($model, 'unit_id')->widget(Select2::classname(), [
                'data' => $units,
                'options' => ['placeholder' => 'Unit','multiple' => false,'class'=>'unit-select'],
                'pluginOptions' => [
                    'allowClear' => count($units) > 1 ? true : false
                ],
            ]);
        ?>
    </div>
    

    <?php
        echo $form->field($model, 'is_required')->widget(Select2::classname(), [
            'data' => [1 => 'No', 2 => 'Yes'],
            'options' => ['placeholder' => 'Required?','multiple' => false,'class'=>'type-select'],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ]);
    ?>

    <div class="divDefaultChoice" id="divDefaultChoice">
        <div id="divInnerDefaultChoice">
        <?php
            echo $form->field($model, 'default_choice_id')->widget(Select2::classname(), [
                'data' => $dchoices,
                'options' => ['placeholder' => 'Choice','multiple' => false,'class'=>'choice-select'],
                'pluginOptions' => [
                    'allowClear' => count($dchoices) > 1 ? true : false
                ],
            ]);
        ?>
        <br><br>
        </div>


        <div class="divChoice" id="divChoice">
            <div class="bs-callout bs-callout-info" id="callout-glyphicons-location">
                
                <?php DynamicFormWidget::begin([
                        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                        'widgetBody' => '.container-items1', // required: css class selector
                        'widgetItem' => '.item1', // required: css class
                        'limit' => 999, // the maximum times, an element can be cloned (default 999)
                        'min' => 0, // 0 or 1 (default 1)
                        'insertButton' => '.add-item', // css class
                        'deleteButton' => '.remove-item', // css class
                        'model' => $choices[0],
                        'formId' => 'dynamic-form',
                        'formFields' => [
                            'id',
                            'value'
                        ],
                    ]); ?>
                     <br>

                <h4 class="page-header">Choices
                    <button type="button" class="btn btn-primary btn-flat pull-right add-item ui teal button">Add Choices</button>
                </h4> 

                        <div class="container-items1"><!-- widgetContainer -->
                            <?php foreach ($choices as $index => $choice): ?>
                                <div class="item1">
                                        <?php
                                            // necessary for update action.
                                            if (!$choice->isNewRecord) {
                                                echo Html::activeHiddenInput($choice, "[{$index}]id");
                                            }
                                        ?>

                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-md-11">
                                                        <label>Value</label>
                                                        <?= $form->field($choice, "[{$index}]value")->textInput(['maxlength' => true])->label(false) ?>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label>&nbsp;</label><br>
                                                        <button type="button" class="remove-item btn btn-flat btn-danger btn-xs">delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php DynamicFormWidget::end(); ?>
                <br>
            </div>
        </div>
    </div>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$url = \yii\helpers\Url::to(['dropdown-json/get-cat-content-type-id']);
$this->registerJs("

    $(document).ready(function(){

        // $('#divType').hide();

        var js_category_id = $('#indicator-category_id').val();
        var in_chart = $('#indicator-in_chart').val();

        if(in_chart == '1' || in_chart == '0')
        {
            $('#partof_chart').slideDown(300);
        }
        else
        {
            $('#partof_chart').hide();
        }

        $.ajax({
            url: '".$url."',
            data: { 
                    category_id:js_category_id,
                    }
            
            }).done(function(result) {

                // 4 - image / 5 - slide images / 6 - pdf / 11 - downloadables 

                if(result == '4' || result == '5' || result == '6' || result == '11')
                {
                    // $('#divFreq').hide();
                    // $('#divUnit').hide();
                    // $('#divDefaultChoice').hide();
                    // $('#divType').hide();
                }
                else if(result == '9' || result == '10')
                {
                    $('#divUnit').show();
                    $('#divDefaultChoice').show();
                }
                else if(result == '8')
                {
                    $('#divUnit').hide();
                    $('#divType').hide();
                    $('#divDefaultChoice').hide();
                    $('#divChoice').hide();
                }
                else
                {
                    // $('#divType').show();
                }
                $('#indicator-temp_content_type_id').val(result);
                
        });


    });

    if($('#indicator-type_id').val()==''){      
        // $('#divFreq').hide();
        $('#divUnit').hide();
    }

    $('#indicator-type_id').on('change', function(){ 
         if($('#indicator-type_id').val()=='2' || $('#indicator-type_id').val()=='5' || $('#indicator-type_id').val()=='6' || $('#indicator-type_id').val()=='7'){      
            $('#divFreq').show();
            $('#divUnit').show();
         }
         else if($('#indicator-type_id').val()=='1' || $('#indicator-type_id').val()=='3' || $('#indicator-type_id').val()=='4'){
            $('#divUnit').hide();
            $('#divFreq').show();
            $('#divDefaultChoice').hide();
         }
    });


     if($('#indicator-unit_id').val()==''){      
        $('#divDefaultChoice').hide();
     }

    $('#indicator-unit_id').on('change', function(){ 
         if($('#indicator-unit_id').val()=='7'){      
            $('#divDefaultChoice').show();
         }
         else{
            $('#divDefaultChoice').hide();
         }
    });




    if($('#indicator-default_choice_id').val()==''){      
         $('#divDefaultChoice').hide();
     }

    $('#indicator-default_choice_id').on('change', function(){ 
         if($('#indicator-default_choice_id').val()=='1'){      
            $('#divChoice').show();
            $('#choice-0-value').prop('required',true);
         }
         else{
            $('#divChoice').hide();
         }
    });

");
// $this->registerJsFile('js/modal.js',array("dependency"=>"jquery"));

?>