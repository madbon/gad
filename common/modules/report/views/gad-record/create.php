<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadRecord */

$this->title =  'Step 1. Input Primary Information';
$this->params['breadcrumbs'][] = ['label' => 'List of GAD Plan and Budget', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
	
</style>
<div class="gad-record-create">

    <h1><?php // Html::encode($this->title) ?></h1>
    <ul class="nav nav-tabs">
	  	<li class="active">
	  		<a class="btn btn-success">Step 1. Input Primary Information</a>
	  	</li>
	  	<?php if($onstep == "to_create_gpb") { ?>
		  	<li>
		  		<?= Html::a('Step 2. Encode Annual GAD Plan and Budget', ['gad-plan-budget/index','ruc' => $ruc, 'onstep' => $onstep], ['class' => 'btn btn-success']) ?>
		  	</li>
		  	<li>
		  		<?= Html::a('Step 3. Submit Report', ['index','ruc' => $ruc, 'onstep' => $onstep], ['class' => 'btn btn-success']) ?>
		  	</li>
		  	<li>
		  		<?= Html::a('Step 4. Report has been submitted', ['index','ruc' => $ruc, 'onstep' => $onstep], ['class' => 'btn btn-success']) ?>
		  	</li>
		<?php } else { ?>
			<li class="disabled">
				<a class="btn btn-success">Step 2. Encode Annual GAD Plan and Budget</a>
			</li>
			<li class="disabled">
				<a class="btn btn-success">Step 3. Submit Report</a>
			</li>
			<li class="disabled">
				<a class="btn btn-success">Step 4. Report has been submitted</a>
			</li>
		<?php } ?>
	  	
	</ul>
    
	<br/>
    <?= $this->render('_form', [
        'model' => $model,
        'onstep' => $onstep,
    ]) ?>

</div>
