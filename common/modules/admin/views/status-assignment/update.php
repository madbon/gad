<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadStatusAssignment */

$this->title = 'Update Status Assignment: ' . $model->role;
$this->params['breadcrumbs'][] = ['label' => 'Status Assignments', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->role, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gad-status-assignment-update">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tags_status' => $tags_status,
        'auth_item' => $auth_item
    ]) ?>

</div>
