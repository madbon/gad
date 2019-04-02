<?php
use yii\helpers\Html;
use kartik\select2\Select2;
?>

<div class="row">
    <div class="col-sm-4">
        <?php
            $urlLoadPpaCategory = \yii\helpers\Url::to(['/report/default/load-ppa-category']);
            echo Select2::widget([
                'name' => 'focused_id',
                'data' => $select_GadFocused,
                'options' => [
                    'placeholder' => 'Select Focused',
                    'id' => "focused_id",
                ],
                'pluginEvents'=>[
                    'select2:select'=>'
                        function(){
                            $("#message-focused_id").text("");
                            $("#select2-focused_id-container").parent(".select2-selection").css({"border":"1px solid #ccc"});

                            var focused_id = this.value;

                            $.ajax({
                                url: "'.$urlLoadPpaCategory.'",
                                data: { 
                                        focused_id:focused_id
                                      }
                            }).done(function(result){
                                var newOption = $("<option>");
                                $("#ppa_focused_id").html("").select2(
                                {
                                    data:result, 
                                    theme:"krajee", 
                                    allowClear:true, 
                                    width:"100%", 
                                    placeholder:"Select PPA Category",
                                });
                                
                                newOption.attr("value","0").text("Others");
                                $("#ppa_focused_id").append(newOption);

                            });
                        }',
                ]     
            ]);
        ?>
        <br/>
        <?php
            echo Select2::widget([
                'name' => 'ppa_focused_id',
                'data' => [],
                'options' => [
                    'placeholder' => 'Category of PPA',
                    'id' => "ppa_focused_id",
                ],
                'pluginEvents'=>[
                    'select2:select'=>'
                        function(){
                            $("#message-ppa_focused_id").text("");
                            $("#select2-ppa_focused_id-container").parent(".select2-selection").css({"border":"1px solid #ccc"});
                            if(this.value == "0")
                            {
                                $("#ppa_value").slideDown(300);
                                $("#message-ppa_value").show();
                            }
                            else
                            {
                                $("#ppa_value").slideUp(300);
                                $("#ppa_value").val("");
                                $("#message-ppa_value").hide();
                            }
                        }',
                ]     
            ]);
        ?>
                
        <?php
            echo $this->render('/gad-plan-budget/common_tools/textarea_suggest',[
                'placeholder_title' => "Please specify here (PPA Other Description)",
                'attribute_name' => "ppa_value",
                'urlLoadResult' => '/report/default/load-ppa-value',
                'rowsValue' => 3,
                'classValue' => 'form-control legit',
                'customStyle' => 'display:none; margin-top:10px;',
            ]);
        ?>

        <br/>
        <?php
            echo Select2::widget([
                'name' => 'inner_category_id',
                'data' => $select_GadInnerCategory,
                'options' => [
                    'placeholder' => 'Gender Issue or GAD Mandate',
                    'id' => "inner_category_id",
                ],
                'pluginEvents'=>[
                    'select2:select'=>'
                        function(){
                            $("#message-inner_category_id").text("");
                            $("#select2-inner_category_id-container").parent(".select2-selection").css({"border":"1px solid #ccc"});
                        }',
                ]     
            ]);
        ?>

        <?php
            echo $this->render('/gad-plan-budget/common_tools/textarea_suggest',[
                'placeholder_title' => "Cause of Gender Issue",
                'attribute_name' => "cause_gender_issue",
                'urlLoadResult' => '/report/default/load-ppa-value',
                'rowsValue' => 3,
                'classValue' => 'form-control',
                'customStyle' => 'margin-top:20px;',
            ]);
        ?>

        <?php
            echo $this->render('/gad-plan-budget/common_tools/textarea_suggest',[
                'placeholder_title' => "GAD Objective",
                'attribute_name' => "objective",
                'urlLoadResult' => '/report/default/load-ppa-value',
                'rowsValue' => 3,
                'classValue' => 'form-control',
                'customStyle' => 'margin-top:20px;',
            ]);
        ?>
    </div>
    <div class="col-sm-4">
        <?php
            echo $this->render('/gad-plan-budget/common_tools/textarea_suggest',[
                'placeholder_title' => "Relevant LGU PPA",
                'attribute_name' => "relevant_lgu_ppa",
                'urlLoadResult' => '/report/default/load-ppa-value',
                'rowsValue' => 2,
                'classValue' => 'form-control',
                'customStyle' => '',
            ]);
        ?>
        <?php
            echo $this->render('/gad-plan-budget/common_tools/textarea_suggest',[
                'placeholder_title' => "GAD Activity",
                'attribute_name' => "activity",
                'urlLoadResult' => '/report/default/load-ppa-value',
                'rowsValue' => 2,
                'classValue' => 'form-control',
                'customStyle' => 'margin-top:20px;',
            ]);
        ?>
        <?php
            echo $this->render('/gad-plan-budget/common_tools/textarea_suggest',[
                'placeholder_title' => "Performance Indicator",
                'attribute_name' => "performance_indicator",
                'urlLoadResult' => '/report/default/load-ppa-value',
                'rowsValue' => 2,
                'classValue' => 'form-control',
                'customStyle' => 'margin-top:20px;',
            ]);
        ?>
        <?php
            echo $this->render('/gad-plan-budget/common_tools/textarea_suggest',[
                'placeholder_title' => "Target",
                'attribute_name' => "target",
                'urlLoadResult' => '/report/default/load-ppa-value',
                'rowsValue' => 2,
                'classValue' => 'form-control',
                'customStyle' => 'margin-top:20px;',
            ]);
        ?>
    </div>
    <div class="col-sm-4">
        <?php
            echo $this->render('/gad-plan-budget/common_tools/textarea_suggest',[
                'placeholder_title' => "Actual Results",
                'attribute_name' => "actual_results",
                'urlLoadResult' => '/report/default/load-ppa-value',
                'rowsValue' => 2,
                'classValue' => 'form-control',
                'customStyle' => '',
            ]);
        ?>
        <?php
            echo $this->render('/gad-plan-budget/common_tools/textinput_suggest',[
                'placeholder_title' => "Total Approved GAD Budget",
                'attribute_name' => "total_approved_gad_budget",
                'urlLoadResult' => '/report/default/load-budget-co',
                'classValue' => 'form-control',
                'customStyle' => 'margin-top:20px;',
            ]);
        ?>
        <?php
            echo $this->render('/gad-plan-budget/common_tools/textinput_suggest',[
                'placeholder_title' => "Actual Cost or Expenditure",
                'attribute_name' => "actual_cost_expenditure",
                'urlLoadResult' => '/report/default/load-budget-co',
                'classValue' => 'form-control',
                'customStyle' => 'margin-top:20px;',
            ]);
        ?>
        <?php
            echo $this->render('/gad-plan-budget/common_tools/textarea_suggest',[
                'placeholder_title' => "Variance Remarks",
                'attribute_name' => "variance_remarks",
                'urlLoadResult' => '/report/default/load-ppa-value',
                'rowsValue' => 2,
                'classValue' => 'form-control',
                'customStyle' => 'margin-top:20px;',
            ]);
        ?>

        <button id="saveClientOrg" type="button" class="btn btn-primary btn-sm" style="margin-top: 8px;">
            <span class="glyphicon glyphicon-floppy-disk"></span> Save
        </button>
        <?php
            $url = \yii\helpers\Url::to(['/report/default/create-accomplishment-report']);
            $this->registerJs('
                $("#saveClientOrg").click(function(){
                    var focused_id                  = $.trim($("#focused_id").val());
                    var ppa_focused_id              = $.trim($("#ppa_focused_id").val());
                    var cause_gender_issue          = $.trim($("#cause_gender_issue").val());
                    var objective                   = $.trim($("#objective").val());
                    var relevant_lgu_ppa            = $.trim($("#relevant_lgu_ppa").val());
                    var activity                    = $.trim($("#activity").val());
                    var performance_indicator       = $.trim($("#performance_indicator").val());
                    var target                      = $.trim($("#target").val());
                    var actual_results              = $.trim($("#actual_results").val());
                    var total_approved_gad_budget   = $.trim($("#total_approved_gad_budget").val());
                    var actual_cost_expenditure     = $.trim($("#actual_cost_expenditure").val());
                    var variance_remarks            = $.trim($("#variance_remarks").val());
                    var ppa_value                   = $.trim($("#ppa_value").val());
                    var inner_category_id           = $.trim($("#inner_category_id").val());
                    var ruc                         = "'.$ruc.'";
                    var onstep                      = "'.$onstep.'";

                    $.ajax({
                        url: "'.$url.'",
                        data: { 
                                focused_id:focused_id,
                                ppa_focused_id:ppa_focused_id,
                                cause_gender_issue:cause_gender_issue,
                                objective:objective,
                                relevant_lgu_ppa:relevant_lgu_ppa,
                                activity:activity,
                                performance_indicator:performance_indicator,
                                target:target,
                                actual_results:actual_results,
                                total_approved_gad_budget:total_approved_gad_budget,
                                actual_cost_expenditure:actual_cost_expenditure,
                                variance_remarks:variance_remarks,
                                ppa_value:ppa_value,
                                inner_category_id:inner_category_id,
                                ruc:ruc,
                                onstep:onstep,
                            }
                        
                        }).done(function(result) {
                            $.each(result, function( index, value ) {
                                
                                $("p#message-"+index+"").text("");
                                $("textarea#"+index+"").css({"border":"1px solid red"});
                                $("textarea#"+index+"").after("<p id=message-"+index+" style=color:red;font-style:italic;>"+value+"</p>");

                                $("input#"+index+"").css({"border":"1px solid red"});
                                $("input#"+index+"").after("<p id=message-"+index+" style=color:red;font-style:italic;>"+value+"</p>");

                                $("#select2-"+index+"-container").parent(".select2-selection").css({"border":"1px solid red"});
                                $("#select2-"+index+"-container").parent(".select2-selection").after("<p id=message-"+index+" style=color:red;font-style:italic;>"+value+"</p>");

                                // $("#select2-"+index+"-container").text
                                
                                $("textarea#"+index+"").keyup(function(){
                                    $("#message-"+index+"").text("");
                                    $(this).css({"border":"1px solid #ccc"});
                                });

                                $("input#"+index+"").keyup(function(){
                                    $("#message-"+index+"").text("");
                                    $(this).css({"border":"1px solid #ccc"});
                                });

                                if($("#ppa_focused_id").val() == "")
                                {
                                    $("#message-ppa_value").hide();
                                }
                            });
                    });
              }); ');
        ?>
        <button type="button" class="btn btn-danger btn-sm" style="margin-top: 8px;">
            <span class="glyphicon glyphicon-remove"></span> Close
        </button>
    </div>
</div>

<br/>