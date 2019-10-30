<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\modules\report\controllers\GadPlanBudgetController;
use common\modules\report\controllers\GadAccomplishmentReportController;
use common\modules\report\controllers\DefaultController;
use common\modules\report\controllers\GadRecordController;
use yii\helpers\Url;

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
    table.table tbody tr td.remarks_class
    {
        width: 150px;
        white-space: pre-wrap;
        font-size:12px;
        font-style: italic;
    }
    .btn-block
    {
        margin-bottom:5px;
    }
    .zui-wrapper {
    	position: relative;
	}
	.zui-scroller {
	    margin-left: 0px;
	    overflow-x: scroll;
	    overflow-y: hidden;

	    padding-bottom: 5px;
	    /*height: 500px;*/
	    /*width: 300px;*/
	}
	.zui-table .zui-sticky-col {
	    border-left: solid 1px #DDEFEF;
	    border-right: solid 1px black;
	    left: 0;
	    /*margin-left: -80px;*/
	    /*height: 100%;*/
	    position: absolute;
	    top: auto;
	    width: 300px;
	    background-color: white;
	    font-size: 12px;
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
        <div class="cust-panel-body">
        <br/>
            <?php
                // $function = new DefaultController();
                echo $this->render('_search', ['model' => $searchModel, 'region' => $region,'province' => $province,'citymun' => $citymun,'report_type' => $report_type,'statusList' => $statusList,'arrayYear' => $arrayYear]);
            ?>
            <?php
                if(Yii::$app->user->can("gad_archive_filtered_result"))
                {
                    echo Html::a('<i class="fa fa-archive"></i> &nbsp;Archive all filtered result', 
                    [
                        '/report/gad-record/archive','report_type' => $report_type,'record_id' => ""
                    ], 
                    [
                        'class' => 'btn btn-md btn-warning',
                        'data' => [
                            'confirm' => 'Are you sure you want to perform this action?',
                            'method' => 'post'
                            ]
                    ]);
                }
            ?>
            <div class="table-responsive">
                <?php
                    if(Yii::$app->user->can("gad_lgu_permission"))
                    {
                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'options' => ['table-responsive'],
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
                                    'label' => $report_type == "plan_budget" ? 'Status' : false,
                                    'attribute' => 'record_status',
                                    'format' => 'raw',
                                    'value' => function($model) use ($report_type)
                                    {

                                        return $report_type == "plan_budget" ? DefaultController::DisplayStatus($model["record_status"]) : false;
                                    }
                                ],
                                [
                                    'label' => 'Date',
                                    'value' => function($model)
                                    {
                                        
                                        return !empty(GadRecordController::GenerateLatestDate($model['record_tuc'])) ? GadRecordController::GenerateLatestDate($model['record_tuc']) : date("F j, Y", strtotime(date($model['date_created'])));
                                    }
                                ],
                                // [
                                //     'label' => 'Plan Category',
                                //     'attribute' => 'create_status_id',
                                //     'format' => 'raw',
                                //     'value' => function($model)
                                //     {
                                //         return DefaultController::CreatePlanStatus($model["record_tuc"]);
                                //     }
                                // ],
                                
                                [
                                    'label' => 'Remarks',
                                    'contentOptions' => ['class' => 'remarks_class'],
                                    'value' => function($model)
                                    {
                                        return GadRecordController::GenerateRemarks($model["record_tuc"]);
                                    }
                                ],
                                [
                                    'label' => 'Attached file(s) from the Reviewer',
                                    'format' => 'raw',
                                    'value' => function($model)
                                    {
                                        if(DefaultController::CountUploadedFile($model['record_tuc'],"GadRecord") != 0)
                                        {
                                            $urluploadfile = '@web/report/gad-plan-budget/upload-form-endorsement-file?ruc='.$model["record_tuc"]."&onstep=to_create_gpb&tocreate=gad_plan_budget";
                                            return Html::button('<span class="glyphicon glyphicon-file"> </span> ('.DefaultController::CountUploadedFile($model['record_tuc'],"GadRecord").")", ['value'=>Url::to($urluploadfile),
                            'class' => 'btn btn-primary btn-sm modalButton ','title' => 'Attached file(s) by the reviewer',]);
                                        }
                                        else
                                        {
                                            return "<i>No file(s) uploaded</i>";
                                        }
                                    }
                                ],

                                ['class' => 'yii\grid\ActionColumn',
                                    'template' => '{view} {track} {delete} {archive}',
                                    'buttons' => [
                                        'view' => function($url, $model) use ($urlReport,$report_type){
                                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span> View', [$urlReport,
                                                    'ruc' => $model['record_tuc'], 
                                                    'onstep' => $report_type == "accomplishment" ? 'to_create_ar' : 'to_create_gpb',
                                                    'tocreate'=> $report_type == "accomplishment" ? 'accomp_report' : 'gad_plan_budget',
                                                ], 
                                                    ['class'=>'btn btn-info btn-xs btn-block']);
                                        },
                                        'track' => function($url, $model) use ($urlReport,$report_type){
                                            $url_track = '@web/report/gad-record/track?ruc='.$model['record_tuc'];
                                            return Html::button('<span class="glyphicon glyphicon-time"></span> Track', ['value'=>Url::to($url_track), 'class' => 'btn btn-default btn-xs btn-block modalButton ','style' => '']);
                                        },
                                        'delete'=>function ($url, $model) {
                                            if(in_array($model['record_status'],DefaultController::HasStatus("delete_report_for_lgu")) || in_array($model['record_status'],DefaultController::HasStatus("delete_report_for_huc")))
                                            {
                                                return Html::a('<i class="glyphicon glyphicon-trash"></i> Delete', 
                                                [
                                                  '/report/gad-record/delete', 'id' => $model['record_id']
                                                ], 
                                                [
                                                  'class' => 'btn btn-xs btn-danger btn-block',
                                                  'data' => [
                                                      'confirm' => 'Are you sure you want to delete this item?',
                                                      'method' => 'post']
                                                ]);
                                            }
                                            else
                                            {
                                                return false;
                                            }
                                        },
                                        'archive' => function($url,$model) use ($urlReport,$report_type){
                                            if(in_array($model['record_status'],DefaultController::HasStatus("archive_report_for_lgu")) || in_array($model['record_status'],DefaultController::HasStatus("archive_report_for_huc")))
                                            {
                                                return Html::a('<i class="fa fa-archive"></i> &nbsp;Archive ', 
                                                [
                                                '/report/gad-record/archive','report_type' => $report_type,'record_id' => $model['record_id']
                                                ], 
                                                [
                                                'class' => 'btn btn-xs btn-warning pull-right',
                                                'data' => [
                                                    'confirm' => 'Are you sure you want to perform this action?',
                                                    'method' => 'post'
                                                    ]
                                                ]);
                                            }
                                        },
                                    ],
                                ],
                            ],
                        ]);
                    } 
                    else if(Yii::$app->user->can("gad_lgu_province_permission"))
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
                                    'label' => $report_type == "plan_budget" ? 'Status' : false,
                                    'attribute' => 'record_status',
                                    'format' => 'raw',
                                    'value' => function($model) use ($report_type)
                                    {

                                        return $report_type == "plan_budget" ? DefaultController::DisplayStatus($model["record_status"]) : false;
                                    }
                                ],
                                [
                                    'label' => 'Date',
                                    'value' => function($model)
                                    {
                                        
                                        return !empty(GadRecordController::GenerateLatestDate($model['record_tuc'])) ? GadRecordController::GenerateLatestDate($model['record_tuc']) : date("F j, Y", strtotime(date($model['date_created'])));
                                    }
                                ],
                                [
                                    'label' => 'Remarks',
                                    'contentOptions' => ['class' => 'remarks_class'],
                                    'value' => function($model)
                                    {
                                        return GadRecordController::GenerateRemarks($model["record_tuc"]);
                                    }
                                ],
                                [
                                    'label' => 'Attached file(s) from the Reviewer',
                                    'format' => 'raw',
                                    'value' => function($model)
                                    {
                                        if(DefaultController::CountUploadedFile($model['record_tuc'],"GadRecord") != 0)
                                        {
                                            $urluploadfile = '@web/report/gad-plan-budget/upload-form-endorsement-file?ruc='.$model["record_tuc"]."&onstep=to_create_gpb&tocreate=gad_plan_budget";
                                            return Html::button('<span class="glyphicon glyphicon-file"> </span> ('.DefaultController::CountUploadedFile($model['record_tuc'],"GadRecord").")", ['value'=>Url::to($urluploadfile),
                            'class' => 'btn btn-primary btn-sm modalButton ','title' => 'Attached file(s) by the reviewer',]);
                                        }
                                        else
                                        {
                                            return "<i>No file(s) uploaded</i>";
                                        }
                                    }
                                ],

                                ['class' => 'yii\grid\ActionColumn',
                                    'template' => Yii::$app->user->can("gad_delete_plan_budget") ? '{view} {track} {delete} {archive}' : '{view} {track} {archive}',
                                    'buttons' => [
                                        'view' => function($url, $model) use ($urlReport,$report_type){
                                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span> View', [$urlReport,
                                                    'ruc' => $model['record_tuc'], 
                                                    'onstep' => $report_type == "accomplishment" ? 'to_create_ar' : 'to_create_gpb',
                                                    'tocreate'=> $report_type == "accomplishment" ? 'accomp_report' : 'gad_plan_budget',
                                                ], 
                                                    ['class'=>'btn btn-info btn-xs btn-block']);
                                        },
                                        'track' => function($url, $model) use ($urlReport,$report_type){
                                            $url_track = '@web/report/gad-record/track?ruc='.$model['record_tuc'];
                                            return Html::button('<span class="glyphicon glyphicon-time"></span> Track', ['value'=>Url::to($url_track), 'class' => 'btn btn-default btn-xs btn-block modalButton ','style' => '']);
                                        },
                                        'delete'=>function ($url, $model) {
                                            if(in_array($model['record_status'],DefaultController::HasStatus("delete_report_for_lgu_province")))
                                            {
                                                return Html::a('<i class="glyphicon glyphicon-trash"></i> Delete', 
                                            [
                                                  '/report/gad-record/delete', 'id' => $model['record_id']
                                                ], 
                                                [
                                                  'class' => 'btn btn-xs btn-danger btn-block',
                                                  'data' => [
                                                      'confirm' => 'Are you sure you want to delete this item?',
                                                      'method' => 'post']
                                                ]);
                                            }
                                            else
                                            {
                                                return false;
                                            }
                                        },
                                        'archive' => function($url,$model) use ($urlReport,$report_type){
                                            if(in_array($model['record_status'],DefaultController::HasStatus("archive_report_for_lgu_province")))
                                            {
                                                return Html::a('<i class="fa fa-archive"></i> &nbsp;Archive ', 
                                                [
                                                '/report/gad-record/archive','report_type' => $report_type,'record_id' => $model['record_id']
                                                ], 
                                                [
                                                'class' => 'btn btn-xs btn-warning pull-right',
                                                'data' => [
                                                    'confirm' => 'Are you sure you want to perform this action?',
                                                    'method' => 'post'
                                                    ]
                                                ]);
                                            }
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
                                    'label' => $report_type == "plan_budget" ? 'Status' : false,
                                    'attribute' => 'record_status',
                                    'format' => 'raw',
                                    'value' => function($model) use ($report_type)
                                    {

                                        return $report_type == "plan_budget" ? DefaultController::DisplayStatus($model["record_status"]) : false;
                                    }
                                ],
                                [
                                    'label' => 'Date',
                                    'value' => function($model)
                                    {
                                        
                                        return !empty(GadRecordController::GenerateLatestDate($model['record_tuc'])) ? GadRecordController::GenerateLatestDate($model['record_tuc']) : date("F j, Y", strtotime(date($model['date_created'])));
                                    }
                                ],
                                [
                                    'label' => 'Remarks',
                                    'contentOptions' => ['class' => 'remarks_class'],
                                    'value' => function($model)
                                    {
                                        return GadRecordController::GenerateRemarks($model["record_tuc"]);
                                    }
                                ],
                                [
                                    'label' => 'Attached file(s) from the Reviewer',
                                    'format' => 'raw',
                                    'value' => function($model)
                                    {
                                        if(DefaultController::CountUploadedFile($model['record_tuc'],"GadRecord") != 0)
                                        {
                                            $urluploadfile = '@web/report/gad-plan-budget/upload-form-endorsement-file?ruc='.$model["record_tuc"]."&onstep=to_create_gpb&tocreate=gad_plan_budget";
                                            return Html::button('<span class="glyphicon glyphicon-file"> </span> ('.DefaultController::CountUploadedFile($model['record_tuc'],"GadRecord").")", ['value'=>Url::to($urluploadfile),
                            'class' => 'btn btn-primary btn-sm modalButton ','title' => 'Attached file(s) by the reviewer',]);
                                        }
                                        else
                                        {
                                            return "<i>No file(s) uploaded</i>";
                                        }
                                    }
                                ],

                                ['class' => 'yii\grid\ActionColumn',
                                    'template' => '{view} {track} {archive}',
                                    'buttons' => [
                                        'view' => function($url, $model) use ($urlReport,$report_type){
                                            if(in_array($model['record_status'],DefaultController::HasStatus("view_report_for_region")))
                                            {
                                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span> View', [$urlReport,
                                                    'ruc' => $model['record_tuc'], 
                                                    'onstep' => $report_type == "accomplishment" ? 'to_create_ar' : 'to_create_gpb',
                                                    'tocreate'=> $report_type == "accomplishment" ? 'accomp_report' : 'gad_plan_budget',
                                                ], 
                                                    ['class'=>'btn btn-info btn-xs']);
                                            }
                                        },
                                        'track' => function($url, $model) use ($urlReport,$report_type){
                                            $url_track = '@web/report/gad-record/track?ruc='.$model['record_tuc'];
                                            return Html::button('<span class="glyphicon glyphicon-time"></span> Track', ['value'=>Url::to($url_track), 'class' => 'btn btn-default btn-xs btn-block modalButton ','style' => '']);
                                        },
                                        'archive' => function($url,$model) use ($urlReport,$report_type){
                                            if(in_array($model['record_status'],DefaultController::HasStatus("archive_report_for_region")))
                                            {
                                                return Html::a('<i class="fa fa-archive"></i> &nbsp;Archive ', 
                                                [
                                                '/report/gad-record/archive','report_type' => $report_type,'record_id' => $model['record_id']
                                                ], 
                                                [
                                                'class' => 'btn btn-xs btn-warning pull-right',
                                                'data' => [
                                                    'confirm' => 'Are you sure you want to perform this action?',
                                                    'method' => 'post'
                                                    ]
                                                ]);
                                            }
                                        },
                                    ],
                                ],
                            ],
                        ]);
                    }
                    else if(Yii::$app->user->can("gad_ppdo_permission"))
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
                                    'label' => $report_type == "plan_budget" ? 'Status' : false,
                                    'attribute' => 'record_status',
                                    'format' => 'raw',
                                    'value' => function($model) use ($report_type)
                                    {

                                        return $report_type == "plan_budget" ? DefaultController::DisplayStatus($model["record_status"]) : false;
                                    }
                                ],
                                [
                                    'label' => 'Date',
                                    'value' => function($model)
                                    {
                                        
                                        return !empty(GadRecordController::GenerateLatestDate($model['record_tuc'])) ? GadRecordController::GenerateLatestDate($model['record_tuc']) : date("F j, Y", strtotime(date($model['date_created'])));
                                    }
                                ],
                                [
                                    'label' => 'Remarks',
                                    'contentOptions' => ['class' => 'remarks_class'],
                                    'value' => function($model)
                                    {
                                        return GadRecordController::GenerateRemarks($model["record_tuc"]);
                                    }
                                ],
                                [
                                    'label' => 'Attached file(s) from the Reviewer',
                                    'format' => 'raw',
                                    'value' => function($model)
                                    {
                                        if(DefaultController::CountUploadedFile($model['record_tuc'],"GadRecord") != 0)
                                        {
                                            $urluploadfile = '@web/report/gad-plan-budget/upload-form-endorsement-file?ruc='.$model["record_tuc"]."&onstep=to_create_gpb&tocreate=gad_plan_budget";
                                            return Html::button('<span class="glyphicon glyphicon-file"> </span> ('.DefaultController::CountUploadedFile($model['record_tuc'],"GadRecord").")", ['value'=>Url::to($urluploadfile),
                            'class' => 'btn btn-primary btn-sm modalButton ','title' => 'Attached file(s) by the reviewer',]);
                                        }
                                        else
                                        {
                                            return "<i>No file(s) uploaded</i>";
                                        }
                                    }
                                ],

                                ['class' => 'yii\grid\ActionColumn',
                                    'template' => '{view} {track} {archive}',
                                    'buttons' => [
                                        'view' => function($url, $model) use ($urlReport,$report_type){
                                            if(in_array($model['record_status'],DefaultController::HasStatus("view_report_for_ppdo")))
                                            {
                                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span> View', [$urlReport,
                                                    'ruc' => $model['record_tuc'], 
                                                    'onstep' => $report_type == "accomplishment" ? 'to_create_ar' : 'to_create_gpb',
                                                    'tocreate'=> $report_type == "accomplishment" ? 'accomp_report' : 'gad_plan_budget',
                                                ], 
                                                    ['class'=>'btn btn-info btn-xs btn-block']);
                                            }
                                            else
                                            {
                                                return false;
                                            }
                                            
                                        },
                                        'track' => function($url, $model) use ($urlReport,$report_type){
                                            $url_track = '@web/report/gad-record/track?ruc='.$model['record_tuc'];
                                            return Html::button('<span class="glyphicon glyphicon-time"></span> Track', ['value'=>Url::to($url_track), 'class' => 'btn btn-default btn-xs btn-block modalButton ','style' => '']);
                                        },
                                        'archive' => function($url,$model) use ($urlReport,$report_type){
                                            if(in_array($model['record_status'],DefaultController::HasStatus("archive_report_for_ppdo")))
                                            {
                                                return Html::a('<i class="fa fa-archive"></i> &nbsp;Archive ', 
                                                [
                                                '/report/gad-record/archive','report_type' => $report_type,'record_id' => $model['record_id']
                                                ], 
                                                [
                                                'class' => 'btn btn-xs btn-warning pull-right',
                                                'data' => [
                                                    'confirm' => 'Are you sure you want to perform this action?',
                                                    'method' => 'post'
                                                    ]
                                                ]);
                                            }
                                        },
                                    ],
                                ],
                            ],
                        ]);
                    }
                    else if(Yii::$app->user->can("gad_province_permission"))
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
                                    'label' => $report_type == "plan_budget" ? 'Status' : false,
                                    'attribute' => 'record_status',
                                    'format' => 'raw',
                                    'value' => function($model) use ($report_type)
                                    {

                                        return $report_type == "plan_budget" ? DefaultController::DisplayStatus($model["record_status"]) : false;
                                    }
                                ],
                                [
                                    'label' => 'Date',
                                    'value' => function($model)
                                    {
                                        
                                        return !empty(GadRecordController::GenerateLatestDate($model['record_tuc'])) ? GadRecordController::GenerateLatestDate($model['record_tuc']) : date("F j, Y", strtotime(date($model['date_created'])));
                                    }
                                ],
                                [
                                    'label' => 'Remarks',
                                    'contentOptions' => ['class' => 'remarks_class'],
                                    'value' => function($model)
                                    {
                                        return GadRecordController::GenerateRemarks($model["record_tuc"]);
                                    }
                                ],
                                [
                                    'label' => 'Attached file(s) from the Reviewer',
                                    'format' => 'raw',
                                    'value' => function($model)
                                    {
                                        if(DefaultController::CountUploadedFile($model['record_tuc'],"GadRecord") != 0)
                                        {
                                            $urluploadfile = '@web/report/gad-plan-budget/upload-form-endorsement-file?ruc='.$model["record_tuc"]."&onstep=to_create_gpb&tocreate=gad_plan_budget";
                                            return Html::button('<span class="glyphicon glyphicon-file"> </span> ('.DefaultController::CountUploadedFile($model['record_tuc'],"GadRecord").")", ['value'=>Url::to($urluploadfile),
                            'class' => 'btn btn-primary btn-sm modalButton ','title' => 'Attached file(s) by the reviewer',]);
                                        }
                                        else
                                        {
                                            return "<i>No file(s) uploaded</i>";
                                        }
                                    }
                                ],

                                ['class' => 'yii\grid\ActionColumn',
                                    'template' => '{view} {track} {archive}',
                                    'buttons' => [
                                        'view' => function($url, $model) use ($urlReport,$report_type){
                                            if(in_array($model['record_status'],DefaultController::HasStatus("view_report_for_province")))
                                            {
                                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span> View', [$urlReport,
                                                    'ruc' => $model['record_tuc'], 
                                                    'onstep' => $report_type == "accomplishment" ? 'to_create_ar' : 'to_create_gpb',
                                                    'tocreate'=> $report_type == "accomplishment" ? 'accomp_report' : 'gad_plan_budget',
                                                ], 
                                                    ['class'=>'btn btn-info btn-xs btn-block']);
                                            }
                                            else
                                            {
                                                return false;
                                            }
                                        },
                                        'track' => function($url, $model) use ($urlReport,$report_type){
                                            $url_track = '@web/report/gad-record/track?ruc='.$model['record_tuc'];
                                            return Html::button('<span class="glyphicon glyphicon-time"></span> Track', ['value'=>Url::to($url_track), 'class' => 'btn btn-default btn-xs btn-block modalButton ','style' => '']);
                                        },
                                        'archive' => function($url,$model) use ($urlReport,$report_type){
                                            if(in_array($model['record_status'],DefaultController::HasStatus("archive_report_for_province")))
                                            {
                                                return Html::a('<i class="fa fa-archive"></i> &nbsp;Archive ', 
                                                [
                                                '/report/gad-record/archive','report_type' => $report_type,'record_id' => $model['record_id']
                                                ], 
                                                [
                                                'class' => 'btn btn-xs btn-warning pull-right',
                                                'data' => [
                                                    'confirm' => 'Are you sure you want to perform this action?',
                                                    'method' => 'post'
                                                    ]
                                                ]);
                                            }
                                        },
                                    ],
                                ],
                            ],
                        ]);
                    }
                    else if(Yii::$app->user->can("SuperAdministrator") || Yii::$app->user->can("RegionalAdministrator") || Yii::$app->user->can("Administrator") || Yii::$app->user->can("gad_admin") || Yii::$app->user->can("gad_central"))
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
                                [
                                    'label' => $report_type == "plan_budget" ? 'Status' : false,
                                    'attribute' => 'record_status',
                                    'format' => 'raw',
                                    'value' => function($model) use ($report_type)
                                    {

                                        return $report_type == "plan_budget" ? DefaultController::DisplayStatus($model["record_status"]) : false;
                                    }
                                ],
                                [
                                    'label' => 'Date',
                                    'value' => function($model)
                                    {
                                        
                                        return !empty(GadRecordController::GenerateLatestDate($model['record_tuc'])) ? GadRecordController::GenerateLatestDate($model['record_tuc']) : date("F j, Y", strtotime(date($model['date_created'])));
                                    }
                                ],
                                [
                                    'label' => 'Remarks',
                                    'contentOptions' => ['class' => 'remarks_class'],
                                    'value' => function($model)
                                    {
                                        return GadRecordController::GenerateRemarks($model["record_tuc"]);
                                    }
                                ],
                                [
                                    'label' => 'Attached file(s) from the Reviewer',
                                    'format' => 'raw',
                                    'value' => function($model)
                                    {
                                        if(DefaultController::CountUploadedFile($model['record_tuc'],"GadRecord") != 0)
                                        {
                                            $urluploadfile = '@web/report/gad-plan-budget/upload-form-endorsement-file?ruc='.$model["record_tuc"]."&onstep=to_create_gpb&tocreate=gad_plan_budget";
                                            return Html::button('<span class="glyphicon glyphicon-file"> </span> ('.DefaultController::CountUploadedFile($model['record_tuc'],"GadRecord").")", ['value'=>Url::to($urluploadfile),
                            'class' => 'btn btn-primary btn-sm modalButton ','title' => 'Attached file(s) by the reviewer',]);
                                        }
                                        else
                                        {
                                            return "<i>No file(s) uploaded</i>";
                                        }
                                    }
                                ],

                                ['class' => 'yii\grid\ActionColumn',
                                    'template' => '{view} {track} {archive}',
                                    'buttons' => [
                                        'view' => function($url, $model) use ($urlReport,$report_type){
                                            if(in_array($model['record_status'],DefaultController::HasStatus("gad_all_status")))
                                            {
                                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span> View', [$urlReport,
                                                    'ruc' => $model['record_tuc'], 
                                                    'onstep' => $report_type == "accomplishment" ? 'to_create_ar' : 'to_create_gpb',
                                                    'tocreate'=> $report_type == "accomplishment" ? 'accomp_report' : 'gad_plan_budget',
                                                ], 
                                                    ['class'=>'btn btn-info btn-xs btn-block']);
                                            }
                                            else
                                            {
                                                return false;
                                            }
                                        },
                                        'track' => function($url, $model) use ($urlReport,$report_type){
                                            $url_track = '@web/report/gad-record/track?ruc='.$model['record_tuc'];
                                            return Html::button('<span class="glyphicon glyphicon-time"></span> Track', ['value'=>Url::to($url_track), 'class' => 'btn btn-default btn-xs btn-block modalButton ','style' => '']);
                                        },
                                        'archive' => function($url,$model) use ($urlReport,$report_type){
                                            return Html::a('<i class="fa fa-archive"></i> &nbsp;Archive ', 
                                            [
                                            '/report/gad-record/archive','report_type' => $report_type,'record_id' => $model['record_id']
                                            ], 
                                            [
                                            'class' => 'btn btn-xs btn-warning pull-right',
                                            'data' => [
                                                'confirm' => 'Are you sure you want to perform this action?',
                                                'method' => 'post'
                                                ]
                                            ]);
                                        },
                                    ],
                                ],
                            ],
                        ]);
                    }
                    else
                    {
                        echo "No Role";
                    }
                ?>
                <?php
                    $this->registerJs("
                        $('table.table').addClass('table-hover');
                        $('.table-responsive').addClass('zui-wrapper');
                        $('.grid-view').addClass('zui-scroller dragscroll');
                        $('table.table').addClass('zui-table');
                    ");
                ?>
            </div>
        </div>
    </div>
</div>
