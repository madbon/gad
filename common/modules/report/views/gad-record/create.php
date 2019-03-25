<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadRecord */

$this->title = 'Create Annex A';
$this->params['breadcrumbs'][] = ['label' => 'Gad Records', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
	
</style>
<div class="gad-record-create">

    <h1><?php // Html::encode($this->title) ?></h1>
    <ul class="nav nav-tabs">
	  	<li class="active"><a href="#">Step 1. Create Primary Information</a></li>
	  	<li><a href="#">Step 2. Encode Annual GAD Plan and Budget</a></li>
	  	<li><a href="#">Step 3. Submit Report</a></li>
	</ul>
    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
