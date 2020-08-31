$(document).ready(function(){
	var id = "";
	var qty = "";
	var qty_old = "";
	
	var retail = "";
	var retail_old = "";
	
	var total = "";
	var invoice_hash = $('#invoicehash').val();
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
					
					
					var data = {invoice: invoice_hash, id: id, qty: qty, total:total, update:'qty'};					
					jQuery.ajax({
					type: 'POST',
					url: 'php-scripts/process-update-invoice-adjustments.php',
					data: data,
					dataType: 'json',
					success: function(response) {
											
						$('#invoice_sub_total').text(response[1]);
						$('#invoice_tax').text(response[2]);
						$('#invoice_grand_total').text(response[3]);
						
						}
					});
					
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
					
					var data = {invoice: invoice_hash, id: id, retail: retail, total:total, update:'retail'};					
					jQuery.ajax({
					type: 'POST',
					url: 'php-scripts/process-update-invoice-adjustments.php',
					data: data,
					dataType: 'json',
					success: function(response) {
											
						$('#invoice_sub_total').text(response[1]);
						$('#invoice_tax').text(response[2]);
						$('#invoice_grand_total').text(response[3]);
						
						}
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
	
	$("#save_note").click(function(){
		var note_text = $('#invoice_note').val();
		invoice_hash = $('#invoicehash').val();
		$.post( "php-scripts/process-update-invoice-adjustments.php", { invoice: invoice_hash, txt: note_text } );
	});
	
	var text_max = 500;
$('#count_label').html('0 / ' + text_max );

$('#invoice_note').keyup(function() {
  var text_length = $('#invoice_note').val().length;
  var text_remaining = text_max - text_length;
  
  $('#count_label').html(text_length + ' / ' + text_max);
});


	
});