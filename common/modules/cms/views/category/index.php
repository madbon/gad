<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel common\modules\bis\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Categories';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index"> 
    <div class="box box-primary">
        <div class="box-header">
              <h3 class="box-title"><strong><?= Html::encode($this->title) ?></strong></h3>
            <div class="form-group">
                <?= Html::a('<span class="glyphicon glyphicon-pencil"> </span> &nbsp;Create', ['create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>

         <?php echo $this->render('_search', ['model' => $searchModel,'category' => $category,]); ?>
        
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            // 'filterModel' => $searchModel,
            'tableOptions' =>['class' => 'table table-responsive table-hover'],
            'options' => ['width:100%;'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'title:ntext',
                 
                // [
                //     'attribute' => 'applicable_to',
                //     'value' => function($model){

                //         $form_type = !empty($model->applicable_to) ? $model->applicable_to : "";

                //         if($form_type == 0)
                //         {
                //             return "Field Officer Monitoring Form";
                //         }
                //         else
                //         {
                //             return "Public Survey Form";
                //         }
                        
                //     }
                // ], 
                // [
                //     'attribute' => 'frequency_id',
                //     'value' => function($model){
                //         return !empty($model->frequencyRelation->title) ? $model->frequencyRelation->title : "";
                //     }
                // ],
                // 'sort',              
               
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => Yii::$app->user->can("bpls_super_admin") ? '{view} {update} {delete}' : '{view} {update}',   
                    'buttons'=>[    
                        'view'=>function ($url, $model) {
                            
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span> &nbsp;View ', ['view', 'id'=>$model->id], ['class' => 'btn btn-info btn-xs btn-block', 'style' => 'background-color:']);
                        },
                        'update'=>function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-edit"></span> &nbsp;Edit', ['update', 'id'=>$model->id], ['class' => 'btn btn-primary  btn-xs btn-block']);
                            
                        },
                        'updatesort'=>function ($url, $model) {
                            // $t = '@web/cms/category/update-sort?id='.$model->id;
                            // return Html::button(' <span class="glyphicon glyphicon-sort"></span> Edit Sorting', ['value'=>Url::to($t), 'class' => 'btn btn-primary btn-xs modalButton']);
                            return Html::a('<span class="glyphicon glyphicon-sort"></span> Edit Sorting ', ['update-sort', 'id'=>$model->id], ['class' => 'btn btn-primary btn-xs btn-block']);
                            
                        },
                        'delete'=>function ($url, $model) {
                            return Html::a('<i class="glyphicon glyphicon-trash"></i> &nbsp;Delete', 
                                [
                                  'category/delete', 'id' => $model->id
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
            ],'layout' => "{items}\n<div class='text-info text-right'>{summary}</div>\n{pager}",
    ]); ?>
    </div>
</div>
