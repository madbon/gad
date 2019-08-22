<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\cms\models\CmsContentWidth */

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'Content Widths', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cms-content-width-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
