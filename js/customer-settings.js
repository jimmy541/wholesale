$('document').ready(function(){
	
	
	$( "#pricing_level" ).change(function() {
		var $vlu = $('#pricing_level').find(":selected").text();
		if ($vlu != 'Normal' ){
			$("#group-fields-dyn").html('<label for="">' + $vlu + '</label><input class="form-control" type="text" name="dby">');
		}else{
			$("#group-fields-dyn").html('');
		}
	});

});