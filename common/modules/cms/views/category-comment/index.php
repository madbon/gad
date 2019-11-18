<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use common\modules\report\controllers\DefaultController as Tools;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\cms\models\GadCategoryCommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->title = 'Comments/Recommendations';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-category-comment-index">

<?php
    $category_title = null;
    foreach ($queryValues as $key => $row) {
        if($category_title != $row['category_title'])
        {
            $category_title = $row['category_title'];
        }
        $category_title = $row['category_title'];
    }
?>
<h4 style="font-weight: bold; color:rgb(60,141,188); font-size: 20px;"><?= $category_title ?> : GPB <?= Tools::GetPlanYear($ruc) ?></h4>
<hr/>
    <div class="row" style="margin-top: -20px;">
        <div class="col-sm-6">
            <h3><span class="fa fa-list"></span> Primary Details</h3>
            <hr/>
            <h4 style="margin-top: 10px; margin-bottom: 10px;">
               
                <b><?= !empty(Tools::GetCitymunName($ruc)) ? Tools::GetCitymunName($ruc).", " : "" ?> 
                <?= Tools::GetProvinceName($ruc) ?> </b>
            </h4>
            
            
            <table class="table table-responsive table-hover table-bordered" style="border:3px solid black; background-color: white;">
                <thead>
                    <tr>
                        <th style="text-align: center; background-color: rgb(60,141,188); color:white;">TEXT FIELDS</th>
                        <th style=" background-color: rgb(60,141,188); color:white;">INPUTTED VALUES 
                            <?= Html::a('<span class="fa fa-edit"> </span> Edit',
                            [
                                'document/edit-form-view',
                                'category_id' => $category_id, 
                                'ruc' => $ruc, 
                                'onstep' => 'to_create_gpb', 
                                'tocreate' => 'gad_plan_budget'
                            ],
                            [
                                'class' => 'btn btn-sm btn-default pull-right',
                                'title' => 'Edit Primary Details',
                                'style' => 'margin-top : 0px; border-radius:15px;', 
                            ])  ?>    
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($queryValues as $key => $row) {
                            echo "<tr>";
                            echo    "<td>".$row["indicator_title"]."</td>";
                            echo    "<td style='font-weight:bold;'> : ".$row["value"]."</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>

            <br/>
            <h3><span class="fa fa-download"></span> Download Section</h3>
            <hr/>
            <?= Html::a('<span class="fa fa-download"> </span> '.($category_title).".docx",
            [
                '/cms/document/download-word',
                'category_id' => $category_id, 
                'ruc' => $ruc
            ],
            [
                // 'class' => 'btn btn-sm btn-primary',
                'title' => 'Download',
                'style' => 'font-size:15px;',
            ])  ?>
        </div>
        <div class="col-sm-6">
            <h3><span class="fa fa-comment"></span> Comment Section</h3>
            <hr/>
            <?php 
                echo $this->render('create', ['model' => $model]);
            ?>

            <div style="overflow-y: scroll; max-height: 300px;">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'options' => ['table-responsive'],
                    // 'filterModel' => $searchModel,
                    'columns' => [
                        // ['class' => 'yii\grid\SerialColumn'],

                        // 'id',
                        // 'category_id',
                        // 'record_id',
                        // 'value:ntext',
                        [
                            'label' => 'Comment(s) / Recommendation(s)',
                            'value' => function($model)
                            {
                                return $model->value;
                            }
                        ],

                        ['class' => 'yii\grid\ActionColumn',
                            'template' => '{update} {delete}',
                            'buttons' => [
                                'update' => function($url,$model) use ($ruc)
                                {
                                    return Html::a('<span class="glyphicon glyphicon-edit"></span>', ['update', 'id' => $model->id,'ruc' => $ruc],['class' => '', 'title' => 'Edit']);
                                },
                                'delete' => function($url,$model) use ($ruc)
                                {
                                    return Html::a('<span class="glyphicon glyphicon-trash" style="color:red;"></span>', ['delete', 'id' => $model->id, 'ruc' => $ruc],['title' => 'Delete','class' => '', 'data' => ['confirm' => 'Are you sure you want to delete this item?','method' => 'post']]);
                                }
                            ]
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>

         
