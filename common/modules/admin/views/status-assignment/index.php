<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\modules\report\controllers\DefaultController;

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
        'options' => ['class' => 'table-responsive'],
        'columns' => [
            // ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'role',
            'rbac_role',
            // 'status_code',
            [
                'attribute' => 'status_code',
                'format' => 'raw',
                'value' => function($model)
                {
                    return DefaultController::DisplayStatusWithCode($model->status_code);
                }
            ],
            'description',
            // 'status',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}'],
        ],
    ]); ?>
</div>
