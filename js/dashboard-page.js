$(document).ready(function(){

	$("#place-order-template1,#place-order-template1-2").click(function () {
		$(".populateDivOrderCustomer").show();
		$("#gray-background").show();
	});
	$("#start-order").click(function () {
		var customer = $('#select-customer option:selected').val();
		var otype = $('#select-order-type option:selected').val();
		var odate = $('#order-date').val();
		if(customer){
			var order = $('#select-order option:selected').val();
			var orderparam = '';
			if(order){
				if(order != 'neworder'){
					orderparam = "&order="+order;
				}else{
					$.ajaxSetup({async:false});
					$.post('php-scripts/process-new-order-number.php', {customer:customer, otype:otype, odate:odate}, function(data){
						orderparam = "&order="+data;
					});
					$.ajaxSetup({async:true});
				}
			}
		var cat = '';
		$.ajaxSetup({async:false});
		$.post('php-scripts/process-get-category-for-order.php', {num:"1"}, function(data){
			cat = data;
		});
		$.ajaxSetup({async:true});
		window.location.href = "order.php?acat="+cat+"&customer="+customer+orderparam;	
		$(".populateDivOrderCustomer").hide();
		$("#gray-background").hide();
		}
	});
	$("#cancel-order").click(function () {
		$(".populateDivOrderCustomer").hide();
		$("#gray-background").hide();
		
	});
	
	$( "#select-customer" ).change(function() {
		var customer = $('#select-customer option:selected').val();
		var otype = $('#select-order-type option:selected').val();
		if(customer){
			$.ajax({
            url: 'php-scripts/process-get-order-of-customer.php',
            type: 'post',
            data: {customer:customer, otype:otype},
            dataType: 'json',
            success:function(response){

                var len = response.length;

                $("#select-order").empty();
				$("#select-order").append("<option value='neworder'>New order</option>");
                for( var i = 0; i<len; i++){
                    var id = response[i]['innum'];
                    var name = response[i]['dstarted'];
                    
                    $("#select-order").append("<option value='"+id+"'>"+name+"</option>");

                }
            }
			});
		}
	});
	$( "#select-order-type" ).change(function() {
		var customer = $('#select-customer option:selected').val();
		var otype = $('#select-order-type option:selected').val();
		if(customer){
			$.ajax({
            url: 'php-scripts/process-get-order-of-customer.php',
            type: 'post',
            data: {customer:customer, otype:otype},
            dataType: 'json',
            success:function(response){

                var len = response.length;

                $("#select-order").empty();
				$("#select-order").append("<option value='neworder'>New order</option>");
                for( var i = 0; i<len; i++){
                    var id = response[i]['innum'];
                    var name = response[i]['dstarted'];
                    
                    $("#select-order").append("<option value='"+id+"'>"+name+"</option>");

                }
            }
			});
		}
	});

});