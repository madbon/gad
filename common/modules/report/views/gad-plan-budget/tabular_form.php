<?php
    echo $this->render('client_focused/gender_issue/attributes_unified_form',[
        'plan' => $plan,
        'attribute' => 'objective',
        'column_title' => 'GAD Objective',
        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-objective']),
        'data_type' => 'string',
    ])
?>
<?php
    echo $this->render('client_focused/gender_issue/attributes_unified_form',[
        'plan' => $plan,
        'attribute' => 'relevant_lgu_program_project',
        'column_title' => 'Relevant LGU Program and Project',
        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-relevant-lgu-program-project']),
        'data_type' => 'string',
    ])
?>
<?php
    echo $this->render('client_focused/gender_issue/attributes_unified_form',[
        'plan' => $plan,
        'attribute' => 'activity',
        'column_title' => 'GAD Activity',
        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-activity']),
        'data_type' => 'string',
    ])
?>
<?php
    echo $this->render('client_focused/gender_issue/attributes_unified_form',[
        'plan' => $plan,
        'attribute' => 'performance_target',
        'column_title' => 'Performance Target',
        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-performance-target']),
        'data_type' => 'string',
    ])
?>
<?php
    echo $this->render('client_focused/gender_issue/attributes_unified_form',[
        'plan' => $plan,
        'attribute' => 'performance_indicator',
        'column_title' => 'Performance Indicator',
        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-performance-indicator']),
        'data_type' => 'string',
    ])
?>
<?php
    echo $this->render('client_focused/gender_issue/attributes_unified_form',[
        'plan' => $plan,
        'attribute' => 'budget_mooe',
        'column_title' => 'MOOE',
        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-budget-mooe']),
        'data_type' => 'number',
    ])
?>
<?php
    echo $this->render('client_focused/gender_issue/attributes_unified_form',[
        'plan' => $plan,
        'attribute' => 'budget_ps',
        'column_title' => 'PS',
        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-budget-ps']),
        'data_type' => 'number',
    ])
?>
<?php
    echo $this->render('client_focused/gender_issue/attributes_unified_form',[
        'plan' => $plan,
        'attribute' => 'budget_co',
        'column_title' => 'CO',
        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-budget-co']),
        'data_type' => 'number',
    ])
?>
<?php
    echo $this->render('client_focused/gender_issue/attributes_unified_form',[
        'plan' => $plan,
        'attribute' => 'lead_responsible_office',
        'column_title' => 'Lead or Responsible Office',
        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-lead-responsible-office']),
        'data_type' => 'string',
    ])
?>