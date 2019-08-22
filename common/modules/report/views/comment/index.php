<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\report\models\GadCommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gad Comments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-comment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Gad Comment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'resp_user_id',
            'resp_office_c',
            'record_id',
            'plan_budget_id',
            //'resp_region_c',
            //'resp_province_c',
            //'resp_citymun_c',
            //'comment:ntext',
            //'row_no',
            //'column_no',
            //'row_value:ntext',
            //'column_value:ntext',
            //'model_name',
            //'attribute_name',
            //'date_created',
            //'time_created',
            //'date_updated',
            //'time_updated',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
