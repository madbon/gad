<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\cms\models\Status */

$this->title = 'Update Status: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="status-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
