<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadRecord */

$this->title = 'Update Gad Record: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gad Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gad-record-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
