<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadReportHistory */

$this->title = 'Create Gad Report History';
$this->params['breadcrumbs'][] = ['label' => 'Gad Report Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-report-history-create">

    <!-- <h1><?php // Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
        'status' => $status
    ]) ?>

</div>
