$(document).ready(function(){
	
   
	$('#closeBtn').click(function(){
		$("#popBrand").hide();
		$('#gray-background').hide();
		$("#popBrand").empty();
	});
	$(document).one('click','span',function(){
		var id = $(this).attr('id').replace('descPopValue', '');
		
		var vlu = $(this).text();
		
		var requestinghash = $('#poprequester').val();
		if(requestinghash == 'f146aa9099b551a29e4d4ae56e170c7'){
			$('#brand').find('option').remove().end()
			.append($("<option></option>")
						.attr("value",id)
						.text(vlu)); 
						$("#popBrand").hide();
						$('#gray-background').hide();
						$("#popBrand").empty();
		}

		if(requestinghash == 'adae3bad1bca266a568ecbc72e698c9'){
			$('#department').find('option').remove().end()
			.append($("<option></option>")
						.attr("value",id)
						.text(vlu)); 
						
						$("#popBrand").hide();
						$('#gray-background').hide();
						$("#popBrand").empty();
		}
		
		if(requestinghash == 'adae3bad1bca266a568ecbc82e698c5'){
			$('#sub_department').find('option').remove().end()
			.append($("<option></option>")
						.attr("value",id)
						.text(vlu)); 
						$("#popBrand").hide();
						$('#gray-background').hide();
						$("#popBrand").empty();
		}
		if(requestinghash == 'trae3bad1bca266a568ecbc82e698c8'){
			$('#category').find('option').remove().end()
			.append($("<option></option>")
						.attr("value",id)
						.text(vlu)); 
						$("#popBrand").hide();
						$('#gray-background').hide();
						$("#popBrand").empty();
		}
		if(requestinghash == 'trae3bad2dca266a568ecbc82e698c8'){
			$('#supplier').find('option').remove().end()
			.append($("<option></option>")
						.attr("value",id)
						.text(vlu)); 
						$("#popBrand").hide();
						$('#gray-background').hide();
						$("#popBrand").empty();
		}
		
		
	});
	$('#removecurrent').click(function(){
		var id = "";
		var vlu = "";
		var requestinghash = $('#poprequester').val();
		if(requestinghash == 'f146aa9099b551a29e4d4ae56e170c7'){
			$('#brand').find('option').remove().end()
			.append($("<option></option>")
						.attr("value",id)
						.text(vlu)); 
						$("#popBrand").hide();
						$('#gray-background').hide();
						$("#popBrand").empty();
		}

		if(requestinghash == 'adae3bad1bca266a568ecbc72e698c9'){
			$('#department').find('option').remove().end()
			.append($("<option></option>")
						.attr("value",id)
						.text(vlu)); 
						$("#popBrand").hide();
						$('#gray-background').hide();
						$("#popBrand").empty();
		}
		
		if(requestinghash == 'adae3bad1bca266a568ecbc82e698c5'){
			$('#sub_department').find('option').remove().end()
			.append($("<option></option>")
						.attr("value",id)
						.text(vlu)); 
						$("#popBrand").hide();
						$('#gray-background').hide();
						$("#popBrand").empty();
		}
		if(requestinghash == 'trae3bad1bca266a568ecbc82e698c8'){
			$('#category').find('option').remove().end()
			.append($("<option></option>")
						.attr("value",id)
						.text(vlu)); 
						$("#popBrand").hide();
						$('#gray-background').hide();
						$("#popBrand").empty();
		}
		if(requestinghash == 'trae3bad2dca266a568ecbc82e698c8'){
			$('#supplier').find('option').remove().end()
			.append($("<option></option>")
						.attr("value",id)
						.text(vlu)); 
						$("#popBrand").hide();
						$('#gray-background').hide();
						$("#popBrand").empty();
		}
		
	});
	$('#submitbtngen').click(function(){
		var t = $('#gtable').DataTable();
		var requestinghash = $('#poprequester').val();
		var requestValue = $('#newDesc').val();
		
		if(requestinghash != 'trae3bad2dca266a568ecbc82e698c8'){
			var data = {reid: requestinghash, revl: requestValue };
		}else{
			var accnu = $('#newaccnum').val();
			var phnu = $('#newphnu').val();
			var data = {reid: requestinghash, revl: requestValue, accnu: accnu, phnu: phnu};
		}
		
        
        jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-new-general-popup.php',
            data: data,
            dataType: 'json',
            success: function(response) {
				var fltr = response[1];
				if(requestinghash != 'trae3bad2dca266a568ecbc82e698c8'){
                var col1 = '<span class="descPopValue" id="descPopValue'+response[0]+'">'+response[1]+'</span>';
				t.row.add([col1]).draw(false);
				}else{
					var col1 = '<span class="descPopValue" id="descPopValue'+response[0]+'">'+response[1]+'</span>';
					var col2 = response[2];
					var col3 = response[3];
					 t.row.add([col1,col2, col3]).draw(false);
				}
               
				$('#newDesc').val('');
				t.search( fltr ).draw();
				
            }
        });
	});
});

//$.post('php-scripts/process-new-general-popup.php', {reid: requestinghash, revl: requestValue }, function(data){
			
 
		//});