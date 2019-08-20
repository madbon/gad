<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\modules\report\controllers\DefaultController;
use richardfan\widget\JSRegister;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel common\modules\report\models\GadAccomplishmentReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = "Annual GAD Accomplishment Reports";
// $this->params['breadcrumbs'][] = $this->title;
?>

<table class="table ar table-responsive table-bordered" style="border: 1px solid black;">
    <thead>
        <tr>
            <th>Gender Issues or GAD Mandate</th>
            <!-- <th>Cause of the Gender Issue</th> -->
            <th>GAD Objective</th>
            <th>Relevant LGU Program or Project</th>
            <th>GAD Activity</th>
            <th>Performance Indicator and Target</th>
            <!-- <th>Target</th> -->
            <th>Actual Results</th>
            <th>Approved GAD Budget</th>
            <th>Actual Cost or Expenditure</th>
            <th>Variance or Remarks</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $totalClient = 0;
            $totalOrganization = 0;
            foreach ($dataAR as $key => $subt) {
                if($subt["focused_id"] == 1)
                {
                    $totalClient ++;
                }

                if($subt["focused_id"] == 2)
                {
                    $totalOrganization ++;
                }
            }
        ?>
        <?php
            $not_FocusedId = null;
            $not_InnerCategoryId = null;
            $countClient = 0;
            $countOrganization = 0;
            $sum_total_approved_gad_budget = 0;
            $sum_actual_cost_expenditure = 0;
            $total_b = 0;
            $total_a = 0;
            $countRow = 0;
        ?>
        <?php foreach ($dataAR as $key => $ar) { ?>
            <?php
                $countRow += 1;
                if($ar["focused_id"] == 1)
                {
                    $countClient ++;
                }

                if($ar["focused_id"] == 2)
                {
                    $countOrganization ++;
                }
            ?>
            <!-- Client or Organization Focused -->
            <?php if($not_FocusedId != $ar["gad_focused_title"]) { ?>
                <tr class="focused_title">
                    <td colspan='5'><b><?= $ar["gad_focused_title"] ?></b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php } ?>

            <!-- Gender Issue or GAD Mandate -->
            <?php if($not_InnerCategoryId != $ar["inner_category_title"]) { ?>
                <tr class="inner_category_title">
                    <td colspan='5'><b><?= $ar["inner_category_title"] ?></b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php } ?>
            <tr id="ar_tr_id_<?= $ar['id'] ?>">
                <?php
                    $sup_data_value = "";
                    $source_value = "";
                    if(!empty($ar["sup_data"]))
                    {
                        $sup_data_value = "<br/><br/><span style=' font-style:italic; font-weight:bold;'>Supporting Statistics Data : </span><br/> <i style=''>".$ar["sup_data"]."</i>";
                    }

                    if(!empty($ar['source_value']))
                    {
                        $source_value = "<br/><br/><span  style=' font-style:italic; font-weight:bold;'>Source : </span><br/> <i id='content_source".$ar['id']."' style=''>".$ar["source_value"]."</i>";
                    }
                ?>
                <td style="white-space: pre-line;">
                	<?= $ar["ppa_value"] ?>
                </td>
                <td style="white-space: pre-line;">
                	<?= $ar["objective"] ?>
                </td>
                <td style="white-space: pre-line;">
                	<?= $ar["relevant_lgu_ppa"] ?>
                </td>
                <td style="white-space: pre-line;">
                	<?= $ar["activity"] ?>
                </td>
                <td style="white-space: pre-line;">
                	<?= $ar["performance_indicator"] ?>
                </td>
               	<td style="white-space: pre-line;">
               		<?= $ar["actual_results"] ?>
               	</td> 
               	<td style="text-align: right;">
               		<?= number_format($ar["total_approved_gad_budget"],2) ?>
               	</td>
                <td style="text-align: right;">
                	<?= number_format($ar["actual_cost_expenditure"],2) ?>
                </td>
                <td>
                	<?= $ar["variance_remarks"] ?>
                </td>
            </tr>
        <?php 
            if($ar["focused_id"] == 1) // client-focused
            {
                $sum_total_approved_gad_budget   += $ar["total_approved_gad_budget"];
                $total_a   += $ar["actual_cost_expenditure"];
                // $total_a = ($sum_total_approved_gad_budget+$sum_actual_cost_expenditure);
                if($countClient == $totalClient)
                {
                    echo "
                    <tr class='subtotal'>
                        <td colspan='5'><b>Sub-total</b></td>
                        <td></td>
                        <td style='text-align:right;'>
                            <b>".(number_format($sum_total_approved_gad_budget,2))."</b>
                        </td>
                        <td style='text-align:right;'>
                            <b>".(number_format($total_a,2))."</b>
                        </td>
                        <td></td>
                    </tr>
                    <tr class='total_a'>
                        <td colspan='7'><b>Total A (MOEE+PS+CO)</b></td>
                        <td  style='text-align:right;'>".(number_format($total_a,2))."</td>
                        <td></td>
                    </tr>
                    ";
                    $sum_total_approved_gad_budget = 0;
                    $sum_actual_cost_expenditure = 0;
                }
                
            }

            if($ar["focused_id"] == 2) // organization-focused
            {
                $sum_total_approved_gad_budget   += $ar["total_approved_gad_budget"];
                $total_b   += $ar["actual_cost_expenditure"];
                // $total_b = ($sum_total_approved_gad_budget+$sum_actual_cost_expenditure);
                if($countOrganization == $totalOrganization)
                {
                    echo "
                    <tr class='subtotal'>
                        <td colspan='5'><b>Sub-total</b></td>
                        <td></td>
                        <td style='text-align:right;'>
                            <b>".(number_format($sum_total_approved_gad_budget,2))."</b>
                        </td>
                        <td style='text-align:right;'>
                            <b>".(number_format($total_b,2))."</b>
                        </td>
                    </tr>
                    <tr class='total_b'>
                        <td colspan='7'><b>Total B (MOEE+PS+CO)</b></td>
                        <td style='text-align:right;'>".(number_format($total_b,2))."</td>
                    </tr>
                    ";
                }
            }
        ?>
        <?php
            $not_FocusedId = $ar["gad_focused_title"];
            $not_InnerCategoryId = $ar["inner_category_title"];
        ?>
        <?php } ?>
        
        <tr class="ar_attributed_program">
            <td colspan="5">ATTRIBUTED PROGRAMS 
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        
        <tr class="ar_attributed_program_head">
            <td colspan="5">Title of LGU Program or Project</td>
            <td>HGDG PIMME/FIMME Score</td>
            <td>Total Annual Program/ Project Cost or Expenditure</td>
            <td>GAD Attributed Program/Project Cost or Expenditure</td>
            <td>Variance or Remarks</td>
        </tr>
         <?php 
        $notnull_apPpaValue = null;
        $total_c = 0;
        $varTotalGadAttributedProBudget = 0;
        $count_rowAttributedProgram = 0;
        foreach ($dataAttributedProgram as $key => $dap) { 
            $count_rowAttributedProgram +=1;
        ?>
            <tr class="attributed_program_td" id="ar_attrib_tr_id_<?= $dap['id'] ?>">
                <td style="white-space: pre-line;" colspan="5">
                	<?= $dap["lgu_program_project"] ?>
                </td>
                <!-- COMPUTATION OF GAD ATTRIBUTED PROGRAM/PROJECT BUDGET -->
                <?php
                    $varHgdg = $dap["hgdg_pimme"];
                    $varTotalAnnualProCost = $dap["total_annual_pro_cost"];
                    $computeGadAttributedProCost = 0;
                    $HgdgMessage = null;
                    $HgdgWrongSign = "";
                    
                    if((float)$varHgdg < 4) // 0%
                    {
                        // echo "GAD is invisible";
                        $computeGadAttributedProCost = ($varTotalAnnualProCost * 0);
                        $varTotalGadAttributedProBudget += $computeGadAttributedProCost;
                    }
                    else if((float)$varHgdg >= 4 && (float)$varHgdg <= 7.99) // 25%
                    {
                        // echo "Promising GAD prospects (conditional pass)";
                        $computeGadAttributedProCost = ($varTotalAnnualProCost * 0.25);
                        $varTotalGadAttributedProBudget += $computeGadAttributedProCost;
                    }
                    else if((float)$varHgdg >= 8 && (float)$varHgdg <= 14.99) // 50%
                    {
                        // echo "Gender Sensetive";
                        $computeGadAttributedProCost = ($varTotalAnnualProCost * 0.50);
                        $varTotalGadAttributedProBudget += $computeGadAttributedProCost;
                    }
                    else if((float)$varHgdg >= 15 && (float)$varHgdg <= 19.99) // 75%
                    {
                        // echo "Gender-responsive";
                        $computeGadAttributedProCost = ($varTotalAnnualProCost * 0.75);
                        $varTotalGadAttributedProBudget += $computeGadAttributedProCost;
                    }
                    else if((float)$varHgdg == 20) // 100%
                    {
                        // echo "Full gender-resposive";
                        $computeGadAttributedProCost = ($varTotalAnnualProCost * 1);
                        $varTotalGadAttributedProBudget += $computeGadAttributedProCost;
                    }
                    else
                    {
                        $HgdgMessage = "Unable to compute (undefined HGDG Score).";
                        $HgdgWrongSign = "<span class='glyphicon glyphicon-alert' style='color:red;' title='Not HGDG Score Standard'></span>";
                    }
                ?>
                <td style="text-align: center;">
                	<?= $dap["hgdg_pimme"] ?>
                </td>
                <td style="text-align: right;">
                	<?= number_format($dap["total_annual_pro_cost"],2) ?>
                </td>
                <td style="text-align: right;">
                    <?= number_format($computeGadAttributedProCost,2) ?>
                </td>
                <td style="white-space: pre-line;">
                	<?= $dap["ar_ap_variance_remarks"] ?>
                </td>
            </tr>
        <?php 
        $total_c = $varTotalGadAttributedProBudget;
        // $notnull_apPpaValue = $dap["ap_ppa_value"];
        } ?>
        <tr class="total_c">
            <td colspan="7">Total C</td>
            <td style="text-align: right;"><?= number_format($total_c,2) ?></td>
            <td></td>
        </tr>
        <tr class="grand_total">
            <td colspan="7">GRAND TOTAL (A+B+C)</td>
            <td style="text-align: right;">
                <?php
                    $grand_total = 0;
                    $grand_total = ($total_a + $total_b + $total_c);
                    echo number_format($grand_total,2);
                ?>
            </td>
            <td></td>
        </tr>
        <tr class="signatory_label">
            <td colspan="3"><b>Prepared by:</b></td>

            <td colspan="4"><b>Approved by:</b></td>
            <td colspan="4"><b>Date:</b></td>
            <!-- <td></td> -->
        </tr>
        <tr class="signatory">
            <?php foreach ($dataRecord as $key => $rec) { ?>
                <td colspan="3" style="text-align: center; font-size: 17px;"><?= $rec["prepared_by"] ?></td>
                <td colspan="4" style="text-align: center; font-size: 17px;"><?= $rec["approved_by"] ?></td>
                <td colspan="4" style="text-align: center; font-size: 17px;"><?= date('d/m/Y',strtotime($rec["footer_date"])); ?></td>
            <?php } ?>
        </tr>
        <tr class="signatory_title">
            <td colspan="3">Chairperson, GFPS TWG</td>
            <td colspan="4">Local Chief Executive</td>
            <td colspan="4">DD/MM/YEAR</td>
        </tr>
    </tbody>
</table>
           