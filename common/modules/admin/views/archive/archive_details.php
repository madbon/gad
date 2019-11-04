<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use common\modules\report\controllers\DefaultController;
?>
<h3 class="style"><span class="fa fa-folder"></span> Archived Details</h3>

<div class="cust-panel">
    <div class="cust-panel-header gad-color">
    </div>
    <div class="cust-panel-body">
    	<br/>
    	<div class="table-responsive" style="max-height: 300px; overflow-y: scroll;">
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th>Date Archived / Restored</th>
						<th>Time Archived / Restored</th>
						<th>Remarks</th>
						<th>Status</th>
						<th>Archived By / Restored By</th>
					</tr>
				</thead>
				<tbody>
					<?php
						if(Yii::$app->user->can("SuperAdministrator") || Yii::$app->user->can("gad_admin") || Yii::$app->user->can("Administrator"))
						{
							foreach ($data as $key => $row) {
								echo "
									<tr>
										<td>".(date("F j, Y", strtotime($row['date_created'])))."</td>
										<td>".($row['time_created'])."</td>
										<td>".($row['remarks'])."</td>
										<td>".(DefaultController::DisplayStatus($row['status']))."</td>
										<td>".($row['archiveby_name'])."</td>
										<td> archive by (user id) : ".($row['archiveby_userid'])."</td>
									</tr>
								";
							}
						}
						else
						{
							foreach ($data as $key => $row) {
								echo "
									<tr>
										<td>".(date("F j, Y", strtotime($row['date_created'])))."</td>
										<td>".($row['time_created'])."</td>
										<td>".($row['remarks'])."</td>
										<td>".(DefaultController::DisplayStatus($row['status']))."</td>
										<td>".($row['archiveby_name'])."</td>
									</tr>
								";
							}
						}
					?>
				</tbody>
			</table>
		</div>
    </div>
</div>
