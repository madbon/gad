<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\cms\models\Type */

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="type-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
