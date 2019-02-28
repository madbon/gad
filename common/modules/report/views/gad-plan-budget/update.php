<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadPlanBudget */

$this->title = 'Update Gad Plan Budget: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gad Plan Budgets', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gad-plan-budget-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
