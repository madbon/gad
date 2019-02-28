<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\GadPlanBudgetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gad Plan Budgets';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-plan-budget-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Gad Plan Budget', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => ['class' => 'table table-responsive'],
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'user_id',
            // 'region_c',
            // 'province_c',
            // 'citymun_c',
            'issue_mandate:ntext',
            'objective:ntext',
            'relevant_lgu_program_project:ntext',
            'activity:ntext',
            'performance_indicator_target:ntext',
            'budget_mooe',
            'budget_ps',
            'budget_co',
            'lead_responsible_office_id',
            //'date_created',
            //'time_created',
            //'date_updated',
            //'time_updated',
            //'sort',
            //'tuc_parent',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
