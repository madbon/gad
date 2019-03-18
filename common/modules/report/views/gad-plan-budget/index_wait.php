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
     /*Speech buble*/
     .div-tooltip-form
     {
        display: none;
     }
     .upd8-textarea
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
    .bubble_actn_button {
        position: absolute;
        background: white;
        color: #FFFFFF;
        font-family: Arial;
        text-align: center;
        width: 50px;
        border-radius: 5px;
        margin-top: 20px;
        z-index: 1;
        padding-bottom: 5px;
        box-shadow: 1px 1px 1px 1px rgba(150,150,150,0.5);
    }
    /*.bubble_actn_button:after {
        content: '';
        position: absolute;
        display: block;
        width: 0;
        z-index: 1;
        border-style: solid;
        border-width: 20px 0 0 20px;
        border-color: transparent transparent transparent gray;
        top: -20px;
        left: 11%;
        margin-left: -15px;
    }*/
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
        background: #00C700;
        color: #FFFFFF;
        font-family: Arial;
        font-size: 20px;
        line-height: 120px;
        text-align: center;
        width: 250px;
        height: 120px;
        border-radius: 10px;
        padding: 0px;
        margin-top: 20px;
        margin-left: 50px;
        z-index: 1;
    }
    .bubble-comment:after {
        content: '';
        position: absolute;
        display: block;
        width: 0;
        z-index: 1;
        border-style: solid;
        border-width: 20px 0 0 20px;
        border-color: transparent transparent transparent #00C700;
        top: -20px;
        left: 11%;
        margin-left: -10px;
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

    <table class="table table-responsive table-hover table-bordered gad-plan-budget">
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
                           <td id="cell-objective-<?= $plan['id'] ?>" class="cell-container">
                                <p><?= $plan["objective"]?></p>
                                <div id="actn-btn-objective-<?= $plan['id']?>" class="bubble_actn_button actn-buble" style="display: none;">
                                    <button type="button" class="btn btn-primary btn-xs " title="Edit" id="btn-edit-objective-<?= $plan['id']?>">
                                        Edit
                                    </button>
                                </div>
                                

                                <?php
                                    $this->registerJs('
                                        $("#cell-objective-'.$plan["id"].'").click(function(){
                                            $(".actn-buble").slideUp(300);
                                            $("#actn-btn-objective-'.$plan["id"].'").slideDown(300);
                                        });
                                        $("#btn-edit-"+attrib_name+"-'.$plan["id"].'").click(function(){
                                            $("#div-edit-"+attrib_name+"-'.$plan["id"].'").slideDown(300);
                                            $("#div-edit-"+attrib_name+"-'.$plan["id"].'").addClass("active-tooltip-form");
                                        });
                                    ');
                                ?>
                                <div id="div-edit-objective-<?= $plan["id"] ?>" class="bubble div-tooltip-form unik-div-tooltip-form-<?= $plan["id"] ?>">
                                    <textarea id="txt-edit-objective" rows="2" class="form-control tooltip-form"></textarea>
                                    <button type="button" class="btn btn-xs btn-default upd8-textarea pull-right "><span class="glyphicon glyphicon-floppy-disk"></span> Update</button>
                                </div>
                                <?php
                                    $this->registerJs('

                                    ');
                                ?>
                               <!--  <button type="button" class="btn btn-default btn-xs" title="Clear">
                                    <span class="glyphicon glyphicon-erase"></span>
                                </button>
                                <button type="button" class="btn btn-warning btn-xs" title="Comment">
                                    <span class="glyphicon glyphicon-comment"></span>
                                </button> -->
                               
                            </td>
                            <td id="cell-relevant_lgu_program_project-<?= $plan['id'] ?>" class="cell-container">
                                <p><?= $plan["relevant_lgu_program_project"]?></p>
                                <button type="button" class="btn btn-success btn-xs btn-open-cell" title="Open" id="btn-open-relevant_lgu_program_project-<?= $plan['id']?>" style="display: none;">
                                    Select
                                </button>
                                <button type="button" class="btn btn-primary btn-xs btn-edit-cell" title="Edit" id="btn-edit-relevant_lgu_program_project-<?= $plan['id']?>">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </button>

                                <?php
                                    $this->registerJs('
                                        
                                    ');
                                ?>
                                <div id="div-edit-relevant_lgu_program_project-<?= $plan["id"] ?>" class="bubble div-tooltip-form unik-div-tooltip-form-<?= $plan["id"] ?>">
                                    <textarea id="txt-edit-relevant_lgu_program_project" rows="2" class="form-control tooltip-form"></textarea>
                                    <button type="button" class="btn btn-xs btn-default upd8-textarea pull-right "><span class="glyphicon glyphicon-floppy-disk"></span> Update</button>
                                </div>
                                <?php
                                    $this->registerJs('

                                    ');
                                ?>
                               <!--  <button type="button" class="btn btn-default btn-xs" title="Clear">
                                    <span class="glyphicon glyphicon-erase"></span>
                                </button>
                                <button type="button" class="btn btn-warning btn-xs" title="Comment">
                                    <span class="glyphicon glyphicon-comment"></span>
                                </button> -->
                               
                            </td>
                            <td>
                                    <p><?= $plan["activity"]?></p>
                                    <button type="button" class="btn btn-primary btn-xs" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>
                                    <button type="button" class="btn btn-default btn-xs" title="Clear"><span class="glyphicon glyphicon-erase"></span></button>
                                    <button type="button" class="btn btn-warning btn-xs" title="Comment"><span class="glyphicon glyphicon-comment"></span></button>
                            </td>
                            <td>
                                    <p><?= $plan["performance_target"]?></p>
                                    <button type="button" class="btn btn-primary btn-xs" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>
                                    <button type="button" class="btn btn-default btn-xs" title="Clear"><span class="glyphicon glyphicon-erase"></span></button>
                                    <button type="button" class="btn btn-warning btn-xs" title="Comment"><span class="glyphicon glyphicon-comment"></span></button>
                            </td>
                            <td>
                                    <p><?= $plan["performance_indicator"]?></p>
                                    <button type="button" class="btn btn-primary btn-xs" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>
                                    <button type="button" class="btn btn-default btn-xs" title="Clear"><span class="glyphicon glyphicon-erase"></span></button>
                                    <button type="button" class="btn btn-warning btn-xs" title="Comment"><span class="glyphicon glyphicon-comment"></span></button>
                            </td>
                            <td>
                                    <p><?= !empty($plan["budget_mooe"]) ? number_format($plan["budget_mooe"],2) : "" ?></p>
                                    <button type="button" class="btn btn-primary btn-xs" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>
                                    <button type="button" class="btn btn-default btn-xs" title="Clear"><span class="glyphicon glyphicon-erase"></span></button>
                                    <button type="button" class="btn btn-warning btn-xs" title="Comment"><span class="glyphicon glyphicon-comment"></span></button>
                            </td>
                            <td>
                                    <p><?= !empty($plan["budget_ps"]) ? number_format($plan["budget_ps"],2) : "" ?></p>
                                    <button type="button" class="btn btn-primary btn-xs" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>
                                    <button type="button" class="btn btn-default btn-xs" title="Clear"><span class="glyphicon glyphicon-erase"></span></button>
                                    <button type="button" class="btn btn-warning btn-xs" title="Comment"><span class="glyphicon glyphicon-comment"></span></button>
                            </td>
                            <td>
                                    <p><?= !empty($plan["budget_co"]) ? number_format($plan["budget_co"],2) : "" ?></p>
                                    <button type="button" class="btn btn-primary btn-xs" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>
                                    <button type="button" class="btn btn-default btn-xs" title="Clear"><span class="glyphicon glyphicon-erase"></span></button>
                                    <button type="button" class="btn btn-warning btn-xs" title="Comment"><span class="glyphicon glyphicon-comment"></span></button>
                            </td>
                            <td>
                                    <p><?= $plan["lead_responsible_office"]?></p>
                                    <button type="button" class="btn btn-primary btn-xs" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>
                                    <button type="button" class="btn btn-default btn-xs" title="Clear"><span class="glyphicon glyphicon-erase"></span></button>
                                    <button type="button" class="btn btn-warning btn-xs" title="Comment"><span class="glyphicon glyphicon-comment"></span></button>
                            </td>
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
