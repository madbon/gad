<?php
/* @var $this yii\web\View */
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
use yii\helpers\Html;
use common\modules\report\controllers\DefaultController as Tools;
?>

<h1>Dashboard</h1>

<table class="table table-bordered table-hover table-striped" style="background-color: white;">
<thead>
	<tr>
		<th>REPORT STATUS</th>
		<th>LGUs</th>
		<th>Go to page</th>
	</tr>
</thead>
<tbody>
	<?php
	$arr = explode(",", $status);

	foreach ($arr as $key_status => $row) {
		
		echo "<tr>
			<td>".(Tools::DisplayStatus($row))."</td>
			<td>".(Tools::GetReportStatusOfLgu($row))."</td>
			<td>".(Html::a('<span class="fa fa-share"></span>', ['/report/gad-record', 'GadRecordSearch[status]'=> $row, 'report_type' => 'plan_budget' ],['target'=>'_blank']))."</td>
		</tr>";	
	}
	?>
</tbody>
</table>