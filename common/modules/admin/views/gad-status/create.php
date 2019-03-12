<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadStatus */

$this->title = 'Create GAD Status';
$this->params['breadcrumbs'][] = ['label' => 'Gad Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-status-create">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
