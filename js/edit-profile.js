$('document').ready(function(){
	//checking first and last name
	verifyInputs();
	$('#form1').submit(function () {
		var firstname = $.trim($('#first_name').val());
		var lastname = $.trim($('#last_name').val());
		var valid1 = '0';
		var valid2 = '0';
		//check for empty fields
		if (firstname.length > 0) { valid1 = '1'} else {valid1 = '0'}
		if (lastname.length > 0) { valid2 = '1'} else {valid2 = '0'}
		if (valid1 == '1' && valid2 == '1'){
			}
		else {
		return false;
		
		}
	});
	function verifyInputs() {
		var firstname = $.trim($('#first_name').val());
		var lastname = $.trim($('#last_name').val());
		var valid1 = '0';
		var valid2 = '0';
		//check for empty fields
		if (firstname.length > 0) { valid1 = '1'} else {valid1 = '0'}
		if (lastname.length > 0) { valid2 = '1'} else {valid2 = '0'}
		if (valid1 == '1' && valid2 == '1'){
			$('#update').removeAttr('disabled');
		}
		else {
		$('#update').attr('disabled','disabled');
		}
	}
	$('#first_name').change(verifyInputs);
	$('#first_name').keyup(verifyInputs);
	$('#last_name').change(verifyInputs);
	$('#last_name').keyup(verifyInputs);
	$('#first_name').keyup(function(){
		var firstname = $.trim($('#first_name').val());
		if (firstname.length > 0) { $('#first_name').css('border', '2px lime solid')} else {$('#first_name').css('border', '2px red solid')}
	});
	$('#last_name').keyup(function(){
		var lastname = $.trim($('#last_name').val());
		if (lastname.length > 0) { $('#last_name').css('border', '2px lime solid')} else {$('#last_name').css('border', '2px red solid')}
	});
	
	
	//checking username
	verifyInputs1a();
	$('#form1a').submit(function () {
		var username = $.trim($('#username').val());
		var valid1 = '0';
		
		//check for empty fields
		if (username.length > 0) { valid1 = '1'} else {valid1 = '0'}
		if (valid1 == '1'){
			}
		else {
		return false;
		
		}
	});
	function verifyInputs1a() {
		var username = $.trim($('#username').val());
		
		var valid1 = '0';
		
		//check for empty fields
		if (username.length > 0) { valid1 = '1'} else {valid1 = '0'}
		
		if (valid1 == '1'){
			$('#update1a').removeAttr('disabled');
		}
		else {
		$('#update1a').attr('disabled','disabled');
		}
	}
	$('#username').change(verifyInputs1a);
	$('#username').keyup(verifyInputs1a);
	
	$('#username').keyup(function(){
		var username = $.trim($('#username').val());
		if (username.length > 0) { $('#username').css('border', '2px lime solid')} else {$('#username').css('border', '2px red solid')}
	});
	

	
	
	
	//checking password
	verifyInputs2();
	$('#form2').submit(function () {
		var firstname = $.trim($('#currentpassword').val());
		var lastname = $.trim($('#newpassword').val());
		var valid1 = '0';
		var valid2 = '0';
		//check for empty fields
		if (firstname.length > 6) { valid1 = '1'} else {valid1 = '0'}
		if (lastname.length > 6) { valid2 = '1'} else {valid2 = '0'}
		if (valid1 == '1' && valid2 == '1'){
			}
		else {
		return false;
		
		}
	});
	function verifyInputs2() {
		var firstname = $.trim($('#currentpassword').val());
		var lastname = $.trim($('#newpassword').val());
		var valid1 = '0';
		var valid2 = '0';
		//check for empty fields
		if (firstname.length > 6) { valid1 = '1'} else {valid1 = '0'}
		if (lastname.length > 6) { valid2 = '1'} else {valid2 = '0'}
		if (valid1 == '1' && valid2 == '1'){
			$('#update2').removeAttr('disabled');
		}
		else {
		$('#update2').attr('disabled','disabled');
		}
	}
	$('#currentpassword').change(verifyInputs2);
	$('#currentpassword').keyup(verifyInputs2);
	$('#newpassword').change(verifyInputs2);
	$('#newpassword').keyup(verifyInputs2);
	$('#currentpassword').keyup(function(){
		var firstname = $.trim($('#currentpassword').val());
		if (firstname.length > 0) { $('#currentpassword').css('border', '2px lime solid')} else {$('#currentpassword').css('border', '2px red solid')}
	});
	$('#newpassword').keyup(function(){
		var lastname = $.trim($('#newpassword').val());
		if (lastname.length > 0) { $('#newpassword').css('border', '2px lime solid')} else {$('#newpassword').css('border', '2px red solid')}
	});

	//checking birthday
	verifyInputs3();
	$('#form3').submit(function () {
		var year1 = $.trim($('#year').val());
		var month1 = $.trim($('#month').val());
		var day1 = $.trim($('#day').val());

		var valid6 = '0';
		var valid7 = '0';
		var valid8 = '0';


		if (year1.length > 0) { valid6 = '1'} else {valid6 = '0'}
		if (month1.length > 0) { valid7 = '1'} else {valid7 = '0'}
		if (day1.length > 0) { valid8 = '1'} else {valid8 = '0'}

		//check if date fields are not empty
		if (year1 == 'عام'){valid6 = '0'}else{valid6 = '1'}
		if (month1 == 'شهر'){valid7 = '0'}else{valid7 = '1'}
		if (day1 == 'يوم'){valid8 = '0'}else{valid8 = '1'}
	
		var text = month1+'/'+day1+'/'+year1;
		var comp = text.split('/');
		var m = parseInt(comp[0], 10);
		var d = parseInt(comp[1], 10);
		var y = parseInt(comp[2], 10);
		var date = new Date(y,m-1,d);
		if (date.getFullYear() == y && date.getMonth() + 1 == m && date.getDate() == d) {
		    valid8 = '1';
		} else {
		    valid8 = '0';
		}

		
		if (valid6 == '1' && valid7 == '1' && valid8 == '1'){
			}
		else {
		return false;
		
		}
	});
	function verifyInputs3() {
		var year1 = $.trim($('#year').val());
		var month1 = $.trim($('#month').val());
		var day1 = $.trim($('#day').val());

		var valid6 = '0';
		var valid7 = '0';
		var valid8 = '0';


		if (year1.length > 0) { valid6 = '1'} else {valid6 = '0'}
		if (month1.length > 0) { valid7 = '1'} else {valid7 = '0'}
		if (day1.length > 0) { valid8 = '1'} else {valid8 = '0'}

		//check if date fields are not empty
		if (year1 == 'عام'){valid6 = '0'}else{valid6 = '1'}
		if (month1 == 'شهر'){valid7 = '0'}else{valid7 = '1'}
		if (day1 == 'يوم'){valid8 = '0'}else{valid8 = '1'}
	
		var text = month1+'/'+day1+'/'+year1;
		var comp = text.split('/');
		var m = parseInt(comp[0], 10);
		var d = parseInt(comp[1], 10);
		var y = parseInt(comp[2], 10);
		var date = new Date(y,m-1,d);
		if (date.getFullYear() == y && date.getMonth() + 1 == m && date.getDate() == d) {
		    valid8 = '1';
		} else {
		    valid8 = '0';
		}
		
		if (valid6 == '1' && valid7 == '1' && valid8 == '1'){
			$('#update3').removeAttr('disabled');
		}
		else {
		$('#update3').attr('disabled','disabled');
		}
	}
	function processDOBfileds(){
	var valid6 = '0';
	var valid7 = '0';
	var valid8 = '0';
	var year1 = $.trim($('#year').val());
	var month1 = $.trim($('#month').val());
	var day1 = $.trim($('#day').val());

	if (year1 == 'عام'){valid6 = '0'}else{valid6 = '1'}
	if (month1 == 'شهر'){valid7 = '0'}else{valid7 = '1'}
	if (day1 == 'يوم'){valid8 = '0'}else{valid8 = '1'}

	var text = month1+'/'+day1+'/'+year1;
	var comp = text.split('/');
	var m = parseInt(comp[0], 10);
	var d = parseInt(comp[1], 10);
	var y = parseInt(comp[2], 10);
	var date = new Date(y,m-1,d);
	if (date.getFullYear() == y && date.getMonth() + 1 == m && date.getDate() == d) {
	    valid8 = '1';
	} else {
	    valid8 = '0';
	}
	
	if (valid6 == '1' && valid7 == '1' && valid8 == '1'){
		$('#year').css('border', '2px lime solid');
		$('#month').css('border', '2px lime solid');
		$('#day').css('border', '2px lime solid');

	}else{
		$('#year').css('border', '2px red solid');
		$('#month').css('border', '2px red solid');
		$('#day').css('border', '2px red solid');
	}
	
}

	
	$('#year').change(verifyInputs3);
	$('#year').keyup(verifyInputs3);
	$('#year').change(processDOBfileds);
	$('#year').keyup(processDOBfileds);
	
	
	$('#month').change(verifyInputs3);
	$('#month').keyup(verifyInputs3);
	$('#month').change(processDOBfileds);
	$('#month').keyup(processDOBfileds);
	
	
	$('#day').change(verifyInputs3);
	$('#day').keyup(verifyInputs3);
	$('#day').change(processDOBfileds);
	$('#day').keyup(processDOBfileds);
	

});