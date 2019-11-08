<?php

use yii\helpers\Html;
use common\modules\report\controllers\DefaultController;
?>

<td style="<?= $customStyle ?>" title="<?= $column_title ?>" colspan="<?= $colspanValue ?>" id="cell-<?= $attribute_name ?>-<?= $row_id ?>" class="common-cell-container"> <!-- remove border if no comment  -->


    <p id="confirm-<?= $attribute_name ?>-<?= $row_id ?>" class="confirm-message"> <!-- confirmation message update click update  -->
       <i></i> <span></span>
    </p>
    <p id="confirm-<?= $attribute_name ?>-comment-<?= $row_id ?>" class="confirm-message confirm-gad"> <!-- confirmation message after comment  -->
        <span class="glyphicon glyphicon-ok"></span> Comment has been saved
    </p>
    <p style="<?= $customStyle ?>" id="content-<?= $attribute_name ?>-<?= $row_id ?>"><?= $data_type == "number" ? number_format($cell_value,2) : $cell_value ?>  <!-- Display the content of attribute or cell value -->
        <div id="actn-btns-<?= $attribute_name ?>-<?= $row_id?>" class="actn-btn-bubble actn-buble-common-class" style="display: none;">
            <button id="btn-select-<?= $attribute_name ?>-<?= $row_id?>" type="button" class="btn btn-info btn-xs btn-select-cell" >
                Select
            </button>
        </div>
    </p>
    
    <?php
        $this->registerJs("
            $('.confirm-message').click(function(){
                $(this).hide();
            });
        ");
    ?>

    <?php
        $this->registerJs('
            $("#cell-'.$attribute_name.'-'.$row_id.'").mouseover(function(){
                var attr_name = "'.$attribute_name.'";
                $(".actn-buble-common-class").hide();
                var disableSelect = "'.$disableSelect.'";

                if(disableSelect == "false")
                {
                    if($(this).hasClass("active-cell")) // if td.active cell has class  .active-cell hide button select
                    {
                        $("#actn-btns-"+attr_name+"-'.$row_id.'").hide();
                    }
                    else
                    {
                        $("#actn-btns-"+attr_name+"-'.$row_id.'").show();
                    }
                }
                
            });

            $("#btn-select-'.$attribute_name.'-'.$row_id.'").click(function(){
                var attr_name = "'.$attribute_name.'";
                $(".common-cell-container").removeClass("active-cell"); // remove other .active-cell if not active
                $("#cell-"+attr_name+"-'.$row_id.'").addClass("active-cell"); // add class .active-cell if active

                $(".common-cell-container").css({"background-color":"white"});
                $("#cell-"+attr_name+"-'.$row_id.'").css({"background-color":"skyblue"}); // active-color

                $(".btn-edit-cell").hide(); // hide btn edit if not active cell
                $(".btn-comment-cell").hide(); // hide btn comment if not active cell
                $(".btn-view-comment-common").hide();
                $("#btn-edit-"+attr_name+"-'.$row_id.'").show(); // if active show btn edit
                $("#btn-comment-"+attr_name+"-'.$row_id.'").show(); // if active show btn common

                var countComment = '.(DefaultController::countComment2($controller_id,$form_id,$row_id,$attribute_name)).';
                if(countComment > 0)
                {
                    $("#btn-view-comment-"+attr_name+"-'.$row_id.'").show(); // if active show btn common
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

                    $("#txt-edit-'.$attribute_name.'-'.$row_id.'").val("'.trim($cell_value).'");
                    $("#div-edit-"+attr_name+"-'.$row_id.'").slideDown(300);
                });
            ');
        ?>
        <div id="div-edit-<?= $attribute_name ?>-<?= $row_id ?>" class="bubble div-tooltip-form unik-div-tooltip-form-<?= $row_id ?>">
            <input id="txt-edit-<?= $attribute_name ?>-<?= $row_id ?>"  class="form-control tooltip-form">
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
                                    $("#content-"+attr_name+"-'.$row_id.'").text(result);
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
</td>