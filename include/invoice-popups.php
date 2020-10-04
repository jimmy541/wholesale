<input type="hidden" id="subject" name="subject" value="invoice" />

<!-- Modal -->
<div class="modal fade" id="modal_delete_order" tabindex="-1" role="dialog" aria-labelledby="modal_delete_order_title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_delete_order_title">Delete Order</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
			<div class="row mb-3">
				<div class="col">
					<h6>Are you sure you want to delete the current order?</h6>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 ml-auto">
					<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">No</button>
				</div>
				<div class="col-md-6 ml-auto">
					<button type="button" class="btn btn-primary btn-block" id="delete_order_yes_btn">Yes</button>
				</div>
			</div>		
		  </div>
      </div>
      
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="populateDivPaymentHis" tabindex="-1" role="dialog" aria-labelledby="modal_show_payment_history_title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_show_payment_history_title">Payments History</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="container-fluid">
		<!-- open row -->
		<div class="row">
			<!-- open col -->
			<div class="col">
				<ul class="invoice-top-buttons-disabled2">
							<li id="edit-payment"><i class="fas fa-edit"></i>Edit</li>
							<li id="delete-payment"><i class="fas fa-trash-alt"></i>Delete</li>
				</ul>
			<!-- close col -->
			</div>
		<!-- close row -->
		</div>
		<!-- open row -->
		<div class="row">
			<!-- open col -->
			<div class="col" id="modal_payment_history_body">
				
			<!-- close col -->
			</div>
		<!-- close row -->
		</div>
	<!-- close container -->
	</div>
      </div>
      
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal_delete_payment" tabindex="-1" role="dialog" aria-labelledby="modal_delete_payment_title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_delete_payment_title">Delete Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
			<div class="row mb-3">
				<div class="col">
					<h6>Are you sure you want to delete the current payment?</h6>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 ml-auto">
					<button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">No</button>
				</div>
				<div class="col-md-6 ml-auto">
					<button type="button" class="btn btn-primary btn-block" id="delete_payment_yes_btn">Yes</button>
				</div>
			</div>		
		  </div>
      </div>
      
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal_change_order_status" tabindex="-1" role="dialog" aria-labelledby="modal_change_order_status_title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_change_order_status_title">Change Order Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
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
      
    </div>
  </div>
</div>

<?php if($order_type == 'invoice'){ ?>
<!-- Modal -->
<div class="modal fade" id="modal_show_payment" tabindex="-1" role="dialog" aria-labelledby="modal_show_payment_title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_change_order_status_title">Payments</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="container-fluid">
		<!-- open row -->
		<div class="row">
			<!-- open col -->
			<div class="col">
				<input type="hidden" value="" id="payment-saving-mode"/>
				<div class="mb-3">
					<label>Payment Date</label>
					<input class="form-control" type="date" id="payment_date" value=""/>
				</div>
				<div class="mb-3">
					<label>Payment Amount</label>
					<input class="form-control" type="number" id="payment_amount" min="0" step="0.01" value=""/>
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
					<button class="btn btn-primary shadow btn-lg btn-block" id="save-pay-button">Save</button>
				</div>
			<!-- close col -->
			</div>
		<!-- close row -->
		</div>
	<!-- close container -->
	</div>
      </div>
      
    </div>
  </div>
</div>

<div class="populateDivSend" id="populateDivSend">
	<button type="button" class="close" aria-label="Close" id="closeIcon">
		<span aria-hidden="true">&times;</span>
	</button>
	<div class="container-fluid">
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
					<button class="btn btn-primary shadow btn-lg btn-block" id="send-email-button">Send</button>
				</div>
			<!-- close col -->
			</div>
		<!-- close row -->
		</div>
	<!-- close container -->
	</div>
</div>


<?php } ?>