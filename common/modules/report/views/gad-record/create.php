<?php

use yii\helpers\Html;
use common\modules\report\controllers\DefaultController;
/* @var $this yii\web\View */
/* @var $model common\models\GadRecord */

if($tocreate == "gad_plan_budget")
{
	$this->title =  'Annual Plan and Budget';
}
else if($tocreate == "accomp_report")
{
	$this->title =  'Annual Accomplishment Report';
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
<?php if($tocreate == "gad_plan_budget"){ ?>
	<h3 style="text-align: center; font-weight: bold; padding-top: 0; margin-top: 0;">GAD Plan and Budget
		<?php if($ruc != "empty"){ ?>
			 FY <?= DefaultController::GetPlanYear($ruc) ?>
		<?php } ?>
	</h3>
<?php }else{ ?>
	<h3 style="text-align: center; font-weight: bold; padding-top: 0; margin-top: 0;">GAD Accomplishment Report 
		<?php if($ruc != "empty"){ ?>
			 FY <?= DefaultController::GetPlanYear($ruc) ?>
		<?php } ?>
	</h3>
<?php } ?>
<div class="gad-record-create">
	<ul class="nav nav-tabs" >
	  	<li class="active">
	  		<a class="btn btn-success">Primary Information  &nbsp;<span class="glyphicon glyphicon-edit"></span> </a>
	  	</li>
	  	
		  	<?php if($onstep == 'to_create_gpb'){ ?>
			  	<?= $this->render('/common_tools/tabs/tab_encode',[
			  			'tabTitle' => 'Annual GAD Plan and Budget',
			  			'liClass' => '',
			  			'ruc' => $ruc,
			  			'onstep' => $onstep,
			  			'tocreate' => $tocreate,
			  			'linkClass' => '',
			  			'url' => '/report/gad-plan-budget/index',
			  			'plan_type' => $plan_type,
			  			'query_all_existing_plan' => $query_all_existing_plan
			  		]);
			  	?>

			  	<?php if(Yii::$app->user->can("gad_lgu_permission")){ ?>
				  	
				  <?php }else if(Yii::$app->user->can("gad_lgu_province_permission")){ ?>
				  		
				  <?php } ?>
		  	<?php }else if($onstep == 'to_create_ar'){ ?>

			  	<?= $this->render('/common_tools/tabs/tab_encode',[
			  			'tabTitle' => 'Annual Accomplishment Report',
			  			'liClass' => '',
			  			'ruc' => $ruc,
			  			'onstep' => $onstep,
			  			'tocreate' => $tocreate,
			  			'linkClass' => '',
			  			'url' => '/report/gad-accomplishment-report/index',
			  			'query_all_existing_plan' => $query_all_existing_plan
			  		]);
			  	?>
			  		<?php if(Yii::$app->user->can("gad_lgu_permission")){ ?>
				  		
				  	<?php }else if(Yii::$app->user->can("gad_lgu_province_permission")){ // if lgu province is encoding?>
				  		
				  <?php } ?>
		  	<?php }else{  //onstep=create_new ?>
		  		<?php if($tocreate == "gad_plan_budget"){ //-----------------------tocreate=gad_plan_budget (GAD Plan and Budget) ?> 
					<?= $this->render('/common_tools/tabs/tab_encode',[
				  			'tabTitle' => 'Annual GAD Plan and Budget',
				  			'liClass' => 'disabled',
				  			'ruc' => $ruc,
				  			'onstep' => $onstep,
				  			'tocreate' => $tocreate,
				  			'linkClass' => 'disabled',
				  			'plan_type' => $plan_type,
				  			'url' => '',
				  			'query_all_existing_plan' => $query_all_existing_plan
				  		]);
				  	?>
				  	<?php if(Yii::$app->user->can("gad_lgu_permission")){ ?>
					  	<?php  if(Yii::$app->user->identity->userinfo->citymun->lgu_type == "HUC" || Yii::$app->user->identity->userinfo->citymun->lgu_type == "ICC" || Yii::$app->user->identity->userinfo->citymun->citymun_m == "PATEROS"){ ?>
						  	
					  	<?php }else{ // if not HUC ?>
					  		
				  		<?php } ?>
				  	<?php }else if(Yii::$app->user->can("gad_lgu_province_permission")){ // if lgu province is encoding?>
				  		
				  	<?php } ?>
				<?php }else{ //------------------------------------------------tocreate=accomp_report (Accomplishment Report)?>
					<?= $this->render('/common_tools/tabs/tab_encode',[
				  			'tabTitle' => 'Annual Accomplishment Report',
				  			'liClass' => 'disabled',
				  			'ruc' => $ruc,
				  			'onstep' => $onstep,
				  			'tocreate' => $tocreate,
				  			'linkClass' => 'disabled',
				  			'url' => '',
				  			'query_all_existing_plan' => $query_all_existing_plan,
				  		]);
				  	?>
				  	<?php if(Yii::$app->user->can("gad_lgu_permission")){ ?>
					  	<?php  if(Yii::$app->user->identity->userinfo->citymun->lgu_type == "HUC" || Yii::$app->user->identity->userinfo->citymun->lgu_type == "ICC" || Yii::$app->user->identity->userinfo->citymun->citymun_m == "PATEROS"){ ?>
						  	
					  	<?php }else{ ?>
					  		
					  	<?php } ?>
				  	<?php }else if(Yii::$app->user->can("gad_lgu_province_permission")){ // if lgu province is encoding?>
				  		
				  	<?php } ?>
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
		        'create_plan_status' => $create_plan_status,
		        'plan_type' => $plan_type,
		        'tocreate' => $tocreate,
		        'query_all_existing_plan' =>  $query_all_existing_plan,
		    ]) ?>
	    </div>
	</div>
</div>
