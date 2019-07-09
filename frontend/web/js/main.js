$(document).ready(function(){
	$('.modalButton').click(function(){
		$("#modalContent").html("");
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });

});
