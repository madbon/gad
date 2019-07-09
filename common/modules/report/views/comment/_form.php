<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use richardfan\widget\JSRegister;

/* @var $this yii\web\View */
/* @var $model common\models\GadComment */
/* @var $form yii\widgets\ActiveForm */
?>
<style> 
    table#comment_list thead tr{
        display:block;
    }

    table#comment_list th,table td{
        width:430px;
    }
    table#comment_list  tbody{
      display:block;
      height:200px;
      overflow:auto;
    }

</style>

<div class="gad-comment-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'plan_budget_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'attribute_name')->hiddenInput()->label(false) ?>

    <div class="row">
        <div class="col-sm-4">
            <h3>SECTION</h3>
            <?= $form->field($model, 'row_no')->textInput() ?>
            <?= $form->field($model, 'row_value')->textarea(['rows' => 3]) ?>
        </div>
        <div class="col-sm-8">
            <h3>OBSERVATION & RECOMMENDATION</h3>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'column_no')->textInput() ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'column_title')->textInput()->label("Column Title") ?>
                </div>
            </div>
            <?= $form->field($model, 'column_value')->textarea(['rows' => 3]) ?>
            <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>
            <div class="form-group pull-right">

                <?= Html::button('Save', ['class' => 'btn btn-success', 'id' => 'saveObservation', 'type' => 'submit']) ?>

                <?php 
                    $url = \yii\helpers\Url::to(['/report/comment/create-comment']);
                    $urlLoadComment = \yii\helpers\Url::to(['/report/comment/load-comment']); 
                ?>
                <?php JSRegister::begin(); ?>
                    <script>
                        $("#gadcomment-comment").keyup(function(){
                            if($.trim($("#gadcomment-comment").val()) == "")
                            {
                                $("#saveObservation").attr("type","submit");
                            }
                            else
                            {
                                $("#saveObservation").attr("type","button");
                            }
                        });

                        $("#saveObservation").click(function(){
                            var row_no = $.trim($("#gadcomment-row_no").val());
                            var row_value = $.trim($("#gadcomment-row_value").val());
                            var column_no = $.trim($("#gadcomment-column_no").val());
                            var column_value = $.trim($("#gadcomment-column_value").val());
                            var column_title = $.trim($("#gadcomment-column_title").val());
                            var attribute_name = $.trim($("#gadcomment-attribute_name").val());
                            var comment = $.trim($("#gadcomment-comment").val());
                            var plan_budget_id = $.trim($("#gadcomment-plan_budget_id").val());

                            if($.trim($("#gadcomment-comment").val()) == "")
                            {

                            }
                            else
                            {
                                $.ajax({
                                    url: "<?= $url ?>",
                                    data: { 
                                            row_no:row_no,
                                            row_value:row_value,
                                            column_no:column_no,
                                            column_value:column_value,
                                            attribute_name:attribute_name,
                                            comment:comment,
                                            plan_budget_id:plan_budget_id,
                                            column_title:column_title
                                        }
                                    }).done(function(result) {
                                        
                                });
                            }
                        });

                        var plan_budget_id2 = $.trim($("#gadcomment-plan_budget_id").val());

                        $.ajax({
                            url: "<?= $urlLoadComment ?>",
                            data: { 
                                    plan_budget_id:plan_budget_id2
                                }
                            }).done(function(data) {
                                $.each(data, function(key, value){
                                    var cols = "";
                                    cols += "<tr>"
                                    cols +=     "<td> Row "+value.row_no+"<br/>"+value.row_value+"</td>";
                                    cols +=     "<td> Column "+value.column_no+". "+value.column_value+"<br/>"+value.comment+"</td>";
                                    cols += "</tr>";
                                    $("#comment_list tbody").append(cols);
                                });
                        });
                    </script>
                <?php JSRegister::end(); ?>
            </div>
        </div>
    </div>   


    <?php ActiveForm::end(); ?>

    
<table class="table table-responsive table-hover" id="comment_list">
    <thead>
        <tr>
            <th style="text-align: center;">SECTION</th>
            <th style="text-align: center;">OBSERVATION & RECOMMENDATION</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
   
</div>
