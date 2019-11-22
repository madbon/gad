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
                        'label' => 'Documents Title',
                        'value' => function($model)
                        {
                            return $model['category_name'];
                        }
                    ],
                    [
                        'label' => 'Office',
                        'value' => function($model)
                        {
                            return $model['office_name'];
                        }
                    ],
                    [
                        'label' => 'Province/District',
                        'value' => function($model)
                        {
                            return $model['province_name'];
                        }
                    ],
                    [
                        'label' => 'City/Municipality',
                        'value' => function($model)
                        {
                            return !empty($model['citymun_name']) ? $model['citymun_name'] : "";
                        }
                    ],
                    [
                        'label' => 'Report',
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
                        'template' => '{create} {update} {download} {delete}',
                        'buttons' => [
                            'create' => function($url,$model) 
                            {
                                if($model['category_id'] == 7)
                                {
                                    return Html::a('<span class="fa fa-pencil"></span> Edit Comment', ['/cms/category-comment', 'ruc' => $model['ruc']],['class' => 'btn btn-success btn-sm btn-block']);
                                }
                            },
                            'update' => function($url,$model) 
                            {
                                return Html::a('<span class="fa fa-edit"></span> Edit Primary Details', ['edit-form-view','category_id' => $model['category_id'], 'ruc' => $model['ruc'], 'onstep' => 'to_create_gpb', 'tocreate' => 'gad_plan_budget'],['class' => 'btn btn-default btn-sm btn-block']);
                            },
                            'delete'=>function ($url, $model) {
                                return Html::a('<i class="glyphicon glyphicon-trash"></i> Delete', 
                                [
                                  '/cms/document/delete-values', 'ruc' => $model['ruc']
                                ], 
                                [
                                  'class' => 'btn btn-sm btn-danger btn-block',
                                  'data' => [
                                      'confirm' => 'Are you sure you want to delete this item?',
                                      'method' => 'post']
                                ]);
                            },
                            'download' => function($url,$model)
                            {
                                return Html::a('<span class="fa fa-download"> </span> Download (.docx)',
                                [
                                    '/cms/document/download-word',
                                    'category_id' => $model['category_id'], 
                                    'ruc' => $model['ruc'],
                                ],
                                [
                                    'class' => 'btn btn-sm btn-primary btn-block',
                                    'title' => 'Download',
                                ]);
                            },
                        ],
                    ],
                ],
            ]); ?>
</div>
