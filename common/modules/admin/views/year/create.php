<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadYear */

$this->title = 'Create Gad Year';
$this->params['breadcrumbs'][] = ['label' => 'Gad Years', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-year-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
