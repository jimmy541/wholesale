$('document').ready(function(){

$('form').submit(function () {
	
	var pass1 = $.trim($('#password1').val());
	var pass2 = $.trim($('#password2').val());
	
	
	var vpass1 = '0';
	var vpass2 = '0';
	
	
	
	//check for empty fields
	if (pass1.length > 0) { vpass1 = '1'} else {vpass1 = '0'}
	if (pass2.length > 0) { vpass2 = '1'} else {vpass2 = '0'}
	
	if (pass1 == pass2){
	vpass1 = '1';
	}else{
	vpass1 = '0'
	}
	
		
	if (vpass1 == '1' && vpass2 == '1'){
		$('#password1').css('border', '2px lime solid');
		$('#password2').css('border', '2px lime solid');
		
	}
	else {
		$('#password1').css('border', '2px red solid');
		$('#password2').css('border', '2px red solid');
	return false;
	
	}

    
        
    
});








});