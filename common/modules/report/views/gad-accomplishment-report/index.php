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
                            $not_FocusedId = null;
                            $not_InnerCategoryId = null;
                        ?>
                        <?php foreach ($dataAR as $key => $ar) { ?>
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
                                        'customStyle' => '',
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
                                        'customStyle' => '',
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
                            $not_FocusedId = $ar["gad_focused_title"];
                            $not_InnerCategoryId = $ar["inner_category_title"];
                        ?>
                        <?php } ?>
                        
                        <tr class="ar_attributed_program">
                            <td colspan="7">ATTRIBUTED PROGRAMS</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr class="ar_attributed_program_head">
                            <td colspan="7">Title of LGU Program or Project</td>
                            <td>HGDG PIMME/FIMME Score</td>
                            <td>Total Annual Program/ Project Cost or Expenditure</td>
                            <td>GAD Attributed Program/Project Cost or Expenditure</td>
                            <td>Variance or Remarks</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
