<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadInnerCategory */

$this->title = 'Create GAD Inner Category';
$this->params['breadcrumbs'][] = ['label' => 'GAD Inner Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-inner-category-create">

    <!-- <h1><?php // Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
