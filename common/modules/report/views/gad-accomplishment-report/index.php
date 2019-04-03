<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\report\models\GadAccomplishmentReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Annual GAD Accomplishment Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-accomplishment-report-index">

    <!-- <h1><?php // Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="cust-panel basic-information inner-panel">
        <div class="cust-panel-header gad-color">
        </div>
        <div class="cust-panel-body">
            <div class="cust-panel-title">
                <p class="sub-title"><span class="glyphicon glyphicon-info-sign"></span> Primary Information</p>
            </div>
            <div class="cust-panel-inner-body">
                <table class="table table-responsive table-hover table-bordered basic-information">
                    <tbody>
                        <tr>
                            <td style="width:1px;">REGION :</td>
                            <td> : <?= $recRegion ?></td>
                            <td style="width: 180px;">TOTAL LGU BUDGET</td>
                            <td> : Php <?= number_format($recTotalLguBudget,2) ?></td>
                        </tr>
                        <tr>
                            <td>PROVINCE :</td>
                            <td> : <?= $recProvince ?></td>
                            <td>TOTAL GAD BUDGET</td>
                            <td> : Php <?= number_format($recTotalGadBudget,2) ?></td>
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
        <span class="glyphicon glyphicon-pencil"></span> Encode
    </button>

    <button type="button" class="btn btn-primary pull-right" id="btn-submit-report" style="margin-bottom: 5px;">
        <span class="glyphicon glyphicon-send"></span> Submit Report to Provincial Office
    </button>

    <div class="cust-panel input-form" >
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
                            'onstep' => $onstep
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
                            <th>Gender Issues/GAD Mandate</th>
                            <th>Cause of the Gender Issue</th>
                            <th>GAD Objective</th>
                            <th>Relevant LGU PPA</th>
                            <th>GAD Activity</th>
                            <th>Performance Indicator</th>
                            <th>Target</th>
                            <th>Actual Results</th>
                            <th>Total Approved GAD Budget</th>
                            <th>Actual Cost or Expenditure</th>
                            <th>Variance / Remarks</th>
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
                                    <td colspan='7'><b><?= $ar["gad_focused_title"] ?></b></td>
                                    <td colspan='3'></td>
                                    <td></td>
                                </tr>
                            <?php } ?>

                            <!-- Gender Issue or GAD Mandate -->
                            <?php if($not_InnerCategoryId != $ar["inner_category_title"]) { ?>
                                <tr class="inner_category_title">
                                    <td colspan='7'><b><?= $ar["inner_category_title"] ?></b></td>
                                    <td colspan='3'></td>
                                    <td></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td><?= $ar["ppa_value"] ?></td>
                                <?php
                                    echo $this->render('/gad-plan-budget/cell_reusable_form',[
                                        'cell_value' => $ar["cause_gender_issue"],
                                        'row_id' => $ar["id"],
                                        'record_unique_code' => $ar["record_tuc"],
                                        'attribute_name' => "cause_gender_issue",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/upd8-ar-cause-gender-issue']),
                                        'column_title' => 'Cause of the Gender Issue',
                                        'colspanValue' => '',
                                        'controller_id' => "gad-accomplishment-report",
                                        'form_id' => 'gad-ar-input-form',
                                        'customStyle' => '',
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
                                    ])
                                ?>
                                <?php
                                    echo $this->render('/gad-plan-budget/cell_reusable_form',[
                                        'cell_value' => $ar["target"],
                                        'row_id' => $ar["id"],
                                        'record_unique_code' => $ar["record_tuc"],
                                        'attribute_name' => "target",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/upd8-ar-target']),
                                        'column_title' => 'Target',
                                        'colspanValue' => '',
                                        'controller_id' => "gad-accomplishment-report",
                                        'form_id' => 'gad-ar-input-form',
                                        'customStyle' => '',
                                    ])
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
                                    ])
                                ?>
                            </tr>
                        <?php 
                            if($ar["focused_id"] == 1) // client-focused
                            {
                                $sum_total_approved_gad_budget   += $ar["total_approved_gad_budget"];
                                $sum_actual_cost_expenditure   += $ar["actual_cost_expenditure"];
                                $total_a = ($sum_total_approved_gad_budget+$sum_actual_cost_expenditure);
                                if($countClient == $totalClient)
                                {
                                    echo "
                                    <tr class='subtotal'>
                                        <td colspan='7'><b>Sub-total</b></td>
                                        <td></td>
                                        <td style='text-align:right;'>
                                            <b>".(number_format($sum_total_approved_gad_budget,2))."</b>
                                        </td>
                                        <td style='text-align:right;'>
                                            <b>".(number_format($sum_actual_cost_expenditure,2))."</b>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr class='total_a'>
                                        <td colspan='7'><b>Total A (MOEE+PS+CO)</b></td>
                                        <td colspan='3'>".(number_format($total_a,2))."</td>
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
                                $sum_actual_cost_expenditure   += $ar["actual_cost_expenditure"];
                                $total_b = ($sum_total_approved_gad_budget+$sum_actual_cost_expenditure);
                                if($countOrganization == $totalOrganization)
                                {
                                    echo "
                                    <tr class='subtotal'>
                                        <td colspan='7'><b>Sub-total</b></td>
                                        <td></td>
                                        <td style='text-align:right;'>
                                            <b>".(number_format($sum_total_approved_gad_budget,2))."</b>
                                        </td>
                                        <td style='text-align:right;'>
                                            <b>".(number_format($sum_actual_cost_expenditure,2))."</b>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr class='total_b'>
                                        <td colspan='7'><b>Total B (MOEE+PS+CO)</b></td>
                                        <td colspan='3'>".(number_format($total_b,2))."</td>
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
                            <td colspan="7">ATTRIBUTED PROGRAMS <button class="btn btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span> Encode</button></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="attributed_program_form" id="attributed_program_anchor">
                            <td colspan="11">
                                <?php
                                    echo $this->render('attributed_program_form', [
                                        'select_PpaAttributedProgram' => $select_PpaAttributedProgram,
                                        'ruc' => $ruc,
                                        'onstep' => $onstep,
                                    ]);
                                ?>
                            </td>
                        </tr>
                        <?php
                            $this->registerJs("
                                $('html, body').animate({
                                    scrollTop: $('#".$tocreate."').offset().top
                                }, 'slow');
                            ");
                        ?>
                        <tr class="ar_attributed_program_head">
                            <td colspan="7">Title of LGU Program or Project</td>
                            <td>HGDG PIMME/FIMME Score</td>
                            <td>Total Annual Program/ Project Cost or Expenditure</td>
                            <td>GAD Attributed Program/Project Cost or Expenditure</td>
                            <td>Variance or Remarks</td>
                        </tr>
                         <?php 
                        $notnull_apPpaValue = null;
                        $total_c = 0;
                        foreach ($dataAttributedProgram as $key => $dap) { ?>
                            <?php if($notnull_apPpaValue != $dap["ap_ppa_value"]){ ?>
                                <tr class="attributed_program_ppa_value">
                                    <td colspan="11"><b><?= $dap["ap_ppa_value"] ?></b></td>
                                </tr>
                            <?php } ?>
                            
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
                                        'colspanValue' => '7',
                                        'controller_id' => $dap['controller_id'],
                                        'form_id' => 'attributed-program',
                                        'customStyle' => '',
                                    ])
                                ?>
                                <?php
                                    echo $this->render('/gad-plan-budget/cell_reusable_form',[
                                        'cell_value' => $dap["hgdg_pimme"],
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
                                    ])
                                ?>
                                <?php
                                    echo $this->render('/gad-plan-budget/cell_reusable_form',[
                                        'cell_value' => $dap["gad_attributed_pro_cost"],
                                        'row_id' => $dap["id"],
                                        'record_unique_code' => $dap["record_tuc"],
                                        'attribute_name' => "gad_attributed_pro_cost",
                                        'data_type' => 'number',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-ar-gad-attributed-pro-cost']),
                                        'column_title' => 'GAD Attributed Program/Project Cost or Expenditure',
                                        'colspanValue' => '',
                                        'controller_id' => $dap['controller_id'],
                                        'form_id' => 'attributed-program',
                                        'customStyle' => 'text-align:right;',
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
                                    ])
                                ?>
                            </tr>
                        <?php 
                        $total_c += $dap["gad_attributed_pro_cost"];
                        $notnull_apPpaValue = $dap["ap_ppa_value"];
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
