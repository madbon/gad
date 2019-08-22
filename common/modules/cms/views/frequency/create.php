<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\bis\models\Frequency */

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'Frequencies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="frequency-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
