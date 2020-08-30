$(document).ready(function(){
	var id = "";
	var qty = "";
	$('input[type="number"]').focusout(function() {
	    $('input[type="number"]').removeClass('blur');
	    $(this).addClass('blur');
	    var currentId = $(this).attr('id');
	    if (currentId.indexOf("qty") >= 0){
				id = $(this).attr('id').replace('qty', '');
				qty = $(this).val();
				alert(qty);
			}
		
		if(!$.isNumeric(qtu)) {
				
			}
			else{
				//$.post('../update-cellphone-goal.php', {dt: dt, store: store, amount: amount}, function(data){
				
				//});
			}
	});
	
	
	$('input').keypress(function(e) {
		if(e.which == 13) {
			var txtID = $(this).attr('id');
			$("#"+txtID).blur();
		}
	});
	
	
});