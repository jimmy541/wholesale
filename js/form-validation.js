$(document).ready(function(){
	var roundformat = '4';
	//customer form
	$( "#newcustomerform" ).submit(function( event ) {
		var oktoproceed = 'true';
		var currentinput = '';
		$( ".errordiv" ).remove();
		$( ".mb-3 input" ).css("background-color", "white");
		$( ".mb-3 select" ).css("background-color", "white");
		
		currentinput = '#account_number';
		if (checklength(currentinput, 2) == 'false'){
			oktoproceed = 'false';
			$(currentinput).css("background-color", "#FEDCDC");
			displayerrormsg(currentinput, 'Account number requires at least 2 characters.');
		}
		
		currentinput = '#business_name';
		if (checklength(currentinput, 2) == 'false'){
			oktoproceed = 'false';
			$(currentinput).css("background-color", "#FEDCDC");
			displayerrormsg(currentinput, 'Business name requires at least 2 characters.');
		}
		
		currentinput = '#website';
		if (checklength(currentinput, 1) == 'true'){
			if(validateurl(currentinput) == 'false'){
				oktoproceed = 'false';
				$(currentinput).css("background-color", "#FEDCDC");
				displayerrormsg(currentinput, 'URL should be in http://example.com format');
			}
		}
		
		currentinput = '#shipping_email';
		if (checklength(currentinput, 1) == 'true'){
			if(isValidEmailAddress(currentinput) == 'false'){
				oktoproceed = 'false';
				$(currentinput).css("background-color", "#FEDCDC");
				displayerrormsg(currentinput, 'Invalid email format');
			}
		}
		
		currentinput = '#mailing_email';
		if (checklength(currentinput, 1) == 'true'){
			if(isValidEmailAddress(currentinput) == 'false'){
				oktoproceed = 'false';
				$(currentinput).css("background-color", "#FEDCDC");
				displayerrormsg(currentinput, 'Invalid email format');
			}
		}
		
		
		if(oktoproceed == 'false'){
			event.preventDefault();
		}
		
	});
	$('#unlockpwd').click(function(){
		$("#password").prop('disabled', false);
		$('#unlockpwd').hide();
	});
	$( "#newuserform" ).submit(function( event ) {
		var oktoproceed = 'true';
		var currentinput = '';
		$( ".errordiv" ).remove();
		$( ".mb-3 input" ).css("background-color", "white");
		$( ".mb-3 select" ).css("background-color", "white");
		
		currentinput = '#email';
		if($("#email").length > 0) {
		//this codition is used for edit user vs. new user
		  if(isValidEmailAddress(currentinput) == 'false'){
						oktoproceed = 'false';
						$(currentinput).css("background-color", "#FEDCDC");
						displayerrormsg(currentinput, 'Invalid email format');
				}else{
					var email = $.trim($('#email').val());
					$.post( "php-scripts/process-registration.php", {"userToCheck": email}, function( data ) {
						if (data == "true"){
							oktoproceed = 'false';
							$('#email').css("background-color", "#FEDCDC");
							displayerrormsg('#email', 'Email Exists');
						}
					});
				}
		}
		
		
		currentinput = '#password';
		if (checklength(currentinput, 6) == 'false'){
			oktoproceed = 'false';
			$(currentinput).css("background-color", "#FEDCDC");
			displayerrormsg(currentinput, 'Password must be 6 chars. minimum.');
		}
		
		currentinput = '#first_name';
		if (checklength(currentinput, 2) == 'false'){
			oktoproceed = 'false';
			$(currentinput).css("background-color", "#FEDCDC");
			displayerrormsg(currentinput, 'First Name is required');
		}
		
		currentinput = '#last_name';
		if (checklength(currentinput, 1) == 'false'){
			oktoproceed = 'false';
			$(currentinput).css("background-color", "#FEDCDC");
			displayerrormsg(currentinput, 'Last Name is required');
		}
		
		currentinput = '#display_code';
		if (checklength(currentinput, 3) == 'false'){
			oktoproceed = 'false';
			$(currentinput).css("background-color", "#FEDCDC");
			displayerrormsg(currentinput, 'Display code is required');
		}
		
		if(oktoproceed == 'false'){
			event.preventDefault();
		}
		
	});
	
	
	$( "#productform" ).submit(function( event ) {
		var oktoproceed = 'true';
		var currentinput = '';
		$( ".errordiv" ).remove();
		$( ".mb-3 input" ).css("background-color", "white");
		$( ".mb-3 select" ).css("background-color", "white");
		
		currentinput = '#cert_code';
		if (checklength(currentinput, 3) == 'false'){
			oktoproceed = 'false';
			$(currentinput).css("background-color", "#FEDCDC");
			displayerrormsg(currentinput, 'Item Code requires at least 3 characters.');
		}
		currentinput = '#cert_code';
		if (alphanum(currentinput) == 'false'){
			oktoproceed = 'false';
			$(currentinput).css("background-color", "#FEDCDC");
			displayerrormsg(currentinput, 'Item Code requires alphanumeric only');
		}
		
		currentinput = '#description';
		if (checklength(currentinput, 3) == 'false'){
			oktoproceed = 'false';
			$(currentinput).css("background-color", "#FEDCDC");
			displayerrormsg(currentinput, 'Description requires at least 3 characters');
		}
		
		
		if(oktoproceed == 'false'){
			event.preventDefault();
		}
	});
	
	
	$( "#general-profile" ).submit(function( event ) {
		var oktoproceed = 'true';
		var currentinput = '';
		$( ".errordiv" ).remove();
		$( ".mb-3 input" ).css("background-color", "white");
		$( ".mb-3 select" ).css("background-color", "white");
		
		currentinput = '#user_fname';
		if (checklength(currentinput, 3) == 'false'){
			oktoproceed = 'false';
			$(currentinput).css("background-color", "#FEDCDC");
			displayerrormsg(currentinput, 'First Name is required');
		}
		currentinput = '#user_Lname';
		if (checklength(currentinput, 3) == 'false'){
			oktoproceed = 'false';
			$(currentinput).css("background-color", "#FEDCDC");
			displayerrormsg(currentinput, 'Last Name is required');
		}
			
		if(oktoproceed == 'false'){
			event.preventDefault();
		}
	});
	
	$( "#security-profile" ).submit(function( event ) {
		var oktoproceed = 'true';
		var currentinput = '';
		$( ".errordiv" ).remove();
		$( ".mb-3 input" ).css("background-color", "white");
		$( ".mb-3 select" ).css("background-color", "white");
		
		currentinput = '#currpswd';
		if (checklength(currentinput, 6) == 'false'){
			oktoproceed = 'false';
			$(currentinput).css("background-color", "#FEDCDC");
			displayerrormsg(currentinput, 'Password must be 6 chars. minimum.');
		}
		
		currentinput = '#newpswd';
		if (checklength(currentinput, 6) == 'false'){
			oktoproceed = 'false';
			$(currentinput).css("background-color", "#FEDCDC");
			displayerrormsg(currentinput, 'Password must be 6 chars. minimum.');
		}
		
		currentinput = '#connewpswd';
		if (checklength(currentinput, 6) == 'false'){
			oktoproceed = 'false';
			$(currentinput).css("background-color", "#FEDCDC");
			displayerrormsg(currentinput, 'Password must be 6 chars. minimum.');
		}
		
		currentinput = '#connewpswd';
		var pass1 = $.trim($('#newpswd').val());
		var pass2 = $.trim($('#connewpswd').val());
		if (pass1 != pass2){
			oktoproceed = 'false';
			$(currentinput).css("background-color", "#FEDCDC");
			displayerrormsg(currentinput, 'Passwords don\'t match');
		}
			
		if(oktoproceed == 'false'){
			event.preventDefault();
		}
	});
	
	
	$( "#reset-password" ).submit(function( event ) {
		var oktoproceed = 'true';
		var currentinput = '';
		$( ".errordiv" ).remove();
		$( ".mb-3 input" ).css("background-color", "white");
		$( ".mb-3 select" ).css("background-color", "white");
		
		
		
		currentinput = '#newpswd';
		if (checklength(currentinput, 6) == 'false'){
			oktoproceed = 'false';
			$(currentinput).css("background-color", "#FEDCDC");
			displayerrormsg(currentinput, 'Password must be 6 chars. minimum.');
		}
		
		currentinput = '#connewpswd';
		if (checklength(currentinput, 6) == 'false'){
			oktoproceed = 'false';
			$(currentinput).css("background-color", "#FEDCDC");
			displayerrormsg(currentinput, 'Password must be 6 chars. minimum.');
		}
		
		currentinput = '#connewpswd';
		var pass1 = $.trim($('#newpswd').val());
		var pass2 = $.trim($('#connewpswd').val());
		if (pass1 != pass2){
			oktoproceed = 'false';
			$(currentinput).css("background-color", "#FEDCDC");
			displayerrormsg(currentinput, 'Passwords don\'t match');
		}
			
		if(oktoproceed == 'false'){
			event.preventDefault();
		}
	});
	
	
	$('#calccaseprice, #calccaseprice2').click(function(){
		roundformat = $('#roundformat').val();
		
		$( ".errordiv" ).remove();
		$( ".mb-3 input" ).css("background-color", "white");
		$( ".mb-3 select" ).css("background-color", "white");
		if (checklength('#Pack', 1) == 'false' || checklength('#case_cost', 1) == 'false'){
			$('#Pack').css("background-color", "#FEDCDC");
			$('#case_cost').css("background-color", "#FEDCDC");
			displayerrormsg("#case_cost", 'Pack and case cost required');
		}else{
			if(checklength('#case_price', 1) == 'true'){
				$('#caseretaildesired').val($('#case_price').val());
				var exactmargin = (($('#caseretaildesired').val() - $('#case_cost').val()) / $('#caseretaildesired').val() * 100);
				$('#margindesired').val(exactmargin.toFixed(2));
			}
			if(checklength('#normal_price', 1) == 'true'){
				$('#unitretaildesired').val($('#normal_price').val());
				var exactmargin = (($('#unitretaildesired').val() - $('#cost').val()) / $('#unitretaildesired').val() * 100);
				$('#margindesiredunit').val(exactmargin.toFixed(2));
			}
			
			var pkval = $('#Pack').val();
			var csval = $('#case_cost').val();
			$('#PackDP').val(pkval);
			$('#case_costDP').val(csval);
			$('#cost').val((csval/pkval).toFixed(2));
			$('#unitcost').val((csval/pkval).toFixed(2));
			$( "#calculateprice" ).show();
			$('#gray-background').show();
		}
	});
	$('#applymrgcase').click(function(){
		
		var mrgn = $('#margindesired').val();
		var cCost = $('#case_cost').val();
		
		$newprice = cCost / ((100-mrgn)/100);
		$newprice = $newprice.toFixed(2);
	
		if(roundformat == '1' || roundformat == '2' || roundformat == '3' || roundformat == '5'){
			var roundedprice = roundformual(roundformat, $newprice);
			$('#caseretaildesired').val(roundedprice);
		}else{
			$('#caseretaildesired').val($newprice);
		}
		var exactmargin = (($('#caseretaildesired').val() - cCost) / $('#caseretaildesired').val() * 100);
		$('#margindesired').val(exactmargin.toFixed(2));
		
	});
	$('#applymrgunit').click(function(){
		var mrgn = $('#margindesiredunit').val();
		var cCost = $('#cost').val();
		
		$newprice = cCost / ((100-mrgn)/100);
		$newprice = $newprice.toFixed(2);
		if(roundformat == '1' || roundformat == '2' || roundformat == '3' || roundformat == '5'){
			var roundedprice = roundformual(roundformat, $newprice);
			$('#unitretaildesired').val(roundedprice);
		}else{
			$('#unitretaildesired').val($newprice);
		}
		var exactmargin = (($('#unitretaildesired').val() - cCost) / $('#unitretaildesired').val() * 100);
		$('#margindesiredunit').val(exactmargin.toFixed(2));
		
	});
	
	$('#donecalcprice').click(function(){
		$('#case_price').val($('#caseretaildesired').val());
		$('#normal_price').val($('#unitretaildesired').val());
		$( "#calculateprice" ).hide();
		$('#gray-background').hide();
		
	});
	$('#cancelcalcprice').click(function(){
		$( "#calculateprice" ).hide();
		$('#gray-background').hide();
		
	});
	
	$('#margindesired').keypress(function(event){
		if(event.keyCode == 13){
			$('#applymrgcase').click();
		}
	});
	$('#margindesiredunit').keypress(function(event){
		if(event.keyCode == 13){
			$('#applymrgunit').click();
		}
	});
	//display error message
	function displayerrormsg(inputid, msg) {
		$( '<div class="group-fields errordiv"><span class="fielderrormsg">'+ msg +'</span></div>' ).insertAfter( $(inputid) );
	}
	
	
	//validate length
	function checklength(inputid, minlength) {
		var x = $.trim($(inputid).val()).length;
		var rtrn = 'false';
		
		if (x >= minlength) {
			rtrn = 'true';
		} 
		return rtrn;
	}
	
	
	//validate url
	function validateurl(url){
		var rtrn = 'false';
		var urltest = $(url).val();
		if(/^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(urltest)){
		rtrn = 'true';
		} else {
			rtrn = 'false';
		}
		return rtrn;
	}
	
	
	//validate email
	function isValidEmailAddress(emailAddress) {
		var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
		var rtrn = 'false';
		if(pattern.test($(emailAddress).val())){
			rtrn = 'true';
		}
		
		return rtrn;
	};
	
	
	//alphanumerica only
	function alphanum(inputstr){
		var regex = new RegExp("^[a-zA-Z0-9]+$");
		var rtrn = 'false';
		if(regex.test($(inputstr).val())){
			rtrn = 'true';
		}
		
		return rtrn;
	}
	
	function roundformual(format, vlu){
		var rslt = '';
		if(format=='5'){
		rslt =	Math.ceil(vlu);
		}
		if(format=='1'){
		rslt =	Math.round(vlu);
		}
		if(format=='2'){
			var x = (Math.round(vlu * 10)) * 10;
			x = x-1;
			x = x/100;
			rslt = x;
		}
		if(format=='3'){
			var x = (Math.round(vlu)) * 100;
			x = x-1;
			x = x/100;
			rslt = x;
		}
		return rslt;
	}
    

});