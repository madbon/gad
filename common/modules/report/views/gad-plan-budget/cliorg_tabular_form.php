<?php
use common\modules\report\controllers\DefaultController as Tools;

?>
<?php
    $sup_data_value = "";
    $source_value = "";
    if(!empty($plan["sup_data"]))
    {
        $sup_data_value = "<br/><br/><span style=' font-style:italic; font-weight:bold;'>Supporting Statistics Data : </span><br/> <i style=''>".$plan["sup_data"]."</i>";
    }

    if(!empty($plan['source_value']))
    {
        $source_value = "<br/><br/><span  style=' font-style:italic; font-weight:bold;'>Source : </span><br/> <i id='content_source".$plan['id']."' style=''>".$plan["source_value"]."</i>";
    }
?>
<?php
    echo $this->render('cell_reusable_form',[
        'cell_value' => $plan["ppa_value"],
        'display_value' => "<span class='cell_span_value'>".$plan["ppa_value"]."</span>"." ".$sup_data_value." ".$source_value,
        'row_id' => $plan["id"],
        'record_unique_code' => $plan["record_uc"],
        'attribute_name' => "ppa_value",
        'data_type' => 'string',
        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-ppa-value']),
        'column_title' => 'Title / Description of Gender Issue or GAD Mandate',
        'colspanValue' => '',
        'controller_id' => "GadPlanBudget",
        'form_id' => 'cli-org-focused-form',
        'customStyle' => '',
        'enableComment' => Yii::$app->user->can('gad_comment_gender_issue') ? 'true' : 'false',
        'enableEdit' => in_array($plan['record_status'],Tools::Can("edit_plan")) ? "true" : "false",
        'enableViewComment' => 'true',
        'countRow' => $countRow,
        'columnNumber' => 1,
    ])
?>
<?php
    echo $this->render('cell_reusable_form',[
        'cell_value' => $plan["objective"],
        'display_value' => $plan["objective"],
        'row_id' => $plan["id"],
        'record_unique_code' => $plan["record_uc"],
        'attribute_name' => "objective",
        'data_type' => 'string',
        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-objective']),
        'column_title' => 'GAD Objective',
        'colspanValue' => '',
        'controller_id' => "GadPlanBudget",
        'form_id' => 'cli-org-focused-form',
        'customStyle' => '',
        'enableComment' => Yii::$app->user->can('gad_comment_objective') ? 'true' : 'false',
        'enableEdit' => in_array($plan['record_status'],Tools::Can("edit_plan")) ? "true" : "false",
        'enableViewComment' => 'true',
        'countRow' => $countRow,
        'columnNumber' => 2,
    ])
?>

<?php
    echo $this->render('cell_reusable_form',[
        'cell_value' => $plan["relevant_lgu_program_project"],
        'display_value' => $plan["relevant_lgu_program_project"],
        'row_id' => $plan["id"],
        'record_unique_code' => $plan["record_uc"],
        'attribute_name' => "relevant_lgu_program_project",
        'data_type' => 'string',
        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-relevant-lgu-program-project']),
        'column_title' => 'Relevant LGU Program and Project',
        'colspanValue' => '',
        'controller_id' => "GadPlanBudget",
        'form_id' => 'cli-org-focused-form',
        'customStyle' => '',
        'enableComment' => Yii::$app->user->can('gad_comment_relevant') ? 'true' : 'false',
        'enableEdit' => in_array($plan['record_status'],Tools::Can("edit_plan")) ? "true" : "false",
        'enableViewComment' => 'true',
        'countRow' => $countRow,
        'columnNumber' => 3
    ])
?>

<?php
    echo $this->render('cell_reusable_form',[
        'cell_value' => $plan["activity"],
        'display_value' => $plan["activity"],
        'row_id' => $plan["id"],
        'record_unique_code' => $plan["record_uc"],
        'attribute_name' => "activity",
        'data_type' => 'string',
        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-activity']),
        'column_title' => 'GAD Activity',
        'colspanValue' => '',
        'controller_id' => "GadPlanBudget",
        'form_id' => 'cli-org-focused-form',
        'customStyle' => '',
        'enableComment' => Yii::$app->user->can('gad_comment_activity') ? 'true' : 'false',
        'enableEdit' => in_array($plan['record_status'],Tools::Can("edit_plan")) ? "true" : "false",
        'enableViewComment' => 'true',
        'countRow' => $countRow,
        'columnNumber' => 4,
    ])
?>

<?php
    echo $this->render('cell_reusable_form',[
        'cell_value' => $plan["performance_target"],
        'display_value' => $plan["performance_target"],
        'row_id' => $plan["id"],
        'record_unique_code' => $plan["record_uc"],
        'attribute_name' => "performance_target",
        'data_type' => 'string',
        'urlUpdateAttribute' =>  \yii\helpers\Url::to(['/report/default/update-performance-target']),
        'column_title' => 'Performance Target',
        'colspanValue' => '',
        'controller_id' => "GadPlanBudget",
        'form_id' => 'cli-org-focused-form',
        'customStyle' => '',
        'enableComment' => Yii::$app->user->can('gad_comment_performance') ? 'true' : 'false',
        'enableEdit' => in_array($plan['record_status'],Tools::Can("edit_plan")) ? "true" : "false",
        'enableViewComment' => 'true',
        'countRow' => $countRow,
        'columnNumber' => 5,
    ])
?>

<?php
    // echo $this->render('cell_reusable_form',[
    //     'cell_value' => $plan["performance_indicator"],
    //     'row_id' => $plan["id"],
    //     'record_unique_code' => $plan["record_uc"],
    //     'attribute_name' => "performance_indicator",
    //     'data_type' => 'string',
    //     'urlUpdateAttribute' =>  \yii\helpers\Url::to(['/report/default/update-performance-indicator']),
    //     'column_title' => 'Performance Indicator',
    //     'colspanValue' => '',
    //     'controller_id' => "GadPlanBudget",
    //     'form_id' => 'cli-org-focused-form',
    //     'customStyle' => '',
    //     'enableComment' => 'true',
    //     'enableEdit' => 'true',
    // ])
?>

<?php
    echo $this->render('cell_reusable_form',[
        'cell_value' => $plan["budget_mooe"],
        'display_value' => $plan["budget_mooe"],
        'row_id' => $plan["id"],
        'record_unique_code' => $plan["record_uc"],
        'attribute_name' => "budget_mooe",
        'data_type' => 'number',
        'urlUpdateAttribute' =>  \yii\helpers\Url::to(['/report/default/update-budget-mooe']),
        'column_title' => 'MOOE',
        'colspanValue' => '',
        'controller_id' => "GadPlanBudget",
        'form_id' => 'cli-org-focused-form',
        'customStyle' => 'text-align:right;',
        'enableComment' => Yii::$app->user->can('gad_comment_mooe') ? 'true' : 'false',
        'enableEdit' => Tools::GetPlanTypeCodeByRuc($ruc) == 3 ? "false" : (in_array($plan['record_status'],Tools::Can("edit_plan")) ? "true" : "false"),
        'enableViewComment' => 'true',
        'countRow' => $countRow,
        'columnNumber' => 6,
    ])
?>

<?php
    echo $this->render('cell_reusable_form',[
        'cell_value' => $plan["budget_ps"],
        'display_value' => $plan["budget_ps"],
        'row_id' => $plan["id"],
        'record_unique_code' => $plan["record_uc"],
        'attribute_name' => "budget_ps",
        'data_type' => 'number',
        'urlUpdateAttribute' =>  \yii\helpers\Url::to(['/report/default/update-budget-ps']),
        'column_title' => 'PS',
        'colspanValue' => '',
        'controller_id' => "GadPlanBudget",
        'form_id' => 'cli-org-focused-form',
        'customStyle' => 'text-align:right;',
        'enableComment' => Yii::$app->user->can('gad_comment_ps') ? 'true' : 'false',
        'enableEdit' => Tools::GetPlanTypeCodeByRuc($ruc) == 3 ? "false" : (in_array($plan['record_status'],Tools::Can("edit_plan")) ? "true" : "false"),
        'enableViewComment' => 'true',
        'countRow' => $countRow,
        'columnNumber' => 7,
    ])
?>

<?php
    echo $this->render('cell_reusable_form',[
        'cell_value' => $plan["budget_co"],
        'display_value' => $plan["budget_co"],
        'row_id' => $plan["id"],
        'record_unique_code' => $plan["record_uc"],
        'attribute_name' => "budget_co",
        'data_type' => 'number',
        'urlUpdateAttribute' =>  \yii\helpers\Url::to(['/report/default/update-budget-co']),
        'column_title' => 'CO',
        'colspanValue' => '',
        'controller_id' => "GadPlanBudget",
        'form_id' => 'cli-org-focused-form',
        'customStyle' => 'text-align:right;',
        'enableComment' => Yii::$app->user->can('gad_comment_co') ? 'true' : 'false',
        'enableEdit' => Tools::GetPlanTypeCodeByRuc($ruc) == 3 ? "false" :  (in_array($plan['record_status'],Tools::Can("edit_plan")) ? "true" : "false"),
        'enableViewComment' => 'true',
        'countRow' => $countRow,
        'columnNumber' => 8,
    ])
?>

<?php
    echo $this->render('cell_reusable_form',[
        'cell_value' => $plan["lead_responsible_office"],
        'display_value' => $plan["lead_responsible_office"],
        'row_id' => $plan["id"],
        'record_unique_code' => $plan["record_uc"],
        'attribute_name' => "lead_responsible_office",
        'data_type' => 'string',
        'urlUpdateAttribute' =>  \yii\helpers\Url::to(['/report/default/update-pb-lead-responsible-office']),
        'column_title' => 'Lead or Responsible Office',
        'colspanValue' => '',
        'controller_id' => "GadPlanBudget",
        'form_id' => 'cli-org-focused-form',
        'customStyle' => 'border-bottom:none;',
        'enableComment' => Yii::$app->user->can('gad_comment_lead') ? 'true' : 'false',
        'enableEdit' => in_array($plan['record_status'],Tools::Can("edit_plan")) ? "true" : "false",
        'enableViewComment' => 'true',
        'countRow' => $countRow,
        'columnNumber' => 9,
    ])
?>