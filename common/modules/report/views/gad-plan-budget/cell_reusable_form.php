<?php

use yii\helpers\Html;
use common\modules\report\controllers\DefaultController;
?>
<?php if(DefaultController::countComment2($controller_id,$form_id,$row_id,$attribute_name) > 0) { ?>
<td style="<?= $customStyle ?>" title="<?= $column_title ?>" colspan="<?= $colspanValue ?>" id="cell-<?= $attribute_name ?>-<?= $row_id ?>" class="common-cell-container has-comment"> <!-- put border if has comment  -->
<?php } else{ ?>
<td style="<?= $customStyle ?>" title="<?= $column_title ?>" colspan="<?= $colspanValue ?>" id="cell-<?= $attribute_name ?>-<?= $row_id ?>" class="common-cell-container"> <!-- remove border if no comment  -->
<?php } ?>

    <p id="confirm-<?= $attribute_name ?>-<?= $row_id ?>" class="confirm-message"> <!-- confirmation message update click update  -->
       <i></i> <span></span>
    </p>
    <p id="confirm-<?= $attribute_name ?>-comment-<?= $row_id ?>" class="confirm-message"> <!-- confirmation message after comment  -->
        <i></i> <span id="comment_return_value-<?= $attribute_name ?>-<?= $row_id ?>"></span>
    </p>

    <?php if($data_type == "number") { ?>
        <p style="<?= $customStyle ?> white-space: pre-line;" id="content-<?= $attribute_name ?>-<?= $row_id ?>">
            <?= number_format($cell_value,2) ?>  <!-- Display the content of attribute or cell value -->
            <div id="actn-btns-<?= $attribute_name ?>-<?= $row_id?>" class="actn-btn-bubble actn-buble-common-class" style="display: none;">
                <button id="btn-select-<?= $attribute_name ?>-<?= $row_id?>" type="button" class="btn btn-info btn-xs btn-select-cell" >
                    Select
                </button>
            </div>
        </p>
    <?php } else{ ?>
        <p style="<?= $customStyle ?> white-space: pre-line;" id="content-<?= $attribute_name ?>-<?= $row_id ?>">
            <?= $cell_value ?>  <!-- Display the content of attribute or cell value -->
            <div id="actn-btns-<?= $attribute_name ?>-<?= $row_id?>" class="actn-btn-bubble actn-buble-common-class" style="display: none;">
                <button id="btn-select-<?= $attribute_name ?>-<?= $row_id?>" type="button" class="btn btn-info btn-xs btn-select-cell" >
                    Select
                </button>
            </div>
        </p>
        
        <?php
            $this->registerJs("
                var res = `".$cell_value."`.replace(/--/g, '<span class=bullet>&#8226</span>');
                $('p#content-".$attribute_name."-".$row_id."').html(res);
                $('.confirm-message').click(function(){
                    $(this).hide();
                });
            ");
        ?>
    <?php } ?>

    <?php
        $this->registerJs('
            $("#cell-'.$attribute_name.'-'.$row_id.'").mouseover(function(){
                var attr_name = "'.$attribute_name.'";
                $(".actn-buble-common-class").hide();

                if($(this).hasClass("active-cell")) // if td.active cell has class  .active-cell hide button select
                {
                    $("#actn-btns-"+attr_name+"-'.$row_id.'").hide();
                }
                else
                {
                    $("#actn-btns-"+attr_name+"-'.$row_id.'").show();
                }
            });

            $("#btn-select-'.$attribute_name.'-'.$row_id.'").click(function(){
                var attr_name = "'.$attribute_name.'";
                var enableComment = "'.$enableComment.'";
                var enableEdit = "'.$enableEdit.'";

                $(".common-cell-container").removeClass("active-cell"); // remove other .active-cell if not active
                $("#cell-"+attr_name+"-'.$row_id.'").addClass("active-cell"); // add class .active-cell if active

                $(".common-cell-container").css({"background-color":"white"});
                $("#cell-"+attr_name+"-'.$row_id.'").css({"background-color":"skyblue"}); // active-color

                if(enableEdit == "true")
                {

                    $(".btn-edit-cell").hide(); // hide btn edit if not active cell
                    $("#btn-edit-"+attr_name+"-'.$row_id.'").show(); // if active show btn edit
                }
                else 
                {
                    $(".btn-edit-cell").hide();
                }
                
                if(enableComment == "true")
                {
                    $(".btn-comment-cell").hide(); // hide btn comment if not active cell
                    $(".btn-view-comment-common").hide();
                    $("#btn-comment-"+attr_name+"-'.$row_id.'").show(); // if active show btn common
                    var countComment = '.(DefaultController::countComment2($controller_id,$form_id,$row_id,$attribute_name)).';
                    if(countComment > 0)
                    {
                        $("#btn-view-comment-"+attr_name+"-'.$row_id.'").show(); // if active show btn common
                    }
                }
                else
                {
                    $(".btn-comment-cell").hide(); // hide btn comment if not active cell
                    $(".btn-view-comment-common").hide();
                }
                

                if($("#cell-"+attr_name+"-'.$row_id.'").hasClass("active-cell")) // if td.active cell has class  .active-cell hide button select
                {
                    $("#actn-btns-"+attr_name+"-'.$row_id.'").hide();
                    $(".div-tooltip-form").slideUp(300); // hide tooltip form if not active cell
                }
                else
                {
                    $("#actn-btns-"+attr_name+"-'.$row_id.'").show();
                }
            });
        ');
    ?>
    <!-- button edit and textarea -->
        <button id="btn-edit-<?= $attribute_name ?>-<?= $row_id?>" type="button" class="btn btn-primary btn-xs btn-edit-cell" title="Edit"  style="display: none;">
            <span class="glyphicon glyphicon-edit"></span>
        </button>
        <?php
            $this->registerJs('
                $("#btn-edit-'.$attribute_name.'-'.$row_id.'").click(function(){
                    var attr_name = "'.$attribute_name.'";
                    var cell_value =  $("#content-"+attr_name+"-'.$row_id.'").text();
                    $(".div-tooltip-form").hide();
                    
                    $("#txt-edit-'.$attribute_name.'-'.$row_id.'").val(`'.$cell_value.'`);
                    $("#div-edit-"+attr_name+"-'.$row_id.'").slideDown(300);

                    
                });
            ');
        ?>
        <div id="div-edit-<?= $attribute_name ?>-<?= $row_id ?>" class="bubble div-tooltip-form unik-div-tooltip-form-<?= $row_id ?>">
            <textarea id="txt-edit-<?= $attribute_name ?>-<?= $row_id ?>" rows="3" class="form-control tooltip-form"></textarea>
            <button id="btn-upd8-<?= $attribute_name ?>-<?= $row_id ?>" type="button" class="btn btn-xs btn-default upd8-button pull-left ">
                <span class="glyphicon glyphicon-floppy-disk"></span> Update
            </button>
            <button id="btn-ext-<?= $attribute_name ?>-<?= $row_id ?>" type="button" class="btn btn-xs btn-danger pull-right exit-button">
                <span class="glyphicon glyphicon-remove"></span> Close
            </button>
            
            <?php

                $this->registerJs('
                    $("#btn-upd8-'.$attribute_name.'-'.$row_id.'").click(function(){
                        var attr_name = "'.$attribute_name.'";
                        var uid = '.$row_id.';
                        var upd8_value = $("#txt-edit-'.$attribute_name.'-'.$row_id.'").val();
                        $.ajax({
                            url: "'.$urlUpdateAttribute.'",
                            data: { 
                                    uid:uid,
                                    upd8_value:upd8_value
                                    }
                            
                            }).done(function(result) {
                                if(result != upd8_value)
                                {
                                    $("#confirm-'.$attribute_name.'-'.$row_id.' i").removeClass("glyphicon-ok").addClass("glyphicon glyphicon-remove");
                                    $("#confirm-'.$attribute_name.'-'.$row_id.'").removeClass("confirm-prmry").addClass("confirm-dngr");
                                    $("#confirm-'.$attribute_name.'-'.$row_id.' span").text(result);
                                    $("#confirm-'.$attribute_name.'-'.$row_id.'").slideDown(300);
                                    setTimeout(function(){ $("#confirm-'.$attribute_name.'-'.$row_id.'").slideUp(300); }, 3000);
                                }
                                else
                                {
                                    var res = result.replace(/--/g, "<span class=bullet>&#8226</span>");
                                    $("#content-"+attr_name+"-'.$row_id.'").html(res);
                                    $("#div-edit-"+attr_name+"-'.$row_id.'").slideUp(300);
                                    $("#confirm-'.$attribute_name.'-'.$row_id.' i").removeClass("glyphicon-remove").addClass("glyphicon glyphicon-ok");
                                    $("#confirm-'.$attribute_name.'-'.$row_id.'").removeClass("confirm-dngr").addClass("confirm-prmry");
                                    $("#confirm-'.$attribute_name.'-'.$row_id.' span").text("'.$column_title.' has been updated");
                                    $("#confirm-'.$attribute_name.'-'.$row_id.'").slideDown(300);
                                    setTimeout(function(){ $("#confirm-'.$attribute_name.'-'.$row_id.'").slideUp(300); }, 3000);
                                }
                        });
                    }); 
                    

                    $("#btn-ext-'.$attribute_name.'-'.$row_id.'").click(function(){
                        $("#div-edit-'.$attribute_name.'-'.$row_id.'").slideUp(300);
                    });
                ');
            ?>
        </div>
    <!-- button edit and textarea end-->

    <!-- button comment and textarea -->
        <!-- button comment -->
        <button id="btn-comment-<?= $attribute_name ?>-<?= $row_id ?>" type="button" class="btn btn-warning btn-xs btn-comment-cell" title="Comment" style="display: none;">
            <span class="glyphicon glyphicon-comment"></span>
        </button>
        <?php
            $this->registerJs('
                $("#btn-comment-'.$attribute_name.'-'.$row_id.'").click(function(){
                    var attr_name = "'.$attribute_name.'";
                    $(".div-tooltip-form").hide();
                    $("#txt-comment-'.$attribute_name.'-'.$row_id.'").val("");
                    $("#div-comment-"+attr_name+"-'.$row_id.'").slideDown(300);
                });
            ');
        ?>
        <!-- Comment Box -->
        <div id="div-comment-<?= $attribute_name ?>-<?= $row_id ?>" class="bubble-comment div-tooltip-form unik-div-tooltip-form-<?= $row_id ?>">
            <textarea id="txt-comment-<?= $attribute_name ?>-<?= $row_id ?>" rows="3" class="form-control tooltip-form" placeholder="Write comment"></textarea>
            <button id="save-comment-<?= $attribute_name ?>-<?= $row_id ?>" type="button" class="btn btn-xs btn-default comnt-textarea pull-left upd8-button">
                <span class="glyphicon glyphicon-floppy-disk"></span> Save
            </button>
            <button id="ext-comment-<?= $attribute_name ?>-<?= $row_id ?>" type="button" class="btn btn-xs btn-danger comnt-textarea pull-right exit-button">
                <span class="glyphicon glyphicon-remove"></span> Close
            </button>
            <?php
                $urlSaveComment = \yii\helpers\Url::to(['/report/default/save-comment']);
                $this->registerJs('
                    $("#save-comment-'.$attribute_name.'-'.$row_id.'").click(function(){
                        var attr_name = "'.$attribute_name.'";
                        var uid = '.$row_id.';
                        var comment_value = $("#txt-comment-'.$attribute_name.'-'.$row_id.'").val();
                        var record_uc = "'.$record_unique_code.'";
                        var controller_id = "'.$controller_id.'";
                        var form_id = "'.$form_id.'";
                        $.ajax({
                            url: "'.$urlSaveComment.'",
                            data: { 
                                    plan_budget_id:uid,
                                    comment:comment_value,
                                    attribute_name:attr_name,
                                    record_uc:record_uc,
                                    controller_id:controller_id,
                                    form_id:form_id
                                    }
                            
                            }).done(function(result) {
                                if(result != comment_value)
                                {
                                    $("#confirm-'.$attribute_name.'-comment-'.$row_id.' i").removeClass("glyphicon glyphicon-ok").addClass("glyphicon glyphicon-remove");
                                    $("#comment_return_value-'.$attribute_name.'-'.$row_id.'").text(result);
                                    $("#confirm-'.$attribute_name.'-comment-'.$row_id.'").removeClass("confirm-gad").addClass("confirm-dngr");
                                    $("#confirm-'.$attribute_name.'-comment-'.$row_id.'").slideDown(300);
                                    setTimeout(function(){ $("#confirm-'.$attribute_name.'-comment-'.$row_id.'").slideUp(300); }, 3000);
                                }
                                else
                                {
                                    $("#div-comment-"+attr_name+"-'.$row_id.'").slideUp(300);
                                    $("#confirm-'.$attribute_name.'-comment-'.$row_id.' i").removeClass("glyphicon glyphicon-remove").addClass("glyphicon glyphicon-ok");
                                    $("#comment_return_value-'.$attribute_name.'-'.$row_id.'").text("Comment has been saved");
                                    $("#confirm-'.$attribute_name.'-comment-'.$row_id.'").removeClass("confirm-dngr").addClass("confirm-gad");
                                    $("#confirm-'.$attribute_name.'-comment-'.$row_id.'").slideDown(300);
                                    setTimeout(function(){ $("#confirm-'.$attribute_name.'-comment-'.$row_id.'").slideUp(300); }, 3000);
                                    $("#cell-'.$attribute_name.'-'.$row_id.'").addClass("has-comment");
                                    $("#btn-view-comment-"+attr_name+"-'.$row_id.'").show();
                                }
                        });
                    }); 

                    $("#btn-ext-'.$attribute_name.'-'.$row_id.'").click(function(){
                        $("#div-comment-'.$attribute_name.'-'.$row_id.'").slideUp(300);
                    });
                ');
            ?>

            <?php
                $this->registerJs('
                    $("#ext-comment-'.$attribute_name.'-'.$row_id.'").click(function(){
                        $("#div-comment-'.$attribute_name.'-'.$row_id.'").slideUp(300);
                    });
                ');
            ?>
        </div>
    <!-- button comment and textarea end -->

    <!-- button view comment and display comment -->
        <!-- button view comment -->
        <button id="btn-view-comment-<?= $attribute_name ?>-<?= $row_id ?>" type="button" class="btn btn-default btn-xs btn-view-comment-common" title="View Comment" style="display: none;">
            <span class="glyphicon glyphicon-eye-open"></span>
        </button>
        
        <?php
            $urlLoadComment = \yii\helpers\Url::to(['/report/default/load-comment']);
            $urlUpdateComment = \yii\helpers\Url::to(['/report/default/update-comment']);
            $urlDeleteComment = \yii\helpers\Url::to(['/report/default/delete-comment']);
            $this->registerJs('
                $("#btn-view-comment-'.$attribute_name.'-'.$row_id.'").click(function(){
                    var attr_name = "'.$attribute_name.'";
                    $(".div-tooltip-form").hide();
                    var uid = '.$row_id.';
                    var controller_id = "'.$controller_id.'";
                    var form_id = "'.$form_id.'";
                    
                    $("#div-view-comment-"+attr_name+"-'.$row_id.'").slideDown(300);
                    $.ajax({
                            url: "'.$urlLoadComment.'",
                            data: { 
                                    id:uid,
                                    attribute:attr_name,
                                    controller_id:controller_id,
                                    form_id:form_id
                                    }
                            
                            }).done(function(data) {
                                $("#result-comment-'.$attribute_name.'-'.$row_id.'").html("");
                                $.each(data, function(key, value){
                                    var cols = "";
                                    cols += "<li id=list_comment-"+value.comment_id+">";
                                    cols += "<p id=comment_confirm_message-"+value.comment_id+" class=confirm-message><i></i> <span></span></p>";
                                    cols += "<p class=psgc_value><span></span> ";
                                    cols +=     "<i class=office>"+value.office_name+" | </i>";
                                    cols +=     "<i class=citymun>"+value.citymun_name+"</i>";
                                    cols +=     " <i class=province>"+value.province_name+"</i>";
                                    cols +=     " <i class=region>"+"("+value.region_name+")"+"</i>";
                                    cols += "</p>";
                                    cols += "<p class=who_date_value>";
                                    cols +=     "<i class=who_comment><span></span> "+value.full_name+"</i>";
                                    cols +=     " <i class=date_value><span></span> "+value.date_created+"</i>";
                                    cols +=     " <i class=time_value><span></span> "+value.time_created+"</i>";
                                    cols += "</p>";
                                    cols += "<p class=comment_value id=comment_value-"+value.comment_id+">"+value.comment+"</p>";
                                    if(value.user_id_comment == value.user_id_login) //<-------- show edit and delete button comment
                                    {
                                        cols += "<p class=comment_action_button>";
                                        cols +=     "<i class=btn-edit-comment id=btn_edit_comment_id-"+value.comment_id+"></i>";
                                        cols +=     "<i class=btn-delete-comment id=btn_del_comment_id-"+value.comment_id+"></i>";
                                        cols +=     "<textarea id=txt_edit_comment-"+value.comment_id+" rows=3 class=form-control></textarea>";
                                        cols +=     "<button type=button id=btn_upd8_comment-"+value.comment_id+"><span></span> Update</button>";
                                        cols += "</p>";
                                    }
                                    cols += "</li>";
                                    $("#result-comment-'.$attribute_name.'-'.$row_id.'").append(cols);

                                    $(".btn-edit-comment").addClass("glyphicon glyphicon-edit");
                                    $(".btn-edit-comment").attr("title","Edit");
                                    $(".btn-delete-comment").addClass("glyphicon glyphicon-trash");
                                    $(".btn-delete-comment").attr("title","Delete");
                                    $(".who_comment span").addClass("glyphicon glyphicon-user");
                                    $(".date_value span").addClass("glyphicon glyphicon-calendar");
                                    $(".time_value span").addClass("glyphicon glyphicon-time");
                                    $(".psgc_value span").addClass("glyphicon glyphicon-map-marker");
                                    $(".comment_action_button button").addClass("btn btn-primary btn-xs");
                                    $(".comment_action_button button span").addClass("glyphicon glyphicon-floppy-disk");
                                    

                                    // Edit comment show textarea and update button
                                    $("#btn_edit_comment_id-"+value.comment_id+"").click(function(){
                                        var comment_value = $("#comment_value-"+value.comment_id+"").text();
                                        $("#txt_edit_comment-"+value.comment_id+"").val(comment_value);
                                        $("#txt_edit_comment-"+value.comment_id+"").slideDown(300);
                                        $("#btn_upd8_comment-"+value.comment_id+"").show();
                                    });

                                    // Update button (save changes in comment)
                                    $("#btn_upd8_comment-"+value.comment_id+"").click(function(){
                                        var comment_id = value.comment_id;
                                        var comment_value = $("#txt_edit_comment-"+value.comment_id+"").val();
                                        $.ajax({
                                            url: "'.$urlUpdateComment.'",
                                            data: { 
                                                    comment_id:comment_id,
                                                    comment_value:comment_value
                                                    }
                                            
                                            }).done(function(data) {
                                                if(data == "update_comment_error_occured")
                                                {
                                                    $("#comment_confirm_message-"+value.comment_id+"").addClass("confirm-dngr");
                                                    $("#comment_confirm_message-"+value.comment_id+"").slideDown(300);
                                                    $("#comment_confirm_message-"+value.comment_id+" i").addClass("glyphicon glyphicon-remove");
                                                    $("#comment_confirm_message-"+value.comment_id+"").text("Error occured upon updating comment");
                                                    setTimeout(function(){ $("#comment_confirm_message-"+value.comment_id+"").slideUp(300); }, 3000);
                                                }
                                                else
                                                {
                                                    $("#comment_confirm_message-"+value.comment_id+"").addClass("confirm-prmry");
                                                    $("#comment_confirm_message-"+value.comment_id+"").slideDown(300);
                                                    $("#comment_confirm_message-"+value.comment_id+" i").addClass("glyphicon glyphicon-ok");
                                                    $("#comment_confirm_message-"+value.comment_id+" span").text("Comment has been changed");
                                                    setTimeout(function(){ 
                                                        $("#comment_confirm_message-"+value.comment_id+"").slideUp(300); 
                                                        $("#comment_value-"+value.comment_id+"").text(data);
                                                        $("#txt_edit_comment-"+value.comment_id+"").slideUp(300);
                                                        $("#btn_upd8_comment-"+value.comment_id+"").hide();
                                                    }, 3000);
                                                }
                                                
                                                $("#comment_confirm_message-"+value.comment_id+"").click(function(){
                                                    $(this).hide();
                                                });
                                        });
                                    });

                                    // Delete Comment
                                    $("#btn_del_comment_id-"+value.comment_id+"").click(function(){
                                        var comment_id = value.comment_id;
                                        if (confirm("Are you sure you want to delete this comment?")) {
                                            $.ajax({
                                                url: "'.$urlDeleteComment.'",
                                                data: { 
                                                        comment_id:comment_id
                                                        }
                                                
                                                }).done(function(data) {
                                                    if(data == "ok")
                                                    {
                                                        $("#comment_confirm_message-"+value.comment_id+"").addClass("confirm-prmry");
                                                        $("#comment_confirm_message-"+value.comment_id+"").slideDown(300);
                                                        $("#comment_confirm_message-"+value.comment_id+" i").addClass("glyphicon glyphicon-ok");
                                                        $("#comment_confirm_message-"+value.comment_id+" span").text("Comment has been deleted");
                                                        setTimeout(function(){ $("#comment_confirm_message-"+value.comment_id+"").slideUp(300); 
                                                            $("#list_comment-"+value.comment_id+"").slideUp(300);
                                                        }, 3000);
                                                        
                                                        
                                                    }
                                                    else
                                                    {
                                                        $("#comment_confirm_message-"+value.comment_id+"").addClass("confirm-dngr");
                                                        $("#comment_confirm_message-"+value.comment_id+"").slideDown(300);
                                                        $("#comment_confirm_message-"+value.comment_id+" i").addClass("glyphicon glyphicon-remove");
                                                        $("#comment_confirm_message-"+value.comment_id+"").text("Error occured upon deleting comment");
                                                        setTimeout(function(){ $("#comment_confirm_message-"+value.comment_id+"").slideUp(300); 
                                                            $("#list_comment-"+value.comment_id+"").slideUp(300);
                                                        }, 3000);
                                                    }

                                                    $("#comment_confirm_message-"+value.comment_id+"").click(function(){
                                                        $(this).hide();
                                                    });
                                            });
                                        }
                                        else
                                        {
                                            return false;
                                        }
                                        
                                    });
                                });
                    });
                });
            ');
        ?>
        <!-- Comment Box -->

        <div id="div-view-comment-<?= $attribute_name ?>-<?= $row_id ?>" class="bubble-view-comment div-tooltip-form unik-div-tooltip-form-<?= $row_id ?>">
                
            <div class="comment-inner-content">
                <ul id="result-comment-<?= $attribute_name ?>-<?= $row_id ?>" class="view-comment-list">
                </ul>
            </div>
            <button id="ext-view-comment-<?= $attribute_name ?>-<?= $row_id ?>" type="button" class="btn btn-xs btn-danger comnt-textarea pull-right exit-button">
                <span class="glyphicon glyphicon-remove"></span> Close
            </button>
            <?php
                
                $this->registerJs('
                    $("#ext-view-comment-'.$attribute_name.'-'.$row_id.'").click(function(){
                        $("#div-view-comment-'.$attribute_name.'-'.$row_id.'").slideUp(300);
                    });
                ');
            ?>
        </div>

        <?php 
            $findOneQry =  \common\models\GadPlanBudget::find()->where(['id' => $row_id, 'inner_category_id' => 1])->andWhere(['not', ['gi_sup_data' => null]]);
        ?>
        <?php if($findOneQry->exists() && $attribute_name == "ppa_value"){ ?>
            <button id="btn_view_gi_sup_data-<?= $row_id ?>" type="button" class="btn btn-warning btn-xs" title="Gender Issue Supporting Statistics Data">
                <span class="glyphicon glyphicon-list"></span>
            </button>
            <?php
                $urlLoadSupData = \yii\helpers\Url::to(['/report/default/load-gender-issue-sup-data']);
                $this->registerJs("
                    $('#btn_view_gi_sup_data-".$row_id."').click(function(){
                        $('.div-tooltip-form').hide(); // hide all showing div
                        $('#div_view_sup_data-".$row_id."').slideDown(300); // show current active div
                        var record_id = ".$row_id.";
                        $.ajax({
                            url: '".$urlLoadSupData."',
                            data: { 
                                    record_id:record_id
                                    }
                            
                            }).done(function(data) {
                                $('#content_sup_data-".$row_id."').text(data);
                        });
                    });
                ");
            ?>
        <?php } ?>

        <div id="div_view_sup_data-<?= $row_id ?>" class="bubble-view-supdata div-tooltip-form unik-div-tooltip-form-<?= $row_id ?>">
            <p class="confirm-message confirm-prmry" id="confirm_gi_sup_data-<?= $row_id ?>"></p>
            <p style="background-color: white; font-weight: bold; color: black; text-align: left; border-bottom: 1px solid white; margin-top: 5px; padding-left: 10px;">GENDER ISSUE SUPPORTING STATISTICS DATA</p>
            <div style="background-color: white; width: 90%; margin-right: 5%; margin-left: auto; margin-top: 10px; overflow-y: scroll; max-height: 100px;">

                <p id="content_sup_data-<?= $row_id ?>" style="color:black; text-align: justify; width: 90%; margin-right: 5%; margin-left: auto; font-style: italic;">
                </p>
            </div>
            <textarea id="ta_edit_supdata-<?= $row_id ?>" rows="3" class="form-control" style="display: none; width: 90%; margin-left: 5%; margin-right: auto; margin-top: 10px; background-color: skyblue; color:black; border-radius: 15px;">
            </textarea>
            <button id="ext_view_supdata-<?= $row_id ?>" type="button" class="btn btn-xs btn-danger comnt-textarea pull-right exit-button">
                    <span class="glyphicon glyphicon-remove"></span> Close
            </button>
            <button id="edit_supdata-<?= $row_id ?>" type="button" class="btn btn-xs btn-default comnt-textarea pull-right exit-button" title="Edit Supporting Statistics Data">
                <span class="glyphicon glyphicon-edit"></span> Edit
            </button>
            <button id="update_supdata-<?= $row_id ?>" type="button" class="btn btn-xs btn-primary comnt-textarea pull-right exit-button" title="Save Changes on Supporting Statistics Data" style="display: none;">
                <span class="glyphicon glyphicon-floppy-disk"></span> Save
            </button>
            
            <?php
                $urlUpdateSupData = \yii\helpers\Url::to(['/report/default/update-gender-issue-sup-data']);
                $this->registerJs("
                    $('#edit_supdata-".$row_id."').click(function(){
                        var value = $.trim($('#content_sup_data-".$row_id."').text());
                        $('#ta_edit_supdata-".$row_id."').text(value);
                        $('#ta_edit_supdata-".$row_id."').slideDown(300);
                        $('#update_supdata-".$row_id."').show();
                    });

                    $('#ext_view_supdata-".$row_id."').click(function(){
                        $('#div_view_sup_data-".$row_id."').slideUp(300);
                    });

                    $('#update_supdata-".$row_id."').click(function(){
                        var ta_supdata_value = $('#ta_edit_supdata-".$row_id."').val();
                        var record_id = ".$row_id.";
                        $.ajax({
                            url: '".$urlUpdateSupData."',
                            data: { 
                                    upd8_value:ta_supdata_value,
                                    uid:record_id
                                    }
                            
                            }).done(function(data) {
                                if(data != ta_supdata_value)
                                {
                                    $('#confirm_gi_sup_data-".$row_id."').removeClass('confirm-prmry').addClass('confirm-dngr');
                                    $('#confirm_gi_sup_data-".$row_id."').text(data);
                                    $('#confirm_gi_sup_data-".$row_id."').slideDown(300);
                                    setTimeout(function(){ $('#confirm_gi_sup_data-".$row_id."').slideUp(300); }, 3000);
                                }
                                else
                                {
                                    $('#confirm_gi_sup_data-".$row_id."').text('Supporting Statistics Data has been updated.');
                                    $('#content_sup_data-".$row_id."').text(ta_supdata_value);
                                    $('#confirm_gi_sup_data-".$row_id."').slideDown(300);
                                    setTimeout(function(){ $('#confirm_gi_sup_data-".$row_id."').slideUp(300); }, 3000);
                                }
                        });
                    });
                ");
            ?>
        </div>
    <!-- button comment and textarea end -->
</td>