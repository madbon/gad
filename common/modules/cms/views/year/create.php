<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\bis\models\Year */

$this->title = 'Create Year';
$this->params['breadcrumbs'][] = ['label' => 'Years', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="year-create">

    <h3 class="page-header"><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
