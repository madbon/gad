<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\report\models\GadRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $index_title;
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .table > caption + thead > tr:first-child > th, .table > colgroup + thead > tr:first-child > th, .table > thead:first-child > tr:first-child > th, .table > caption + thead > tr:first-child > td, .table > colgroup + thead > tr:first-child > td, .table > thead:first-child > tr:first-child > td
    {
        border-top: none;
    }
    table.table thead tr th
    {
        background-color: #29012cc4;
        /*color:#dac4c4;*/
        color:white;
        /*border:1px solid #dac4c4;*/
        /*text-align: center;*/
        font-weight: normal;
    }
    table.table
    {
        box-shadow: 0.5px 0.5px 0.5px 0.5px rgba(150,150,150,0.5);
    }
    table.table tbody tr td
    {
        border:none;
    }
    table.table thead tr th
    {
        border:none;
    }
</style>
<div class="gad-record-index">

    <!-- <h1><?php // Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!-- <p>
        <?php // Html::a('Create Annex A', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

<div class="cust-panel">
    <div class="cust-panel-header gad-color">
        </div>
        <div class="cust-panel-body">
            <!-- <div class="cust-panel-title">
                <p>
                    <?= Html::encode($this->title) ?>
                </p>
            </div> -->
            <br/>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                // 'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    // 'id',
                    // 'responsbile',
                    [
                        'label' => 'Created by',
                        'attribute' => 'responsbile',
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
                        'attribute' => 'record_total_gad_budget',
                        'value' => function($model)
                        {   
                            return !empty($model["record_total_gad_budget"]) ? "Php ".number_format($model["record_total_gad_budget"],2) : "";
                        }
                    ],
                    [
                        'label' => 'Year',
                        'attribute' => 'record_year',
                    ],
                    [
                        'label' => 'Status',
                        'attribute' => 'record_status',
                    ],

                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{view}',
                        'buttons' => [
                            'view' => function($url, $model) use ($urlReport){
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span> View Report', [$urlReport,
                                        'ruc' => $model['record_tuc'], 'onstep' => 'view_report','tocreate'=>'not'], ['class'=>'btn btn-primary btn-xs btn-block']);
                            },
                        ],
                    ],
                ],
            ]); ?>
            <?php
                $this->registerJs("
                    $('table.table').addClass('table-hover');
                ");
            ?>
        </div>
    </div>
</div>
