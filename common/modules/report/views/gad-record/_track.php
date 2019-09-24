<?php

use yii\helpers\Html;
use common\modules\report\controllers\DefaultController;

?>
<h3>Track Report</h3>
<div style='overflow-y:scroll; max-height:300px;'>
	<table class="table table-responsive table-hover table-striped">
		<thead>
			<tr>
				<th>#</th>
				<th>Date</th>
				<th>Details</th>
			</tr>
		</thead>

	<tbody>
		<?php
			$count = 0;
			$not_repeat_date = null;
			foreach ($qry as $key => $row) {
				$count += 1;

				echo "
					<tr>
						<td>".($count)."</td>
						<td>".(date("F j, Y", strtotime(date($row['date_created']))))."</td>
						<td> <b>Remarks :</b> ".($row['remarks'])."
							<br/><br/>
							
							
							<b>Responsible : </b>
							<i style='font-size:12px; color:gray;'> <span class='glyphicon glyphicon-user'></span> ".($row['fullname'])."</i>  &nbsp;
							<i style='font-size:12px; color:gray;'> <span class='glyphicon glyphicon-map-marker'></span> ".($row['office'])." : ".($row['region'])." : ".($row['province'])." : ".($row['citymun'])."</i>
							<br/><br/>
							<b>Report Status : </b> ".(DefaultController::DisplayStatus($row["status"]))."
							<br/><br/>
							<i style='font-size:11px; font-weight:normal; border-radius:10px;' class='label label-default'> <span class='glyphicon glyphicon-time'></span> ".($row['time_created'])."</i> &nbsp;
							<br/><br/>
						</td>
					</tr>
				";
			}
		?>
	</tbody>
	</table>
</div>