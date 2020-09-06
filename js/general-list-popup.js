$(document).ready(function(){
		var id = "";
		var subject = $('#subject').val();
		var clickedRow = '';
		var clickedPayment = '';
		
		
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
				$('#gray-background').hide();
				
				var requestingpage = $('#page-requesting').val();
				
				if (requestingpage == 'payments-page'){
					
					t = $('#paymentsTable').DataTable();
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
		function isEmail(email) {
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			return regex.test(email);
		}
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
		
		
		
});