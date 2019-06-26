<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\rms\models\UploadedClient */

$this->title = 'Update Uploaded Client: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Registered Business', 'url' => ['/rms/dynamic-view/registered-business']];
$this->params['breadcrumbs'][] = ['label' => $model->business_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="uploaded-client-update">

    <?= $this->render('_form', [
        'model' => $model,
        'type' => $type,
    ]) ?>

</div>
