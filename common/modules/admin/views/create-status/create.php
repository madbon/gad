<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CreateStatus */

$this->title = 'Input Create Plan Status';
$this->params['breadcrumbs'][] = ['label' => 'Create Plan Status', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="create-status-create">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
