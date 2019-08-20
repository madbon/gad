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
use yii\helpers\Url;
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
                                $permission_to_attach_ar = Yii::$app->user->can("gad_attach_accomplishment") ? 1 : 0;
                            ?>
                            <a>Needed before submitting GPB: </a>
                            <?php
                             if($grand_total_pb < $fivePercentTotalLguBudget){ ?>
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
                                    var permission_to_attach_ar = "<?= $permission_to_attach_ar ?>";
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
                                                    if(permission_to_attach_ar == 1)
                                                    {
                                                        cols +=     "<td><button type='button' id='attach_id-"+value.record_id+"' class='btn btn-success btn-xs'>Attach to GPB</button></td>";
                                                    }
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
            <?php
                $urluploadfile = '@web/report/gad-plan-budget/upload-form-endorsement-file?ruc='.$ruc."&onstep=".$onstep."&tocreate=".$tocreate;
                if(Yii::$app->user->can("gad_lgu_permission"))
                {
                    if(DefaultController::CountUploadedFile($ruc,"GadRecord") != 0)
                    {
                        echo "<div class='btn-group'>";
                        echo "<button class='btn btn-default btn-md'>".' ('.(DefaultController::CountUploadedFile($ruc,"GadRecord")).")</button>";
                        echo Html::button('<span class="glyphicon glyphicon-paperclip"> </span> View file(s) attached by the Reviewer', ['value'=>Url::to($urluploadfile),
                            'class' => 'btn btn-primary btn-md modalButton ','title' => 'Upload Files',]);
                        echo "</div>";
                    }
                }
                else if(Yii::$app->user->can("gad_lgu_province_permission"))
                {
                    if(DefaultController::CountUploadedFile($ruc,"GadRecord") != 0)
                    {
                        echo "<div class='btn-group'>";
                        echo "<button class='btn btn-default btn-md'>".' ('.(DefaultController::CountUploadedFile($ruc,"GadRecord")).")</button>";
                        echo Html::button('<span class="glyphicon glyphicon-paperclip"> </span> View file(s) attached by the Reviewer', ['value'=>Url::to($urluploadfile),
                            'class' => 'btn btn-primary btn-md modalButton ','title' => 'Upload Files',]);
                        echo "</div>";
                    }
                }
                else if(Yii::$app->user->can("gad_province_permission"))
                {
                    echo "<div class='btn-group'>";
                    echo "<button class='btn btn-default btn-md'>".' ('.(DefaultController::CountUploadedFile($ruc,"GadRecord")).")</button>";
                    echo Html::button('<span class="glyphicon glyphicon-paperclip"> </span> Click this to attach document(s) needed by the LGU', ['value'=>Url::to($urluploadfile),
                        'class' => 'btn btn-primary btn-md modalButton ','title' => 'Upload Files',]);
                    echo "</div>";
                }
                else if(Yii::$app->user->can("gad_region_permission"))
                {
                    echo "<div class='btn-group'>";
                    echo "<button class='btn btn-default btn-md'>".' ('.(DefaultController::CountUploadedFile($ruc,"GadRecord")).")</button>";
                    echo Html::button('<span class="glyphicon glyphicon-paperclip"> </span> Click this to attach document(s) needed by the LGU', ['value'=>Url::to($urluploadfile),
                        'class' => 'btn btn-primary btn-md modalButton ','title' => 'Upload Files',]);
                    echo "</div>";
                }
                else if(Yii::$app->user->can("gad_ppdo_permission"))
                {
                    echo "<div class='btn-group'>";
                    echo "<button class='btn btn-default btn-md'>".' ('.(DefaultController::CountUploadedFile($ruc,"GadRecord")).")</button>";
                    echo Html::button('<span class="glyphicon glyphicon-paperclip"> </span> Click this to attach document(s) needed by the LGU', ['value'=>Url::to($urluploadfile),
                        'class' => 'btn btn-primary btn-md modalButton ','title' => 'Upload Files',]);
                    echo "</div>";
                }
            ?>
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
    <div class="row">
        <div class="col-sm-6">
            <div class="btn-group" style="margin-top: 20px;">
                <?php if(Yii::$app->user->can("gad_create_planbudget")){ ?>
                    <br/>
                    <?php if($qryReportStatus == 0 || $qryReportStatus == 5 || $qryReportStatus == 6 || $qryReportStatus == 7 || $qryReportStatus == 9 || $qryReportStatus == 8){ ?>
                        <button type="button" class="btn btn-success" id="btn-encode" style="border-radius: 5px 0px 0px 5px; margin-bottom: 20px;">
                            <span class="glyphicon glyphicon-pencil"></span> Encode Plan
                        </button>
                        <?php 
                            echo Html::a('<span class="glyphicon glyphicon-cloud-upload"></span> Upload Plan & Budget (excel)',['/upload/plan/index','ruc' => $ruc, 'onstep' => $onstep, 'tocreate' => $tocreate],['class'=>'btn btn-success btn-md','style' => '']);
                        ?>
                        <?php 
                            echo Html::a('<span class="glyphicon glyphicon-cloud-upload"></span> Upload Attrbiuted Programs (excel)',['/upload/plan-attributed/index','ruc' => $ruc, 'onstep' => $onstep, 'tocreate' => $tocreate],['class'=>'btn btn-success btn-md','style' => '']);
                        ?>
                    <?php } ?>
                <?php } ?>

                <?php 
                    if(Yii::$app->user->can("gad_create_letter_menu"))
                    {
                        echo Html::a('<span class="glyphicon glyphicon-pencil"></span> Create Letter of Review / Endorsement',['/cms/document/index', 'ruc' => $ruc,'onstep' => $onstep, 'tocreate' => $tocreate], ['class' => 'btn btn-primary','style' => '']); 
                    }
                ?>
                <?php
                    $urlsearchplan = '@web/report/gad-plan-budget/search-plan?ruc='.$ruc."&onstep=".$onstep."&tocreate=".$tocreate;;
                    echo Html::button('<span class="glyphicon glyphicon-search"> </span> Search', ['value'=>Url::to($urlsearchplan),
                            'class' => 'btn btn-default btn-md modalButton ','title' => 'Upload Files','style' => '']);
                ?>
            </div>
        </div>
        <div class="col-sm-6">
            <br/>
            <?php
                $t = '@web/report/gad-plan-budget/form-change-report-status?qryReportStatus='.$qryReportStatus."&ruc=".$ruc."&onstep=".$onstep."&tocreate=".$tocreate."";

                if(Yii::$app->user->can("gad_lgu_permission"))
                {
                    // show in encoding process || returned to LGU || encoding process huc || returned by region
                    if($qryReportStatus == 0 || $qryReportStatus == 7 || $qryReportStatus == 8 || $qryReportStatus == 6)
                    {
                        // if(DefaultController::CreatePlanStatusCode($ruc) != 1)
                        // {
                            // echo Html::a('<span class="glyphicon glyphicon-refresh"></span> Load Plan',['load-plan','ruc' => $ruc,'onstep' => $onstep,'tocreate' => $tocreate],['class' => 'btn btn-success'])."&nbsp;";
                            // echo Html::a('<span class="glyphicon glyphicon-refresh"></span> Load Uploaded Files',['load-file','ruc' => $ruc,'onstep' => $onstep,'tocreate' => $tocreate],['class' => 'btn btn-success']);
                        // }
                        echo Html::button('<span class="glyphicon glyphicon-send"></span> Submit', ['value'=>Url::to($t),
                        'class' => 'btn btn-info btn-md modalButton pull-right']);
                    }
                }
                else if(Yii::$app->user->can("gad_lgu_province_permission"))
                {   
                    // encoding process || returned by dilg region 
                    if($qryReportStatus == 9 || $qryReportStatus == 6)
                    {
                    //     if(DefaultController::CreatePlanStatusCode($ruc) != 1)
                    //     {
                            // echo Html::a('<span class="glyphicon glyphicon-refresh"></span> Load Plan',['load-plan','ruc' => $ruc,'onstep' => $onstep,'tocreate' => $tocreate],['class' => 'btn btn-success'])."&nbsp;";
                            // echo Html::a('<span class="glyphicon glyphicon-refresh"></span> Load Uploaded Files',['load-file','ruc' => $ruc,'onstep' => $onstep,'tocreate' => $tocreate],['class' => 'btn btn-success']);
                        // }
                        echo Html::button('<span class="glyphicon glyphicon-send"></span> Submit', ['value'=>Url::to($t),
                        'class' => 'btn btn-info btn-md modalButton pull-right']);
                    }
                }
                else if(Yii::$app->user->can("gad_ppdo_permission"))
                {
                    // for review || returned by dilg province
                    if($qryReportStatus == 1 || $qryReportStatus == 5)
                    {
                        echo Html::button('<span class="glyphicon glyphicon-send"></span> Submit', ['value'=>Url::to($t),
                        'class' => 'btn btn-info btn-md modalButton pull-right']);
                    }
                }
                else if(Yii::$app->user->can("gad_province_permission"))
                {
                    // for review of dilg province || returned by dilg province
                    if($qryReportStatus == 2)
                    {
                        echo Html::button('<span class="fa fa-paper-plane-o"></span> Process', ['value'=>Url::to($t),
                        'class' => 'btn btn-info btn-md modalButton pull-right']);
                    }
                }
                else if(Yii::$app->user->can("gad_region_permission"))
                {
                    // for review of dilg region
                    if($qryReportStatus == 3)
                    {
                        echo Html::button('<span class="fa fa-paper-plane-o"></span> Process', ['value'=>Url::to($t),
                        'class' => 'btn btn-info btn-md modalButton pull-right']);
                    }
                }
            ?>
        </div>
    </div>

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

            <!-- /////////////////////////////////////////////////////////////// Remarks Form End -->
    <?php if(Yii::$app->user->can("gad_create_planbudget")){ ?>
        <?php if($qryReportStatus == 0 || $qryReportStatus == 5 || $qryReportStatus == 6 || $qryReportStatus == 7 || $qryReportStatus == 9 || $qryReportStatus == 8){ //if report status is encoding ?> 
            <?php if(Yii::$app->session["encode_gender_pb"] == "open"){  ?>
            <div class="cust-panel input-form" id="inputFormPlan">
            <?php }else{ ?>
            <div class="cust-panel input-form" id="inputFormPlan" style="display: none;">
            <?php } ?>
                <div class="cust-panel-header gad-color">
                </div>
                <div class="cust-panel-body" style="background-image: linear-gradient(141deg, #6437a1 0%, #796692 51%, #a579dc 75%)">
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
                                'model' => $model,
                                'recTotalLguBudget' => $recTotalLguBudget,
                                'select_ActivityCategory' => $select_ActivityCategory,
                                'grand_total_pb' => $grand_total_pb,
                            ]);
                        ?>
                    </div>
                </div>
            </div>
        <?php  } ?>
    <?php } ?>

    <?php
        // echo $this->render('_search',[
        //     'model'=>$model,
        //     'select_GadFocused' => $select_GadFocused,
        // ]);
    ?>
    <br/>

    <div class="cust-panel tabular-report">
        <div class="cust-panel-header gad-color">
        </div>
        <div class="cust-panel-body table-responsive">
            <div class="cust-panel-title">
                <div class="row">
                    <div class="col-sm-6">
                        <p class="sub-title"><span class="glyphicon glyphicon-th"></span> Tabular Report</p>
                    </div>
                    <div class="col-sm-6">
                        <div class="btn-group pull-right">
                            <?php echo Html::a('<span class="glyphicon glyphicon-print"></span> &nbsp;Preview Client / Org. Focused',['print/gpb-client-organization-focused','region' => $recRegion,'province' => $recProvince, 'citymun' => $recCitymun, 'grand_total' => $grand_total_pb, 'total_lgu_budget' => $recTotalLguBudget,'ruc' => $ruc],['class'=>'btn btn-md btn-default','target'=>'_blank']);  ?>
                            <?php echo Html::a('<span class="glyphicon glyphicon-print"></span> &nbsp;Preview Attributed Program',['print/gpb-attributed-program'],['class'=>'btn btn-md btn-default','target'=>'_blank']);  ?>
                            <?php echo Html::a('<span class="glyphicon glyphicon-print"></span> &nbsp;Preview GAD Plan and Budget',['print/gad-plan-budget','region' => $recRegion,'province' => $recProvince, 'citymun' => $recCitymun, 'grand_total' => $grand_total_pb, 'total_lgu_budget' => $recTotalLguBudget,'ruc' => $ruc],['class'=>'btn btn-md btn-default','target'=>'_blank']);  ?>
                        </div>
                    </div>
                </div>
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
                        $countRow = 0;
                        foreach ($dataPlanBudget as $key2 => $plan) {
                            $countRow += 1;
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

                            <tr id="plan_tr_<?= $plan['id'] ?>">
                                <?php
                                    echo $this->render('cliorg_tabular_form',[
                                        'plan' => $plan,
                                        'countRow' => $countRow,
                                    ]);
                                ?>
                                <td style="border-bottom: none;">
                                    <?php
                                        if(Yii::$app->user->can("gad_delete_rowplanbudget"))
                                        {
                                            echo "<button class='btn btn-danger btn-xs' title='Delete' id='delete_plan_".$plan['id']."'><span class='glyphicon glyphicon-trash'></span></button>";
                                        }
                                    ?>
                                    <?php JSRegister::begin() ?>
                                    <?php $url_deletePlanRow = \yii\helpers\Url::to(['default/delete-plan-budget-gender-issue']); ?>
                                    <script>
                                        $("#delete_plan_<?= $plan['id']?>").click(function(){
                                            var plan_id = "<?= $plan['id']?>";
                                            if(confirm("Are you sure you want to delete this row?"))
                                            {
                                                $.ajax({
                                                    url: "<?= $url_deletePlanRow ?>",
                                                    data: { 
                                                            plan_id:plan_id
                                                            }
                                                    
                                                    }).done(function(result) {
                                                        if(result == 1)
                                                        {
                                                            $("#plan_tr_<?= $plan['id'] ?>").slideUp(300);
                                                        }
                                                        else
                                                        {
                                                            alert("Can't process your request. Something went wrong.");
                                                        }
                                                });
                                            }
                                            else
                                            {

                                            }
                                        });
                                    </script>
                                    <?php JSRegister::end() ?>
                                    

                                    <?php
                                        if(Yii::$app->user->can("gad_upload_files_row"))
                                        {
                                            $t = '@web/report/gad-plan-budget/update?id='.$plan['id']."&ruc=".$ruc."&onstep=".$onstep."&tocreate=".$tocreate;
                                            echo "&nbsp;".Html::button('<span class="glyphicon glyphicon-paperclip"></span> ', ['value'=>Url::to($t),
                                            'class' => 'btn btn-default btn-xs modalButton','title' => 'Upload File(s)',]);
                                        }

                                        if(DefaultController::GetUploadStatus($plan["id"],"GadPlanBudget") == 1)
                                        { // if has uploaded files show button to view file
                                            $t = '@web/report/gad-plan-budget/view?row_id='.$plan['id']."&ruc=".$ruc."&onstep=".$onstep."&tocreate=".$tocreate."&model_name=GadPlanBudget";
                                            echo "&nbsp;".Html::button('<span class="glyphicon glyphicon-file"></span> ', ['value'=>Url::to($t),
                                            'class' => 'btn btn-info btn-xs modalButton','title' => 'View Uploaded File(s)']);
                                        }
                                        else
                                        { // else no uploaded file yet
                                            if(DefaultController::PlanUploadStatus($plan['id']) == 0)
                                            { // the upload_status = 0 means no uploaded file or not upload later
                                                if(Yii::$app->user->can("gad_upload_later"))
                                                {
                                                    echo "<span class='label label-warning btn-block' id='label_nuf_noplan_".$plan['id']."'>No Uploaded File(s) </span>";
                                                }
                                            }
                                            else if(DefaultController::PlanUploadStatus($plan['id']) == 1)
                                            {
                                                echo "<span class='label label-warning btn-block' id='label_nufplan_".$plan['id']."'>Upload later </span>";
                                            }
                                            ?>
                                            <?php 
                                        }
                                    ?>

                                    <?php
                                        $url_viewDetails = '@web/report/gad-plan-budget/view-other-details-plan?model_id='.$plan['id']."&ruc=".$ruc."&onstep=".$onstep."&tocreate=".$tocreate;
                                            echo "&nbsp;".Html::button('<span class="glyphicon glyphicon-info-sign"></span> Other details', ['value'=>Url::to($url_viewDetails),
                                            'class' => 'btn btn-default btn-xs modalButton','title' => 'View other details',]);
                                    ?>

                                    <?php $url_upload_status = \yii\helpers\Url::to(['/report/default/update-upload-status']); ?>
                                    <?php JSRegister::begin(); ?>
                                        <script>
                                            $("#upload_later_<?= $plan['id'] ?>").click(function(){
                                                var row_id = "<?= $plan['id'] ?>";

                                                $.ajax({
                                                url: "<?= $url_upload_status ?>",
                                                data: { 
                                                        row_id:row_id
                                                    }
                                                }).done(function(result) {
                                                    $("#upload_later_<?= $plan['id'] ?>").hide();
                                                    $("#label_nuf_<?= $plan['id'] ?>").text("Upload Later");
                                                });
                                            });
                                        </script>
                                    <?php JSRegister::end(); ?>
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
                                    <?php if($qryReportStatus == 0 || $qryReportStatus == 5 || $qryReportStatus == 6 || $qryReportStatus == 7 || $qryReportStatus == 9 || $qryReportStatus == 8){ ?>
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
                            <?php if($qryReportStatus == 0 || $qryReportStatus == 5 || $qryReportStatus == 6 || $qryReportStatus == 7 || $qryReportStatus == 9 || $qryReportStatus == 8){ ?>
                                <?php if(Yii::$app->session["encode_attribute_pb"] == "open"){ ?>
                                    <tr class="attributed_program_form">
                                <?php }else{ ?>
                                    <tr class="attributed_program_form" style="display: none;">
                                <?php } ?>
                                    <td colspan="10" style="background-color: #1fc8db; background-image: linear-gradient(141deg, #6437a1 0%, #796692 51%, #a579dc 75%)">
                                        <?php
                                            echo $this->render('attributed_program_form', [
                                                'select_PpaAttributedProgram' => $select_PpaAttributedProgram,
                                                'ruc' => $ruc,
                                                'onstep' => $onstep,
                                                'tocreate' => $tocreate,
                                                'upload' => $upload,
                                                'folder_type' => $folder_type,
                                                'select_Checklist' => $select_Checklist,
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
                        $countRowAttribute = 0;
                        foreach ($dataAttributedProgram as $key => $dap) { 
                            $countRowAttribute += 1;
                            ?>

                            <tr class="attributed_program_td" id="attributed_tr_<?= $dap['id'] ?>">
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
                                        'customStyle' => 'padding-top:13px;',
                                        'enableComment' => Yii::$app->user->can("gad_create_comment") && $dap["record_status"] != 1 ? 'true' : 'false',
                                        'enableEdit' => Yii::$app->user->can("gad_edit_cell") && $dap["record_status"] != 1  ? 'true' : 'false',
                                        'enableViewComment' => 'true',
                                        'countRow' => $countRowAttribute,
                                        'columnNumber' => 1,

                                    ])
                                ?>
                                <!-- COMPUTATION OF GAD ATTRIBUTED PROGRAM/PROJECT BUDGET -->
                                <?php
                                    $varHgdg = $dap["hgdg"];
                                    $varTotalAnnualProBudget = $dap["total_annual_pro_budget"];
                                    $computeGadAttributedProBudget = 0;
                                    $HgdgMessage = null;
                                    $HgdgWrongSign = "";
                                    
                                    if((float)$varHgdg < 4) // 0%
                                    {
                                        // echo "GAD is invisible";
                                        $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0);
                                        $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
                                    }
                                    else if((float)$varHgdg >= 4 && (float)$varHgdg <= 7.99) // 25%
                                    {
                                        // echo "Promising GAD prospects (conditional pass)";
                                        $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0.25);
                                        $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
                                    }
                                    else if((float)$varHgdg >= 8 && (float)$varHgdg <= 14.99) // 50%
                                    {
                                        // echo "Gender Sensetive";
                                        $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0.50);
                                        $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
                                    }
                                    else if((float)$varHgdg >= 15 && (float)$varHgdg <= 19.99) // 75%
                                    {
                                        // echo "Gender-responsive";
                                        $computeGadAttributedProBudget = ($varTotalAnnualProBudget * 0.75);
                                        $varTotalGadAttributedProBudget += $computeGadAttributedProBudget;
                                    }
                                    else if((float)$varHgdg == 20) // 100%
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
                                        'customStyle' => 'text-align:center; padding-top:13px;',
                                        'enableComment' => Yii::$app->user->can("gad_create_comment") && $dap["record_status"] != 1 ? 'true' : 'false',
                                        'enableEdit' => Yii::$app->user->can("gad_edit_cell") && $dap["record_status"] != 1  ? 'true' : 'false',
                                        'enableViewComment' => 'true',
                                        'countRow' => $countRowAttribute,
                                        'columnNumber' => 2,
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
                                        'countRow' => $countRowAttribute,
                                        'columnNumber' => 3,
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
                                <td colspan="3" style="text-align: right; padding-top: 25px;"><?= !empty($HgdgMessage) ? $HgdgMessage : number_format($computeGadAttributedProBudget,2) ?></td>
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
                                        'customStyle' => 'text-align:center; padding-top:13px;',
                                        'enableComment' => Yii::$app->user->can("gad_create_comment") && $dap["record_status"] != 1 ? 'true' : 'false',
                                        'enableEdit' => Yii::$app->user->can("gad_edit_cell") && $dap["record_status"] != 1  ? 'true' : 'false',
                                        'enableViewComment' => 'true',
                                        'countRow' => $countRowAttribute,
                                        'columnNumber' => 5,
                                    ])
                                ?>
                                <td>
                                    <?php
                                        if(Yii::$app->user->can("gad_delete_plan_budget"))
                                        {
                                            // echo Html::a("<span class='glyphicon glyphicon-trash'></span>",
                                            // [
                                            //     'default/delete-plan-budget-attrib',
                                            //     'id' => $dap['id'],
                                            //     'ruc' => $ruc,
                                            //     'onstep' => $onstep,
                                            //     'tocreate' => $tocreate,
                                            // ],
                                            // [
                                            //     'class' => 'btn btn-danger btn-xs',
                                            //     'id'=>"submit_to",
                                            //     'title' => 'Delete',
                                            //     'style' => '',
                                            //     'data' => [
                                            //         'confirm' => 'Are you sure you want to perform this action?',
                                            //         'method' => 'post']
                                            // ]);
                                            echo "<button class='btn btn-danger btn-xs' title='Delete' id='delete_ap_".$dap['id']."'><span class='glyphicon glyphicon-trash'></span></button>";
                                        }
                                    ?>
                                    <?php JSRegister::begin() ?>
                                    <?php $url_deletePlanAttributedProgram = \yii\helpers\Url::to(['default/delete-plan-budget-attrib']); ?>
                                    <script>
                                        $("#delete_ap_<?= $dap['id']?>").click(function(){
                                            var attrib_id = "<?= $dap['id']?>";
                                            if(confirm("Are you sure you want to delete this row?"))
                                            {
                                                $.ajax({
                                                    url: "<?= $url_deletePlanAttributedProgram ?>",
                                                    data: { 
                                                            attrib_id:attrib_id
                                                            }
                                                    
                                                    }).done(function(result) {
                                                        $("#attributed_tr_<?= $dap['id'] ?>").slideUp(300);
                                                });
                                            }
                                            else
                                            {

                                            }
                                        });
                                    </script>
                                    <?php JSRegister::end() ?>
                                    <?php
                                        if(Yii::$app->user->can("gad_upload_files_row"))
                                        {
                                            $t = '@web/report/gad-plan-budget/update-upload-form-attributed-program?id='.$dap['id']."&ruc=".$ruc."&onstep=".$onstep."&tocreate=".$tocreate;
                                            echo Html::button('<span class="glyphicon glyphicon-paperclip"></span>', ['value'=>Url::to($t),
                                            'class' => 'btn btn-default btn-xs modalButton ','title' => 'Upload Files',]);
                                        }

                                        if(DefaultController::GetUploadStatus($dap["id"],"GadAttributedProgram") == 1)
                                        { // if has uploaded files show button to view file
                                            $t = '@web/report/gad-plan-budget/view?row_id='.$dap['id']."&ruc=".$ruc."&onstep=".$onstep."&tocreate=".$tocreate."&model_name=GadAttributedProgram";
                                            echo "&nbsp;".Html::button('<span class="glyphicon glyphicon-file"></span> ', ['value'=>Url::to($t),
                                            'class' => 'btn btn-info btn-xs modalButton','title' => 'View Uploaded Files',]);
                                        }
                                        else
                                        { // else no uploaded file yet
                                            if(DefaultController::PlanUploadStatusAttrib($dap['id']) == 1)
                                            {
                                                echo "<span class='label label-warning btn-block' id='label_nuf_".$dap['id']."'>Upload later </span>";
                                            }
                                        }
                                    ?>
                                    <?php
                                        $url_viewDetailsAttributed = '@web/report/gad-plan-budget/view-other-details-attributed?model_id='.$dap['id']."&ruc=".$ruc."&onstep=".$onstep."&tocreate=".$tocreate;
                                            echo "&nbsp;".Html::button('<span class="glyphicon glyphicon-info-sign"></span> Other details', ['value'=>Url::to($url_viewDetailsAttributed),
                                            'class' => 'btn btn-default btn-xs modalButton','title' => 'View other details',]);
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


