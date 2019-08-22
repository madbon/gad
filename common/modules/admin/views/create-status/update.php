<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CreateStatus */

$this->title = 'Update Create Status: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Create Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="create-status-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
