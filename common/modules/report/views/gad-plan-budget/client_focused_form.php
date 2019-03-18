<?php
use yii\helpers\Html;
use kartik\select2\Select2;
?>
<style type="text/css">
    tr#row-input-form td
    {
        border:none;
        background-color: white;
    }
</style>
<tr>
    <td colspan='12'>
        <button type='button' class='btn btn-success btn-sm' id="btnGenderIssue"><span class='glyphicon glyphicon-pencil'></span> Gender Issue</button>
        <?php
            $this->registerJs("
                $('#btnGenderIssue').click(function(){
                    $('#genderIssueInputForm').slideDown(300);
                });
            ");
        ?>
    </td>
</tr>
<tr id="genderIssueInputForm" style="display: none;">
    <td colspan='12'>
        <div class="row">
            <div class="col-sm-4">
                 <?php
                    echo Select2::widget([
                        'name' => 'ppa_focused_id',
                        'data' => $opt_cli_focused,
                        'options' => [
                            'placeholder' => 'Category of PPA',
                            'id' => "ppa_focused_id-".$val['id'],
                        ],
                        'pluginEvents'=>[
                            'select2:select'=>'
                                function(){
                                    $("#message-ppa_focused_id-'.$val["id"].'").text("");
                                    $("#select2-ppa_focused_id-'.$val["id"].'-container").parent(".select2-selection").css({"border":"1px solid #ccc"});
                                    if(this.value == "0")
                                    {
                                        $("#ppa_value-'.$val["id"].'").slideDown(300);
                                        $("#message-ppa_value-'.$val["id"].'").show();
                                    }
                                    else
                                    {
                                        $("#ppa_value-'.$val["id"].'").slideUp(300);
                                        $("#ppa_value-'.$val["id"].'").val("");
                                        $("#message-ppa_value-'.$val["id"].'").hide();
                                    }
                                }',
                        ]     
                    ]);
                ?>
                <textarea placeholder="PPA Other Description" type="text" name="other-ppa_value" id="ppa_value-<?= $val["id"]?>" class="form-control" rows="2" style="display: none; margin-top: 10px;"></textarea>
                <ul id="result-ppa_value-<?= $val['id'] ?>" class="result"></ul>
                <?php
                    $urlPpaValue = \yii\helpers\Url::to(['/report/default/load-ppa-value']);
                    $this->registerJs("
                        $('#ppa_value-".$val['id']."').keyup(function(){
                            var searchField = $(this).val();
                            var expression = new RegExp(searchField, 'i');
                            var value_length = $(this).val();
                            var attrib = 'ppa_value';
                            $('#message-'+attrib+'-".$val['id']."').hide();
                            if(value_length.length>= 3){
                                $.getJSON('".$urlPpaValue."', function(data){
                                    $('#result-'+attrib+'-".$val['id']."').html('');
                                    $.each(data, function(key, value){
                                        if(value.title.search(expression) != -1)
                                        {
                                            var tarea_obj_wid = $('#'+attrib+'-".$val['id']."').width();
                                            var tarea_obj_wid_res = tarea_obj_wid+25 + 'px';
                                            console.log(tarea_obj_wid_res);
                                            $('#result-'+attrib+'-".$val['id']."').append('<li id='+attrib+'-li-'+value.id+'>'+value.title+'</li>');

                                            $('#result-'+attrib+'-".$val['id']."').css({'width': tarea_obj_wid_res,'box-shadow':'0.5px 0.5px 0.5px 1px skyblue'});
                                            $('#result-'+attrib+'-".$val['id']." li#'+attrib+'-li-'+value.id+'').click(function(){
                                                $('#'+attrib+'-".$val['id']."').val($(this).text());
                                                $('#result-'+attrib+'-".$val['id']."').html('');
                                            });
                                            $('#'+attrib+'-".$val['id']."').css({'border-bottom':'none','border-radius':'4px 4px 0px 0px'});
                                            $('body').click(function(){
                                                $('.result').html('');
                                                $('.result').css({'box-shadow':'none'});
                                                $('#'+attrib+'-".$val['id']."').css({'border-radius':'4px','border-bottom':'1px solid rgb(204,204,204)'});
                                            });
                                        }
                                    });
                                });
                            }
                        });
                    ");
                ?>
                <?php
                    $this->registerJs("
                        var newOption = $('<option>');
                        newOption.attr('value','0').text('Others');
                        $('#ppa_focused_id-".$val['id']."').append(newOption);
                    ");
                ?>
                <br/>
                <textarea placeholder="Cause of the Gender Issue" type="text" class="form-control" rows="2" id="cause_gender_issue-<?= $val['id']?>"></textarea>
                <ul id="result-cause_gender_issue-<?= $val['id'] ?>" class="result"></ul>
                <?php
                    $urlCauseGenderIssue = \yii\helpers\Url::to(['/report/default/load-cause-gender-issue']);
                    $this->registerJs("
                        $('#cause_gender_issue-".$val['id']."').keyup(function(){
                            var searchField = $(this).val();
                            var expression = new RegExp(searchField, 'i');
                            var value_length = $(this).val();
                            var attrib = 'cause_gender_issue';
                            $('#message-'+attrib+'-".$val['id']."').hide();
                            if(value_length.length>= 3){
                                $.getJSON('".$urlCauseGenderIssue."', function(data){
                                    $('#result-'+attrib+'-".$val['id']."').html('');
                                    $.each(data, function(key, value){
                                        if(value.title.search(expression) != -1)
                                        {
                                            var tarea_obj_wid = $('#'+attrib+'-".$val['id']."').width();
                                            var tarea_obj_wid_res = tarea_obj_wid+25 + 'px';
                                            $('#result-'+attrib+'-".$val['id']."').append('<li id='+attrib+'-li-'+value.id+'>'+value.title+'</li>');

                                            $('#result-'+attrib+'-".$val['id']."').css({'width': tarea_obj_wid_res,'box-shadow':'0.5px 0.5px 0.5px 1px skyblue'});
                                            $('#result-'+attrib+'-".$val['id']." li#'+attrib+'-li-'+value.id+'').click(function(){
                                                $('#'+attrib+'-".$val['id']."').val($(this).text());
                                                $('#result-'+attrib+'-".$val['id']."').html('');
                                            });
                                            $('#'+attrib+'-".$val['id']."').css({'border-bottom':'none','border-radius':'4px 4px 0px 0px'});
                                            $('body').click(function(){
                                                $('.result').html('');
                                                $('.result').css({'box-shadow':'none'});
                                                $('#'+attrib+'-".$val['id']."').css({'border-radius':'4px','border-bottom':'1px solid rgb(204,204,204)'});
                                            });
                                        }
                                    });
                                });
                            }
                        });
                    ");
                ?>
                <br/>
                <textarea placeholder="GAD Objective" type="text" rows="2" id="objective-<?= $val['id']?>" class="form-control"></textarea>
                <ul id="result-obj-<?= $val['id'] ?>" class="result"></ul>
                <?php
                    $urlPbObjective = \yii\helpers\Url::to(['/report/default/load-pb-objective']);
                    $this->registerJs("
                        $('#objective-".$val['id']."').keyup(function(){
                            var searchField = $(this).val();
                            var expression = new RegExp(searchField, 'i');
                            var value_obj = $(this).val();
                            if(value_obj.length>= 3){
                                $.getJSON('".$urlPbObjective."', function(data){
                                    $('#result-obj-".$val['id']."').html('');
                                    $.each(data, function(key, value){
                                        if(value.title.search(expression) != -1)
                                        {
                                            var tarea_obj_wid = $('#objective-".$val['id']."').width();
                                            var tarea_obj_wid_res = tarea_obj_wid+25 + 'px';
                                            $('#result-obj-".$val['id']."').append('<li id=obj-li-'+value.id+'>'+value.title+'</li>');

                                            $('#result-obj-".$val['id']."').css({'width': tarea_obj_wid_res,'box-shadow':'0.5px 0.5px 0.5px 1px skyblue'});
                                            $('#result-obj-".$val['id']." li#obj-li-'+value.id+'').click(function(){
                                                $('#objective-".$val['id']."').val($(this).text());
                                                $('#result-obj-".$val['id']."').html('');
                                            });
                                            $('#objective-".$val['id']."').css({'border-bottom':'none','border-radius':'4px 4px 0px 0px'});
                                            $('body').click(function(){
                                                $('.result').html('');
                                                $('.result').css({'box-shadow':'none'});
                                                $('#objective-".$val['id']."').css({'border-radius':'4px','border-bottom':'1px solid rgb(204,204,204)'});
                                            });
                                        }
                                    });
                                });
                            }
                        });
                    ");
                ?>
            </div>
            <div class="col-sm-4">
                <textarea type="text" placeholder=" Relevant LGU Program or Project" id="relevant_lgu_program_project-<?= $val['id']?>"rows="2" class="form-control"></textarea>
                <ul id="result-relevant_lgu_program_project-<?= $val['id'] ?>" class="result"></ul>
                <?php
                    $urlRelevant = \yii\helpers\Url::to(['/report/default/load-relevant-lgu']);
                    $this->registerJs("
                        $('#relevant_lgu_program_project-".$val['id']."').keyup(function(){
                            var searchField = $(this).val();
                            var expression = new RegExp(searchField, 'i');
                            var value_length = $(this).val();
                            var attrib = 'relevant_lgu_program_project';
                            if(value_length.length>= 3){
                                $.getJSON('".$urlRelevant."', function(data){
                                    $('#result-'+attrib+'-".$val['id']."').html('');
                                    $.each(data, function(key, value){
                                        if(value.title.search(expression) != -1)
                                        {
                                            var tarea_obj_wid = $('#'+attrib+'-".$val['id']."').width();
                                            var tarea_obj_wid_res = tarea_obj_wid+25 + 'px';
                                            $('#result-'+attrib+'-".$val['id']."').append('<li id='+attrib+'-li-'+value.id+'>'+value.title+'</li>');

                                            $('#result-'+attrib+'-".$val['id']."').css({'width': tarea_obj_wid_res,'box-shadow':'0.5px 0.5px 0.5px 1px skyblue'});
                                            $('#result-'+attrib+'-".$val['id']." li#'+attrib+'-li-'+value.id+'').click(function(){
                                                $('#'+attrib+'-".$val['id']."').val($(this).text());
                                                $('#result-'+attrib+'-".$val['id']."').html('');
                                            });
                                            $('#'+attrib+'-".$val['id']."').css({'border-bottom':'none','border-radius':'4px 4px 0px 0px'});
                                            $('body').click(function(){
                                                $('.result').html('');
                                                $('.result').css({'box-shadow':'none'});
                                                $('#'+attrib+'-".$val['id']."').css({'border-radius':'4px','border-bottom':'1px solid rgb(204,204,204)'});
                                            });
                                        }
                                    });
                                });
                            }
                        });
                    ");
                ?>
                <br/>
                <textarea placeholder="GAD Activity" type="text" id="activity-<?= $val['id']?>" class="form-control" rows="2"></textarea>
                <ul id="result-activity-<?= $val['id'] ?>" class="result"></ul>
                <?php
                    $urlActivity = \yii\helpers\Url::to(['/report/default/load-activity']);
                    $this->registerJs("
                        $('#activity-".$val['id']."').keyup(function(){
                            var searchField = $(this).val();
                            var expression = new RegExp(searchField, 'i');
                            var value_length = $(this).val();
                            var attrib = 'activity';
                            if(value_length.length>= 3){
                                $.getJSON('".$urlActivity."', function(data){
                                    $('#result-'+attrib+'-".$val['id']."').html('');
                                    $.each(data, function(key, value){
                                        if(value.title.search(expression) != -1)
                                        {
                                            var tarea_obj_wid = $('#'+attrib+'-".$val['id']."').width();
                                            var tarea_obj_wid_res = tarea_obj_wid+25 + 'px';
                                            $('#result-'+attrib+'-".$val['id']."').append('<li id='+attrib+'-li-'+value.id+'>'+value.title+'</li>');

                                            $('#result-'+attrib+'-".$val['id']."').css({'width': tarea_obj_wid_res,'box-shadow':'0.5px 0.5px 0.5px 1px skyblue'});
                                            $('#result-'+attrib+'-".$val['id']." li#'+attrib+'-li-'+value.id+'').click(function(){
                                                $('#'+attrib+'-".$val['id']."').val($(this).text());
                                                $('#result-'+attrib+'-".$val['id']."').html('');
                                            });
                                            $('#'+attrib+'-".$val['id']."').css({'border-bottom':'none','border-radius':'4px 4px 0px 0px'});
                                            $('body').click(function(){
                                                $('.result').html('');
                                                $('.result').css({'box-shadow':'none'});
                                                $('#'+attrib+'-".$val['id']."').css({'border-radius':'4px','border-bottom':'1px solid rgb(204,204,204)'});
                                            });
                                        }
                                    });
                                });
                            }
                        });
                    ");
                ?>
                <br/>
                <textarea placeholder="Performance Target" type="text" id="performance_target-<?= $val['id']?>" class="form-control" rows="2"></textarea>
                <ul id="result-performance_target-<?= $val['id'] ?>" class="result"></ul>
                <?php
                    $urlPerformance = \yii\helpers\Url::to(['/report/default/load-performance-target']);
                    $this->registerJs("
                        $('#performance_target-".$val['id']."').keyup(function(){
                            var searchField = $(this).val();
                            var expression = new RegExp(searchField, 'i');
                            var value_length = $(this).val();
                            var attrib = 'performance_target';
                            if(value_length.length>= 3){
                                $.getJSON('".$urlPerformance."', function(data){
                                    $('#result-'+attrib+'-".$val['id']."').html('');
                                    $.each(data, function(key, value){
                                        if(value.title.search(expression) != -1)
                                        {
                                            var tarea_obj_wid = $('#'+attrib+'-".$val['id']."').width();
                                            var tarea_obj_wid_res = tarea_obj_wid+25 + 'px';
                                            $('#result-'+attrib+'-".$val['id']."').append('<li id='+attrib+'-li-'+value.id+'>'+value.title+'</li>');

                                            $('#result-'+attrib+'-".$val['id']."').css({'width': tarea_obj_wid_res,'box-shadow':'0.5px 0.5px 0.5px 1px skyblue'});
                                            $('#result-'+attrib+'-".$val['id']." li#'+attrib+'-li-'+value.id+'').click(function(){
                                                $('#'+attrib+'-".$val['id']."').val($(this).text());
                                                $('#result-'+attrib+'-".$val['id']."').html('');
                                            });
                                            $('#'+attrib+'-".$val['id']."').css({'border-bottom':'none','border-radius':'4px 4px 0px 0px'});
                                            $('body').click(function(){
                                                $('.result').html('');
                                                $('.result').css({'box-shadow':'none'});
                                                $('#'+attrib+'-".$val['id']."').css({'border-radius':'4px','border-bottom':'1px solid rgb(204,204,204)'});
                                            });
                                        }
                                    });
                                });
                            }
                        });
                    ");
                ?>
                <br/>
                <textarea placeholder="Performance Indicator" type="text" id="performance_indicator-<?= $val['id']?>" class="form-control" rows="2"></textarea>
                <ul id="result-performance_indicator-<?= $val['id'] ?>" class="result"></ul>
                <?php
                    $urlPerformance = \yii\helpers\Url::to(['/report/default/load-performance-indicator']);
                    $this->registerJs("
                        $('#performance_indicator-".$val['id']."').keyup(function(){
                            var searchField = $(this).val();
                            var expression = new RegExp(searchField, 'i');
                            var value_length = $(this).val();
                            var attrib = 'performance_indicator';
                            if(value_length.length>= 3){
                                $.getJSON('".$urlPerformance."', function(data){
                                    $('#result-'+attrib+'-".$val['id']."').html('');
                                    $.each(data, function(key, value){
                                        if(value.title.search(expression) != -1)
                                        {
                                            var tarea_obj_wid = $('#'+attrib+'-".$val['id']."').width();
                                            var tarea_obj_wid_res = tarea_obj_wid+25 + 'px';
                                            $('#result-'+attrib+'-".$val['id']."').append('<li id='+attrib+'-li-'+value.id+'>'+value.title+'</li>');

                                            $('#result-'+attrib+'-".$val['id']."').css({'width': tarea_obj_wid_res,'box-shadow':'0.5px 0.5px 0.5px 1px skyblue'});
                                            $('#result-'+attrib+'-".$val['id']." li#'+attrib+'-li-'+value.id+'').click(function(){
                                                $('#'+attrib+'-".$val['id']."').val($(this).text());
                                                $('#result-'+attrib+'-".$val['id']."').html('');
                                            });
                                            $('#'+attrib+'-".$val['id']."').css({'border-bottom':'none','border-radius':'4px 4px 0px 0px'});
                                            $('body').click(function(){
                                                $('.result').html('');
                                                $('.result').css({'box-shadow':'none'});
                                                $('#'+attrib+'-".$val['id']."').css({'border-radius':'4px','border-bottom':'1px solid rgb(204,204,204)'});
                                            });
                                        }
                                    });
                                });
                            }
                        });
                    ");
                ?>
            </div>
            <div class="col-sm-4">
                <input placeholder="MOOE" type="text" rows="2" id="budget_mooe-<?= $val['id']?>" class="form-control priceformat">
                <ul id="result-budget_mooe-<?= $val['id'] ?>" class="result"></ul>
                <?php
                    $urlMooe = \yii\helpers\Url::to(['/report/default/load-budget-mooe']);
                    $this->registerJs("
                        $('#budget_mooe-".$val['id']."').keyup(function(){
                            var searchField = $(this).val();
                            var expression = new RegExp(searchField, 'i');
                            var value_length = $(this).val();
                            var attrib = 'budget_mooe';
                            if(value_length.length>= 3){
                                $.getJSON('".$urlMooe."', function(data){
                                    $('#result-'+attrib+'-".$val['id']."').html('');
                                    $.each(data, function(key, value){
                                        if(value.title.search(expression) != -1)
                                        {
                                            var tarea_obj_wid = $('#'+attrib+'-".$val['id']."').width();
                                            var tarea_obj_wid_res = tarea_obj_wid+25 + 'px';
                                            $('#result-'+attrib+'-".$val['id']."').append('<li id='+attrib+'-li-'+value.id+'>'+value.title+'</li>');

                                            $('#result-'+attrib+'-".$val['id']."').css({'width': tarea_obj_wid_res,'box-shadow':'0.5px 0.5px 0.5px 1px skyblue'});
                                            $('#result-'+attrib+'-".$val['id']." li#'+attrib+'-li-'+value.id+'').click(function(){
                                                $('#'+attrib+'-".$val['id']."').val($(this).text());
                                                $('#result-'+attrib+'-".$val['id']."').html('');
                                            });
                                            $('#'+attrib+'-".$val['id']."').css({'border-bottom':'none','border-radius':'4px 4px 0px 0px'});
                                            $('body').click(function(){
                                                $('.result').html('');
                                                $('.result').css({'box-shadow':'none'});
                                                $('#'+attrib+'-".$val['id']."').css({'border-radius':'4px','border-bottom':'1px solid rgb(204,204,204)'});
                                            });
                                        }
                                    });
                                });
                            }
                        });
                    ");
                ?>
                <br/>
                <input placeholder="PS" type="text" id="budget_ps-<?= $val['id']?>" class="form-control">
                <ul id="result-budget_ps-<?= $val['id'] ?>" class="result"></ul>
                <?php
                    $urlBudgetPs = \yii\helpers\Url::to(['/report/default/load-budget-ps']);
                    $this->registerJs("
                        $('#budget_ps-".$val['id']."').keyup(function(){
                            var searchField = $(this).val();
                            var expression = new RegExp(searchField, 'i');
                            var value_length = $(this).val();
                            var attrib = 'budget_ps';
                            if(value_length.length>= 3){
                                $.getJSON('".$urlBudgetPs."', function(data){
                                    $('#result-'+attrib+'-".$val['id']."').html('');
                                    $.each(data, function(key, value){
                                        if(value.title.search(expression) != -1)
                                        {
                                            var tarea_obj_wid = $('#'+attrib+'-".$val['id']."').width();
                                            var tarea_obj_wid_res = tarea_obj_wid+25 + 'px';
                                            $('#result-'+attrib+'-".$val['id']."').append('<li id='+attrib+'-li-'+value.id+'>'+value.title+'</li>');

                                            $('#result-'+attrib+'-".$val['id']."').css({'width': tarea_obj_wid_res,'box-shadow':'0.5px 0.5px 0.5px 1px skyblue'});
                                            $('#result-'+attrib+'-".$val['id']." li#'+attrib+'-li-'+value.id+'').click(function(){
                                                $('#'+attrib+'-".$val['id']."').val($(this).text());
                                                $('#result-'+attrib+'-".$val['id']."').html('');
                                            });
                                            $('#'+attrib+'-".$val['id']."').css({'border-bottom':'none','border-radius':'4px 4px 0px 0px'});
                                            $('body').click(function(){
                                                $('.result').html('');
                                                $('.result').css({'box-shadow':'none'});
                                                $('#'+attrib+'-".$val['id']."').css({'border-radius':'4px','border-bottom':'1px solid rgb(204,204,204)'});
                                            });
                                        }
                                    });
                                });
                            }
                        });
                    ");
                ?>
                <br/>
                <input placeholder="CO" type="text" id="budget_co-<?= $val['id']?>" class="form-control">
                <ul id="result-budget_co-<?= $val['id'] ?>" class="result"></ul>
                <?php
                    $urlBudgetCo = \yii\helpers\Url::to(['/report/default/load-budget-co']);
                    $this->registerJs("
                        $('#budget_co-".$val['id']."').keyup(function(){
                            var searchField = $(this).val();
                            var expression = new RegExp(searchField, 'i');
                            var value_length = $(this).val();
                            var attrib = 'budget_co';
                            if(value_length.length>= 3){
                                $.getJSON('".$urlBudgetCo."', function(data){
                                    $('#result-'+attrib+'-".$val['id']."').html('');
                                    $.each(data, function(key, value){
                                        if(value.title.search(expression) != -1)
                                        {
                                            var tarea_obj_wid = $('#'+attrib+'-".$val['id']."').width();
                                            var tarea_obj_wid_res = tarea_obj_wid+25 + 'px';
                                            $('#result-'+attrib+'-".$val['id']."').append('<li id='+attrib+'-li-'+value.id+'>'+value.title+'</li>');

                                            $('#result-'+attrib+'-".$val['id']."').css({'width': tarea_obj_wid_res,'box-shadow':'0.5px 0.5px 0.5px 1px skyblue'});
                                            $('#result-'+attrib+'-".$val['id']." li#'+attrib+'-li-'+value.id+'').click(function(){
                                                $('#'+attrib+'-".$val['id']."').val($(this).text());
                                                $('#result-'+attrib+'-".$val['id']."').html('');
                                            });
                                            $('#'+attrib+'-".$val['id']."').css({'border-bottom':'none','border-radius':'4px 4px 0px 0px'});
                                            $('body').click(function(){
                                                $('.result').html('');
                                                $('.result').css({'box-shadow':'none'});
                                                $('#'+attrib+'-".$val['id']."').css({'border-radius':'4px','border-bottom':'1px solid rgb(204,204,204)'});
                                            });
                                        }
                                    });
                                });
                            }
                        });
                    ");
                ?>
                <br/>
                <textarea placeholder="Lead or Responsible Office" type="text" rows="2" id="lead_responsible_office-<?= $val['id']?>" class="form-control"></textarea>
                <ul id="result-lead_responsible_office-<?= $val['id'] ?>" class="result"></ul>
                <?php
                    $urlLeadResponsible = \yii\helpers\Url::to(['/report/default/load-lead-responsible']);
                    $this->registerJs("
                        $('#lead_responsible_office-".$val['id']."').keyup(function(){
                            var searchField = $(this).val();
                            var expression = new RegExp(searchField, 'i');
                            var value_length = $(this).val();
                            var attrib = 'lead_responsible_office';
                            if(value_length.length>= 3){
                                $.getJSON('".$urlLeadResponsible."', function(data){
                                    $('#result-'+attrib+'-".$val['id']."').html('');
                                    $.each(data, function(key, value){
                                        if(value.title.search(expression) != -1)
                                        {
                                            var tarea_obj_wid = $('#'+attrib+'-".$val['id']."').width();
                                            var tarea_obj_wid_res = tarea_obj_wid+25 + 'px';
                                            $('#result-'+attrib+'-".$val['id']."').append('<li id='+attrib+'-li-'+value.id+'>'+value.title+'</li>');

                                            $('#result-'+attrib+'-".$val['id']."').css({'width': tarea_obj_wid_res,'box-shadow':'0.5px 0.5px 0.5px 1px skyblue'});
                                            $('#result-'+attrib+'-".$val['id']." li#'+attrib+'-li-'+value.id+'').click(function(){
                                                $('#'+attrib+'-".$val['id']."').val($(this).text());
                                                $('#result-'+attrib+'-".$val['id']."').html('');
                                            });
                                            $('#'+attrib+'-".$val['id']."').css({'border-bottom':'none','border-radius':'4px 4px 0px 0px'});
                                            $('body').click(function(){
                                                $('.result').html('');
                                                $('.result').css({'box-shadow':'none'});
                                                $('#'+attrib+'-".$val['id']."').css({'border-radius':'4px','border-bottom':'1px solid rgb(204,204,204)'});
                                            });
                                        }
                                    });
                                });
                            }
                        });
                    ");
                ?>
                <br/>
                <button type="button" class="btn btn-primary btn-sm" title="Save" id="save-gender-issue-<?= $val['id']?>">
                    <span class="glyphicon glyphicon-floppy-disk"></span> Save
                </button>
                <?php
                    $url = \yii\helpers\Url::to(['/report/default/create-gad-plan-budget']);
                    $this->registerJs('
                        $("#save-gender-issue-'.$val['id'].'").click(function(){
                            var ppa_focused_id     = $("#ppa_focused_id-'.$val['id'].'").val();
                            var ppa_value     = $("#ppa_value-'.$val['id'].'").val();
                            var issue       = $("#cause_gender_issue-'.$val['id'].'").val();
                            var obj         = $("#objective-'.$val['id'].'").val();
                            var relevant    = $("#relevant_lgu_program_project-'.$val['id'].'").val();
                            var act         = $("#activity-'.$val['id'].'").val();
                            var performance_target     = $("#performance_target-'.$val['id'].'").val();
                            var performance_indicator     = $("#performance_indicator-'.$val['id'].'").val();
                            var budget_mooe = $("#budget_mooe-'.$val['id'].'").val();
                            var budget_ps   = $("#budget_ps-'.$val['id'].'").val();
                            var budget_co   = $("#budget_co-'.$val['id'].'").val();
                            var lead_responsible_office   = $("#lead_responsible_office-'.$val['id'].'").val();
                            var ruc         = "'.$ruc.'";

                            $.ajax({
                                url: "'.$url.'",
                                data: { 
                                        issue:issue,
                                        obj:obj,
                                        relevant:relevant,
                                        act:act,
                                        performance_indicator:performance_indicator,
                                        performance_target:performance_target,
                                        ruc:ruc,
                                        ppa_focused_id:ppa_focused_id,
                                        ppa_value:ppa_value,
                                        budget_mooe:budget_mooe,
                                        budget_ps:budget_ps,
                                        budget_co:budget_co,
                                        lead_responsible_office:lead_responsible_office
                                    }
                                
                                }).done(function(result) {
                                    $.each(result, function( index, value ) {
                                        
                                        $("p#message-"+index+"-'.$val["id"].'").text("");
                                        $("textarea#"+index+"-'.$val['id'].'").css({"border":"1px solid red"});
                                        $("textarea#"+index+"-'.$val['id'].'").after("<p id=message-"+index+"-'.$val["id"].' style=color:red;font-style:italic;>"+value+"</p>");

                                        $("input#"+index+"-'.$val['id'].'").css({"border":"1px solid red"});
                                        $("input#"+index+"-'.$val['id'].'").after("<p id=message-"+index+"-'.$val["id"].' style=color:red;font-style:italic;>"+value+"</p>");

                                        $("#select2-"+index+"-'.$val["id"].'-container").parent(".select2-selection").css({"border":"1px solid red"});
                                        $("#select2-"+index+"-'.$val["id"].'-container").parent(".select2-selection").after("<p id=message-"+index+"-'.$val["id"].' style=color:red;font-style:italic;>"+value+"</p>");

                                        // $("#select2-"+index+"-'.$val["id"].'-container").text
                                        
                                        $("textarea#"+index+"-'.$val['id'].'").keyup(function(){
                                            $("#message-"+index+"-'.$val["id"].'").text("");
                                            $(this).css({"border":"1px solid #ccc"});
                                        });

                                        $("input#"+index+"-'.$val['id'].'").keyup(function(){
                                            $("#message-"+index+"-'.$val["id"].'").text("");
                                            $(this).css({"border":"1px solid #ccc"});
                                        });

                                        if($("#ppa_focused_id-'.$val["id"].'").val() == "")
                                        {
                                            $("#message-ppa_value-'.$val["id"].'").hide();
                                        }
                                    });
                            });
                      }); ');
                ?>
                <button type="button" class="btn btn-danger btn-sm" title="Exit" id="exit-gender-issue">
                    <span class="glyphicon glyphicon-remove"></span> Exit
                </button>
                <?php
                    $this->registerJs('
                        $("#exit-gender-issue").click(function(){
                            $("#genderIssueInputForm").slideUp(300);
                        });
                    ');
                ?>
            </div>
        </div>
                
            <!-- </td>
            <td> -->
                
                
    </td>
 </tr>
            <!-- <td class="td-ppa_focused_id-<?= $val['id']; ?>" colspan="1"> -->
                
