<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\cms\models\DocumentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Letters/Certificates Created';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php //echo Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Back to Plan', ['/report/gad-plan-budget/index/','ruc' => $ruc,'onstep' => $onstep, 'tocreate' => $tocreate], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'options' => ['table-responsive'],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'office_name',
            [
                'label' => 'Letter/Certificate',
                'value' => function($model)
                {
                    return $model['category_name'];
                }
            ],
            [
                'label' => 'OFFICE',
                'value' => function($model)
                {
                    return $model['office_name'];
                }
            ],
            [
                'label' => 'PROVINCE',
                'value' => function($model)
                {
                    return $model['province_name'];
                }
            ],
            [
                'label' => 'CITY/MUNICIPALITY',
                'value' => function($model)
                {
                    return !empty($model['citymun_name']) ? $model['citymun_name'] : "";
                }
            ],
            [
                'label' => 'REPORT',
                'value' => function($model)
                {
                    if($model["report_type"] == 1)
                    {
                        return "GPB";
                    }
                    else
                    {
                        return "Accomplishment";
                    }
                }
            ],
            [
                'label' => 'FY',
                'value' => function($model)
                {
                    return $model['record_year'];
                }
            ],
            // 'frequency',
            // 'frequency_id',
            // 'lgup_content_type_id',
            //'lgup_content_width_id',
            //'applicable_to',
            //'left_or_right',
            //'sort',
            // 'add_comment',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{create} {update}',
                'buttons' => [
                    'create' => function($url,$model) 
                    {
                        return Html::a('Add comments/recommendations', ['/cms/category-comment', 'ruc' => $model['ruc']],['class' => 'btn btn-success btn-sm']);
                    },
                    'update' => function($url,$model) 
                    {
                        return Html::a('Edit', ['edit-form-view','category_id' => $model['category_id'], 'ruc' => $model['ruc'], 'onstep' => 'to_create_gpb', 'tocreate' => 'gad_plan_budget'],['class' => 'btn btn-primary btn-sm']);
                    }
                ]
            ],
        ],
    ]); ?>
</div>
