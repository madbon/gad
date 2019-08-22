<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadChecklist */

$this->title = 'Create Checklist';
$this->params['breadcrumbs'][] = ['label' => 'Checklists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-checklist-create">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
