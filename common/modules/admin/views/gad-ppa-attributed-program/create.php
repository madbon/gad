<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadPpaAttributedProgram */

$this->title = 'Create Gad Ppa Attributed Program';
$this->params['breadcrumbs'][] = ['label' => 'Gad Ppa Attributed Programs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gad-ppa-attributed-program-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
