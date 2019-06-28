<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\admin\models\GadChecklistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Checklists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-checklist-index">

    <h1><?php // Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Checklist', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'report_type_id',
            [
                'attribute' => 'report_type_id',
                'value' => function($model)
                {
                    if($model->report_type_id == 1)
                    {
                        return "Plan and Budget";
                    }
                    else
                    {
                        return "Accomplishment";
                    }
                }
            ],
            'title',
            // 'is_hidden',
            [
                'attribute' => 'is_hidden',
                'value' => function($model)
                {
                    if($model->is_hidden == 0)
                    {
                        return "Yes";
                    }
                    else
                    {
                        return "No";
                    }
                }
            ],
            'sort',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
