<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\cms\models\Status */

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'Statuses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="status-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
