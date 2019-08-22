<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadActivityCategory */

$this->title = 'Update Activity Category: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Activity Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gad-activity-category-update">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
