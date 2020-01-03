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
                <td style="text-align: right;"><?= number_format($plan["budget_mooe"],2) ?></td>
                <td style="text-align: right;"><?= number_format($plan["budget_ps"],2) ?></td>
                <td style="text-align: right;"><?= number_format($plan["budget_co"],2) ?></td>
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

<?php
	$this->registerJs("
		window.print();
	");
?>