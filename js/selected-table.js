$(document).ready(function() {
	var pTable = '';
	var id = "";
	var subject = $('#subject').val();
	var clickedRow = '';
	var clickedPayment = '';
	
	/* Handling selected rows button clicks */
	
	$('#gtable tfoot th').each( function () {
        var title = $(this).text();
		if(title == 'Account Number' || title == 'Business Name'){
			$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
		}
    } );
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
	
	
	/* Handling buttons inside the buttons*/
	
	$('#delete-order').click(function(){
			clickedRow = $('#invoicehash').val();
			id = $('#invoicehash').val();
			if (id){
				$( "#populateDivGenCustDel" ).show();
				$('#gray-background').show();
			}
		});
		$(document).on('click', '#delete-payment',function(){
			clickedPayment = $('#paymentid').val();
			id = $('#invoicehash').val();
			if (clickedPayment){
				$( "#populateDivGenPaymentDel" ).show();
				$('#gray-background').show();
			}
		});
		$(document).on('click','i',function(){
			clickedRow = $(this).attr('id');
			var str = $(this).attr('id');
			if(typeof str != 'undefined'){
				if (str.indexOf("delete") >= 0){
					$( "#populateDivGenCustDel" ).show();
					id = $(this).attr('id').replace('delete', '');
					$('#gray-background').show();
				}
				if (str.indexOf("inactive") >= 0){
					$("#populateDivGenCustInactive" ).show();
					id = $(this).attr('id').replace('inactive', '');
					$('#gray-background').show();
				}
			}
		});
		$(document).on('click','button',function(){
			//clickedRow = $(this).attr('id');
			var str = $(this).attr('id');
			if(typeof str != 'undefined'){
			if (str.indexOf("changestatus") >= 0){
				clickedRow = $('#invoicehash').val();
				id = $('#invoicehash').val();
				$( "#populatechangeorderstatus" ).show();
				id = $(this).attr('id').replace('changestatus', '');
				$('#gray-background').show();
			}
		}
		});
		$(document).on('click','#status-change-to-processing',function(){
			var data = {changeto: 'Processing', id: id};
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-change-invoice-status.php',
            data: data,
            success: function(response) {
				$( "#populatechangeorderstatus" ).hide();
				$('#gray-background').hide();
				$('#changestatus'+id).text("Processing");
				$('#changestatus'+id).addClass('btn-warning').removeClass('btn-success').removeClass('btn-info');
				//$('#changestatus'+id).css("background-color","#ffc107");
				//$('#changestatus'+id).css("border-color","#ffc107");
					id = '';
				}
			});
		});
		$(document).on('click','#status-change-to-shipped',function(){
			var data = {changeto: 'Shipped', id: id};
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-change-invoice-status.php',
            data: data,
            success: function(response) {
				$( "#populatechangeorderstatus" ).hide();
				$('#gray-background').hide();
				$('#changestatus'+id).text("Shipped");
				$('#changestatus'+id).addClass('btn-info').removeClass('btn-success').removeClass('btn-warning');
				//$('#changestatus'+id).css("background-color","#17a2b8");
				//$('#changestatus'+id).css("border-color","#17a2b8");
					id = '';
				}
			});
		});
		$(document).on('click','#status-change-to-delivered',function(){
			var data = {changeto: 'Delivered', id: id};
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-change-invoice-status.php',
            data: data,
            success: function(response) {
				$( "#populatechangeorderstatus" ).hide();
				$('#gray-background').hide();
				$('#changestatus'+id).text("Delivered");
				$('#changestatus'+id).addClass('btn-success').removeClass('btn-warning').removeClass('btn-info');
				//$('#changestatus'+id).css("background-color","#1e7e34");
				//$('#changestatus'+id).css("border-color","#1e7e34");
					id = '';
				}
			});
		});
		$(document).on('click','#noBtn',function(){
			$( "#populateDivGenCustDel" ).hide();
			$( "#populateDivGenCustInactive" ).hide();
			$('#gray-background').hide();
		});
		$(document).on('click','#noDelPayBtn',function(){
			$( "#populateDivGenPaymentDel" ).hide();
			$('#gray-background').hide();
		});
		$(document).on('click','#closeIcon',function(){
			$( "#populateDivPayment" ).hide();
			$( "#populateDivSend" ).hide();
			$( "#populateDivPaymentHis" ).hide();
			$("#populateDivGenPaymentDel").hide();
			$("#paymentid").val('');
			$("#populatechangeorderstatus").hide();
			$('#gray-background').hide();
		});
		$(document).on('click','#closeIcon2',function(){
			$( "#populateDivPayment" ).hide();
		});
		$(document).on('click','#yesBtn',function(){
			var data = {subject: subject, id: id};
				jQuery.ajax({
				type: 'POST',
				url: 'php-scripts/process-general-remove.php',
				data: data,
				success: function(response) {
					$( "#populateDivGenCustDel" ).hide();
					$('#gray-background').hide();
						id = '';
					var t = $('#gtable').DataTable();
					t
					.row( $('#'+clickedRow).parents('tr') )
					.remove()
					.draw();
					}
				});
		});
		$(document).on('click','#yesInactiveBtn',function(){
			var data = {subject: 'inactivecustomer', id: id};
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-general-remove.php',
            data: data,
            success: function(response) {
				$( "#populateDivGenCustInactive" ).hide();
				$('#gray-background').hide();
					id = '';
				var t = $('#gtable').DataTable();
				t
				.row( $('#'+clickedRow).parents('tr') )
				.remove()
				.draw();
				}
			});
		});
		$(document).on('click','#delete-invoice-yesBtn',function(){
			var data = {subject: subject, id: id};
			if(subject == 'invoice-single-item'){
				jQuery.ajax({
				type: 'POST',
				url: 'php-scripts/process-general-remove.php',
				data: data,
				dataType: 'json',
				success: function(response) {
					$( "#populateDivGenCustDel" ).hide();
					$('#gray-background').hide();
					$('#delete'+id).closest('tr').remove();
					id = '';
					$('#invoice_sub_total').text(response[1]);
					$('#invoice_tax').text(response[2]);
					$('#invoice_grand_total').text(response[3]);
					}
				});
			}else{
				jQuery.ajax({
				type: 'POST',
				url: 'php-scripts/process-general-remove.php',
				data: data,
				success: function(response) {
					$('#invoicehash').val('');
					$( "#populateDivGenCustDel" ).hide();
					$('#gray-background').hide();
						id = '';
					var t = $('#gtable').DataTable();
					t
					.row( $('#'+clickedRow).parents('tr') )
					.remove()
					.draw();
					}
				});
			}
		});
		$(document).on('click','#delete-payment-yesBtn',function(){
			var data = {subject: "payment", id: clickedPayment};
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-general-remove.php',
            data: data,
			dataType: 'json',
            success: function(response) {
				$('#paymentid').val('');
				$( "#populateDivGenPaymentDel" ).hide();
				$( "#populateDivPaymentHis" ).hide();
				$('#gray-background').hide();
				var requestingpage = $('#page-requesting').val();
				if (requestingpage == 'payments-page'){
					t = $('#gtable').DataTable();
					t
					.row( $('#'+clickedPayment).parents('tr') )
					.remove()
					.draw();
				}else{
					var t = $('#gtable').DataTable();
					var cell = t.cell('#invbalance'+id);
					var newValue = response[0];
					cell.data(newValue).draw();
					t = $('#paymentsTable').DataTable();
					t
					.row( $('#'+clickedPayment).parents('tr') )
					.remove()
					.draw();
				}
			}
			});
		});
		$("#emailto" ).change(function() {
			var sendto = $('#emailto option:selected').val();
			if(sendto != 'Custom'){
				$('#emailtoblock').hide();
			}else{
				$('#emailtoblock').show();
			}
		});
		$("#send-email-button").click(function () {
			var emailaddress = '';
			var sendto = $('#emailto option:selected').text();
			var sendtoname = $('#emailto option:selected').val();
			var msgbody = $('#message_text').val();
			var msgsubject = $('#emailsubject').val();
			var doctype = $('#doc-type').val();
			if(sendto == 'Custom'){
				emailaddress = $('#emailaddress').val();
				sendtoname = "";
			}else{
				emailaddress = $('#emailto option:selected').text();
			}
			var inid = "";
			if(doctype == 'invoice'){
				inid = $('#invoicehash').val();
			}else if (doctype == 'statement'){
				inid = $('#customerhash').val();
			}else if (doctype == 'ahistory'){
				inid = $('#customerhash').val();
			}
			if(emailaddress && isEmail(emailaddress)){
				var data = {doctype:doctype, email:emailaddress, toname:sendtoname, invoice:inid, msgsubject:msgsubject, msgbody:msgbody}
				jQuery.ajax({
					type: 'POST',
					url: 'php-scripts/sendmail.php',
					data: data,
					dataType: 'text',
					success: function(response) {
						$('#email-sent-success').show();
					}
				});
				$('#gray-background').hide();
				$( "#populateDivSend" ).hide();
			}else{
				$( '<div class="group-fields errordiv"><span class="fielderrormsg">Invalid e-mail address</span></div>' ).insertAfter( $('#emailto') );
			}
		});
		$(document).on('click','#save-pay-button',function(){
			id = $('#invoicehash').val();
			var customerid = $('#customerhash').val();
			var paydate = $('#payment_date').val();
			var amount = $('#payment_amount').val();
			var refnum = $('#ref_no').val();
			var mop = $('#mop').val();
			var savingmode = $('#payment-saving-mode').val();
			var data = '';
			if(savingmode=='new'){data = {id:id, customerid:customerid, paydate:paydate, amount:amount, refnum:refnum, mop:mop, savingmode:savingmode};}
			if(savingmode=='edit'){
				var paymentid = $('#paymentid').val();
				data = {paymentid:paymentid, id:id, customerid:customerid, paydate:paydate, amount:amount, refnum:refnum, mop:mop, savingmode:savingmode};
				}
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-pay-invoice.php',
            data: data,
			dataType: 'json',
            success: function(response) {
				$( "#populateDivPayment" ).hide();
				$('#gray-background').hide();
				var t = $('#gtable').DataTable();
				var cell = t.cell('#invbalance'+id);
				var newValue = response[0];
				cell.data(newValue).draw();
				if(savingmode=='edit'){
					t = $('#paymentsTable').DataTable();
					var cell = t.cell('#payamount'+$('#paymentid').val());
					var newValue = response[1];
					cell.data(newValue).draw();
					var cell = t.cell('#paydate'+$('#paymentid').val());
					var newValue = response[2];
					cell.data(newValue).draw();
					var cell = t.cell('#ref'+$('#paymentid').val());
					var newValue = response[3];
					cell.data(newValue).draw();
					var cell = t.cell('#mop'+$('#paymentid').val());
					var newValue = response[4];
					cell.data(newValue).draw();
				}
			}
			});
		});
		$(document).on('click', '#save-assign-salesperson', function(){
			
			var customerid = $('#customerhash').val();
			var saleseperson_id = $('#salesperson option:selected').val();
			var data = {customerid:customerid, saleseperson_id:saleseperson_id};
			
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/update-customer-salesperson.php',
            data: data,
            success: function(response) {
				$('#assing_salesperson').modal('toggle');
				
			}
			});
			
		});
	
//Special batch and push batch start	
$("#products_modal_gtable").width("100%");
var products_modal_gtable = $('#products_modal_gtable').DataTable({
	"columnDefs": [
            {
                "targets": [ 0 ],
                "searchable": false
            }
        ]
});	
$('#products_modal_gtable tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
			$("#add_product_button").attr("disabled", true);
			$('#product_id_form_1').val('');
			}
        else {
            products_modal_gtable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
			$("#add_product_button").removeAttr("disabled");
			var ids = $.map(products_modal_gtable.rows('.selected').data(), function (item) {
				$('#product_id_form_1').val(item[0]);
			});
        }
    } );
$(document).on('click','i',function(){
			clickedRow = $(this).attr('id');
			var str = $(this).attr('id');
			if(typeof str != 'undefined'){
				if (str.indexOf("remove_item_from_batch") >= 0){
					$( "#modal_remove_product" ).modal("toggle");
					id = $(this).attr('id').replace('remove_item_from_batch', '');
					
				}
			}
		});
		$(document).on('click','#delete_product_special_batch',function(){
			var batchid = $('#batch_id').val();
			var data = {subject: "special_batch_product", batchid: batchid, recordid:id};
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-general-remove.php',
            data: data,
            success: function(response) {
				
				
				
					var t = $('#gtable').DataTable();
					t
					.row( $('#'+clickedRow).parents('tr') )
					.remove()
					.draw();
					
					clickedRow = '';
					id = '';
					$( "#modal_remove_product" ).modal("toggle");
				
			}
			});
		});
//Special batch and push batch end 
	
	
	
	
	
	/* Functions */
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
	function isEmail(email) {
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			return regex.test(email);
		}
	
});