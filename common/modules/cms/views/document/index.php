<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\cms\models\DocumentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Letter / Certificate of Review & Endorsement Templates';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h2><?= Html::encode($this->title) ?></h2>
            <p>
                <?php echo Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Back to Plan', ['/report/gad-plan-budget/index/','ruc' => $ruc,'onstep' => $onstep, 'tocreate' => $tocreate], ['class' => 'btn btn-success']) ?>
            </p>
        </div>
        <div class="panel-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    // 'id',
                    'title:ntext',
                    // 'frequency',
                    // 'frequency_id',
                    // 'lgup_content_type_id',
                    //'lgup_content_width_id',
                    //'applicable_to',
                    //'left_or_right',
                    //'sort',
                    // 'add_comment',

                    ['class' => 'yii\grid\ActionColumn',
                        'template' => '{create}',
                        'buttons' => [
                            'create' => function($url,$model) use ($ruc,$onstep,$tocreate)
                            {
                                return Html::a('Create', ['form-view','category_id' => $model->id,'ruc' => $ruc, 'onstep'=> $onstep,'tocreate' => $tocreate],['class' => 'btn btn-success']);
                            }
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
