<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\cms\models\GadCategoryCommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comments/Recommendations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-category-comment-index">

    <h1><?= Html::encode($this->title)." For GPB FY. ".\common\modules\report\controllers\DefaultController::GetPlanYear($ruc) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   <!-- <p>
        <?php // echo  Html::a('Create Gad Category Comment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>  -->
    <div class="row">
        <div class="col-sm-6">
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
            <h4>Region : <?= \common\modules\report\controllers\DefaultController::GetRegionName($ruc) ?></h4>
            <h4>Province : <?= \common\modules\report\controllers\DefaultController::GetProvinceName($ruc) ?></h4>
            <h4>City/Municipality : <?= \common\modules\report\controllers\DefaultController::GetCitymunName($ruc) ?></h4>
            <h3>
                <span class="fa fa-file"></span> <?= $category_title ?>
                <?= Html::a('<span class="fa fa-edit" style="font-size:25px;"> edit</span>',
                [
                    'document/edit-form-view',
                    'category_id' => $category_id, 
                    'ruc' => $ruc, 
                    'onstep' => 'to_create_gpb', 
                    'tocreate' => 'gad_plan_budget'
                ],
                [
                    'class' => 'btn btn-sm btn-primary',
                    'title' => 'Edit Letter'
                ])  ?>
                <?= Html::a('<span class="fa fa-download" style="font-size:25px;"> .docx</span>',
                [
                    '/cms/document/download-word',
                    'category_id' => $category_id, 
                    'ruc' => $ruc
                ],
                [
                    'class' => 'btn btn-sm btn-primary',
                    'title' => 'Download Letter/Certificate'
                ])  ?>
            </h3>
            <table class="table table-responsive table-striped table-hover" style="border:3px solid black; background-color: white;">
                <thead>
                    <tr>
                        <th>INDICATOR</th>
                        <th>VALUE</th>
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
        </div>
    </div>

 

    <?php 
        echo $this->render('create', ['model' => $model]);
    ?>

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
                'label' => 'Comments/Recommendations',
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
                        return Html::a('Edit', ['update', 'id' => $model->id,'ruc' => $ruc],['class' => 'btn btn-primary btn-sm']);
                    },
                    'delete' => function($url,$model) use ($ruc)
                    {
                        return Html::a('Delete', ['delete', 'id' => $model->id, 'ruc' => $ruc],['class' => 'btn btn-danger btn-sm', 'data' => ['confirm' => 'Are you sure?','method' => 'post']]);
                    }
                ]
            ],
        ],
    ]); ?>
</div>
