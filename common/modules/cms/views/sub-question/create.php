<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\bis\models\SubQuestion */

$this->title = 'Create Sub Question';
$this->params['breadcrumbs'][] = ['label' => 'Sub Questions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sub-question-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
