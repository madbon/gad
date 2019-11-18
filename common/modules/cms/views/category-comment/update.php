<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadCategoryComment */

// $this->title = 'Update Gad Category Comment: ' . $model->id;
// $this->params['breadcrumbs'][] = ['label' => 'Gad Category Comments', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->value, 'url' => ['view', 'id' => $model->id]];
// $this->params['breadcrumbs'][] = 'Update';
?>
<div class="gad-category-comment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
