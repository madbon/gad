<?php

use yii\helpers\Html;
use common\modules\report\controllers\DefaultController;
?>

<?php if(DefaultController::countComment($plan["id"],"objective") > 0) { ?>
<td id="cell-objective-<?= $plan['id'] ?>" class="common-cell-container has-comment"> <!-- put border if has comment  -->
<?php } else{ ?>
<td id="cell-objective-<?= $plan['id'] ?>" class="common-cell-container"> <!-- remove border if no comment  -->
<?php } ?>
    <p id="confirm-objective-<?= $plan['id'] ?>" class="confirm-message confirm-prmry"> <!-- confirmation message update click update  -->
        <span class="glyphicon glyphicon-ok"></span> This GAD Objective has been changed
    </p>
    <p id="confirm-objective-comment-<?= $plan['id'] ?>" class="confirm-message confirm-wrnng"> <!-- confirmation message after comment  -->
        <span class="glyphicon glyphicon-ok"></span> Comment has been saved
    </p>
    <p id="content-objective-<?= $plan['id'] ?>"><?= $plan["objective"]?></p>
    <div id="actn-btns-objective-<?= $plan['id']?>" class="actn-btn-bubble actn-buble-common-class" style="display: none;">
        <button id="btn-select-objective-<?= $plan['id']?>" type="button" class="btn btn-info btn-xs btn-select-cell" title="Select" >
            Select
        </button>
    </div>
    
    <?php
        $this->registerJs('
            $("#cell-objective-'.$plan["id"].'").mouseover(function(){
                var attr_name = "objective";
                $(".actn-buble-common-class").hide();

                if($(this).hasClass("active-cell")) // if td.active cell has class  .active-cell hide button select
                {
                    $("#actn-btns-"+attr_name+"-'.$plan["id"].'").hide();
                }
                else
                {
                    $("#actn-btns-"+attr_name+"-'.$plan["id"].'").show();
                }
            });

            $("#btn-select-objective-'.$plan["id"].'").click(function(){
                var attr_name = "objective";
                $(".common-cell-container").removeClass("active-cell"); // remove other .active-cell if not active
                $("#cell-"+attr_name+"-'.$plan["id"].'").addClass("active-cell"); // add class .active-cell if active

                $(".common-cell-container").css({"background-color":"white"});
                $("#cell-"+attr_name+"-'.$plan["id"].'").css({"background-color":"skyblue"}); // active-color

                $(".btn-edit-cell").hide(); // hide btn edit if not active cell
                $(".btn-comment-cell").hide(); // hide btn comment if not active cell
                $("#btn-edit-"+attr_name+"-'.$plan["id"].'").show(); // if active show btn edit
                $("#btn-comment-"+attr_name+"-'.$plan["id"].'").show(); // if active show btn common

                var countComment = '.(DefaultController::countComment($plan["id"],"objective")).';
                if(countComment > 0)
                {
                    $("#btn-view-comment-"+attr_name+"-'.$plan["id"].'").show(); // if active show btn common
                }

                if($("#cell-"+attr_name+"-'.$plan["id"].'").hasClass("active-cell")) // if td.active cell has class  .active-cell hide button select
                {
                    $("#actn-btns-"+attr_name+"-'.$plan["id"].'").hide();
                    $(".div-tooltip-form").slideUp(300); // hide tooltip form if not active cell
                }
                else
                {
                    $("#actn-btns-"+attr_name+"-'.$plan["id"].'").show();
                }
            });
        ');
    ?>
    <!-- button edit and textarea -->
        <button id="btn-edit-objective-<?= $plan['id']?>" type="button" class="btn btn-primary btn-xs btn-edit-cell" title="Edit"  style="display: none;">
            <span class="glyphicon glyphicon-edit"></span>
        </button>
        <?php
            $this->registerJs('
                $("#btn-edit-objective-'.$plan["id"].'").click(function(){
                    var attr_name = "objective";
                    var cell_value =  $("#content-"+attr_name+"-'.$plan["id"].'").text();
                    $(".div-tooltip-form").hide();
                    $("#txt-edit-objective-'.$plan["id"].'").val(cell_value);
                    $("#div-edit-"+attr_name+"-'.$plan["id"].'").slideDown(300);
                });
            ');
        ?>
        <div id="div-edit-objective-<?= $plan["id"] ?>" class="bubble div-tooltip-form unik-div-tooltip-form-<?= $plan["id"] ?>">
            <textarea id="txt-edit-objective-<?= $plan["id"] ?>" rows="3" class="form-control tooltip-form"></textarea>
            <button id="btn-upd8-objective-<?= $plan["id"] ?>" type="button" class="btn btn-xs btn-default upd8-button pull-left ">
                <span class="glyphicon glyphicon-floppy-disk"></span> Update
            </button>
            <button id="btn-ext-objective-<?= $plan["id"] ?>" type="button" class="btn btn-xs btn-danger pull-right exit-button">
                <span class="glyphicon glyphicon-remove"></span> Exit
            </button>
            
            <?php
                $url = \yii\helpers\Url::to(['/report/default/update-objective']);
                $this->registerJs('
                    $("#btn-upd8-objective-'.$plan['id'].'").click(function(){
                        var attr_name = "objective";
                        var uid = '.$plan["id"].';
                        var upd8_value = $("#txt-edit-objective-'.$plan["id"].'").val();
                        $.ajax({
                            url: "'.$url.'",
                            data: { 
                                    uid:uid,
                                    upd8_value:upd8_value
                                    }
                            
                            }).done(function(result) {
                                $("#content-"+attr_name+"-'.$plan["id"].'").text(result);
                                $("#div-edit-"+attr_name+"-'.$plan["id"].'").slideUp(300);
                                $("#confirm-objective-'.$plan["id"].'").slideDown(300);
                                setTimeout(function(){ $("#confirm-objective-'.$plan["id"].'").slideUp(300); }, 3000);
                                
                        });
                    }); 

                    $("#btn-ext-objective-'.$plan["id"].'").click(function(){
                        $("#div-edit-objective-'.$plan["id"].'").slideUp(300);
                    });
                ');
            ?>
        </div>
    <!-- button edit and textarea end-->

    <!-- button comment and textarea -->
        <!-- button comment -->
        <button id="btn-comment-objective-<?= $plan['id'] ?>" type="button" class="btn btn-warning btn-xs btn-comment-cell" title="Comment" style="display: none;">
            <span class="glyphicon glyphicon-comment"></span>
        </button>
        <?php
            $this->registerJs('
                $("#btn-comment-objective-'.$plan["id"].'").click(function(){
                    var attr_name = "objective";
                    $(".div-tooltip-form").hide();
                    $("#div-comment-"+attr_name+"-'.$plan["id"].'").slideDown(300);
                });
            ');
        ?>
        <!-- Comment Box -->
        <div id="div-comment-objective-<?= $plan["id"] ?>" class="bubble-comment div-tooltip-form unik-div-tooltip-form-<?= $plan["id"] ?>">
            <textarea id="txt-comment-objective-<?= $plan["id"] ?>" rows="3" class="form-control tooltip-form" placeholder="Write comment"></textarea>
            <button id="save-comment-objective-<?= $plan["id"] ?>" type="button" class="btn btn-xs btn-default comnt-textarea pull-left upd8-button">
                <span class="glyphicon glyphicon-floppy-disk"></span> Save
            </button>
            <button id="ext-comment-objective-<?= $plan["id"] ?>" type="button" class="btn btn-xs btn-danger comnt-textarea pull-right exit-button">
                <span class="glyphicon glyphicon-remove"></span> Exit
            </button>
            <?php
                $urlSaveComment = \yii\helpers\Url::to(['/report/default/save-comment']);
                $this->registerJs('
                    $("#save-comment-objective-'.$plan['id'].'").click(function(){
                        var attr_name = "objective";
                        var uid = '.$plan["id"].';
                        var comment_value = $("#txt-comment-objective-'.$plan["id"].'").val();
                        var record_uc = "'.$plan["record_uc"].'";
                        $.ajax({
                            url: "'.$urlSaveComment.'",
                            data: { 
                                    plan_budget_id:uid,
                                    comment:comment_value,
                                    attribute_name:attr_name,
                                    record_uc:record_uc
                                    }
                            
                            }).done(function(result) {
                                $("#div-comment-"+attr_name+"-'.$plan["id"].'").slideUp(300);
                                $("#confirm-objective-comment-'.$plan["id"].'").slideDown(300);
                                setTimeout(function(){ $("#confirm-objective-comment-'.$plan["id"].'").slideUp(300); }, 3000);
                                $("#cell-objective-'.$plan["id"].'").css({"border":"2px solid red","border-left":"2px solid red","border-top":"2px solid red"});
                                $("#btn-view-comment-"+attr_name+"-'.$plan["id"].'").show();
                        });
                    }); 

                    $("#btn-ext-objective-'.$plan["id"].'").click(function(){
                        $("#div-comment-objective-'.$plan["id"].'").slideUp(300);
                    });
                ');
            ?>
        </div>
    <!-- button comment and textarea end -->

    <!-- button view comment and display comment -->
        <!-- button view comment -->
        <button id="btn-view-comment-objective-<?= $plan['id'] ?>" type="button" class="btn btn-default btn-xs btn-comment-cell" title="View Comment" style="display: none;">
            <span class="glyphicon glyphicon-eye-open"></span>
        </button>
        
        <?php
            $urlLoadComment = \yii\helpers\Url::to(['/report/default/load-comment']);
            $urlUpdateComment = \yii\helpers\Url::to(['/report/default/update-comment']);
            $urlDeleteComment = \yii\helpers\Url::to(['/report/default/delete-comment']);
            $this->registerJs('
                $("#btn-view-comment-objective-'.$plan["id"].'").click(function(){
                    var attr_name = "objective";
                    $(".div-tooltip-form").hide();
                    var uid = '.$plan["id"].';
                    
                    $("#div-view-comment-"+attr_name+"-'.$plan["id"].'").slideDown(300);
                    $.ajax({
                            url: "'.$urlLoadComment.'",
                            data: { 
                                    id:uid,
                                    attribute:attr_name
                                    }
                            
                            }).done(function(data) {
                                $("#result-comment-objective-'.$plan['id'].'").html("");
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
                                    $("#result-comment-objective-'.$plan['id'].'").append(cols);

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

        <div id="div-view-comment-objective-<?= $plan["id"] ?>" class="bubble-view-comment div-tooltip-form unik-div-tooltip-form-<?= $plan["id"] ?>">
                
            <div class="comment-inner-content">
                <ul id="result-comment-objective-<?= $plan["id"] ?>" class="view-comment-list">
                </ul>
            </div>
            <button id="ext-view-comment-objective-<?= $plan["id"] ?>" type="button" class="btn btn-xs btn-danger comnt-textarea pull-right exit-button">
                <span class="glyphicon glyphicon-remove"></span> Exit
            </button>
            <?php
                
                $this->registerJs('
                    $("#ext-view-comment-objective-'.$plan["id"].'").click(function(){
                        $("#div-view-comment-objective-'.$plan["id"].'").slideUp(300);
                    });
                ');
            ?>
        </div>
    <!-- button comment and textarea end -->
</td>