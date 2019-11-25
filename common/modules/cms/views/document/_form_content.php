<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\money\MaskMoney;
use kartik\file\FileInput; 
use kartik\date\DatePicker;
use kartik\checkbox\CheckboxX;
use common\modules\rms\controllers\DynamicViewController;
use common\modules\report\controllers\DefaultController as Tools;
/* @var $this yii\web\View */
/* @var $model common\modules\drugaffectation\models\DrugAffectationBarangay */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
.th-title{
    background:#f7f7f7;
}
.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
    border-top: 0 solid #fff;
    padding-bottom: 0;
}
</style>
<div class="survey-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?php /*"<pre>"; print_r($data); exit;*/ ?>
<div class="row">
    	<div class="col-md-12">
		    <div class="box box-primary">   
		        <!-- <h4>&nbsp;&nbsp;Online Survey</h4> -->
		        <div class="box-body">		 

				    <h3>GAD <?= Tools::GetReportTitle($ruc) ?> FY <?= Tools::GetPlanYear($ruc);  ?> : 
				    	<b><?= !empty(Tools::GetCitymunName($ruc)) ? ucwords(strtolower(Tools::GetCitymunName($ruc))).", " : "" ?> 
				    	<?= ucwords(strtolower(Tools::GetProvinceName($ruc))); ?></b>
				    </h3>
				    <table class="table table-responsive" style="font-size:15px;">
			            <?php $cat = "";
			            foreach($data as $d){ ?>
			            <?php 
			            $req = !empty($d->is_required) && $d->is_required == 2 ? ' <span style="color:red;font-size:18px">*</span> ' : '';
			            ?>
			            	<?php if($cat != $d->category_title) { ?>
				            	<tr style="background:#3c8dbc; color:#000;">
				               		<th colspan="2" style="text-align:left;color:#fff;padding-bottom: 8px; font-size: 20px; font-weight: normal;"><span class="fa fa-file"></span> <?= $d->category_title; ?></th>
				            	</tr>
				            	<tr><th></th></tr>
			            	<?php } ?>
			            <?php 
			                if($d->type_title == "title") { ?>
			                <tr>
			                    <th colspan=3 style="padding-top: 0px;font-size: 18px; white-space: pre-line;"><?= $d->indicator_title; ?>:</th>
			                </tr>
			                <?php } else if($d->type_title == "second-level-title") { ?>
			                <tr>
			                    <th colspan=3 style="padding: 7.5px;color: #4a4a4a; white-space: pre-line;"><?= $d->indicator_title; ?></th>
			                </tr>
			                 <?php } else if($d->type_title == "third-level-title") { ?>
			                <tr>
			                    <th colspan=3 style="padding: 7.5px; font-size:15px; font-weight: normal; color: #4a4a4a; white-space: pre-line;"><?= $d->indicator_title; ?></th>
			                </tr>
			                <?php } else { ?>

			               


			                <tr>
			                    <td> 
			                        <?php if($d->unit_id == 2) { ?>
			                        	<p style=<?= DynamicViewController::QuestionStyle($d->type_title)?>><?= $d->indicator_title.$req; ?></p>
			                            <?= $form->field($data[$d->indicator_id], '['.$d->indicator_id.']value')->textInput(['type' => 'number'])->label(false); ?>
			                        <?php } else if($d->unit_id == 3) { ?>
			                        	<p style=<?= DynamicViewController::QuestionStyle($d->type_title)?>><?= $d->indicator_title.$req; ?></p>
			                            <?= $form->field($data[$d->indicator_id], '['.$d->indicator_id.']value')->widget(MaskMoney::classname(), [
			                                'name' => '['.$d->indicator_id.']value',
			                                'pluginOptions' => [
			                                    'prefix' => 'Php ',
			                                    ],
			                            ])->label(false); ?>
			                        <?php } else if($d->unit_id == 4) { ?>
			                        	<p style=<?= DynamicViewController::QuestionStyle($d->type_title)?>><?= $d->indicator_title.$req; ?></p>
			                            <?= $form->field($data[$d->indicator_id], '['.$d->indicator_id.']value')->textInput(['maxlength' => true])->label(false); ?>
			                        <?php } else if($d->unit_id == 5) { ?>      
			                        	<p style=<?= DynamicViewController::QuestionStyle($d->type_title)?>><?= $d->indicator_title.$req; ?></p>        
			                            <?= $form->field($data[$d->indicator_id], '['.$d->indicator_id.']value')->widget(
			                                        DatePicker::className(), [
			                                            // inline too, not bad
			                                            // 'inline' => true, 
			                                            // modify template for custom rendering
			                                            'pluginOptions' => [
			                                                'autoclose' => true,
			                                                'format' => 'yyyy-mm-dd'
			                                            ]
			                                            ])->label(false); ?>
			                        <?php } else if($d->unit_id == 6) { ?>
			                        	<p style=<?= DynamicViewController::QuestionStyle($d->type_title)?>><?= $d->indicator_title.$req; ?></p>
			                            <?= $form->field($data[$d->indicator_id], '['.$d->indicator_id.']value')->textInput(['maxlength' => true])->label(false); ?>
			                        <?php } else if($d->unit_id == 7) { ?>
			                        	<p style=<?= DynamicViewController::QuestionStyle($d->type_title)?>><?= $d->indicator_title.$req; ?></p>
			                            <?= $form->field($data[$d->indicator_id], '['.$d->indicator_id.']value')->widget(Select2::classname(), [
			                                    'data' => $d->choices,
			                                    'options' => ['placeholder' => ' - ','multiple' => false,'class'=>'with_question-select'],
			                                    'pluginOptions' => [
			                                        'allowClear' => false
			                                    ]
			                                ])->label(false);
			                            ?>
			                            
		                                    <?php if($d->subs){ ?>
		                                        <div id="divSubQuestion<?= $d->indicator_id?>">
		                                        <?php foreach ($data2 as $sub) {
		                                            if($sub->indicator_id == $d->indicator_id){
		                                            	if($sub->type == 2){
		                                                    echo "<b>".$sub->sub_question."</b><br>";
		                                                    echo $form->field($data2['ind'.$d->indicator_id.'sub'.$sub->sub_question_id], '[ind'.$d->indicator_id.'sub'.$sub->sub_question_id.']value')->textInput(['type' => 'number', 'id' => 'sub-'.$sub->indicator_id])->label(false);
		                                                }
		                                                else if($sub->type == 3){
		                                                    echo "<b>".$sub->sub_question."</b><br>";
		                                                    echo $form->field($data2['ind'.$d->indicator_id.'sub'.$sub->sub_question_id], '[ind'.$d->indicator_id.'sub'.$sub->sub_question_id.']value')->widget(MaskMoney::classname(), [
		                                                        'name' => '['.$sub->sub_question_id.']value',
		                                                        'pluginOptions' => [
		                                                            'prefix' => 'Php ',
		                                                            ],
		                                                        'id' => 'sub-'.$sub->indicator_id,
		                                                    ])->label(false);
		                                                }
		                                                else if($sub->type == 4){
		                                                    echo "<b>".$sub->sub_question."</b><br>";
		                                                    echo $form->field($data2['ind'.$d->indicator_id.'sub'.$sub->sub_question_id], '[ind'.$d->indicator_id.'sub'.$sub->sub_question_id.']value')->textInput(['maxlength' => true, 'id' => 'sub-'.$sub->indicator_id])->label(false);
		                                                } else if($sub->type == 5){
		                                                    echo "<b>".$sub->sub_question."</b><br>";
		                                                    echo $form->field($data2['ind'.$d->indicator_id.'sub'.$sub->sub_question_id], '[ind'.$d->indicator_id.'sub'.$sub->sub_question_id.']value')->widget(
		                                                    DatePicker::className(), [
		                                                        'pluginOptions' => [
		                                                            'autoclose' => true,
		                                                            'format' => 'yyyy-mm-dd'
		                                                            ],
		                                                        'id' => 'sub-'.$sub->indicator_id
		                                                        ])->label(false);
		                                                }
		                                                 else if($sub->type == 6){
		                                                	echo "<b>".$sub->sub_question."</b><br>";
		                                                    echo $form->field($data2['ind'.$d->indicator_id.'sub'.$sub->sub_question_id], '[ind'.$d->indicator_id.'sub'.$sub->sub_question_id.']value')->textInput(['id' => 'sub-'.$sub->indicator_id])->label(false);
		                                                } 
		                                                else if($sub->type == 8){
		                                                    echo "<b>".$sub->sub_question."</b><br>";
		                                                    echo $form->field($data2['ind'.$d->indicator_id.'sub'.$sub->sub_question_id], '[ind'.$d->indicator_id.'sub'.$sub->sub_question_id.']value')->textInput(['maxlength' => true, 'id' => 'sub-'.$sub->indicator_id])->label(false);
		                                                } 
		                                                else if($sub->type == 9){
		                                                    echo "<b>".$sub->sub_question."</b><br>";
		                                                    echo $form->field($data2['ind'.$d->indicator_id.'sub'.$sub->sub_question_id], '[ind'.$d->indicator_id.'sub'.$sub->sub_question_id.']value')->textArea(['row' => 2, 'id' => 'sub-'.$sub->indicator_id])->label(false);
		                                                }
		                                                else if($sub->type == 10){
		                                                	echo "<b>Attachment:</b>";
 															echo $form->field($data2['ind'.$d->indicator_id.'sub'.$sub->sub_question_id], "[ind".$d->indicator_id."sub".$sub->sub_question_id."]imageFiles[]")->widget(FileInput::classname(), [
								                                'pluginOptions' => [
								                                    'browseClass' => "btn btn-primary btn-file",
								                                    'showPreview' => true,
								                                    'showCaption' => true,
								                                    'showRemove' => false,
								                                    'showUpload' => false,
								                                    'browseLabel' => 'Browse',
								                                    'maxFileCount' => $contentValue,
									            					'allowedFileExtensions' => $contentExtension,
								                                ],
								                                'options'=>[
								                                    'multiple'=>true,
								                                ],
								                            ])->label(false);
		                                                } 
		                                            }
		                                        } ?>
		                                        </div>

		                                    <?php } ?>

		                                <?php $this->registerJs("
		                                     if($('#value-".$d->indicator_id."-value').val()=='' || $('#value-".$d->indicator_id."-value').val()!='".$d->ans."'){      
		                                        $('#divSubQuestion".$d->indicator_id."').hide();
		                                            $('#sub-".$d->indicator_id."').val('');
		                                     }

		                                    $('#value-".$d->indicator_id."-value').on('change', function(){ 
		                                         if($('#value-".$d->indicator_id."-value').val()=='".$d->ans."'){      
		                                            $('#divSubQuestion".$d->indicator_id."').show();
		                                         }
		                                         else{  
		                                            $('#divSubQuestion".$d->indicator_id."').hide();
		                                            $('#sub-".$d->indicator_id."').val('');
		                                         }
		                                    });
		                                ");

		                                // $this->registerJsFile('js/modal.js',array("dependency"=>"jquery"));
		                                ?>

			                        <?php } else if($d->unit_id == 8) { ?>
		                        			<p><?= $d->indicator_title.$req; ?></p>
			                                <?= $form->field($data[$d->indicator_id], '['.$d->indicator_id.']value')->textInput(['maxlength' => true])->label(false); ?>
			                        <?php } else if($d->unit_id == 9) { ?>
		                        			<p><?= $d->indicator_title.$req; ?></p>
			                                <?= $form->field($data[$d->indicator_id], '['.$d->indicator_id.']value')->textArea(['row' => 2])->label(false); ?>
			                        <?php } else if($d->unit_id == 10) { ?>
		                        		<p><?= $d->indicator_title.$req; ?></p>
			                        	<?php
				                            echo $form->field($data[$d->indicator_id], "[".$d->indicator_id."]imageFiles[]")->widget(FileInput::classname(), [
				                                'pluginOptions' => [
				                                    'browseClass' => "btn btn-primary btn-file",
				                                    'showPreview' => true,
				                                    'showCaption' => true,
				                                    'showRemove' => false,
				                                    'showUpload' => false,
				                                    'browseLabel' => 'Browse',
				                                    'maxFileCount' => $contentValue,
					            					'allowedFileExtensions' => $contentExtension,
				                                ],
				                                'options'=>[
				                                    'multiple'=>true,
				                                ],
				                            ])->label(false);
				                        ?>
			                        <?php } else if($d->unit_id == 11) { ?>
		                        	<?php 
		                        		echo $form->field($data[$d->indicator_id], '['.$d->indicator_id.']value')->widget(CheckboxX::classname(), [		                        			
									    'name'=> 'value-['.$d->indicator_id.']-value',
									    'options'=>['id'=>'value-['.$d->indicator_id.']-value', 'class' => 'cbx cbx-md cbx-active'],
									    'initInputType' => CheckboxX::INPUT_CHECKBOX,							    
									    'pluginOptions' => [									    	
									        'threeState' => false,
									    ],
									    'labelSettings' => [
									    	'label' => $d->indicator_title,
									        'position' => CheckboxX::LABEL_RIGHT
									    ]
									])->label(false);
		                        	?>
			                        <?php } ?>
			                    </td>
			                </tr>
			                <?php }
			                $cat = $d->category_title;
			            } ?>
			        </table>
		        </div>
		    </div>
			<div>
				<div class="btn-group pull-left">
					<?php // Html::a('<span class="glyphicon glyphicon-triangle-left" style="font-size:12px;"></span> Return', ["create"], ['class' => 'btn btn-flat btn-default']) ?>
				</div>
				
				<div class="btn-group pull-right">
					<?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk" style="font-size:12px;"></span> Save ',['class' => 'btn btn-flat btn-success']) ?>
				</div>
			</div>
        </div>
	</div>
    <?php ActiveForm::end(); ?>

</div>
