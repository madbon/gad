<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\captcha\Captcha;
/* @var $this yii\web\View */
/* @var $model common\modules\drugaffectation\models\DrugAffectationBarangay */
/* @var $form yii\widgets\ActiveForm */
?>
<style type="text/css">

	.glyphicon-lg{font-size:3em}
	.blockquote-box{border-right:5px solid #E6E6E6; border-top: 1px solid #E6E6E6; border-bottom: 1px solid #E6E6E6; border-left: 1px solid #E6E6E6; margin-bottom:25px; border-style: solid;}
	.blockquote-box .square{width:100px;min-height:80px;margin-right:22px;text-align:center!important;background-color:#E6E6E6;padding:20px 0}
	.blockquote-box.blockquote-info{border-color:#46B8DA}
	.blockquote-box.blockquote-info .square{background-color:#5BC0DE;color:#FFF}

	input[type="radio"] {
	    background-color: #fff;
	    background-image: -webkit-linear-gradient(0deg, transparent 20%, hsla(0,0%,100%,.7), transparent 80%),
	                      -webkit-linear-gradient(90deg, transparent 20%, hsla(0,0%,100%,.7), transparent 80%);
	    border-radius: 10px;
	    box-shadow: inset 0 1px 1px hsla(0,0%,100%,.8),
	                0 0 0 1px hsla(0,0%,0%,.6),
	                0 2px 3px hsla(0,0%,0%,.6),
	                0 4px 3px hsla(0,0%,0%,.4),
	                0 6px 6px hsla(0,0%,0%,.2),
	                0 10px 6px hsla(0,0%,0%,.2);
	    cursor: pointer;
	    display: inline-block;
	    height: 15px;
	    margin-right: 15px;
	    position: relative;
	    width: 15px;
	    -webkit-appearance: none;
	}
	input[type="radio"]:after {
	    /*background-color: #444;*/
	    border-radius: 25px;
	    box-shadow: inset 0 0 0 1px hsla(0,0%,0%,.4),
	                0 1px 1px hsla(0,0%,100%,.8);
	    content: '';
	    display: block;
	    height: 7px;
	    left: 4px;
	    position: relative;
	    top: 4px;
	    width: 7px;
	}
	input[type="radio"]:checked:after {
	    background-color: #03274c;
	    box-shadow: inset 0 0 0 1px hsla(0,0%,0%,.4),
	                inset 0 2px 2px hsla(0,0%,100%,.4),
	                0 1px 1px hsla(0,0%,100%,.8),
	                0 0 2px 2px hsla(0,70%,70%,.4);
	}
</style>

<div class="survey-basic-info-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
    <div class="col-md-12">
    <?php if(Yii::$app->user->can('bpls_answer_monitoring_form')){ ?> 
    	<div class="box box-primary">
	      <div class="box-header" style="margin-bottom: -15px">
	        <h4 class=""><strong>Basic Information: </strong></h4>
	      </div><!-- /.box-header -->
	      <div class="box-body">
	      	<div class="row">
	      		<?php if(Yii::$app->user->can('bpls_admin_monitoring_form')){ ?> 
	      		<?php } else if(Yii::$app->user->can('bpls_answer_monitoring_form')){ ?> 
		      		<div class="col-md-12">
		      			Full Name: <strong><?= !empty(Yii::$app->user->identity->userinfo->fullName) ? Yii::$app->user->identity->userinfo->fullName : '' ?></strong> ||
		      			Region: <strong><?= !empty(Yii::$app->user->identity->userinfo->region->region_m) ? Yii::$app->user->identity->userinfo->region->region_m : '' ?></strong> ||
		      			Province / District: <strong><?= !empty(Yii::$app->user->identity->userinfo->province->province_m) ? Yii::$app->user->identity->userinfo->province->province_m : '' ?></strong> || 
		      			City/Municipality: <strong><?= !empty(Yii::$app->user->identity->userinfo->citymun->citymun_m) ? Yii::$app->user->identity->userinfo->citymun->citymun_m : '' ?></strong>
		      		</div>
	      		<?php } else { ?>
		      		<div class="col-md-12">
		      			Full Name: <strong><?= !empty(Yii::$app->user->identity->userinfo->fullName) ? Yii::$app->user->identity->userinfo->fullName : "" ?></strong> ||
		      			Region: <strong><?= empty($model->user->region) ? '' : $model->user->region->region_m; ?></strong> ||
		      			Province / District: <strong><?= empty($model->user->province) ? '' : $model->user->province->province_m; ?></strong> || 
		      			City/Municipality: <strong><?= empty($model->userCitymun->citymun_m) ? '' : $model->userCitymun->citymun_m; ?></strong>
		      		</div>
	      		<?php }?>
	      	</div>    	
	      </div><!-- /.box-body -->
	  	</div><!-- /.box -->
	  <?php } ?>

    	<div class="box box-primary">
	      <div class="box-body">
			        <div class="row">		
			        	<div class="col-md-12">	    
			        	<?php if(!Yii::$app->user->can('bpls_answer_monitoring_form')){ ?>
			        		<h4 class=""><strong>Basic Information: <?= Yii::$app->session['defaultFormRegionName']?></strong></h4>
			        	<?php } ?>
					    <div class="callout callout-info">
							<h4><i class="fa fa-info-circle"></i> Note!</h4>
								<ul>
									<?php if(!Yii::$app->user->can('bpls_answer_monitoring_form')){ ?>
										<li>Please fill up the required <span style="color:red;font-size:18px">*</span> field/s below.</li> 
									<?php } else { ?>
										<li>Please choose the quarter, year and application type.</li> 
									<?php } ?>
								</ul>
						</div>
						</div>
						<?php if(Yii::$app->user->can('bpls_admin_monitoring_form') || Yii::$app->user->isGuest){ ?>
			        	<div class="col-md-12">
					        <?php 
					            $provincesurl = \yii\helpers\Url::to(['/user/province/province-list']);
					            echo empty(Yii::$app->session['regionDefaultForm']) ? $form->field($model, 'region_c')->widget(Select2::classname(), [
					                'data' => $regions,
					                'options' => ['placeholder' => 'Region','multiple' => false,'class'=>'region-select'],
					                'pluginOptions' => [
					                    'allowClear' => count($provinces) > 1 ? true : false,
					                    /*'ajax'=>[
					                                'url'=>$url,
					                                'dataType' => 'json',
					                                'data' => new JsExpression('function(params) { alert(params);}')
					                            ],*/
					                ],
					                'pluginEvents'=>[
					                    'select2:select'=>'
					                        function(){
					                            var vals = this.value;
					                            $.ajax({
					                                url: "'.$provincesurl.'",
					                                data: {region:vals}
					                                
					                            }).done(function(result) {
					                                var h;

					                                /*for(var i=0; i<result.length; i++){
					                                    var id = result[i].id;
					                                    var text = result[i].text;
					                                    h+="<option value=\'"+id+"\' >"+text+"</option>";
					                                }*/
					                               // 
					                               // $("#province-select").select2("destroy");
					                                $(".province-select").html("").select2({ data:result, theme:"krajee", width:"100%",placeholder:"Province",
					                                allowClear: true,});
					                                $(".province-select").select2("val","");
					                            });
					                        }'
					                ]
					            ])->label('Region <span style="color:red;font-size:18px;">*</span>') : "";
					        ?>
					    </div>
			        	<div class="col-md-12">
					        <?php 
					            $citymunsurl = \yii\helpers\Url::to(['/cms/dropdown-json/find-citymun-by-province']);
					            echo empty(Yii::$app->session['regionDefaultForm']) ?  $form->field($model, 'province_c')->widget(Select2::classname(), [
					                'data' => $provinces,
					                'options' => ['placeholder' => 'Province','multiple' => false,'class'=>'province-select'],
					                'pluginOptions' => [
					                    'allowClear' => count($provinces) > 1 ? true : false
					                ],
					                'pluginEvents'=>[
					                    'select2:select'=>'
					                        function(){
					                            var province = this.value;
					                            var region = $("#record-region_c").val();
					                            $.ajax({
					                                url: "'.$citymunsurl.'",
					                                data: {region_c:region, province_c:province}
					                                
					                            }).done(function(result) {
					                                var h;
					                                $(".citymun-select").html("").select2({ data:result, theme:"krajee", width:"100%",placeholder:"City/Municipality",
					                                allowClear: true,});
					                                $(".citymun-select").select2("val","");
					                            });
					                        }'

					                ]
					            ])->label('Province <span style="color:red;font-size:18px;">*</span>') : "";
					        ?>
					    </div>
			        	<div class="col-md-12">
					        <?php 
					            // $barangaysurl = \yii\helpers\Url::to(['/user/barangay/barangay-list']);
					            echo $form->field($model, 'citymun_c')->widget(Select2::classname(), [
					                'data' => $citymuns,
					                'options' => ['placeholder' => 'City/Municipality','multiple' => false,'class'=>'citymun-select'],
					                'pluginOptions' => [
					                    'allowClear' => count($citymuns) > 1 ? true : false
					                ],
					                // 'pluginEvents'=>[
					                //     'select2:select'=>'
					                //         function(){
					                //             var vals = this.value;
					                //             var prov = document.getElementById("drugaffectationbarangay-province_c").value;
					                //             $.ajax({
					                //                 url: "'.$barangaysurl.'",
					                //                 data: {citymun:vals, province:prov}
					                                
					                //             }).done(function(result) {
					                //                 var h;
					                //                 $(".barangay-select").html("").select2({ data:result, theme:"krajee", width:"100%",placeholder:"Barangay",
					                //                 allowClear: true,});
					                //                 $(".barangay-select").select2("val","");
					                //             });
					                //         }'
					                // ]
					            ])->label('City/Municipality <span style="color:red;font-size:18px;">*</span>');
					            echo $form->field($model, 'new_citymun_c')->hiddenInput(['maxlength' => true, 'class' => 'new-citymun_c-text'])->label(false);
					        ?>
					    </div>
						<?php } ?>
					</div>

			        <div class="row">
						<?php if(Yii::$app->user->can('bpls_answer_monitoring_form')){ ?>
							<div class="col-md-6">
								<?= $form->field($model, 'quarter')->dropDownList(['1' => '1st', '2' => '2nd', '3' => '3rd', '4' => '4th'],['prompt'=>'Select Quarter...'])->label('Quarter <span style="color:red;font-size:18px;">*</span>'); ?>
							</div>
							<div class="col-md-6">
								<?= $form->field($model, 'year')->dropDownList([date('Y') => date('Y'), date('Y')-1 => date('Y')-1],['prompt'=>'Select Year...'])->label('Quarter <span style="color:red;font-size:18px;">*</span>')->label('Year <span style="color:red;font-size:18px;">*</span>'); ?>
							</div>
						<?php } ?>
						<?php if(!Yii::$app->user->can('bpls_answer_monitoring_form')){ ?>
						<div class="col-md-12">
			        		<?= $form->field($model, 'business_name')->textInput(['maxlength' => true, 'placeholder' => "Exact Registered Owner's Name / Company Name"])->label("Owner's Name / Company Name<span style='color:red;font-size:18px;'> *</span>"); ?>
			        	</div> 
			        	<div class="col-md-12">
			        		<?= $form->field($model, 'application_no')->textInput(['maxlength' => true, 'placeholder' => 'Permit No. '])->label('Permit No. <span style="color:red;font-size:18px;">*</span>'); ?>
			        	</div> 
			        	
			        	<div class="col-md-12">
		                    <?= $form->field($model, 'application_date')->widget(
		                        DatePicker::className(), [
		                            'name' => 'date_filed', 
		                            'value' => date('yyyy-mm-dd'),
		                            'type' => DatePicker::TYPE_COMPONENT_APPEND,
		                            'options' => ['placeholder' => 'Select Date'],
		                            'pluginOptions' => [
		                                'format' => 'yyyy-mm-dd',
		                                'autoclose'=>true,
		                                'todayHighlight' => true
		                            ]
		                        ])->label('Application Date (YYYY-MM-DD) <span style="color:red;font-size:18px;">*</span>');
		                    ?>
			        	</div> 
			        	<div class="col-md-12">
			        		<?= $form->field($model, 'tin')->textInput(['maxlength' => true,'placeholder' => 'DTI/SEC/CDA No.'])->label('DTI/SEC/CDA No. <span style="color:red;font-size:18px;">*</span>'); ?>
			        	</div>    
			        	<div class="col-md-4">
			        		<?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'placeholder' => 'First Name'])->label("Applicant's Name (optional)"); ?>
			        	</div>
			        	<div class="col-md-4">
			        		<?= $form->field($model, 'middle_name')->textInput(['maxlength' => true, 'placeholder' => 'Middle Name'])->label("&nbsp;"); ?>	
			        	</div>
			        	<div class="col-md-4">
			        		<?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'placeholder' => 'Last Name'])->label("&nbsp;"); ?>
			        	</div>			        	
						<?php } ?>		
						<div class="col-md-12">
					        <div class="row">
					        	<div class="col-md-12 ">
					        		<label class="radio-head">Application Type: <span style="color:red;font-size:18px;">*</span></label>
					        		<?=
				                    $form->field($model, 'form_type')
				                        ->radioList(
				                            $categories,
				                            [
				                                'item' => function($index, $label, $name, $checked, $value) {
				                                	$checked= '';
				                                	$session = Yii::$app->session;
				                                	if(!empty($session['createdData'])){
				                                		$checked = $value == $session['createdData']['form_type'] ? 'checked' : '';
				                                	}
				                                    $return = '<label class="modal-radio" style="margin-left:30px;cursor:pointer;">';
				                                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" tabindex="3" class="" '.$checked.'>';
				                                    $return .= '<i></i>';
				                                    $return .= '<span>&nbsp;' . ucwords(strtoupper($label)) . '</span>';
				                                    $return .= '</label><br>';
				                                    $checked = 2;
				                                    return $return;
				                                }
				                            ]
				                        )
				                    ->label(false); ?>
					        	</div>
					        	<?php if(!Yii::$app->user->can('bpls_answer_monitoring_form')){ ?>
					        	<div class="col-md-12">
					        		<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
									    'captchaAction' => '/rms/dynamic-view/captcha'
									])->label('Verify Code <span style="color:red;font-size:18px;">*</span>') ?>
					        	</div>
					        	<?php } ?>
					        </div>

						    <div class="form-group pull-right">
						        <?= Html::submitButton('Next Step <span class="glyphicon glyphicon-triangle-right" style="font-size:12px;"></span>', ['class' => 'btn btn-flat btn-primary']) ?>
						    </div>
					    </div>
			        </div>      	
	      </div><!-- /.box-body -->
	  	</div><!-- /.box -->
  	</div>

    	<div class="col-md-6">
	  	</div>

    	</div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
if(Yii::$app->user->can('bpls_admin_monitoring_form') || Yii::$app->user->isGuest){
$this->registerJs("		
		if($('#record-region_c').val()!=null){
            var vals = $('#record-region_c').val();
            $.ajax({
                url: '".$provincesurl."',
                data: {region:vals}
                
            }).done(function(result) {
                var h;
                $('.province-select').html('').select2({ data:result, theme:'krajee', width:'100%',placeholder:'Province',
                allowClear: true,});
                $('.province-select').select2('val','');
            	$('#record-province_c').val('".$model->province_c."').trigger('change');
            });
		}
		setTimeout(function(){ 			
			if($('#record-province_c').val()!=null){	
	            var vals = $('#record-province_c').val();
	            var vals2 = $('#record-region_c').val();
	            $.ajax({
	                url: '".$citymunsurl."',
	                data: {region_c:vals2, province_c:vals}
	                
	            }).done(function(result) {
	                var h;
	                $('.citymun-select').html('').select2({ data:result, theme:'krajee', width:'100%',placeholder:'City/Municipality',
	                allowClear: true,});
	                $('.citymun-select').select2('val','');
	            	$('#record-citymun_c').val('".$model->citymun_c."').trigger('change');
	            });
			}
		; }, 200);

        if($('#record-form_type').val()==''){      
            $('#divAppType').hide();
        }

        $('#record-form_type').on('click', function(){ 
             if($('#record-form_type').val()=='18'){      
                $('#divAppType').show();
             }
             else{  
                $('#divAppType').hide();
             }
        });

        $(document).ready(function() {
            $('#record-verifycode-image').trigger('click');
        });
");
}
// $this->registerJsFile('js/modal.js',array("dependency"=>"jquery"));

?>
