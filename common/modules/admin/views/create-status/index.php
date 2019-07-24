<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\admin\models\CreateStatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Create Plan Status';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="create-status-index">

    <!-- <h1><?php // Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Input Create Plan Status', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'code',
            'title',
            [
                'attribute' => 'is_active',
                'label' => 'Is Active?',
                'value' => function($model)
                {
                    return $model->is_active == 0 ? "No" :  "Yes";
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
