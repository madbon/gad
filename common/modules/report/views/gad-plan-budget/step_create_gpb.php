<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\GadRecord */

$this->title = 'Step 2. Encode Annual GAD Plan and Budget';
$this->params['breadcrumbs'][] = ['label' => 'Step 1. Input Primary Information', 'url' => ['gad-record/create', 'ruc' => $ruc,'onstep' => $onstep], ['class' => 'btn btn-success']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<style>
	
</style>
<div class="gad-record-create">

    <h1><?php // Html::encode($this->title) ?></h1>
    <ul class="nav nav-tabs">
	  	<?= $this->render('/common_tools/tabs/tab_input',[
                'tabTitle' => 'Step 1. Input Primary Information',
                'liClass' => '',
                'ruc' => $ruc,
                'onstep' => $onstep,
                'tocreate' => $tocreate,
                'linkClass' => '',
                'url' => '/report/gad-record/create'
            ]);
        ?>
        <?= $this->render('/common_tools/tabs/tab_encode',[
                'tabTitle' => 'Step 2. Encode Annual GAD Plan and Budget',
                'liClass' => 'active',
                'ruc' => $ruc,
                'onstep' => $onstep,
                'tocreate' => $tocreate,
                'linkClass' => '',
                'url' => 'index'
            ]);
        ?>
        <?= $this->render('/common_tools/tabs/tab_submit',[
                'tabTitle' => 'Step 3. Submit Report',
                'liClass' => '',
                'ruc' => $ruc,
                'onstep' => $onstep,
                'tocreate' => $tocreate,
                'linkClass' => '',
                'url' => 'index'
            ]);
        ?>
        <?= $this->render('/common_tools/tabs/tab_completed',[
                'tabTitle' => 'Step 4. Report has been submitted',
                'liClass' => '',
                'ruc' => $ruc,
                'onstep' => $onstep,
                'tocreate' => $tocreate,
                'linkClass' => '',
                'url' => 'index'
            ]);
        ?>
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
        'grand_total_pb' => $grand_total_pb
    ]) ?>

</div>
