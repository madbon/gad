<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\modules\bis\models\Indicator */

$this->title = 'Create Indicator';
$this->params['breadcrumbs'][] = ['label' => 'Indicators', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="indicator-create">

    <!-- <h3 class="page-header"><?php // Html::encode($this->title) ?></h3> -->
 
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
