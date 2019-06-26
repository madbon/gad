<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\bis\models\Category */

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <?= $this->render('_form', [
        'model' => $model,
        'content_type' => $content_type,
        'content_width' => $content_width,
        'frequency' => $frequency,
        'applicable_to' => $applicable_to,
        'left_right' => $left_right,
    ]) ?>

</div>
