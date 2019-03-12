<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\report\models\GadRecordSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Created Annex A (GAD Plan and Budget)';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-record-index">

    <h1><?php // Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Annex A', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

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
            //'form_type',
            //'status',
            //'is_archive',
            //'date_created',
            //'time_created',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span> View Report', ['gad-plan-budget/index',
                                'ruc' => $model['record_tuc']], ['class'=>'btn btn-primary btn-xs btn-block']);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
