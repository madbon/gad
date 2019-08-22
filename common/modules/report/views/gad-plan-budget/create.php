<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadPlanBudget */

$this->title = 'Create Gad Plan Budget (Annex A)';
$this->params['breadcrumbs'][] = ['label' => 'Gad Plan Budgets', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="gad-plan-budget-create">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'region' => $region,
    ]) ?>

</div>
