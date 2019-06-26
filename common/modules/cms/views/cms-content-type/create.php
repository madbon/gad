<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\cms\models\CmsContentType */

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'Content Types', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-content-type-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
