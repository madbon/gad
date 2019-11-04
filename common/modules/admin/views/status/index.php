<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\admin\models\GadStatusSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'List of Status';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-status-index">

    <p>
        <?= Html::a('Create Status', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'code',
            'title',
            'future_tense',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
