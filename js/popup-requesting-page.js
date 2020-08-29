$(document).ready(function(){
	$('#brand').click(function(){
		$(this).blur();
		$( "#popBrand" ).show();
		$('#gray-background').show();
		$( "#popBrand" ).load( "popup-options.php?reid=f146aa9099b551a29e4d4ae56e170c7" );
		$('#poprequester').val("f146aa9099b551a29e4d4ae56e170c7");
			
	});
	$('#department').click(function(){
		$(this).blur();
		$( "#popBrand" ).show();
		$('#gray-background').show();
		$( "#popBrand" ).load( "popup-options.php?reid=adae3bad1bca266a568ecbc72e698c9" );
		$('#poprequester').val("adae3bad1bca266a568ecbc72e698c9");
	});
	$('#sub_department').click(function(){
		$(this).blur();
		$( "#popBrand" ).show();
		$('#gray-background').show();
		$( "#popBrand" ).load( "popup-options.php?reid=adae3bad1bca266a568ecbc82e698c5" );
		$('#poprequester').val("adae3bad1bca266a568ecbc82e698c5");
	});
	$('#category').click(function(){
		$(this).blur();
		$( "#popBrand" ).show();
		$('#gray-background').show();
		$( "#popBrand" ).load( "popup-options.php?reid=trae3bad1bca266a568ecbc82e698c8" );
		$('#poprequester').val("trae3bad1bca266a568ecbc82e698c8");
	});
	$('#supplier').click(function(){
		$(this).blur();
		$( "#popBrand" ).show();
		$('#gray-background').show();
		$( "#popBrand" ).load( "popup-options.php?reid=trae3bad2dca266a568ecbc82e698c8" );
		$('#poprequester').val("trae3bad2dca266a568ecbc82e698c8");
	});
	
	
	
	
});
