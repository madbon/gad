<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadScoreType */

$this->title = 'Update Score Type: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Score Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gad-score-type-update">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
