<?php
use yii\helpers\Html;
use kartik\select2\Select2;
?>
<style type="text/css">
    tr#row-input-form td
    {
        border:none;
        background-color: white;
    }
</style>
<tr id="genderIssueInputForm" style="display: none;">
    <td colspan='12'>
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
                    echo $this->render('common_tools/textarea_suggest',[
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
                <br/>
                <?php
                    echo $this->render('common_tools/textarea_suggest',[
                        'placeholder_title' => "Cause of the Gender Issue",
                        'attribute_name' => "cause_gender_issue",
                        'urlLoadResult' => '/report/default/load-cause-gender-issue',
                        'rowsValue' => 2,
                        'classValue' => 'form-control',
                        'customStyle' => '',
                    ]);
                ?>
                <br/>
                <?php
                    echo $this->render('common_tools/textarea_suggest',[
                        'placeholder_title' => "GAD Objective",
                        'attribute_name' => "objective",
                        'urlLoadResult' => '/report/default/load-pb-objective',
                        'rowsValue' => 2,
                        'classValue' => 'form-control',
                        'customStyle' => '',
                    ]);
                ?>
            </div>
            <div class="col-sm-4">
                <?php
                    echo $this->render('common_tools/textarea_suggest',[
                        'placeholder_title' => "Relevant LGU Program or Project",
                        'attribute_name' => "relevant_lgu_program_project",
                        'urlLoadResult' => '/report/default/load-relevant-lgu',
                        'rowsValue' => 2,
                        'classValue' => 'form-control',
                        'customStyle' => '',
                    ]);
                ?>
                <br/>
                <?php
                    echo $this->render('common_tools/textarea_suggest',[
                        'placeholder_title' => "GAD Activity",
                        'attribute_name' => "activity",
                        'urlLoadResult' => '/report/default/load-activity',
                        'rowsValue' => 2,
                        'classValue' => 'form-control',
                        'customStyle' => '',
                    ]);
                ?>
                <br/>
                <?php
                    echo $this->render('common_tools/textarea_suggest',[
                        'placeholder_title' => "Performance Target",
                        'attribute_name' => "performance_target",
                        'urlLoadResult' => '/report/default/load-performance-target',
                        'rowsValue' => 2,
                        'classValue' => 'form-control',
                        'customStyle' => '',
                    ]);
                ?>
                <br/>
                <?php
                    echo $this->render('common_tools/textarea_suggest',[
                        'placeholder_title' => "Performance Indicator",
                        'attribute_name' => "performance_indicator",
                        'urlLoadResult' => '/report/default/load-performance-indicator',
                        'rowsValue' => 2,
                        'classValue' => 'form-control',
                        'customStyle' => '',
                    ]);
                ?>
            </div>
            <div class="col-sm-4">
                <?php
                    echo $this->render('common_tools/textinput_suggest',[
                        'placeholder_title' => "MOOE",
                        'attribute_name' => "budget_mooe",
                        'urlLoadResult' => '/report/default/load-budget-mooe',
                        'classValue' => 'form-control',
                        'customStyle' => '',
                    ]);
                ?>
                <br/>
                <?php
                    echo $this->render('common_tools/textinput_suggest',[
                        'placeholder_title' => "PS",
                        'attribute_name' => "budget_ps",
                        'urlLoadResult' => '/report/default/load-budget-ps',
                        'classValue' => 'form-control',
                        'customStyle' => '',
                    ]);
                ?>
                <br/>
                <?php
                    echo $this->render('common_tools/textinput_suggest',[
                        'placeholder_title' => "CO",
                        'attribute_name' => "budget_co",
                        'urlLoadResult' => '/report/default/load-budget-co',
                        'classValue' => 'form-control',
                        'customStyle' => '',
                    ]);
                ?>
                <br/>
                <?php
                    echo $this->render('common_tools/textarea_suggest',[
                        'placeholder_title' => "Lead or Responsible Office",
                        'attribute_name' => "lead_responsible_office",
                        'urlLoadResult' => '/report/default/load-lead-responsible',
                        'rowsValue' => 2,
                        'classValue' => 'form-control',
                        'customStyle' => '',
                    ]);
                ?>
                <br/>
                <button type="button" class="btn btn-primary btn-sm" title="Save" id="save-gender-issue">
                    <span class="glyphicon glyphicon-floppy-disk"></span> Save
                </button>
                <?php
                    $url = \yii\helpers\Url::to(['/report/default/create-gad-plan-budget']);
                    $this->registerJs('
                        $("#save-gender-issue").click(function(){
                            var ppa_focused_id = $("#ppa_focused_id").val();
                            var ppa_value     = $("#ppa_value").val();
                            var issue       = $("#cause_gender_issue").val();
                            var obj         = $("#objective").val();
                            var relevant    = $("#relevant_lgu_program_project").val();
                            var act         = $("#activity").val();
                            var performance_target     = $("#performance_target").val();
                            var performance_indicator     = $("#performance_indicator").val();
                            var budget_mooe = $("#budget_mooe").val();
                            var budget_ps   = $("#budget_ps").val();
                            var budget_co   = $("#budget_co").val();
                            var lead_responsible_office   = $("#lead_responsible_office").val();
                            var ruc         = "'.$ruc.'";
                            var focused_id = $("#focused_id").val();
                            var inner_category_id = $("#inner_category_id").val();
                            var onstep = "'.$onstep.'";
                            var tocreate = "'.$tocreate.'";
                            $.ajax({
                                url: "'.$url.'",
                                data: { 
                                        issue:issue,
                                        obj:obj,
                                        relevant:relevant,
                                        act:act,
                                        performance_indicator:performance_indicator,
                                        performance_target:performance_target,
                                        ruc:ruc,
                                        ppa_focused_id:ppa_focused_id,
                                        ppa_value:ppa_value,
                                        budget_mooe:budget_mooe,
                                        budget_ps:budget_ps,
                                        budget_co:budget_co,
                                        lead_responsible_office:lead_responsible_office,
                                        focused_id:focused_id,
                                        inner_category_id:inner_category_id,
                                        onstep:onstep,
                                        tocreate:tocreate
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
                <button type="button" class="btn btn-danger btn-sm" title="Close" id="exit-gender-issue">
                    <span class="glyphicon glyphicon-remove"></span> Close
                </button>
                <?php
                    $urlSetSession = \yii\helpers\Url::to(['default/session-encode']);
                    $this->registerJs("
                        $('#exit-gender-issue').click(function(){
                            var trigger = 'closed';
                            var form_type = 'gender_issue';
                            var report_type = 'pb';
                            $.ajax({
                                url: '".$urlSetSession."',
                                data: { 
                                        trigger:trigger,
                                        form_type:form_type,
                                        report_type:report_type
                                        }
                                
                                }).done(function(result) {
                                    
                            });
                            $('#inputFormPlan').slideUp(300);
                        });
                    ");
                ?>
            </div>
        </div>
                
    </td>
 </tr>
                
