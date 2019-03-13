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
                <?php echo $this->render('client_focused_form_test',[
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
                           <td>
                                <p><?= $plan["objective"]?></p>
                                <button type="button" class="btn btn-primary btn-xs" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>
                                <button type="button" class="btn btn-default btn-xs" title="Clear"><span class="glyphicon glyphicon-erase"></span></button>
                                <button type="button" class="btn btn-warning btn-xs" title="Comment"><span class="glyphicon glyphicon-comment"></span></button>
                                <br/><br/>
                                <textarea type="text" rows="2" class="form-control"></textarea>
                            </td>
                            <td>
                                
                                    <p><?= $plan["relevant_lgu_program_project"]?></p>
                                    <button type="button" class="btn btn-primary btn-xs" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>
                                    <button type="button" class="btn btn-default btn-xs" title="Clear"><span class="glyphicon glyphicon-erase"></span></button>
                                    <button type="button" class="btn btn-warning btn-xs" title="Comment"><span class="glyphicon glyphicon-comment"></span></button>
                                    <br/><br/>
                                    <textarea type="text" rows="2" class="form-control"></textarea>
                            </td>
                            <td>
                                    <p><?= $plan["activity"]?></p>
                                    <button type="button" class="btn btn-primary btn-xs" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>
                                    <button type="button" class="btn btn-default btn-xs" title="Clear"><span class="glyphicon glyphicon-erase"></span></button>
                                    <button type="button" class="btn btn-warning btn-xs" title="Comment"><span class="glyphicon glyphicon-comment"></span></button>
                                    <br/><br/>
                                    <textarea type="text" rows="2" class="form-control"></textarea>
                            </td>
                            <td>
                                    <p><?= $plan["performance_target"]?></p>
                                    <button type="button" class="btn btn-primary btn-xs" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>
                                    <button type="button" class="btn btn-default btn-xs" title="Clear"><span class="glyphicon glyphicon-erase"></span></button>
                                    <button type="button" class="btn btn-warning btn-xs" title="Comment"><span class="glyphicon glyphicon-comment"></span></button>
                                    <br/><br/>
                                    <textarea type="text" rows="2" class="form-control"></textarea>
                            </td>
                            <td>
                                    <p><?= $plan["performance_indicator"]?></p>
                                    <button type="button" class="btn btn-primary btn-xs" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>
                                    <button type="button" class="btn btn-default btn-xs" title="Clear"><span class="glyphicon glyphicon-erase"></span></button>
                                    <button type="button" class="btn btn-warning btn-xs" title="Comment"><span class="glyphicon glyphicon-comment"></span></button>
                                    <br/><br/>
                                    <textarea type="text" rows="2" class="form-control"></textarea>
                            </td>
                            <td>
                                    <p><?= !empty($plan["budget_mooe"]) ? number_format($plan["budget_mooe"],2) : "" ?></p>
                                    <button type="button" class="btn btn-primary btn-xs" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>
                                    <button type="button" class="btn btn-default btn-xs" title="Clear"><span class="glyphicon glyphicon-erase"></span></button>
                                    <button type="button" class="btn btn-warning btn-xs" title="Comment"><span class="glyphicon glyphicon-comment"></span></button>
                                    <br/><br/>
                                    <textarea type="text" rows="2" class="form-control"></textarea>
                            </td>
                            <td>
                                    <p><?= !empty($plan["budget_ps"]) ? number_format($plan["budget_ps"],2) : "" ?></p>
                                    <button type="button" class="btn btn-primary btn-xs" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>
                                    <button type="button" class="btn btn-default btn-xs" title="Clear"><span class="glyphicon glyphicon-erase"></span></button>
                                    <button type="button" class="btn btn-warning btn-xs" title="Comment"><span class="glyphicon glyphicon-comment"></span></button>
                                    <br/><br/>
                                    <textarea type="text" rows="2" class="form-control"></textarea>
                            </td>
                            <td>
                                    <p><?= !empty($plan["budget_co"]) ? number_format($plan["budget_co"],2) : "" ?></p>
                                    <button type="button" class="btn btn-primary btn-xs" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>
                                    <button type="button" class="btn btn-default btn-xs" title="Clear"><span class="glyphicon glyphicon-erase"></span></button>
                                    <button type="button" class="btn btn-warning btn-xs" title="Comment"><span class="glyphicon glyphicon-comment"></span></button>
                                    <br/><br/>
                                    <textarea type="text" rows="2" class="form-control"></textarea>
                            </td>
                            <td>
                                    <p><?= $plan["lead_responsible_office"]?></p>
                                    <button type="button" class="btn btn-primary btn-xs" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>
                                    <button type="button" class="btn btn-default btn-xs" title="Clear"><span class="glyphicon glyphicon-erase"></span></button>
                                    <button type="button" class="btn btn-warning btn-xs" title="Comment"><span class="glyphicon glyphicon-comment"></span></button>
                                    <br/><br/>
                                    <textarea type="text" rows="2" class="form-control"></textarea>
                            </td>
                            <td></td>
                        </tr>
                    

                    <?php } ?>
                <?php echo $this->render('client_focused_bottom_form',[
                        'opt_cli_focused' => $opt_cli_focused,
                        'val' => $val,
                        'ruc' => $ruc,
                    ]);?>
                <tr>
                    <td colspan='12'><button type='button' class='btn btn-success btn-sm'><span class='glyphicon glyphicon-pencil'></span> GAD Mandate</button></td>
                </tr>
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
