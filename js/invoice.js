$(document).ready(function(){
	
	$('input[type="text"]').focusout(function() {
	    $('input[type="text"]').removeClass('blur');
	    $(this).addClass('blur');
	    
	    var currentId = $(this).attr('id');
		
		var dt = currentId.substr(0, 10);
		var store = currentId.substr(11, 2);
		var amount = $('#'+currentId).val();
		
		
		if (currentId.length = 13){
		
		
			if(!$.isNumeric(amount)) {
				
			}
			else{
				$.post('../update-cellphone-goal.php', {dt: dt, store: store, amount: amount}, function(data){
				
				});
			}

		}
	});
	
	
	$('input').keypress(function(e) {
		if(e.which == 13) {
			var txtID = $(this).attr('id');
			$("#"+txtID).blur();
		}
	});
	
	
});