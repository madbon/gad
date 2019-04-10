<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadRecord */

if($tocreate == "gad_plan_budget")
{
	$this->title =  'Step 1. Input Primary Information (Plan and Budget)';
}
else if($tocreate == "accomp_report")
{
	$this->title =  'Step 1. Input Primary Information (Accomplishment Report)';
}
else
{
	throw new \yii\web\HttpException(404, 'The requested Item could not be found.');
}

// $this->params['breadcrumbs'][] = ['label' => 'List of GAD Plan and Budget', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
	
</style>
<div class="gad-record-create">
	<ul class="nav nav-tabs" style="padding-top: 15px;">
	  	<li class="active">
	  		<a class="btn btn-success">Step 1. Input Primary Information  &nbsp;<span class="glyphicon glyphicon-edit"></span> </a>
	  	</li>
	  	
		  	<?php if($onstep == 'to_create_gpb'){ ?>
			  	<?= $this->render('/common_tools/tabs/tab_encode',[
			  			'tabTitle' => 'Step 2. Encode Annual GAD Plan and Budget',
			  			'liClass' => '',
			  			'ruc' => $ruc,
			  			'onstep' => $onstep,
			  			'tocreate' => $tocreate,
			  			'linkClass' => '',
			  			'url' => '/report/gad-plan-budget/index'
			  		]);
			  	?>

			  	<?= $this->render('/common_tools/tabs/tab_submit',[
			  			'tabTitle' => 'Step 3. Submit Report',
			  			'liClass' => '',
			  			'ruc' => $ruc,
			  			'onstep' => $onstep,
			  			'tocreate' => $tocreate,
			  			'linkClass' => '',
			  			'url' => '/report/gad-plan-budget/index'
			  		]);
			  	?>

			  	<?= $this->render('/common_tools/tabs/tab_completed',[
			  			'tabTitle' => 'Step 4. Report has been submitted',
			  			'liClass' => '',
			  			'ruc' => $ruc,
			  			'onstep' => $onstep,
			  			'tocreate' => $tocreate,
			  			'linkClass' => '',
			  			'url' => '/report/gad-plan-budget/index'
			  		]);
			  	?>
		  	<?php }else if($onstep == 'to_create_ar'){ ?>

			  	<?= $this->render('/common_tools/tabs/tab_encode',[
			  			'tabTitle' => 'Step 2. Encode Annual Accomplishment Report',
			  			'liClass' => '',
			  			'ruc' => $ruc,
			  			'onstep' => $onstep,
			  			'tocreate' => $tocreate,
			  			'linkClass' => '',
			  			'url' => '/report/gad-accomplishment-report/index'
			  		]);
			  	?>
			  	<?= $this->render('/common_tools/tabs/tab_submit',[
			  			'tabTitle' => 'Step 3. Submit Report',
			  			'liClass' => '',
			  			'ruc' => $ruc,
			  			'onstep' => $onstep,
			  			'tocreate' => $tocreate,
			  			'linkClass' => '',
			  			'url' => '/report/gad-plan-budget/index'
			  		]);
			  	?>

			  	<?= $this->render('/common_tools/tabs/tab_completed',[
			  			'tabTitle' => 'Step 4. Report has been submitted',
			  			'liClass' => '',
			  			'ruc' => $ruc,
			  			'onstep' => $onstep,
			  			'tocreate' => $tocreate,
			  			'linkClass' => '',
			  			'url' => '/report/gad-plan-budget/index'
			  		]);
			  	?>
		  	<?php }else{ ?>
		  		<?php if($tocreate == "gad_plan_budget"){ ?>
				  	<!-- <li class="disabled">
						<a class="btn btn-success">Step 2. Encode Annual GAD Plan and Budget &nbsp;<span class="glyphicon glyphicon-pencil"></span> </a>
					</li> -->
					<?= $this->render('/common_tools/tabs/tab_encode',[
				  			'tabTitle' => 'Step 2. Encode Annual GAD Plan and Budget',
				  			'liClass' => 'disabled',
				  			'ruc' => $ruc,
				  			'onstep' => $onstep,
				  			'tocreate' => $tocreate,
				  			'linkClass' => '',
				  			'url' => ''
				  		]);
				  	?>

				  	<?= $this->render('/common_tools/tabs/tab_submit',[
				  			'tabTitle' => 'Step 3. Submit Report',
				  			'liClass' => 'disabled',
				  			'ruc' => $ruc,
				  			'onstep' => $onstep,
				  			'tocreate' => $tocreate,
				  			'linkClass' => '',
				  			'url' => ''
				  		]);
				  	?>

				  	<?= $this->render('/common_tools/tabs/tab_completed',[
				  			'tabTitle' => 'Step 4. Report has been submitted',
				  			'liClass' => 'disabled',
				  			'ruc' => $ruc,
				  			'onstep' => $onstep,
				  			'tocreate' => $tocreate,
				  			'linkClass' => '',
				  			'url' => ''
				  		]);
				  	?>
				<?php }else{ ?>
					<?= $this->render('/common_tools/tabs/tab_encode',[
				  			'tabTitle' => 'Step 2. Encode Annual Accomplishment Report',
				  			'liClass' => 'disabled',
				  			'ruc' => $ruc,
				  			'onstep' => $onstep,
				  			'tocreate' => $tocreate,
				  			'linkClass' => '',
				  			'url' => ''
				  		]);
				  	?>

				  	<?= $this->render('/common_tools/tabs/tab_submit',[
				  			'tabTitle' => 'Step 3. Submit Report',
				  			'liClass' => 'disabled',
				  			'ruc' => $ruc,
				  			'onstep' => $onstep,
				  			'tocreate' => $tocreate,
				  			'linkClass' => '',
				  			'url' => ''
				  		]);
				  	?>

				  	<?= $this->render('/common_tools/tabs/tab_completed',[
				  			'tabTitle' => 'Step 4. Report has been submitted',
				  			'liClass' => 'disabled',
				  			'ruc' => $ruc,
				  			'onstep' => $onstep,
				  			'tocreate' => $tocreate,
				  			'linkClass' => '',
				  			'url' => ''
				  		]);
				  	?>
				<?php } ?>
	  		<?php } ?>
	  	
	</ul>
	<div class="cust-panel">
	    <!-- <div class="cust-panel-header gad-color">
	    </div> -->
	    <div class="cust-panel-body">
	    	<br/>
	        <?= $this->render('_form', [
		        'model' => $model,
		        'onstep' => $onstep,
		    ]) ?>
	    </div>
	</div>
</div>
