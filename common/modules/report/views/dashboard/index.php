<?php
/* @var $this yii\web\View */
use miloschuman\highcharts\Highcharts;
use miloschuman\highcharts\HighchartsAsset;
use yii\helpers\Html;
?>

<div class="panel panel-default">
	<div class="panel-heading"><p style="font-size: 15px; margin:0px; font-weight: bold; text-transform: uppercase;"><i class="glyphicon glyphicon-stats"></i> LGU<span style="text-transform: lowercase;">s</span> Report Status</p></div>
  	<div class="panel-body">
  		<?php
  		// echo "<pre>";
  		// print_r($product_status); exit;
  			// echo 	Highcharts::widget([
				 //    'htmlOptions' => [
				 //        'style'=> ['height' => '468px']
				 //    ],
			  //     	'options' => [
					//       'title' => ['text' => ''],
					//       'xAxis' => [
					//        		'categories' => $category_status,
					//       	],
					//       	'yAxis' => [
					// 	       'title' => ['text' => ''],
					// 	       'stackLabels' => [
					// 	                  'enabled' => true,
					// 	        ],
					//       	],
					//       'plotOptions' => [
				 //              	'column' => [
				 //                  	'dataLabels' => [
				 //                      'enabled' => true,
				 //                      // 'format' => '{point.y:1f}%',
				 //                  	],
				 //                  	'colorByPoint' => true,
				 //              	]
					//         ],
					//     'series' => $product_status
			  //    	]
			  // 	]);
  		?>

  		<table class="table table-responsive table-hover table-bordered">
	  		<thead>
	  			<tr>
	  				<th style="text-align: center;" class="col-sm-4">REPORT STATUS</th>
	  				<?php if(Yii::$app->user->can("gad_ppdo_permission") || Yii::$app->user->can("gad_province_permission")){ ?>
	  					<th style="text-align: center;" class="col-sm-8">CITY/MUNICIPALITY</th>
	  				<?php }else if(Yii::$app->user->can("gad_region_permission")){ ?>
	  					<th style="text-align: center;" class="col-sm-8">PROVINCE</th>
	  				<?php }else{ ?>
	  					<th style="text-align: center;" class="col-sm-8">REGION</th>
	  				<?php } ?>
	  			</tr>
	  		</thead>
	  		<tbody>
	  			<?php
	  				$notRepStatus = null;
	  				$encoding_process = [];
	  				$for_review = [];
	  				$submit_province = [];
	  				$return_ppdo = [];
	  				$return_lgu_byppdo = [];
	  				$has_endorsed_province = [];
	  				$encoding_process_huc = [];
	  				$encoding_process_prov = [];
	  				$endorse_by_region = [];
	  				$return_by_region = [];
	  				$submit_to_region = [];
		  			foreach ($queryTable as $key => $row) {
		  				if(Yii::$app->user->can("gad_ppdo_permission") || Yii::$app->user->can("gad_province_permission")){
			  				if($row["status_code"] == 0)
			  				{
			  					$encoding_process[] = "<span class='label label-warning'><i class='glyphicon glyphicon-pencil'></i> ".$row['citymun_name']."</span>";
			  				}
			  				else if($row["status_code"] == 1)
			  				{
			  					$for_review[] = "<span class='label label-success'>".$row['citymun_name']."</span>";;
			  				}
			  				else if($row["status_code"] == 2)
			  				{
			  					$submit_province[] = "<span class='label label-info'>".$row['citymun_name']."</span>";;
			  				}
			  				else if($row["status_code"] == 5)
			  				{
			  					$return_ppdo[] = "<span class='label label-danger'>".$row['citymun_name']."</span>";;
			  				}
			  				else if($row["status_code"] == 7)
			  				{
			  					$return_lgu_byppdo[] = "<span class='label label-danger'> ".$row['citymun_name']."</span>";;
			  				}
			  				else if($row["status_code"] == 4)
			  				{
			  					$has_endorsed_province[] = "<span class='label label-primary'>".$row['citymun_name']."</span>";
			  				}
			  			}
			  			else if(Yii::$app->user->can("gad_region_permission")){
			  				if($row["status_code"] == 8) // encoding huc
			  				{
			  					$encoding_process_huc[] = "<span class='label label-warning'><i class='glyphicon glyphicon-pencil'></i> ".$row['province_name']."</span>";
			  				}
			  				else if($row["status_code"] == 9) // encoding province
			  				{
			  					$encoding_process_prov[] = "<span class='label label-warning'><i class='glyphicon glyphicon-pencil'></i> ".$row['province_name']."</span>";
			  				}
			  				else if($row["status_code"] == 10)
			  				{
			  					$endorse_by_region[] = "<span class='label label-primary'>".$row['province_name']."</span>";
			  				}
			  				else if($row["status_code"] == 6)
			  				{
			  					$return_by_region[] = "<span class='label label-danger'>".$row['province_name']."</span>";;
			  				}
			  				else if($row["status_code"] == 3)
			  				{
			  					$submit_to_region[] = "<span class='label label-info'>".$row['province_name']."</span>";;
			  				}

			  			}
			  			else {
			  				if($row["status_code"] == 0)
			  				{
			  					$encoding_process[] = "<span class='label label-warning'><i class='glyphicon glyphicon-pencil'></i> ".$row['region_name']."</span>";
			  				}
			  				else if($row["status_code"] == 1)
			  				{
			  					$for_review[] = "<span class='label label-success'>".$row['region_name']."</span>";;
			  				}
			  				else if($row["status_code"] == 2)
			  				{
			  					$submit_province[] = "<span class='label label-info'>".$row['region_name']."</span>";;
			  				}
			  				else if($row["status_code"] == 5)
			  				{
			  					$return_ppdo[] = "<span class='label label-danger'>".$row['region_name']."</span>";;
			  				}
			  				else if($row["status_code"] == 7)
			  				{
			  					$return_lgu_byppdo[] = "<span class='label label-danger'> ".$row['region_name']."</span>";;
			  				}
			  				else if($row["status_code"] == 4)
			  				{
			  					$has_endorsed_province[] = "<span class='label label-primary'>".$row['region_name']."</span>";
			  				}
			  				else if($row["status_code"] == 8) // encoding huc
			  				{
			  					$encoding_process_huc[] = "<span class='label label-warning'><i class='glyphicon glyphicon-pencil'></i> ".$row['region_name']."</span>";
			  				}
			  				else if($row["status_code"] == 9) // encoding province
			  				{
			  					$encoding_process_prov[] = "<span class='label label-warning'><i class='glyphicon glyphicon-pencil'></i> ".$row['region_name']."</span>";
			  				}
			  				else if($row["status_code"] == 10)
			  				{
			  					$endorse_by_region[] = "<span class='label label-primary'>".$row['region_name']."</span>";
			  				}
			  				else if($row["status_code"] == 6)
			  				{
			  					$return_by_region[] = "<span class='label label-danger'>".$row['region_name']."</span>";;
			  				}
			  				else if($row["status_code"] == 3)
			  				{
			  					$submit_to_region[] = "<span class='label label-info'>".$row['region_name']."</span>";;
			  				}
			  			}
		  			}
		  		?>	

		  		<?php if(Yii::$app->user->can("gad_ppdo_permission") || Yii::$app->user->can("gad_province_permission")){ ?>
			  		<!-- Group by City/Municipality -->
			  		<tr>
			  			<td><i class='glyphicon glyphicon-pencil'></i>  
			  				<?php
			  					echo Html::a('Encoding Process </span>', ['/report/gad-record', 'GadRecordSearch[status]'=> 0, 'report_type' => 'plan_budget' ]);
			  				?>
			  			</td>
			  			<td><?= implode(", ", $encoding_process) ?></td>
			  		</tr>
			  		<tr>
			  			<td>
			  				<i class='glyphicon glyphicon-search'></i> 
			  				<?php
			  					echo Html::a('For Review by PPDO </span>', ['/report/gad-record', 'GadRecordSearch[status]'=> 1, 'report_type' => 'plan_budget' ]);
			  				?>
			  			</td>
			  			<td><?= implode(", ", $for_review) ?></td>
			  		</tr>
			  		<tr>
			  			<td><i class='glyphicon glyphicon-thumbs-up'></i> 
			  				<?php
			  					echo Html::a('Submitted to DILG Province </span>', ['/report/gad-record', 'GadRecordSearch[status]'=> 2, 'report_type' => 'plan_budget' ]);
			  				?>
			  			</td>
			  			<td><?= implode(", ", $submit_province) ?></td>
			  		</tr>
			  		<tr>
			  			<td><i class='glyphicon glyphicon-flag' style="color: red;"></i> 
			  				<?php
			  					echo Html::a('Returned to PPDO by DILG Province </span>', ['/report/gad-record', 'GadRecordSearch[status]'=> 5, 'report_type' => 'plan_budget' ]);
			  				?>
			  			</td>
			  			<td><?= implode(", ", $return_ppdo) ?></td>
			  		</tr>
			  		<tr>
			  			<td><i class='glyphicon glyphicon-flag' style="color:red;"></i>  
			  				<?php
			  					echo Html::a('Returned to LGU by PPDO </span>', ['/report/gad-record', 'GadRecordSearch[status]'=> 7, 'report_type' => 'plan_budget' ]);
			  				?>
			  			</td>
			  			<td><?= implode(", ", $return_lgu_byppdo) ?></td>
			  		</tr>
			  		<tr>
			  			<td><i class='glyphicon glyphicon-flag'></i> 
			  				<?php
			  					echo Html::a('Endorsed by DILG (Province) </span>', ['/report/gad-record', 'GadRecordSearch[status]'=> 4, 'report_type' => 'plan_budget' ]);
			  				?>
			  			</td>
			  			<td><?= implode(", ", $has_endorsed_province) ?></td>
			  		</tr>
		  		<?php } else if(Yii::$app->user->can("gad_region_permission")){ ?>
		  			<!-- Group by Province -->
			  		<tr>
			  			<td><i class='glyphicon glyphicon-pencil'></i>  
			  				<?php
			  					echo Html::a('Encoding Process (HUC/ICC) </span>', ['/report/gad-record', 'GadRecordSearch[status]'=> 8, 'report_type' => 'plan_budget' ]);
			  				?>
			  			</td>
			  			<td><?= implode(", ", $encoding_process_huc) ?></td>
			  		</tr>
			  		<tr>
			  			<td><i class='glyphicon glyphicon-pencil'></i> 
			  				<?php
			  					echo Html::a('Encoding Process (Province) </span>', ['/report/gad-record', 'GadRecordSearch[status]'=> 9, 'report_type' => 'plan_budget' ]);
			  				?>
			  			</td>
			  			<td><?= implode(", ", $encoding_process_prov) ?></td>
			  		</tr>
			  		<tr>
			  			<td><i class='glyphicon glyphicon-thumbs-up'></i> 
			  				<?php
			  					echo Html::a('Submitted to Region </span>', ['/report/gad-record', 'GadRecordSearch[status]'=> 3, 'report_type' => 'plan_budget' ]);
			  				?>
			  			</td>
			  			<td><?= implode(", ", $submit_to_region) ?></td>
			  		</tr>
			  		<tr>
			  			<td><i class='glyphicon glyphicon-flag' style="color: #428bca;"></i>
			  				<?php
			  					echo Html::a('Endorsed by DILG (Region) </span>', ['/report/gad-record', 'GadRecordSearch[status]'=> 10, 'report_type' => 'plan_budget' ]);
			  				?>
			  			</td>
			  			<td><?= implode(", ", $endorse_by_region) ?></td>
			  		</tr>
			  		<tr>
			  			<td><i class='glyphicon glyphicon-flag' style="color:red;"></i>  
			  				<?php
			  					echo Html::a('Returned to LGU by DILG Region </span>', ['/report/gad-record', 'GadRecordSearch[status]'=> 6, 'report_type' => 'plan_budget' ]);
			  				?>
			  			</td>
			  			<td><?= implode(", ", $return_by_region) ?></td>
			  		</tr>
		  		<?php }else{ ?> 
		  			<!-- Group By Region -->
		  			<tr>
		  				<td colspan="2" style="text-align: center; background-color: whitesmoke; font-weight: bold;">LGU CC/M Report Status</td>
		  			</tr>
		  			<tr>
			  			<td><i class='glyphicon glyphicon-pencil'></i>  
			  				<?php
			  					echo Html::a('Encoding Process (CC/M) </span>', ['/report/gad-record', 'GadRecordSearch[status]'=> 0, 'report_type' => 'plan_budget' ]);
			  				?>
			  			</td>
			  			<td><?= implode(", ", $encoding_process) ?></td>
			  		</tr>
			  		<tr>
			  			<td>
			  				<i class='glyphicon glyphicon-search'></i> 
			  				<?php
			  					echo Html::a('For Review by PPDO </span>', ['/report/gad-record', 'GadRecordSearch[status]'=> 1, 'report_type' => 'plan_budget' ]);
			  				?>
			  			</td>
			  			<td><?= implode(", ", $for_review) ?></td>
			  		</tr>
			  		<tr>
			  			<td><i class='glyphicon glyphicon-flag' style="color: red;"></i> 
			  				<?php
			  					echo Html::a('Returned to PPDO by DILG Province </span>', ['/report/gad-record', 'GadRecordSearch[status]'=> 5, 'report_type' => 'plan_budget' ]);
			  				?>
			  			</td>
			  			<td><?= implode(", ", $return_ppdo) ?></td>
			  		</tr>
			  		<tr>
			  			<td><i class='glyphicon glyphicon-flag' style="color:red;"></i>  
			  				<?php
			  					echo Html::a('Returned to LGU by PPDO </span>', ['/report/gad-record', 'GadRecordSearch[status]'=> 7, 'report_type' => 'plan_budget' ]);
			  				?>
			  			</td>
			  			<td><?= implode(", ", $return_lgu_byppdo) ?></td>
			  		</tr>	
			  		<tr>
			  			<td><i class='glyphicon glyphicon-thumbs-up'></i> 
			  				<?php
			  					echo Html::a('Submitted to DILG Province </span>', ['/report/gad-record', 'GadRecordSearch[status]'=> 2, 'report_type' => 'plan_budget' ]);
			  				?>
			  			</td>
			  			<td><?= implode(", ", $submit_province) ?></td>
			  		</tr>
			  		
			  		<tr>
			  			<td><i class='glyphicon glyphicon-flag'></i> 
			  				<?php
			  					echo Html::a('Endorsed by DILG (Province) </span>', ['/report/gad-record', 'GadRecordSearch[status]'=> 4, 'report_type' => 'plan_budget' ]);
			  				?>
			  			</td>
			  			<td><?= implode(", ", $has_endorsed_province) ?></td>
			  		</tr>
			  		<tr>
			  			<td colspan="2" style="text-align: center; background-color: whitesmoke; font-weight: bold;">LGU HUC/Province Report Status</td>
			  		</tr>
			  		<tr>
			  			<td><i class='glyphicon glyphicon-pencil'></i>  
			  				<?php
			  					echo Html::a('Encoding Process (HUC/ICC) </span>', ['/report/gad-record', 'GadRecordSearch[status]'=> 8, 'report_type' => 'plan_budget' ]);
			  				?>
			  			</td>
			  			<td><?= implode(", ", $encoding_process_huc) ?></td>
			  		</tr>
			  		<tr>
			  			<td><i class='glyphicon glyphicon-pencil'></i> 
			  				<?php
			  					echo Html::a('Encoding Process (Province) </span>', ['/report/gad-record', 'GadRecordSearch[status]'=> 9, 'report_type' => 'plan_budget' ]);
			  				?>
			  			</td>
			  			<td><?= implode(", ", $encoding_process_prov) ?></td>
			  		</tr>
			  		<tr>
			  			<td><i class='glyphicon glyphicon-thumbs-up'></i> 
			  				<?php
			  					echo Html::a('Submitted to Region </span>', ['/report/gad-record', 'GadRecordSearch[status]'=> 3, 'report_type' => 'plan_budget' ]);
			  				?>
			  			</td>
			  			<td><?= implode(", ", $submit_to_region) ?></td>
			  		</tr>
			  		<tr>
			  			<td><i class='glyphicon glyphicon-flag' style="color: #428bca;"></i>
			  				<?php
			  					echo Html::a('Endorsed by DILG (Region) </span>', ['/report/gad-record', 'GadRecordSearch[status]'=> 10, 'report_type' => 'plan_budget' ]);
			  				?>
			  			</td>
			  			<td><?= implode(", ", $endorse_by_region) ?></td>
			  		</tr>
			  		<tr>
			  			<td><i class='glyphicon glyphicon-flag' style="color:red;"></i>  
			  				<?php
			  					echo Html::a('Returned to LGU by DILG Region </span>', ['/report/gad-record', 'GadRecordSearch[status]'=> 6, 'report_type' => 'plan_budget' ]);
			  				?>
			  			</td>
			  			<td><?= implode(", ", $return_by_region) ?></td>
			  		</tr>
		  		<?php } ?>
	  		</tbody>
	  	</table>
  	</div>

</div>
