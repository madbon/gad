<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadStatus */

$this->title = 'Update Gad Status: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Gad Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gad-status-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
