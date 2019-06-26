<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\cms\models\Type */

$this->title = 'Update ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
