$('document').ready(function(){


$('#registration-form').submit(function( event ) {
	$( ".errordiv" ).remove();
	var currentinput = '';
	var firstname = $.trim($('#first_name').val());
	var lastname = $.trim($('#last_name').val());
	var email = $.trim($('#email').val());
	var companyname = $.trim($('#company_name').val());
	var pass = $.trim($('#password').val());
		
	var valid1 = '0';
	var valid2 = '0';
	var valid3 = '0';
	var valid4 = '0';
	var valid5 = '0';
		
	//check for empty fields
	if (firstname.length > 0) { valid1 = '1'; } else {valid1 = '0'; displayerrormsg('#first_name', "First name is required")}
	if (lastname.length > 0) { valid2 = '1'} else {valid2 = '0'; displayerrormsg('#last_name', "Last name is required")}
	if (email.length > 0) { valid3 = '1'} else {valid3 = '0'; displayerrormsg('#email', "Email address is required")}
	if (companyname.length > 0) { valid4 = '1'} else {valid4 = '0'; displayerrormsg('#company_name', "Company name is required")}
	if (pass.length > 6) { valid5 = '1'} else {valid5 = '0'; displayerrormsg('#password', "Password is required")}
		
	
	
	//check if email is in correct format
	if( !isValidEmailAddress( email ) ){ valid3 = '0'; displayerrormsg('#email', "Invalid email address")}else{
		$.ajaxSetup({async:false});
		$.post( "php-scripts/process-registration.php", {"userToCheck": email}, function( data ) {
			if (data == "true"){
				displayerrormsg('#email', "Email Address Exist");
				valid3 = '0';
				
			}
			});
		$.ajaxSetup({async:true});
			
	}
	
	
	
	
	if (valid1 == '1' && valid2 == '1' && valid3 == '1' && valid4 == '1' && valid5 == '1'){
		
	}
	else {
		
		event.preventDefault();
	}

});

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
};
function displayerrormsg(inputid, msg) {
		$( '<div class="group-fields errordiv" style="text-align:left;"><span class="fielderrormsg">'+ msg +'</span></div>' ).insertAfter( $(inputid) );
		
	}




});