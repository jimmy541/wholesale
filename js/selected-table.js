$(document).ready(function() {
	$('#gtable tfoot th').each( function () {
        var title = $(this).text();
		if(title == 'Account Number' || title == 'Business Name'){
			$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
		}
    } );
	
	var pTable = '';
    var table = $('#gtable').DataTable({
		initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
 
                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        },
		 "order": [],
		"columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            },
			{
                "targets": [ 1 ],
                "visible": false,
                "searchable": false
            },
			
		]
		
		
	});
	
	
    $('#gtable tbody').on( 'click', 'tr', function () {
		if ( $(this).hasClass('disable-select') ) {
			
		}else{
			
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
				$('#invoicehash').val('');
				$('#customerid').val('');
				$('#customerhash').val('');
				$('#paymentid').val('');
				$('#invoice-number').val('');
				$( ".invoice-top-buttons" ).closest( "ul" ).addClass("invoice-top-buttons-disabled");
				$( ".invoice-top-buttons" ).closest( "ul" ).removeClass("invoice-top-buttons");
				
				
			}
			else {
				table.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var ids = $.map(table.rows('.selected').data(), function (item) {
					$('#invoicehash').val(item[0]);
					$('#customerid').val(item[0]);
					$('#customerhash').val(item[1]);
					$('#paymentid').val(item[2]);
					$('#invoice-number').val(item[3]);
					$( ".invoice-top-buttons-disabled" ).closest( "ul" ).addClass("invoice-top-buttons");
					$( ".invoice-top-buttons-disabled" ).closest( "ul" ).removeClass("invoice-top-buttons-disabled");
				});
			}
		}
    });
	
	$(document).on( 'click', '#paymentsTable tbody tr', function () {
		var tb = $(this);
        if ( tb.hasClass('selected') ) {
            tb.removeClass('selected');
			$('#paymentid').val('');
			$( ".invoice-top-buttons" ).closest( "ul" ).addClass("invoice-top-buttons-disabled");
			$( ".invoice-top-buttons" ).closest( "ul" ).removeClass("invoice-top-buttons");
			
        }
        else {
			
            pTable.$('tr.selected').removeClass('selected');
            tb.addClass('selected');
			$( ".invoice-top-buttons-disabled" ).closest( "ul" ).addClass("invoice-top-buttons");
			$( ".invoice-top-buttons-disabled" ).closest( "ul" ).removeClass("invoice-top-buttons-disabled");
			var ids = $.map(pTable.rows('.selected').data(), function (item) {
				$('#paymentid').val(item[0]);
				
			});
        }
    });
	
	$('#uncusstatement').click(function(){
		var currentSel = $('#customerhash').val();
		if(currentSel){
			window.location.href = "accounts-statement.php?customer="+currentSel;
		}
	});
	$('#printstatement').click(function(){
		var currentSel = $('#customerhash').val();
		if(currentSel){
			window.location.href = "pdf-customer-statement.php?customer="+currentSel;
		}
	});
	$('#downloadstatement').click(function(){
		var currentSel = $('#customerhash').val();
		if(currentSel){
			window.location.href = "pdf-customer-statement.php?d=1&customer="+currentSel;
		}
	});
	$('#printacchistory').click(function(){
		var currentSel = $('#customerhash').val();
		var datefrom = $('#datefrom').val();
		var dateto = $('#dateto').val();
		if(currentSel){
			window.location.href = "pdf-account-history.php?customer="+currentSel+"&datefrom="+datefrom+"&dateto="+dateto;
		}
	});
	$('#downloadacchistory').click(function(){
		var currentSel = $('#customerhash').val();
		var datefrom = $('#datefrom').val();
		var dateto = $('#dateto').val();
		if(currentSel){
			window.location.href = "pdf-account-history.php?d=1&customer="+currentSel+"&datefrom="+datefrom+"&dateto="+dateto;
		}
	});
	$('#print-list').click(function(){
		window.location.href = "pdf-accounts-unpaid.php";
	});
	$('#download-list').click(function(){
		window.location.href = "pdf-accounts-unpaid.php?d=1";
	});
	$('#show-quotes').click(function(){
		var currentSel = $('#show-quotes').text();
		if(currentSel == 'Quotes'){
			window.location.href = "list-orders.php?show=quotes";
		}else{
			window.location.href = "list-orders.php";
		}	
	});
	
	$('#view-order').click(function(){
		var currentSel = $('#invoicehash').val();
		if(currentSel){
			window.location.href = "invoice.php?invoice="+currentSel;
		}
	});
	
	$('#print-order').click(function(){
		var currentSel = $('#invoicehash').val();
		if(currentSel){
			window.location.href = "pdf-invoice.php?invoice="+currentSel;
		}
	});
	
	$('#download-order').click(function(){
		var currentSel = $('#invoicehash').val();
		if(currentSel){
			window.location.href = "pdf-invoice.php?d=1&invoice="+currentSel;
		}
	});
	$('#send-order').click(function(){
		var currentSel = $('#invoicehash').val();
		if(currentSel){
			$.get("pdf-invoice.php?s=1&invoice="+currentSel);
			//return false;
			
			$('#closeIcon2').hide();
			$('#closeIcon').show();
		    $( "#populateDivSend" ).show();
			var cushash = $('#customerhash').val();
			$('#emailsubject').val('Invoice '+$('#invoice-number').val());
			$('#message_text').val('Dear Client, \nAttached is your invoice. \n\nThank you for your business!\n');
			
			$('#gray-background').show();
					$.ajax({
						url: 'php-scripts/process-get-emails-of-customer.php',
						type: 'post',
						data: {customer:cushash},
						dataType: 'json',
						success:function(response){
							var len = response.length;
							$("#emailto").empty();
							$("#emailto").append("<option value='Custom'>Custom</option>");
							$("#emailtoblock").show();
							for( var i = 0; i<len; i++){
								var fname = response[i]['fullname'];
								var email = response[i]['email'];
								$("#emailto").append("<option value='"+fname+"'>"+email+"</option>");
							}
						}
					});
		}
	});
	$('#sendstatement').click(function(){
		var currentSel = $('#customerhash').val();
		if(currentSel){
			$.get("pdf-customer-statement.php?s=1&customer="+currentSel);
			//return false;
			
			$('#closeIcon2').hide();
			$('#closeIcon').show();
		    $( "#populateDivSend" ).show();
			var cushash = $('#customerhash').val();
			$('#emailsubject').val('Statement');
			$('#message_text').val('Dear Client, \nAttached is your statement. \n\nThank you for your business!\n');
			
			$('#gray-background').show();
					$.ajax({
						url: 'php-scripts/process-get-emails-of-customer.php',
						type: 'post',
						data: {customer:cushash},
						dataType: 'json',
						success:function(response){
							var len = response.length;
							$("#emailto").empty();
							$("#emailto").append("<option value='Custom'>Custom</option>");
							$("#emailtoblock").show();
							for( var i = 0; i<len; i++){
								var fname = response[i]['fullname'];
								var email = response[i]['email'];
								$("#emailto").append("<option value='"+fname+"'>"+email+"</option>");
							}
						}
					});
		}
	});
	$('#sendhistory').click(function(){
		var currentSel = $('#customerhash').val();
		if(currentSel){
			var datefrom = $('#datefrom').val();
			var dateto = $('#dateto').val();
			$.get("pdf-account-history.php?s=1&customer="+currentSel+"&datefrom="+datefrom+"&dateto="+dateto);
			//return false;
			
			$('#closeIcon2').hide();
			$('#closeIcon').show();
		    $( "#populateDivSend" ).show();
			var cushash = $('#customerhash').val();
			$('#emailsubject').val('Account history');
			$('#message_text').val('Dear Client, \nAttached is your account history. \n\nThank you for your business!\n');
			
			$('#gray-background').show();
					$.ajax({
						url: 'php-scripts/process-get-emails-of-customer.php',
						type: 'post',
						data: {customer:cushash},
						dataType: 'json',
						success:function(response){
							var len = response.length;
							$("#emailto").empty();
							$("#emailto").append("<option value='Custom'>Custom</option>");
							$("#emailtoblock").show();
							for( var i = 0; i<len; i++){
								var fname = response[i]['fullname'];
								var email = response[i]['email'];
								$("#emailto").append("<option value='"+fname+"'>"+email+"</option>");
							}
						}
					});
		}
	});
	$('#pull-sheet').click(function(){
		var currentSel = $('#invoicehash').val();
		if(currentSel){
			window.location.href = "pdf-pull-sheet.php?invoice="+currentSel;
		}
	});
	
	$('#pay-invoice').click(function(){
		var currentSel = $('#invoicehash').val();
		$('#closeIcon2').hide();
		$('#closeIcon').show();
		
		$('#payment-saving-mode').val('new');
		if (currentSel){
				$( "#populateDivPayment" ).show();
				$('#gray-background').show();
				$('#payment_amount').val('');
				$('#ref_no').val('');
		}
	});
	
	$('#edit-customer').click(function(){
		var currentSel = $('#customerhash').val();
		var currentSel2 = $('#customerid').val();
		if(currentSel && currentSel2){
			window.location.href = "edit-customer.php?account="+currentSel2+"&token="+currentSel;
		}
	});
	$('#view-customer-invoices').click(function(){
		var currentSel = $('#customerhash').val();
		if(currentSel){
			window.location.href = "list-orders.php?customer="+currentSel;
		}
	});
	$('#customer-statement-ll').click(function(){
		var currentSel = $('#customerhash').val();
		if(currentSel){
			window.location.href = "accounts-statement.php?customer="+currentSel;
		}
	});
	$('#customer-list-acchistory').click(function(){
		var currentSel = $('#customerhash').val();
		var dToday = $('#todaydate').val();
		var d3months = $('#prior3months').val();
		
		if(currentSel){
			window.location.href = "accounts-history.php?datefrom="+d3months+"&dateto="+dToday+"&customer_select="+currentSel;
		}
	});
	$('#customer-payment-history').click(function(){
		var currentSel = $('#customerhash').val();
		if(currentSel){
			window.location.href = "list-payments.php?customer="+currentSel;
		}
	});
	$('#print-payment-history').click(function(){
		var pdfrom = $('#pdatefrom').val();
		var pdto = $('#pdateto').val();
		var pcustomer = $('#customerfilter').val();
			window.location.href = "pdf-payments.php?dfrom="+pdfrom+"&dto="+pdto+"&customer="+pcustomer;
		
	});
	
	$('#download-payment-history').click(function(){
		var pdfrom = $('#pdatefrom').val();
		var pdto = $('#pdateto').val();
		var pcustomer = $('#customerfilter').val();
			window.location.href = "pdf-payments.php?d=1&dfrom="+pdfrom+"&dto="+pdto+"&customer="+pcustomer;
		
	});
	$(document).on('click','#edit-payment',function(){
		
		$('#closeIcon').show();
		$('#closeIcon2').show();
		var currentSel = $('#invoicehash').val();
		var paymentid = $('#paymentid').val();
		$('#payment-saving-mode').val('edit');
		if (currentSel){
				
			var data = {id:paymentid};
			
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-get-invoice-fields.php',
            data: data,
			dataType: 'json',
            success: function(response) {
				var dtValue = response[0];
				var amnt = response[1];
				var mop = response[2];
				var ref = response[3];
				$( "#populateDivPayment" ).show();
				$('#gray-background').show();
				$('#ref_no').val('');
				$('#payment_amount').val('');
				document.getElementById("payment_date").value = dtValue;
				$('#payment_amount').val(amnt);
				$("#mop").val(mop);
				$('#ref_no').val(ref);
				
			}
			});
				
				
			}
	});
	
	$('#payment-history').click(function(){
		var currentSel = $('#invoicehash').val();
		if (currentSel){
				
			
			var customerid = $('#customerhash').val();
			var data = {id:currentSel, customerid:customerid};
			
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-get-payment-history.php',
            data: data,
            success: function(response) {
				
				$('#populateDivPaymentHis').html(response);
				pTable = $('#paymentsTable').DataTable({
					
					"paging":   false,
					"info":     false,
					"scrollCollapse": true
				});
				$( "#populateDivPaymentHis" ).show();
				$('#gray-background').show();
			}
			});
			}
	});
	function generate_token(length){
    //edit the token allowed characters
    var a = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890".split("");
    var b = [];  
    for (var i=0; i<length; i++) {
        var j = (Math.random() * (a.length-1)).toFixed(0);
        b[i] = a[j];
    }
    return b.join("");
}
	
	
});