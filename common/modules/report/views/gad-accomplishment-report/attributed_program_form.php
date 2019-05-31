<?php
use yii\helpers\Html;
use kartik\select2\Select2;
?>

 <div class="row">
    <div class="col-sm-4">
    	<?php
            $urlLoadPpaCategory = \yii\helpers\Url::to(['/report/default/load-ppa-category']);
            echo Select2::widget([
                'name' => 'ppa_attributed_program_id',
                'data' => $select_PpaAttributedProgram,
                'options' => [
                    'placeholder' => 'Tag PPA Sectors',
                    'id' => "ppa_attributed_program_id",
                    'multiple' => true,
                ],
                'pluginEvents'=>[
                    'select2:select'=>'
                        function(){
                            
                        }',
                ]     
            ]);
            $this->registerJs('
            	var newOption = $("<option>");
            	newOption.attr("value","0").text("Others");
                $("#ppa_attributed_program_id").append(newOption);
            ');
        ?>
        <div id="div-ppa_attributed_program_others" style="display:none;">
	        <?php
	            echo $this->render('/gad-plan-budget/common_tools/textinput_suggest',[
	                'placeholder_title' => "Specify here (Other PPA Attributed Program)",
	                'attribute_name' => "ppa_attributed_program_others",
	                'urlLoadResult' => '/report/default/load-ar-ppa-attributed-program-others',
	                'classValue' => 'form-control',
	                'customStyle' => 'margin-top:10px;',
	            ]);
	        ?>
        </div>
        <br/>
        <?php
		    echo $this->render('/gad-plan-budget/common_tools/textarea_suggest',[
		        'placeholder_title' => "Title of LGU Program or Project",
		        'attribute_name' => "lgu_program_project",
		        'urlLoadResult' => '/report/default/load-ar-lgu-program-project',
		        'rowsValue' => 3,
		        'classValue' => 'form-control',
		        'customStyle' => 'height:88px;',
		    ]);
		?>
    </div>
    <div class="col-sm-4">
		<?php
            echo $this->render('/gad-plan-budget/common_tools/textinput_suggest',[
                'placeholder_title' => "HGDG PIMME/ FIMME Score",
                'attribute_name' => "hgdg_pimme",
                'urlLoadResult' => '/report/default/load-ar-hgdg-pimme',
                'classValue' => 'form-control',
                'customStyle' => '',
            ]);
        ?>
        <br/>
        <?php
            echo $this->render('/gad-plan-budget/common_tools/textinput_suggest',[
                'placeholder_title' => "Total Annual Program/ Project Cost or Expenditure",
                'attribute_name' => "total_annual_pro_cost",
                'urlLoadResult' => '/report/default/load-ar-total-annual-pro-cost',
                'classValue' => 'form-control',
                'customStyle' => '',
            ]);
        ?>
        <br/>
        <?php
            // echo $this->render('/gad-plan-budget/common_tools/textinput_suggest',[
            //     'placeholder_title' => "GAD Attributed Program/Project Cost or Expenditure",
            //     'attribute_name' => "gad_attributed_pro_cost",
            //     'urlLoadResult' => '/report/default/load-ar-attributed-pro-cost',
            //     'classValue' => 'form-control',
            //     'customStyle' => '',
            // ]);
        ?>
	</div>
	<div class="col-sm-4">
		<?php
		    // echo $this->render('/gad-plan-budget/common_tools/textarea_suggest',[
		    //     'placeholder_title' => "Variance or Remarks",
		    //     'attribute_name' => "variance_remarks",
		    //     'urlLoadResult' => '/report/default/load-ap-lead-responsible-office',
		    //     'rowsValue' => 3,
		    //     'classValue' => 'form-control',
		    //     'customStyle' => 'height:88px;',
		    // ]);
		?>
        <textarea rows="2" class="form-control" id="ar_ap_variance_remarks" placeholder="Variance or Remarks"></textarea>
		<br/>
		<button id="saveAttributedProgram" type="button" class="btn btn-primary btn-sm">
			<span class="glyphicon glyphicon-floppy-disk"></span> Save
		</button>
		<?php
        $url = \yii\helpers\Url::to(['/report/default/create-ar-attributed-program']);
        $this->registerJs('
            $("#saveAttributedProgram").click(function(){
                var ruc         					= "'.$ruc.'";
                var onstep 							= "'.$onstep.'";
                var ppa_sectors                     = $("#ppa_attributed_program_id").val();
                var ppa_attributed_program_id       = ppa_sectors.toString();
                var ppa_attributed_program_others 	= $("#ppa_attributed_program_others").val();
                var lgu_program_project 			= $("#lgu_program_project").val();
                var hgdg_pimme 					    = $("#hgdg_pimme").val();
                var total_annual_pro_cost 		    = $("#total_annual_pro_cost").val();
                var ar_ap_variance_remarks 		        = $("#ar_ap_variance_remarks").val();
                var controller_id					= "'.(Yii::$app->controller->id).'";
                var tocreate                        = "'.$tocreate.'";
                $.ajax({
                    url: "'.$url.'",
                    data: { 
                            ruc:ruc,
                            onstep:onstep,
                            ppa_attributed_program_id:ppa_attributed_program_id,
                            ppa_attributed_program_others:ppa_attributed_program_others,
                            lgu_program_project:lgu_program_project,
                            hgdg_pimme:hgdg_pimme,
                            total_annual_pro_cost:total_annual_pro_cost,
                            ar_ap_variance_remarks:ar_ap_variance_remarks,
                            controller_id:controller_id,
                            tocreate:tocreate
                        }
                    
                    }).done(function(result) {
                        $.each(result, function( index, value ) {
                            
                            // error in select2
                            $("p#messages2-"+index+"").text("");
                            $("#"+index+"").next("span").css({"border":"1px solid red","border-radius":"5px"});
                            $("#"+index+"").next("span").after("<p id=messages2-"+index+" style=color:red;font-style:italic;>"+value+"</p>");
                            // error in textarea
                            $("p#messageta-"+index+"").text("");
                            $("textarea#"+index+"").css({"border":"1px solid red"});
                            $("textarea#"+index+"").after("<p id=messageta-"+index+" style=color:red;font-style:italic;>"+value+"</p>");
                            // error in textbox
                            $("p#messagete-"+index+"").text("");
                            $("input#"+index+"").css({"border":"1px solid red"});
                            $("input#"+index+"").after("<p id=messagete-"+index+" style=color:red;font-style:italic;>"+value+"</p>");

                            // keypress remove error message
                            $("textarea#"+index+"").keyup(function(){
                                $("#messageta-"+index+"").text("");
                                $(this).css({"border":"1px solid #ccc"});
                            });

                            $("input#"+index+"").keyup(function(){
                                $("#messagete-"+index+"").text("");
                                $(this).css({"border":"1px solid #ccc"});
                            });
                        });
                });
          }); ');
        ?>
		<button id="exitAttributedProgram" type="button" class="btn btn-danger btn-sm">
			<span class="glyphicon glyphicon-remove"></span> Close
		</button>
		<?php
            $urlSetSession = \yii\helpers\Url::to(['default/session-encode']);
            $this->registerJs("
                $('#exitAttributedProgram').click(function(){
                    var trigger = 'close';
                    var form_type = 'attribute';
                    var report_type = 'ar';
                    $.ajax({
                        url: '".$urlSetSession."',
                        data: { 
                                trigger:trigger,
                                form_type:form_type,
                                report_type:report_type
                                }
                        
                        }).done(function(result) {
                            $('#attributed_program_anchor').slideUp(300);
                    });
                });
            ");
        ?>
	</div>
</div>