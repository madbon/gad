<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadFocused */

$this->title = 'Create GAD Focused';
$this->params['breadcrumbs'][] = ['label' => 'GAD Focused', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-focused-create">

    <!-- <h1><?php // Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
