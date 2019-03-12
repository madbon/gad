<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use kartik\typeahead\Typeahead;
/* @var $this yii\web\View */
/* @var $searchModel common\models\GadPlanBudgetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gad Plan Budgets (Annex A)';
$this->params['breadcrumbs'][] = $this->title;
?>


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

    <table class="table table-responsive table-hover table-striped table-bordered">
        <thead>
            <tr>
                <th>Gender Issue or GAD Mandate</th>
                <th>GAD Objective</th>
                <th>Relevant LGU Program or Project</th>
                <th>GAD Activity</th>
                <th>Performance Indicator and Target</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
               foreach ($dataRecord as $key => $val) {
            ?>
                 
                <tr>
                    <td colspan='6'><b>CLIENT-FOCUSED</b></td>
                </tr>
                <tr>
                    <td colspan='6'><button type='button' class='btn btn-success btn-sm'><span class='glyphicon glyphicon-pencil'></span> Input Gender Issue</button></td>
                    <tr>
                        <td><input type="text" id="gender-issue-<?= $val['id']?>" class="form-control"> </td>
                        <td><input type="text" id="gad-objective-<?= $val['id']?>" class="form-control"></td>
                        <td><input type="text" id="relevant-project-<?= $val['id']?>" class="form-control"></td>
                        <td><input type="text" id="gad-activity-<?= $val['id']?>" class="form-control"></td>
                        <td><input type="text" id="permform-indicator-<?= $val['id']?>" class="form-control"></td>
                        <td>
                            <button type="button" class="btn btn-primary" title="Save" id="save-gender-issue-<?= $val['id']?>">
                                <span class="glyphicon glyphicon-floppy-disk"></span>
                            </button>
                        </td>
                    </tr>
                    <?php
                        $url = \yii\helpers\Url::to(['/report/default/create-gad-plan-budget']);
                        $this->registerJs('
                            $("#save-gender-issue-'.$val['id'].'").click(function(){
                                var issue       = $("#gender-issue-'.$val['id'].'").val();
                                var obj         = $("#gad-objective-'.$val['id'].'").val();
                                var relevant    = $("#relevant-project-'.$val['id'].'").val();
                                var act         = $("#gad-activity-'.$val['id'].'").val();
                                var perform     = $("#permform-indicator-'.$val['id'].'").val();
                                var ruc         = "'.$ruc.'";

                                $.ajax({
                                    url: "'.$url.'",
                                    data: { 
                                            issue:issue,
                                            obj:obj,
                                            relevant:relevant,
                                            act:act,
                                            perform:perform,
                                            ruc:ruc
                                        }
                                    
                                    }).done(function(result) {
                                        alert("hello");
                                });
                          }); ');
                    ?>
                </tr>
                    <?php
                        $not_gender_issue = null;
                        $not_gad_objective = null;
                        $not_relevant = null;
                        $not_act = null;
                        $not_perform = null;
                        $sample = null;
                        $tempKey = 0;
                        $countVal = array_count_values(ArrayHelper::getColumn($dataPlanBudget, 'objective'));
                        foreach ($dataPlanBudget as $key2 => $plan) {
                    ?>
                        <tr>
                            <td>
                                <?= $not_gender_issue != $plan["issue_mandate"] ? $plan["issue_mandate"] : "" ?>
                            </td>
                            <td>
                                <p><?= $plan["objective"]?></p>
                                <button type="button" class="btn btn-primary btn-xs" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>
                                <button type="button" class="btn btn-warning btn-xs" title="Comment"><span class="glyphicon glyphicon-comment"></span></button>
                                <button type="button" class="btn btn-default btn-xs" title="Clear"><span class="glyphicon glyphicon-erase"></span></button>
                                <br/><br/>
                                <textarea id="texta-<?= $plan['id'] ?>" rows="2"></textarea>
                                
                                <?php $tempKey = 0; ?>
                                <?php $tempKey++; ?>
                                <?= "hello".$countVal[$plan["objective"]] ?>
                                
                                <?php if($tempKey == $countVal[$plan["objective"]]) { ?>
                                    
                                    <br/>
                                    <button type="button" class="btn btn-success btn-xs" title="Add GAD Objective"><span class="glyphicon glyphicon-pencil"></span></button>
                                    
                                    <br/><br/>
                                    <textarea type="text" rows="2" class="form-control" placeholder="Add GAD Objective"></textarea>
                                <?php } ?>
                                
                            </td>
                            <td>
                                <?php if($not_relevant != $plan["relevant_lgu_program_project"]) { ?>
                                    <p><?= $plan["relevant_lgu_program_project"]?></p>
                                    <button type="button" class="btn btn-success btn-xs" title="Add GAD Objective"><span class="glyphicon glyphicon-pencil"></span></button>
                                    <button type="button" class="btn btn-primary btn-xs" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>
                                    <button type="button" class="btn btn-default btn-xs" title="Clear"><span class="glyphicon glyphicon-erase"></span></button>
                                    <button type="button" class="btn btn-warning btn-xs" title="Comment"><span class="glyphicon glyphicon-comment"></span></button>
                                    <br/><br/>
                                    <textarea type="text" rows="2" class="form-control"></textarea>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if($not_act != $plan["activity"]) { ?>
                                    <p><?= $plan["activity"]?></p>
                                    <button type="button" class="btn btn-success btn-xs" title="Add GAD Objective"><span class="glyphicon glyphicon-pencil"></span></button>
                                    <button type="button" class="btn btn-primary btn-xs" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>
                                    <button type="button" class="btn btn-default btn-xs" title="Clear"><span class="glyphicon glyphicon-erase"></span></button>
                                    <button type="button" class="btn btn-warning btn-xs" title="Comment"><span class="glyphicon glyphicon-comment"></span></button>
                                    <br/><br/>
                                    <textarea type="text" rows="2" class="form-control"></textarea>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if($not_perform != $plan["performance_indicator_target"]) { ?>
                                    <p><?= $plan["performance_indicator_target"]?></p>
                                    <button type="button" class="btn btn-success btn-xs" title="Add GAD Objective"><span class="glyphicon glyphicon-pencil"></span></button>
                                    <button type="button" class="btn btn-primary btn-xs" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>
                                    <button type="button" class="btn btn-default btn-xs" title="Clear"><span class="glyphicon glyphicon-erase"></span></button>
                                    <button type="button" class="btn btn-warning btn-xs" title="Comment"><span class="glyphicon glyphicon-comment"></span></button>
                                    <br/><br/>
                                    <textarea type="text" rows="2" class="form-control"></textarea>
                                <?php } ?>
                            </td>
                            <td></td>
                        </tr>
                    <?php 
                        $sample = $plan['objective'];
                        $not_gender_issue  = $plan['issue_mandate'];
                        $not_gad_objective = $plan['objective'];
                        $not_relevant = $plan['relevant_lgu_program_project'];
                        $not_act = $plan['activity'];
                        $not_perform = $plan['performance_indicator_target'];
                    } ?>
                
                <tr>
                    <td colspan='6'><button type='button' class='btn btn-success btn-sm'><span class='glyphicon glyphicon-plus'></span> GAD Mandate</button></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan='6'><b>Sub-total</b></td>
                </tr>
                <tr>
                    <td colspan='6'><b>Total A (MOEE+PS+CO)</b></td>
                </tr>
                <tr>
                    <td colspan='6'><b>ORGANIZATION-FOCUSED</b></td>
                </tr>
                <tr>
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
