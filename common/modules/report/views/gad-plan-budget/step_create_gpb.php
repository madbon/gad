<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadRecord */

$this->title = 'Annual GAD Plan and Budget';
// $this->params['breadcrumbs'][] = ['label' => 'Step 1. Input Primary Information', 'url' => ['gad-record/create', 'ruc' => $ruc,'onstep' => $onstep], ['class' => 'btn btn-success']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<style>
	
</style>
<h2>Annual GAD Plan and Budget FY <?= \common\modules\report\controllers\DefaultController::GetPlanYear($ruc) ?></h2>
<div class="gad-record-create">
<?php if(Yii::$app->user->can("gad_lgu_province_permission")){ ?>
    <ul class="nav nav-tabs">
        <?php if($qryReportStatus == 0 || $qryReportStatus == 6) // if report status is under encoding tab
            {
                echo $this->render('/common_tools/tabs/tab_input',[
                    'tabTitle' => 'Step 1. Input Primary Information',
                    'liClass' => '',
                    'ruc' => $ruc,
                    'onstep' => $onstep,
                    'tocreate' => $tocreate,
                    'linkClass' => '',
                    'url' => '/report/gad-record/create'
                ]);
                echo $this->render('/common_tools/tabs/tab_encode',[
                    'tabTitle' => 'Step 2. Encode Annual GAD Plan and Budget',
                    'liClass' => 'active',
                    'ruc' => $ruc,
                    'onstep' => $onstep,
                    'tocreate' => $tocreate,
                    'linkClass' => '',
                    'url' => 'index'
                ]);
            }
            else // else on PPDO or Submitted to DILG
            {
                echo $this->render('/common_tools/tabs/tab_input',[
                    'tabTitle' => 'Step 1. Input Primary Information',
                    'liClass' => 'disabled',
                    'ruc' => $ruc,
                    'onstep' => $onstep,
                    'tocreate' => $tocreate,
                    'linkClass' => 'disabled',
                    'url' => ''
                ]);
                echo $this->render('/common_tools/tabs/tab_encode',[
                    'tabTitle' => 'Step 2. Encode Annual GAD Plan and Budget',
                    'liClass' => 'disabled',
                    'ruc' => $ruc,
                    'onstep' => $onstep,
                    'tocreate' => $tocreate,
                    'linkClass' => 'disabled',
                    'url' => ''
                ]);
            }
        ?>

        <?php if($qryReportStatus == 3){ ?>
            <li class="active">
                <?= Html::a("Step 3. Endorsed to DILG Regional Office &nbsp;<span class='glyphicon glyphicon-ok'></span>", ['','ruc' => $ruc, 'onstep' => $onstep,'tocreate' => $tocreate], ['class' => "btn btn-success"]) ?>
            </li>
        <?php }else{ ?>
            <li class="disabled">
                <?= Html::a("Step 3. Endorsed to DILG Regional Office &nbsp;<span class='glyphicon glyphicon-ok'></span>", ['','ruc' => $ruc, 'onstep' => $onstep,'tocreate' => $tocreate], ['class' => "disabled btn btn-success"]) ?>
            </li>
        <?php } ?>
<?php }else if(Yii::$app->user->can("gad_lgu_permission")){ ?>

<?php  if(Yii::$app->user->identity->userinfo->citymun->lgu_type == "HUC" || Yii::$app->user->identity->userinfo->citymun->lgu_type == "ICC" || Yii::$app->user->identity->userinfo->citymun->citymun_m == "PATEROS"){ // id HUC ?>
    <ul class="nav nav-tabs">
        <?php if($qryReportStatus == 0 || $qryReportStatus == 6) // if report status is under encoding tab
            {
                echo $this->render('/common_tools/tabs/tab_input',[
                    'tabTitle' => 'Step 1. Input Primary Information',
                    'liClass' => '',
                    'ruc' => $ruc,
                    'onstep' => $onstep,
                    'tocreate' => $tocreate,
                    'linkClass' => '',
                    'url' => '/report/gad-record/create'
                ]);
                echo $this->render('/common_tools/tabs/tab_encode',[
                    'tabTitle' => 'Step 2. Encode Annual GAD Plan and Budget',
                    'liClass' => 'active',
                    'ruc' => $ruc,
                    'onstep' => $onstep,
                    'tocreate' => $tocreate,
                    'linkClass' => '',
                    'url' => 'index'
                ]);
            }
            else // else on PPDO or Submitted to DILG
            {
                echo $this->render('/common_tools/tabs/tab_input',[
                    'tabTitle' => 'Step 1. Input Primary Information',
                    'liClass' => 'disabled',
                    'ruc' => $ruc,
                    'onstep' => $onstep,
                    'tocreate' => $tocreate,
                    'linkClass' => 'disabled',
                    'url' => ''
                ]);
                echo $this->render('/common_tools/tabs/tab_encode',[
                    'tabTitle' => 'Step 2. Encode Annual GAD Plan and Budget',
                    'liClass' => 'disabled',
                    'ruc' => $ruc,
                    'onstep' => $onstep,
                    'tocreate' => $tocreate,
                    'linkClass' => 'disabled',
                    'url' => ''
                ]);
            }
        ?>

        <?php if($qryReportStatus == 3){ ?>
            <li class="active">
                <?= Html::a("Step 3. Endorsed to DILG Regional Office &nbsp;<span class='glyphicon glyphicon-ok'></span>", ['','ruc' => $ruc, 'onstep' => $onstep,'tocreate' => $tocreate], ['class' => "btn btn-success"]) ?>
            </li>
        <?php }else{ ?>
            <li class="disabled">
                <?= Html::a("Step 3. Endorsed to DILG Regional Office &nbsp;<span class='glyphicon glyphicon-ok'></span>", ['','ruc' => $ruc, 'onstep' => $onstep,'tocreate' => $tocreate], ['class' => "disabled btn btn-success"]) ?>
            </li>
        <?php } ?>

<?php }else{ // else non HUC -/////////////////////////////////////////////////// ?>   
    <ul class="nav nav-tabs">
        <?php if($qryReportStatus == 0 || $qryReportStatus == 5) // if report status is under encoding tab
            {
                echo $this->render('/common_tools/tabs/tab_input',[
                    'tabTitle' => 'Step 1. Input Primary Information',
                    'liClass' => '',
                    'ruc' => $ruc,
                    'onstep' => $onstep,
                    'tocreate' => $tocreate,
                    'linkClass' => '',
                    'url' => '/report/gad-record/create'
                ]);
                echo $this->render('/common_tools/tabs/tab_encode',[
                    'tabTitle' => 'Step 2. Encode Annual GAD Plan and Budget',
                    'liClass' => 'active',
                    'ruc' => $ruc,
                    'onstep' => $onstep,
                    'tocreate' => $tocreate,
                    'linkClass' => '',
                    'url' => 'index'
                ]);
            }
            else // else on PPDO or Submitted to DILG
            {
                echo $this->render('/common_tools/tabs/tab_input',[
                    'tabTitle' => 'Step 1. Input Primary Information',
                    'liClass' => 'disabled',
                    'ruc' => $ruc,
                    'onstep' => $onstep,
                    'tocreate' => $tocreate,
                    'linkClass' => 'disabled',
                    'url' => ''
                ]);
                echo $this->render('/common_tools/tabs/tab_encode',[
                    'tabTitle' => 'Step 2. Encode Annual GAD Plan and Budget',
                    'liClass' => 'disabled',
                    'ruc' => $ruc,
                    'onstep' => $onstep,
                    'tocreate' => $tocreate,
                    'linkClass' => 'disabled',
                    'url' => ''
                ]);
            }
        ?>

        <?php if($qryReportStatus == 1){ ?>
            <li class="active">
                <?= Html::a("Step 3. For Review by PPDO &nbsp;<span class='glyphicon glyphicon-eye-open'></span>", ['','ruc' => $ruc, 'onstep' => $onstep,'tocreate' => $tocreate], ['class' => "btn btn-success"]) ?>
            </li>
        <?php }else{ ?>
            <li class="disabled">
                <?= Html::a("Step 3. For Review by PPDO &nbsp;<span class='glyphicon glyphicon-eye-open'></span>", ['','ruc' => $ruc, 'onstep' => $onstep,'tocreate' => $tocreate], ['class' => "disabled btn btn-success"]) ?>
            </li>
        <?php } ?>

        <?php 
            if($qryReportStatus == 2)
            {
                echo $this->render('/common_tools/tabs/tab_completed',[
                    'tabTitle' => 'Step 4. Endorsed to DILG Office (C/MLGOO)',
                    'liClass' => 'active',
                    'ruc' => $ruc,
                    'onstep' => $onstep,
                    'tocreate' => $tocreate,
                    'linkClass' => '',
                    'url' => ''
                ]);
            }
            else
            {
                echo $this->render('/common_tools/tabs/tab_completed',[
                    'tabTitle' => 'Step 4. Endorse to DILG Office (C/MLGOO)',
                    'liClass' => 'disabled',
                    'ruc' => $ruc,
                    'onstep' => $onstep,
                    'tocreate' => $tocreate,
                    'linkClass' => 'disabled',
                    'url' => ''
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
    ]) ?>

</div>
