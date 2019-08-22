<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\bis\models\FrequencyDetails */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Frequency Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="frequency-details-view">

    <h3 class="page-header"><?= Html::encode($this->title) ?></h3>

    <?= DetailView::widget([
        'model' => $model,
        'options' =>['class' => 'table table-condensed table-bordered table-hover table-responsive'],
        'attributes' => [
            'id',
            'frequency_id',
            'details',
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

</div>
