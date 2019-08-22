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
        /*width:430px;*/
    }
    table#comment_list thead th:nth-child(2)
    {
        width: 100%;
    }
    table#comment_list thead th:first-child
    {
        width: 200px;
        text-align: center;
    }
    table#comment_list tbody td:first-child
    {
        width: 200px;
    }
    table#comment_list tboody td:nth-child(2)
    {
        width: 250px;
    }
    table#comment_list  tbody{
      display:block;
      min-height:200px;
      max-height: 500px;
      overflow:auto;
    }
    div.mess-success
    {
        background-color: #5cb85c;
        color:white;
    }
    div.confirm
    {
        height: 50px;
        width: 100%;     
        border-radius: 2px;   
        padding-top: 15px;
        padding-left: 10px;
    }

</style>

<div class="gad-comment-form">
<div class="confirm" style="display: none;"></div>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'plan_budget_id')->textInput()->label() ?>
    <?= $form->field($model, 'attribute_name')->textInput()->label() ?>
    <?= $form->field($model, 'record_tuc')->textInput()->label() ?>
    <?= $form->field($model, 'record_id')->textInput()->label() ?>
    <?= $form->field($model, 'id')->textInput()->label() ?>

    <div class="row" style="margin-top: -45px;">
        <div class="col-sm-4">
            <h3>
                <?php
                    if(Yii::$app->user->can("gad_letter_endorsement_ppdo"))
                    {
                        echo "City/Municipality PPAs";
                    }
                    else
                    {
                        echo "SECTION";
                    }
                ?>
                
            </h3>
            <?= $form->field($model, 'row_no')->textInput() ?>
            <?= $form->field($model, 'row_value')->textarea(['rows' => 3]) ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Downloadable(s)
                </div>
                <div class="panel-body">

                    <?php 
                        if(Yii::$app->user->can("gad_letter_endorsement_ppdo"))
                        {
                            echo Html::a('<span class="glyphicon glyphicon-download"></span> Letter of Review for PPDO (.docx)',
                            [
                                '/cms/document/download-specific-observation',
                                'ruc' => $ruc,
                                'type' => 'ppdo_letter'
                            ],
                            [
                                'class' => 'btn-link',
                                'title' => 'Download Letter/Certificate'
                            ]);  
                        }

                        echo Html::a('<span class="glyphicon glyphicon-download"></span> Specic Observation and Recommendation (.docx)',
                            [
                                '/cms/document/download-specific-observation',
                                'ruc' => $ruc,
                                'type' => 'specific_observation'
                            ],
                            [
                                'class' => 'btn-link',
                                'title' => 'Download Letter/Certificate'
                            ]);  
                    
                    ?>
                </div>
            </div>
            
        </div>
        <div class="col-sm-8">
            <h3>
                <?php
                    if(Yii::$app->user->can("gad_letter_endorsement_ppdo"))
                    {
                        echo "Inconsistent/not aligned with the Provincial PPAs";
                    }
                    else
                    {
                        echo "SPECIFIC OBSERVATION & RECOMMENDATION";
                    }
                ?>
            </h3>
            <div class="row">
                <div class="col-sm-6">
                    <?= $form->field($model, 'column_no')->textInput() ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'column_title')->textInput()->label("Column Title") ?>
                </div>
            </div>
            <?= $form->field($model, 'column_value')->textarea(['rows' => 3]); ?>
            <?= $form->field($model, 'comment')->textarea(['rows' => 6])->label("Observation & Recommendation <i style='color:red; font-weight:normal;'>(Important Note: Avoid using ampersand(&) in comment box it causes error when downloading .docx)</i>"); ?>

            <div class="form-group pull-right">
                
                <?= Html::button('Save', ['class' => 'btn btn-success', 'id' => 'saveObservation', 'type' => 'submit']) ?>
                <?php 
                    $urlCreate = \yii\helpers\Url::to(['/report/comment/create-comment']);
                    $urlLoadComment = \yii\helpers\Url::to(['/report/comment/load-comment']); 
                    $urlEditComment = \yii\helpers\Url::to(['/report/comment/edit-comment']);
                    $urlUpdate = \yii\helpers\Url::to(['/report/comment/update-comment']); 
                    $urlDelete = \yii\helpers\Url::to(['/report/comment/delete-comment']); 
                ?>
                <?php JSRegister::begin(); ?>
                    <script>

                        var record_tuc = $.trim($("#gadcomment-record_tuc").val());
                        function triggermessage(type,message)
                        {
                            $(".confirm").addClass(type);
                            $(".confirm").text(message);
                            $(".confirm").slideDown(300); 
                            setTimeout(function(){
                                $(".confirm").slideUp(300); 
                            }, 3000);
                        }
                        function loadcomment()
                        {
                            $.ajax({
                                url: "<?= $urlLoadComment ?>",
                                data: { 
                                        record_tuc:record_tuc
                                    }
                                }).done(function(data) {
                                    $("#comment_list tbody").html("");
                                    $.each(data, function(key, value){
                                        var cols = "";
                                        cols += "<tr>"
                                        cols +=     "<td> Row "+value.row_no+"<br/>"+value.row_value+"</td>";
                                        cols +=     "<td style='white-space:pre-line;'> Column "+value.column_no+". ("+value.column_title+") <i>"+value.column_value+"</i> <br/>"+value.comment+"</td>";
                                        cols +=     "<td><button class='btn btn-primary btn-xs' id='editcomment-"+value.comment_id+"'><span class='glyphicon glyphicon-edit'></span></button>";
                                        cols +=     "&nbsp;<button class='btn btn-danger btn-xs' id='deletecomment-"+value.comment_id+"'><span class='glyphicon glyphicon-trash'></span></button></td>";
                                        cols += "</tr>";
                                        $("#comment_list tbody").append(cols);

                                        $("#editcomment-"+value.comment_id+"").click(function(){
                                            var comment_id = value.comment_id;
                                            $.ajax({
                                                url: "<?= $urlEditComment ?>",
                                                data: { 
                                                        comment_id:comment_id
                                                    }
                                                }).done(function(data1) {
                                                    $("#gadcomment-row_no").val(data1.row_no);
                                                    $("#gadcomment-row_value").val(data1.row_value);
                                                    $("#gadcomment-column_no").val(data1.column_no);
                                                    $("#gadcomment-column_title").val(data1.column_title);
                                                    $("#gadcomment-column_value").val(data1.column_value);
                                                    $("#gadcomment-comment").val(data1.comment);
                                                    $("#gadcomment-plan_budget_id").val(data1.plan_budget_id);
                                                    $("#gadcomment-attribute_name").val(data1.attribute_name);
                                                    $("#gadcomment-record_id").val(data1.record_id);
                                                    $("#gadcomment-id").val(data1.id);
                                                    $("#saveObservation").text("Update");
                                            });
                                        });
                                        $("#deletecomment-"+value.comment_id+"").click(function(){
                                            var comment_id = value.comment_id;
                                            if(confirm("Are you sure you want to delete this item?"))
                                            {
                                                $.ajax({
                                                    url: "<?= $urlDelete ?>",
                                                    data: { 
                                                            comment_id:comment_id
                                                        }
                                                    }).done(function(data) {
                                                        triggermessage("mess-success","Observation and Recommendation has been deleted");
                                                        loadcomment();
                                                });
                                            }
                                            else
                                            {
                                                
                                            }
                                        });
                                    });
                            });
                        }

                        loadcomment();

                        $("#gadcomment-comment").keyup(function(){
                            if($.trim($("#gadcomment-comment").val()) == "" || $.trim($("#gadcomment-row_value").val()) == "" || $.trim($("#gadcomment-row_no").val()) == "" || $.trim($("#gadcomment-column_no").val()) == "" || $.trim($("#gadcomment-column_value").val()) == "" || $.trim($("#gadcomment-attribute_name").val()) == "")
                            {
                                $("#saveObservation").attr("type","submit");
                            }
                            else
                            {
                                $("#saveObservation").attr("type","button");
                            }
                        });

                        $("#gadcomment-row_no").keyup(function(){
                            if($.trim($("#gadcomment-comment").val()) == "" || $.trim($("#gadcomment-row_value").val()) == "" || $.trim($("#gadcomment-row_no").val()) == "" || $.trim($("#gadcomment-column_no").val()) == "" || $.trim($("#gadcomment-column_value").val()) == "" || $.trim($("#gadcomment-attribute_name").val()) == "")
                            {
                                $("#saveObservation").attr("type","submit");
                            }
                            else
                            {
                                $("#saveObservation").attr("type","button");
                            }
                        });

                        $("#gadcomment-row_value").keyup(function(){
                            if($.trim($("#gadcomment-comment").val()) == "" || $.trim($("#gadcomment-row_value").val()) == "" || $.trim($("#gadcomment-row_no").val()) == "" || $.trim($("#gadcomment-column_no").val()) == "" || $.trim($("#gadcomment-column_value").val()) == "" || $.trim($("#gadcomment-attribute_name").val()) == "")
                            {
                                $("#saveObservation").attr("type","submit");
                            }
                            else
                            {
                                $("#saveObservation").attr("type","button");
                            }
                        });

                        $("#gadcomment-column_no").keyup(function(){
                            if($.trim($("#gadcomment-comment").val()) == "" || $.trim($("#gadcomment-row_value").val()) == "" || $.trim($("#gadcomment-row_no").val()) == "" || $.trim($("#gadcomment-column_no").val()) == "" || $.trim($("#gadcomment-column_value").val()) == "" || $.trim($("#gadcomment-attribute_name").val()) == "")
                            {
                                $("#saveObservation").attr("type","submit");
                            }
                            else
                            {
                                $("#saveObservation").attr("type","button");
                            }
                        });

                        $("#gadcomment-column_value").keyup(function(){
                            if($.trim($("#gadcomment-comment").val()) == "" || $.trim($("#gadcomment-row_value").val()) == "" || $.trim($("#gadcomment-row_no").val()) == "" || $.trim($("#gadcomment-column_no").val()) == "" || $.trim($("#gadcomment-column_value").val()) == "" || $.trim($("#gadcomment-attribute_name").val()) == "")
                            {
                                $("#saveObservation").attr("type","submit");
                            }
                            else
                            {
                                $("#saveObservation").attr("type","button");
                            }
                        });

                        $("#gadcomment-attribute_name").keyup(function(){
                            if($.trim($("#gadcomment-comment").val()) == "" || $.trim($("#gadcomment-row_value").val()) == "" || $.trim($("#gadcomment-row_no").val()) == "" || $.trim($("#gadcomment-column_no").val()) == "" || $.trim($("#gadcomment-column_value").val()) == "" || $.trim($("#gadcomment-attribute_name").val()) == "")
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
                            var ruc = $.trim($("#gadcomment-record_tuc").val());
                            var id = $.trim($("#gadcomment-id").val());
                            var route = "";

                            if($("#saveObservation").text() == "Save")
                            {
                                route = "<?= $urlCreate ?>";
                            }
                            else
                            {
                                route = "<?= $urlUpdate ?>";
                            }

                            if($.trim($("#gadcomment-comment").val()) == "" || $.trim($("#gadcomment-row_value").val()) == "" || $.trim($("#gadcomment-row_no").val()) == "" || $.trim($("#gadcomment-column_no").val()) == "" || $.trim($("#gadcomment-column_value").val()) == "" || $.trim($("#gadcomment-attribute_name").val()) == "")
                            {
                                $("#saveObservation").attr("type","submit");
                            }
                            else
                            {
                                $.ajax({
                                    type: "POST",
                                    url: route,
                                    data: { 
                                            row_no:row_no,
                                            row_value:row_value,
                                            column_no:column_no,
                                            column_value:column_value,
                                            attribute_name:attribute_name,
                                            comment:comment,
                                            plan_budget_id:plan_budget_id,
                                            column_title:column_title,
                                            id:id,
                                            ruc:ruc
                                        }
                                    }).done(function(result) {
                                        if($("#saveObservation").text() == "Save")
                                        {
                                            triggermessage("mess-success","Observation and Recommend has been saved");
                                        }
                                        else
                                        {
                                            triggermessage("mess-success","Observation and Recommend has been changed");
                                        }
                                        loadcomment();

                                        $("#gadcomment-row_no").val("");
                                        $("#gadcomment-row_value").val("");
                                        $("#gadcomment-column_no").val("");
                                        $("#gadcomment-column_value").val("");
                                        $("#gadcomment-column_title").val("");
                                        $("#gadcomment-attribute_name").val("");
                                        $("#gadcomment-comment").val("");
                                        $("#gadcomment-plan_budget_id").val("");
                                });
                            }
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
            <th style="text-align: center;">
                <?php
                    if(Yii::$app->user->can("gad_letter_endorsement_ppdo"))
                    {
                        echo "City/Municipality PPAs";
                    }
                    else
                    {
                        echo "SECTION";
                    }
                ?>
            </th>
            <th style="text-align: center;">
                <?php
                    if(Yii::$app->user->can("gad_letter_endorsement_ppdo"))
                    {
                        echo "Inconsistent/not aligned with the Provincial PPAs";
                    }
                    else
                    {
                        echo "OBSERVATION & RECOMMENDATION";
                    }
                ?>
            </th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
   
</div>
