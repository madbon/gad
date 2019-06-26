<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\bis\models\IndicatorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Indicators';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="indicator-index">
        <div class="box box-primary">
            <div class="box-header" >
              <h3 class="box-title"><strong><?= Html::encode($this->title) ?></strong></h3>
                <div class="form-group">
                    <?= Html::a('<span class="glyphicon glyphicon-pencil"> </span> &nbsp;Create', ['create'], ['class' => 'btn btn-flat btn-success']) ?>
                </div>
            </div><!-- /.box-header -->
            
            <?php echo $this->render('_search', ['model' => $searchModel,'default' => $default,'category' => $category,'unit' => $unit, 'type' => $type,'indicator'=>$indicator]); ?>
            
            <div class="box-body">        
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'tableOptions' =>['class' => 'table table-responsive table-hover'],
                    'options' => ['width:100%;'],
                    //'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'categoryTitle',
                        'indicatorTitle',
                        [
                            'label' => Yii::$app->user->can("bpls_super_admin") ? 'Indicator ID' : "",
                            'attribute' => 'id',
                            'value' => function($model){
                                return Yii::$app->user->can("bpls_super_admin") ? !empty($model->id) ? $model->id : "" : "";
                            }
                        ],
                        [
                            'label' => 'Type',
                            'attribute' => 'type_id',
                            'value' => function($model){
                                return !empty($model->type->title) ? $model->type->title : "";
                            }
                        ],
                        [
                            'label' => 'Unit',
                            'attribute' => 'unit_id',
                            'value' => function($model){
                                return !empty($model->unit->title) ? $model->unit->title : "";
                            }
                        ],
                        [
                            'label' => 'Sort',
                            'attribute' => 'sort',
                        ],
                        [
                            'label' => 'Is Required',
                            'attribute' => 'is_required',
                            'value' => function($model){
                                return $model->is_required == 1 ? 'No' : 'Yes';
                            }
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',                            
                            'template' => Yii::$app->user->can("bpls_super_admin") ? '{view} {update} {delete}' : '{view} {update}',   
                                'buttons'=>[    
                                    'view'=>function ($url, $model) {
                                        
                                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span> &nbsp;View ', ['view', 'id'=>$model->id], ['class' => 'btn btn-info btn-xs btn-block']);
                                    },
                                    'update'=>function ($url, $model) {
                                        return Html::a('<span class="glyphicon glyphicon-edit"></span> &nbsp;Edit', ['update', 'id'=>$model->id], ['class' => 'btn btn-primary  btn-xs btn-block']);
                                        
                                    },
                                    'delete'=>function ($url, $model) {
                                        return Html::a('<i class="glyphicon glyphicon-trash"></i> &nbsp;Delete', 
                                            [
                                              'indicator/delete', 'id' => $model->id
                                            ], 
                                            [
                                              'class' => 'btn btn-danger btn-xs btn-block',
                                              'data' => [
                                                  'confirm' => 'Are you sure you want to delete this?',
                                                  'method' => 'post']
                                            ]);
                                    },
                                    
                                ],
                        ],
                    ],
                    'layout' => "{items}\n<div class='text-info text-right'>{summary}</div>\n{pager}",
                ]); ?>
            </div>
        </div>
</div>
