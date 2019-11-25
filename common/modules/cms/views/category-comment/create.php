<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadCategoryComment */

$this->title = 'Create Gad Category Comment';
// $this->params['breadcrumbs'][] = ['label' => 'Gad Category Comments', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-category-comment-create">

    <h1><?php // Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
