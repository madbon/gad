<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\bis\models\Category */

$this->title = 'Update ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="category-update">
    <?= $this->render('_form', [
        'model' => $model,
        'content_type' => $content_type,
        'content_width' => $content_width,
        'frequency' =>  $frequency,
        'applicable_to' => $applicable_to,
        'left_right' => $left_right,
    ]) ?>

</div>
