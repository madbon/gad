<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadRecord */

$this->title = 'Create Annex A';
$this->params['breadcrumbs'][] = ['label' => 'Gad Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-record-create">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
