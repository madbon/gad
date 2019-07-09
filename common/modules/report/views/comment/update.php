<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadComment */

$this->title = 'Update Gad Comment: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gad Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gad-comment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
