<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\GadPlanBudget */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gad Plan Budgets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="gad-plan-budget-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'region_c',
            'province_c',
            'citymun_c',
            'issue_mandate:ntext',
            'objective:ntext',
            'relevant_lgu_program_project:ntext',
            'activity:ntext',
            'performance_indicator_target:ntext',
            'budget_mooe',
            'budget_ps',
            'budget_co',
            'lead_responsible_office_id',
            'date_created',
            'time_created',
            'date_updated',
            'time_updated',
            'sort',
            'tuc_parent',
        ],
    ]) ?>

</div>
