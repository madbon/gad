<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\bis\models\DefaultChoice */

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'Default Choices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="default-choice-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
