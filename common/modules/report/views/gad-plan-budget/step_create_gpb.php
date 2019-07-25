<?php

use yii\helpers\Html;
use \common\modules\report\controllers\DefaultController;
/* @var $this yii\web\View */
/* @var $model common\models\GadRecord */

$this->title = 'Annual GAD Plan and Budget';
// $this->params['breadcrumbs'][] = ['label' => ' Input Primary Information', 'url' => ['gad-record/create', 'ruc' => $ruc,'onstep' => $onstep], ['class' => 'btn btn-success']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<style>
	
</style>
<h2>Annual GAD Plan and Budget FY <?= DefaultController::GetPlanYear($ruc) ?> <i style="text-decoration: underline; font-size: 25px;">(<?= DefaultController::CreatePlanStatus($ruc) ?>)</i></h2>
<div class="gad-record-create">
<?php if(Yii::$app->user->can("gad_lgu_province_permission")){ ?>
    <ul class="nav nav-tabs">
        <?php if($qryReportStatus == 9) // if report status is under encoding tab
            {
                echo $this->render('/common_tools/tabs/tab_input',[
                    'tabTitle' => ' Input Primary Information',
                    'liClass' => '',
                    'ruc' => $ruc,
                    'onstep' => $onstep,
                    'tocreate' => $tocreate,
                    'linkClass' => '',
                    'url' => '/report/gad-record/create'
                ]);
                echo $this->render('/common_tools/tabs/tab_encode',[
                    'tabTitle' => 'Encode Annual GAD Plan and Budget',
                    'liClass' => 'active',
                    'ruc' => $ruc,
                    'onstep' => $onstep,
                    'tocreate' => $tocreate,
                    'linkClass' => '',
                    'url' => 'index'
                ]);
            }
        ?>

        
<?php }else if(Yii::$app->user->can("gad_lgu_permission")){ ?>

<?php  if(Yii::$app->user->identity->userinfo->citymun->lgu_type == "HUC" || Yii::$app->user->identity->userinfo->citymun->lgu_type == "ICC" || Yii::$app->user->identity->userinfo->citymun->citymun_m == "PATEROS"){ // id HUC ?>
    <ul class="nav nav-tabs">
        <?php if($qryReportStatus == 0 || $qryReportStatus == 8) // if report status is under encoding tab
            {
                echo $this->render('/common_tools/tabs/tab_input',[
                    'tabTitle' => 'Input Primary Information',
                    'liClass' => '',
                    'ruc' => $ruc,
                    'onstep' => $onstep,
                    'tocreate' => $tocreate,
                    'linkClass' => '',
                    'url' => '/report/gad-record/create'
                ]);
                echo $this->render('/common_tools/tabs/tab_encode',[
                    'tabTitle' => 'Encode Annual GAD Plan and Budget',
                    'liClass' => 'active',
                    'ruc' => $ruc,
                    'onstep' => $onstep,
                    'tocreate' => $tocreate,
                    'linkClass' => '',
                    'url' => 'index'
                ]);
            }
        ?>
<?php }else{ // else non HUC -/////////////////////////////////////////////////// ?>   
    <ul class="nav nav-tabs">
        <?php if($qryReportStatus == 0) // if report status is under encoding tab
            {
                echo $this->render('/common_tools/tabs/tab_input',[
                    'tabTitle' => ' Input Primary Information',
                    'liClass' => '',
                    'ruc' => $ruc,
                    'onstep' => $onstep,
                    'tocreate' => $tocreate,
                    'linkClass' => '',
                    'url' => '/report/gad-record/create'
                ]);
                echo $this->render('/common_tools/tabs/tab_encode',[
                    'tabTitle' => 'Encode Annual GAD Plan and Budget',
                    'liClass' => 'active',
                    'ruc' => $ruc,
                    'onstep' => $onstep,
                    'tocreate' => $tocreate,
                    'linkClass' => '',
                    'url' => 'index'
                ]);
            }
        ?>

<?php } ?>
<?php }// end of gad_lgu  ?>
	</ul>

    <?= $this->render('index', [
        'dataRecord' => $dataRecord,
        'dataAttributedProgram' => $dataAttributedProgram,
        'select_PpaAttributedProgram' => $select_PpaAttributedProgram,
        'dataPlanBudget' => $dataPlanBudget,
        'ruc' => $ruc,
        'objective_type' => $objective_type,
        'opt_org_focused' => $opt_org_focused,
        'opt_cli_focused' => $opt_cli_focused,
        'relevant_type' => $relevant_type,
        'recRegion' => $recRegion,
        'recProvince' => $recProvince,
        'recCitymun' => $recCitymun,
        'recTotalGadBudget' => $recTotalGadBudget,
        'recTotalLguBudget' => $recTotalLguBudget,
        'onstep' => $onstep,
        'select_GadFocused' => $select_GadFocused,
        'select_GadInnerCategory' => $select_GadInnerCategory,
        'tocreate' => $tocreate,
        'grand_total_pb' => $grand_total_pb,
        'fivePercentTotalLguBudget' => $fivePercentTotalLguBudget,
        'qryReportStatus' => $qryReportStatus,
        'model' => $model,
        'select_ActivityCategory' => $select_ActivityCategory,
        'upload' => $upload,
        'folder_type' => $folder_type
    ]) ?>

</div>
