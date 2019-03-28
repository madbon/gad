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

$this->title = $onstep == 'to_create_gpb' ? 'Step 2. Encode Annual GAD Plan and Budget ' : 'ANNUAL GENDER AND DEVELOPMENT (GAD PLAN BUDGET) FY '.date("Y");
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="gad-plan-budget-index">
    <!-- <p>
        <?php // Html::a('Create Annex A', ['gad-record/create'], ['class' => 'btn btn-success']) ?>
    </p> -->

   
    <div class="cust-panel basic-information">
        <div class="cust-panel-header success">
        </div>
        <div class="cust-panel-body">
            <div class="cust-panel-title">
                <p class="sub-title">Primary Information</p>
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
    
    <?php
        $this->registerJs('
            $("#btn-encode").click(function(){
                $(".input-form").slideDown(300);
            });
        ');
    ?>
    <div class="cust-panel input-form" style="display: none;">
        <div class="cust-panel-header success">
        </div>
        <div class="cust-panel-body">
            <div class="cust-panel-title">
                <p class="sub-title">INPUT FORM</p>
            </div>
            <div class="cust-panel-inner-body">
                <?php echo $this->render('client_focused_form',[
                    'opt_cli_focused' => $opt_cli_focused,
                    'ruc' => $ruc,
                    'select_GadFocused' => $select_GadFocused,
                    'select_GadInnerCategory' => $select_GadInnerCategory,
                    'onstep' => $onstep
                    ]);
                ?>
            </div>
        </div>
    </div>

    
    <br/>

    <div class="cust-panel tabular-report">
        <div class="cust-panel-header success">
        </div>
        <div class="cust-panel-body">
            <div class="cust-panel-title">
                <p class="sub-title">Tabular Report</p>
            </div>
            <div class="cust-panel-inner-body">
                <table class="table table-responsive table-bordered gad-plan-budget">
                    <thead>
                        <tr>
                            <th>Gender Issue or GAD Mandate </th>
                            <th>Cause of the Gender Issue</th>
                            <th>GAD Objective</th>
                            <th>Relevant LGU Program or Project</th>
                            <th>GAD Activity</th>
                            <th>Performance Target </th>
                            <th>Performance Indicator</th>
                            <th colspan="3">GAD Budget (6)</th>
                            <th>Lead or Responsible Office </th>
                            <th></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>MOOE</th>
                            <th>PS</th>
                            <th>CO</th>
                            <th></th>
                            <th>Action</th>
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
                                    <td colspan='7'><b><?= $plan["gad_focused_title"] ?></b></td>
                                    <td colspan='3'></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php } ?>

                            <!-- Gender Issue or GAD Mandate -->
                            <?php if($not_InnerCategoryId != $plan["inner_category_title"]) { ?>
                                <tr class="inner_category_title">
                                    <td colspan='7'><b><?= $plan["inner_category_title"] ?></b></td>
                                    <td colspan='3'></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <?php } ?>

                            <tr>
                                <td>
                                    <?= $not_ppa_value != $plan["ppa_value"] ? $plan["ppa_value"] : "" ?>
                                </td>   
                                <td>
                                    <?= !empty($plan["cause_gender_issue"]) ? $plan["cause_gender_issue"] : "" ?>
                                </td>
                                

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
                                if($countClient == $totalClient)
                                {
                                    echo "
                                    <tr>
                                        <td colspan='7'><b>Sub-total</b></td>
                                        <td style='text-align:right;'><b>".(number_format($sum_mooe,2))."</b></td>
                                        <td style='text-align:right;'><b>".(number_format($sum_ps,2))."</b></td>
                                        <td style='text-align:right;'><b>".(number_format($sum_co,2))."</b></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan='7'><b>Total A (MOEE+PS+CO)</b></td>
                                        <td colspan='3'></td>
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
                                if($countOrganization == $totalOrganization)
                                {
                                    echo "
                                    <tr>
                                        <td colspan='7'><b>Sub-total</b></td>
                                        <td style='text-align:right;'><b>".(number_format($sum_mooe,2))."</b></td>
                                        <td style='text-align:right;'><b>".(number_format($sum_ps,2))."</b></td>
                                        <td style='text-align:right;'><b>".(number_format($sum_co,2))."</b></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan='7'><b>Total B (MOEE+PS+CO)</b></td>
                                        <td colspan='3'></td>
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
                            <td colspan="7">
                                <b>ATTRIBUTED PROGRAMS</b> 
                                <button type="button" class="btn btn-success btn-sm">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                    Encode
                                </button>
                            </td>
                            <td colspan="3"></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="attributed_program_form">
                            <td colspan="12">
                                <?php
                                    echo $this->render('attributed_program_form', [
                                        'select_PpaAttributedProgram' => $select_PpaAttributedProgram,
                                        'ruc' => $ruc,
                                        'onstep' => $onstep,
                                    ]);
                                ?>
                            </td>
                        </tr>
                        <tr class="attributed_program_thead">
                            <td colspan="3"><b>Title of LGU Program or Project</b></td>
                            <td colspan="2"><b>HGDG Design/ Funding Facility/ Generic Checklist Score</b></td>
                            <td colspan="2"><b>Total Annual Program/ Project Budget</b></td>
                            <td colspan="3"><b>GAD Attributed Program/Project Budget</b></td>
                            <td><b>Lead or Responsible Office</b></td>
                            <td></td>
                        </tr>
                        <?php 
                        $notnull_apPpaValue = null;
                        foreach ($dataAttributedProgram as $key => $dap) { ?>
                            <?php if($notnull_apPpaValue != $dap["ap_ppa_value"]){ ?>
                                <tr class="attributed_program_ppa_value">
                                    <td colspan="12"><b><?= $dap["ap_ppa_value"] ?></b></td>
                                </tr>
                            <?php } ?>
                            
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
                                        'colspanValue' => '3',
                                        'controller_id' => $dap['controller_id'],
                                        'form_id' => 'attributed-program'
                                    ])
                                ?>
                                <?php
                                    echo $this->render('cell_reusable_form',[
                                        'cell_value' => $dap["hgdg"],
                                        'row_id' => $dap["id"],
                                        'record_unique_code' => $dap["record_tuc"],
                                        'attribute_name' => "hgdg",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-hgdg']),
                                        'column_title' => 'HGDG Design/ Funding Facility/ Generic Checklist Score',
                                        'colspanValue' => '2',
                                        'controller_id' => $dap['controller_id'],
                                        'form_id' => 'attributed-program'
                                    ])
                                ?>
                                <?php
                                    echo $this->render('cell_reusable_form',[
                                        'cell_value' => $dap["total_annual_pro_budget"],
                                        'row_id' => $dap["id"],
                                        'record_unique_code' => $dap["record_tuc"],
                                        'attribute_name' => "total_annual_pro_budget",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-total-annual-pro-budget']),
                                        'column_title' => 'Total Annual Program/ Project Budget',
                                        'colspanValue' => '2',
                                        'controller_id' => $dap['controller_id'],
                                        'form_id' => 'attributed-program'
                                    ])
                                ?>
                                <?php
                                    echo $this->render('cell_reusable_form',[
                                        'cell_value' => $dap["attributed_pro_budget"],
                                        'row_id' => $dap["id"],
                                        'record_unique_code' => $dap["record_tuc"],
                                        'attribute_name' => "attributed_pro_budget",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-attributed-pro-budget']),
                                        'column_title' => 'GAD Attributed Program/Project Budget',
                                        'colspanValue' => '3',
                                        'controller_id' => $dap['controller_id'],
                                        'form_id' => 'attributed-program'
                                    ])
                                ?>
                                <?php
                                    echo $this->render('cell_reusable_form',[
                                        'cell_value' => $dap["lead_responsible_office"],
                                        'row_id' => $dap["id"],
                                        'record_unique_code' => $dap["record_tuc"],
                                        'attribute_name' => "lead_responsible_office",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-ap-lead-responsible-office']),
                                        'column_title' => 'Lead or Responsible Office',
                                        'colspanValue' => '',
                                        'controller_id' => $dap['controller_id'],
                                        'form_id' => 'attributed-program'
                                    ])
                                ?>
                                <td></td>
                            </tr>
                        <?php 
                        $notnull_apPpaValue = $dap["ap_ppa_value"];
                        } ?>
                    </tbody>
                </table>

                
            </div>
        </div>
    </div>

    
</div>
