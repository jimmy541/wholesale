$(document).ready(function(){
		var id = "";
		var subject = $('#subject').val();
		var clickedRow = '';
		$(document).on('click','span',function(){
			clickedRow = $(this).attr('id');
			var str = $(this).attr('id');
			
			if (str.indexOf("del") >= 0){
				$( "#populateDivGen" ).show();
				id = $(this).attr('id').replace('del', '');
				$('#gray-background').show();
			}
			if (str.indexOf("edit") >= 0){
				$( "#populateDivGenEdit" ).show();
				id = $(this).attr('id').replace('edit', '');
				$('#updatedvalue').val($("#desc"+id).text());
				if(subject == 'tt'){
					$('#updatedvalueV').val($("#value"+id).text());
					
				}
				$('#gray-background').show();
			}
		});

		$(document).on('click','#noBtn',function(){
			$( "#populateDivGen" ).hide();
			$('#gray-background').hide();
			id = '';
		});
		$(document).on('click','#cancelBtn',function(){
			$( "#populateDivGenEdit" ).hide();
			$('#gray-background').hide();
			id = '';
		});
		
		$(document).on('click','#yesBtn',function(){
			var data = {subject: subject, id: id};
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-general-remove.php',
            data: data,
			
            success: function(response) {
				$( "#populateDivGen" ).hide();
				$('#gray-background').hide();
					id = '';
				var t = $('#gtable').DataTable();
				
				t
				.row( $('#'+clickedRow).parents('tr') )
				.remove()
				.draw();
				}
			});
		});
		
		$(document).on('click','#saveBtn',function(){
			var updatedvalue = $('#updatedvalue').val();
			var data = {subject: subject, id: id, newDesc: updatedvalue};
			
			if(subject == 'tt'){
					var newValue = $('#updatedvalueV').val();
					data = {subject: subject, id: id, newDesc: updatedvalue, newV: newValue};
					
			}
			
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-general-edit.php',
            data: data,
			dataType: 'json',
            success: function(response) {
				$( "#populateDivGenEdit" ).hide();
				$('#gray-background').hide();
					
				var t = $('#gtable').DataTable();
				var cell = t.cell('#tdid'+id);
				var newValue = '<span id="desc'+response[0]+'">'+response[1]+'</span>';
				cell.data(newValue).draw();
				
				if(subject == 'tt'){
					
					var cell2 = t.cell('#tdidV'+id);
					var newValue2 = '<span id="value'+response[0]+'">'+response[2]+'</span>';
					cell2.data(newValue2).draw();
				}
					
				
				
			}
			});
		});
		
});