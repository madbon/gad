<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\rms\models\UploadedClient */

$this->title = 'Add Registered Business';
$this->params['breadcrumbs'][] = ['label' => 'Registered Business', 'url' => ['/rms/dynamic-view/registered-business']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="uploaded-client-create">

    <?= $this->render('_form', [
        'model' => $model,
        'type' => $type,
    ]) ?>

</div>
