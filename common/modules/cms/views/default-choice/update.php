<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\bis\models\DefaultChoice */

$this->title = 'Update ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Default Choices', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="default-choice-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
