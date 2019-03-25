<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use kartik\typeahead\Typeahead;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $searchModel common\models\GadPlanBudgetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'ANNUAL GENDER AND DEVELOPMENT (GAD PLAN BUDGET) FY '.date("Y");
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
    table.basic-information tbody tr td:nth-child(2)
    {
        font-weight: bold;
    }
    table.basic-information tbody tr td:nth-child(4)
    {
        font-weight: bold;
    }
    table.basic-information tbody tr td
    {
        border:none;
    }
    /*table.basic-information tbody tr td:nth-child(3)
    {
        background-color: rgb(245,245,245);
    }
    table.basic-information tbody tr:nth-child(3) td:nth-child(3)
    {
        background-color: white;
    }
    table.basic-information tbody tr td:first-child
    {
        background-color: rgb(245,245,245);
    }
    table.basic-information tbody tr td
    {
        border:1px solid black;
    }*/
    div.input_form_container
    {
        border: 1px solid #ddd;
        margin-bottom: 20px;
    }
    div.input_form_body
    {
        width: 96%;
        margin-left: 2%;
        margin-right: auto;
        padding-top: 10px;
        padding-bottom: 20px;
    }
    div.input_form_header
    {
        height: 30px;
        background-color: #ddd;
    }
    ul.view-comment-list li p.comment_action_button textarea
    {
        display: none;
    }
    ul.view-comment-list li p.comment_action_button button
    {
        margin-top: 5px;
        display: none;
    }
    ul.view-comment-list li p.comment_action_button i.btn-delete-comment
    {
        margin-left:5px;
    }
    ul.view-comment-list li p.psgc_value span.glyphicon-map-marker
    {
        color: #ef3131;
    }
    ul.view-comment-list li p.psgc_value i.office
    {
        font-weight: normal;
        font-style: normal;
        color: #337ab7;
    }
    ul.view-comment-list li p.psgc_value i.citymun
    {
        font-weight: normal;
        font-style: normal;
        font-size: 11px;
        color: #337ab7;
    }
    ul.view-comment-list li p.psgc_value i.province
    {
        font-style: normal;
        font-weight: normal;
        font-size: 11px;
        color: #337ab7;
    }
    ul.view-comment-list li p.psgc_value i.region
    {
        font-style: normal;
        font-weight: normal;
        font-size: 11px;
        color: #337ab7;
    }
    ul.view-comment-list li p.comment_value
    {
        font-weight: normal;
        padding-bottom: 0;
        margin-bottom: 10px;
        margin-top: -8px;
        /*font-style: italic;*/
        text-align: left;
    }
    ul.view-comment-list li p.who_date_value
    {
        margin-top: -10px;
    }
    ul.view-comment-list li i.who_comment
    {
        font-size: 13px;
        font-style: normal;
        padding-right: 10px;
        color:gray;
    }
    ul.view-comment-list li i.date_value
    {
        font-size: 10px;
        color:gray;
        padding-right: 5px;
        /*font-style: normal;*/
    }
    ul.view-comment-list li i.time_value
    {
        font-size: 10px;
        color:gray;
        /*font-style: normal;*/
    }
    .btn-delete-comment
    {
        color:#337ab7;
        cursor: pointer;
        font-size: 12px;
    }
    .btn-edit-comment
    {
        color:#337ab7;
        cursor: pointer;
        font-size: 12px;
    }
    ul.view-comment-list li p.psgc_value
    {
        font-weight: bold;
    }

    ul.view-comment-list li
    {
        padding-top: 10px;
        padding-bottom: 5px;
        border-bottom: 1px solid rgb(220,220,220);
    }
    ul.view-comment-list
    {
        list-style-type: none;
        text-align: left;
        padding-left: 15px;
        padding-right: 15px;
    }
    div.comment-inner-content
    {
        overflow-y: scroll;
        max-height: 220px;
    }
    table tbody tr td.has-comment
    {
      /* border:2px solid rgb(237,63,57) !important; 
       border-left: 2px solid rgb(237,63,57) !important; 
       border-top: 2px solid rgb(237,63,57) !important; */
       background-color: #9e42a969 !important;
    }
    .bubble-view-comment {
        position: absolute;
        background: white;
        color: black;
        font-family: Arial;
        text-align: center;
        width: 350px;
        border-radius: 5px;
        margin-top: 20px;
        z-index: 1;
        padding-bottom: 5px;
        box-shadow: 1px 1px 1px 1px rgba(150,150,150,0.5);
        max-height: 250px;
    }
    .bubble-view-comment:after {
        content: '';
        position: absolute;
        display: block;
        width: 0;
        z-index: 1;
        border-style: solid;
        border-width: 20px 0 0 20px;
        border-color: transparent transparent transparent white;
        top: -20px;
        left: 11%;
        margin-left: 30px;
    }
     /*Speech buble*/
    
    p.confirm-message
    {
        position: absolute;
        padding:5px;
        display: none;
        border-radius: 15px;
        font-size:12px;
        box-shadow: 2px 2px 2px 2px rgba(150,150,150,0.5);
        z-index: 1;
    }
    p.confirm-wrnng
    {
        background-color: #f0ad4e;
        color:white;
    }
    p.confirm-sccss
    {
        background-color: rgb(92,184,92);
        color:white;
    }
    p.confirm-prmry
    {
        background-color: #286090;
        color:white;
    }
    p.confirm-dngr
    {
        background-color: #d9534f;
        color:white;
    }
    .actn-btn-bubble {
        position: absolute;
        /*background: #5cb85c;*/
        color: #FFFFFF;
        font-family: Arial;
        text-align: center;
        width: 50px;
        border-radius: 5px;
        /*margin-top: 20px;*/
        z-index: 1;
        padding-bottom: 5px;
        /*box-shadow: 1px 1px 1px 1px rgba(150,150,150,0.5);*/
    }
    .actn-btn-bubble:after {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        width: 0;
        height: 0;
        border: 10px solid transparent;
        border-bottom-color: #5bc0de;
        border-top: 0;
        margin-left: -20px;
        margin-top: -10px;
    }
     .div-tooltip-form
     {
        display: none;
     }
     .upd8-button
     {
        margin-top: 5px;
        margin-left: 5px;
        border-radius: 50px;
     }
     .exit-button
     {
        margin-top: 5px;
        margin-right: 5px;
        border-radius: 50px;
     }
     .comnt-textarea
     {
        margin-top: 5px;
        margin-right: 5px;
        border-radius: 50px;
     }
     .tooltip-form
    {
        margin-top: 5px;
        width: 96%;
        margin-left: 2%;
        margin-right: auto;
    }

    .bubble {
        position: absolute;
        background: #286090;
        color: #FFFFFF;
        font-family: Arial;
        text-align: center;
        width: 250px;
        border-radius: 5px;
        margin-top: 20px;
        z-index: 1;
        padding-bottom: 5px;
        box-shadow: 1px 1px 1px 1px rgba(150,150,150,0.5);
    }
    .bubble:after {
        content: '';
        position: absolute;
        display: block;
        width: 0;
        z-index: 1;
        border-style: solid;
        border-width: 20px 0 0 20px;
        border-color: transparent transparent transparent #286090;
        top: -20px;
        left: 11%;
        margin-left: -15px;
    }

    .bubble-comment {
        position: absolute;
        background: #f0ad4e;
        color: #FFFFFF;
        font-family: Arial;
        text-align: center;
        width: 250px;
        border-radius: 5px;
        margin-top: 20px;
        z-index: 1;
        padding-bottom: 5px;
        box-shadow: 1px 1px 1px 1px rgba(150,150,150,0.5);
    }
    .bubble-comment:after {
        content: '';
        position: absolute;
        display: block;
        width: 0;
        z-index: 1;
        border-style: solid;
        border-width: 20px 0 0 20px;
        border-color: transparent transparent transparent #f0ad4e;
        top: -20px;
        left: 11%;
        margin-left: 10px;
    }


    .tt-menu .tt-suggestion
    {
        white-space: pre-wrap;
    }
    ul.result
    {
        max-height: 200px;
        overflow-y: auto;
        position: absolute;
        padding-left:0;
        padding-right: 0;
        z-index: 1001;
        cursor: pointer;
        /*max-width:247px;*/
        background-color: white;
        
        border-radius: 0px 0px 2px 2px;
        border-left: 1px solid rgb(102,175,233);


    }
    ul.result li:hover
    {
        background-color: rgb(51,122,183);
        color:white;
    }
    ul.result li
    {
        padding-top: 5px;
        padding-bottom: 5px;
        padding-left:5px;
    }
    .select2-container--krajee .select2-selection--single .select2-selection__rendered
    {
        width: 200px;
    }

    .table > caption + thead > tr:first-child > th, .table > colgroup + thead > tr:first-child > th, .table > thead:first-child > tr:first-child > th, .table > caption + thead > tr:first-child > td, .table > colgroup + thead > tr:first-child > td, .table > thead:first-child > tr:first-child > td
    {
        border-top: 1px solid black;
    }
    table.gad-plan-budget thead tr th
    {
        text-align: center;
        border:1px solid black;
    }
    table.gad-plan-budget thead tr:first-child th
    {
        border-bottom: none;
    }
    table.gad-plan-budget thead tr:nth-child(2) th
    {
        border-top: none;
    }
    table.gad-plan-budget thead tr:first-child th:nth-child(8)
    {
        border-bottom: 1px solid black;
    }

    table.gad-plan-budget tbody tr td
    {
        border:1px solid black;
    }

</style>
<div class="gad-plan-budget-index">
    <!-- <p>
        <?php // Html::a('Create Annex A', ['gad-record/create'], ['class' => 'btn btn-success']) ?>
    </p> -->

   
    <div class="cust-panel basic-information">
        <div class="cust-panel-header success">
        </div>
        <div class="cust-panel-body">
            <div class="cust-panel-title">
                <p class="sub-title">Primary Information</p>
            </div>
            <div class="cust-panel-inner-body">
                <table class="table table-responsive table-hover table-bordered basic-information">
                    <tbody>
                        <tr>
                            <td style="width:1px;">REGION :</td>
                            <td> : <?= $recRegion ?></td>
                            <td style="width: 180px;">TOTAL LGU BUDGET</td>
                            <td> : Php <?= number_format($recTotalLguBudget,2) ?></td>
                        </tr>
                        <tr>
                            <td>PROVINCE :</td>
                            <td> : <?= $recProvince ?></td>
                            <td>TOTAL GAD BUDGET</td>
                            <td> : Php <?= number_format($recTotalGadBudget,2) ?></td>
                        </tr>
                        <tr>
                            <td>CITY/MUNICIPALITY </td>
                            <td> : <?= $recCitymun ?></td>
                            <td colspan="2"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br/>

    <button type="button" class="btn btn-success" id="btn-encode" style="margin-bottom: 5px;">
        <span class="glyphicon glyphicon-pencil"></span> Encode
    </button>
    
    <?php
        $this->registerJs('
            $("#btn-encode").click(function(){
                $(".input-form").slideDown(300);
            });
        ');
    ?>
    <div class="cust-panel input-form" style="display: none;">
        <div class="cust-panel-header success">
        </div>
        <div class="cust-panel-body">
            <div class="cust-panel-title">
                <p class="sub-title">INPUT FORM</p>
            </div>
            <div class="cust-panel-inner-body">
                <?php echo $this->render('client_focused_form',[
                    'opt_cli_focused' => $opt_cli_focused,
                    'ruc' => $ruc,
                ]);
                ?>
            </div>
        </div>
    </div>
    <br/>

    <div class="cust-panel tabular-report">
        <div class="cust-panel-header success">
        </div>
        <div class="cust-panel-body">
            <div class="cust-panel-title">
                <p class="sub-title">Tabular Report</p>
            </div>
            <div class="cust-panel-inner-body">
                <table class="table table-responsive table-bordered gad-plan-budget">
                    <thead>
                        <tr>
                            <th>Gender Issue or GAD Mandate </th>
                            <th>Cause of the Gender Issue</th>
                            <th>GAD Objective</th>
                            <th>Relevant LGU Program or Project</th>
                            <th>GAD Activity</th>
                            <th>Performance Target </th>
                            <th>Performance Indicator</th>
                            <th colspan="3">GAD Budget (6)</th>
                            <th>Lead or Responsible Office </th>
                            <th></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>MOOE</th>
                            <th>PS</th>
                            <th>CO</th>
                            <th></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                           foreach ($dataRecord as $key => $val) {
                        ?>
                             
                            <tr>
                                <td colspan='12'><b>CLIENT-FOCUSED</b></td>
                            </tr>
                            <tr>
                                <td colspan='12'><b>Gender Issue</b></td>
                            </tr>
                            
                                <?php
                                    $not_ppa_value = null;
                                    foreach ($dataPlanBudget as $key2 => $plan) {
                                ?>
                                    <tr>
                                        <td>
                                            <?= $not_ppa_value != $plan["ppa_value"] ? $plan["ppa_value"] : "" ?>
                                        </td>   
                                        <td>
                                            <?= !empty($plan["cause_gender_issue"]) ? $plan["cause_gender_issue"] : "" ?>
                                        </td>
                                        
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
                                        <td></td>
                                    </tr>
                                

                                <?php } ?>
                            <?php echo $this->render('client_focused_gad_mandate',[
                                    'opt_cli_focused' => $opt_cli_focused,
                                    'val' => $val,
                                    'ruc' => $ruc,
                                ]);?>
                                
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan='12'><b>Sub-total</b></td>
                            </tr>
                            <tr>
                                <td colspan='12'><b>Total A (MOEE+PS+CO)</b></td>
                            </tr>
                            <tr>
                                <td colspan='12'><b>ORGANIZATION-FOCUSED</b></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                                
                        <?php   
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
</div>
