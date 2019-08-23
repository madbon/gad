<?php

use yii\helpers\Html;
use common\modules\report\controllers\GadAccomplishmentReportController;
?>
<h3 style="padding-top: 0; margin-top: 0;">Accomplishment Report(s)</h3>
<table class="table table-responsive table-hover">
	<thead>
		<tr>
			<th>CITY/MUNICIPALITY</th>
			<th>TOTAL LGU BUDGET</th>
			<th>TOTAL GAD EXPENDITURE</th>
			<th>YEAR</th>
			<th>PREPARED BY</th>
			<th>APPROVED BY</th>
			<th>Status</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php

			foreach ($qry as $key => $row) {
				$button_attached = "";
				if(Yii::$app->user->can("gad_attach_accomplishment"))
				{
					if($recordOne_attached_ar_record_id == $row['record_id'])
					{
						$button_attached = Html::a('Attached',['/report/default/update-attached-ar','record_id' => $row['record_id'],'ruc' => $ruc,'onstep' => 'to_create_gpb','tocreate' => 'gad_plan_budget'],['class' => 'btn btn-success btn-sm']);
					}
					else
					{
						$button_attached = Html::a('Attach',['/report/default/update-attached-ar','record_id' => $row['record_id'],'ruc' => $ruc,'onstep' => 'to_create_gpb','tocreate' => 'gad_plan_budget'],['class' => 'btn btn-default btn-sm']);
					}
				}
				else
				{
					if($recordOne_attached_ar_record_id == $row['record_id'])
					{
						$button_attached = "<label class='label label-success'>Attached</label>";
					}
					else
					{
						$button_attached = "";
					}
				}



				echo "
				<tr>
					<td>".($row['citymun_name'])."</td>
					<td>".($row['total_lgu_budget'])."</td>
					<td>".(GadAccomplishmentReportController::ComputeAccomplishment($row['ruc']))."</td>
					<td>".($row['year'])."</td>
					<td>".($row['prepared_by'])."</td>
					<td>".($row['approved_by'])."</td>
					<td>".($button_attached)."</td>
					<td>".(Html::a('View Report',['/report/gad-accomplishment-report','ruc' => $row['ruc'], 'onstep' => 'to_create_ar','tocreate' => 'accomp_report'],['class' => 'btn btn-info btn-sm','target' => '_blank']))."</td>
				</tr>
				";
			}
		?>
	</tbody>
</table>