<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\bis\models\Category */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-view">
<h1></h1><br>    
    <div class="box box-primary">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <div class="box-header" style="margin-bottom: -20px;">
              <!-- <h3 class="box-title">Title: <strong><?php // Html::encode($this->title) ?></strong></h3> -->
            <div class="form-group pull-right">
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
        <?= DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table table-condensed table-bordered table-responsive table-hover'],
            'attributes' => [
                'id',
                'title:ntext',
                // 'frequencyRelation.title',
            ],
        ]) ?>
    </div>
</div>
