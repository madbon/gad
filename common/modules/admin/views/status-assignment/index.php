<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\admin\models\GadStatusAssignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Status Assignments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-status-assignment-index">
    <p>
        <?= Html::a('Create Status Assignment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'role',
            // 'status',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
        ],
    ]); ?>
</div>
