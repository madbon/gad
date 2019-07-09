<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\GadComment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gad Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="gad-comment-view">

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
            'resp_user_id',
            'resp_office_c',
            'record_id',
            'plan_budget_id',
            'resp_region_c',
            'resp_province_c',
            'resp_citymun_c',
            'comment:ntext',
            'row_no',
            'column_no',
            'row_value:ntext',
            'column_value:ntext',
            'model_name',
            'attribute_name',
            'date_created',
            'time_created',
            'date_updated',
            'time_updated',
        ],
    ]) ?>

</div>
