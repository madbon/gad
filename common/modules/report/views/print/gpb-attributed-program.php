<?php
/* @var $this yii\web\View */
?>
<table class="table table-responsive table-bordered gad-plan-budget">

    <tbody>
        <!-- CLIENT-FOCUSED -->
       

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
        $total_c = 0;
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
            <td colspan="1">Total C</td>
            <td colspan="4"></td>
            <td colspan="3" style="text-align: right;"><?= number_format($total_c,2) ?></td>
            <td></td>
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

<?php
	$this->registerJs("
		window.print();
	");
?>