<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\GadAccomplishmentReport */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gad Accomplishment Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="gad-accomplishment-report-view">

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
            'record_id',
            'focused_id',
            'inner_category_id',
            'ppa_focused_id',
            'ppa_value:ntext',
            'cause_gender_issue:ntext',
            'objective:ntext',
            'relevant_lgu_ppa:ntext',
            'activity:ntext',
            'performance_indicator:ntext',
            'target:ntext',
            'actual_results:ntext',
            'total_approved_gad_budget',
            'actual_cost_expenditure',
            'variance_remarks:ntext',
            'date_created',
            'time_created',
            'date_updated',
            'time_updated',
            'record_tuc',
            'this_tuc',
        ],
    ]) ?>

</div>
