<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadScoreType */

$this->title = 'Create Score Type';
$this->params['breadcrumbs'][] = ['label' => 'Score Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-score-type-create">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
