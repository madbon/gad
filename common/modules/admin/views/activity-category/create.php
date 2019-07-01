<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadActivityCategory */

$this->title = 'Create Activity Category';
$this->params['breadcrumbs'][] = ['label' => 'Activity Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-activity-category-create">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
