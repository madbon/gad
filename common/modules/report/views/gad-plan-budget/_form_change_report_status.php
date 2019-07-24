<?php
use yii\helpers\Html;
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
            $sendTo = "Submit to Region";
        }
        else if(Yii::$app->user->can("gad_lgu_permission"))
        {
            if(Yii::$app->user->identity->userinfo->citymun->lgu_type == "HUC" || Yii::$app->user->identity->userinfo->citymun->lgu_type == "ICC" || Yii::$app->user->identity->userinfo->citymun->citymun_m == "PATEROS")
            {
                $reportStatus = 3;
                $sendTo = "Submit to Regional Office";
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
                else if($qryReportStatus == 7) // submitted to PPDO
                {
                    $reportStatus = 1;
                    $sendTo = 'Submit to PPDO';
                    $defaultRemarks = "Default Remarks : Submitted to PPDO";
                }
            }
        }
        else if(Yii::$app->user->can("gad_province_permission"))
        {
            $reportStatus = 4;
            $sendTo = "Endorse LGU";
            $returnTo = "Return to PPDO";
            $returnStatus = 5;
        }
        else if(Yii::$app->user->can("gad_ppdo_permission"))
        {
            $reportStatus = 2; 
            $sendTo = "Submit to DILG Province";
            $returnTo = "Return to LGU";
            $returnStatus = 7;
        }
        else if(Yii::$app->user->can("gad_region"))
        {
            $reportStatus = 10;
            $sendTo = "Endorse LGU";
            $returnTo = "Return to LGU";
            $returnStatus = 6;
        }
        else
        {
            $sendTo = null;
        }
    ?>

    
    <textarea class="form-control" rows='5' placeholder="Remarks (optional)" id="text_remarks"></textarea>
    <?php
        echo Html::a('<i class="glyphicon glyphicon-send"></i> '.$sendTo,
          [
            'gad-plan-budget/change-report-status',
            'status' => $reportStatus,
            'tuc' => $ruc,
            'onstep' => $onstep,
            'tocreate' => $tocreate
          ],
          [
            'class' => 'btn btn-primary btn-md',
            'id'=>"submit_to",
            'style' => 'margin-bottom:5px; margin-top:5px;',
          ]);
    ?>

    <?php
    if(Yii::$app->user->can("gad_return_report"))
    {
        echo Html::a('<i class="glyphicon glyphicon-send"></i> '.$returnTo,
          [
            'gad-plan-budget/change-report-status',
            'status' => $returnStatus,
            'tuc' => $ruc,
            'onstep' => $onstep,
            'tocreate' => $tocreate
          ],
          [
            'class' => 'btn btn-danger btn-md',
            'id'=>"submitAsReturn",
            'style' => 'margin-bottom:5px; margin-top:5px;',
          ]);
    }
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
                if (confirm('Are you sure you want perform this action?')) {
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
                
                if (confirm('Are you sure you want perform this action?')) {
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