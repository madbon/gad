<?php

use yii\helpers\Html;
?>

<td id="cell-objective-<?= $plan['id'] ?>" class="common-cell-container">
    <p id="confirm-objective-<?= $plan['id'] ?>" class="confirm-message confirm-prmry">
        <span class="glyphicon glyphicon-ok"></span> This GAD Objective has been changed
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
        <div id="div-comment-objective-<?= $plan["id"] ?>" class="bubble-comment div-tooltip-form unik-div-tooltip-form-<?= $plan["id"] ?>">
            <textarea id="txt-comment-objective" rows="2" class="form-control tooltip-form" placeholder="Write comment"></textarea>
            <button type="button" class="btn btn-xs btn-default comnt-textarea pull-right "><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
        </div>
    <!-- button comment and textarea end -->
</td>