<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadAccomplishmentReport */

$this->title = 'Create Gad Accomplishment Report';
// $this->params['breadcrumbs'][] = ['label' => 'Gad Accomplishment Reports', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-accomplishment-report-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
