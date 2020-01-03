<?php
/* @var $this yii\web\View */
use common\modules\report\controllers\DefaultController as Tools;
use common\modules\report\controllers\GadPlanBudgetController as PlanActions;
?>
<style>
    table thead tr th.no_border
    {
        border:none;
    }
    table thead tr th.align_left
    {
        text-align: left;
    }
</style>
<p style="text-align: center; font-weight: bold;">ANNUAL GENDER AND DEVELOPMENT (GAD) PLAN AND BUDGET FY <?= Tools::GetPlanYear($ruc) ?> <?= Tools::DispPlanTypeByRuc($ruc) ?></p>
<table class="table table-responsive table-bordered gad-plan-budget" style="border: none;">
    <thead>
        <tr>
            <th class="no_border align_left">REGION </th>
            <th class="no_border align_left" colspan="2"> : <?= $region ?></th>
            <th class="no_border align_left">TOTAL LGU BUDGET
                <?php
                    // if(in_array($qryReportStatus,Tools::Can("edit_plan")))
                    // {
                    //     $url_edit_record = '@web/report/gad-record/edit-form?ruc='.$ruc.'&onstep='.$onstep.'&tocreate='.$tocreate;
                    //         echo Html::button('<span class="fa fa-edit"></span> Edit ', ['value'=>Url::to($url_edit_record),
                    // 'class' => 'btn btn-primary btn-sm modalButton ']);
                    // }
                ?>
            </th>

            <?php
                if(Tools::GetPlanTypeCodeByRuc($ruc) == 1)
                {
                    echo "<th class='no_border align_left' colspan='5'> : Php ".number_format($total_lgu_budget,2)."</th>";
                }
                else
                {
                    if(Tools::GetPlanTypeCodeByRuc($ruc) == 2)
                    {
                        if(Tools::GetHasAdditionalLguBudgetByRuc($ruc) == "yes")
                        {
                            echo "<th class='no_border align_left' colspan='5'> : Php ".number_format($total_lgu_budget,2)." <label class='label label-default'>Additional LGU Budget</label></th>";
                        }
                        else
                        {
                            if(Tools::GetHasAdditionalLguBudgetByRuc($ruc) == "no")
                            {
                                echo "<th class='no_border align_left' colspan='5'> : Php ".number_format($total_lgu_budget,2)." <label class='label label-default'>Old LGU Budget</label></th>";
                            }
                            else
                            {
                                echo "<th class='no_border align_left'  colspan='5'> : Php ".number_format($total_lgu_budget,2)." </th>";
                            }
                        }
                    }
                    else
                    {
                        echo "<th class='no_border align_left' colspan='5'> : Php ".number_format($total_lgu_budget,2)."</th>";
                    }
                }
            ?>
        </tr>
        <tr>
            <th class="no_border align_left">PROVINCE 
                <br/><br/>
                <?= !empty($citymun) ? "CITY/MUNICIPALITY" : ""; ?>    
            </th>
            <th class="no_border align_left" colspan="2" style="text-align: left;"> : <?= $province ?>
                <br/><br/>
                 : <?= !empty($citymun) ? $citymun : ""; ?>
            </th>
            <th class="no_border align_left">TOTAL GAD BUDGET</th>
            <?php
                if(Tools::GetPlanTypeCodeByRuc($ruc) == 1) // new plan
                {
                    echo "<th class='no_border align_left' colspan='5'> : Php ".number_format($grand_total,2)."</th>";
                }
                else
                {
                    if(Tools::GetPlanTypeCodeByRuc($ruc) == 2) // supplemental plan
                    {
                        if(Tools::GetHasAdditionalLguBudgetByRuc($ruc) == "yes") // if has additional LGU budget
                        {
                            if($grand_total < $fivePercentTotalLguBudget)
                            {
                                echo "<th class='no_border align_left' style='color:red;' colspan='5'> : Php ".number_format($grand_total,2)." <label class='label label-default'>Supplemental GAD Budget</label></th>";
                            }
                            else
                            {
                                echo "<th class='no_border align_left' colspan='5'> : Php ".number_format($grand_total,2)." <label class='label label-default'>Supplemental GAD Budget</label></th>";
                            }
                        }
                        else
                        {
                            if(Tools::GetHasAdditionalLguBudgetByRuc($ruc) == "no") // if no additional LGU budget
                            {
                                echo "<th class='no_border align_left' colspan='5'> : Php ".number_format($grand_total,2)." <label class='label label-default'>Old GAD Budget</label>";
                                echo "<br/><br/><p> : Php ".(number_format(PlanActions::GetGadBudgetByRuc($ruc),2))." <label class='label label-default'>Supplemental GAD Budget</label></p>";
                                echo "</th>";
                            }
                            else
                            {

                            }
                        }
                    }
                    else // for Revision
                    {
                        echo "<th class='no_border align_left' colspan='5'> : Php ".number_format($grand_total,2);
                        echo "</th>";
                    }
                }
            ?>
        </tr>
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
                </tr>
            <?php } ?>

            <!-- Gender Issue or GAD Mandate -->
            <?php if($not_InnerCategoryId != $plan["inner_category_title"]) { ?>
                <tr class="inner_category_title">
                    <td style="border-top: none;" colspan='5'><b><?= $plan["inner_category_title"] ?></b></td>
                    <td colspan="3" style="border-top: none;"></td>
                    <td  style="border-top:none; border-bottom: none;"></td>
                </tr>
            <?php } ?>

            <tr id="plan_tr_<?= $plan['id'] ?>">
                <td style="white-space: pre-line;"><?= $plan["ppa_value"] ?></td>
                <td style="white-space: pre-line;"><?= $plan["objective"] ?></td>
                <td style="white-space: pre-line;"><?= $plan["relevant_lgu_program_project"] ?></td>
                <td style="white-space: pre-line;"><?= $plan["activity"] ?></td>
                <td style="white-space: pre-line;"><?= $plan["performance_target"] ?></td>
                <td style="text-align: right;"><?= $plan["budget_mooe"] ?></td>
                <td style="text-align: right;"><?= $plan["budget_ps"] ?></td>
                <td style="text-align: right;"><?= $plan["budget_co"] ?></td>
                <td><?= $plan["lead_responsible_office"] ?></td>
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
                    </tr>
                    <tr class='total_a'>
                        <td colspan='5'><b>Total A (MOEE+PS+CO)</b></td>
                        <td colspan='3'>".(number_format($total_a,2))."</td>
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
                    </tr>
                    <tr class='total_b'>
                        <td colspan='5'><b>Total B (MOEE+PS+CO)</b></td>
                        <td colspan='3'>".(number_format($total_b,2))."</td>
                        <td style='border-top:none; border-bottom:none;'></td>
                    </tr>
                    ";
                }
            }
            
            $not_FocusedId = $plan["gad_focused_title"];
            $not_InnerCategoryId = $plan["inner_category_title"];
        } //End of dataClient ?>

        <!-- Start of Attributed Program -->

        <tr class="attributed_program_title" style="border-top: none;">
            <td colspan="5">
                <b>ATTRIBUTED PROGRAMS</b> 
            </td>
            <td colspan="3"></td>
            <td style="border-top: none;"></td>
        </tr>
        
        <tr class="attributed_program_thead">
            <td colspan="2"><b>Title of LGU Program or Project</b></td>
            <td colspan="1"><b>HGDG Design/ Funding Facility/ Generic Checklist Score</b></td>
            <td colspan="2"><b>Total Annual Program/ Project Budget</b></td>
            <td colspan="3"><b>GAD Attributed Program/Project Budget</b></td>
            <td><b>Lead or Responsible Office</b></td>
        </tr>
        <?php 
        $notnull_apPpaValue = null;
        // $total_c = 0;
        $varTotalGadAttributedProBudget = 0;

        foreach ($dataAttributedProgram as $key => $dap) 
        { 
            
            ?>

            <tr class="attributed_program_td" id="attributed_tr_<?= $dap['id'] ?>">
            	<td colspan="2" style="white-space: pre-line;"><?= $dap["lgu_program_project"] ?></td>
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
                <td style="text-align: center;"><?= $dap["hgdg"] ?></td>
               	<td style="text-align: right;" colspan="2"><?= number_format($dap["total_annual_pro_budget"],2) ?></td>
                <td colspan="3" style="text-align: right;"><?= !empty($HgdgMessage) ? $HgdgMessage : number_format($computeGadAttributedProBudget,2) ?>
                </td>
                <td><?= $dap["ap_lead_responsible_office"] ?></td>
            </tr>
        	<?php 
        	$total_c = $varTotalGadAttributedProBudget;
        } 
        ?>
        <tr class="total_c">
            <td><b>Total C</b></td>
            <td colspan="4"></td>
            <td colspan="3"><?= number_format($total_c,2) ?></td>
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
        </tr>
        <tr class="signatory_label">
            <td colspan="2"><b>Prepared by:</b></td>
            <td colspan="3"><b>Approved by:</b></td>
            <td colspan="3"><b>Date:</b></td>
            <td></td>
        </tr>
        <tr class="signatory">
            <?php foreach ($dataRecord as $key => $rec) { ?>
            	<td colspan="2" style="text-align: center; font-size: 17px;"><?= $rec["prepared_by"] ?></td>
                <td colspan="3" style="text-align: center; font-size: 17px;"><?= $rec["approved_by"] ?></td>
                <td colspan="3" style="text-align: center; font-size: 17px;"><?= date('d/m/Y',strtotime($rec["footer_date"])); ?></td>
                <td></td>
            <?php } ?>
        </tr>
        <tr class="signatory_title">
            <td colspan="2">Chairperson, GFPS TWG</td>
            <td colspan="3">Local Chief Executive</td>
            <td colspan="3">DD/MM/YEAR</td>
            <td colspan="1"></td>
        </tr>
	</tbody>
</table>
</div>

<?php
	$this->registerJs("
		window.print();
	");
?>