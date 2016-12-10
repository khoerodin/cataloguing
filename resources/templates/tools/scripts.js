jQuery(function($) {
    // INSERT ELEMENT FOR HANDLEBARS
    $('<div id="navbar"></div><div id="content"></div>').insertAfter('#loading');
    // END INSERT ELEMENT FOR HANDLEBARS

    // HANDLEBARS TEMPLATE
    $('#navbar').html(Tools.templates.navbar());
    $('#content').html(Tools.templates.content());
    // END HANDLEBARS TEMPLATE

    // toolsTab
    $("#toolsTab a").click(function(e){
        e.preventDefault();
        $(this).tab('show');
    });
    // End toolsTab

    var bar = $('.progress-bar');
	var percent = $('.percent');
	var status = $('#status');	
	var uploaded_file = '';
	$('form').ajaxForm({
	    beforeSend: function() {
	    	window.onbeforeunload = function() {return '';}
	        status.empty();
	        $("#save-btn-area").empty();
	        var percentVal = '0%';
	        bar.width(percentVal)
	        percent.html(percentVal+' UPLOADED');
	        $("#display_uploaded_table").html("");
	        $('#status').html('<span class="text-success">UPLOADING SPREADSHEET... <div class="mini-spinner"></div></span>');
	    	$('input#file_upload').attr('disabled', 'disabled');
	    },
	    uploadProgress: function(event, position, total, percentComplete) {
	        var percentVal = percentComplete + '%';
	        bar.width(percentVal)
	        percent.html(percentVal+' UPLOADED');
	    },
	    success: function(xhr) {
	        var percentVal = '100%';
	        bar.width(percentVal)
	        percent.html(percentVal+' UPLOADED');
	        var dest = $('#select_table').val();
	        $('#status').html('<span class="text-success">SPREADSHEET UPLOADED &#x2714;<br/>READING AND VALIDATING YOUR DATA... <div class="mini-spinner"></div></span>');
	        $.ajax({
			    type: 'GET',
			    url: 'tools/read-source/'+xhr.file,
			    success: function(data){
			    	$('#status').html('');     	
		        	$("#display_uploaded_table").html(data);
		        	$(".import_to_db").appendTo("#save-btn-area");
		        	$('input#file_upload').removeAttr('disabled');

		        	$('#datatables').dataTable( {
						dom: "<'row'<'col-sm-6'><'col-sm-6'f>>" +
								"Z<'row'<'col-sm-12'tr>>" +
								"<'row'<'col-sm-5'i><'col-sm-7'p>>",
						oLanguage: {
			                sInfo: "_START_ TO _END_ OF _TOTAL_ ROWS",
			                oPaginate: {
			                    sFirst: "FIRST",
			                    sLast: "LAST",
			                    sNext: "NEXT",
			                    sPrevious: "PREVIOUS"
			                },
			                sSearch: "",
			                sSearchPlaceholder: "SEARCH...",
			            },
					});

		        	$("#message").appendTo("div#datatables_wrapper div.row div.col-sm-6:eq(0)");
		        	$("#data_counter").appendTo("#counter");

		        	uploaded_file = xhr.file;
		        	window.onbeforeunload = function() {}
			    },
			    error: function(xhr){
			    	var errors = xhr.responseJSON;
			    	$('#status').html('<span class="text-danger">'+errors+'</span>');
			    	$('input#file_upload').removeAttr('disabled');
			    	window.onbeforeunload = function() {}
			    }
			});
	        // $('#div.progress').remove();
	    },
		complete: function(xhr) {},
		error: function(xhr) {
			var percentVal = '0%';
	        bar.width(percentVal)
	        percent.html(percentVal);

	        var errors = xhr.responseJSON;
			$('#status').html('<span class="text-danger">'+errors.document+'</span>');
			$("#display_uploaded_table").html("");
			$('input#file_upload').removeAttr('disabled');
			window.onbeforeunload = function() {}
		}
	});

	$('#file_upload').change(function() {
	  $('form').submit();
	});

	$('#file_upload').click(function() {
	    this.value = null;
	});

	// IMPORT to DATABASE
	var uploaded_file = uploaded_file;
	$(document).on('click', '.import_inc', function() {
		$.ajax({
		    type: 'GET',
		    url: 'tools/import-inc/'+uploaded_file,
		    beforeSend: function(){
		    	window.onbeforeunload = function() {return '';}
		    	$('input#file_upload').attr('disabled', 'disabled');
		    	$('.import_inc').attr('disabled', 'disabled');
		    	$("#message").html("IMPORTING YOUR <strong>INC</strong> DATA... <div class='mini-spinner'></div>");
		    },
		    success: function(data){
		    	window.onbeforeunload = function() {}
		    	$('#status').empty();
		    	$("#file_upload").val('');
		    	$("div.bootstrap-filestyle.input-group input").val('');
		    	$("span.group-span-filestyle.input-group-btn > label > span").text('SELECT SPREADSHEET AGAIN');
		    	$('input#file_upload').removeAttr('disabled');
	        	$("#save-btn-area").empty();
	        	$("#display_uploaded_table").empty();
	        	$("#status").html("<span class='text-success'><strong>"+data+" OF INC</strong> DATA HAS BEEN IMPORTED SUCCESSFULLY</span>");
		    },
		    error: function(){
		    	window.onbeforeunload = function() {}
		    	$("#file_upload").val('');
		    	$("div.bootstrap-filestyle.input-group input").val('');
		    	$("span.group-span-filestyle.input-group-btn > label > span").text('SELECT SPREADSHEET AGAIN');
		    	$('input#file_upload').removeAttr('disabled');
		    	$('.import_inc').removeAttr('disabled');
	        	$("#message").html("<strong style='color:red;'>ERROR</strong> IMPORTING YOUR <strong>INC</strong> DATA");
		    }
		});
	});
});

function upload_pmc() {
	$.ajax({
	    type: 'POST',
	    url: 'tools/insert-pmc',
	    data: $('.part_master_id').serialize()+'&'+$('.tbl_manufacturer_code_id').serialize()+'&'+$('.tbl_source_type_id').serialize()+'&'+$('.manufacturer_ref').serialize()+'&'+$('.tbl_part_manufacturer_code_type_id').serialize(),
	    dataType: 'json',
	    beforeSend: function(){
	    },
	    success: function(data){
	    	$('#uploaded_area').remove();
	    	$('#status').empty();
	        var percentVal = '0%';
	        $('.progress-bar').width(percentVal)
	        $('.percent').html(percentVal);

	        $("#file_upload").val('');
	        $("div.bootstrap-filestyle.input-group input").val('');

	        $('#status').html('<h4 class="text-primary"><u>'+data+'</u> rows of <u>Part Manufacturer Code</u> data has been saved successfully</h4>');
	    	
	    	$("span.group-span-filestyle.input-group-btn > label > span").html('UPLOAD AGAIN');

	    	$("#save-btn-area").html('');
	    },
	    error: function(data){
	    	var errors = data.responseJSON;
	    	err = '';
	    	$.each(errors, function( index, value ) {
			  err = '<p>' + value + '</p>';
			});
	    	$('#status').html('<font color="red">'+err+'</font>');
	    }
	});
};

function upload_pec() {
	$.ajax({
	    type: 'POST',
	    url: 'tools/insert-pec',
	    data: $('.part_master_id').serialize()+'&'+$('.tbl_equipment_code_id').serialize()+'&'+$('.qty_install').serialize()+'&'+$('.tbl_manufacturer_code_id').serialize()+'&'+$('.doc_ref').serialize()+'&'+$('.dwg_ref').serialize(),
	    dataType: 'json',
	    beforeSend: function(){
	    },
	    success: function(data){
	    	$('#uploaded_area').remove();
	    	$('#status').empty();
	        var percentVal = '0%';
	        $('.progress-bar').width(percentVal)
	        $('.percent').html(percentVal);

	        $("#file_upload").val('');
	        $("div.bootstrap-filestyle.input-group input").val('');

	        $('#status').html('<h4 class="text-primary"><u>'+data+'</u> rows of <u>Part Equipment Code</u> data has been imported successfully</h4>');
	    	
	    	$("span.group-span-filestyle.input-group-btn > label > span").html('IMPORT AGAIN');

	    	$("#save-btn-area").html('');
	    },
	    error: function(data){
	    	var errors = data.responseJSON;
	    	err = '';
	    	$.each(errors, function( index, value ) {
			  err = '<p>' + value + '</p>';
			});
	    	$('#status').html('<font color="red">'+err+'</font>');
	    }
	});
};

function upload_tgc() {
	$.ajax({
	    type: 'POST',
	    url: 'tools/insert-tgc',
	    data: $('.tbl_group_id').serialize()+'&'+$('.class').serialize()+'&'+$('.name').serialize()+'&'+$('.eng_definition').serialize()+'&'+$('.ind_definition').serialize(),
	    dataType: 'json',
	    beforeSend: function(){
	    },
	    success: function(data){
	    	$('#uploaded_area').remove();
	    	$('#status').empty();
	        var percentVal = '0%';
	        $('.progress-bar').width(percentVal)
	        $('.percent').html(percentVal);

	        $("#file_upload").val('');
	        $("div.bootstrap-filestyle.input-group input").val('');

	        $('#status').html('<h4 class="text-primary"><u>'+data+'</u> rows of <u>Group Class</u> data has been imported successfully</h4>');
	    	
	    	$("span.group-span-filestyle.input-group-btn > label > span").html('IMPORT AGAIN');

	    	$("#save-btn-area").html('');
	    },
	    error: function(data){
	    	var errors = data.responseJSON;
	    	err = '';
	    	$.each(errors, function( index, value ) {
			  err = '<p>' + value + '</p>';
			});
	    	$('#status').html('<font color="red">'+err+'</font>');
	    }
	});
};

function upload_igc() {
	$.ajax({
	    type: 'POST',
	    url: 'tools/insert-igc',
	    data: $('.tbl_inc_id').serialize()+'&'+$('.tbl_group_class_id').serialize(),
	    dataType: 'json',
	    beforeSend: function(){
	    },
	    success: function(data){
	    	$('#uploaded_area').remove();
	    	$('#status').empty();
	        var percentVal = '0%';
	        $('.progress-bar').width(percentVal)
	        $('.percent').html(percentVal);

	        $("#file_upload").val('');
	        $("div.bootstrap-filestyle.input-group input").val('');

	        $('#status').html('<h4 class="text-primary"><u>'+data+'</u> rows of <u>INC Group Class</u> data has been imported successfully</h4>');
	    	
	    	$("span.group-span-filestyle.input-group-btn > label > span").html('IMPORT AGAIN');

	    	$("#save-btn-area").html('');
	    },
	    error: function(data){
	    	var errors = data.responseJSON;
	    	err = '';
	    	$.each(errors, function( index, value ) {
			  err = '<p>' + value + '</p>';
			});
	    	$('#status').html('<font color="red">'+err+'</font>');
	    }
	});
};

function upload_ic() {
	$.ajax({
	    type: 'POST',
	    url: 'tools/insert-ic',
	    data: $('.tbl_inc_id').serialize()+'&'+$('.tbl_characteristic_id').serialize()+'&'+$('.sequence').serialize(),
	    dataType: 'json',
	    beforeSend: function(){
	    },
	    success: function(data){
	    	$('#uploaded_area').remove();
	    	$('#status').empty();
	        var percentVal = '0%';
	        $('.progress-bar').width(percentVal)
	        $('.percent').html(percentVal);

	        $("#file_upload").val('');
	        $("div.bootstrap-filestyle.input-group input").val('');

	        $('#status').html('<h4 class="text-primary"><u>'+data+'</u> rows of <u>INC CHARACTERISTIC</u> data has been imported successfully</h4>');
	    	
	    	$("span.group-span-filestyle.input-group-btn > label > span").html('IMPORT AGAIN');

	    	$("#save-btn-area").html('');
	    },
	    error: function(data){
	    	var errors = data.responseJSON;
	    	err = '';
	    	$.each(errors, function( index, value ) {
			  err = '<p>' + value + '</p>';
			});
	    	$('#status').html('<font color="red">'+err+'</font>');
	    }
	});
};

function upload_icv() {
	$.ajax({
	    type: 'POST',
	    url: 'tools/insert-icv',
	    data: $('.link_inc_characteristic_id').serialize()+'&'+$('.value').serialize()+'&'+$('.abbrev').serialize()+'&'+$('.approved').serialize(),
	    dataType: 'json',
	    beforeSend: function(){
	    },
	    success: function(data){
	    	$('#uploaded_area').remove();
	    	$('#status').empty();
	        var percentVal = '0%';
	        $('.progress-bar').width(percentVal)
	        $('.percent').html(percentVal);

	        $("#file_upload").val('');
	        $("div.bootstrap-filestyle.input-group input").val('');

	        $('#status').html('<h4 class="text-primary"><u>'+data+'</u> rows of <u>INC CHARACTERISTIC VALUE</u> data has been imported successfully</h4>');
	    	
	    	$("span.group-span-filestyle.input-group-btn > label > span").html('IMPORT AGAIN');

	    	$("#save-btn-area").html('');
	    },
	    error: function(data){
	    	var errors = data.responseJSON;
	    	err = '';
	    	$.each(errors, function( index, value ) {
			  err = '<p>' + value + '</p>';
			});
	    	$('#status').html('<font color="red">'+err+'</font>');
	    }
	});
};

function upload_m() {
	$.ajax({
	    type: 'POST',
	    url: 'tools/insert-m',
	    data: $('.catalog_no').serialize()+'&'+$('.tbl_holding_id').serialize()+'&'+$('.holding_no').serialize()+'&'+$('.reference_no').serialize()+'&'+$('.link_inc_group_class_id').serialize()+'&'+$('.catalog_type').serialize()+'&'+$('.unit_issue').serialize()+'&'+$('.unit_purchase').serialize()+'&'+$('.tbl_catalog_status_id').serialize()+'&'+$('.conversion').serialize()+'&'+$('.tbl_user_class_id').serialize()+'&'+$('.tbl_item_type_id').serialize()+'&'+$('.tbl_harmonized_code_id').serialize()+'&'+$('.tbl_hazard_class_id').serialize()+'&'+$('.weight_value').serialize()+'&'+$('.tbl_weight_unit_id').serialize()+'&'+$('.tbl_stock_type_id').serialize()+'&'+$('.average_unit_price').serialize()+'&'+$('.memo').serialize(),
	    dataType: 'json',
	    beforeSend: function(){
	    },
	    success: function(data){
	    	$('#uploaded_area').remove();
	    	$('#status').empty();
	        var percentVal = '0%';
	        $('.progress-bar').width(percentVal)
	        $('.percent').html(percentVal);

	        $("#file_upload").val('');
	        $("div.bootstrap-filestyle.input-group input").val('');

	        $('#status').html('<h4 class="text-primary"><u>'+data+'</u> rows of <u>MASTER</u> data has been imported successfully</h4>');
	    	
	    	$("span.group-span-filestyle.input-group-btn > label > span").html('IMPORT AGAIN');

	    	$("#save-btn-area").html('');
	    },
	    error: function(data){
	    	var errors = data.responseJSON;
	    	err = '';
	    	$.each(errors, function( index, value ) {
				err = '<p>' + value + '</p>';
			});
	    	$('#status').html('<font color="red">'+err+'</font>');
	    }
	});
};