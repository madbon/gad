<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadPpaAttributedProgram */

$this->title = 'Update PPA Sector: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'PPA Sector', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gad-ppa-attributed-program-update">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
