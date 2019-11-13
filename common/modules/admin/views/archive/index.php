<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\grid\GridView;
use common\modules\report\controllers\GadPlanBudgetController;
use common\modules\report\controllers\GadAccomplishmentReportController;
use common\modules\report\controllers\DefaultController;
use common\modules\report\controllers\GadRecordController;
use yii\helpers\Url;
?>
<style>
 table thead tr th
{
	text-align: center;
} 
table tbody tr td
{
	background:#80808057 !important;
}
table thead tr th
{
	background:gray;
	color:white;
	font-weight: normal;
}
</style>
<h3 class="style" style="margin-top: 0px; padding-top: 10px;"><span class="fa fa-folder"></span> Archived Report(s)</h3>

	<?php
        echo $this->render('_search', ['model' => $model, 'region' => $region,'province' => $province,'citymun' => $citymun,'statusList' => $statusList,'arrayYear' => $arrayYear]);
    ?>
<div class="table-responsive">
	
	<?php
    	echo GridView::widget([
			'dataProvider' => $dataProvider,
			'options' => [
					'style'=>'word-wrap: break-word;'
			],
            'columns' => [
            	['class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {restore} {details}',
                    'buttons' => [
                    	'view' => function($url, $model){
                    		
                    		if($model["report_type_id"] == 1)
                    		{
                    			$urlReport = "/report/gad-plan-budget/index";
                    		}
                    		else
                    		{
                    			$urlReport = "/report/gad-accomplishment-report/index";
                    		}

                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span> View', [$urlReport,
                                'ruc' => $model['record_tuc'], 
                                'onstep' => $model["report_type_id"] == 2 ? 'to_create_ar' : 'to_create_gpb',
                                'tocreate'=> $model["report_type_id"] == 2 ? 'accomp_report' : 'gad_plan_budget',
                            ], 
                                ['class'=>'btn btn-info btn-xs btn-block']);
                        },
                        'details' => function($url, $model){
                            $url_track = '@web/admin/archive/archive-details?ruc='.$model['record_tuc'];
                            return Html::button('&nbsp;<span class="fa fa-list"></span> Details&nbsp;', ['value'=>Url::to($url_track), 'class' => 'btn btn-default btn-xs btn-block modalButton ','style' => 'margin-top:5px;',]);
                        },
                        'restore' => function($url,$model){
                            return Html::a('<i class="fa fa-share"></i> &nbsp;Restore ', 
                            [	
                            'restore','report_type' => $model["report_type_id"],'record_id' => $model['record_id']
                            ], 
                            [
                            'class' => 'btn btn-xs btn-success pull-right',
                            'style' => 'margin-top:5px; margin-bottom:5px',
                            'data' => [
                                'confirm' => 'Are you sure you want to perform this action?',
                                'method' => 'post'
                                ]
                            ]);
                        },
                    ],
                ],
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
                    'label' => 'City / Municipality',
                    'attribute' => 'citymun_name',
                    'value' => function($model)
                    {
                        return !empty($model["citymun_name"]) ? $model["citymun_name"] : "";
                    }
                ],
                [
                    'label' => "Report",
                    'format' => 'raw',
                    'value' => function($model)
                    {
                        if($model["report_type_id"] == 2)
                        {
                            return "Accomplishment Report";
                        }
                        else
                        {
                            return "Plan and Budget";
                        }
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
                    'label' => "Total GAD Budget / Expenditure",
                    'format' => 'raw',
                    'value' => function($model)
                    {
                        if($model["report_type_id"] == 2)
                        {
                            return "Total GAD Expenditure : ".GadAccomplishmentReportController::ComputeAccomplishment($model['record_tuc']);
                        }
                        else
                        {
                            return "Total GAD Budget : ".GadPlanBudgetController::ComputeGadBudget($model['record_tuc']);
                        }
                    }
                ],
                [
                    'label' => "GAD Plan Status",
                    'attribute' => 'record_status',
                    'format' => 'raw',
                    'value' => function($model)
                    {

                        return DefaultController::DisplayStatus($model["record_status"]);
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
            ],
        ]);    
    ?>
       


