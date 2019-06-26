<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\cms\models\CmsContentWidth */

$this->title = 'Update Content Width: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Content Widths', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->class_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cms-content-width-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
