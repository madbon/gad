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
                    'placeholder' => 'Select PPA Category',
                    'id' => "ppa_attributed_program_id",
                ],
                'pluginEvents'=>[
                    'select2:select'=>'
                        function(){
                            $("#message-ppa_attributed_program_id").text("");
                            $("#select2-ppa_attributed_program_id-container").parent(".select2-selection").css({"border":"1px solid #ccc"});
                            var this_val = this.value;
                            if(this_val == "0")
                            {
                            	$("#div-ppa_attributed_program_others").slideDown(300);
                            }
                            else
                            {
                            	$("#div-ppa_attributed_program_others").slideUp(300);
                            }
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
	            echo $this->render('common_tools/textinput_suggest',[
	                'placeholder_title' => "Specify here (Other PPA Attributed Program)",
	                'attribute_name' => "ppa_attributed_program_others",
	                'urlLoadResult' => '/report/default/load-ppa-attributed-program-others',
	                'classValue' => 'form-control',
	                'customStyle' => 'margin-top:10px;',
	            ]);
	        ?>
        </div>
        <br/>
        <?php
		    echo $this->render('common_tools/textarea_suggest',[
		        'placeholder_title' => "Title of LGU Program or Project",
		        'attribute_name' => "lgu_program_project",
		        'urlLoadResult' => '/report/default/load-lgu-program-project',
		        'rowsValue' => 3,
		        'classValue' => 'form-control',
		        'customStyle' => 'height:88px;',
		    ]);
		?>
    </div>
    <div class="col-sm-4">
		<?php
            echo $this->render('common_tools/textinput_suggest',[
                'placeholder_title' => "HGDG Design/ Funding Facility/ Gender Checklist Score",
                'attribute_name' => "hgdg",
                'urlLoadResult' => '/report/default/load-hgdg',
                'classValue' => 'form-control',
                'customStyle' => '',
            ]);
        ?>
        <br/>
        <?php
            echo $this->render('common_tools/textinput_suggest',[
                'placeholder_title' => "Total Annual Program/ Project Budget",
                'attribute_name' => "total_annual_pro_budget",
                'urlLoadResult' => '/report/default/load-total-annual-pro-budget',
                'classValue' => 'form-control',
                'customStyle' => '',
            ]);
        ?>
        <br/>
        <?php
            echo $this->render('common_tools/textinput_suggest',[
                'placeholder_title' => "GAD Attributed Program/Project Budget",
                'attribute_name' => "attributed_pro_budget",
                'urlLoadResult' => '/report/default/load-attributed-pro-budget',
                'classValue' => 'form-control',
                'customStyle' => '',
            ]);
        ?>
	</div>
	<div class="col-sm-4">
		<?php
		    echo $this->render('common_tools/textarea_suggest',[
		        'placeholder_title' => "Lead or Responsible Office",
		        'attribute_name' => "ap_lead_responsible_office",
		        'urlLoadResult' => '/report/default/load-ap-lead-responsible-office',
		        'rowsValue' => 3,
		        'classValue' => 'form-control',
		        'customStyle' => 'height:88px;',
		    ]);
		?>
		<br/>
		<button id="saveAttributedProgram" type="button" class="btn btn-primary btn-sm">
			<span class="glyphicon glyphicon-floppy-disk"></span> Save
		</button>
		<?php
        $url = \yii\helpers\Url::to(['/report/default/create-pb-attributed-program']);
        $this->registerJs('
            $("#saveAttributedProgram").click(function(){
                var ruc         					= "'.$ruc.'";
                var onstep 							= "'.$onstep.'";
                var ppa_attributed_program_id 		= $("#ppa_attributed_program_id").val();
                var ppa_attributed_program_others 	= $("#ppa_attributed_program_others").val();
                var lgu_program_project 			= $("#lgu_program_project").val();
                var hgdg 							= $("#hgdg").val();
                var total_annual_pro_budget 		= $("#total_annual_pro_budget").val();
                var attributed_pro_budget 			= $("#attributed_pro_budget").val();
                var lead_responsible_office 		= $("#ap_lead_responsible_office").val();
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
                            hgdg:hgdg,
                            total_annual_pro_budget:total_annual_pro_budget,
                            attributed_pro_budget:attributed_pro_budget,
                            lead_responsible_office:lead_responsible_office,
                            controller_id:controller_id,
                            tocreate:tocreate
                        }
                    
                    }).done(function(result) {
                        $.each(result, function( index, value ) {
                            
                            $("p#message-"+index+"").text("");
                            $("textarea#"+index+"").css({"border":"1px solid red"});
                            $("textarea#"+index+"").after("<p id=message-"+index+" style=color:red;font-style:italic;>"+value+"</p>");

                            $("input#"+index+"").css({"border":"1px solid red"});
                            $("input#"+index+"").after("<p id=message-"+index+" style=color:red;font-style:italic;>"+value+"</p>");

                            $("#select2-"+index+"-container").parent(".select2-selection").css({"border":"1px solid red"});
                            $("#select2-"+index+"-container").parent(".select2-selection").after("<p id=message-"+index+" style=color:red;font-style:italic;>"+value+"</p>");

                            // $("#select2-"+index+"-container").text
                            
                            $("textarea#"+index+"").keyup(function(){
                                $("#message-"+index+"").text("");
                                $(this).css({"border":"1px solid #ccc"});
                            });

                            $("input#"+index+"").keyup(function(){
                                $("#message-"+index+"").text("");
                                $(this).css({"border":"1px solid #ccc"});
                            });

                            // if($("#ppa_focused_id").val() == "")
                            // {
                            //     $("#message-ppa_value").hide();
                            // }
                        });
                });
          }); ');
        ?>
		<button id="exitAttributedProgram" type="button" class="btn btn-danger btn-sm">
			<span class="glyphicon glyphicon-remove"></span> Close
		</button>
		<?php
            $this->registerJs("
                $('#exitAttributedProgram').click(function(){
                    $('.attributed_program_form').slideUp(300);
                });
            ");
        ?>
	</div>
</div>