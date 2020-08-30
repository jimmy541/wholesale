$(document).ready(function(){
	var id = "";
	var qty = "";
	var qty_old = "";
	
	var retail = "";
	var retail_old = "";
	
	var total = "";
	
	//store the number in current input incase user enter invalid number
	$('input').focus(function(){
		var currentId = $(this).attr('id');
		if (currentId.indexOf("qty") >= 0){
				qty_old = $(this).val();
		}
		if (currentId.indexOf("retail") >= 0){
				retail_old = $(this).val();
		}
		
	});
	
	$('input[type="number"]').focusout(function() {
	    $('input[type="number"]').removeClass('blur');
	    $(this).addClass('blur');
	    var currentId = $(this).attr('id');
	    if (currentId.indexOf("qty") >= 0){
				id = $(this).attr('id').replace('qty', '');
				qty = $(this).val();
				
				if(!$.isNumeric(qty)) {
					$(this).val(qty_old);
				}
				else{
					
					retail = $("#retail"+id).val();
					total = (retail * qty).toFixed(2);
					$("#total"+id).text(total);
					
					
					//$.post('../update-cellphone-goal.php', {dt: dt, store: store, amount: amount}, function(data){
				
					//});
				}
				
			}
		if (currentId.indexOf("retail") >= 0){
				id = $(this).attr('id').replace('retail', '');
				retail = $(this).val();
				if(!$.isNumeric(retail)) {
					$(this).val(retail_old);
				}
				else{
					qty = $("#qty"+id).val();
					$("#total"+id).text(retail * qty);
					total = (retail * qty).toFixed(2);
					$("#total"+id).text(total);
					
					//$.post('../update-cellphone-goal.php', {dt: dt, store: store, amount: amount}, function(data){
				
					//});
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