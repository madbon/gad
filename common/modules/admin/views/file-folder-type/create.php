<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadFileFolderType */

$this->title = 'Create File Type';
$this->params['breadcrumbs'][] = ['label' => 'File Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-file-folder-type-create">

    <!-- <h1><?php // Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
