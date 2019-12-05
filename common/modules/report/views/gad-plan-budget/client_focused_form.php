<?php
use yii\helpers\Html;
use kartik\select2\Select2;
// use yii\widgets\ActiveForm;
use richardfan\widget\JSRegister;
use kartik\date\DatePicker;
use kartik\field\FieldRange;
use kartik\form\ActiveForm;
use kartik\daterange\DateRangePicker;
?>
<style type="text/css">
    tr#row-input-form td
    {
        border:none;
        background-color: white;
    }
    .file-drop-zone-title
    {
        background-color: white;
    }
    .file-drop-zone
    {
        background-color: gray;
    }
    .file-preview 
    {
        background-color: #c0b2b2;
    }
    div.clearfix
    {
        background-color: white;
    }
    div.file-preview-frame
    {
        background-color: #cdc6d2;
    }
    .help-block, .has-star, .warningmess
    {
        color:#e79f9f !important;
    }
    .help-block
    {
        font-style: italic;
    }

</style>
<?php
$addon = <<< HTML
<div class="input-group-append">
    <span class="input-group-text">
        <i class="fas fa-calendar-alt"></i>
    </span>
</div>
HTML;
?>
<?php $form = ActiveForm::begin(); ?>
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
                                }',
                        ]     
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

                <?php
                    // echo $this->render('common_tools/textarea_suggest',[
                    //     'placeholder_title' => "Supporting Statistics Data",
                    //     'attribute_name' => "gi_sup_data",
                    //     'urlLoadResult' => '',
                    //     'rowsValue' => 3,
                    //     'classValue' => 'form-control',
                    //     'customStyle' => 'margin-top:5px; ',
                    // ]);
                ?>

                <textarea style="margin-top: 5px;" rows="3" id="gi_sup_data" placeholder="Supporting Statistics Data" class="form-control"></textarea>

                <input type="input" class="form-control" placeholder="Source of Supporting Statistics Data" style="margin-top: 5px;" id="source">
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
                    // // Activity Category
                    // echo Select2::widget([
                    //     'name' => 'ppa_focused_id',
                    //     'data' => [],
                    //     'options' => [
                    //         'placeholder' => 'Activity Category',
                    //         'id' => "ppa_focused_id",
                    //     ],
                    //     'pluginEvents'=>[
                    //         'select2:select'=>'
                    //             function(){
                    //                 $("#messages2-ppa_focused_id").text("");
                    //                 $("#ppa_focused_id").next("span").css({"border":"none"});

                    //                 if(this.value == "0")
                    //                 {
                    //                     $("#cause_gender_issue").slideDown(300);
                    //                     $("#message-cause_gender_issue").show();
                    //                 }
                    //                 else
                    //                 {
                    //                     $("#cause_gender_issue").slideUp(300);
                    //                     $("#cause_gender_issue").val("");
                    //                     $("#message-cause_gender_issue").hide();
                    //                 }
                    //             }',
                    //     ]     
                    // ]);
                ?>
                <?= $form->field($model, 'ppa_focused_id')->hiddenInput(['maxlength' => true, 'id' => 'ppa_focused_id'])->label(false) ?>
                <?= $form->field($model, 'cause_gender_issue')->hiddenInput(['maxlength' => true, 'id' => 'cause_gender_issue'])->label(false) ?>
                <?php
                    // Other Activity Category
                    // echo $this->render('common_tools/textarea_suggest',[
                    //     'placeholder_title' => "Pls. Specify Other Activity Category",
                    //     'attribute_name' => "cause_gender_issue",
                    //     'urlLoadResult' => '/report/default/load-cause-gender-issue',
                    //     'rowsValue' => 2,
                    //     'classValue' => 'form-control',
                    //     'customStyle' => 'margin-top:5px; display:none;',
                    // ]);
                ?>
                <?php
                // print_r($select_PpaAttributedProgram); exit;
                    echo Select2::widget([
                        'name' => 'activity_category_id',
                        'data' => $select_ActivityCategory,
                        'options' => [
                            'placeholder' => 'Tag Activity Category',
                            'id' => "activity_category_id",
                            'multiple' => true,
                        ],
                        'pluginEvents'=>[
                            'select2:select'=>'
                                function(){
                                    $("#message-activity_category_id").text("");
                                    $("#select2-activity_category_id-container").parent(".select2-selection").css({"border":"1px solid #ccc"});
                                }',
                        ]     
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
                    echo $form->field($model, 'date_implement_start', [
                        'addon'=>['prepend'=>['content'=>'<i class="fas fa-calendar-alt"></i>']],
                        'options'=>['class'=>'drp-container form-group'],
                    ])->widget(DateRangePicker::classname(), [
                        'useWithAddon'=>true,
                        'pluginOptions'=>[
                            'locale'=>[
                                'separator'=>' to ',
                            ],
                            'opens'=>'left'
                        ],
                        'pluginEvents'=>[
                            "changeDate" => "function(e) {  
                                var value = this.val;
                                $('#gadplanbudget-date_implement_start').val(value);
                             }",
                        ],  
                    ]);
                ?>
               
                <?php
                    echo $this->render('common_tools/textarea_suggest',[
                        'placeholder_title' => "Performance Target / Indicator",
                        'attribute_name' => "performance_target",
                        'urlLoadResult' => '/report/default/load-performance-target',
                        'rowsValue' => 2,
                        'classValue' => 'form-control',
                        'customStyle' => '',
                    ]);
                ?>
                <br/>
                <?php
                    // echo $this->render('common_tools/textarea_suggest',[
                    //     'placeholder_title' => "Performance Indicator",
                    //     'attribute_name' => "performance_indicator",
                    //     'urlLoadResult' => '/report/default/load-performance-indicator',
                    //     'rowsValue' => 2,
                    //     'classValue' => 'form-control',
                    //     'customStyle' => '',
                    // ]);
                ?>
            </div>
            <div class="col-sm-4">
                <?php
                    // echo $this->render('common_tools/textinput_suggest',[
                    //     'placeholder_title' => "MOOE",
                    //     'attribute_name' => "budget_mooe",
                    //     'urlLoadResult' => '/report/default/load-budget-mooe',
                    //     'classValue' => 'form-control',
                    //     'customStyle' => '',
                    // ]);
                ?>
                <input type="text" class="form-control amountcomma alertexceeding" id="budget_mooe" placeholder="MOOE">
                <br/>
                <input type="text" class="form-control amountcomma alertexceeding" id="budget_ps" placeholder="PS">
                <br/>
                <input type="text" class="form-control amountcomma alertexceeding" id="budget_co" placeholder="CO">
                <?php richardfan\widget\JSRegister::begin(); ?>
                <script>
                    var grand_total_pb = "<?= $grand_total_pb ?>";
                    var totalLguBudget = "<?= $recTotalLguBudget ?>";
                    var resGrandTotalPb = parseFloat(grand_total_pb);
                    var resTotalLguBudget = parseFloat(totalLguBudget.replace(/,/g, ""));
                    var totalAmount = 0;

                    $("#budget_mooe").keyup(function(){
                        var inputedMooe = $("#budget_mooe").val();
                        var inputedPs = $("#budget_ps").val();
                        var inputedCo = $("#budget_co").val();
                        var resMooe = parseFloat(inputedMooe.replace(/,/g, ""));
                        var resPs = parseFloat(inputedPs.replace(/,/g, ""));
                        var resCo = parseFloat(inputedCo.replace(/,/g, ""));
                        var inputedTAPB = $("#total_annual_pro_budget").val();
                        var resTAPB = parseFloat(inputedTAPB.replace(/,/g, ""));
                        if(isNaN(resTAPB))
                        {
                            resTAPB = 0;
                        }

                        if(isNaN(resPs))
                        {
                            resPs = 0;
                        }

                        if(isNaN(resCo))
                        {
                            resCo = 0;
                        }

                        totalAmount = resMooe + resPs + resCo + resGrandTotalPb + resTAPB;
                        console.log(totalAmount);
                        if(totalAmount > resTotalLguBudget)
                        {
                            alert("Exceeding LGU budget appropriated. Please check budget or recheck previous PPAs");
                            $(this).val("");
                        }
                    });
                    $("#budget_co").keyup(function(){
                        var inputedMooe = $("#budget_mooe").val();
                        var inputedPs = $("#budget_ps").val();
                        var inputedCo = $("#budget_co").val();
                        var resMooe = parseFloat(inputedMooe.replace(/,/g, ""));
                        var resPs = parseFloat(inputedPs.replace(/,/g, ""));
                        var resCo = parseFloat(inputedCo.replace(/,/g, ""));
                        var inputedTAPB = $("#total_annual_pro_budget").val();
                        var resTAPB = parseFloat(inputedTAPB.replace(/,/g, ""));
                        if(isNaN(resTAPB))
                        {
                            resTAPB = 0;
                        }
                        if(isNaN(resMooe))
                        {
                            resMooe = 0;
                        }
                        if(isNaN(resPs))
                        {
                            resPs = 0;
                        }
                        totalAmount = resMooe + resPs + resCo + resGrandTotalPb + resTAPB;
                        console.log(totalAmount);
                        if(totalAmount > resTotalLguBudget)
                        {
                            alert("Exceeding LGU budget appropriated. Please check budget or recheck previous PPAs");
                            $(this).val("");
                        }
                    });
                    $("#budget_ps").keyup(function(){
                        var inputedMooe = $("#budget_mooe").val();
                        var inputedPs = $("#budget_ps").val();
                        var inputedCo = $("#budget_co").val();
                        var resMooe = parseFloat(inputedMooe.replace(/,/g, ""));
                        var resPs = parseFloat(inputedPs.replace(/,/g, ""));
                        var resCo = parseFloat(inputedCo.replace(/,/g, ""));
                        var inputedTAPB = $("#total_annual_pro_budget").val();
                        var resTAPB = parseFloat(inputedTAPB.replace(/,/g, ""));
                        if(isNaN(resTAPB))
                        {
                            resTAPB = 0;
                        }
                        if(isNaN(resCo))
                        {
                            resCo = 0;
                        }
                        if(isNaN(resMooe))
                        {
                            resMooe = 0;
                        }
                        totalAmount = resMooe + resPs + resCo + resGrandTotalPb + resTAPB;
                        console.log(totalAmount);
                        if(totalAmount > resTotalLguBudget)
                        {
                            alert("Exceeding LGU budget appropriated. Please check budget or recheck previous PPAs");
                            $(this).val("");
                        }
                    });
                </script>
                <?php JSRegister::end(); ?>
                <?php
                    // echo $this->render('common_tools/textinput_suggest',[
                    //     'placeholder_title' => "PS",
                    //     'attribute_name' => "budget_ps",
                    //     'urlLoadResult' => '/report/default/load-budget-ps',
                    //     'classValue' => 'form-control',
                    //     'customStyle' => '',
                    // ]);
                ?>
                
                <?php
                    // echo $this->render('common_tools/textinput_suggest',[
                    //     'placeholder_title' => "CO",
                    //     'attribute_name' => "budget_co",
                    //     'urlLoadResult' => '/report/default/load-budget-co',
                    //     'classValue' => 'form-control',
                    //     'customStyle' => '',
                    // ]);
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
                <?php // Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Save', ['class' => 'btn btn-primary btn-sm','id' => 'save-gender-issue','type' => 'button']) ?>
                <?php
                    $url = \yii\helpers\Url::to(['/report/default/create-gad-plan-budget']);
                    $this->registerJs('
                        function SaveGenderIssueAjax(issue,obj,relevant,act,performance_target,ruc,ppa_focused_id,ppa_value,budget_mooe,budget_ps,budget_co,lead_responsible_office,focused_id,inner_category_id,onstep,tocreate,cliorg_ppa_attributed_program_id,gi_sup_data,date_implement_start,date_implement_end,activity_category_id,source)
                        {
                            $.ajax({
                                url: "'.$url.'",
                                data: { 
                                        issue:issue,
                                        obj:obj,
                                        relevant:relevant,
                                        act:act,
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
                                        gi_sup_data:gi_sup_data,
                                        date_implement_start:date_implement_start,
                                        date_implement_end:date_implement_end,
                                        activity_category_id:activity_category_id,
                                        source:source

                                    }
                                
                                }).done(function(result) {
                                    $.each(result, function( index, value ) {

                                        // error in select2
                                        $("p#messages2-"+index+"").text("");
                                        $("#"+index+"").next("span").css({"border":"1px solid red","border-radius":"5px"});
                                        $("#"+index+"").next("span").after("<p class=warningmess id=messages2-"+index+" style=color:red;font-style:italic;>"+value+"</p>");
                                        // error in textarea
                                        $("p#messageta-"+index+"").text("");
                                        $("textarea#"+index+"").css({"border":"1px solid red"});
                                        $("textarea#"+index+"").after("<p class=warningmess id=messageta-"+index+" style=color:red;font-style:italic;>"+value+"</p>");
                                        // error in textbox
                                        $("p#messagete-"+index+"").text("");
                                        $("input#"+index+"").css({"border":"1px solid red"});
                                        $("input#"+index+"").after("<p class=warningmess id=messagete-"+index+" style=color:red;font-style:italic;>"+value+"</p>");
                                        // error in date_picker
                                        if($("#gadplanbudget-date_implement_start").val() == "")
                                        {
                                            $("p#date_implement").text("");
                                            $(".help-block").text("");
                                            $(".input-group").css({"border":"1px solid red"});
                                            $(".input-group").after("<p class=warningmess id=date_implement style=color:red;font-style:italic;>Target Date of Implementation cannot be blank.</p>");
                                        }
                                        else
                                        {
                                            $("p#date_implement").text("");
                                            $(".help-block").text("");
                                            $(".input-group").css({"border":"none"});
                                        }
                                       

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
                        }
                        $("#save-gender-issue").click(function(){
                            var ppa_focused_id = $("#ppa_focused_id").val();
                            var ppa_value     = $("#ppa_value").val();
                            var issue       = $("#cause_gender_issue").val();
                            var obj         = $("#objective").val();
                            var relevant    = $("#relevant_lgu_program_project").val();
                            var act         = $("#activity").val();
                            var performance_target     = $("#performance_target").val();
                            var mooe = $.trim($("#budget_mooe").val());
                            var ps   = $.trim($("#budget_ps").val());
                            var co   = $.trim($("#budget_co").val());
                            var budget_mooe = mooe.replace(/,/g, "");
                            var budget_ps = ps.replace(/,/g, "");
                            var budget_co = co.replace(/,/g, "");
                            var lead_responsible_office   = $("#lead_responsible_office").val();
                            var ruc         = "'.$ruc.'";
                            var focused_id = $("#focused_id").val();
                            var inner_category_id = $("#inner_category_id").val();
                            var onstep = "'.$onstep.'";
                            var tocreate = "'.$tocreate.'";
                            var ppa_sectors = $("#cliorg_ppa_attributed_program_id").val();
                            var cliorg_ppa_attributed_program_id = ppa_sectors.toString();
                            var gi_sup_data = $("#gi_sup_data").val();

                            var date_implement = $("#gadplanbudget-date_implement_start").val();
                            var n = date_implement.lastIndexOf("to");
                            var date_implement_end = $.trim(date_implement.substring(n + 2));
                            var date_implement_start = $.trim(date_implement.substr(0, date_implement.indexOf(" ")));
                            var arr_activity_category_id = $("#activity_category_id").val();
                            var activity_category_id = arr_activity_category_id.toString();
                            var source = $.trim($("#source").val());
                            
                            console.log(date_implement_start);
                            if(budget_mooe == "" && budget_co == "" && budget_ps == "")
                            {
                                if(confirm("are you sure there is no funding requirement?"))
                                {
                                    SaveGenderIssueAjax(issue,obj,relevant,act,performance_target,ruc,ppa_focused_id,ppa_value,budget_mooe,budget_ps,budget_co,lead_responsible_office,focused_id,inner_category_id,onstep,tocreate,cliorg_ppa_attributed_program_id,gi_sup_data,date_implement_start,date_implement_end,activity_category_id,source);
                                }
                                else
                                {

                                }
                            }
                            else
                            {
                                SaveGenderIssueAjax(issue,obj,relevant,act,performance_target,ruc,ppa_focused_id,ppa_value,budget_mooe,budget_ps,budget_co,lead_responsible_office,focused_id,inner_category_id,onstep,tocreate,cliorg_ppa_attributed_program_id,gi_sup_data,date_implement_start,date_implement_end,activity_category_id,source);
                            }
                            
                      }); ');
                ?>
                <button type="button" class="btn btn-default btn-sm" title="Close" id="exit-gender-issue">
                    <span class="glyphicon glyphicon-eye-close"></span> Hide
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
 <?php ActiveForm::end(); ?>
                
