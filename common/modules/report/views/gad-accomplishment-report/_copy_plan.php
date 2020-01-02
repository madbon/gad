<?php

use yii\helpers\Html;
use common\modules\report\controllers\DefaultController as Tools;
use common\modules\report\controllers\GadPlanBudgetController;
?>

<div class="table-responsive">
	<table class="table table-responsive">
		<thead>
			<tr>
				<!-- <th>Province</th>
				<th>City/Municipality</th> -->
				<th></th>
				<th>Plan Type</th>
				<th>Year</th>
				<th>Total LGU Budget</th>
				<th>Total GAD Budget</th>
				<th>Status</th>
				<th>Approved By</th>
				<th>Prepared By</th>
				<th>Date Processed</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
				$count_rows = 0;
				if(!empty($query))
				{
					foreach ($query as $key => $row) {
						echo "
						<tr>
							<td>".(Html::a('Copy Insert',[
								'copy-insert-plan',
								'ruc' => $ruc,
								'onstep' => $onstep, 
								'tocreate' => $tocreate, 
								'selected_plan_ruc' => $row['ruc']
							],
							[
	                          'class' => 'btn btn-sm btn-default',
	                          'data' => [
	                              'confirm' => 'Are you sure you want to copy this GAD Plan and Budget and insert to Accomplishment Report?',
	                              'method' => 'post']
	                        ]))."</td>
	                        <td>".(Tools::GetPlanTypeLabel($row['plan_type_code']))."</td>
							<td>".($row['year'])."</td>
							<td> Php ".(number_format($row['total_lgu_budget'],2))."</td>
							<td>".(GadPlanBudgetController::ComputeGadBudget($row['ruc']))."</td>
							<td>".(Tools::DisplayStatus($row["status"]))."</td>
							<td>".($row['approved_by'])."</td>
							<td>".($row['prepared_by'])."</td>
							<td>".(date("F j, Y", strtotime($row['footer_date'])))."</td>
						</tr>
						";
					}
				}
				else
				{
					echo "<tr><td colspan='8' style='color:red;'>No endorsed plan found..</td></tr>";
				}
				
			?>
		</tbody>
	</table>
</div>