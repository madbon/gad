<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\bis\models\DefaultChoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Default Choices';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="default-choice-index">
    <div class="box box-primary">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <div class="box-header" style="margin-bottom: -20px;">
              <h3 class="box-title"><strong><?= Html::encode($this->title) ?></strong></h3>
            <div class="form-group pull-right">
                <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' =>['class' => 'table table-responsive table-hover'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'title',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete} ',   
                    'buttons'=>[    
                        'view'=>function ($url, $model) {
                            
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span> View ', ['view', 'id'=>$model->id], ['class' => 'btn btn-primary btn-xs']);
                        },
                        'update'=>function ($url, $model) {
                            return Html::a('<span class="fa fa-edit"></span> Update', ['update', 'id'=>$model->id], ['class' => 'btn btn-primary  btn-xs']);
                            
                        },
                        'delete'=>function ($url, $model) {
                            return Html::a('<i class="glyphicon glyphicon-trash"></i> Delete', 
                                [
                                  'default-choice/delete', 'id' => $model->id
                                ], 
                                [
                                  'class' => 'btn btn-danger btn-xs',
                                  'data' => [
                                      'confirm' => 'Are you sure you want to delete this?',
                                      'method' => 'post']
                                ]);
                        },
                        
                    ],
                ],
            ],'layout' => "{items}\n<div class='text-info text-right'>{summary}</div>\n{pager}",
        ]); ?>
    </div>
</div>
