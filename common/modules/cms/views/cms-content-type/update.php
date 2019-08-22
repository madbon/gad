<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\cms\models\CmsContentType */

$this->title = 'Update ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Content Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->type, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cms-content-type-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
