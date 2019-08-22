<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\bis\models\Category */

$this->title = 'Update Sorting of : ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="category-update">

    <h3 class="page-header"><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form_update_sort', [
        'model' => $model,
    ]) ?>

</div>
