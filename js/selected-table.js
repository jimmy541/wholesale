$(document).ready(function() {
	var pTable = '';
	var id = "";
	var subject = $('#subject').val();
	var clickedRow = '';
	var clickedPayment = '';
	
	
		var now = new Date();
		var day = ("0" + now.getDate()).slice(-2);
		var month = ("0" + (now.getMonth() + 1)).slice(-2);
		var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
	
	//{list-products.php  start
	$("#list_products_php_table1 tfoot th").each( function () {
        var title = $(this).text();
		if(title == "Brand" || title == "Item" || title == "Description" || title == "Size"){
			$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
		}
    } );
    var list_products_php_table1 = $("#list_products_php_table1").DataTable({
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
                $( "input", this.footer() ).on( "keyup change clear", function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        }
    });
	$("#list_products_php_table1").parent().addClass("table-responsive");
	$(document).on('click','i',function(){
			
			var str = $(this).attr('id');
			if(typeof str != 'undefined'){
				if (str.indexOf("list_products_php_table1_delete") >= 0){
					clickedRow = $(this).attr('id');
					id = $(this).attr('id').replace('list_products_php_table1_delete', '');
					$( "#modal_remove_product" ).modal("toggle");
				}
			}
	});
	$(document).on('click','#list_products_php_yes_btn',function(){
			var data = {subject: subject, id: id};
				jQuery.ajax({
				type: 'POST',
				url: 'php-scripts/process-general-remove.php',
				data: data,
				success: function(response) {
					$( "#modal_remove_product" ).modal("toggle");
					id = '';
					var t = $('#list_products_php_table1').DataTable();
					t
					.row( $('#'+clickedRow).parents('tr') )
					.remove()
					.draw();
					}
				});
		});
	//}list-products.php end
	//{list-products-departments.php start
	$("#list_products_departments_php_table1 tfoot th").each( function () {
        var title = $(this).text();
		if(title == "Description"){
			$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
		}
    } );
    var list_products_departments_php_table1 = $("#list_products_departments_php_table1").DataTable({
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
                $( "input", this.footer() ).on( "keyup change clear", function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        }
    });
	$(document).on('click','i',function(){
			
			var str = $(this).attr('id');
			if(typeof str != 'undefined'){
				if (str.indexOf("list_products_departments_php_table1_delete") >= 0){
					id = $(this).attr('id').replace('list_products_departments_php_table1_delete', '');
					$( "#modal_remove_product_department" ).modal("toggle");
					clickedRow = $(this).attr('id');
				}
				if (str.indexOf("list_products_departments_php_table1_edit") >= 0){
					id = $(this).attr('id').replace('list_products_departments_php_table1_edit', '');
					$( "#modal_edit_product_department" ).modal("toggle");
					$('#updatedvalue').val($("#desc"+id).text());
					clickedRow = $(this).attr('id');
				}
			}
	});
	$(document).on('click','#list_products_departments_php_save_btn',function(){
			var updatedvalue = $('#updatedvalue').val();
			var data = {subject: subject, id: id, newDesc: updatedvalue};
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-general-edit.php',
            data: data,
			dataType: 'json',
            success: function(response) {
				$( "#modal_edit_product_department" ).modal("toggle");
				var t = $('#list_products_departments_php_table1').DataTable();
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
		$(document).on('click','#list_products_departments_php_yes_btn',function(){
			var data = {subject: subject, id: id};
				jQuery.ajax({
				type: 'POST',
				url: 'php-scripts/process-general-remove.php',
				data: data,
				success: function(response) {
					$( "#modal_remove_product_department" ).modal("toggle");
					id = '';
					var t = $('#list_products_departments_php_table1').DataTable();
					t
					.row( $('#'+clickedRow).parents('tr') )
					.remove()
					.draw();
					}
				});
		});
	//}list-products-departments.php end
	//{list-products-sub-departments.php start
	$("#list_products_sub_department_php_table1 tfoot th").each( function () {
        var title = $(this).text();
		if(title == "Description"){
			$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
		}
    } );
    var list_products_sub_department_php_table1 = $("#list_products_sub_department_php_table1").DataTable({
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
                $( "input", this.footer() ).on( "keyup change clear", function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        }
    });
	$(document).on('click','i',function(){
			
			var str = $(this).attr('id');
			if(typeof str != 'undefined'){
				if (str.indexOf("list_products_sub_departments_php_table1_delete") >= 0){
					id = $(this).attr('id').replace('list_products_sub_departments_php_table1_delete', '');
					$( "#modal_remove_product_sub_department" ).modal("toggle");
					clickedRow = $(this).attr('id');
				}
				if (str.indexOf("list_products_sub_departments_php_table1_edit") >= 0){
					id = $(this).attr('id').replace('list_products_sub_departments_php_table1_edit', '');
					$( "#modal_edit_product_sub_department" ).modal("toggle");
					$('#updatedvalue').val($("#desc"+id).text());
					clickedRow = $(this).attr('id');
				}
			}
	});
	$(document).on('click','#list_products_sub_departments_php_save_btn',function(){
			var updatedvalue = $('#updatedvalue').val();
			var data = {subject: subject, id: id, newDesc: updatedvalue};
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-general-edit.php',
            data: data,
			dataType: 'json',
            success: function(response) {
				$( "#modal_edit_product_sub_department" ).modal("toggle");
				var t = $('#list_products_sub_department_php_table1').DataTable();
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
		$(document).on('click','#list_products_sub_departments_php_yes_btn',function(){
			var data = {subject: subject, id: id};
				jQuery.ajax({
				type: 'POST',
				url: 'php-scripts/process-general-remove.php',
				data: data,
				success: function(response) {
					$( "#modal_remove_product_sub_department" ).modal("toggle");
					id = '';
					var t = $('#list_products_sub_department_php_table1').DataTable();
					t
					.row( $('#'+clickedRow).parents('tr') )
					.remove()
					.draw();
					}
				});
		});
	//}list-products-sub-departments.php end
	//{list-products-brands.php start
	$("#list_products_brands_php_table1 tfoot th").each( function () {
        var title = $(this).text();
		if(title == "Description"){
			$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
		}
    } );
    var list_products_brands_php_table1 = $("#list_products_brands_php_table1").DataTable({
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
                $( "input", this.footer() ).on( "keyup change clear", function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        }
    });
	$(document).on('click','i',function(){
			
			var str = $(this).attr('id');
			if(typeof str != 'undefined'){
				if (str.indexOf("list_products_brands_php_table1_delete") >= 0){
					id = $(this).attr('id').replace('list_products_brands_php_table1_delete', '');
					$( "#modal_remove_product_brand" ).modal("toggle");
					clickedRow = $(this).attr('id');
				}
				if (str.indexOf("list_products_brands_php_table1_edit") >= 0){
					id = $(this).attr('id').replace('list_products_brands_php_table1_edit', '');
					$( "#modal_edit_product_brand" ).modal("toggle");
					$('#updatedvalue').val($("#desc"+id).text());
					clickedRow = $(this).attr('id');
				}
			}
	});
	$(document).on('click','#list_products_brands_php_save_btn',function(){
			var updatedvalue = $('#updatedvalue').val();
			var data = {subject: subject, id: id, newDesc: updatedvalue};
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-general-edit.php',
            data: data,
			dataType: 'json',
            success: function(response) {
				$( "#modal_edit_product_brand" ).modal("toggle");
				var t = $('#list_products_brands_php_table1').DataTable();
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
		$(document).on('click','#list_products_brands_php_yes_btn',function(){
			var data = {subject: subject, id: id};
				jQuery.ajax({
				type: 'POST',
				url: 'php-scripts/process-general-remove.php',
				data: data,
				success: function(response) {
					$( "#modal_remove_product_brand" ).modal("toggle");
					id = '';
					var t = $('#list_products_brands_php_table1').DataTable();
					t
					.row( $('#'+clickedRow).parents('tr') )
					.remove()
					.draw();
					}
				});
		});
	//}list-products-brands.php end
	//{list-products-categories.php start
	$("#list_products_categories_php_table1 tfoot th").each( function () {
        var title = $(this).text();
		if(title == "Description"){
			$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
		}
    } );
    var list_products_categories_php_table1 = $("#list_products_categories_php_table1").DataTable({
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
                $( "input", this.footer() ).on( "keyup change clear", function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        }
    });
	$(document).on('click','i',function(){
			
			var str = $(this).attr('id');
			if(typeof str != 'undefined'){
				if (str.indexOf("list_products_categories_php_table1_delete") >= 0){
					id = $(this).attr('id').replace('list_products_categories_php_table1_delete', '');
					$( "#modal_remove_product_categories" ).modal("toggle");
					clickedRow = $(this).attr('id');
				}
				if (str.indexOf("list_products_categories_php_table1_edit") >= 0){
					id = $(this).attr('id').replace('list_products_categories_php_table1_edit', '');
					$( "#modal_edit_product_category" ).modal("toggle");
					$('#updatedvalue').val($("#desc"+id).text());
					clickedRow = $(this).attr('id');
				}
			}
	});
	$(document).on('click','#list_products_categories_php_save_btn',function(){
			var updatedvalue = $('#updatedvalue').val();
			var data = {subject: subject, id: id, newDesc: updatedvalue};
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-general-edit.php',
            data: data,
			dataType: 'json',
            success: function(response) {
				$( "#modal_edit_product_category" ).modal("toggle");
				var t = $('#list_products_categories_php_table1').DataTable();
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
		$(document).on('click','#list_products_categories_php_yes_btn',function(){
			var data = {subject: subject, id: id};
				jQuery.ajax({
				type: 'POST',
				url: 'php-scripts/process-general-remove.php',
				data: data,
				success: function(response) {
					$( "#modal_remove_product_categories" ).modal("toggle");
					id = '';
					var t = $('#list_products_categories_php_table1').DataTable();
					t
					.row( $('#'+clickedRow).parents('tr') )
					.remove()
					.draw();
					}
				});
		});
	//}list-products-categories.php end
	//{list-products-packages.php start
	$("#list_products_packages_php_table1 tfoot th").each( function () {
        var title = $(this).text();
		if(title == "Description"){
			$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
		}
    } );
    var list_products_packages_php_table1 = $("#list_products_packages_php_table1").DataTable({
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
                $( "input", this.footer() ).on( "keyup change clear", function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        }
    });
	$(document).on('click','i',function(){
			
			var str = $(this).attr('id');
			if(typeof str != 'undefined'){
				if (str.indexOf("list_products_packages_php_table1_delete") >= 0){
					id = $(this).attr('id').replace('list_products_packages_php_table1_delete', '');
					$( "#modal_remove_product_package" ).modal("toggle");
					clickedRow = $(this).attr('id');
				}
				if (str.indexOf("list_products_packages_php_table1_edit") >= 0){
					id = $(this).attr('id').replace('list_products_packages_php_table1_edit', '');
					$( "#modal_edit_product_package" ).modal("toggle");
					$('#updatedvalue').val($("#desc"+id).text());
					clickedRow = $(this).attr('id');
				}
			}
	});
	$(document).on('click','#list_products_packages_php_save_btn',function(){
			var updatedvalue = $('#updatedvalue').val();
			var data = {subject: subject, id: id, newDesc: updatedvalue};
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-general-edit.php',
            data: data,
			dataType: 'json',
            success: function(response) {
				$( "#modal_edit_product_package" ).modal("toggle");
				var t = $('#list_products_packages_php_table1').DataTable();
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
		$(document).on('click','#list_products_packages_php_yes_btn',function(){
			var data = {subject: subject, id: id};
				jQuery.ajax({
				type: 'POST',
				url: 'php-scripts/process-general-remove.php',
				data: data,
				success: function(response) {
					$( "#modal_remove_product_package" ).modal("toggle");
					id = '';
					var t = $('#list_products_packages_php_table1').DataTable();
					t
					.row( $('#'+clickedRow).parents('tr') )
					.remove()
					.draw();
					}
				});
		});
	//}list-products-packages.php end
	//{list-products-weight-units.php start
	$("#list_products_weight_units_php_table1 tfoot th").each( function () {
        var title = $(this).text();
		if(title == "Description"){
			$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
		}
    } );
    var list_products_weight_units_php_table1 = $("#list_products_weight_units_php_table1").DataTable({
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
                $( "input", this.footer() ).on( "keyup change clear", function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        }
    });
	$(document).on('click','i',function(){
			
			var str = $(this).attr('id');
			if(typeof str != 'undefined'){
				if (str.indexOf("list_products_weight_units_php_table1_delete") >= 0){
					id = $(this).attr('id').replace('list_products_weight_units_php_table1_delete', '');
					$( "#modal_remove_product_weight_units" ).modal("toggle");
					clickedRow = $(this).attr('id');
				}
				if (str.indexOf("list_products_weight_units_php_table1_edit") >= 0){
					id = $(this).attr('id').replace('list_products_weight_units_php_table1_edit', '');
					$( "#modal_edit_product_weight_unit" ).modal("toggle");
					$('#updatedvalue').val($("#desc"+id).text());
					clickedRow = $(this).attr('id');
				}
			}
	});
	$(document).on('click','#list_products_weight_unit_php_save_btn',function(){
			var updatedvalue = $('#updatedvalue').val();
			var data = {subject: subject, id: id, newDesc: updatedvalue};
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-general-edit.php',
            data: data,
			dataType: 'json',
            success: function(response) {
				$( "#modal_edit_product_weight_unit" ).modal("toggle");
				var t = $('#list_products_weight_units_php_table1').DataTable();
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
		$(document).on('click','#list_products_weight_units_php_yes_btn',function(){
			var data = {subject: subject, id: id};
				jQuery.ajax({
				type: 'POST',
				url: 'php-scripts/process-general-remove.php',
				data: data,
				success: function(response) {
					$( "#modal_remove_product_weight_units" ).modal("toggle");
					id = '';
					var t = $('#list_products_weight_units_php_table1').DataTable();
					t
					.row( $('#'+clickedRow).parents('tr') )
					.remove()
					.draw();
					}
				});
		});
	//}list-products-unit-weights.php end
	//{list-products-tax-type.php start
	$("#list_products_tax_type_php_table1 tfoot th").each( function () {
        var title = $(this).text();
		if(title == "Description"){
			$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
		}
    } );
    var list_products_tax_type_php_table1 = $("#list_products_tax_type_php_table1").DataTable({
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
                $( "input", this.footer() ).on( "keyup change clear", function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        }
    });
	$(document).on('click','i',function(){
			
			var str = $(this).attr('id');
			if(typeof str != 'undefined'){
				if (str.indexOf("list_products_tax_type_php_table1_delete") >= 0){
					id = $(this).attr('id').replace('list_products_tax_type_php_table1_delete', '');
					$( "#modal_remove_product_tax_type" ).modal("toggle");
					clickedRow = $(this).attr('id');
				}
				if (str.indexOf("list_products_tax_type_php_table1_edit") >= 0){
					id = $(this).attr('id').replace('list_products_tax_type_php_table1_edit', '');
					$( "#modal_edit_product_tax_type" ).modal("toggle");
					$('#updatedvalue').val($("#desc"+id).text());
					$('#updatedvalueV').val($("#tdidV"+id).text());
					clickedRow = $(this).attr('id');
				}
			}
	});
	$(document).on('click','#list_products_tax_type_php_save_btn',function(){
			var updatedvalue = $('#updatedvalue').val();
			var newValue = $('#updatedvalueV').val();
			data = {subject: subject, id: id, newDesc: updatedvalue, newV: newValue};
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-general-edit.php',
            data: data,
			dataType: 'json',
            success: function(response) {
				$( "#modal_edit_product_tax_type" ).modal("toggle");
				var t = $('#list_products_tax_type_php_table1').DataTable();
				var cell = t.cell('#tdid'+id);
				var newValue = '<span id="desc'+response[0]+'">'+response[1]+'</span>';
				cell.data(newValue).draw();
				var cell2 = t.cell('#tdidV'+id);
				var newValue2 = '<span id="value'+response[0]+'">'+response[2]+'</span>';
				cell2.data(newValue2).draw();
			}
			});
		});
		$(document).on('click','#list_products_tax_type_php_yes_btn',function(){
			var data = {subject: subject, id: id};
				jQuery.ajax({
				type: 'POST',
				url: 'php-scripts/process-general-remove.php',
				data: data,
				success: function(response) {
					$( "#modal_remove_product_tax_type" ).modal("toggle");
					id = '';
					var t = $('#list_products_tax_type_php_table1').DataTable();
					t
					.row( $('#'+clickedRow).parents('tr') )
					.remove()
					.draw();
					}
				});
		});
	//}list-products-tax-type.php end
	//{edit-product.php, new-product.php start
		$('#brand').click(function(){
		$(this).blur();
		$( "#modal_product_select_popups" ).modal("toggle");
		$("#popup_title").text("Select Brand");
		$( "#popBrand" ).load( "popup-options.php?reid=f146aa9099b551a29e4d4ae56e170c7" );
		$('#poprequester').val("f146aa9099b551a29e4d4ae56e170c7");
	});
	$('#department').click(function(){
		$(this).blur();
		$( "#modal_product_select_popups" ).modal("toggle");
		$("#popup_title").text("Select Department");
		$( "#popBrand" ).load( "popup-options.php?reid=adae3bad1bca266a568ecbc72e698c9" );
		$('#poprequester').val("adae3bad1bca266a568ecbc72e698c9");
	});
	$('#sub_department').click(function(){
		$(this).blur();
		$( "#modal_product_select_popups" ).modal("toggle");
		$("#popup_title").text("Select Sub Department");
		$( "#popBrand" ).load( "popup-options.php?reid=adae3bad1bca266a568ecbc82e698c5" );
		$('#poprequester').val("adae3bad1bca266a568ecbc82e698c5");
	});
	$('#category').click(function(){
		$(this).blur();
		$( "#modal_product_select_popups" ).modal("toggle");
		$("#popup_title").text("Select Category");
		$( "#popBrand" ).load( "popup-options.php?reid=trae3bad1bca266a568ecbc82e698c8" );
		$('#poprequester').val("trae3bad1bca266a568ecbc82e698c8");
	});
	$('#supplier').click(function(){
		$(this).blur();
		$( "#modal_product_select_popups" ).modal("toggle");
		$("#popup_title").text("Select Supplier");
		$( "#popBrand" ).load( "popup-options.php?reid=trae3bad2dca266a568ecbc82e698c8" );
		$('#poprequester').val("trae3bad2dca266a568ecbc82e698c8");
	});
	//}edit-product.php, new-product.php end
	//{list-suppliers.php start
		$("#list_suppliers_php_table1 tfoot th").each( function () {
        var title = $(this).text();
		if(title == "Supplier Name" || title == "Account Number" || title == "Phone Number"){
			$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
		}
    } );
    // DataTable
    var list_suppliers_php_table1 = $("#list_suppliers_php_table1").DataTable({
        initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
                $( "input", this.footer() ).on( "keyup change clear", function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        }
    });
	$("#list_suppliers_php_table1").parent().addClass("table-responsive");
	$(document).on('click','i',function(){
			
			var str = $(this).attr('id');
			if(typeof str != 'undefined'){
				if (str.indexOf("list_suppliers_php_delete") >= 0){
					id = $(this).attr('id').replace('list_suppliers_php_delete', '');
					$( "#modal_delete_supplier" ).modal("toggle");
					clickedRow = $(this).attr('id');
				}
			}
	});
	$(document).on('click','#list_suppliers_php_yes_btn',function(){
			var data = {subject: subject, id: id};
				jQuery.ajax({
				type: 'POST',
				url: 'php-scripts/process-general-remove.php',
				data: data,
				success: function(response) {
					$( "#modal_delete_supplier" ).modal("toggle");
					id = '';
					var t = $('#list_suppliers_php_table1').DataTable();
					t
					.row( $('#'+clickedRow).parents('tr') )
					.remove()
					.draw();
					}
				});
		});
	//}list-suppliers.php end
	//{list-customers.php start 
	$('#list_customers_php_table1').parent().addClass('table-responsive');
	$(".salesperson").css("width", "100%");
	$(".salesperson").select2({
		dropdownParent: $("#assing_salesperson")
	});
	$('#list_customers_php_table1 tfoot th').each( function () {
        var title = $(this).text();
		if(title == 'Account Number' || title == 'Business Name'){
			$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
		}
    } );
    var list_customers_php_table1 = $('#list_customers_php_table1').DataTable({
		initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        },
		 "order": [],
		"columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            },
			{
                "targets": [ 1 ],
                "visible": false,
                "searchable": false
            },
		]
	});
	$(document).on('click','i',function(){
			
			var str = $(this).attr('id');
			if(typeof str != 'undefined'){
				if (str.indexOf("list_customers_php_delete") >= 0){
					id = $(this).attr('id').replace('list_customers_php_delete', '');
					$( "#modal_delete_customer" ).modal("toggle");
					clickedRow = $(this).attr('id');
				}else if(str.indexOf("list_customers_php_inactive") >= 0){
					id = $(this).attr('id').replace('list_customers_php_inactive', '');
					$( "#modal_deactivate_customer" ).modal("toggle");
					clickedRow = $(this).attr('id');
				}
			}
	});
	$(document).on('click','#list_customers_php_yes_btn',function(){
			var data = {subject: subject, id: id};
				jQuery.ajax({
				type: 'POST',
				url: 'php-scripts/process-general-remove.php',
				data: data,
				success: function(response) {
					$( "#modal_delete_customer" ).modal("toggle");
					id = '';
					var t = $('#list_customers_php_table1').DataTable();
					t
					.row( $('#'+clickedRow).parents('tr') )
					.remove()
					.draw();
					}
				});
		});
		$(document).on('click','#list_customers_php_yes_deactivate_btn',function(){
			var data = {subject: 'inactivecustomer', id: id};
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-general-remove.php',
            data: data,
            success: function(response) {
				$( "#modal_deactivate_customer" ).modal("toggle");
				id = '';
				var t = $('#list_customers_php_table1').DataTable();
				t
				.row( $('#'+clickedRow).parents('tr') )
				.remove()
				.draw();
				}
			});
		});
	$('#list_customers_php_table1 tbody').on( 'click', 'tr', function () {
		if ( $(this).hasClass('disable-select') ) {
		}else{
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
				$("#assign-salesperson-customer").attr("data-target", "");
				$('#customerid').val('');
				$('#customerhash').val('');
				$( ".invoice-top-buttons" ).closest( "ul" ).addClass("invoice-top-buttons-disabled");
				$( ".invoice-top-buttons" ).closest( "ul" ).removeClass("invoice-top-buttons");
			}
			else {
				list_customers_php_table1.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				$("#assign-salesperson-customer").attr("data-target", "#assing_salesperson");
				var ids = $.map(list_customers_php_table1.rows('.selected').data(), function (item) {
					$('#customerid').val(item[0]);
					$('#customerhash').val(item[1]);
					$( ".invoice-top-buttons-disabled" ).closest( "ul" ).addClass("invoice-top-buttons");
					$( ".invoice-top-buttons-disabled" ).closest( "ul" ).removeClass("invoice-top-buttons-disabled");
					var assigned_salesrep = item[5];
					$("#salesperson option").filter(function() {
  //may want to use $.trim in here
  return $(this).text() == assigned_salesrep;
}).prop('selected', true);
					
					
					
				});
			}
		}
    });
	$(document).on('click', '#save-assign-salesperson', function(){
			var customerid = $('#customerhash').val();
			var saleseperson_id = $('#salesperson option:selected').val();
			var data = {customerid:customerid, saleseperson_id:saleseperson_id};
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/update-customer-salesperson.php',
            data: data,
            success: function(response) {
				$('#assing_salesperson').modal('toggle');
			}
			});
		});
	//}list-customers.php end
	//{accounts-unpaid.php start 
	
	$("#accounts_unpaid_php_table1").parent().addClass("table-responsive");
	$('#accounts_unpaid_php_table1 tfoot th').each( function () {
        var title = $(this).text();
		if(title == 'Account Number' || title == 'Business Name'){
			$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
		}
    } );
	var accounts_unpaid_php_table1 = $('#accounts_unpaid_php_table1').DataTable({
		initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        },
		 "order": [],
		"columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            },
			{
                "targets": [ 1 ],
                "visible": false,
                "searchable": false
            },
		]
	});
	$('#accounts_unpaid_php_table1 tbody').on( 'click', 'tr', function () {
		if ( $(this).hasClass('disable-select') ) {
		}else{
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
				$('#customerhash').val('');
				$( ".invoice-top-buttons" ).closest( "ul" ).addClass("invoice-top-buttons-disabled");
				$( ".invoice-top-buttons" ).closest( "ul" ).removeClass("invoice-top-buttons");
			}
			else {
				accounts_unpaid_php_table1.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var ids = $.map(accounts_unpaid_php_table1.rows('.selected').data(), function (item) {
					$('#customerhash').val(item[1]);
					$( ".invoice-top-buttons-disabled" ).closest( "ul" ).addClass("invoice-top-buttons");
					$( ".invoice-top-buttons-disabled" ).closest( "ul" ).removeClass("invoice-top-buttons-disabled");
				});
			}
		}
    });
	//} accounts-unpaid.php end
	//{accounts-statement.php start 
	var accounts_statement_php_table1 = $('#accounts_statement_php_table1').DataTable({
		
		 "order": [],
		"columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            },
			{
                "targets": [ 1 ],
                "visible": false,
                "searchable": false
            },
		]
	});
	
	
	$("#accounts_statement_php_table1").parent().addClass("table-responsive");
	$('#accounts_statement_php_table1 tbody').on( 'click', 'tr', function () {
		if ( $(this).hasClass('disable-select') ) {
		}else{
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
				$('#invoicehash').val('');
				$('#customerhash').val('');
				$( ".invoice-top-buttons" ).closest( "ul" ).addClass("invoice-top-buttons-disabled");
				$( ".invoice-top-buttons" ).closest( "ul" ).removeClass("invoice-top-buttons");
			}
			else {
				accounts_statement_php_table1.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var ids = $.map(accounts_statement_php_table1.rows('.selected').data(), function (item) {
					$('#invoicehash').val(item[0]);
					$('#customerhash').val(item[1]);
					$( ".invoice-top-buttons-disabled" ).closest( "ul" ).addClass("invoice-top-buttons");
					$( ".invoice-top-buttons-disabled" ).closest( "ul" ).removeClass("invoice-top-buttons-disabled");
				});
			}
		}
    });

	//}accounts-statement.php end
	//{accounts-history.php start
	
	$("#accounts_history_php_table1").parent().addClass("table-responsive");
	var accounts_history_php_table1 = $('#accounts_history_php_table1').DataTable({
		"order": [],
		"columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            },
			{
                "targets": [ 1 ],
                "visible": false,
                "searchable": false
            },
		]
	});
	
	//}accounts-history.php end
	//{list-payments.php start
	
	
	$("#list_payments_php_table1").parent().addClass("table-responsive");
	$("#paymentsTable").parent().addClass("table-responsive");
	var list_payments_php_table1 = $('#list_payments_php_table1').DataTable({
		"order": [],
		"columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            },
			{
                "targets": [ 1 ],
                "visible": false,
                "searchable": false
            },{
                "targets": [ 2 ],
                "visible": false,
                "searchable": false
            },
		]
	});
	
	$('#list_payments_php_table1 tbody').on( 'click', 'tr', function () {
		if ( $(this).hasClass('disable-select') ) {
		}else{
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
				$('#invoicehash').val('');
				$('#customerhash').val('');
				$('#paymentid').val('');
				$( ".invoice-top-buttons" ).closest( "ul" ).addClass("invoice-top-buttons-disabled");
				$( ".invoice-top-buttons" ).closest( "ul" ).removeClass("invoice-top-buttons");
			}
			else {
				list_payments_php_table1.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var ids = $.map(list_payments_php_table1.rows('.selected').data(), function (item) {
					$('#invoicehash').val(item[0]);
					$('#customerhash').val(item[1]);
					$('#paymentid').val(item[2]);
					$( ".invoice-top-buttons-disabled" ).closest( "ul" ).addClass("invoice-top-buttons");
					$( ".invoice-top-buttons-disabled" ).closest( "ul" ).removeClass("invoice-top-buttons-disabled");
				});
			}
		}
    });
	
	//}list-payments.php end
	//{list-orders.php start 
	
	$("#payment_date").val(today);
	$("#list_order_php_table1").parent().addClass("table-responsive");
	var list_order_php_table1 = $('#list_order_php_table1').DataTable({
		"order": [],
		"columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": false
            },
			{
                "targets": [ 1 ],
                "visible": false,
                "searchable": false
            }
		]
	});
	
	$('#list_order_php_table1 tbody').on( 'click', 'tr', function () {
		if ( $(this).hasClass('disable-select') ) {
		}else{
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
				$('#invoicehash').val('');
				$('#customerhash').val('');
				$('#paymentid').val('');
				$( ".invoice-top-buttons" ).closest( "ul" ).addClass("invoice-top-buttons-disabled");
				$( ".invoice-top-buttons" ).closest( "ul" ).removeClass("invoice-top-buttons");
			}
			else {
				list_order_php_table1.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
				var ids = $.map(list_order_php_table1.rows('.selected').data(), function (item) {
					$('#invoicehash').val(item[0]);
					$('#customerhash').val(item[1]);
					$('#paymentid').val(item[2]);
					$( ".invoice-top-buttons-disabled" ).closest( "ul" ).addClass("invoice-top-buttons");
					$( ".invoice-top-buttons-disabled" ).closest( "ul" ).removeClass("invoice-top-buttons-disabled");
				});
			}
		}
    });
	$(document).on('click','#delete_order_yes_btn',function(){
			var data = {subject: subject, id: id};
			if(subject == 'invoice-single-item'){
				jQuery.ajax({
				type: 'POST',
				url: 'php-scripts/process-general-remove.php',
				data: data,
				dataType: 'json',
				success: function(response) {
					$( "#modal_delete_order" ).modal("toggle");
					$('#delete'+id).closest('tr').remove();
					id = '';
					$('#invoice_sub_total').text(response[1]);
					$('#invoice_tax').text(response[2]);
					$('#invoice_grand_total').text(response[3]);
					}
				});
			}else{
				jQuery.ajax({
				type: 'POST',
				url: 'php-scripts/process-general-remove.php',
				data: data,
				success: function(response) {
					$('#invoicehash').val('');
					$( "#modal_delete_order" ).modal("toggle");
						id = '';
					var t = $('#list_order_php_table1').DataTable();
					t
					.row( $('#'+clickedRow).parents('tr') )
					.remove()
					.draw();
					}
				});
			}
		});
	//}list-orders.php end
	//{list-users.php start
	$("#list_users_php_table1").DataTable();
	$("#list_users_php_table1").parent().addClass("table-responsive");
	$(document).on('click','i',function(){
			
			var str = $(this).attr('id');
			if(typeof str != 'undefined'){
				if (str.indexOf("list_users_php_delete") >= 0){
					id = $(this).attr('id').replace('list_users_php_delete', '');
					$( "#modal_remove_users" ).modal("toggle");
					clickedRow = $(this).attr('id');
				}
			}
	});
	$(document).on('click','#list_users_php_yes_btn',function(){
			var data = {subject: subject, id: id};
				jQuery.ajax({
				type: 'POST',
				url: 'php-scripts/process-general-remove.php',
				data: data,
				success: function(response) {
					$( "#modal_remove_users" ).modal("toggle");
					id = '';
					var t = $('#list_users_php_table1').DataTable();
					t
					.row( $('#'+clickedRow).parents('tr') )
					.remove()
					.draw();
					}
				});
		});
	//}list-users.php end
	
	

	$(document).on( 'click', '#paymentsTable tbody tr', function () {
		var tb = $(this);
        if ( tb.hasClass('selected') ) {
            tb.removeClass('selected');
			$('#paymentid').val('');
			$( ".invoice-top-buttons2" ).closest( "ul" ).addClass("invoice-top-buttons-disabled2");
			$( ".invoice-top-buttons2" ).closest( "ul" ).removeClass("invoice-top-buttons2");
        }
        else {
            pTable.$('tr.selected').removeClass('selected');
            tb.addClass('selected');
			$( ".invoice-top-buttons-disabled2" ).closest( "ul" ).addClass("invoice-top-buttons2");
			$( ".invoice-top-buttons-disabled2" ).closest( "ul" ).removeClass("invoice-top-buttons-disabled2");
			var ids = $.map(pTable.rows('.selected').data(), function (item) {
				$('#paymentid').val(item[0]);
			});
        }
    });
	
	$('#uncusstatement').click(function(){
		var currentSel = $('#customerhash').val();
		if(currentSel){
			window.location.href = "accounts-statement.php?customer="+currentSel;
		}
	});
	$('#printstatement').click(function(){
		var currentSel = $('#customerhash').val();
		if(currentSel){
			window.location.href = "pdf-customer-statement.php?customer="+currentSel;
		}
	});
	$('#downloadstatement').click(function(){
		var currentSel = $('#customerhash').val();
		if(currentSel){
			window.location.href = "pdf-customer-statement.php?d=1&customer="+currentSel;
		}
	});
	$('#printacchistory').click(function(){
		var currentSel = $('#customerhash').val();
		var datefrom = $('#datefrom').val();
		var dateto = $('#dateto').val();
		if(currentSel){
			window.location.href = "pdf-account-history.php?customer="+currentSel+"&datefrom="+datefrom+"&dateto="+dateto;
		}
	});
	$('#downloadacchistory').click(function(){
		var currentSel = $('#customerhash').val();
		var datefrom = $('#datefrom').val();
		var dateto = $('#dateto').val();
		if(currentSel){
			window.location.href = "pdf-account-history.php?d=1&customer="+currentSel+"&datefrom="+datefrom+"&dateto="+dateto;
		}
	});
	$('#print-list').click(function(){
		window.location.href = "pdf-accounts-unpaid.php";
	});
	$('#download-list').click(function(){
		window.location.href = "pdf-accounts-unpaid.php?d=1";
	});
	$('#show-quotes').click(function(){
		var currentSel = $('#show-quotes').text();
		if(currentSel == 'Quotes'){
			window.location.href = "list-orders.php?show=quotes";
		}else{
			window.location.href = "list-orders.php";
		}	
	});
	$('#view-order').click(function(){
		var currentSel = $('#invoicehash').val();
		if(currentSel){
			window.location.href = "invoice.php?invoice="+currentSel;
		}
	});
	$('#print-order').click(function(){
		var currentSel = $('#invoicehash').val();
		if(currentSel){
			window.location.href = "pdf-invoice.php?invoice="+currentSel;
		}
	});
	$('#download-order').click(function(){
		var currentSel = $('#invoicehash').val();
		if(currentSel){
			window.location.href = "pdf-invoice.php?d=1&invoice="+currentSel;
		}
	});
	$('#send-order').click(function(){
		var currentSel = $('#invoicehash').val();
		if(currentSel){
			$.get("pdf-invoice.php?s=1&invoice="+currentSel);
			//return false;
			$('#closeIcon2').hide();
			$('#closeIcon').show();
		    $( "#populateDivSend" ).show();
			var cushash = $('#customerhash').val();
			$('#emailsubject').val('Invoice '+$('#invoice-number').val());
			$('#message_text').val('Dear Client, \nAttached is your invoice. \n\nThank you for your business!\n');
			$('#gray-background').show();
					$.ajax({
						url: 'php-scripts/process-get-emails-of-customer.php',
						type: 'post',
						data: {customer:cushash},
						dataType: 'json',
						success:function(response){
							var len = response.length;
							$("#emailto").empty();
							$("#emailto").append("<option value='Custom'>Custom</option>");
							$("#emailtoblock").show();
							for( var i = 0; i<len; i++){
								var fname = response[i]['fullname'];
								var email = response[i]['email'];
								$("#emailto").append("<option value='"+fname+"'>"+email+"</option>");
							}
						}
					});
		}
	});
	$('#sendstatement').click(function(){
		var currentSel = $('#customerhash').val();
		if(currentSel){
			$.get("pdf-customer-statement.php?s=1&customer="+currentSel);
			//return false;
			$('#closeIcon2').hide();
			$('#closeIcon').show();
		    $( "#populateDivSend" ).show();
			var cushash = $('#customerhash').val();
			$('#emailsubject').val('Statement');
			$('#message_text').val('Dear Client, \nAttached is your statement. \n\nThank you for your business!\n');
			$('#gray-background').show();
					$.ajax({
						url: 'php-scripts/process-get-emails-of-customer.php',
						type: 'post',
						data: {customer:cushash},
						dataType: 'json',
						success:function(response){
							var len = response.length;
							$("#emailto").empty();
							$("#emailto").append("<option value='Custom'>Custom</option>");
							$("#emailtoblock").show();
							for( var i = 0; i<len; i++){
								var fname = response[i]['fullname'];
								var email = response[i]['email'];
								$("#emailto").append("<option value='"+fname+"'>"+email+"</option>");
							}
						}
					});
		}
	});
	$('#sendhistory').click(function(){
		var currentSel = $('#customerhash').val();
		if(currentSel){
			var datefrom = $('#datefrom').val();
			var dateto = $('#dateto').val();
			$.get("pdf-account-history.php?s=1&customer="+currentSel+"&datefrom="+datefrom+"&dateto="+dateto);
			//return false;
			$('#closeIcon2').hide();
			$('#closeIcon').show();
		    $( "#populateDivSend" ).show();
			var cushash = $('#customerhash').val();
			$('#emailsubject').val('Account history');
			$('#message_text').val('Dear Client, \nAttached is your account history. \n\nThank you for your business!\n');
			$('#gray-background').show();
					$.ajax({
						url: 'php-scripts/process-get-emails-of-customer.php',
						type: 'post',
						data: {customer:cushash},
						dataType: 'json',
						success:function(response){
							var len = response.length;
							$("#emailto").empty();
							$("#emailto").append("<option value='Custom'>Custom</option>");
							$("#emailtoblock").show();
							for( var i = 0; i<len; i++){
								var fname = response[i]['fullname'];
								var email = response[i]['email'];
								$("#emailto").append("<option value='"+fname+"'>"+email+"</option>");
							}
						}
					});
		}
	});
	$('#pull-sheet').click(function(){
		var currentSel = $('#invoicehash').val();
		if(currentSel){
			window.location.href = "pdf-pull-sheet.php?invoice="+currentSel;
		}
	});
	$('#pay-invoice').click(function(){
		var currentSel = $('#invoicehash').val();
		$('#closeIcon2').hide();
		$('#closeIcon').show();
		$('#payment-saving-mode').val('new');
		if (currentSel){
				
				$('#payment_amount').val('');
				$('#ref_no').val('');
				
				$("#payment_date").val(today);
				$('#payment_amount').val('');
				
				
				$( "#modal_show_payment" ).modal("toggle");
		}
	});
	$('#view-customer-invoices').click(function(){
		var currentSel = $('#customerhash').val();
		if(currentSel){
			window.location.href = "list-orders.php?customer="+currentSel;
		}
	});
	$('#customer-statement-ll').click(function(){
		var currentSel = $('#customerhash').val();
		if(currentSel){
			window.location.href = "accounts-statement.php?customer="+currentSel;
		}
	});
	$('#customer-list-acchistory').click(function(){
		var currentSel = $('#customerhash').val();
		var dToday = $('#todaydate').val();
		var d3months = $('#prior3months').val();
		if(currentSel){
			window.location.href = "accounts-history.php?datefrom="+d3months+"&dateto="+dToday+"&customer_select="+currentSel;
		}
	});
	$('#customer-payment-history').click(function(){
		var currentSel = $('#customerhash').val();
		if(currentSel){
			window.location.href = "list-payments.php?customer="+currentSel;
		}
	});
	$('#print-payment-history').click(function(){
		var pdfrom = $('#pdatefrom').val();
		var pdto = $('#pdateto').val();
		var pcustomer = $('#customerfilter').val();
			window.location.href = "pdf-payments.php?dfrom="+pdfrom+"&dto="+pdto+"&customer="+pcustomer;
	});
	$('#download-payment-history').click(function(){
		var pdfrom = $('#pdatefrom').val();
		var pdto = $('#pdateto').val();
		var pcustomer = $('#customerfilter').val();
			window.location.href = "pdf-payments.php?d=1&dfrom="+pdfrom+"&dto="+pdto+"&customer="+pcustomer;
	});
	$(document).on('click','#edit-payment',function(){
		$('#closeIcon').show();
		$('#closeIcon2').show();
		var currentSel = $('#invoicehash').val();
		var paymentid = $('#paymentid').val();
		$('#payment-saving-mode').val('edit');
		if (currentSel){
			var data = {id:paymentid};
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-get-invoice-fields.php',
            data: data,
			dataType: 'json',
            success: function(response) {
				var dtValue = response[0];
				var amnt = response[1];
				var mop = response[2];
				var ref = response[3];
				$( "#modal_show_payment" ).modal("toggle");
				$('#ref_no').val('');
				$('#payment_amount').val('');
				document.getElementById("payment_date").value = dtValue;
				$('#payment_amount').val(amnt);
				$("#mop").val(mop);
				$('#ref_no').val(ref);
			}
			});
			}
	});
	$('#payment-history').click(function(){
		var currentSel = $('#invoicehash').val();
		if (currentSel){
			var customerid = $('#customerhash').val();
			var data = {id:currentSel, customerid:customerid};
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-get-payment-history.php',
            data: data,
            success: function(response) {
				$('#modal_payment_history_body').html(response);
				pTable = $('#paymentsTable').DataTable({
					"paging":   false,
					"info":     false,
					"scrollCollapse": true
				});
				$( "#populateDivPaymentHis" ).modal("toggle");
			}
			});
			}
	});
	/* Handling buttons inside the buttons*/
	$('#delete-order').click(function(){
			clickedRow = $('#invoicehash').val();
			id = $('#invoicehash').val();
			if (id){
				$( "#modal_delete_order" ).modal("toggle");
				
			}
		});
		$(document).on('click', '#delete-payment',function(){
			clickedPayment = $('#paymentid').val();
			id = $('#invoicehash').val();
			if (clickedPayment){
				$( "#modal_delete_payment" ).modal("toggle");
			}
		});
		
		$(document).on('click','button',function(){
			//clickedRow = $(this).attr('id');
			var str = $(this).attr('id');
			if(typeof str != 'undefined'){
			if (str.indexOf("changestatus") >= 0){
				clickedRow = $('#invoicehash').val();
				id = $('#invoicehash').val();
				$( "#modal_change_order_status" ).modal("toggle");
				id = $(this).attr('id').replace('changestatus', '');
				
			}
		}
		});
		$(document).on('click','#status-change-to-processing',function(){
			var data = {changeto: 'Processing', id: id};
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-change-invoice-status.php',
            data: data,
            success: function(response) {
				$( "#modal_change_order_status" ).modal("toggle");
				$('#changestatus'+id).text("Processing");
				$('#changestatus'+id).addClass('btn-warning').removeClass('btn-success').removeClass('btn-info');
				//$('#changestatus'+id).css("background-color","#ffc107");
				//$('#changestatus'+id).css("border-color","#ffc107");
					id = '';
				}
			});
		});
		$(document).on('click','#status-change-to-shipped',function(){
			var data = {changeto: 'Shipped', id: id};
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-change-invoice-status.php',
            data: data,
            success: function(response) {
				$( "#modal_change_order_status" ).modal("toggle");
				$('#changestatus'+id).text("Shipped");
				$('#changestatus'+id).addClass('btn-info').removeClass('btn-success').removeClass('btn-warning');
				//$('#changestatus'+id).css("background-color","#17a2b8");
				//$('#changestatus'+id).css("border-color","#17a2b8");
					id = '';
				}
			});
		});
		$(document).on('click','#status-change-to-delivered',function(){
			var data = {changeto: 'Delivered', id: id};
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-change-invoice-status.php',
            data: data,
            success: function(response) {
				$( "#modal_change_order_status" ).modal("toggle");
				$('#changestatus'+id).text("Delivered");
				$('#changestatus'+id).addClass('btn-success').removeClass('btn-warning').removeClass('btn-info');
				//$('#changestatus'+id).css("background-color","#1e7e34");
				//$('#changestatus'+id).css("border-color","#1e7e34");
					id = '';
				}
			});
		});
		
		
		
		$(document).on('click','#delete_payment_yes_btn',function(){
			var data = {subject: "payment", id: clickedPayment};
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-general-remove.php',
            data: data,
			dataType: 'json',
            success: function(response) {
				$('#paymentid').val('');
				$( "#modal_delete_payment" ).modal("toggle");
				var requestingpage = $('#page-requesting').val();
				if (requestingpage == 'payments-page'){
					var t = $('#list_payments_php_table1').DataTable();
					t
					.row( $('#'+clickedPayment).parents('tr') )
					.remove()
					.draw();
				}else{
					var t = $('#list_order_php_table1').DataTable();
					var cell = t.cell('#invbalance'+id);
					var newValue = response[0];
					cell.data(newValue).draw();
					t = $('#paymentsTable').DataTable();
					t
					.row( $('#'+clickedPayment).parents('tr') )
					.remove()
					.draw();
				}
			}
			});
		});
		$("#emailto" ).change(function() {
			var sendto = $('#emailto option:selected').val();
			if(sendto != 'Custom'){
				$('#emailtoblock').hide();
			}else{
				$('#emailtoblock').show();
			}
		});
		$("#send-email-button").click(function () {
			var emailaddress = '';
			var sendto = $('#emailto option:selected').text();
			var sendtoname = $('#emailto option:selected').val();
			var msgbody = $('#message_text').val();
			var msgsubject = $('#emailsubject').val();
			var doctype = $('#doc-type').val();
			if(sendto == 'Custom'){
				emailaddress = $('#emailaddress').val();
				sendtoname = "";
			}else{
				emailaddress = $('#emailto option:selected').text();
			}
			var inid = "";
			if(doctype == 'invoice'){
				inid = $('#invoicehash').val();
			}else if (doctype == 'statement'){
				inid = $('#customerhash').val();
			}else if (doctype == 'ahistory'){
				inid = $('#customerhash').val();
			}
			if(emailaddress && isEmail(emailaddress)){
				var data = {doctype:doctype, email:emailaddress, toname:sendtoname, invoice:inid, msgsubject:msgsubject, msgbody:msgbody}
				jQuery.ajax({
					type: 'POST',
					url: 'php-scripts/sendmail.php',
					data: data,
					dataType: 'text',
					success: function(response) {
						$('#email-sent-success').show();
					}
				});
				$('#gray-background').hide();
				$( "#populateDivSend" ).hide();
			}else{
				$( '<div class="group-fields errordiv"><span class="fielderrormsg">Invalid e-mail address</span></div>' ).insertAfter( $('#emailto') );
			}
		});
		$(document).on('click','#save-pay-button',function(){
			id = $('#invoicehash').val();
			var requestingpage = $('#page-requesting').val();
			var table_name = 'list_order_php_table1';
				if (requestingpage == 'list-orders'){
					
				}
			var customerid = $('#customerhash').val();
			var paydate = $('#payment_date').val();
			var amount = $('#payment_amount').val();
			var refnum = $('#ref_no').val();
			var mop = $('#mop').val();
			var savingmode = $('#payment-saving-mode').val();
			var data = '';
			if(savingmode=='new'){data = {id:id, customerid:customerid, paydate:paydate, amount:amount, refnum:refnum, mop:mop, savingmode:savingmode};}
			if(savingmode=='edit'){
				var paymentid = $('#paymentid').val();
				data = {paymentid:paymentid, id:id, customerid:customerid, paydate:paydate, amount:amount, refnum:refnum, mop:mop, savingmode:savingmode};
				}
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-pay-invoice.php',
            data: data,
			dataType: 'json',
            success: function(response) {
				$( "#modal_show_payment" ).modal("toggle");
				var t = $('#'+table_name).DataTable();
				var cell = t.cell('#invbalance'+id);
				var newValue = response[0];
				cell.data(newValue).draw();
				if(savingmode=='edit'){
					t = $('#paymentsTable').DataTable();
					var cell = t.cell('#payamount'+$('#paymentid').val());
					var newValue = response[1];
					cell.data(newValue).draw();
					var cell = t.cell('#paydate'+$('#paymentid').val());
					var newValue = response[2];
					cell.data(newValue).draw();
					var cell = t.cell('#ref'+$('#paymentid').val());
					var newValue = response[3];
					cell.data(newValue).draw();
					var cell = t.cell('#mop'+$('#paymentid').val());
					var newValue = response[4];
					cell.data(newValue).draw();
				}
			}
			});
		});
		
//{Special batch and push batch start
$("#products_modal_gtable").width("100%");
$('#add_products_push_specials').on('shown.bs.modal', function() {
    $('#single_case_price').trigger('focus');
  });
var products_modal_gtable = $('#products_modal_gtable').DataTable({
	"columnDefs": [
            {
                "targets": [ 0 ],
                "searchable": false
            },
			{
                "targets": [ 7 ],
                "searchable": false
            },
			{
                "targets": [ 8 ],
                "searchable": false
            }
        ]
});	
var products_specials = $('#special_products').DataTable({
	"columnDefs": [
            {
                "targets": [ 7 ],
                "searchable": false
            },
			{
                "targets": [ 8 ],
                "searchable": false
            },
			{
                "targets": [ 9 ],
                "searchable": false
            }
        ]
});	
$('#products_modal_gtable tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
			$("#add_product_button").attr("disabled", true);
			$('#product_id_form_1').val('');
			}
        else {
            products_modal_gtable.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
			$("#add_product_button").removeAttr("disabled");
			var ids = $.map(products_modal_gtable.rows('.selected').data(), function (item) {
				$('#product_id_form_1').val(item[0]);
				$('#product_description').val(item[2] + ' ' + item[3]);
				$('#regular_price').val(item[5]);
				$('#cost').val(item[7]);
				$('#cases_in_pallet').val(item[8]);
				$('#special_batch_product_price_form').attr('action', 'php-scripts/process-add-product-to-special-batch.php');
			});
        }
    } );
		$(document).on('click','i',function(){
			
			var str = $(this).attr('id');
			if(typeof str != 'undefined'){
				if (str.indexOf("remove_item_from_batch") >= 0){
					$( "#modal_remove_product" ).modal("toggle");
					id = $(this).attr('id').replace('remove_item_from_batch', '');
					clickedRow = $(this).attr('id');
				}
			}
		});
		$(document).on('click','i',function(){
			
			var str = $(this).attr('id');
			if(typeof str != 'undefined'){
				if (str.indexOf("special_batch") >= 0){
					$( "#modal_remove_product" ).modal("toggle");
					id = $(this).attr('id').replace('special_batch', '');
					$('#batch_id').val(id);
					clickedRow = $(this).attr('id');
				}
			}
		});
		$(document).on('click','#delete_special_batch',function(){
			var batchid = $('#batch_id').val();
			var data = {subject: "special_batch", batchid: batchid};
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-general-remove.php',
            data: data,
            success: function(response) {
					var t = $('#list_special_batches_table').DataTable();
					t
					.row( $('#'+clickedRow).parents('tr') )
					.remove()
					.draw();
					clickedRow = '';
					id = '';
					$( "#modal_remove_product" ).modal("toggle");
			}
			});
		});
		$(document).on('click','#delete_product_special_batch',function(){
			var batchid = $('#batch_id').val();
			var data = {subject: "special_batch_product", batchid: batchid, recordid:id};
			jQuery.ajax({
            type: 'POST',
            url: 'php-scripts/process-general-remove.php',
            data: data,
            success: function(response) {
					products_specials					
					.row( $('#'+clickedRow).parents('tr') )
					.remove()
					.draw();
					clickedRow = '';
					id = '';
					$( "#modal_remove_product" ).modal("toggle");
			}
			});
		});
		$(document).on('click','i',function(){
			
			var str = $(this).attr('id');
			if(typeof str != 'undefined'){
				if (str.indexOf("update_batch_product") >= 0){
					clickedRow = $(this).attr('id');
					$(this).closest('tr').addClass('selected');
					var special_products = $('#special_products').DataTable();
					var ids = $.map(special_products.rows('.selected').data(), function (item) {
					$('#product_description').val(item[1]);
					$('#regular_price').val(item[8]);
					$('#cost').val(item[7]);
					$('#cases_in_pallet').val(item[9]);
					$('#single_case_price').val(item[3]);
					$('#minimum_qty').val(item[4]);
					$('#free_cases').val(item[5]);
					});
					$(this).closest('tr').removeClass('selected');
					id = $(this).attr('id').replace('update_batch_product', '');
					$('#product_id_form_1').val(id);
					$( "#add_products_push_specials" ).modal("toggle");
					$('#special_batch_product_price_form').attr('action', 'php-scripts/process-edit-product-to-special-batch.php');
				}
			}
		});
//}Special batch and push batch end 
	/* Functions */
	function generate_token(length){
		//edit the token allowed characters
		var a = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890".split("");
		var b = [];  
		for (var i=0; i<length; i++) {
			var j = (Math.random() * (a.length-1)).toFixed(0);
			b[i] = a[j];
		}
		return b.join("");
	}
	function isEmail(email) {
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			return regex.test(email);
		}
	
});