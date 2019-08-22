<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\bis\models\FrequencyDetails */

$this->title = 'Update ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Frequency Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="frequency-details-update">

    <h3 class="page-header"><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
