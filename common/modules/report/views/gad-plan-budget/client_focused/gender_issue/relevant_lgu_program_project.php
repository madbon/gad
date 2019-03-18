<?php

use yii\helpers\Html;
?>

<td id="cell-relevant_lgu_program_project-<?= $plan['id'] ?>" class="common-cell-container">
    <p><?= $plan["relevant_lgu_program_project"]?></p>
    <div id="actn-btns-relevant_lgu_program_project-<?= $plan['id']?>" class="actn-btn-bubble actn-buble-common-class" style="display: none;">
        <button id="btn-select-relevant_lgu_program_project-<?= $plan['id']?>" type="button" class="btn btn-info btn-xs btn-select-cell" title="Select" >
            Select
        </button>
    </div>
   
    <?php
        $this->registerJs('
            $("#cell-relevant_lgu_program_project-'.$plan["id"].'").mouseover(function(){
                var attr_name = "relevant_lgu_program_project";
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

            $("#btn-select-relevant_lgu_program_project-'.$plan["id"].'").click(function(){
                var attr_name = "relevant_lgu_program_project";
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
        <button id="btn-edit-relevant_lgu_program_project-<?= $plan['id']?>" type="button" class="btn btn-primary btn-xs btn-edit-cell" title="Edit"  style="display: none;">
            <span class="glyphicon glyphicon-edit"></span>
        </button>
        <?php
            $this->registerJs('
                $("#btn-edit-relevant_lgu_program_project-'.$plan["id"].'").click(function(){
                    var attr_name = "relevant_lgu_program_project";
                    $(".div-tooltip-form").hide();
                    $("#div-edit-"+attr_name+"-'.$plan["id"].'").slideDown(300);
                });
            ');
        ?>
        <div id="div-edit-relevant_lgu_program_project-<?= $plan["id"] ?>" class="bubble div-tooltip-form unik-div-tooltip-form-<?= $plan["id"] ?>">
            <textarea id="txt-edit-relevant_lgu_program_project" rows="2" class="form-control tooltip-form"></textarea>
            <button type="button" class="btn btn-xs btn-default upd8-textarea pull-right "><span class="glyphicon glyphicon-floppy-disk"></span> Update</button>
        </div>
    <!-- button edit and textarea end-->

    <!-- button comment and textarea -->
        <button id="btn-comment-relevant_lgu_program_project-<?= $plan['id'] ?>" type="button" class="btn btn-warning btn-xs btn-comment-cell" title="Comment" style="display: none;">
            <span class="glyphicon glyphicon-comment"></span>
        </button>
        <?php
            $this->registerJs('
                $("#btn-comment-relevant_lgu_program_project-'.$plan["id"].'").click(function(){
                    var attr_name = "relevant_lgu_program_project";
                    $(".div-tooltip-form").hide();
                    $("#div-comment-"+attr_name+"-'.$plan["id"].'").slideDown(300);
                });
            ');
        ?>
        <div id="div-comment-relevant_lgu_program_project-<?= $plan["id"] ?>" class="bubble-comment div-tooltip-form unik-div-tooltip-form-<?= $plan["id"] ?>">
            <textarea id="txt-comment-relevant_lgu_program_project" rows="2" class="form-control tooltip-form" placeholder="Write comment"></textarea>
            <button type="button" class="btn btn-xs btn-default comnt-textarea pull-right "><span class="glyphicon glyphicon-floppy-disk"></span> Save</button>
        </div>
    <!-- button comment and textarea end -->
</td>