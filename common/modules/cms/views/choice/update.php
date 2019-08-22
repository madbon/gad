<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\bis\models\Choice */

$this->title = 'Update' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Choices', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->value, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="choice-update">

    <?= $this->render('_form', [
        'model' => $model,
        'indicator' => $indicator,
        'default_choices' => $default_choices,
    ]) ?>

</div>
