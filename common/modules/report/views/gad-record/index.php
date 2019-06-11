<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\modules\report\controllers\GadPlanBudgetController;
use common\modules\report\controllers\GadAccomplishmentReportController;
use common\modules\report\controllers\DefaultController;
use common\modules\report\controllers\GadRecordController;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\report\models\GadRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $index_title;
// $this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .table > caption + thead > tr:first-child > th, .table > colgroup + thead > tr:first-child > th, .table > thead:first-child > tr:first-child > th, .table > caption + thead > tr:first-child > td, .table > colgroup + thead > tr:first-child > td, .table > thead:first-child > tr:first-child > td
    {
        border-top: none;
    }
    table.table thead tr th
    {
        background-color: #7e57b1;
        /*color:#dac4c4;*/
        color:white;
        /*border:1px solid #dac4c4;*/
        /*text-align: center;*/
        font-weight: normal;
    }
    table.table
    {
        border:1px solid #7e57b1;
    }
    table.table tbody tr td
    {
        border:none;
    }
    table.table thead tr th
    {
        border:1px solid #7e57b1;
    }
    a.btn-view-report
    {
        background-color: #4a4242 !important;
        border:1px solid #2a2626 !important;
        color: white;   
    }
    a.btn-view-report:hover
    {
        color: white;
        background-color: #5f5858 !important;
    }
</style>
<div class="gad-record-index">

<!-- <p>
    <?php // Html::a('Create Annex A', ['create'], ['class' => 'btn btn-success']) ?>
</p> -->
<h3 style="text-transform: uppercase;"><b><?= Html::encode($this->title) ?></b></h3>
<div class="cust-panel">

    <div class="cust-panel-header gad-color">
        
        </div>
        <div class="cust-panel-body table-responsive">
            <br/>
            <?php
                echo $this->render('_search', ['model' => $searchModel, 'region' => $region,'province' => $province,'citymun' => $citymun,'report_type' => $report_type]);
            ?>
            <?php
                if(Yii::$app->user->can("gad_submit_all_to_central"))
                {
                    echo Html::a('<i class="glyphicon glyphicon-send"></i> Submit All Endorsed Reports to Central Office',
                      [
                        'multiple-submit','report_type' => $report_type

                      ],
                      [
                        'class' => 'btn btn-primary btn-sm pull-right',
                        'id'=>"submitAll",
                        'style' => ' margin-top:5px;',
                        'data' => [
                            'confirm' => 'Are you sure you want Submit All Endorsed Reports to Central Office?',
                            'method' => 'post',
                        ],
                      ]);
                }
            ?>
            <br/>
            <?php
                if(Yii::$app->user->can("gad_field_permission"))
                {
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'label' => 'Office',
                                'attribute' => 'office_name',
                            ],
                            [
                                'label' => 'City/Municipality',
                                'attribute' => 'citymun_name',
                            ],
                            [
                                'label' => 'Year',
                                'attribute' => 'record_year',
                            ],
                            [
                                'label' => 'Total LGU Budget',
                                'attribute' => 'record_total_lgu_budget',
                                'value' => function($model)
                                {   
                                    return !empty($model["record_total_lgu_budget"]) ? "Php ".number_format($model["record_total_lgu_budget"],2) : "";
                                }
                            ],
                            [
                                'label' => 'Total GAD Budget',
                                'format' => 'raw',
                                'value' => function($model)
                                {
                                    return GadPlanBudgetController::ComputeGadBudget($model['record_tuc']);
                                }
                            ],
                            [
                                'label' => 'Status',
                                'attribute' => 'record_status',
                                'format' => 'raw',
                                'value' => function($model)
                                {
                                    return DefaultController::DisplayStatus($model["record_status"]);
                                }
                            ],
                            [
                                'label' => 'Remarks',
                                'value' => function($model)
                                {
                                    return GadRecordController::GenerateRemarks($model["record_tuc"]);
                                }
                            ],

                            ['class' => 'yii\grid\ActionColumn',
                                'template' => '{view}',
                                'buttons' => [
                                    'view' => function($url, $model) use ($urlReport,$report_type){
                                        if($model["record_status"] == 2 || $model["record_status"] == 4)
                                        {
                                             return Html::a('<span class="glyphicon glyphicon-eye-open"></span> View Report', [$urlReport,
                                                'ruc' => $model['record_tuc'], 
                                                'onstep' => $report_type == "accomplishment" ? 'to_create_ar' : 'to_create_gpb',
                                                'tocreate'=> $report_type == "accomplishment" ? 'accomp_report' : 'gad_plan_budget',
                                            ], 
                                                ['class'=>'btn btn-default btn-sm btn-view-report']);
                                        }
                                       
                                    },
                                ],
                            ],
                        ],
                    ]);
                }
                else if(Yii::$app->user->can("gad_lgu_permission"))
                {
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'label' => 'Office',
                                'attribute' => 'office_name',
                            ],
                            [
                                'label' => 'City/Municipality',
                                'attribute' => 'citymun_name',
                            ],
                            [
                                'label' => 'Year',
                                'attribute' => 'record_year',
                            ],
                            [
                                'label' => 'Total LGU Budget',
                                'attribute' => 'record_total_lgu_budget',
                                'value' => function($model)
                                {   
                                    return !empty($model["record_total_lgu_budget"]) ? "Php ".number_format($model["record_total_lgu_budget"],2) : "";
                                }
                            ],
                            [
                                'label' => $report_type == "plan_budget" ? "Total GAD Budgdet" : "Total GAD Expenditure",
                                'format' => 'raw',
                                'value' => function($model) use ($report_type)
                                {
                                    if($report_type == "accomplishment")
                                    {
                                        return GadAccomplishmentReportController::ComputeAccomplishment($model['record_tuc']);
                                    }
                                    else
                                    {
                                        return GadPlanBudgetController::ComputeGadBudget($model['record_tuc']);
                                    }
                                }
                            ],
                            [
                                'label' => 'Status',
                                'attribute' => 'record_status',
                                'format' => 'raw',
                                'value' => function($model)
                                {
                                    return DefaultController::DisplayStatus($model["record_status"]);
                                }
                            ],
                            [
                                'label' => 'Remarks',
                                'value' => function($model)
                                {
                                    return GadRecordController::GenerateRemarks($model["record_tuc"]);
                                }
                            ],

                            ['class' => 'yii\grid\ActionColumn',
                                'template' => '{view}',
                                'buttons' => [
                                    'view' => function($url, $model) use ($urlReport,$report_type){
                                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span> View Report', [$urlReport,
                                                'ruc' => $model['record_tuc'], 
                                                'onstep' => $report_type == "accomplishment" ? 'to_create_ar' : 'to_create_gpb',
                                                'tocreate'=> $report_type == "accomplishment" ? 'accomp_report' : 'gad_plan_budget',
                                            ], 
                                                ['class'=>'btn btn-default btn-sm btn-view-report']);
                                    },
                                ],
                            ],
                        ],
                    ]);
                } 
                else if(Yii::$app->user->can("gad_lgu_province_permission") || Yii::$app->user->can("gad_province_permission"))
                {
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'label' => 'Office',
                                'attribute' => 'office_name',
                            ],
                            [
                                'label' => 'Province',
                                'attribute' => 'province_name',
                            ],
                            [
                                'label' => 'Year',
                                'attribute' => 'record_year',
                            ],
                            [
                                'label' => 'Total LGU Budget',
                                'attribute' => 'record_total_lgu_budget',
                                'value' => function($model)
                                {   
                                    return !empty($model["record_total_lgu_budget"]) ? "Php ".number_format($model["record_total_lgu_budget"],2) : "";
                                }
                            ],
                            [
                                'label' => $report_type == "plan_budget" ? "Total GAD Budgdet" : "Total GAD Expenditure",
                                'format' => 'raw',
                                'value' => function($model) use ($report_type)
                                {
                                    if($report_type == "accomplishment")
                                    {
                                        return GadAccomplishmentReportController::ComputeAccomplishment($model['record_tuc']);
                                    }
                                    else
                                    {
                                        return GadPlanBudgetController::ComputeGadBudget($model['record_tuc']);
                                    }
                                }
                            ],
                            [
                                'label' => 'Status',
                                'attribute' => 'record_status',
                                'format' => 'raw',
                                'value' => function($model)
                                {
                                    return DefaultController::DisplayStatus($model["record_status"]);
                                }
                            ],
                            [
                                'label' => 'Remarks',
                                'value' => function($model)
                                {
                                    return GadRecordController::GenerateRemarks($model["record_tuc"]);
                                }
                            ],

                            ['class' => 'yii\grid\ActionColumn',
                                'template' => '{view}',
                                'buttons' => [
                                    'view' => function($url, $model) use ($urlReport,$report_type){
                                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span> View Report', [$urlReport,
                                                'ruc' => $model['record_tuc'], 
                                                'onstep' => $report_type == "accomplishment" ? 'to_create_ar' : 'to_create_gpb',
                                                'tocreate'=> $report_type == "accomplishment" ? 'accomp_report' : 'gad_plan_budget',
                                            ], 
                                                ['class'=>'btn btn-default btn-sm btn-view-report']);
                                    },
                                ],
                            ],
                        ],
                    ]);
                }
                else if(Yii::$app->user->can("gad_region_permission"))
                {
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'label' => 'Office',
                                'attribute' => 'office_name',
                            ],
                            [
                                'label' => 'Province',
                                'attribute' => 'province_name',
                            ],
                            [
                                'label' => 'City/Municipality',
                                'attribute' => 'citymun_name',
                                'value' => function($model)
                                {
                                    return !empty($model["citymun_name"]) ? $model["citymun_name"] : "";
                                }
                            ],
                            [
                                'label' => 'Year',
                                'attribute' => 'record_year',
                            ],
                            [
                                'label' => 'Total LGU Budget',
                                'attribute' => 'record_total_lgu_budget',
                                'value' => function($model)
                                {   
                                    return !empty($model["record_total_lgu_budget"]) ? "Php ".number_format($model["record_total_lgu_budget"],2) : "";
                                }
                            ],
                            [
                                'label' => $report_type == "plan_budget" ? "Total GAD Budgdet" : "Total GAD Expenditure",
                                'format' => 'raw',
                                'value' => function($model) use ($report_type)
                                {
                                    if($report_type == "accomplishment")
                                    {
                                        return GadAccomplishmentReportController::ComputeAccomplishment($model['record_tuc']);
                                    }
                                    else
                                    {
                                        return GadPlanBudgetController::ComputeGadBudget($model['record_tuc']);
                                    }
                                }
                            ],
                            [
                                'label' => 'Status',
                                'attribute' => 'record_status',
                                'format' => 'raw',
                                'value' => function($model)
                                {
                                    return DefaultController::DisplayStatus($model["record_status"]);
                                }
                            ],
                            [
                                'label' => 'Remarks',
                                'value' => function($model)
                                {
                                    return GadRecordController::GenerateRemarks($model["record_tuc"]);
                                }
                            ],

                            ['class' => 'yii\grid\ActionColumn',
                                'template' => '{view}',
                                'buttons' => [
                                    'view' => function($url, $model) use ($urlReport,$report_type){
                                        if($model['record_status'] == 3 || $model['record_status'] == 4)
                                        {
                                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span> View Report', [$urlReport,
                                                'ruc' => $model['record_tuc'], 
                                                'onstep' => $report_type == "accomplishment" ? 'to_create_ar' : 'to_create_gpb',
                                                'tocreate'=> $report_type == "accomplishment" ? 'accomp_report' : 'gad_plan_budget',
                                            ], 
                                                ['class'=>'btn btn-default btn-sm btn-view-report']);
                                        }
                                        
                                    },
                                ],
                            ],
                        ],
                    ]);
                }
                else
                {
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'label' => 'Office',
                                'attribute' => 'office_name',
                            ],
                            [
                                'label' => 'Region',
                                'attribute' => 'region_name',
                            ],
                            [
                                'label' => 'Province',
                                'attribute' => 'province_name',
                            ],
                            [
                                'label' => 'City/Municipality',
                                'attribute' => 'citymun_name',
                                'value' => function($model)
                                {
                                    return !empty($model["citymun_name"]) ? $model["citymun_name"] : "";
                                }
                            ],
                            [
                                'label' => 'Year',
                                'attribute' => 'record_year',
                            ],
                            [
                                'label' => 'Total LGU Budget',
                                'attribute' => 'record_total_lgu_budget',
                                'value' => function($model)
                                {   
                                    return !empty($model["record_total_lgu_budget"]) ? "Php ".number_format($model["record_total_lgu_budget"],2) : "";
                                }
                            ],
                            [
                                'label' => $report_type == "plan_budget" ? "Total GAD Budgdet" : "Total GAD Expenditure",
                                'format' => 'raw',
                                'value' => function($model) use ($report_type)
                                {
                                    if($report_type == "accomplishment")
                                    {
                                        return GadAccomplishmentReportController::ComputeAccomplishment($model['record_tuc']);
                                    }
                                    else
                                    {
                                        return GadPlanBudgetController::ComputeGadBudget($model['record_tuc']);
                                    }
                                }
                            ],
                            // [
                            //     'label' => 'Status',
                            //     'attribute' => 'record_status',
                            //     'format' => 'raw',
                            //     'value' => function($model)
                            //     {
                            //         return DefaultController::DisplayStatus($model["record_status"]);
                            //     }
                            // ],
                            [
                                'label' => 'Remarks',
                                'value' => function($model)
                                {
                                    return GadRecordController::GenerateRemarks($model["record_tuc"]);
                                }
                            ],

                            ['class' => 'yii\grid\ActionColumn',
                                'template' => '{view}',
                                'buttons' => [
                                    'view' => function($url, $model) use ($urlReport,$report_type){

                                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span> View Report', [$urlReport,
                                                'ruc' => $model['record_tuc'], 
                                                'onstep' => $report_type == "accomplishment" ? 'to_create_ar' : 'to_create_gpb',
                                                'tocreate'=> $report_type == "accomplishment" ? 'accomp_report' : 'gad_plan_budget',
                                            ], 
                                                ['class'=>'btn btn-primary btn-sm btn-view-report']);
                                    },
                                ],
                            ],
                        ],
                    ]);
                }
                 
            ?>
            <?php
                $this->registerJs("
                    $('table.table').addClass('table-hover');
                ");
            ?>
        </div>
    </div>
</div>
