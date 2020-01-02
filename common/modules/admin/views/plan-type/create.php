<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadPlanType */

$this->title = 'Create Plan Type';
$this->params['breadcrumbs'][] = ['label' => 'Plan Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-plan-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
