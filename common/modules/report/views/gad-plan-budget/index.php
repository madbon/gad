<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use kartik\typeahead\Typeahead;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $searchModel common\models\GadPlanBudgetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $onstep == 'to_create_gpb' ? 'Step 2. Encode Annual GAD Plan and Budget ' : 'Annual GAD Plan and Budget FY '.date("Y");
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="gad-plan-budget-index">
    <!-- <p>
        <?php // Html::a('Create Annex A', ['gad-record/create'], ['class' => 'btn btn-success']) ?>
    </p> -->

   
    <div class="cust-panel basic-information inner-panel">
        <!-- <div class="cust-panel-header gad-color">
        </div> -->
        <div class="cust-panel-body">
            <div class="cust-panel-title">
                <p class="sub-title"><span class="glyphicon glyphicon-info-sign"></span> Primary Information</p>
            </div>
            <div class="cust-panel-inner-body">
                <table class="table table-responsive table-hover table-bordered basic-information">
                    <tbody>
                        <tr>
                            <td style="width:1px;">REGION </td>
                            <td> : <?= $recRegion ?></td>
                            <td style="width: 180px;">TOTAL LGU BUDGET</td>
                            <td> : Php <?= number_format($recTotalLguBudget,2) ?></td>
                        </tr>
                        <tr>
                            <td>PROVINCE </td>
                            <td> : <?= $recProvince ?></td>
                            <td>TOTAL GAD BUDGET</td>
                            <?php
                                if($grand_total_pb < $fivePercentTotalLguBudget)
                                {
                                    echo "<td style='color:red;'> : Php ".number_format($grand_total_pb,2)."</td>";
                                }
                                else
                                {
                                    echo "<td style='color:blue;'> : Php ".number_format($grand_total_pb,2)."</td>";
                                }
                            ?>
                            
                        </tr>
                        <tr>
                            <td>CITY/MUNICIPALITY </td>
                            <td> : <?= $recCitymun ?></td>
                            <td colspan="2"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br/>

    <button type="button" class="btn btn-success" id="btn-encode" style="margin-bottom: 5px;">
        <span class="glyphicon glyphicon-pencil"></span> Encode Gender Issue or GAD Mandate
    </button>

    <?php
        $urlSetSession = \yii\helpers\Url::to(['default/session-encode']);
        $this->registerJs("
            $('#btn-encode').click(function(){
                var trigger = 'open';
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
                $('#inputFormPlan').slideDown(300);
            });
        ");
    ?>

    <?php
        $sendTo = "";
        if(Yii::$app->user->can("gad_lgu"))
        {
            $sendTo = "Sumit to Field Officer";
        }
        elseif(Yii::$app->user->can("gad_field"))
        {
            $sendTo = "Endorse to Provincial Office";
        }
        else if(Yii::$app->user->can("gad_province"))
        {
            $sendTo = "Submit to Regional Office";
        }
        else if(Yii::$app->user->can("gad_region"))
        {
            $sendTo = "Submit to Central Office";
        }
        else
        {
            $sendTo = null;
        }
    ?>
    <?php if(!empty($sendTo)){ ?>
        <button type="button" class="btn btn-primary pull-right" id="btn-submit-report" style="margin-bottom: 5px;">
            <?= $sendTo ?> &nbsp;<span class="glyphicon glyphicon-send" ></span> 
        </button>
    <?php } ?>

    <?php if(Yii::$app->session["encode_gender_pb"] == "open"){ ?>
    <div class="cust-panel input-form" id="inputFormPlan">
    <?php }else{ ?>
    <div class="cust-panel input-form" id="inputFormPlan" style="display: none;">
    <?php } ?>
        <div class="cust-panel-header gad-color">
        </div>
        <div class="cust-panel-body">
            <div class="cust-panel-title">
                <p class="sub-title"><span class="glyphicon glyphicon-pencil"></span> INPUT FORM</p>
            </div>
            <div class="cust-panel-inner-body">
                <?php echo $this->render('client_focused_form',[
                    'opt_cli_focused' => $opt_cli_focused,
                    'ruc' => $ruc,
                    'select_GadFocused' => $select_GadFocused,
                    'select_GadInnerCategory' => $select_GadInnerCategory,
                    'onstep' => $onstep,
                    'tocreate' => $tocreate,
                    'select_PpaAttributedProgram' => $select_PpaAttributedProgram,
                    ]);
                ?>
            </div>
        </div>
    </div>

    
    <br/>

    <div class="cust-panel tabular-report">
        <div class="cust-panel-header gad-color">
        </div>
        <div class="cust-panel-body">
            <div class="cust-panel-title">
                <p class="sub-title"><span class="glyphicon glyphicon-th"></span> Tabular Report</p>
            </div>
            <div class="cust-panel-inner-body">
                <table class="table table-responsive table-bordered gad-plan-budget">
                    <thead>
                        <tr>
                            <th style="border-bottom: none;">Gender Issue or GAD Mandate </th>
                            <!-- <th>Cause of the Gender Issue</th> -->
                            <th style="border-bottom: none;">GAD Objective</th>
                            <th style="border-bottom: none;">Relevant LGU Program or Project</th>
                            <th style="border-bottom: none;">GAD Activity</th>
                            <th style="border-bottom: none;">Performance Indicator and Target </th>
                            <!-- <th style="border-bottom: none;">Performance Indicator</th> -->
                            <th style="border-bottom: none;" colspan="3">GAD Budget (6)</th>
                            <th style="border-bottom: none;">Lead or Responsible Office </th>
                            <th style="border-bottom: none;"></th>
                        </tr>
                        <tr>
                            <th style="border-top: none;"></th>
                            <!-- <th></th> -->
                            <th style="border-top: none;"></th>
                            <th style="border-top: none;"></th>
                            <th style="border-top: none;"></th>
                            <th style="border-top: none;"></th>
                            <!-- <th style="border-top: none;"></th> -->
                            <th>MOOE</th>
                            <th>PS</th>
                            <th>CO</th>
                            <th style="border-top: none;"></th>
                            <th style="border-top: none;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- CLIENT-FOCUSED -->
                        <?php
                        $totalClient = 0;
                        $totalOrganization = 0;
                        
                        foreach ($dataPlanBudget as $key => $subt) {
                            if($subt["focused_id"] == 1)
                            {
                                $totalClient ++;
                            }

                            if($subt["focused_id"] == 2)
                            {
                                $totalOrganization ++;
                            }
                        }

                        $not_ppa_value = null;
                        $not_FocusedId = null;
                        $not_InnerCategoryId = null;
                        $countClient = 0;
                        $countOrganization = 0;
                        $sum_mooe = 0;
                        $sum_ps = 0;
                        $sum_co = 0;
                        $total_c = 0;
                        $total_b = 0;
                        $total_a = 0;
                        $grand_total = 0;
                        foreach ($dataPlanBudget as $key2 => $plan) {
                            if($plan["focused_id"] == 1)
                            {
                                $countClient ++;
                            }

                            if($plan["focused_id"] == 2)
                            {
                                $countOrganization ++;
                            }
                        ?>
                            <!-- Client or Organization Focused -->
                            <?php if($not_FocusedId != $plan["gad_focused_title"]) { ?>
                                <tr class="focused_title">
                                    <td style="border-bottom: none;" colspan='5'><b><?= $plan["gad_focused_title"] ?></b></td>
                                    <td colspan="3" style="border-bottom: none;"></td>
                                    <td style="border-bottom: none;"></td>
                                    <td style="border-bottom: none;"></td>
                                </tr>
                            <?php } ?>

                            <!-- Gender Issue or GAD Mandate -->
                            <?php if($not_InnerCategoryId != $plan["inner_category_title"]) { ?>
                                <tr class="inner_category_title">
                                    <td style="border-top: none;" colspan='5'><b><?= $plan["inner_category_title"] ?></b></td>
                                    <td colspan="3" style="border-top: none;"></td>
                                    <td  style="border-top:none;"></td>
                                    <td style="border-top: none;"></td>
                                </tr>
                            <?php } ?>

                            <tr>
                                <?php
                                    echo $this->render('cliorg_tabular_form',[
                                        'plan' => $plan
                                    ]);
                                ?>
                                <td></td>
                            </tr>
                        <!-- Display Sub-Total -->
                        <?php 
                            if($plan["focused_id"] == 1) // client-focused
                            {
                                $sum_mooe   += $plan["budget_mooe"];
                                $sum_ps     += $plan["budget_ps"];
                                $sum_co     += $plan["budget_co"];
                                $total_a = 0;
                                $total_a = ($sum_mooe + $sum_ps + $sum_co);
                                if($countClient == $totalClient)
                                {
                                    echo "
                                    <tr class='subtotal'>
                                        <td colspan='5'><b>Sub-total</b></td>
                                        <td style='text-align:right;'><b>".(number_format($sum_mooe,2))."</b></td>
                                        <td style='text-align:right;'><b>".(number_format($sum_ps,2))."</b></td>
                                        <td style='text-align:right;'><b>".(number_format($sum_co,2))."</b></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr class='total_a'>
                                        <td colspan='5'><b>Total A (MOEE+PS+CO)</b></td>
                                        <td colspan='3'>".(number_format($total_a,2))."</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    ";
                                    $sum_mooe = 0;
                                    $sum_ps = 0;
                                    $sum_co = 0;

                                }
                            }

                            if($plan["focused_id"] == 2) // organization-focused
                            {
                                $sum_mooe   += $plan["budget_mooe"];
                                $sum_ps     += $plan["budget_ps"];
                                $sum_co     += $plan["budget_co"];
                                $total_b    = ($sum_mooe + $sum_ps + $sum_co);
                                if($countOrganization == $totalOrganization)
                                {
                                    echo "
                                    <tr class='subtotal'>
                                        <td colspan='5'><b>Sub-total</b></td>
                                        <td style='text-align:right;'><b>".(number_format($sum_mooe,2))."</b></td>
                                        <td style='text-align:right;'><b>".(number_format($sum_ps,2))."</b></td>
                                        <td style='text-align:right;'><b>".(number_format($sum_co,2))."</b></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr class='total_b'>
                                        <td colspan='5'><b>Total B (MOEE+PS+CO)</b></td>
                                        <td colspan='3'>".(number_format($total_b,2))."</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    ";
                                }
                            }
                            
                            $not_FocusedId = $plan["gad_focused_title"];
                            $not_InnerCategoryId = $plan["inner_category_title"];
                        } //End of dataClient ?>
                        

                        <tr class="attributed_program_title">
                            <td colspan="5">
                                <b>ATTRIBUTED PROGRAMS</b> 
                                <button id="btn_encode_attributed_program" type="button" class="btn btn-success btn-sm">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                    Encode
                                </button>
                                <?php
                                    $this->registerJs("
                                        $('#btn_encode_attributed_program').click(function(){
                                            var trigger = 'open';
                                            var form_type = 'attribute';
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
                                            $('.attributed_program_form').slideDown(300);
                                        });
                                    ");
                                ?>
                            </td>
                            <td colspan="3"></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php if(Yii::$app->session["encode_attribute_pb"] == "open"){ ?>
                            <tr class="attributed_program_form">
                        <?php }else{ ?>
                            <tr class="attributed_program_form" style="display: none;">
                        <?php } ?>
                            <td colspan="10">
                                <?php
                                    echo $this->render('attributed_program_form', [
                                        'select_PpaAttributedProgram' => $select_PpaAttributedProgram,
                                        'ruc' => $ruc,
                                        'onstep' => $onstep,
                                        'tocreate' => $tocreate,
                                    ]);
                                ?>
                            </td>
                        </tr>
                        <tr class="attributed_program_thead">
                            <td colspan="2"><b>Title of LGU Program or Project</b></td>
                            <td colspan="1"><b>HGDG Design/ Funding Facility/ Generic Checklist Score</b></td>
                            <td colspan="2"><b>Total Annual Program/ Project Budget</b></td>
                            <td colspan="3"><b>GAD Attributed Program/Project Budget</b></td>
                            <td><b>Lead or Responsible Office</b></td>
                            <td></td>
                        </tr>
                        <?php 
                        $notnull_apPpaValue = null;
                        // $total_c = 0;
                        $varTotalGadAttributedProBudget = 0;
                        foreach ($dataAttributedProgram as $key => $dap) { ?>

                            <tr class="attributed_program_td">
                                <?php
                                    echo $this->render('cell_reusable_form',[
                                        'cell_value' => $dap["lgu_program_project"],
                                        'row_id' => $dap["id"],
                                        'record_unique_code' => $dap["record_tuc"],
                                        'attribute_name' => "lgu_program_project",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-ap-lgu-program-project']),
                                        'column_title' => 'Title of LGU Program or Project',
                                        'colspanValue' => '2',
                                        'controller_id' => $dap['controller_id'],
                                        'form_id' => 'attributed-program',
                                        'customStyle' => '',
                                        'enableComment' => 'true',
                                        'enableEdit' => 'true',
                                    ])
                                ?>
                                <!-- COMPUTATION OF GAD ATTRIBUTED PROGRAM/PROJECT BUDGET -->
                                <?php
                                    $varHgdg = $dap["hgdg"];
                                    $varTotalAnnualProBudget = $dap["total_annual_pro_budget"];
                                    $computeGadAttributedProBudget = 0;
                                    $HgdgMessage = null;
                                    $HgdgWrongSign = "";
                                    
                                    if($varHgdg < 4) // 0%
                                    {
                                        // echo "GAD is invisible";
                                        $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0);
                                        $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
                                    }
                                    else if($varHgdg >= 4 && $varHgdg <= 7.9) // 25%
                                    {
                                        // echo "Promising GAD prospects (conditional pass)";
                                        $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0.25);
                                        $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
                                    }
                                    else if($varHgdg >= 8 && $varHgdg <= 14.9) // 50%
                                    {
                                        // echo "Gender Sensetive";
                                        $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0.50);
                                        $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
                                    }
                                    else if($varHgdg >= 15 && $varHgdg <= 19.9) // 75%
                                    {
                                        // echo "Gender-responsive";
                                        $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0.75);
                                        $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
                                    }
                                    else if($varHgdg == 20) // 100%
                                    {
                                        // echo "Full gender-resposive";
                                        $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 1);
                                        $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
                                    }
                                    else
                                    {
                                        $HgdgMessage = "Unable to compute (undefined HGDG Score).";
                                        $HgdgWrongSign = "<span class='glyphicon glyphicon-alert' style='color:red;' title='Not HGDG Score Standard'></span>";
                                    }
                                ?>
                                <?php

                                    echo $this->render('cell_reusable_form',[
                                        'cell_value' => $HgdgWrongSign." ".$dap["hgdg"],
                                        'row_id' => $dap["id"],
                                        'record_unique_code' => $dap["record_tuc"],
                                        'attribute_name' => "hgdg",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-hgdg']),
                                        'column_title' => 'HGDG Design/ Funding Facility/ Generic Checklist Score',
                                        'colspanValue' => '1',
                                        'controller_id' => $dap['controller_id'],
                                        'form_id' => 'attributed-program',
                                        'customStyle' => 'text-align:center;',
                                        'enableComment' => 'true',
                                        'enableEdit' => 'true',
                                    ])
                                ?>
                                <?php
                                    echo $this->render('cell_reusable_form',[
                                        'cell_value' => $dap["total_annual_pro_budget"],
                                        'row_id' => $dap["id"],
                                        'record_unique_code' => $dap["record_tuc"],
                                        'attribute_name' => "total_annual_pro_budget",
                                        'data_type' => 'number',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-total-annual-pro-budget']),
                                        'column_title' => 'Total Annual Program/ Project Budget',
                                        'colspanValue' => '2',
                                        'controller_id' => $dap['controller_id'],
                                        'form_id' => 'attributed-program',
                                        'customStyle' => 'text-align:right;',
                                        'enableComment' => 'true',
                                        'enableEdit' => 'true',
                                    ])
                                ?>
                                <?php
                                    // echo $this->render('cell_reusable_form',[
                                    //     'cell_value' => $dap["attributed_pro_budget"],
                                    //     'row_id' => $dap["id"],
                                    //     'record_unique_code' => $dap["record_tuc"],
                                    //     'attribute_name' => "attributed_pro_budget",
                                    //     'data_type' => 'number',
                                    //     'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-attributed-pro-budget']),
                                    //     'column_title' => 'GAD Attributed Program/Project Budget',
                                    //     'colspanValue' => '3',
                                    //     'controller_id' => $dap['controller_id'],
                                    //     'form_id' => 'attributed-program',
                                    //     'customStyle' => 'text-align:right;',
                                    // ])
                                ?>
                                
                                <?php
                                    echo $this->render('cell_reusable_form',[
                                        'cell_value' => !empty($HgdgMessage) ? $HgdgMessage : number_format($computeGadAttributedProBudget,2),
                                        'row_id' => $dap["id"],
                                        'record_unique_code' => $dap["record_tuc"],
                                        'attribute_name' => "attributed_pro_budget",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => "",
                                        'column_title' => 'GAD Attributed Program/Project Budget',
                                        'colspanValue' => '3',
                                        'controller_id' => $dap['controller_id'],
                                        'form_id' => 'attributed-program',
                                        'customStyle' => 'text-align:right; ',
                                        'enableComment' => "true",
                                        'enableEdit' => "false",
                                    ])
                                ?>
                                <?php
                                    echo $this->render('cell_reusable_form',[
                                        'cell_value' => $dap["ap_lead_responsible_office"],
                                        'row_id' => $dap["id"],
                                        'record_unique_code' => $dap["record_tuc"],
                                        'attribute_name' => "ap_lead_responsible_office",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-ap-lead-responsible-office']),
                                        'column_title' => 'Lead or Responsible Office',
                                        'colspanValue' => '',
                                        'controller_id' => $dap['controller_id'],
                                        'form_id' => 'attributed-program',
                                        'customStyle' => '',
                                        'enableComment' => 'true',
                                        'enableEdit' => 'true',
                                    ])
                                ?>
                                <td></td>
                            </tr>
                        <?php 
                        $total_c = $varTotalGadAttributedProBudget;
                        } ?>
                        <tr class="total_c">
                            <td><b>Total C</b></td>
                            <td colspan="4"></td>
                            <td colspan="3"><?= number_format($total_c,2) ?></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="grand_total">
                            <td colspan="2"><b>GRAND TOTAL (A+B+C</b></td>
                            <td colspan="3"></td>
                            <td colspan="3">
                                <?php
                                    $grand_total = ($total_a + $total_b + $total_c);
                                    echo number_format($grand_total,2);
                                ?>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="signatory_label">
                            <td colspan="2"><b>Prepared by:</b></td>

                            <td colspan="3"><b>Approved by:</b></td>
                            <td colspan="3"><b>Date:</b></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr class="signatory">
                            <?php foreach ($dataRecord as $key => $rec) { ?>
                                <?php
                                    echo $this->render('reusable_edit_cell_form',[
                                        'cell_value' => $rec["prepared_by"],
                                        'row_id' => $rec["id"],
                                        'record_unique_code' => $rec["tuc"],
                                        'attribute_name' => "prepared_by",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-pb-prepared-by']),
                                        'column_title' => 'Chairperson, GFPS TWG',
                                        'colspanValue' => '2',
                                        'controller_id' => "gad-plan-budget",
                                        'form_id' => 'attributed-program',
                                        'customStyle' => 'text-align:center; font-size:20px;',
                                    ]);
                                ?>
                                <?php
                                    echo $this->render('reusable_edit_cell_form',[
                                        'cell_value' => $rec["approved_by"],
                                        'row_id' => $rec["id"],
                                        'record_unique_code' => $rec["tuc"],
                                        'attribute_name' => "approved_by",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-pb-approved-by']),
                                        'column_title' => 'Local Chief Executive',
                                        'colspanValue' => '3',
                                        'controller_id' => "gad-plan-budget",
                                        'form_id' => 'attributed-program',
                                        'customStyle' => 'text-align:center; font-size:20px;',
                                    ]);
                                ?>
                                <?php
                                    echo $this->render('reusable_edit_cell_form_date',[
                                        'cell_value' => $rec["footer_date"],
                                        'row_id' => $rec["id"],
                                        'record_unique_code' => $rec["tuc"],
                                        'attribute_name' => "footer_date",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-pb-footer-date']),
                                        'column_title' => 'Date',
                                        'colspanValue' => '3',
                                        'controller_id' => "gad-plan-budget",
                                        'form_id' => 'attributed-program',
                                        'customStyle' => 'text-align:center; font-size:20px;',
                                    ]);
                                ?>
                                 <td colspan="2"></td>
                            <?php } ?>
                        </tr>
                        <tr class="signatory_title">
                            <td colspan="2">Chairperson, GFPS TWG</td>
                            <td colspan="3">Local Chief Executive</td>
                            <td colspan="3">DD/MM/YEAR</td>
                            <td colspan="2"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
</div>
