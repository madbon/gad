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
                                            placeholder:"Select Activity Category",
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
                    echo $this->render('common_tools/textarea_suggest',[
                        'placeholder_title' => "Gender Issue Supporting Statistics Data",
                        'attribute_name' => "gi_sup_data",
                        'urlLoadResult' => '',
                        'rowsValue' => 3,
                        'classValue' => 'form-control',
                        'customStyle' => 'margin-top:5px; display:none;',
                    ]);
                ?>
                <?php
                    echo $this->render('common_tools/textarea_suggest',[
                        'placeholder_title' => "Title / Description of Gender Issue or GAD Mandate",
                        'attribute_name' => "ppa_value",
                        'urlLoadResult' => '/report/default/load-ppa-value',
                        'rowsValue' => 3,
                        'classValue' => 'form-control',
                        'customStyle' => 'margin-top:5px;',
                    ]);
                ?>
                <br/>
                <?php
                // print_r($select_PpaAttributedProgram); exit;
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
                <?php
                    echo $this->render('common_tools/textarea_suggest',[
                        'placeholder_title' => "Relevant LGU Program or Project",
                        'attribute_name' => "relevant_lgu_program_project",
                        'urlLoadResult' => '/report/default/load-relevant-lgu',
                        'rowsValue' => 2,
                        'classValue' => 'form-control',
                        'customStyle' => 'margin-top:10px;',
                    ]);
                ?>
            </div>
            <div class="col-sm-4">
                
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
                    echo $this->render('common_tools/textarea_suggest',[
                        'placeholder_title' => "Pls. Specify Other Activity Category",
                        'attribute_name' => "cause_gender_issue",
                        'urlLoadResult' => '/report/default/load-cause-gender-issue',
                        'rowsValue' => 2,
                        'classValue' => 'form-control',
                        'customStyle' => 'margin-top:5px; display:none;',
                    ]);
                ?>
                <?php
                    echo $this->render('common_tools/textarea_suggest',[
                        'placeholder_title' => "GAD Activity",
                        'attribute_name' => "activity",
                        'urlLoadResult' => '/report/default/load-activity',
                        'rowsValue' => 2,
                        'classValue' => 'form-control',
                        'customStyle' => 'margin-top:5px;',
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
                            var ppa_sectors = $("#cliorg_ppa_attributed_program_id").val();
                            var cliorg_ppa_attributed_program_id = ppa_sectors.toString();
                            var gi_sup_data = $("#gi_sup_data").val();

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

                                        // keypress remove error message for moee,ps,co
                                        $("#budget_mooe").keyup(function(){
                                            $("#messagete-budget_mooe").text("");
                                            $("#budget_mooe").css({"border":"1px solid #ccc"});

                                            $("#messagete-budget_ps").text("");
                                            $("#budget_ps").css({"border":"1px solid #ccc"});

                                            $("#messagete-budget_co").text("");
                                            $("#budget_co").css({"border":"1px solid #ccc"});
                                        });
                                        $("#budget_ps").keyup(function(){
                                            $("#messagete-budget_mooe").text("");
                                            $("#budget_mooe").css({"border":"1px solid #ccc"});

                                            $("#messagete-budget_ps").text("");
                                            $("#budget_ps").css({"border":"1px solid #ccc"});

                                            $("#messagete-budget_co").text("");
                                            $("#budget_co").css({"border":"1px solid #ccc"});
                                        });
                                        $("#budget_co").keyup(function(){
                                            $("#messagete-budget_mooe").text("");
                                            $("#budget_mooe").css({"border":"1px solid #ccc"});

                                            $("#messagete-budget_ps").text("");
                                            $("#budget_ps").css({"border":"1px solid #ccc"});

                                            $("#messagete-budget_co").text("");
                                            $("#budget_co").css({"border":"1px solid #ccc"});
                                        });

                                        if($("#ppa_focused_id").val() == "")
                                        {
                                            $("#messageta-cause_gender_issue").hide();
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
                
