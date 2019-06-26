<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\bis\models\Choice */

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'Choices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="choice-create">
    <?= $this->render('_form', [
        'model' => $model,
        'indicator' => $indicator,
        'default_choices' => $default_choices,
    ]) ?>

</div>
