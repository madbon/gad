<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\GadChecklist */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Checklists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="gad-checklist-view">

    <h1><?php // Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?>
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
            // 'id',
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
        ],
    ]) ?>

</div>
