<input style="<?= $customStyle ?>" placeholder="<?= $placeholder_title ?>" type="text"  id="<?= $attribute_name ?>" class="<?= $classValue ?>">
<ul id="result-<?= $attribute_name ?>" class="result"></ul>
<?php
    $loadResults = \yii\helpers\Url::to([$urlLoadResult]);
    $this->registerJs("
        $('#".$attribute_name."').keyup(function(){
            var searchField = $(this).val();
            var expression = new RegExp(searchField, 'i');
            var value_length = $(this).val();
            var attrib = '".$attribute_name."';
            if(value_length.length>= 3){
                $.getJSON('".$loadResults."', function(data){
                    $('#result-'+attrib+'').html('');
                    $.each(data, function(key, value){
                        if(value.title.search(expression) != -1)
                        {
                            var tarea_obj_wid = $('#'+attrib+'').width();
                            var tarea_obj_wid_res = tarea_obj_wid+25 + 'px';
                            $('#result-'+attrib+'').append('<li id='+attrib+'-li-'+value.id+'>'+value.title+'</li>');

                            $('#result-'+attrib+'').css({'width': tarea_obj_wid_res,'box-shadow':'0.5px 0.5px 0.5px 1px skyblue'});
                            $('#result-'+attrib+' li#'+attrib+'-li-'+value.id+'').click(function(){
                                $('#'+attrib+'').val($(this).text());
                                $('#result-'+attrib+'').html('');
                            });
                            $('#'+attrib+'').css({'border-bottom':'none','border-radius':'4px 4px 0px 0px'});
                            $('body').click(function(){
                                $('.result').html('');
                                $('.result').css({'box-shadow':'none'});
                                $('#'+attrib+'').css({'border-radius':'4px','border-bottom':'1px solid rgb(204,204,204)'});
                            });
                        }
                    });
                });
            }
        });
    ");
?>