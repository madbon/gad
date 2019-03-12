<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadPpaAttributedProgram */

$this->title = 'Update Gad Ppa Attributed Program: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Gad Ppa Attributed Programs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gad-ppa-attributed-program-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
