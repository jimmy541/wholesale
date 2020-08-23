$(document).ready(function(){
	$("#asshipping").change(function() {
    if(this.checked) {
		
		
        $('#mailing_address1').val($('#shipping_address1').val());
		$('#mailing_address1').prop("readonly", true);
		$('#mailing_address2').val($('#shipping_address2').val());
		$('#mailing_address2').prop("readonly", true);
		$('#mailing_city').val($('#shipping_city').val());
		$('#mailing_city').prop("readonly", true);
		$("#mailing_state").val($("#shipping_state").val()).trigger('change');
		$('#mailing_state').prop("readonly", true);
		$('#mailing_zip_code').val($('#shipping_zip_code').val());
		$('#mailing_zip_code').prop("readonly", true);
    }else{
		$('#mailing_address1').prop("readonly", false);
		$('#mailing_address2').prop("readonly", false);
		$('#mailing_city').prop("readonly", false);
		$('#mailing_state').prop("readonly", false);
		$('#mailing_zip_code').prop("readonly", false);
		

	}
});
});