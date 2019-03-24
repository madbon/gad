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

$this->title = 'Gad Plan Budgets (Annex A)';
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
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
       border:2px solid rgb(237,63,57); 
       border-left: 2px solid rgb(237,63,57); 
       border-top: 2px solid rgb(237,63,57); 
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
        margin-top: 20px;
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

    table.gad-plan-budget thead tr th
    {
        text-align: center;
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
        border-bottom: 1px solid #ddd;
    }

</style>
<div class="gad-plan-budget-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Annex A', ['gad-record/create'], ['class' => 'btn btn-success']) ?>
    </p>

    <table class="table table-responsive table-hover table-bordered">
        <tbody>
            <tr>
                <td>Region</td>
                <td></td>
                <td>Total LGU Budget</td>
                <td></td>
            </tr>
            <tr>
                <td>Province</td>
                <td></td>
                <td>Total GAD Budget</td>
                <td></td>
            </tr>
            <tr>
                <td>City/Municipality</td>
                <td></td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>

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
                <?php echo $this->render('client_focused_form',[
                    'opt_cli_focused' => $opt_cli_focused,
                    'val' => $val,
                    'ruc' => $ruc,
                ]);
                ?>
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
                                echo $this->render('client_focused/gender_issue/objective',[
                                    'plan' => $plan,
                                ])
                            ?>
                            <?php
                                echo $this->render('client_focused/gender_issue/relevant_lgu_program_project',[
                                    'plan' => $plan,
                                ])
                            ?>
                            <?php
                                echo $this->render('client_focused/gender_issue/activity',[
                                    'plan' => $plan,
                                ])
                            ?>
                            <?php
                                echo $this->render('client_focused/gender_issue/performance_target',[
                                    'plan' => $plan,
                                ])
                            ?>
                            <?php
                                echo $this->render('client_focused/gender_issue/performance_indicator',[
                                    'plan' => $plan,
                                ])
                            ?>
                            <?php
                                echo $this->render('client_focused/gender_issue/budget_mooe',[
                                    'plan' => $plan,
                                ])
                            ?>
                            <?php
                                echo $this->render('client_focused/gender_issue/budget_ps',[
                                    'plan' => $plan,
                                ])
                            ?>
                            <?php
                                echo $this->render('client_focused/gender_issue/budget_co',[
                                    'plan' => $plan,
                                ])
                            ?>
                            <?php
                                echo $this->render('client_focused/gender_issue/lead_responsible_office',[
                                    'plan' => $plan,
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
