<?php
use yii\helpers\Html;
use kartik\select2\Select2;
?>
<tr>
    
    <tr>
        <td class="td-bot-ppa_value-<?= $val['id']; ?>">
            <?php
                echo Select2::widget([
                    'name' => 'bot-ppa_value',
                    'data' => $opt_cli_focused,
                    'options' => [
                        'placeholder' => 'Types of Client-Focused',
                        'id' => "bot-ppa_value-".$val['id'],
                    ],
                    'pluginEvents'=>[
                        'select2:select'=>'
                            function(){
                                $("#message-bot-ppa_value-'.$val["id"].'").text("");
                                $("#select2-bot-ppa_value-'.$val["id"].'-container").parent(".select2-selection").css({"border":"1px solid #ccc"});
                            }',
                    ]     
                ]);
            ?>
            <br/>
            <textarea type="text" name="other-bot-ppa_value" id="other-bot-ppa_value-<?= $val["id"]?>" class="form-control" rows="2"></textarea>
            <?php
                $this->registerJs("
                    var newOption = $('<option>');
                    newOption.attr('value','0').text('Others');
                    $('#bot-ppa_value-".$val['id']."').append(newOption);
                ");
            ?>
            
        </td>
        <td>
           <textarea type="text" class="form-control" rows="2" id="bot-cause_gender_issue-<?= $val['id']?>"></textarea>
        </td>
        <td>
            <textarea type="text" rows="2" id="bot-objective-<?= $val['id']?>" class="form-control"></textarea>
            <ul id="bot-result-obj-<?= $val['id'] ?>" class="result"></ul>
            <?php
                $urlPbObjective = \yii\helpers\Url::to(['/report/default/load-pb-objective']);
                $this->registerJs("
                    $('#bot-objective-".$val['id']."').keyup(function(){
                        var searchField = $(this).val();
                        var expression = new RegExp(searchField, 'i');
                        var value_obj = $(this).val();
                        if(value_obj.length>= 3){
                            $.getJSON('".$urlPbObjective."', function(data){
                                $('#bot-result-obj-".$val['id']."').html('');
                                $.each(data, function(key, value){
                                    if(value.title.search(expression) != -1)
                                    {
                                        var tarea_obj_wid = $('#bot-objective-".$val['id']."').width();
                                        var tarea_obj_wid_res = tarea_obj_wid+25 + 'px';
                                        $('#bot-result-obj-".$val['id']."').append('<li id=obj-li-'+value.id+'>'+value.title+'</li>');

                                        $('#bot-result-obj-".$val['id']."').css({'width': tarea_obj_wid_res,'box-shadow':'0.5px 0.5px 0.5px 1px skyblue'});
                                        $('#bot-result-obj-".$val['id']." li#obj-li-'+value.id+'').click(function(){
                                            $('#bot-objective-".$val['id']."').val($(this).text());
                                            $('#bot-result-obj-".$val['id']."').html('');
                                        });
                                        $('#bot-objective-".$val['id']."').css({'border-bottom':'none','border-radius':'4px 4px 0px 0px'});
                                        $('body').click(function(){
                                            $('.result').html('');
                                            $('.result').css({'box-shadow':'none'});
                                            $('#bot-objective-".$val['id']."').css({'border-radius':'4px','border-bottom':'1px solid rgb(204,204,204)'});
                                        });
                                    }
                                });
                            });
                        }
                    });

                    
                ");
            ?>
        </td>
        <td>
            <textarea type="text" id="bot-relevant_lgu_program_project-<?= $val['id']?>"rows="2" class="form-control"></textarea>
        </td>
        <td><textarea type="text" id="bot-activity-<?= $val['id']?>" class="form-control" rows="2"></textarea></td>
        <td><textarea type="text" id="bot-performance_target-<?= $val['id']?>" class="form-control" rows="2"></textarea></td>
        <td>
            <button type="button" class="btn btn-primary" title="Save" id="bot-save-gender-issue-<?= $val['id']?>">
                <span class="glyphicon glyphicon-floppy-disk"></span>
            </button>
        </td>
    </tr>
    <?php
        $url = \yii\helpers\Url::to(['/report/default/create-gad-plan-budget']);
        $this->registerJs('
            $("#bot-save-gender-issue-'.$val['id'].'").click(function(){
                var focused     = $("#bot-ppa_value-'.$val['id'].'").val();
                var issue       = $("#bot-cause_gender_issue-'.$val['id'].'").val();
                var obj         = $("#bot-objective-'.$val['id'].'").val();
                var relevant    = $("#bot-relevant_lgu_program_project-'.$val['id'].'").val();
                var act         = $("#bot-activity-'.$val['id'].'").val();
                var perform     = $("#bot-performance_target-'.$val['id'].'").val();
                var ruc         = "'.$ruc.'";

                $.ajax({
                    url: "'.$url.'",
                    data: { 
                            issue:issue,
                            obj:obj,
                            relevant:relevant,
                            act:act,
                            perform:perform,
                            ruc:ruc,
                            focused:focused
                        }
                    
                    }).done(function(result) {
                        $.each(result, function( index, value ) {
                            
                            $("p#message-"+index+"-'.$val["id"].'").text("");
                            $("textarea#bot-"+index+"-'.$val['id'].'").css({"border":"1px solid red"});
                            $("textarea#bot-"+index+"-'.$val['id'].'").after("<p id=message-bot-"+index+"-'.$val["id"].' style=color:red;font-style:italic;>"+value+"</p>");

                            $("input#bot-"+index+"-'.$val['id'].'").css({"border":"1px solid red"});
                            $("input#bot-"+index+"-'.$val['id'].'").after("<p id=message-bot-"+index+"-'.$val["id"].' style=color:red;font-style:italic;>"+value+"</p>");

                            $("#select2-bot-"+index+"-'.$val["id"].'-container").parent(".select2-selection").css({"border":"1px solid red"});
                            $("#select2-bot-"+index+"-'.$val["id"].'-container").parent(".select2-selection").after("<p id=message-bot-"+index+"-'.$val["id"].' style=color:red;font-style:italic;>"+value+"</p>");

                            $("#select2-bot-"+index+"-'.$val["id"].'-container").text
                            
                            $("textarea#bot-"+index+"-'.$val['id'].'").keyup(function(){
                                $("#message-bot-"+index+"-'.$val["id"].'").text("");
                                $(this).css({"border":"1px solid #ccc"});
                            });

                            $("input#bot-"+index+"-'.$val['id'].'").keyup(function(){
                                $("#message-bot-"+index+"-'.$val["id"].'").text("");
                                $(this).css({"border":"1px solid #ccc"});
                            });
                        });
                });
          }); ');
    ?>
</tr>