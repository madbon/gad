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
        max-width:247px;
        background-color: white;
        box-shadow: 1px 1px 1px 1px gray;
        border-radius: 0px 0px 5px 5px;


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

    <table class="table table-responsive table-hover table-striped table-bordered">
        <thead>
            <tr>
                <th>Client Focused Type</th>
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
                        <td class="td-ppa_value-<?= $val['id']; ?>">
                            <?php
                                echo Select2::widget([
                                    'name' => 'ppa_value',
                                    'data' => $opt_cli_focused,
                                    'options' => [
                                        'placeholder' => 'Type of Client-Focused',
                                        'id' => "ppa_value-".$val['id'],
                                    ],
                                    'pluginEvents'=>[
                                        'select2:select'=>'
                                            function(){
                                                $("#message-ppa_value-'.$val["id"].'").text("");
                                                $("#select2-ppa_value-'.$val["id"].'-container").parent(".select2-selection").css({"border":"1px solid #ccc"});
                                            }',
                                    ]     
                                ]);
                            ?>
                            <?php
                                $this->registerJs("
                                    var newOption = $('<option>');
                                    newOption.attr('value','0').text('Others');
                                    $('#ppa_value-".$val['id']."').append(newOption);
                                ");
                            ?>
                            
                        </td>
                        <td>
                           <textarea type="text" class="form-control" rows="2" id="issue_mandate-<?= $val['id']?>"></textarea>
                        </td>
                        <td>
                            <textarea type="text" rows="2" id="objective-<?= $val['id']?>" class="form-control"></textarea>
                            <ul id="result-obj-<?= $val['id'] ?>" class="result"></ul>
                            
                            
                            <?php
                                $urlPbObjective = \yii\helpers\Url::to(['/report/default/load-pb-objective']);
                                $this->registerJs("
                                    $('#objective-".$val['id']."').keyup(function(){
                                        var searchField = $(this).val();
                                        var expression = new RegExp(searchField, 'i');
                                        var value_obj = $(this).val();
                                        if(value_obj.length>= 3){
                                            $.getJSON('".$urlPbObjective."', function(data){
                                                $('#result-obj-".$val['id']."').html('');
                                                $.each(data, function(key, value){
                                                    if(value.title.search(expression) != -1)
                                                    {
                                                        console.log(value)
                                                        $('#result-obj-".$val['id']."').append('<li id=obj-li-'+value.id+'>'+value.title+'</li>');

                                                        $('#result-obj-".$val['id']." li#obj-li-'+value.id+'').click(function(){
                                                            $('#objective-".$val['id']."').val($(this).text());
                                                            $('#result-obj-".$val['id']."').html('');
                                                        });
                                                        $('body').click(function(){
                                                            $('.result').html('');
                                                        });
                                                    }
                                                });
                                            });
                                        }
                                    });

                                    
                                ");
                            ?>
                        </td>
                        <td>
                            <?php
                                echo Typeahead::widget([
                                    'name' => 'obj_name'.$val['id'],
                                    'id' => 'relevant_lgu_program_project-'.$val['id'],
                                    'options' => ['placeholder' => 'Filter as you type ...'],
                                    'pluginOptions' => ['highlight'=>true],
                                    'dataset' => [
                                        [
                                            'local' => $relevant_type,
                                            'limit' => 10
                                        ]
                                    ]
                                ]);
                            ?>
                        </td>
                        <td><input type="text" id="activity-<?= $val['id']?>" class="form-control"></td>
                        <td><input type="text" id="performance_indicator_target-<?= $val['id']?>" class="form-control"></td>
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
                                var focused     = $("#ppa_value-'.$val['id'].'").val();
                                var issue       = $("#issue_mandate-'.$val['id'].'").val();
                                var obj         = $("#objective-'.$val['id'].'").val();
                                var relevant    = $("#relevant_lgu_program_project-'.$val['id'].'").val();
                                var act         = $("#activity-'.$val['id'].'").val();
                                var perform     = $("#performance_indicator_target-'.$val['id'].'").val();
                                var ruc         = "'.$ruc.'";

                                $.ajax({
                                    url: "'.$url.'",
                                    data: { 
                                            issue:issue,
                                            obj:obj,
                                            relevant:relevant,
                                            act:act,
                                            perform:perform,
                                            ruc:ruc,
                                            focused:focused
                                        }
                                    
                                    }).done(function(result) {
                                        $.each(result, function( index, value ) {
                                            
                                            $("p#message-"+index+"-'.$val["id"].'").text("");
                                            $("textarea#"+index+"-'.$val['id'].'").css({"border":"1px solid red"});
                                            $("textarea#"+index+"-'.$val['id'].'").after("<p id=message-"+index+"-'.$val["id"].' style=color:red;font-style:italic;>"+value+"</p>");

                                            $("input#"+index+"-'.$val['id'].'").css({"border":"1px solid red"});
                                            $("input#"+index+"-'.$val['id'].'").after("<p id=message-"+index+"-'.$val["id"].' style=color:red;font-style:italic;>"+value+"</p>");

                                            $("#select2-"+index+"-'.$val["id"].'-container").parent(".select2-selection").css({"border":"1px solid red"});
                                            $("#select2-"+index+"-'.$val["id"].'-container").parent(".select2-selection").after("<p id=message-"+index+"-'.$val["id"].' style=color:red;font-style:italic;>"+value+"</p>");

                                            $("#select2-"+index+"-'.$val["id"].'-container").text
                                            
                                            $("textarea#"+index+"-'.$val['id'].'").keyup(function(){
                                                $("#message-"+index+"-'.$val["id"].'").text("");
                                                $(this).css({"border":"1px solid #ccc"});
                                            });

                                            $("input#"+index+"-'.$val['id'].'").keyup(function(){
                                                $("#message-"+index+"-'.$val["id"].'").text("");
                                                $(this).css({"border":"1px solid #ccc"});
                                            });
                                        });
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
                        $countObjective = 0;
                        $not_ppa_value = null;
                        foreach ($dataPlanBudget as $key2 => $plan) {
                    ?>
                        <tr>
                            <td>
                                <?= $not_ppa_value != $plan["ppa_value"] ? $plan["ppa_value"] : "" ?>
                            </td>
                            <td>
                                <?= !empty($plan["issue_mandate"]) ? $plan["issue_mandate"] : "" ?>
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
                                    <p><?= $plan["performance_indicator_target"]?></p>
                                    <button type="button" class="btn btn-primary btn-xs" title="Edit"><span class="glyphicon glyphicon-edit"></span></button>
                                    <button type="button" class="btn btn-default btn-xs" title="Clear"><span class="glyphicon glyphicon-erase"></span></button>
                                    <button type="button" class="btn btn-warning btn-xs" title="Comment"><span class="glyphicon glyphicon-comment"></span></button>
                                    <br/><br/>
                                    <textarea type="text" rows="2" class="form-control"></textarea>
                            </td>
                            <td></td>
                        </tr>
                    <?php 
                        $not_ppa_value = $plan['ppa_value'];
                        $not_gender_issue  = $plan['issue_mandate'];
                        $not_gad_objective = $plan['objective'];
                        $not_relevant = $plan['relevant_lgu_program_project'];
                        $not_act = $plan['activity'];
                        $not_perform = $plan['performance_indicator_target'];
                    } ?>
                
                <tr>
                    <td colspan='7'><button type='button' class='btn btn-success btn-sm'><span class='glyphicon glyphicon-plus'></span> GAD Mandate</button></td>
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
                <tr>
                    <td colspan='7'><b>Sub-total</b></td>
                </tr>
                <tr>
                    <td colspan='7'><b>Total A (MOEE+PS+CO)</b></td>
                </tr>
                <tr>
                    <td colspan='7'><b>ORGANIZATION-FOCUSED</b></td>
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
