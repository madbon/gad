<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadFileFolderType */

$this->title = 'Create Gad File Folder Type';
$this->params['breadcrumbs'][] = ['label' => 'Gad File Folder Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-file-folder-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
