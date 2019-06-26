<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\cms\models\CmsContentWidth */

$this->title = $model->class_name;
$this->params['breadcrumbs'][] = ['label' => 'Content Widths', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-content-width-view">
    <h1></h1><br>    
    <div class="box box-primary">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <div class="box-header" style="margin-bottom: -20px;">
              <h3 class="box-title">Class Name: <strong><?= Html::encode($this->title) ?></strong></h3>
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
            'attributes' => [
                'id',
                'class_name',
                'description',
            ],
        ]) ?>
    </div>
</div>
