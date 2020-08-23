<input type="hidden" id="subject" name="subject" value="invoice" />
<div class="populateDivGenDelete" id="populateDivGenCustDel">
	<div class="container text-center">
		<p class="mb-3">Are you sure you want to delete the selected record?</p>
		<div class="row">
			<div class="col-md-6 mb-3">
				<button class="btn btn-primary btn-lg btn-block" id="delete-invoice-yesBtn">Yes</button>
			</div>
			<div class="col-md-6 mb-3">
				<button class="btn btn-primary btn-lg btn-block" id="noBtn">No</button>
			</div>
		</div>
	</div>
</div>
<div class="populateDivGenDelete" id="populateDivGenPaymentDel">
	<div class="container text-center">
		<p class="mb-3">Are you sure you want to delete the selected record?</p>
		<div class="row">
			<div class="col-md-6 mb-3">
				<button class="btn btn-primary btn-lg btn-block" id="delete-payment-yesBtn">Yes</button>
			</div>
			<div class="col-md-6 mb-3">
				<button class="btn btn-primary btn-lg btn-block" id="noDelPayBtn">No</button>
			</div>
		</div>
	</div>
</div>

<div class="populateDivGenDelete" id="populatechangeorderstatus" style="height:auto !important">
<button type="button" class="close" aria-label="Close" id="closeIcon">
		<span aria-hidden="true">&times;</span>
	</button>
	<div class="container text-center">
		<p class="mb-3">Change order status to:</p>
		<div class="row">
			<div class="col">
			
			<div class="mb-3">
				<button  class="btn btn-warning btn-lg btn-block" id="status-change-to-processing">Processing</button>
			</div>
		
		
			<div class="mb-3">
				<button class="btn btn-info btn-lg btn-block" id="status-change-to-shipped">Shipped</button>
			</div>
		
		
			<div class="mb-3">
				<button class="btn btn-success btn-lg btn-block" id="status-change-to-delivered">Delivered</button>
			</div>
			
			</div>
		</div>
	</div>
</div>

<?php if($order_type == 'invoice'){ ?>
<div class="populateDivPayment" id="populateDivPayment">
	<input type="hidden" value="" id="payment-saving-mode"/>
	
	<button type="button" class="close" aria-label="Close" id="closeIcon">
		<span aria-hidden="true">&times;</span>
	</button>
	<div class="container">
		<!-- open row -->
		<div class="row">
			<!-- open col -->
			<div class="col">
				
				<div class="mb-3">
					<label>Payment Date</label>
					<input class="form-control" type="date" id="payment_date" />
				</div>
				<div class="mb-3">
					<label>Payment Amount</label>
					<input class="form-control" type="number" id="payment_amount" min="0" step="0.01"/>
				</div>
				<div class="mb-3">
					<label>Payment Method</label>
					<select class="form-control" id="mop">
						<option>Cash</option>
						<option>Check</option>
						<option>Money Order</option>
						<option>EFT</option>
						<option>Wire Payment</option>
						<option>Online Payment</option>
					</select>
				</div>
				<div class="mb-3">
					<label>Reference No.</label>
					<input class="form-control" type="text" id="ref_no"/>
				</div>
				<div class="mb-3">
					<button class="btn btn-primary btn-lg btn-block" id="save-pay-button">Save</button>
				</div>
			<!-- close col -->
			</div>
		<!-- close row -->
		</div>
	<!-- close container -->
	</div>
</div>

<div class="populateDivSend" id="populateDivSend">
	<button type="button" class="close" aria-label="Close" id="closeIcon">
		<span aria-hidden="true">&times;</span>
	</button>
	<div class="container">
		<!-- open row -->
		<div class="row">
			<!-- open col -->
			<div class="col">
				
				<div class="mb-3">
					<label>Send To</label>
					<select class="form-control" id="emailto">
						
					</select>
				</div>
				<div class="mb-3" id="emailtoblock">
					<label>Email</label>
					<input type="text" class="form-control" id="emailaddress" />
				</div>
				<div class="mb-3">
					<label>Subject</label>
					<input type="text" class="form-control" id="emailsubject" />
				</div>
				<div class="mb-3">
					<label>Message</label>
					<textarea class="form-control" id="message_text" rows="4" cols="50"></textarea>
				</div>
				
				<div class="mb-3">
					<button class="btn btn-primary btn-lg btn-block" id="send-email-button">Send</button>
				</div>
			<!-- close col -->
			</div>
		<!-- close row -->
		</div>
	<!-- close container -->
	</div>
</div>
<div class="populateDivPaymentHis" id="populateDivPaymentHis">

</div>
<?php } ?>