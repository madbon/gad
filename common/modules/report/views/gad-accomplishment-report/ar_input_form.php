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
                            $("#messages2-focused_id").text("");
                            $("#focused_id").next("span").css({"border":"none"});

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
                'name' => 'inner_category_id',
                'data' => $select_GadInnerCategory,
                'options' => [
                    'placeholder' => 'Gender Issue or GAD Mandate',
                    'id' => "inner_category_id",
                ],
                'pluginEvents'=>[
                    'select2:select'=>'
                        function(){
                            $("#messages2-inner_category_id").text("");
                            $("#inner_category_id").next("span").css({"border":"none"});

                            if(this.value == "1")
                            {
                                $("#gi_sup_data").slideDown(300);
                                $("#ppa_value").attr("placeholder","Title / Description of Gender Issue");
                            }
                            else
                            {
                                $("#gi_sup_data").slideUp(300);
                                $("#ppa_value").attr("placeholder","Title / Description of GAD Mandate");
                            }
                        }',
                ]     
            ]);
        ?>

        <?php
            echo $this->render('/gad-plan-budget/common_tools/textarea_suggest',[
                'placeholder_title' => "Gender Issue Supporting Statistics Data",
                'attribute_name' => "gi_sup_data",
                'urlLoadResult' => '#',
                'rowsValue' => 3,
                'classValue' => 'form-control',
                'customStyle' => 'margin-top:5px; display:none;',
            ]);
        ?>

        <?php
            echo $this->render('/gad-plan-budget/common_tools/textarea_suggest',[
                'placeholder_title' => "Title / Description of Gender Issue or GAD Mandate",
                'attribute_name' => "ppa_value",
                'urlLoadResult' => '/report/default/load-ar-ppa-value',
                'rowsValue' => 3,
                'classValue' => 'form-control',
                'customStyle' => 'margin-top:5px;',
            ]);
        ?>
        <br/>
        <?php
            echo Select2::widget([
                'name' => 'ppa_attributed_program_id',
                'data' => $select_PpaAttributedProgram,
                'options' => [
                    'placeholder' => 'Tag PPA Sectors',
                    'id' => "cliorg_ppa_attributed_program_id",
                    'multiple' => true,
                ],
                'pluginEvents'=>[
                    'select2:select'=>'
                        function(){
                            $("#message-cliorg_ppa_attributed_program_id").text("");
                            $("#select2-cliorg_ppa_attributed_program_id-container").parent(".select2-selection").css({"border":"1px solid #ccc"});
                        }',
                ]     
            ]);
        ?>

        <?php
            echo $this->render('/gad-plan-budget/common_tools/textarea_suggest',[
                'placeholder_title' => "GAD Objective",
                'attribute_name' => "objective",
                'urlLoadResult' => '/report/default/load-ar-objective',
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
                'urlLoadResult' => '/report/default/load-ar-relevant-lgu-ppa',
                'rowsValue' => 2,
                'classValue' => 'form-control',
                'customStyle' => '',
            ]);
        ?>
        <!-- Activity Category -->
        <br/>
        <?php
            // Activity Category
            echo Select2::widget([
                'name' => 'ppa_focused_id',
                'data' => [],
                'options' => [
                    'placeholder' => 'Activity Category',
                    'id' => "ppa_focused_id",
                ],
                'pluginEvents'=>[
                    'select2:select'=>'
                        function(){
                            $("#messages2-ppa_focused_id").text("");
                            $("#ppa_focused_id").next("span").css({"border":"none"});

                            if(this.value == "0")
                            {
                                $("#cause_gender_issue").slideDown(300);
                                $("#message-cause_gender_issue").show();
                            }
                            else
                            {
                                $("#cause_gender_issue").slideUp(300);
                                $("#cause_gender_issue").val("");
                                $("#message-cause_gender_issue").hide();
                            }
                        }',
                ]     
            ]);
        ?>

        <?php
            // Other Activity Category
            echo $this->render('/gad-plan-budget/common_tools/textarea_suggest',[
                'placeholder_title' => "Pls. Specify Other Activity Category",
                'attribute_name' => "cause_gender_issue",
                'urlLoadResult' => '/report/default/load-cause-gender-issue',
                'rowsValue' => 2,
                'classValue' => 'form-control',
                'customStyle' => 'margin-top:5px; display:none;',
            ]);
        ?>
        <?php
            echo $this->render('/gad-plan-budget/common_tools/textarea_suggest',[
                'placeholder_title' => "GAD Activity",
                'attribute_name' => "activity",
                'urlLoadResult' => '/report/default/load-ar-activity',
                'rowsValue' => 2,
                'classValue' => 'form-control',
                'customStyle' => 'margin-top:5px;',
            ]);
        ?>
        
        <?php
            echo $this->render('/gad-plan-budget/common_tools/textarea_suggest',[
                'placeholder_title' => "Performance Indicator and Target",
                'attribute_name' => "performance_indicator",
                'urlLoadResult' => '/report/default/load-ar-performance-indicator',
                'rowsValue' => 2,
                'classValue' => 'form-control',
                'customStyle' => 'margin-top:20px;',
            ]);
        ?>
        <?php
            // echo $this->render('/gad-plan-budget/common_tools/textarea_suggest',[
            //     'placeholder_title' => "Target",
            //     'attribute_name' => "target",
            //     'urlLoadResult' => '/report/default/load-ar-target',
            //     'rowsValue' => 2,
            //     'classValue' => 'form-control',
            //     'customStyle' => 'margin-top:20px;',
            // ]);
        ?>
    </div>
    <div class="col-sm-4">
        <?php
            echo $this->render('/gad-plan-budget/common_tools/textarea_suggest',[
                'placeholder_title' => "Actual Results",
                'attribute_name' => "actual_results",
                'urlLoadResult' => '/report/default/load-ar-actual-results',
                'rowsValue' => 2,
                'classValue' => 'form-control',
                'customStyle' => '',
            ]);
        ?>
        <?php
            echo $this->render('/gad-plan-budget/common_tools/textinput_suggest',[
                'placeholder_title' => "Total Approved GAD Budget",
                'attribute_name' => "total_approved_gad_budget",
                'urlLoadResult' => '/report/default/load-ar-total-approved-gad-budget',
                'classValue' => 'form-control',
                'customStyle' => 'margin-top:20px;',
            ]);
        ?>
        <?php
            echo $this->render('/gad-plan-budget/common_tools/textinput_suggest',[
                'placeholder_title' => "Actual Cost or Expenditure",
                'attribute_name' => "actual_cost_expenditure",
                'urlLoadResult' => '/report/default/load-ar-actual-cost-expenditure',
                'classValue' => 'form-control',
                'customStyle' => 'margin-top:20px;',
            ]);
        ?>
        <?php
            // echo $this->render('/gad-plan-budget/common_tools/textarea_suggest',[
            //     'placeholder_title' => "Variance Remarks",
            //     'attribute_name' => "variance_remarks",
            //     'urlLoadResult' => '/report/default/load-ppa-value',
            //     'rowsValue' => 2,
            //     'classValue' => 'form-control',
            //     'customStyle' => 'margin-top:20px;',
            // ]);
        ?>
        <textarea style="margin-top: 20px;" placeholder="Variance or Remarks" id="variance_remarks" rows="2" class="form-control"></textarea>

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
                    var tocreate                    = "'.$tocreate.'";
                    var ppa_sectors = $("#cliorg_ppa_attributed_program_id").val();
                    var cliorg_ppa_attributed_program_id = ppa_sectors.toString();
                    var gi_sup_data = $("#gi_sup_data").val();

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
                                tocreate:tocreate,
                                cliorg_ppa_attributed_program_id:cliorg_ppa_attributed_program_id,
                                gi_sup_data:gi_sup_data
                            }
                        
                        }).done(function(result) {
                            $.each(result, function( index, value ) {
                                
                                // error in select2
                                $("p#messages2-"+index+"").text("");
                                $("#"+index+"").next("span").css({"border":"1px solid red","border-radius":"5px"});
                                $("#"+index+"").next("span").after("<p id=messages2-"+index+" style=color:red;font-style:italic;>"+value+"</p>");
                                // error in textarea
                                $("p#messageta-"+index+"").text("");
                                $("textarea#"+index+"").css({"border":"1px solid red"});
                                $("textarea#"+index+"").after("<p id=messageta-"+index+" style=color:red;font-style:italic;>"+value+"</p>");
                                // error in textbox
                                $("p#messagete-"+index+"").text("");
                                $("input#"+index+"").css({"border":"1px solid red"});
                                $("input#"+index+"").after("<p id=messagete-"+index+" style=color:red;font-style:italic;>"+value+"</p>");

                                // keypress remove error message
                                $("textarea#"+index+"").keyup(function(){
                                    $("#messageta-"+index+"").text("");
                                    $(this).css({"border":"1px solid #ccc"});
                                });

                                $("input#"+index+"").keyup(function(){
                                    $("#messagete-"+index+"").text("");
                                    $(this).css({"border":"1px solid #ccc"});
                                });

                                if($("#ppa_focused_id").val() == "")
                                {
                                    $("#messageta-cause_gender_issue").hide();
                                }
                            });
                    });
              }); ');
        ?>
        <button id="btnClose" type="button" class="btn btn-danger btn-sm" style="margin-top: 8px;">
            <span class="glyphicon glyphicon-remove"></span> Close
        </button>
        <?php
            $urlSetSession = \yii\helpers\Url::to(['default/session-encode']);
            $this->registerJs("
                $('#btnClose').click(function(){
                    var trigger = 'close';
                    var form_type = 'gender_issue';
                    var report_type = 'ar';
                    $.ajax({
                        url: '".$urlSetSession."',
                        data: { 
                                trigger:trigger,
                                form_type:form_type,
                                report_type:report_type
                                }
                        
                        }).done(function(result) {
                            $('#input-form-gender').slideUp(300);
                    });
                });
            ");
        ?>
    </div>
</div>

<br/>