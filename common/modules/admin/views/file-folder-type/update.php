<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadFileFolderType */

$this->title = 'Update File Type: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'File Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gad-file-folder-type-update">

    <!-- <h1><?php // Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
