$(document).ready(function(){
var currentcustomer = $('#current_customer').val();
var currentorder = $('#current_order').val();
var ordertype = $('#order_type').val();

$(document).on('click', 'span', function () {
	var $id1 = (this.id);
    $id1 = $id1.replace("label", "div");
	$("#"+$id1).toggle("slow");
	
});

/*
$(document).on('mouseover', 'div', function () {
	var $id2 = (this.id);
    $id2 = $id2.replace("SingleItemBox", "");
	$("#OrderDiv"+$id2).show();
	
});

$(document).on('mouseout', 'div', function () {
	var $id3 = (this.id);
    $id3 = $id3.replace("SingleItemBox", "");
	$("#OrderDiv"+$id3).hide();
	
});
*/
$(document).on('click', 'input:button', function () {
	var $id = (this.id);
    $id = $id.replace("minus", "");
    $id = $id.replace("plus", "");
	
	if (this.id == 'minus'+$id){
		var num = +$("#qty"+$id).val() - 1;
		if (num <= 0){
			num = 0;
			$('#greenCircle'+$id).hide();
		}
		$("#qty"+$id).val(num);
		
		$.post('php-scripts/process-update-qty.php', {cert_code: $id, qty: num, customer:currentcustomer, order:currentorder, ordertype:ordertype}, function(data){
		if (num > 0){
			$('#greenCircle'+$id).show();
			$('#greenCircle'+$id).text(num);
			
		}
 
		});
		
		
	}
	else if (this.id == 'plus'+$id){
		var num = +$("#qty"+$id).val() + 1;
		$("#qty"+$id).val(num);
		
		$.post('php-scripts/process-update-qty.php', {cert_code: $id, qty: num, customer: currentcustomer, order:currentorder, ordertype:ordertype}, function(data){
			
		if (num > 0){
			$('#greenCircle'+$id).show();
			$('#greenCircle'+$id).text(num);
			
		}
		});

	}
});

});

