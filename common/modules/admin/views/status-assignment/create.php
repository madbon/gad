<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadStatusAssignment */

$this->title = 'Create Status Assignment';
$this->params['breadcrumbs'][] = ['label' => 'Status Assignments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-status-assignment-create">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tags_status' => $tags_status,
    ]) ?>

</div>
