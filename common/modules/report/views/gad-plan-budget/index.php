<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use kartik\typeahead\Typeahead;
use kartik\select2\Select2;
use common\modules\report\controllers\DefaultController;
use richardfan\widget\JSRegister;
/* @var $this yii\web\View */
/* @var $searchModel common\models\GadPlanBudgetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Annual GAD Plan and Budget";
?>
<style>
    /*div.input-form
    {
        background-color: skyblue !important;
    }*/
</style>

<div class="gad-plan-budget-index">
   
    <div class="cust-panel basic-information inner-panel">
        <!-- <div class="cust-panel-header gad-color">
        </div> -->
        <div class="cust-panel-body">
            <div class="cust-panel-title">
                <div class="row">
                    <div class="col-sm-6">
                        <p class="sub-title"><span class="glyphicon glyphicon-info-sign"></span> Primary Information <?= DefaultController::DisplayStatusByTuc($ruc); ?></p>
                    </div>
                    <div class="col-sm-6">
                        <div class="pull-right">
                            <?php
                                $urlLoadAr = \yii\helpers\Url::to(['/report/default/load-ar']);
                                $urlUpdateAttachedAr = \yii\helpers\Url::to(['/report/default/update-attached-ar']);
                                $recordOne = \common\models\GadRecord::find()->where(['tuc' => $ruc])->one();
                                $recordOne_attached_ar_record_id = $recordOne->attached_ar_record_id;
                            ?>
                            <a>Needed before submitting GBP: </a>
                            <?php if($grand_total_pb < $fivePercentTotalLguBudget){ ?>
                                <a class="btn btn-default btn-sm" style="background-color: gray; color:white;"><span class="glyphicon glyphicon-remove"></span> &nbsp;Reached the 5%</a>
                            <?php }else{ ?>
                                <a class="btn btn-success btn-sm"><span class="glyphicon glyphicon-ok"></span> &nbsp;Reached the 5%</a>
                            <?php } ?>
                            <?php if(!empty($recordOne_attached_ar_record_id)){ ?>
                                <a class="btn btn-success btn-sm" id="btn_attachar"><span class="glyphicon glyphicon-ok"></span> &nbsp;
                                     Attached the Accomplishment
                                </a>
                            <?php }else{ ?>
                                <a class="btn btn-dafault btn-sm" id="btn_attachar" style="background-color: gray; color:white;"><span class="glyphicon glyphicon-remove"></span> &nbsp;
                                     Attached the Accomplishment
                                </a>
                            <?php } ?>

                            
                            <?php JSRegister::begin(); ?>
                            <script>
                                $("#btn_attachar").click(function(){
                                    var params = "<?= $ruc ?>";
                                    var recordOne_attached_ar_record_id = "<?= $recordOne_attached_ar_record_id ?>";
                                    $("table#result_ar tbody").html("");
                                    $.ajax({
                                        url: "<?= $urlLoadAr ?>",
                                        data: { 
                                            params:params,
                                        }
                                        
                                        }).done(function(data) {
                                            $("#select_ar").slideDown(300);
                                            $.each(data, function(key, value){
                                                var cols = "";
                                                cols += "<tr id=list_ar-"+value.record_id+">";
                                                cols +=     "<td>"+value.province_name+"</td>";
                                                cols +=     "<td>"+value.citymun_name+"</td>";
                                                cols +=     "<td>"+value.year+"</td>";
                                                cols +=     "<td>"+value.total_lgu_budget+"</td>";
                                                cols +=     "<td>"+value.prepared_by+"</td>";
                                                cols +=     "<td>"+value.approved_by+"</td>";
                                                
                                                if(recordOne_attached_ar_record_id == value.record_id)
                                                {
                                                    cols += "<td><span class='label label-success'>Attached to GPB</span></td>";
                                                }
                                                else
                                                {
                                                    cols +=     "<td><button type='button' id='attach_id-"+value.record_id+"' class='btn btn-success btn-xs'>Attach to GPB</button></td>";
                                                }
                                                
                                                
                                                cols += "</tr>";
                                                $("table#result_ar tbody").append(cols);

                                                $("#attach_id-"+value.record_id+"").click(function(){
                                                    var record_id = value.record_id;
                                                    var ruc = "<?= $ruc ?>";
                                                    var onstep = "<?= $onstep ?>";
                                                    var tocreate  = "<?= $tocreate ?>";

                                                    $.ajax({
                                                        url: "<?= $urlUpdateAttachedAr ?>",
                                                        data: { 
                                                            record_id:record_id,
                                                            ruc:ruc,
                                                            onstep:onstep,
                                                            tocreate:tocreate,
                                                        }
                                                        }).done(function(data) {

                                                    });
                                                });
                                            });
                                        });
                                });
                            </script>

                            <?php JSRegister::end(); ?>

                        </div>
                    </div>
                </div>
            </div>

            <div class="cust-panel-inner-body">
                <table class="table table-responsive table-hover table-bordered basic-information">
                    <tbody>
                        <tr>
                            <td style="width:1px;">REGION </td>
                            <td> : <?= $recRegion ?></td>
                            <td style="width: 180px;">TOTAL LGU BUDGET</td>
                            <td> : Php <?= number_format($recTotalLguBudget,2) ?></td>
                        </tr>
                        <tr>
                            <td>PROVINCE </td>
                            <td> : <?= $recProvince ?></td>
                            <td>TOTAL GAD BUDGET</td>
                            <?php
                                if($grand_total_pb < $fivePercentTotalLguBudget)
                                {
                                    echo "<td style='color:red;'> : Php ".number_format($grand_total_pb,2)."</td>";
                                }
                                else
                                {
                                    echo "<td style='color:blue;'> : Php ".number_format($grand_total_pb,2)."</td>";
                                }
                            ?>
                            
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

     <div class="row" style="display: none;" id="select_ar">
        <div class="col-sm-12">
            <h3>Attach One(1) Accomplishment Report</h3>
            <table id="result_ar" class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <th>PROVINCE</th>
                        <th>CITY/MUNICIPALITY</th>
                        <th>TOTAL LGU BUDGET</th>
                        <th>YEAR</th>
                        <th>PREPARED BY</th>
                        <th>APPROVED BY</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    <?php if(Yii::$app->user->can("gad_create_planbudget")){ ?>
        <br/>
        <?php if($qryReportStatus == 0 ||  $qryReportStatus == 5 || $qryReportStatus == 6){ ?>
            <button type="button" class="btn btn-success" id="btn-encode" style="margin-bottom: 5px;">
                <span class="glyphicon glyphicon-pencil"></span> Encode Plan
            </button>
            <?php echo Html::a('<span class="glyphicon glyphicon-pencil"></span> Letter of Review (.docx)',['/cms/document/index', 'ruc' => $ruc,'onstep' => $onstep, 'tocreate' => $tocreate], ['class' => 'btn btn-primary']); ?>
        <?php } ?>
    <?php } ?>

    <?php
        $urlSetSession = \yii\helpers\Url::to(['default/session-encode']);
        $this->registerJs("
            $('#btn-encode').click(function(){
                var trigger = 'open';
                var form_type = 'gender_issue';
                var report_type = 'pb';
                $.ajax({
                    url: '".$urlSetSession."',
                    data: { 
                            trigger:trigger,
                            form_type:form_type,
                            report_type:report_type
                            }
                    
                    }).done(function(result) {
                        
                });
                $('#inputFormPlan').slideDown(300);
            });
        ");
    ?>

    <?php
        $sendTo = "";
        $reportStatus = 0;
        $defaultRemarks = "";
        $returnTo = "";
        $returnStatus = 0;
        if(Yii::$app->user->can("gad_lgu_province_permission"))
        {
            $reportStatus = 3;
            $sendTo = "Endorse to DILG Regional Office";
        }
        else if(Yii::$app->user->can("gad_lgu_permission"))
        {
            if(Yii::$app->user->identity->userinfo->citymun->lgu_type == "HUC" || Yii::$app->user->identity->userinfo->citymun->lgu_type == "ICC" || Yii::$app->user->identity->userinfo->citymun->citymun_m == "PATEROS")
            {
                $reportStatus = 3;
                $sendTo = "Endorse to DILG Regional Office";
            }
            else
            {
                $reportStatus = 1;
                if($qryReportStatus == 0) // encoding process
                {
                    $reportStatus = 1;
                    $sendTo = 'Submit to PPDO';
                    $defaultRemarks = "Default Remarks : For Review by PPDO";
                }
                else if($qryReportStatus == 1) // submitted to PPDO
                {
                    $reportStatus = 2;
                    $sendTo = 'Endorse to DILG Office (C/MLGOO)';
                    $defaultRemarks = "Endorsed to DILG Office (C/MLGOO)";
                }
            }
           
        }
        else if(Yii::$app->user->can("gad_field_permission"))
        {
            $reportStatus = 4;
            $sendTo = "Endorse to Central Office";
            $returnTo = "Return to LGU";
            $returnStatus = 5;
        }
        else if(Yii::$app->user->can("gad_province_permission"))
        {
            $sendTo = "Submit to Regional Office";
        }
        else if(Yii::$app->user->can("gad_ppdo_permission"))
        {
            $reportStatus = 2; 
            $sendTo = "Endorse to DILG C/M Office";
            $returnTo = "Return to LGU";
            $returnStatus = 7;
        }
        else if(Yii::$app->user->can("gad_region"))
        {
            $reportStatus = 4;
            $sendTo = "Submit to Central Office";
            $returnTo = "Return to LGU";
            $returnStatus = 6;
        }
        else
        {
            $sendTo = null;
        }
    ?>

    <?php
    if(Yii::$app->user->can("gad_region_permission"))
    {
        if($qryReportStatus == 3)
        {
            echo '<br/><a class="btn btn-danger pull-right" id="return_to" style="border-radius:0px 5px 5px 0px;">'.$returnTo.'</a><a class="btn btn-success pull-right" id="endorse_to" style="border-radius:5px 0px 0px 5px;">'.$sendTo.'</a>';
        }
    }
    else if(Yii::$app->user->can("gad_lgu_province_permission")) 
    {
        if($qryReportStatus == 3)
        {

        }
        else
        {
            echo '<a class="btn btn-success pull-right" id="endorse_to">'.$sendTo.'</a>';
        }
    }
    else if(Yii::$app->user->can("gad_ppdo_permission")) 
    {
        if($qryReportStatus == 1)
        {
            echo '<br/><a class="btn btn-danger pull-right" id="return_to" style="border-radius:0px 5px 5px 0px;">'.$returnTo.'</a><a class="btn btn-success pull-right" id="endorse_to" style="border-radius:5px 0px 0px 5px;">'.$sendTo.'</a>';
        }
    }
    else if(Yii::$app->user->can("gad_lgu_permission"))
    {
        if(!empty($sendTo) && $qryReportStatus == 0 || $qryReportStatus == 1)
        { 
            if(Yii::$app->user->identity->userinfo->citymun->lgu_type == "HUC" || Yii::$app->user->identity->userinfo->citymun->lgu_type == "ICC" || Yii::$app->user->identity->userinfo->citymun->citymun_m == "PATEROS" && $qryReportStatus == 0)
            { 
                echo '<a class="btn btn-success pull-right" id="endorse_to">'.$sendTo.'</a>';
            }
            else
            {
                if($qryReportStatus == 0)
                {
                    echo '<a class="btn btn-success pull-right" id="endorse_to">'.$sendTo.'</a>';
                }
                else
                {
                    // echo '<a class="btn btn-success pull-right" id="endorse_to">'.$sendTo.'</a>';
                }
            }
        } 
    }
    else if(Yii::$app->user->can("gad_field"))
    { 
        if(!empty($sendTo) && $qryReportStatus == 2)
        { 
            if(Yii::$app->user->identity->userinfo->citymun->lgu_type == "HUC" || Yii::$app->user->identity->userinfo->citymun->lgu_type == "ICC" || Yii::$app->user->identity->userinfo->citymun->citymun_m == "PATEROS" && $qryReportStatus == 0)
            { 
                echo '<br/><a class="btn btn-danger pull-right" id="return_to" style="border-radius:0px 5px 5px 0px;">'.$returnTo.'</a><a class="btn btn-success pull-right" id="endorse_to" style="border-radius:5px 0px 0px 5px;">'.$sendTo.'</a>';
            
            }
            else
            {
                if($qryReportStatus == 0)
                {
                    echo "<br/>".Html::a($sendTo,
                    [
                        'gad-plan-budget/change-report-status',
                        'status' => $reportStatus,
                        'tuc' => $ruc,
                        'onstep' => $onstep,
                        'tocreate' => $tocreate
                    ],
                    [
                        'class' => 'btn btn-success pull-right',
                        'id'=>"submit_to",
                        'style' => '',
                        'data' => [
                            'confirm' => 'Are you sure you want to perform this action?',
                            'method' => 'post']
                    ]);
                }
                else
                {
                    echo '<br/><a class="btn btn-danger pull-right" id="return_to" style="border-radius:0px 5px 5px 0px;">'.$returnTo.'</a><a class="btn btn-success pull-right" id="endorse_to" style="border-radius:5px 0px 0px 5px;">'.$sendTo.'</a>';
                }
            }
        }
    } 
    ?>
    <?php
        $this->registerJs("
            $('#endorse_to').click(function(){
                $('#text_remarks').slideDown(300);
                $('#submitAsReturn').hide();
                $('#submit_to').show();
            });

            $('#return_to').click(function(){
                $('#text_remarks').slideDown(300);
                $('#submit_to').hide();
                $('#submitAsReturn').show();
            });
        ");
    ?>

    <!-- //////////////////////////////////////////////////////////// Remarks Form Start -->
    <br/> <br/>
    <div class="row">
        <div class="col-sm-8">
        </div>
        <div class="col-sm-4">
            <textarea class="form-control" rows='3' placeholder="Remarks (optional)" id="text_remarks" style="display: none;"></textarea>
    <?php
        echo Html::a('<i class="glyphicon glyphicon-send"></i> Proceed',
          [
            'gad-plan-budget/change-report-status',
            'status' => $reportStatus,
            'tuc' => $ruc,
            'onstep' => $onstep,
            'tocreate' => $tocreate
          ],
          [
            'class' => 'btn btn-success btn-sm pull-right',
            'id'=>"submit_to",
            'style' => 'margin-bottom:5px; margin-top:5px; display:none;',
          ]);
    ?>

    <?php
        echo Html::a('<i class="glyphicon glyphicon-send"></i> Return',
          [
            'gad-plan-budget/change-report-status',
            'status' => $returnStatus,
            'tuc' => $ruc,
            'onstep' => $onstep,
            'tocreate' => $tocreate
          ],
          [
            'class' => 'btn btn-danger btn-sm pull-right',
            'id'=>"submitAsReturn",
            'style' => 'margin-bottom:5px; margin-top:5px; display:none;',
          ]);
    ?>
    <?php
        $urlSaveReportValidationHistory =  \yii\helpers\Url::to(['/report/default/create-report-history']);
        $this->registerJs("
            $('#submit_to').click(function(){
                var valQryReportStatus = '".$qryReportStatus."';
                var valueTextRemarks;
                if($('#text_remarks').val() == '')
                {
                    valueTextRemarks = '".$defaultRemarks."';
                }
                else
                {
                    valueTextRemarks = $.trim($('#text_remarks').val());
                }
                
                var valueReportStatus = '".$reportStatus."';
                var tuc = '".$ruc."';
                var valueOnStep = '".$onstep."';
                var valueToCreate = '".$tocreate."';
                if (confirm('Are you sure you want Return this Report?')) {
                    $.ajax({
                        url: '".$urlSaveReportValidationHistory."',
                        data: { 
                                valueTextRemarks:valueTextRemarks,
                                valueReportStatus:valueReportStatus,
                                tuc:tuc,
                                valueOnStep:valueOnStep,
                                valueToCreate:valueToCreate
                                }
                        
                        }).done(function(result) {
                            
                    });
                }
                else
                {
                    return false;
                }
            });
        ");

        $this->registerJs("
            $('#submitAsReturn').click(function(){
                var valQryReportStatus = '".$qryReportStatus."';
                var valueTextRemarks;
                if($('#text_remarks').val() == '')
                {
                    valueTextRemarks = '".$defaultRemarks."';
                }
                else
                {
                    valueTextRemarks = $.trim($('#text_remarks').val());
                }
                
                var valueReportStatus = '".$returnStatus."';
                var tuc = '".$ruc."';
                var valueOnStep = '".$onstep."';
                var valueToCreate = '".$tocreate."';
                
                if (confirm('Are you sure you want Return this Report?')) {
                    $.ajax({
                        url: '".$urlSaveReportValidationHistory."',
                        data: { 
                                valueTextRemarks:valueTextRemarks,
                                valueReportStatus:valueReportStatus,
                                tuc:tuc,
                                valueOnStep:valueOnStep,
                                valueToCreate:valueToCreate
                                }
                        
                        }).done(function(result) {
                            
                    });
                } else {
                  return false;
                }
                
            });
        ");
    ?>
        </div>
    </div>

    
            <!-- /////////////////////////////////////////////////////////////// Remarks Form End -->
    <?php if(Yii::$app->user->can("gad_create_planbudget")){ ?>
        <?php if($qryReportStatus == 0 || $qryReportStatus == 5 || $qryReportStatus == 6){ //if report status is encoding ?> 
            <?php if(Yii::$app->session["encode_gender_pb"] == "open"){  ?>
            <div class="cust-panel input-form" id="inputFormPlan">
            <?php }else{ ?>
            <div class="cust-panel input-form" id="inputFormPlan" style="display: none;">
            <?php } ?>
                <div class="cust-panel-header gad-color">
                </div>
                <div class="cust-panel-body" style="background-color: #1fc8db; background-image: linear-gradient(141deg, #9fb8ad 0%, #1fc8db 51%, #2cb5e8 75%);">
                    <div class="cust-panel-title">
                        <p class="sub-title" style="color: white !important;"><span class="glyphicon glyphicon-pencil"></span> Encode Plan</p>
                    </div>
                    <div class="cust-panel-inner-body">
                        <?php 
                            echo $this->render('client_focused_form',[
                                'opt_cli_focused' => $opt_cli_focused,
                                'ruc' => $ruc,
                                'select_GadFocused' => $select_GadFocused,
                                'select_GadInnerCategory' => $select_GadInnerCategory,
                                'onstep' => $onstep,
                                'tocreate' => $tocreate,
                                'select_PpaAttributedProgram' => $select_PpaAttributedProgram,
                            ]);
                        ?>
                    </div>
                </div>
            </div>
        <?php  } ?>
    <?php } ?>

    
    <br/>

    <div class="cust-panel tabular-report">
        <div class="cust-panel-header gad-color">
        </div>
        <div class="cust-panel-body table-responsive">
            <div class="cust-panel-title">
                <p class="sub-title"><span class="glyphicon glyphicon-th"></span> Tabular Report</p>
            </div>
            <div class="cust-panel-inner-body">
                <table class="table table-responsive table-bordered gad-plan-budget table-hover">
                    <thead>
                        <tr>
                            <th style="border-bottom: none;">Gender Issue or GAD Mandate </th>
                            <!-- <th>Cause of the Gender Issue</th> -->
                            <th style="border-bottom: none;">GAD Objective</th>
                            <th style="border-bottom: none;">Relevant LGU Program or Project</th>
                            <th style="border-bottom: none;">GAD Activity</th>
                            <th style="border-bottom: none;">Performance Indicator and Target </th>
                            <!-- <th style="border-bottom: none;">Performance Indicator</th> -->
                            <th style="border-bottom: none;" colspan="3">GAD Budget (6)</th>
                            <th style="border-bottom: none;">Lead or Responsible Office </th>
                            <th style="border-bottom: none;"></th>
                        </tr>
                        <tr>
                            <th style="border-top: none;"></th>
                            <!-- <th></th> -->
                            <th style="border-top: none;"></th>
                            <th style="border-top: none;"></th>
                            <th style="border-top: none;"></th>
                            <th style="border-top: none;"></th>
                            <!-- <th style="border-top: none;"></th> -->
                            <th>MOOE</th>
                            <th>PS</th>
                            <th>CO</th>
                            <th style="border-top: none; border-bottom: none;"></th>
                            <th style="border-top: none; border-bottom: none;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- CLIENT-FOCUSED -->
                        <?php
                        $totalClient = 0;
                        $totalOrganization = 0;
                        
                        foreach ($dataPlanBudget as $key => $subt) {
                            if($subt["focused_id"] == 1)
                            {
                                $totalClient ++;
                            }

                            if($subt["focused_id"] == 2)
                            {
                                $totalOrganization ++;
                            }
                        }

                        $not_ppa_value = null;
                        $not_FocusedId = null;
                        $not_InnerCategoryId = null;
                        $countClient = 0;
                        $countOrganization = 0;
                        $sum_mooe = 0;
                        $sum_ps = 0;
                        $sum_co = 0;
                        $total_c = 0;
                        $total_b = 0;
                        $total_a = 0;
                        $grand_total = 0;
                        foreach ($dataPlanBudget as $key2 => $plan) {
                            if($plan["focused_id"] == 1)
                            {
                                $countClient ++;
                            }

                            if($plan["focused_id"] == 2)
                            {
                                $countOrganization ++;
                            }
                        ?>
                            <!-- Client or Organization Focused -->
                            <?php if($not_FocusedId != $plan["gad_focused_title"]) { ?>
                                <tr class="focused_title">
                                    <td style="border-bottom: none;" colspan='5'><b><?= $plan["gad_focused_title"] ?></b></td>
                                    <td colspan="3" style="border-bottom: none;"></td>
                                    <td style="border-bottom: none; border-top: none;"></td>
                                    <td style="border-bottom: none; border-top: none;"></td>
                                </tr>
                            <?php } ?>

                            <!-- Gender Issue or GAD Mandate -->
                            <?php if($not_InnerCategoryId != $plan["inner_category_title"]) { ?>
                                <tr class="inner_category_title">
                                    <td style="border-top: none;" colspan='5'><b><?= $plan["inner_category_title"] ?></b></td>
                                    <td colspan="3" style="border-top: none;"></td>
                                    <td  style="border-top:none; border-bottom: none;"></td>
                                    <td style="border-top: none; border-bottom: none;"></td>
                                </tr>
                            <?php } ?>

                            <tr>
                                <?php
                                    echo $this->render('cliorg_tabular_form',[
                                        'plan' => $plan
                                    ]);
                                ?>
                                <td style="border-bottom: none;">
                                    <?php
                                        if(Yii::$app->user->can("gad_delete_rowplanbudget") && $plan["record_status"] != 1)
                                        {
                                            echo Html::a("<span class='glyphicon glyphicon-trash'></span> Delete ",
                                            [
                                                'default/delete-plan-budget-gender-issue',
                                                'id' => $plan['id'],
                                                'ruc' => $ruc,
                                                'onstep' => $onstep,
                                                'tocreate' => $tocreate
                                            ],
                                            [
                                                'class' => 'btn btn-danger btn-xs',
                                                'id'=>"submit_to",
                                                'style' => '',
                                                'data' => [
                                                    'confirm' => 'Are you sure you want to perform this action?',
                                                    'method' => 'post']
                                            ]);
                                        }
                                    ?>
                                </td>
                            </tr>
                        <!-- Display Sub-Total -->
                        <?php 
                            if($plan["focused_id"] == 1) // client-focused
                            {
                                $sum_mooe   += $plan["budget_mooe"];
                                $sum_ps     += $plan["budget_ps"];
                                $sum_co     += $plan["budget_co"];
                                $total_a = 0;
                                $total_a = ($sum_mooe + $sum_ps + $sum_co);
                                if($countClient == $totalClient)
                                {
                                    echo "
                                    <tr class='subtotal'>
                                        <td colspan='5'><b>Sub-total</b></td>
                                        <td style='text-align:right;'><b>".(number_format($sum_mooe,2))."</b></td>
                                        <td style='text-align:right;'><b>".(number_format($sum_ps,2))."</b></td>
                                        <td style='text-align:right;'><b>".(number_format($sum_co,2))."</b></td>
                                        <td style='border-bottom:none;'></td>
                                        <td style='border-bottom:none;'></td>
                                    </tr>
                                    <tr class='total_a'>
                                        <td colspan='5'><b>Total A (MOEE+PS+CO)</b></td>
                                        <td colspan='3'>".(number_format($total_a,2))."</td>
                                        <td style='border-top:none; border-bottom:none;'></td>
                                        <td style='border-top:none; border-bottom:none;'></td>
                                    </tr>
                                    ";
                                    $sum_mooe = 0;
                                    $sum_ps = 0;
                                    $sum_co = 0;

                                }
                            }

                            if($plan["focused_id"] == 2) // organization-focused
                            {
                                $sum_mooe   += $plan["budget_mooe"];
                                $sum_ps     += $plan["budget_ps"];
                                $sum_co     += $plan["budget_co"];
                                $total_b    = ($sum_mooe + $sum_ps + $sum_co);
                                if($countOrganization == $totalOrganization)
                                {
                                    echo "
                                    <tr class='subtotal'>
                                        <td colspan='5'><b>Sub-total</b></td>
                                        <td style='text-align:right;'><b>".(number_format($sum_mooe,2))."</b></td>
                                        <td style='text-align:right;'><b>".(number_format($sum_ps,2))."</b></td>
                                        <td style='text-align:right;'><b>".(number_format($sum_co,2))."</b></td>
                                        <td style='border-bottom:none;'></td>
                                        <td style='border-bottom:none;'></td>
                                    </tr>
                                    <tr class='total_b'>
                                        <td colspan='5'><b>Total B (MOEE+PS+CO)</b></td>
                                        <td colspan='3'>".(number_format($total_b,2))."</td>
                                        <td style='border-top:none; border-bottom:none;'></td>
                                        <td style='border-top:none; border-bottom:none;'></td>
                                    </tr>
                                    ";
                                }
                            }
                            
                            $not_FocusedId = $plan["gad_focused_title"];
                            $not_InnerCategoryId = $plan["inner_category_title"];
                        } //End of dataClient ?>
                        

                        <tr class="attributed_program_title" style="border-top: none;">
                            <td colspan="5">
                                <b>ATTRIBUTED PROGRAMS</b> 
                                <?php if(Yii::$app->user->can("gad_create_planbudget")){ ?>
                                    <?php if($qryReportStatus == 0 || $qryReportStatus == 5 || $qryReportStatus == 6){ ?>
                                        <button id="btn_encode_attributed_program" type="button" class="btn btn-success btn-sm">
                                            <span class="glyphicon glyphicon-pencil"></span>
                                            Encode
                                        </button>
                                        <?php
                                            $this->registerJs("
                                                $('#btn_encode_attributed_program').click(function(){
                                                    var trigger = 'open';
                                                    var form_type = 'attribute';
                                                    var report_type = 'pb';
                                                    $.ajax({
                                                        url: '".$urlSetSession."',
                                                        data: { 
                                                                trigger:trigger,
                                                                form_type:form_type,
                                                                report_type:report_type
                                                                }
                                                        
                                                        }).done(function(result) {
                                                            
                                                    });
                                                    $('.attributed_program_form').slideDown(300);
                                                });
                                            ");
                                        ?>
                                    <?php } ?>
                                <?php } ?>
                            </td>
                            <td colspan="3"></td>
                            <td style="border-top: none;"></td>
                            <td style="border-top: none; border-bottom: none;"></td>
                        </tr>
                        <?php if(Yii::$app->user->can("gad_create_planbudget")){ ?>
                            <?php if($qryReportStatus == 0 || $qryReportStatus == 5 || $qryReportStatus == 6){ ?>
                                <?php if(Yii::$app->session["encode_attribute_pb"] == "open"){ ?>
                                    <tr class="attributed_program_form">
                                <?php }else{ ?>
                                    <tr class="attributed_program_form" style="display: none;">
                                <?php } ?>
                                    <td colspan="10" style="background-color: #1fc8db; background-image: linear-gradient(141deg, #9fb8ad 0%, #1fc8db 51%, #2cb5e8 75%);">
                                        <?php
                                            echo $this->render('attributed_program_form', [
                                                'select_PpaAttributedProgram' => $select_PpaAttributedProgram,
                                                'ruc' => $ruc,
                                                'onstep' => $onstep,
                                                'tocreate' => $tocreate,
                                            ]);
                                        ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        <tr class="attributed_program_thead">
                            <td colspan="2"><b>Title of LGU Program or Project</b></td>
                            <td colspan="1"><b>HGDG Design/ Funding Facility/ Generic Checklist Score</b></td>
                            <td colspan="2"><b>Total Annual Program/ Project Budget</b></td>
                            <td colspan="3"><b>GAD Attributed Program/Project Budget</b></td>
                            <td><b>Lead or Responsible Office</b></td>
                            <td style="border-top: none;"></td>
                        </tr>
                        <?php 
                        $notnull_apPpaValue = null;
                        // $total_c = 0;
                        $varTotalGadAttributedProBudget = 0;
                        foreach ($dataAttributedProgram as $key => $dap) { ?>

                            <tr class="attributed_program_td">
                                <?php
                                    echo $this->render('cell_reusable_form',[
                                        'cell_value' => $dap["lgu_program_project"],
                                        'display_value' => $dap["lgu_program_project"],
                                        'row_id' => $dap["id"],
                                        'record_unique_code' => $dap["record_tuc"],
                                        'attribute_name' => "lgu_program_project",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-ap-lgu-program-project']),
                                        'column_title' => 'Title of LGU Program or Project',
                                        'colspanValue' => '2',
                                        'controller_id' => $dap['controller_id'],
                                        'form_id' => 'attributed-program',
                                        'customStyle' => '',
                                        'enableComment' => Yii::$app->user->can("gad_create_comment") && $dap["record_status"] != 1 ? 'true' : 'false',
                                        'enableEdit' => Yii::$app->user->can("gad_edit_cell") && $dap["record_status"] != 1  ? 'true' : 'false',
                                        'enableViewComment' => 'true',
                                    ])
                                ?>
                                <!-- COMPUTATION OF GAD ATTRIBUTED PROGRAM/PROJECT BUDGET -->
                                <?php
                                    $varHgdg = $dap["hgdg"];
                                    $varTotalAnnualProBudget = $dap["total_annual_pro_budget"];
                                    $computeGadAttributedProBudget = 0;
                                    $HgdgMessage = null;
                                    $HgdgWrongSign = "";
                                    
                                    if($varHgdg < 4) // 0%
                                    {
                                        // echo "GAD is invisible";
                                        $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0);
                                        $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
                                    }
                                    else if($varHgdg >= 4 && $varHgdg <= 7.9) // 25%
                                    {
                                        // echo "Promising GAD prospects (conditional pass)";
                                        $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0.25);
                                        $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
                                    }
                                    else if($varHgdg >= 8 && $varHgdg <= 14.9) // 50%
                                    {
                                        // echo "Gender Sensetive";
                                        $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0.50);
                                        $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
                                    }
                                    else if($varHgdg >= 15 && $varHgdg <= 19.9) // 75%
                                    {
                                        // echo "Gender-responsive";
                                        $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0.75);
                                        $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
                                    }
                                    else if($varHgdg == 20) // 100%
                                    {
                                        // echo "Full gender-resposive";
                                        $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 1);
                                        $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
                                    }
                                    else
                                    {
                                        $HgdgMessage = Yii::$app->user->can("gad_hgdg_score_standard") ? "Unable to compute (undefined HGDG Score)." : "";
                                        $HgdgWrongSign = Yii::$app->user->can("gad_hgdg_score_standard") ? "<span class='glyphicon glyphicon-alert' style='color:red;' title='Not HGDG Score Standard'></span>" : "";
                                    }
                                ?>
                                <?php

                                    echo $this->render('cell_reusable_form',[
                                        'cell_value' => $dap["hgdg"],
                                        'display_value' => $HgdgWrongSign." ".$dap["hgdg"],
                                        'row_id' => $dap["id"],
                                        'record_unique_code' => $dap["record_tuc"],
                                        'attribute_name' => "hgdg",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-hgdg']),
                                        'column_title' => 'HGDG Design/ Funding Facility/ Generic Checklist Score',
                                        'colspanValue' => '1',
                                        'controller_id' => $dap['controller_id'],
                                        'form_id' => 'attributed-program',
                                        'customStyle' => 'text-align:center;',
                                        'enableComment' => Yii::$app->user->can("gad_create_comment") && $dap["record_status"] != 1 ? 'true' : 'false',
                                        'enableEdit' => Yii::$app->user->can("gad_edit_cell") && $dap["record_status"] != 1  ? 'true' : 'false',
                                        'enableViewComment' => 'true',
                                    ])
                                ?>
                                <?php
                                    echo $this->render('cell_reusable_form',[
                                        'cell_value' => $dap["total_annual_pro_budget"],
                                        'display_value' => $dap["total_annual_pro_budget"],
                                        'row_id' => $dap["id"],
                                        'record_unique_code' => $dap["record_tuc"],
                                        'attribute_name' => "total_annual_pro_budget",
                                        'data_type' => 'number',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-total-annual-pro-budget']),
                                        'column_title' => 'Total Annual Program/ Project Budget',
                                        'colspanValue' => '2',
                                        'controller_id' => $dap['controller_id'],
                                        'form_id' => 'attributed-program',
                                        'customStyle' => 'text-align:right;',
                                        'enableComment' => Yii::$app->user->can("gad_create_comment") && $dap["record_status"] != 1 ? 'true' : 'false',
                                        'enableEdit' => Yii::$app->user->can("gad_edit_cell") && $dap["record_status"] != 1  ? 'true' : 'false',
                                        'enableViewComment' => 'true',
                                    ])
                                ?>
                                <?php
                                    // echo $this->render('cell_reusable_form',[
                                    //     'cell_value' => $dap["attributed_pro_budget"],
                                    //     'row_id' => $dap["id"],
                                    //     'record_unique_code' => $dap["record_tuc"],
                                    //     'attribute_name' => "attributed_pro_budget",
                                    //     'data_type' => 'number',
                                    //     'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-attributed-pro-budget']),
                                    //     'column_title' => 'GAD Attributed Program/Project Budget',
                                    //     'colspanValue' => '3',
                                    //     'controller_id' => $dap['controller_id'],
                                    //     'form_id' => 'attributed-program',
                                    //     'customStyle' => 'text-align:right;',
                                    // ])
                                ?>
                                
                                <?php
                                    echo $this->render('cell_reusable_form',[
                                        'cell_value' => !empty($HgdgMessage) ? $HgdgMessage : $computeGadAttributedProBudget,
                                        'display_value' =>  !empty($HgdgMessage) ? $HgdgMessage : number_format($computeGadAttributedProBudget,2),
                                        'row_id' => $dap["id"],
                                        'record_unique_code' => $dap["record_tuc"],
                                        'attribute_name' => "attributed_pro_budget",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => "",
                                        'column_title' => 'GAD Attributed Program/Project Budget',
                                        'colspanValue' => '3',
                                        'controller_id' => $dap['controller_id'],
                                        'form_id' => 'attributed-program',
                                        'customStyle' => 'text-align:right; ',
                                         'enableComment' => Yii::$app->user->can("gad_create_comment") && $dap["record_status"] != 1 ? 'true' : 'false',
                                        'enableEdit' => Yii::$app->user->can("gad_edit_cell") && $dap["record_status"] != 1  ? 'true' : 'false',
                                        'enableViewComment' => 'true',
                                    ])
                                ?>
                                <?php
                                    echo $this->render('cell_reusable_form',[
                                        'cell_value' => $dap["ap_lead_responsible_office"],
                                        'display_value' => $dap["ap_lead_responsible_office"],
                                        'row_id' => $dap["id"],
                                        'record_unique_code' => $dap["record_tuc"],
                                        'attribute_name' => "ap_lead_responsible_office",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-ap-lead-responsible-office']),
                                        'column_title' => 'Lead or Responsible Office',
                                        'colspanValue' => '',
                                        'controller_id' => $dap['controller_id'],
                                        'form_id' => 'attributed-program',
                                        'customStyle' => '',
                                        'enableComment' => Yii::$app->user->can("gad_create_comment") && $dap["record_status"] != 1 ? 'true' : 'false',
                                        'enableEdit' => Yii::$app->user->can("gad_edit_cell") && $dap["record_status"] != 1  ? 'true' : 'false',
                                        'enableViewComment' => 'true',
                                    ])
                                ?>
                                <td>
                                    <?php
                                        if(Yii::$app->user->can("gad_delete_plan_budget"))
                                        {
                                            echo Html::a("<span class='glyphicon glyphicon-trash'></span> Delete",
                                            [
                                                'default/delete-plan-budget-attrib',
                                                'id' => $dap['id'],
                                                'ruc' => $ruc,
                                                'onstep' => $onstep,
                                                'tocreate' => $tocreate
                                            ],
                                            [
                                                'class' => 'btn btn-danger btn-xs',
                                                'id'=>"submit_to",
                                                'style' => '',
                                                'data' => [
                                                    'confirm' => 'Are you sure you want to perform this action?',
                                                    'method' => 'post']
                                            ]);
                                        }
                                    ?>
                                </td>
                            </tr>
                        <?php 
                        $total_c = $varTotalGadAttributedProBudget;
                        } ?>
                        <tr class="total_c">
                            <td><b>Total C</b></td>
                            <td colspan="4"></td>
                            <td colspan="3"><?= number_format($total_c,2) ?></td>
                            <td style="border-bottom: none;"></td>
                            <td style="border-bottom: none;"></td>
                        </tr>
                        <tr class="grand_total">
                            <td colspan="2"><b>GRAND TOTAL (A+B+C</b></td>
                            <td colspan="3"></td>
                            <td colspan="3">
                                <?php
                                    $grand_total = ($total_a + $total_b + $total_c);
                                    echo number_format($grand_total,2);
                                ?>
                            </td>
                            <td style="border-top: none;"></td>
                            <td style="border-top: none; background-color: white;"></td>
                        </tr>
                        <tr class="signatory_label">
                            <td colspan="2"><b>Prepared by:</b></td>

                            <td colspan="3"><b>Approved by:</b></td>
                            <td colspan="3"><b>Date:</b></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr class="signatory">
                            <?php foreach ($dataRecord as $key => $rec) { ?>
                                <?php
                                    echo $this->render('reusable_edit_cell_form',[
                                        'cell_value' => $rec["prepared_by"],
                                        'row_id' => $rec["id"],
                                        'record_unique_code' => $rec["tuc"],
                                        'attribute_name' => "prepared_by",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-pb-prepared-by']),
                                        'column_title' => 'Chairperson, GFPS TWG',
                                        'colspanValue' => '2',
                                        'controller_id' => "gad-plan-budget",
                                        'form_id' => 'attributed-program',
                                        'customStyle' => 'text-align:center; font-size:20px;',
                                        'disableSelect' => $rec["status"] == 1 ? 'true' : 'false',
                                    ]);
                                ?>
                                <?php
                                    echo $this->render('reusable_edit_cell_form',[
                                        'cell_value' => $rec["approved_by"],
                                        'row_id' => $rec["id"],
                                        'record_unique_code' => $rec["tuc"],
                                        'attribute_name' => "approved_by",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-pb-approved-by']),
                                        'column_title' => 'Local Chief Executive',
                                        'colspanValue' => '3',
                                        'controller_id' => "gad-plan-budget",
                                        'form_id' => 'attributed-program',
                                        'customStyle' => 'text-align:center; font-size:20px;',
                                        'disableSelect' =>  $rec["status"] == 1 ? 'true' : 'false',
                                    ]);
                                ?>
                                <?php
                                    echo $this->render('reusable_edit_cell_form_date',[
                                        'cell_value' => $rec["footer_date"],
                                        'row_id' => $rec["id"],
                                        'record_unique_code' => $rec["tuc"],
                                        'attribute_name' => "footer_date",
                                        'data_type' => 'string',
                                        'urlUpdateAttribute' => \yii\helpers\Url::to(['/report/default/update-pb-footer-date']),
                                        'column_title' => 'Date',
                                        'colspanValue' => '3',
                                        'controller_id' => "gad-plan-budget",
                                        'form_id' => 'attributed-program',
                                        'customStyle' => 'text-align:center; font-size:20px;',
                                        'disableSelect' => 'true',
                                    ]);
                                ?>
                                 <td colspan="2"></td>
                            <?php } ?>
                        </tr>
                        <tr class="signatory_title">
                            <td colspan="2">Chairperson, GFPS TWG</td>
                            <td colspan="3">Local Chief Executive</td>
                            <td colspan="3">DD/MM/YEAR</td>
                            <td colspan="2"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    
</div>


