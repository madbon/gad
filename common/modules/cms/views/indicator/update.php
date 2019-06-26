<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\modules\bis\models\Indicator */

$this->title = 'Update  ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Indicators', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="indicator-update">

	    <?= $this->render('_form', [
	        'model' => $model,
	        'categories' => $categories,
	        'types' => $types,
	        'units' => $units,
	        'frequencies' => $frequencies,
	        'dchoices' => $dchoices,
	        'choices' => $choices,
	        'in_chart' => $in_chart,
	    ]) ?>
	    
</div>
