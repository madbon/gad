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
<tbody>
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
           