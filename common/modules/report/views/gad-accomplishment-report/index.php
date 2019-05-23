<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\report\models\GadAccomplishmentReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Annual GAD Accomplishment Reports FY '.date("Y");
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-accomplishment-report-index">

    <!-- <h1><?php // Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
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
                                if($grand_total_ar < $fivePercentTotalLguBudget)
                                {
                                    echo "<td style='color:red;'> : Php ".number_format($grand_total_ar,2)."</td>";
                                }
                                else
                                {
                                    echo "<td style='color:blue;'> : Php ".number_format($grand_total_ar,2)."</td>";
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
                var report_type = 'ar';
                $.ajax({
                    url: '".$urlSetSession."',
                    data: { 
                            trigger:trigger,
                            form_type:form_type,
                            report_type:report_type
                            }
                    
                    }).done(function(result) {
                        $('#input-form-gender').slideDown(300);
                });
            });
        ");
    ?>

    <button type="button" class="btn btn-primary pull-right" id="btn-submit-report" style="margin-bottom: 5px;">
        <span class="glyphicon glyphicon-send"></span> Submit Report to Provincial Office
    </button>

    <?php if(Yii::$app->session["encode_gender_ar"] == "open") {  ?>
        <div class="cust-panel input-form" id="input-form-gender">
    <?php }else{ ?>
        <div class="cust-panel input-form" id="input-form-gender" style="display: none;">
    <?php } ?>
            <div class="cust-panel-header gad-color">
            </div>
            <div class="cust-panel-body">
                <div class="cust-panel-title">
                    <p class="sub-title"><span class="glyphicon glyphicon-pencil"></span> INPUT FORM</p>
                </div>
                <div class="cust-panel-inner-body">
                    <div class="input_form_ar">
                        <?php
                            echo $this->render('ar_input_form',[
                                'select_GadFocused' => $select_GadFocused,
                                'select_GadInnerCategory' => $select_GadInnerCategory,
                                'select_PpaAttributedProgram' => $select_PpaAttributedProgram,
                                'ruc' => $ruc,
                                'onstep' => $onstep,
                                'tocreate' => $tocreate,
                            ]);
                        ?>
                    </div>
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
                <table class="table ar table-responsive table-bordered">
                    <thead>
                        <tr>
                            <th>Gender Issues or GAD Mandate</th>
                            <!-- <th>Cause of the Gender Issue</th> -->
                            <th>GAD Objective</th>
                            <th>Relevant LGU Program or Project</th>
                            <th>GAD Activity</th>
                            <th>Performance Indicator and Target</th>
                            <!-- <th>Target</th> -->
                            <th>Actual Results</th>
                            <th>Approved GAD Budget</th>
                            <th>Actual Cost or Expenditure</th>
                            <th>Variance or Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $totalClient = 0;
                            $totalOrganization = 0;
                            foreach ($dataAR as $key => $subt) {
                                if($subt["focused_id"] == 1)
                                {
                                    $totalClient ++;
                                }

                                if($subt["focused_id"] == 2)
                                {
                                    $totalOrganization ++;
                                }
                            }
                        ?>
                        <?php
                            $not_FocusedId = null;
                            $not_InnerCategoryId = null;
                            $countClient = 0;
                            $countOrganization = 0;
                            $sum_total_approved_gad_budget = 0;
                            $sum_actual_cost_expenditure = 0;
                            $total_b = 0;
                            $total_a = 0;
                        ?>
                        <?php foreach ($dataAR as $key => $ar) { ?>
                            <?php
                                if($ar["focused_id"] == 1)
                                {
                                    $countClient ++;
                                }

                                if($ar["focused_id"] == 2)
                                {
                                    $countOrganization ++;
                                }
                            ?>
                            <!-- Client or Organization Focused -->
                            <?php if($not_FocusedId != $ar["gad_focused_title"]) { ?>
                                <tr class="focused_title">
                                    <td colspan='5'><b><?= $ar["gad_focused_title"] ?></b></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php } ?>

                            <!-- Gender Issue or GAD Mandate -->
                            <?php if($not_InnerCategoryId != $ar["inner_category_title"]) { ?>
                                <tr class="inner_category_title">
                                    <td colspan='5'><b><?= $ar["inner_category_title"] ?></b></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <?php
                                    echo $this->render('/gad-plan-budget/cell_reusable_form',[
                                        'cell_value' => $ar["ppa_value"],
                                        'row_id' => $ar["id"],
                                        'record_unique_code' => $ar["record_tuc"],
                                        'attribute_name' => "ppa_value",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-ar-ppa-value']),
                                        'column_title' => 'Title / Description of Gender Issue or GAD Mandate',
                                        'colspanValue' => '',
                                        'controller_id' => Yii::$app->controller->id,
                                        'form_id' => 'gad-ar-input-form',
                                        'customStyle' => '',
                                        'enableComment' => 'true',
                                        'enableEdit' => 'true',
                                    ])
                                ?>
                                <?php
                                    echo $this->render('/gad-plan-budget/cell_reusable_form',[
                                        'cell_value' => $ar["objective"],
                                        'row_id' => $ar["id"],
                                        'record_unique_code' => $ar["record_tuc"],
                                        'attribute_name' => "objective",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/upd8-ar-gad-objective']),
                                        'column_title' => 'GAD Objective',
                                        'colspanValue' => '',
                                        'controller_id' => "gad-accomplishment-report",
                                        'form_id' => 'gad-ar-input-form',
                                        'customStyle' => '',
                                        'enableComment' => 'true',
                                        'enableEdit' => 'true',
                                    ])
                                ?>
                                <?php
                                    echo $this->render('/gad-plan-budget/cell_reusable_form',[
                                        'cell_value' => $ar["relevant_lgu_ppa"],
                                        'row_id' => $ar["id"],
                                        'record_unique_code' => $ar["record_tuc"],
                                        'attribute_name' => "relevant_lgu_ppa",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/upd8-ar-relevant-lgu-ppa']),
                                        'column_title' => 'Relevant LGU PPA',
                                        'colspanValue' => '',
                                        'controller_id' => "gad-accomplishment-report",
                                        'form_id' => 'gad-ar-input-form',
                                        'customStyle' => '',
                                        'enableComment' => 'true',
                                        'enableEdit' => 'true',
                                    ])
                                ?>
                                <?php
                                    echo $this->render('/gad-plan-budget/cell_reusable_form',[
                                        'cell_value' => $ar["activity"],
                                        'row_id' => $ar["id"],
                                        'record_unique_code' => $ar["record_tuc"],
                                        'attribute_name' => "activity",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/upd8-ar-gad-activity']),
                                        'column_title' => 'GAD Activity',
                                        'colspanValue' => '',
                                        'controller_id' => "gad-accomplishment-report",
                                        'form_id' => 'gad-ar-input-form',
                                        'customStyle' => '',
                                        'enableComment' => 'true',
                                        'enableEdit' => 'true',
                                    ])
                                ?>
                                <?php
                                    echo $this->render('/gad-plan-budget/cell_reusable_form',[
                                        'cell_value' => $ar["performance_indicator"],
                                        'row_id' => $ar["id"],
                                        'record_unique_code' => $ar["record_tuc"],
                                        'attribute_name' => "performance_indicator",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/upd8-ar-performance-indicator']),
                                        'column_title' => 'Performance Indicator',
                                        'colspanValue' => '',
                                        'controller_id' => "gad-accomplishment-report",
                                        'form_id' => 'gad-ar-input-form',
                                        'customStyle' => '',
                                        'enableComment' => 'true',
                                        'enableEdit' => 'true',
                                    ])
                                ?>
                                <?php
                                    // echo $this->render('/gad-plan-budget/cell_reusable_form',[
                                    //     'cell_value' => $ar["target"],
                                    //     'row_id' => $ar["id"],
                                    //     'record_unique_code' => $ar["record_tuc"],
                                    //     'attribute_name' => "target",
                                    //     'data_type' => 'string',
                                    //     'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/upd8-ar-target']),
                                    //     'column_title' => 'Target',
                                    //     'colspanValue' => '',
                                    //     'controller_id' => "gad-accomplishment-report",
                                    //     'form_id' => 'gad-ar-input-form',
                                    //     'customStyle' => '',
                                    //     'enableComment' => 'true',
                                    //     'enableEdit' => 'true',
                                    // ])
                                ?>
                                <?php
                                    echo $this->render('/gad-plan-budget/cell_reusable_form',[
                                        'cell_value' => $ar["actual_results"],
                                        'row_id' => $ar["id"],
                                        'record_unique_code' => $ar["record_tuc"],
                                        'attribute_name' => "actual_results",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/upd8-ar-actual-result']),
                                        'column_title' => 'Actual Results',
                                        'colspanValue' => '',
                                        'controller_id' => "gad-accomplishment-report",
                                        'form_id' => 'gad-ar-input-form',
                                        'customStyle' => '',
                                        'enableComment' => 'true',
                                        'enableEdit' => 'true',
                                    ])
                                ?>
                                <?php
                                    echo $this->render('/gad-plan-budget/cell_reusable_form',[
                                        'cell_value' => $ar["total_approved_gad_budget"],
                                        'row_id' => $ar["id"],
                                        'record_unique_code' => $ar["record_tuc"],
                                        'attribute_name' => "total_approved_gad_budget",
                                        'data_type' => 'number',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/upd8-ar-total-approved-gad-budget']),
                                        'column_title' => 'Total Approved GAD Budget',
                                        'colspanValue' => '',
                                        'controller_id' => "gad-accomplishment-report",
                                        'form_id' => 'gad-ar-input-form',
                                        'customStyle' => 'text-align:right;',
                                        'enableComment' => 'true',
                                        'enableEdit' => 'true',
                                    ])
                                ?>
                                <?php
                                    echo $this->render('/gad-plan-budget/cell_reusable_form',[
                                        'cell_value' => $ar["actual_cost_expenditure"],
                                        'row_id' => $ar["id"],
                                        'record_unique_code' => $ar["record_tuc"],
                                        'attribute_name' => "actual_cost_expenditure",
                                        'data_type' => 'number',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/upd8-ar-actual-cost-expenditure']),
                                        'column_title' => 'Actual Cost or Expenditure',
                                        'colspanValue' => '',
                                        'controller_id' => "gad-accomplishment-report",
                                        'form_id' => 'gad-ar-input-form',
                                        'customStyle' => 'text-align:right;',
                                        'enableComment' => 'true',
                                        'enableEdit' => 'true',
                                    ])
                                ?>
                                <?php
                                    echo $this->render('/gad-plan-budget/cell_reusable_form',[
                                        'cell_value' => $ar["variance_remarks"],
                                        'row_id' => $ar["id"],
                                        'record_unique_code' => $ar["record_tuc"],
                                        'attribute_name' => "variance_remarks",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/upd8-ar-variance-remark']),
                                        'column_title' => 'Variance Remarks',
                                        'colspanValue' => '',
                                        'controller_id' => "gad-accomplishment-report",
                                        'form_id' => 'gad-ar-input-form',
                                        'customStyle' => '',
                                        'enableComment' => 'true',
                                        'enableEdit' => 'true',
                                    ])
                                ?>
                            </tr>
                        <?php 
                            if($ar["focused_id"] == 1) // client-focused
                            {
                                $sum_total_approved_gad_budget   += $ar["total_approved_gad_budget"];
                                $total_a   += $ar["actual_cost_expenditure"];
                                // $total_a = ($sum_total_approved_gad_budget+$sum_actual_cost_expenditure);
                                if($countClient == $totalClient)
                                {
                                    echo "
                                    <tr class='subtotal'>
                                        <td colspan='5'><b>Sub-total</b></td>
                                        <td></td>
                                        <td style='text-align:right;'>
                                            <b>".(number_format($sum_total_approved_gad_budget,2))."</b>
                                        </td>
                                        <td style='text-align:right;'>
                                            <b>".(number_format($total_a,2))."</b>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr class='total_a'>
                                        <td colspan='7'><b>Total A (MOEE+PS+CO)</b></td>
                                        <td  style='text-align:right;'>".(number_format($total_a,2))."</td>
                                        <td></td>
                                    </tr>
                                    ";
                                    $sum_total_approved_gad_budget = 0;
                                    $sum_actual_cost_expenditure = 0;
                                }
                                
                            }

                            if($ar["focused_id"] == 2) // organization-focused
                            {
                                $sum_total_approved_gad_budget   += $ar["total_approved_gad_budget"];
                                $total_b   += $ar["actual_cost_expenditure"];
                                // $total_b = ($sum_total_approved_gad_budget+$sum_actual_cost_expenditure);
                                if($countOrganization == $totalOrganization)
                                {
                                    echo "
                                    <tr class='subtotal'>
                                        <td colspan='5'><b>Sub-total</b></td>
                                        <td></td>
                                        <td style='text-align:right;'>
                                            <b>".(number_format($sum_total_approved_gad_budget,2))."</b>
                                        </td>
                                        <td style='text-align:right;'>
                                            <b>".(number_format($total_b,2))."</b>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr class='total_b'>
                                        <td colspan='7'><b>Total B (MOEE+PS+CO)</b></td>
                                        <td style='text-align:right;'>".(number_format($total_b,2))."</td>
                                        <td></td>
                                    </tr>
                                    ";
                                }
                            }
                        ?>
                        <?php
                            $not_FocusedId = $ar["gad_focused_title"];
                            $not_InnerCategoryId = $ar["inner_category_title"];
                        ?>
                        <?php } ?>
                        
                        <tr class="ar_attributed_program">
                            <td colspan="5">ATTRIBUTED PROGRAMS 
                                <button id="btnEncodeAP" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span> Encode
                                </button>
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <?php
                            $this->registerJs("
                                $('#btnEncodeAP').click(function(){
                                    var trigger = 'open';
                                    var form_type = 'attribute';
                                    var report_type = 'ar';
                                    $.ajax({
                                        url: '".$urlSetSession."',
                                        data: { 
                                                trigger:trigger,
                                                form_type:form_type,
                                                report_type:report_type
                                                }
                                        
                                        }).done(function(result) {
                                            $('#attributed_program_anchor').slideDown(300);
                                    });
                                });
                            ");
                        ?>

                        <?php // print_r(Yii::$app->session["encode_attribute_ar"]); exit; ?>
                        <?php if(Yii::$app->session["encode_attribute_ar"] == "open") {  ?>
                            <tr class="attributed_program_form" id="attributed_program_anchor">
                        <?php }else{ ?>
                            <tr class="attributed_program_form" id="attributed_program_anchor" style="display: none;">
                        <?php } ?>
                            <td colspan="9">
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
                        
                        <tr class="ar_attributed_program_head">
                            <td colspan="5">Title of LGU Program or Project</td>
                            <td>HGDG PIMME/FIMME Score</td>
                            <td>Total Annual Program/ Project Cost or Expenditure</td>
                            <td>GAD Attributed Program/Project Cost or Expenditure</td>
                            <td>Variance or Remarks</td>
                        </tr>
                         <?php 
                        $notnull_apPpaValue = null;
                        $total_c = 0;
                        $varTotalGadAttributedProBudget = 0;
                        foreach ($dataAttributedProgram as $key => $dap) { ?>
                            <tr class="attributed_program_td">
                                <?php
                                    echo $this->render('/gad-plan-budget/cell_reusable_form',[
                                        'cell_value' => $dap["lgu_program_project"],
                                        'row_id' => $dap["id"],
                                        'record_unique_code' => $dap["record_tuc"],
                                        'attribute_name' => "lgu_program_project",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-ar-ap-lgu-program-project']),
                                        'column_title' => 'Title of LGU Program or Project',
                                        'colspanValue' => '5',
                                        'controller_id' => $dap['controller_id'],
                                        'form_id' => 'attributed-program',
                                        'customStyle' => '',
                                        'enableComment' => 'true',
                                        'enableEdit' => 'true',
                                    ])
                                ?>
                                <!-- COMPUTATION OF GAD ATTRIBUTED PROGRAM/PROJECT BUDGET -->
                                <?php
                                    $varHgdg = $dap["hgdg_pimme"];
                                    $varTotalAnnualProCost = $dap["total_annual_pro_cost"];
                                    $computeGadAttributedProCost = 0;
                                    $HgdgMessage = null;
                                    $HgdgWrongSign = "";
                                    
                                    if($varHgdg < 4) // 0%
                                    {
                                        // echo "GAD is invisible";
                                        $computeGadAttributedProCost = ($varTotalAnnualProCost * 0);
                                        $varTotalGadAttributedProBudget += $computeGadAttributedProCost;
                                    }
                                    else if($varHgdg >= 4 && $varHgdg <= 7.9) // 25%
                                    {
                                        // echo "Promising GAD prospects (conditional pass)";
                                        $computeGadAttributedProCost = ($varTotalAnnualProCost * 0.25);
                                        $varTotalGadAttributedProBudget += $computeGadAttributedProCost;
                                    }
                                    else if($varHgdg >= 8 && $varHgdg <= 14.9) // 50%
                                    {
                                        // echo "Gender Sensetive";
                                        $computeGadAttributedProCost = ($varTotalAnnualProCost * 0.50);
                                        $varTotalGadAttributedProBudget += $computeGadAttributedProCost;
                                    }
                                    else if($varHgdg >= 15 && $varHgdg <= 19.9) // 75%
                                    {
                                        // echo "Gender-responsive";
                                        $computeGadAttributedProCost = ($varTotalAnnualProCost * 0.75);
                                        $varTotalGadAttributedProBudget += $computeGadAttributedProCost;
                                    }
                                    else if($varHgdg == 20) // 100%
                                    {
                                        // echo "Full gender-resposive";
                                        $computeGadAttributedProCost = ($varTotalAnnualProCost * 1);
                                        $varTotalGadAttributedProBudget += $computeGadAttributedProCost;
                                    }
                                    else
                                    {
                                        $HgdgMessage = "Unable to compute (undefined HGDG Score).";
                                        $HgdgWrongSign = "<span class='glyphicon glyphicon-alert' style='color:red;' title='Not HGDG Score Standard'></span>";
                                    }
                                ?>
                                <?php
                                    echo $this->render('/gad-plan-budget/cell_reusable_form',[
                                        'cell_value' => $HgdgWrongSign." ".$dap["hgdg_pimme"],
                                        'row_id' => $dap["id"],
                                        'record_unique_code' => $dap["record_tuc"],
                                        'attribute_name' => "hgdg_pimme",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-ar-hgdg-pimme']),
                                        'column_title' => 'HGDG PIMME / FIMME Score',
                                        'colspanValue' => '',
                                        'controller_id' => $dap['controller_id'],
                                        'form_id' => 'attributed-program',
                                        'customStyle' => 'text-align:center;',
                                        'enableComment' => 'true',
                                        'enableEdit' => 'true',
                                    ])
                                ?>
                                <?php
                                    echo $this->render('/gad-plan-budget/cell_reusable_form',[
                                        'cell_value' => $dap["total_annual_pro_cost"],
                                        'row_id' => $dap["id"],
                                        'record_unique_code' => $dap["record_tuc"],
                                        'attribute_name' => "total_annual_pro_cost",
                                        'data_type' => 'number',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-ar-total-annual-pro-cost']),
                                        'column_title' => 'Total Annual Program/ Project Cost or Expenditure',
                                        'colspanValue' => '',
                                        'controller_id' => $dap['controller_id'],
                                        'form_id' => 'attributed-program',
                                        'customStyle' => 'text-align:right;',
                                        'enableComment' => 'true',
                                        'enableEdit' => 'true',
                                    ])
                                ?>
                                <?php
                                    echo $this->render('/gad-plan-budget/cell_reusable_form',[
                                        'cell_value' => !empty($HgdgMessage) ? $HgdgMessage : number_format($computeGadAttributedProCost,2),
                                        'row_id' => $dap["id"],
                                        'record_unique_code' => $dap["record_tuc"],
                                        'attribute_name' => "gad_attributed_pro_cost",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => "",
                                        'column_title' => 'GAD Attributed Program/Project Cost or Expenditure',
                                        'colspanValue' => '',
                                        'controller_id' => $dap['controller_id'],
                                        'form_id' => 'attributed-program',
                                        'customStyle' => 'text-align:right;',
                                        'enableComment' => 'true',
                                        'enableEdit' => 'false',
                                    ])
                                ?>
                                <?php
                                    echo $this->render('/gad-plan-budget/cell_reusable_form',[
                                        'cell_value' => $dap["variance_remarks"],
                                        'row_id' => $dap["id"],
                                        'record_unique_code' => $dap["record_tuc"],
                                        'attribute_name' => "variance_remarks",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-ar-variance-remarks']),
                                        'column_title' => 'Variance or Remarks',
                                        'colspanValue' => '',
                                        'controller_id' => $dap['controller_id'],
                                        'form_id' => 'attributed-program',
                                        'customStyle' => '',
                                        'enableComment' => 'true',
                                        'enableEdit' => 'true',
                                    ])
                                ?>
                            </tr>
                        <?php 
                        $total_c = $varTotalGadAttributedProBudget;
                        // $notnull_apPpaValue = $dap["ap_ppa_value"];
                        } ?>
                        <tr class="total_c">
                            <td colspan="7">Total C</td>
                            <td style="text-align: right;"><?= number_format($total_c,2) ?></td>
                            <td></td>
                        </tr>
                        <tr class="grand_total">
                            <td colspan="7">GRAND TOTAL (A+B+C)</td>
                            <td style="text-align: right;">
                                <?php
                                    $grand_total = 0;
                                    $grand_total = ($total_a + $total_b + $total_c);
                                    echo number_format($grand_total,2);
                                ?>
                            </td>
                            <td></td>
                        </tr>
                        <tr class="signatory_label">
                            <td colspan="3"><b>Prepared by:</b></td>

                            <td colspan="4"><b>Approved by:</b></td>
                            <td colspan="4"><b>Date:</b></td>
                        </tr>
                        <tr class="signatory">
                            <?php foreach ($dataRecord as $key => $rec) { ?>
                                <?php
                                    echo $this->render('/gad-plan-budget/reusable_edit_cell_form',[
                                        'cell_value' => $rec["prepared_by"],
                                        'row_id' => $rec["id"],
                                        'record_unique_code' => $rec["tuc"],
                                        'attribute_name' => "prepared_by",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-pb-prepared-by']),
                                        'column_title' => 'Chairperson, GFPS TWG',
                                        'colspanValue' => '3',
                                        'controller_id' => "gad-plan-budget",
                                        'form_id' => 'attributed-program',
                                        'customStyle' => 'text-align:center; font-size:20px;',
                                    ]);
                                ?>
                                <?php
                                    echo $this->render('/gad-plan-budget/reusable_edit_cell_form',[
                                        'cell_value' => $rec["approved_by"],
                                        'row_id' => $rec["id"],
                                        'record_unique_code' => $rec["tuc"],
                                        'attribute_name' => "approved_by",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-pb-approved-by']),
                                        'column_title' => 'Local Chief Executive',
                                        'colspanValue' => '4',
                                        'controller_id' => "gad-plan-budget",
                                        'form_id' => 'attributed-program',
                                        'customStyle' => 'text-align:center; font-size:20px;',
                                    ]);
                                ?>
                                <?php
                                    echo $this->render('/gad-plan-budget/reusable_edit_cell_form_date',[
                                        'cell_value' => $rec["footer_date"],
                                        'row_id' => $rec["id"],
                                        'record_unique_code' => $rec["tuc"],
                                        'attribute_name' => "footer_date",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-pb-footer-date']),
                                        'column_title' => 'Date',
                                        'colspanValue' => '4',
                                        'controller_id' => "gad-plan-budget",
                                        'form_id' => 'attributed-program',
                                        'customStyle' => 'text-align:center; font-size:20px;',
                                    ]);
                                ?>
                            <?php } ?>
                        </tr>
                        <tr class="signatory_title">
                            <td colspan="3">Chairperson, GFPS TWG</td>
                            <td colspan="4">Local Chief Executive</td>
                            <td colspan="4">DD/MM/YEAR</td>
                            <!-- <td></td> -->
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
