jQuery(function($) {
    // INSERT ELEMENT FOR HANDLEBARS
    $('<div id="navbar"></div><div id="content"></div>').insertAfter('#loading');
    // END INSERT ELEMENT FOR HANDLEBARS

    // HANDLEBARS TEMPLATE
    $('#navbar').html(Home.templates.home_navbar());
    $('#content').html(Home.templates.home_content());
    // END HANDLEBARS TEMPLATE

    // disable datatables error prompt
    $.fn.dataTable.ext.errMode = 'none';

    // GLOBAL SEARCH
    $(document).on('click', '#btn_search', function() {
        
        catalogNo = $('select#search_catalog_no').val();
        if(catalogNo){
            catalogNo = catalogNo;
        }else{
            catalogNo = 0;
        }

        holdingNo = $('select#search_holding_no').val();
        if(holdingNo){
            holdingNo = holdingNo.trim();
        }else{
            holdingNo = 0;
        }

        incId = $('select#search_inc_item_name').val();
        if(incId){
            incId = incId;
        }else{
            incId = 0;
        }

        colloquialId = $('select#search_colloquial_id').val();
        if(colloquialId){
            colloquialId = colloquialId.trim();
        }else{
            colloquialId = 0;
        }

        groupClassId = $('select#search_group_class').val();
        if(groupClassId){
            groupClassId = groupClassId;
        }else{
            groupClassId = 0;
        }

        catalogStatusId = $('select#search_catalog_status').val();
        if(catalogStatusId){
            catalogStatusId = catalogStatusId;
        }else{
            catalogStatusId = 0;
        }

        catalogType = $('select#search_catalog_type').val();
        if(catalogType){
            catalogType = hashids.encode(catalogType);
        }else{
            catalogType = 0;
        }

        itemTypeId = $('select#search_item_type').val();
        if(itemTypeId){
            itemTypeId = itemTypeId;
        }else{
            itemTypeId = 0;
        }

        manCodeId = $('select#search_manufacturer').val();
        if(manCodeId){
            manCodeId = manCodeId;
        }else{
            manCodeId = 0;
        }

        partNumber = $('select#search_part_number').val();
        if(partNumber){
            partNumber = partNumber.trim();
        }else{
            partNumber = 0;
        }

        equipmentCodeId = $('select#search_equipment').val();
        if(equipmentCodeId){
            equipmentCodeId = equipmentCodeId;
        }else{
            equipmentCodeId = 0;
        }

        holdingId = $('select#search_holding').val();
        if(holdingId){
            holdingId = holdingId;
        }else{
            holdingId = 0;
        }

        companyId = $('select#search_company').val();
        if(companyId){
            companyId = companyId;
        }else{
            companyId = 0;
        }

        plantId = $('select#search_plant').val();
        if(plantId){
            plantId = plantId;
        }else{
            plantId = 0;
        }

        locationId = $('select#search_location').val();
        if(locationId){
            locationId = locationId;
        }else{
            locationId = 0;
        }

        shelfId = $('select#search_shelf').val();
        if(shelfId){
            shelfId = shelfId;
        }else{
            shelfId = 0;
        }

        binId = $('select#search_bin').val();
        if(binId){
            binId = binId;
        }else{
            binId = 0;
        }

        var arr =   [
                        catalogNo,
                        holdingNo,
                        incId,
                        colloquialId,
                        groupClassId,
                        catalogStatusId,
                        catalogType,
                        itemTypeId,
                        manCodeId,          
                        partNumber,          
                        equipmentCodeId,               
                        holdingId,     
                        companyId,            
                        plantId,    
                        locationId,          
                        shelfId,       
                        binId,
                    ];

        $.ajax({
            url: 'search',
            type: 'POST',
            data: {
                    catalogNo:catalogNo,
                    holdingNo:holdingNo,
                    incId:incId,
                    colloquialId:colloquialId,
                    groupClassId:groupClassId,
                    catalogStatusId:catalogStatusId,
                    catalogType:catalogType,
                    itemTypeId:itemTypeId,
                    manCodeId:manCodeId,
                    partNumber:partNumber,
                    equipmentCodeId:equipmentCodeId,
                    holdingId:holdingId,
                    companyId:companyId,
                    plantId:plantId,
                    locationId:locationId,
                    shelfId:shelfId,
                    binId:binId
                },
            success: function(data) {
                if(data){
                    var newURL = window.location.protocol + "//" + window.location.host + "/?key=" + data;
                    history.pushState(null, null, newURL);
                    getCatalog();
                }                
            },
        });
        
    });

    $.urlParam = function(name){
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        return results[1] || 0;       
    }

    function getCatalog(){
        if (window.location.search.indexOf('key=') > -1) {
            key = $.urlParam('key');
            getCatalogDataTable(key);
            $('.container2').append('<input type="hidden" value="'+key+'" id="key">');
        }
    }

    // CLEAR ALL SELECTION
    $(document).on('click', '#btn_clear', function() {
        $('div.bootstrap-select select[id^=search]').val([]);
        $('div.bootstrap-select select[id^=search]').trigger('change.abs.preserveSelected');
        $('div.bootstrap-select select[id^=search]').selectpicker('refresh');
        $('div.bootstrap-select select[id^=search]').trigger("click");
        $('div.bootstrap-select button').removeAttr('style');
    });
    // END CLEAR ALL SELECTION

    // RIGHT CLICK SELECT SEARCH
    new BootstrapMenu('button[data-id="search_catalog_no"]', {
        actions: [{
            name: 'CLEAR SELECTION',
            onClick: function() {
                $('#search_catalog_no').val([]);
                $('#search_catalog_no').trigger('change.abs.preserveSelected');
                $('#search_catalog_no').selectpicker('refresh');
                $('#search_catalog_no').trigger("click");
                $('button[data-id="search_catalog_no"]').removeAttr('style');
            }
        }]
    });

    new BootstrapMenu('button[data-id="search_holding_no"]', {
        actions: [{
            name: 'CLEAR SELECTION',
            onClick: function() {
                $('#search_holding_no').val([]);
                $('#search_holding_no').trigger('change.abs.preserveSelected');
                $('#search_holding_no').selectpicker('refresh');
                $('#search_holding_no').trigger("click");
                $('button[data-id="search_holding_no"]').removeAttr('style');
            }
        }]
    });

    new BootstrapMenu('button[data-id="search_inc_item_name"]', {
        actions: [{
            name: 'CLEAR SELECTION',
            onClick: function() {
                $('#search_inc_item_name').val([]);
                $('#search_inc_item_name').trigger('change.abs.preserveSelected');
                $('#search_inc_item_name').selectpicker('refresh');
                $('#search_inc_item_name').trigger("click");
                $('button[data-id="search_inc_item_name"]').removeAttr('style');
            }
        }]
    });

    new BootstrapMenu('button[data-id="search_colloquial_id"]', {
        actions: [{
            name: 'CLEAR SELECTION',
            onClick: function() {
                $('#search_colloquial_id').val([]);
                $('#search_colloquial_id').trigger('change.abs.preserveSelected');
                $('#search_colloquial_id').selectpicker('refresh');
                $('#search_colloquial_id').trigger("click");
                $('button[data-id="search_colloquial_id"]').removeAttr('style');
            }
        }]
    });

    new BootstrapMenu('button[data-id="search_group_class"]', {
        actions: [{
            name: 'CLEAR SELECTION',
            onClick: function() {
                $('#search_group_class').val([]);
                $('#search_group_class').trigger('change.abs.preserveSelected');
                $('#search_group_class').selectpicker('refresh');
                $('#search_group_class').trigger("click");
                $('button[data-id="search_group_class"]').removeAttr('style');
            }
        }]
    });

    new BootstrapMenu('button[data-id="search_catalog_status"]', {
        actions: [{
            name: 'CLEAR SELECTION',
            onClick: function() {
                $('#search_catalog_status').val([]);
                $('#search_catalog_status').trigger('change.abs.preserveSelected');
                $('#search_catalog_status').selectpicker('refresh');
                $('#search_catalog_status').trigger("click");
                $('button[data-id="search_catalog_status"]').removeAttr('style');
            }
        }]
    });

    new BootstrapMenu('button[data-id="search_catalog_type"]', {
        actions: [{
            name: 'CLEAR SELECTION',
            onClick: function() {
                $('#search_catalog_type').val([]);
                $('#search_catalog_type').trigger('change.abs.preserveSelected');
                $('#search_catalog_type').selectpicker('refresh');
                $('#search_catalog_type').trigger("click");
                $('button[data-id="search_catalog_type"]').removeAttr('style');
            }
        }]
    });

    new BootstrapMenu('button[data-id="search_item_type"]', {
        actions: [{
            name: 'CLEAR SELECTION',
            onClick: function() {
                $('#search_item_type').val([]);
                $('#search_item_type').trigger('change.abs.preserveSelected');
                $('#search_item_type').selectpicker('refresh');
                $('#search_item_type').trigger("click");
                $('button[data-id="search_item_type"]').removeAttr('style');
            }
        }]
    });

    new BootstrapMenu('button[data-id="search_manufacturer"]', {
        actions: [{
            name: 'CLEAR SELECTION',
            onClick: function() {
                $('#search_manufacturer').val([]);
                $('#search_manufacturer').trigger('change.abs.preserveSelected');
                $('#search_manufacturer').selectpicker('refresh');
                $('#search_manufacturer').trigger("click");
                $('button[data-id="search_manufacturer"]').removeAttr('style');
            }
        }]
    });

    new BootstrapMenu('button[data-id="search_part_number"]', {
        actions: [{
            name: 'CLEAR SELECTION',
            onClick: function() {
                $('#search_part_number').val([]);
                $('#search_part_number').trigger('change.abs.preserveSelected');
                $('#search_part_number').selectpicker('refresh');
                $('#search_part_number').trigger("click");
                $('button[data-id="search_part_number"]').removeAttr('style');
            }
        }]
    });

    new BootstrapMenu('button[data-id="search_equipment"]', {
        actions: [{
            name: 'CLEAR SELECTION',
            onClick: function() {
                $('#search_equipment').val([]);
                $('#search_equipment').trigger('change.abs.preserveSelected');
                $('#search_equipment').selectpicker('refresh');
                $('#search_equipment').trigger("click");
                $('button[data-id="search_equipment"]').removeAttr('style');
            }
        }]
    });

    new BootstrapMenu('button[data-id="search_holding"]', {
        actions: [{
            name: 'CLEAR SELECTION',
            onClick: function() {
                $('#search_holding').val([]);
                $('#search_holding').trigger('change.abs.preserveSelected');
                $('#search_holding').selectpicker('refresh');
                $('#search_holding').trigger("click");
                $('button[data-id="search_holding"]').removeAttr('style');
            }
        }]
    });

    new BootstrapMenu('button[data-id="search_company"]', {
        actions: [{
            name: 'CLEAR SELECTION',
            onClick: function() {
                $('#search_company').val([]);
                $('#search_company').trigger('change.abs.preserveSelected');
                $('#search_company').selectpicker('refresh');
                $('#search_company').trigger("click");
                $('button[data-id="search_company"]').removeAttr('style');
            }
        }]
    });

    new BootstrapMenu('button[data-id="search_plant"]', {
        actions: [{
            name: 'CLEAR SELECTION',
            onClick: function() {
                $('#search_plant').val([]);
                $('#search_plant').trigger('change.abs.preserveSelected');
                $('#search_plant').selectpicker('refresh');
                $('#search_plant').trigger("click");
                $('button[data-id="search_plant"]').removeAttr('style');
            }
        }]
    });

    new BootstrapMenu('button[data-id="search_location"]', {
        actions: [{
            name: 'CLEAR SELECTION',
            onClick: function() {
                $('#search_location').val([]);
                $('#search_location').trigger('change.abs.preserveSelected');
                $('#search_location').selectpicker('refresh');
                $('#search_location').trigger("click");
                $('button[data-id="search_location"]').removeAttr('style');
            }
        }]
    });

    new BootstrapMenu('button[data-id="search_shelf"]', {
        actions: [{
            name: 'CLEAR SELECTION',
            onClick: function() {
                $('#search_shelf').val([]);
                $('#search_shelf').trigger('change.abs.preserveSelected');
                $('#search_shelf').selectpicker('refresh');
                $('#search_shelf').trigger("click");
                $('button[data-id="search_shelf"]').removeAttr('style');
            }
        }]
    });

    new BootstrapMenu('button[data-id="search_bin"]', {
        actions: [{
            name: 'CLEAR SELECTION',
            onClick: function() {
                $('#search_bin').val([]);
                $('#search_bin').trigger('change.abs.preserveSelected');
                $('#search_bin').selectpicker('refresh');
                $('#search_bin').trigger("click");
                $('button[data-id="search_bin"]').removeAttr('style');
            }
        }]
    });
    // END RIGHT CLICK SELECT SEARCH
    getCatalog();
    // END GLOBAL SEARCH

    // PART MASTER
    function getCatalogDataTable(key){
        $('#part_master').DataTable({
            destroy: true,
            processing: false,
            serverSide: true,
            ajax: 'home/part-master/'+key,
            columns: [{
                data: 'catalog_no',
                name: 'catalog_no'
            }, {
                data: 'holding_no',
                name: 'holding_no'
            }, {
                data: 'company',
                name: 'company'
            }, {
                data: 'inc',
                name: 'tbl_inc.inc'
            }, {
                data: 'item_name',
                name: 'tbl_inc.item_name'
            }, {
                data: 'group_class',
                name: 'tbl_group_class.group_class'
            }, {
                data: 'unit_issue',
                name: 'unit_issue'
            }, {
                data: 'catalog_type',
                name: 'catalog_type'
            }, {
                data: 'status',
                name: 'tbl_catalog_status.status'
            }, ],
            oLanguage: {
                sLengthMenu: "_MENU_",
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
            pageLength: 4,
            dom: "Z<'row'<'col-sm-12'tr>>" +
                "<'row'i<'col-sm-3'p>>",

            drawCallback: function() {
                $("#part_master tbody tr:first-child").addClass('active');
                $("#part_master tbody tr").on('click', function(event) {
                    $("#part_master tbody tr:first-child").removeClass('active');
                    $("#part_master tbody tr").removeClass('active');
                    $(this).addClass('active');
                });
                var api = this.api();
                var firstRow = api.rows().data()[0];
                if (typeof firstRow != "undefined") {
                    var part_master_id = firstRow['part_master_id'];
                    var company_id = firstRow['tbl_company_id'];
                    var inc_group_class_id = firstRow['link_inc_group_class_id'];
                }
                if(part_master_id && company_id && inc_group_class_id){
                    get_part_equipment_code(part_master_id,company_id);
                    get_part_manufacturer_code(part_master_id);
                    get_part_characteristic_value(inc_group_class_id);
                    catalog_tag(part_master_id)
                    getSelectedInfo();
                }
                var info = api.page.info();
                recordsTotal = info.recordsTotal;

                if(key == 0){
                    $('#search_result').css('display', 'none');
                    $('#search_form').css('display', 'block');
                }else if(recordsTotal == '0'){
                    $('#search_result').css('display', 'none');
                    $('#search_form').css('display', 'block');
                    notif = '<span class="pull-right text-danger">No match Catalog for your criteria. :(</span>';
                    $('#search_notif').html(notif);
                }else{
                    $('#search_result').css('display', 'block');
                    $('#search_form').css('display', 'none');
                    menu  = '<li class="dropdown"><a class="pointer" href="/" target="_blank">SEARCH</a></li>';
                    menu += '<li class="dropdown"><a class="pointer" target="_blank">HISTORY</a></li>';
                }

                var index   = 3;
                var ke      = 1 + index; // 4
                var hal     = Math.ceil(ke / 5);
                console.log(hal +' apa hayooo..');
            },
        });
        
        $('#part_master_info').addClass('col-sm-9');
        clickPartMasterRow();
    }

    // WHEN CLICK CLASSFICATION TAB
    $(document).one('click', '#class_tab_link', function() {
        var part_master_id = $("#part_master tbody tr.active").attr("id");
        get_classification(part_master_id);
        get_part_colloquial(part_master_id);
    });

    // WHEN CLICK EQUIPMENT TAB
    $(document).one('click', '#eq_tab_link', function() {
        var part_master_id = $("#part_master tbody tr.active").attr("id");
        var company_id = $("#part_master tbody tr.active .company").val();
        get_part_equipment_code(part_master_id,company_id);
    });

    // WHEN CLICK EQUIPMENT TAB
    $(document).one('click', '#atc_tab_link', function() {
        var part_master_id = $("#part_master tbody tr.active").attr("id");
        var company_id = $("#part_master tbody tr.active .company").val();
        get_part_attachment(part_master_id);
    });

    function getSelectedInfo(){
        catalog_no = $("table#part_master tr.active td:eq(0)").text();
        company = $("table#part_master tr.active td:eq(2)").text();
        inc = $("table#part_master tr.active td:eq(3)").text();
        item_name = $("table#part_master tr.active td:eq(4)").text();
        unit_issue = $("table#part_master tr.active td:eq(6)").text();
        catalog_type = $("table#part_master tr.active td:eq(7)").text();
        
        var selected_info = catalog_no + '/ ' + company + ' /  ' + inc + '  :  ' + item_name + '  /  ' + unit_issue + '  /  ' + catalog_type;
        $('#selected_catalog_info').val(selected_info);
    }

    // WHEN CLICK ROW PART MASTER
    function clickPartMasterRow(){
        $("#part_master tbody").delegate("tr", "click", function() {
            var part_master_id = $(this).attr('id').trim();
            var company_id = $(this).find("input.company").val().trim();
            var inc_group_class_id = $(this).find("input.inc_group_class_id").val().trim();

            get_part_manufacturer_code(part_master_id);
            get_part_colloquial(part_master_id);
            get_part_equipment_code(part_master_id,company_id);
            get_classification(part_master_id);
            catalog_tag(part_master_id);
            get_source();
            get_part_attachment(part_master_id);
            getSelectedInfo();
            get_part_characteristic_value(inc_group_class_id);
        });
    }

    // SHOW SOURCE DESC
    $(document).on('click', '#show_source', function() {
        var requestCallback = new MyRequestsCompleted({
            numRequest: 2,
            singleCallback: function() {
                $('#source_modal').modal({ backdrop: 'static', keyboard: false});
                $('.modal').css('pointer-events', 'none');
                $('.modal-backdrop').css('display', 'none');
                $('.modal-content').css('pointer-events', 'all');
                catalog_no = $("table#part_master tr.active td:eq(0)").text();
                $('#source_modal #source_modal_title').text("SOURCE FOR CATALOG NO : " + catalog_no);
                $('#source_modal').modal('show');
            }
        });

        $.ajax({
            type: 'GET',
            url: 'home/part-source-description/' + $("#part_master tbody tr.active").attr("id"),
            dataType: 'json',
            success: function(data) {
                source_meta = '<table>';

                if (data.inc.length > 0) {
                    source_meta += '<tr><td width="25%">INC</td><td>: ' + data.inc + '</td></tr>';
                }

                if (data.item_name.length > 0) {
                    source_meta += '<tr><td width="25%">ITEM NAME</td><td>: ' + data.item_name + '</td></tr>';
                }

                if (data.group_class.length > 0) {
                    source_meta += '<tr><td width="25%">GROUP CLASS</td><td>: ' + data.group_class + '</td></tr>';
                }

                if (data.unit_issue.length > 0) {
                    source_meta += '<tr><td width="25%">UOM</td><td>: ' + data.unit_issue + '</td></tr>';
                }
                source_meta += '</table>';

                if (data.inc.length > 0 || data.item_name.length > 0 || data.group_class.length > 0 || data.unit_issue.length > 0) {
                    $('#source_modal .modal-body #hr').html("<hr>");
                } else {
                    $('#source_modal .modal-body #hr').html("");
                }

                $('#source_modal .modal-body #source_meta').html(source_meta);
                $('#source_modal .modal-body #source_desc').text(data.source);

                requestCallback.requestComplete(true);
            },
            error: function(){
                $('#source_modal .modal-body #source_meta').html('Whoops, No source available<br>');
                $('#source_modal .modal-body #source_desc').text('Please import source for this catalog');
                requestCallback.requestComplete(true);
            }
        });

        $.ajax({
            type: 'GET',
            url: 'home/part-source-part-number/' + $("#part_master tbody tr.active").attr("id"),
            dataType: 'json',
            success: function(data) {
                if (data.length > 0) {
                    part_source = '<table class="table table-striped">';
                    part_source += '<tr><th>MANCODE</th><th>MANUFACTURER</th><th>MANREF</th></tr>';
                    $.each(data, function(i, item) {
                        part_source += '<tr><td>' + item.manufacturer_code + '</td><td>' + item.manufacturer + '</td><td>' + item.manufacturer_ref + '</td></tr>';
                    });
                    part_source += '<table class="table table-striped">';

                    $('#source_modal .modal-body #part_source').empty().append(part_source);
                } else {
                    $('#source_modal .modal-body #part_source').empty();
                }

                requestCallback.requestComplete(true);
            },
            error: function(){
                $('#source_modal .modal-body #part_source').empty();
                requestCallback.requestComplete(true);
            }
        });
    });
    // END SHOW SOURCE DESC

    // GET SOURCE
    function get_source(){
        catalog_no = $("table#part_master tr.active td:eq(0)").text();
        $.ajax({
            type: 'GET',
            url: 'home/part-source-description/' + $("#part_master tbody tr.active").attr("id"),
            dataType: 'json',
            success: function(data) {
                $('#source_modal #source_modal_title').text("SOURCE FOR CATALOG NO : " + catalog_no);
                source_meta = '<table>';

                if (data.inc.length > 0) {
                    source_meta += '<tr><td width="25%">INC</td><td>: ' + data.inc + '</td></tr>';
                }

                if (data.item_name.length > 0) {
                    source_meta += '<tr><td width="25%">ITEM NAME</td><td>: ' + data.item_name + '</td></tr>';
                }

                if (data.group_class.length > 0) {
                    source_meta += '<tr><td width="25%">GROUP CLASS</td><td>: ' + data.group_class + '</td></tr>';
                }

                if (data.unit_issue.length > 0) {
                    source_meta += '<tr><td width="25%">UOM</td><td>: ' + data.unit_issue + '</td></tr>';
                }
                source_meta += '</table>';

                if (data.inc.length > 0 || data.item_name.length > 0 || data.group_class.length > 0 || data.unit_issue.length > 0) {
                    $('#source_modal .modal-body #hr').html("<hr>");
                } else {
                    $('#source_modal .modal-body #hr').html("");
                }

                $('#source_modal .modal-body #source_meta').html(source_meta);
                $('#source_modal .modal-body #source_desc').text(data.source);
            },
            error: function(){
                $('#source_modal #source_modal_title').text("SOURCE FOR CATALOG NO : " + catalog_no);
                $('#source_modal .modal-body #source_meta').html('Whoops, No source available<br>');
                $('#source_modal .modal-body #source_desc').text('Please import source for this catalog');
            }
        });

        $.ajax({
            type: 'GET',
            url: 'home/part-source-part-number/' + $("#part_master tbody tr.active").attr("id"),
            dataType: 'json',
            success: function(data) {
                if (data.length > 0) {
                    part_source = '<table class="table table-striped">';
                    part_source += '<tr><th>MANCODE</th><th>MANUFACTURER</th><th>MANREF</th></tr>';
                    $.each(data, function(i, item) {
                        part_source += '<tr><td>' + item.manufacturer_code + '</td><td>' + item.manufacturer + '</td><td>' + item.manufacturer_ref + '</td></tr>';
                    });
                    part_source += '<table class="table table-striped">';

                    $('#source_modal .modal-body #part_source').empty().append(part_source);
                } else {
                    $('#source_modal .modal-body #part_source').empty();
                }
            },
            error: function(){
                $('#source_modal .modal-body #part_source').empty();
            }
        });
    }
    // END GET SOURCE DESC

    // MODAL DRAGGABLE - for source description
    $('.modal.draggable>.modal-dialog').draggable({
        cursor: 'move',
        handle: '.modal-header'
    });
    $('.modal.draggable>.modal-dialog>.modal-content>.modal-header').css('cursor', 'move');
    // END MODAL DRAGGABLE

    // REPORT MODAL
    $(document).on('click', '#create_report', function() {
        $('#report_modal').modal('show');
        $('#report_warn').empty();
        // $('.modal-backdrop').remove();
    });
    // END REPORT MODAL

    // GET PART CHARACTERISTIC VALUE
    function get_part_characteristic_value(inc_group_class_id) {

        $.ajax({
            url: 'home/inc-group-class/' + inc_group_class_id,
            type: 'GET',
            beforeSend: function() {

            },
            success: function(data) {

                // INC ON CHARACTERISTIC VALUE
                var optInc = '<option value="' + data.inc_id + '" selected="selected">' + data.inc + ' : ' + data.item_name + '</option>';
                $("#inc").empty().append(optInc);

                $("#text_inc").val(data.item_name);
                $("#text_inc").attr("title", data.item_name);

                var optionsINC = {
                    ajax: {
                        url: 'home/select-inc',
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'SELECT INC - ITEM NAME',
                        searchPlaceholder: 'SEARCH INC OR ITEM NAME'
                    },
                    preprocessData: function(data) {
                        var i, l = data.length,
                            array = [];
                        if (l) {
                            for (i = 0; i < l; i++) {
                                array.push($.extend(true, data[i], {
                                    text: data[i].inc + ' : ' + data[i].item_name,
                                    value: data[i].tbl_inc_id,
                                }));
                            }
                        }
                        return array;
                    }
                };

                $('.inc').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsINC);
                $('.inc').trigger('change');
                $('button[data-id="inc"]').addClass("btn-sm");
                $('.bs-searchbox > input.form-control').addClass("input-sm");

                console.log("Belum di cek, jangan liat kesini ah, malu :P");

                // GROUP CLASS ON CHARACTERISTIC VALUE
                $.ajax({
                    url: 'home/group-class/' + data.inc_id,
                    type: 'GET',
                    beforeSend: function() {

                    },
                    success: function(groupClassData) {
                        opt = '';
                        $.each(groupClassData, function(i, item) {
                            if (item.group_class_id != data.group_class_id) {
                                opt += '<option value="' + item.group_class_id + '">' + item.group_class + ' : ' + item.name + '</option>';
                            } else {
                                opt += '<option value="' + item.group_class_id + '" selected="selected">' + item.group_class + ' : ' + item.name + '</option>';

                                $("#text_group_class").val(item.name);
                                $("#text_group_class").attr("title", item.name);
                            }
                        });
                        $("#group_class").empty().append(opt);

                        $('.group-class').selectpicker('refresh');
                        $('button[data-id="group_class"]').addClass("btn-sm");
                        $('.bs-searchbox > input.form-control').addClass("input-sm");

                    },
                    error: function() {
                        $("#group_class").empty();
                        $('.group-class').selectpicker('refresh');
                        $('button[data-id="group_class"]').addClass("btn-sm");
                        $('.bs-searchbox > input.form-control').addClass("input-sm");
                        alert("Error while getting Group Class.");
                    }
                });

                // CHARACTERISTIC VALUE AND PART CHARACTERISTIC VALUE
                part_characteristic_value_box();

            },
            error: function() {
                $("#inc").empty()
                $('.inc').selectpicker('refresh');
                $('button[data-id="inc"]').addClass("btn-sm");

                $("#group_class").empty();
                $('.group-class').selectpicker('refresh');
                $('button[data-id="group_class"]').addClass("btn-sm");

                $('.bs-searchbox > input.form-control').addClass("input-sm");

                $("#characteristic_value_box").empty()
                alert("Error while getting INC - Group Class");
            }
        });

    }
    // END GET PART CHARACTERISTIC VALUE

    // TAB
    $("#mainTab a").click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
    // END TAB

    // SHORT DESCRIPTION RESULT
    function get_short_description_result() {
        part_master_id = $("#part_master tbody tr.active").attr("id");
        // company_id = $("#company").val();
        company_id = $("#part_master tbody tr.active input.company").val();

        $.ajax({
            url: 'home/short-description/' + part_master_id + '/' + company_id,
            type: 'GET',
            success: function(data) {
                $('#short_desc').val(data);
                $('#short_desc').prop('title', 'CHARACTER COUNT: '+data.length);
            },
            error: function() {
               $('#short_desc').val('ERROR');
               $('#short_desc').prop('title', 'ERROR');
            }
        });
    }
    // END SHORT DESCRIPTION RESULT

    // PART CHARACTERISTIC VALUE BOX
    function part_characteristic_value_box() {
        var inc_id = $("#inc").val();
        var part_master_id = $("#part_master tbody tr.active").attr("id");
        var company_id = $("#part_master tbody tr.active input.company").val();
        var catalog_status_id = $("#part_master tbody tr.active input.catalog_status_id").val();

        if(inc_id && part_master_id && company_id && catalog_status_id){

            $.ajax({
                url: 'home/characteristic-value/' + inc_id + '/' + part_master_id + '/' + company_id,
                type: 'GET',
                beforeSend: function() {},
                success: function(data) {
                    if (data == 0) {

                        emptyMsg = "<td colspan='4' style='padding-top:30px;'><center><i class='fa fa-building' style='font-size:130px;color:#ccc;'></i></center><td colspan='4'><center>NO DATA</center></td></td>";
                        $("#characteristic_value_box").empty().append(emptyMsg);

                        var optionsSelectAddCompany = {
                            ajax: {
                                url: 'home/select-add-company/' + part_master_id,
                                type: 'POST',
                                dataType: 'json',
                            },
                            locale: {
                                emptyTitle: 'SELECT COMPANY',
                            },
                            preprocessData: function(data) {
                                var i, l = data.length,
                                    array = [];
                                if (l) {
                                    for (i = 0; i < l; i++) {
                                        array.push($.extend(true, data[i], {
                                            text: data[i].company,
                                            value: data[i].id,
                                        }));
                                    }
                                }
                                return array;
                            }
                        };

                        $('.select_add_company').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsSelectAddCompany);

                        $('.select_add_company').trigger('change');
                        $('button[data-id="select_add_company"]').addClass("btn-sm");

                        catalog_no = $("table#part_master tr.active td:eq(0)").text();
                        holding = $("table#part_master tr.active td:eq(1)").text();
                        item_name = $("table#part_master tr.active td:eq(3)").text();

                        $('#item_info').text(catalog_no + ' / ' + holding + ' / ' + item_name);
                        $('#add_company_modal').modal('show');

                    } else if (data == 1) {

                        emptyMsg = "<td colspan='4' style='padding-top:30px;'><center><i class='fa fa-exclamation-circle' style='font-size:130px;color:#ccc;'></i></center><td colspan='4'><center>no characteristic available for this INC</center></td></td>";
                        $("#characteristic_value_box").empty().append(emptyMsg);

                    } else {

                        len = [];
                        $.each(data, function(i, item) {
                            if (item.value != '') {
                                len.push(item.characteristic.length);
                            }
                        });

                        max_char_len = Math.max.apply(null,len);
                        po_charval = '';
                        charval = '';
                        index = 0;
                        $.each(data, function(i, item) {
                            if (item.value != '') {
                                if(item.approved != 1) {
                                    bg = 'rgba(255, 255, 0, 0.5)';
                                }else{
                                    bg = '';
                                }
                                // UPDATE VALUE
                                charval += '<tr id="update_id'+index+'" style="background-color: '+bg+';">';
                                charval += '<td>' + item.characteristic;
                                charval += '<input type="hidden" value="' + item.characteristic + '" name="char_name' + item.link_inc_characteristic_id + '">';
                                charval += '<input type="hidden" value="' + item.link_inc_characteristic_id + '" class="update_inc_char_id" name="update_inc_char_id[' + index + ']">';
                                charval += '<input type="hidden" value="' + item.char_id + '" class="update_char_id" name="update_char_id[' + index + ']"></td>';
                                charval += '<td>';
                                charval += '<input class="characteristic_value_cell update_value get-values-list state change-char-value" type="text" id="update_value' + index + '" data-change="update_value' + index + '" name="update_value[' + index + ']" state="0" data-inc-char-id="' + item.link_inc_characteristic_id + '" data-char-id="' + item.char_id + '" data-index="' + index + '" data-action="update" value="' + item.value + '">';
                                charval += '<input type="hidden" value="' + item.part_characteristic_value_id + '" class="update_part_char_value_id" name="update_part_char_value_id[' + index + ']"></td>';
                                charval += '</td>';
                                // if(item.approved == 1) {
                                //     abbrev = item.abbrev;
                                // }else{
                                //     abbrev = '';
                                // }
                                charval += '<td><input type="text" title="' + item.abbrev + '" class="characteristic_value_cell" id="update_abbrev' + index + '" value="' + item.abbrev + '" disabled></td>';

                                if (item.short != 1) {
                                    charval += '<td><input type="checkbox" class="pull-right update_short cstate change-char-value" name="update_short[' + index + ']" value="1" cstate="0" id="update_short' + index + '" data-change="update_short' + index + '"></td>';
                                } else {
                                    charval += '<td><input type="checkbox" class="pull-right update_short cstate change-char-value" name="update_short[' + index + ']" value="1" cstate="0" id="update_short' + index + '" data-change="update_short' + index + '" checked></td>';
                                }

                                // PO TEXT
                                space_count  = max_char_len - item.characteristic.length + 1;
                                spasi        = ' '.repeat(space_count)+': ';
                                po_charval  += item.characteristic+spasi+item.value+'<br>';
                                // END PO TEXT

                            } else {
                                // INSERT VALUE
                                charval += '<tr id="insert_id'+index+'">';
                                charval += '<td>' + item.characteristic;

                                charval += '<input type="hidden" value="' + item.characteristic + '" name="char_name' + item.link_inc_characteristic_id + '">';

                                charval += '<input type="hidden" value="' + item.link_inc_characteristic_id + '" class="insert_inc_char_id" name="insert_inc_char_id[' + index + ']">';

                                charval += '<input type="hidden" value="' + item.char_id + '" class="insert_char_id" name="insert_char_id[' + index + ']"></td>';

                                charval += '<td>';

                                charval += '<input class="characteristic_value_cell insert_value state get-values-list state change-char-value" type="text" id="insert_value' + index + '" data-change="insert_value' + index + '" name="insert_value[' + index + ']" state="0" data-inc-char-id="' + item.link_inc_characteristic_id + '" data-char-id="' + item.char_id + '" data-index="' + index + '" data-action="insert" value="">';

                                charval += '</td>';

                                charval += '<td><input type="text" class="characteristic_value_cell" id="insert_abbrev' + index + '" disabled></td>';

                                if (item.short != 1) {
                                    charval += '<td><input type="checkbox" class="pull-right insert_short cstate change-char-value" name="insert_short[' + index + ']" value="1" cstate="0" id="insert_short' + index + '" data-change="insert_short' + index + '"></td>';
                                } else {
                                    charval += '<td><input type="checkbox" class="pull-right insert_short cstate change-char-value" name="insert_short[' + index + ']" value="1" cstate="0" id="insert_short' + index + '" data-change="insert_short' + index + '" checked></td>';
                                }
                            }

                            charval += '</tr>';
                            index++;
                        });
                        $("#characteristic_value_box").empty().append(charval);

                        // SHORT DESCRIPTION
                        get_short_description_result();

                        // PO TEXT
                        $("#po_text").empty().append(po_charval);
                        
                        // TYPEAHEAD
                        // ini pake typeahead yg udah di edit
                        // dari https://github.com/bassjobsen/Bootstrap-3-Typeahead/commit/eaa459e2f76bca720b38c46f1c481bf86540d6b0
                        indexT = 0;
                        $.each(data, function(i, item) {
                            if (item.value != '') {
                                values = [];
                                $.each(item.values, function(i, item) {
                                    values.push(item.value);
                                });
                                
                                $('input#update_value' + indexT).typeahead({ 
                                    source: values,
                                    minLength: 0,
                                    showHintOnFocus: 'all',
                                    fitToElement: true,
                                    autoSelect: false,
                                });
                            }else{
                                values = [];
                                $.each(item.values, function(i, item) {
                                    values.push(item.value);
                                });
                                
                                $('input#insert_value' + indexT).typeahead({ 
                                    source: values,
                                    minLength: 0,
                                    showHintOnFocus: 'all',
                                    fitToElement: true,
                                    autoSelect: false,
                                });
                            }
                            indexT++;
                        });
                        // END TYPEAHEAD

                        // VALUE LIST MODAL
                        ind = 0;
                        body = '';
                        $.each(data, function(i, item) {
                            if (item.value != '') {
                                action = 'update';
                            }else{
                                action = 'insert';
                            }
                            valueData = '';
                            $.each(item.values, function(i_, item_) {
                                if(item_.approved != 1){
                                    bg = 'rgba(255, 255, 0, .5);';
                                }else{
                                    bg = '';
                                }
                                valueData += '<tr style="background-color: '+bg+'" data-bg="'+bg+'" class="pick-value" data-link-inc-char-val-id="' + item_.link_inc_characteristic_value_id + '" data-value="' + item_.value + '" data-abbrev="' + item_.abbrev + '" data-action="'+action+'">';
                                valueData += '<td>' + item_.value + '</td>';
                                valueData += '<td>' + item_.abbrev + '</td>';
                                valueData += '</tr>';
                            });
                            body += '<span id="body_'+ind+'"><table><tbody>'+valueData+'</tbody></table></span>';
                            ind++;
                        });
                        $("#values_list_modal_content").html(body);
                        // END VALUE LIST MODAL
                    }
                },
                error: function() {
                    $("#characteristic_value_box").empty()
                    alert("Error while getting Characteristic Value");
                }
            }).done(get_catalog_status(catalog_status_id));

        }else{
            emptyMsg = "<td colspan='4' style='padding-top:30px;'><center><i class='fa fa-building' style='font-size:130px;color:#ccc;'></i></center><td colspan='4'><center>NO DATA</center></td></td>";
            $("#characteristic_value_box").empty().append(emptyMsg);

            var optionsSelectAddCompany = {
                ajax: {
                    url: 'home/select-add-company/' + part_master_id,
                    type: 'POST',
                    dataType: 'json',
                },
                locale: {
                    emptyTitle: 'SELECT COMPANY',
                },
                preprocessData: function(data) {
                    var i, l = data.length,
                        array = [];
                    if (l) {
                        for (i = 0; i < l; i++) {
                            array.push($.extend(true, data[i], {
                                text: data[i].company,
                                value: data[i].id,
                            }));
                        }
                    }
                    return array;
                }
            };

            $('.select_add_company').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsSelectAddCompany);

            $('.select_add_company').trigger('change');
            $('button[data-id="select_add_company"]').addClass("btn-sm");

            catalog_no = $("table#part_master tr.active td:eq(0)").text();
            holding = $("table#part_master tr.active td:eq(1)").text();
            item_name = $("table#part_master tr.active td:eq(3)").text();

            $('#item_info').text(catalog_no + ' / ' + holding + ' / ' + item_name);
            $('#add_company_modal').modal('show');
        }

        
    }
    // END PART CHARACTERISTIC VALUE BOX

    // INC ON CHANGED
    $('#inc').on('changed.bs.select', function(e) {
        var bismillah = $("#inc optgroup option").attr("data-subtext");
        $("#text_inc").val(bismillah);
        $("#text_inc").attr("title", bismillah);

        inc_id = $(this).val();
        part_characteristic_value_box();

        $.ajax({
            url: 'home/group-class/' + inc_id,
            type: 'GET',
            beforeSend: function() {

                $("#group_class").empty();
                $('#group_class').selectpicker('render');
                $('#group_class').selectpicker('refresh');
                $('#group_class').val('');
                $('button[data-id="group_class"]').prop("disabled", true);
                $('button[data-id="group_class"]').attr("title", "PLEASE WAIT...");
                $('button[data-id="group_class"] > span.filter-option').text("PLEASE WAIT...");
                $("#text_group_class").val('PLEASE WAIT...');
                $("#text_group_class").attr("title", 'PLEASE WAIT...');
                $('#select_group_class_box').removeClass("has-error");
                $('#select_group_class_box > p').removeClass("text-danger");

            },
            success: function(data) {

                opt = '';
                $.each(data, function(i, item) {
                    opt += '<option value="' + item.group_class_id + '">' + item.group_class + ' : ' + item.name + '</option>';
                    $("#text_group_class").val(item.name);
                    $("#text_group_class").attr("title", item.name);
                });

                $("#group_class").empty().append(opt);
                $('#group_class').selectpicker('render');
                $('#group_class').selectpicker('refresh');

                $('#group_class').val('');
                $("#text_group_class").val('');
                $("#text_group_class").attr("title", '');

                $('button[data-id="group_class"]').addClass("btn-sm");
                $('button[data-id="group_class"]').attr("title", "SELECT GROUP CLASS - NAME");
                $('button[data-id="group_class"] > span.filter-option').text("SELECT GROUP CLASS - NAME");
                $('button[data-id="group_class"]').prop("disabled", false);
                $('.bs-searchbox > input.form-control').addClass("input-sm");
                $('#select_group_class_box').addClass("has-error");
                $('#select_group_class_box > p').addClass("text-danger");
                $('li[data-original-index="0"]').removeClass("selected");
                $('li[data-original-index="0"]').removeClass("active");

            },
            error: function() {

                $("#group_class").empty();
                $('#group_class').selectpicker('render');
                $('#group_class').selectpicker('refresh');
                $('#group_class').val('');
                $('button[data-id="group_class"]').prop("disabled", true);
                $('button[data-id="group_class"]').attr("title", "PLEASE WAIT...");
                $('button[data-id="group_class"] > span.filter-option').text("PLEASE WAIT...");
                $("#text_group_class").val('PLEASE WAIT...');
                $("#text_group_class").attr("title", 'PLEASE WAIT...');
                $('#select_group_class_box').removeClass("has-error");
                $('#select_group_class_box > p').removeClass("text-danger");

                alert("Whoops, something went wrong while getting Group Class... I am so sorry");
            }
        });
    });
    // END INC ON CHANGED

    // GROUP CLASS ON CHANGED
    $('#group_class').on('changed.bs.select', function(e) {
        var bismillah = $("#select_group_class li.selected small").text();
        $("#text_group_class").val(bismillah);
        $("#text_group_class").attr("title", bismillah);
        $('#select_group_class_box').removeClass("has-error");
        $('#select_group_class_box > p').removeClass("text-danger");
    });
    // END GROUP CLASS ON CHANGED

    // GET VALUES LIST WHEN VALUE COLUMN DOUBLE CLICKED
    $(document).on('dblclick', '.get-values-list', function() {
        // untuk bikin refresh pake ini:
        // url: 'home/inc-char-values/' + incCharId,
        incCharId = $(this).attr('data-inc-char-id');
        index = $(this).attr('data-index');
        charName = $('input[name="char_name' + incCharId + '"]').val();

        value = $('#values_list_modal_content span#body_'+index+' table tbody').html();
        $('#value_body').html(value);
        
        $('#get_values_list_modal_title').html(charName + ' <small>VALUE</small>');
        $('#index_get_values_list_modal').val(index);
        $('#get_values_list_modal').modal('show');
    });
    // END GET VALUES LIST WHEN VALUE COLUMN DOUBLE CLICKED

    // PICK VALUE FROM VALUES LIST / POP UP
    $(document).on('dblclick', '.pick-value', function() {
        linckIncCharValId = $(this).attr('data-link-inc-char-val-id');
        value = $(this).attr('data-value');
        abbrev = $(this).attr('data-abbrev');
        action = $(this).attr('data-action');
        bgcolor = $(this).attr('data-bg');

        index = $('#index_get_values_list_modal').val();

        if (action != 'update') {
            $('#insert_inc_char_val_id' + index).val(linckIncCharValId);
            $('#insert_value' + index).val(value);
            $('#insert_value' + index).attr('title', value);
            $('#insert_abbrev' + index).val(abbrev);
            $('#insert_abbrev' + index).attr('title', abbrev);
            $('tr#insert_id' + index).css('background-color', bgcolor);

            change('insert_value' + index);
        } else {
            $('#update_inc_char_val_id' + index).val(linckIncCharValId);
            $('#update_value' + index).val(value);
            $('#update_value' + index).attr('title', value);
            $('#update_abbrev' + index).val(abbrev);
            $('#update_abbrev' + index).attr('title', abbrev);
            $('tr#update_id' + index).css('background-color', bgcolor);

            change('update_value' + index);
        }

        $('#get_values_list_modal').modal('hide');
    });
    // END PICK VALUE FROM VALUES LIST / POP UP

    // DETECT CHANGED VALUE
    // https://www.sitepoint.com/detect-html-form-changes/

    // FOR INPUT VALUE FROM VALUES LIST / POP UP 
    function change(id) {
        var name = document.getElementById(id);
        if (name.value != name.defaultValue) {
            $("#" + id).attr("state", '1');
        } else {
            $("#" + id).attr("state", '0');
        }

        state = []; // value state
        $('.state').each(function(index, value) {
            state.push($(this).attr('state'));
        });

        cstate = []; // checkbox state
        $('.cstate').each(function(index, value) {
            cstate.push($(this).attr('cstate'));
        });

        newArray = state.concat(cstate);

        if (jQuery.inArray('1', newArray) == -1) {
            $("button#submit_values").prop("disabled", true);
        } else {
            $("button#submit_values").prop("disabled", false);
        }
    }
    // END FOR INPUT VALUE FROM VALUES LIST / POP UP 

    // FOR INPUT VALUE
    $(document).on('keyup', '.change-char-value', function() {
        id = $(this).attr('data-change');

        var name = document.getElementById(id);
        if (name.value != name.defaultValue) {
            $("#" + id).attr("state", '1');
        } else {
            $("#" + id).attr("state", '0');
        }

        state = []; // value state
        $('.state').each(function(index, value) {
            state.push($(this).attr('state'));
        });

        cstate = []; // checkbox state
        $('.cstate').each(function(index, value) {
            cstate.push($(this).attr('cstate'));
        });

        newArray = state.concat(cstate);

        // jika array tidak sama / ada yang berubah
        if (jQuery.inArray('1', newArray) == -1) {
            $("button#submit_values").prop("disabled", true);
        } else {
            $("button#submit_values").prop("disabled", false);
        }
        // console.log(newArray);
    });
    // END FOR INPUT VALUE

    // FOR CHECKBOX
    $(document).on('click', '.change-char-value', function() {
        id = $(this).attr('data-change');

        var checkbox = document.getElementById(id);
        if (checkbox.checked != checkbox.defaultChecked) {
            $("#" + id).attr("cstate", '1');
        } else {
            $("#" + id).attr("cstate", '0');
        }

        state = []; // value state
        $('.state').each(function(index, value) {
            state.push($(this).attr('state'));
        });

        cstate = []; // checkbox state
        $('.cstate').each(function(index, value) {
            cstate.push($(this).attr('cstate'));
        });

        newArray = state.concat(cstate);

        // jika array tidak sama / ada yang berubah
        if (jQuery.inArray('1', newArray) == -1) {
            $("button#submit_values").prop("disabled", true);
        } else {
            $("button#submit_values").prop("disabled", false);
        }
    });
    // END FOR CHECKBOX 

    // END DETECT CHANGED VALUE

    // INSERT-UPDATE PART CHARACTERISTIC VALUE
    $(document).on('click', '#submit_values', function() {

        // INSERTING...
        var insert_inc_char_id = $('.insert_inc_char_id').map(function() {
            return {
                name: this.name,
                value: $(this).val()
            };
        });

        var insert_char_ids = $('.insert_char_id').map(function() {
            return {
                name: this.name,
                value: $(this).val()
            };
        });

        var insert_values = $('.insert_value').map(function() {
            return {
                name: this.name,
                value: $(this).val().trim()
            };
        });

        var insert_shorts = $('.insert_short').map(function() {
            return {
                name: this.name,
                value: this.checked ? this.value : "0"
            };
        });

        // UPDATING...
        var update_inc_char_id = $('.update_inc_char_id').map(function() {
            return {
                name: this.name,
                value: $(this).val()
            };
        });

        var update_char_id = $('.update_char_id').map(function() {
            return {
                name: this.name,
                value: $(this).val()
            };
        });

        var update_value = $('.update_value').map(function() {
            return {
                name: this.name,
                value: $(this).val().trim()
            };
        });

        var part_char_value_id = $('.update_part_char_value_id').map(function() {
            return {
                name: this.name,
                value: $(this).val().trim()
            };
        });

        var update_short = $('.update_short').map(function() {
            return {
                name: this.name,
                value: this.checked ? this.value : "0"
            };
        });

        inserting1 = $.merge(insert_inc_char_id, insert_char_ids);
        inserting2 = $.merge(insert_values, insert_shorts);
        inserting = $.merge(inserting1, inserting2);

        updating1 = $.merge(update_inc_char_id, update_char_id);
        updating2 = $.merge(update_value, part_char_value_id);
        updating3 = $.merge(updating1, updating2);
        updating = $.merge(updating3, update_short);

        combine = $.merge(inserting, updating);

        $.ajax({
            type: 'POST',
            url: 'home/submit-values',
            data: jQuery.param(combine) + '&inc_id=' + $('select#inc').val() + '&group_class_id=' + $('select#group_class').val() + '&part_master_id=' + $("#part_master tbody tr.active").attr("id") + '&company_id=' + $("#part_master tbody tr.active input.company").val(),
            dataType: 'json',
            beforeSend: function() {},
            success: function(data) {
                if (data == 0) {

                    emptyMsg = "<td colspan='4' style='padding-top:30px;'><center><i class='fa fa-building-circle' style='font-size:130px;color:#ccc;'></i></center><td colspan='4'><center>NO DATA</center></td></td>";
                    $("#characteristic_value_box").empty().append(emptyMsg);

                    var optionsSelectAddCompany = {
                        ajax: {
                            url: 'home/select-add-company/' + part_master_id,
                            type: 'POST',
                            dataType: 'json',
                        },
                        locale: {
                            emptyTitle: 'SELECT COMPANY',
                        },
                        preprocessData: function(data) {
                            var i, l = data.length,
                                array = [];
                            if (l) {
                                for (i = 0; i < l; i++) {
                                    array.push($.extend(true, data[i], {
                                        text: data[i].company,
                                        value: data[i].id,
                                    }));
                                }
                            }
                            return array;
                        }
                    };

                    $('.select_add_company').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsSelectAddCompany);

                    $('.select_add_company').trigger('change');
                    $('button[data-id="select_add_company"]').addClass("btn-sm");

                    catalog_no = $("table#part_master tr.active td:eq(0)").text();
                    holding = $("table#part_master tr.active td:eq(1)").text();
                    item_name = $("table#part_master tr.active td:eq(3)").text();

                    $('#item_info').text(catalog_no + ' / ' + holding + ' / ' + item_name);
                    $('#add_company_modal').modal('show');

                } else if (data == 1) {

                    emptyMsg = "<td colspan='4' style='padding-top:30px;'><center><i class='fa fa-exclamation-circle' style='font-size:130px;color:#ccc;'></i></center><td colspan='4'><center>no characteristic available for this INC</center></td></td>";
                    $("#characteristic_value_box").empty().append(emptyMsg);

                } else {

                    $("table#part_master tr.active td:eq(3)").text(data.inc);
                    $("table#part_master tr.active td:eq(4)").text(data.item_name);
                    $("table#part_master tr.active td:eq(5)").text(data.group_class);

                    part_characteristic_value_box();
                    $("button#submit_values").prop("disabled", true);
                }
            },
            error: function(data) {
                $("#submit_values").blur();
                var errors = data.responseJSON;
                if (errors) {
                    $.each(errors, function(k, v) {
                        var i = k.substr(k.indexOf('.') + 1); //get after dot
                        var n = k.substr(0, k.indexOf('.')); //get before dot
                        if (n == 'update_value') {
                            $('tbody#characteristic_value_box input[name="update_value[' + i + ']"]').addClass('has-error');
                        } else if (n == 'insert_value') {
                            $('tbody#characteristic_value_box input[name="insert_value[' + i + ']"]').addClass('has-error');
                        }
                    });
                }
            }
        });

    });
    // INSERT-UPDATE PART CHARACTERISTIC VALUE

    // PART MANUFACTURER CODE
    // DATATABLES
    var datatable_part_manufacturer_code;

    function get_part_manufacturer_code(part_master_id) {
        datatable_part_manufacturer_code = $('#part_manufacturer_code').DataTable({
            destroy: true,
            processing: false,
            serverSide: true,
            ajax: 'home/part-manufacturer-code/' + part_master_id,
            columns: [{
                data: 'manufacturer_code',
                name: 'manufacturer_code'
            }, {
                data: 'source_type',
                name: 'source_type'
            }, {
                data: 'manufacturer_ref',
                name: 'manufacturer_ref'
            }, {
                data: 'type',
                name: 'type'
            }],
            oLanguage: {
                sLengthMenu: "_MENU_",
                sInfo: "SHOWING _START_ TO _END_ OF _TOTAL_ ENTRIES",
                oPaginate: {
                    sFirst: "FIRST",
                    sLast: "LAST",
                    sNext: "NEXT",
                    sPrevious: "PREVIOUS"
                },
                sSearch: "",
                sSearchPlaceholder: "SEARCH...",
            },
            dom: "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            pageLength: 8,
            drawCallback: function() {
                $('#part_manufacturer_code th:last-child')
                    .addClass('cpointer')
                    .empty()
                    .append('TYPE <kbd id="add-pmc" style="padding:2px 4px 1px !important;" class="kbd-primary pull-right cpointer">ADD</kbd>');
                
                var api = this.api();
                var info = api.page.info();
                recordsTotal = info.recordsTotal;
                if ( recordsTotal > 8 ) {
                    $('#part_manufacturer_code_info').css('display', 'block');
                    $('#part_manufacturer_code_paginate').css('display', 'block');
                }else{
                    $('#part_manufacturer_code_info').css('display', 'none');
                    $('#part_manufacturer_code_paginate').css('display', 'none');
                }
            }
        });
    }
    // END DATATABLES   

    var optionsManufacturerCode = {
        ajax: {
            url: 'home/select-manufacturer-code',
            type: 'POST',
            dataType: 'json',
        },
        locale: {
            emptyTitle: 'SELECT MANUFACTURER CODE'
        },
        preprocessData: function(data) {
            var i, l = data.length,
                array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text: data[i].manufacturer_code,
                        value: data[i].tbl_manufacturer_code_id,
                        data: {
                            subtext: data[i].manufacturer_name
                        }
                    }));
                }
            }
            return array;
        }
    };

    $('.manufacturer-code-pmc').trigger('change');

    // SHOW ADD PART MANUFACTURER CODE MODAL
    $(document).on('click', '#add-pmc', function() {
        // initialize here
        var requestCallback = new MyRequestsCompleted({
            numRequest: 2,
            singleCallback: function() {

                $(".error_saving_pmc").hide();
                $(".error_updating_pmc").hide();

                $('.manufacturer-code-pmc').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsManufacturerCode);
                $('button[data-id="manufacturer_code_pmc"]').addClass("btn-sm");
                $('.bs-searchbox > input.form-control').addClass("input-sm");

                $('#manufacturer_code_pmc').val([]);
                $('#manufacturer_code_pmc').trigger('change.abs.preserveSelected');
                $('#manufacturer_code_pmc').selectpicker('refresh');

                $('#manufacturer_name_pmc').val("");
                $('#manufacturer_ref_pmc').val("");
                $('#part_manufacturer_code_modal_title').text("ADD MANUFACTURER CODE");
                $('#btn_save_pmc').val("SAVE");
                $('#part_manufacturer_code_modal').modal('show');
                
            }
        });

        $.ajax({
            type: 'GET',
            url: 'home/source-type',
            dataType: 'json',
            beforeSend: function() {},
            success: function(data) {
                var option = '';
                $.each(data, function(i, item) {
                    option += '<option data-subtext="' + item.description + '" value="' + item.tbl_source_type_id + '">';
                    option += item.type;
                    option += '</option>';
                });
                $("#select_source_type_pmc").empty().append(option);
                $("#select_source_type_pmc").selectpicker('refresh');
                $('button[data-id="select_source_type_pmc"]').addClass("btn-sm");

                requestCallback.requestComplete(true);
            },
            error: function() {}
        });

        $.ajax({
            type: 'GET',
            url: 'home/manufacturer-code-type',
            dataType: 'json',
            beforeSend: function() {},
            success: function(data) {
                var option = '';
                $.each(data, function(i, item) {
                    option += '<option data-subtext="' + item.description + '" value="' + item.tbl_part_manufacturer_code_type_id + '">';
                    option += item.type;
                    option += '</option>';
                });
                $("#select_manufacturer_code_type_pmc").empty().append(option);
                $("#select_manufacturer_code_type_pmc").selectpicker('refresh');
                $('button[data-id="select_manufacturer_code_type_pmc"]').addClass("btn-sm");

                requestCallback.requestComplete(true);
            },
            error: function() {}
        });
    });
    // END SHOW ADD PART MANUFACTURER CODE MODAL    

    // SAVE PART MANUFACTURER CODE
    $("#btn_save_pmc").click(function() {
        var formData = {
            part_master_id: $("#part_master tbody tr.active").attr("id"),
            tbl_manufacturer_code_id: $('#manufacturer_code_pmc').val(),
            tbl_source_type_id: $('#select_source_type_pmc').val(),
            manufacturer_ref: $('#manufacturer_ref_pmc').val(),
            tbl_part_manufacturer_code_type_id: $('#select_manufacturer_code_type_pmc').val(),
            created_by: $('#logged_in_user').val(),
            last_updated_by: $('#logged_in_user').val(),
            id: $('#part_manufacturer_code_id_pmc').val(),
        }

        var state = $('#btn_save_pmc').val();
        var type = "POST";
        var url = 'home/add-part-manufacturer-code';


        if (state == "UPDATE") {
            type = "PUT";
            url = 'home/update-part-manufacturer-code';
        }

        $.ajax({
            type: type,
            url: url,
            data: formData,
            dataType: 'json',
            beforeSend: function(data) {
                $(".error_saving_pmc").hide();
                $(".error_updating_pmc").hide();

                if (state == "SAVE") {
                    $(".saving_pmc").show();
                } else {
                    $(".updating_pmc").show();
                }
            },
            success: function(data) {
                $('#part_manufacturer_code_modal_form').trigger("reset");
                $(".saving_pmc").hide();
                $(".updating_pmc").hide();

                datatable_part_manufacturer_code.ajax.reload(null, false);
                $('#part_manufacturer_code_modal').modal('hide');
            },
            error: function(data) {
                $(".saving_pmc").hide();
                $(".updating_pmc").hide();

                if (state == "SAVE") {
                    $(".error_saving_pmc").show();
                } else {
                    $(".error_updating_pmc").show();
                }
            }
        });
    });
    // END SAVE PART MANUFACTURER CODE

    // EDIT PART MANUFACTURER CODE
    $(document).on('click', '.edit-pmc', function() {
        id = $(this).attr('data-id');
        $.ajax({
            url: 'home/edit-part-manufacturer-code/' + id,
            type: 'GET',
            beforeSend: function() {},
            success: function(data) {

                $("#select_manufacturer_code_pmc > button[title='SELECT MANUFACTURER CODE']").replaceWith('<button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" data-id="manufacturer_code_pmc" title="' + data.manufacturer_code + '"><span class="filter-option pull-left">' + data.manufacturer_code + '</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>');
                $('#select_manufacturer_code_pmc > .dropdown-menu.open').replaceWith('<div class="dropdown-menu open" style="min-height: 39px; max-height: 228px; overflow: hidden;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px; max-height: 177px; overflow-y: auto;"><li class="dropdown-header" data-optgroup="1"><span class="text">Currently Selected</span></li><li data-original-index="0" data-optgroup="1" class="selected active"><a tabindex="0" class="opt  " style="" data-tokens="null"><span class="text">' + data.manufacturer_code + '<small class="text-muted">' + data.manufacturer_name + '</small></span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul><div class="status" style="">Start typing a search query</div></div>');
                $('#select_manufacturer_code_pmc > #manufacturer_code_pmc').replaceWith('<select id="manufacturer_code_pmc" class="manufacturer-code-pmc with-ajax" data-live-search="true" tabindex="-98"><optgroup label="Currently Selected"><option value="' + data.tbl_manufacturer_code_id + '" selected="selected" data-subtext="' + data.manufacturer_name + '">' + data.manufacturer_code + '</option></optgroup></select>');

                var optionsManufacturerCodeEdit = {
                    ajax: {
                        url: 'home/select-manufacturer-code',
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'SELECT MANUFACTURER CODE'
                    },
                    preprocessData: function(data) {
                        var i, l = data.length,
                            array = [];
                        if (l) {
                            for (i = 0; i < l; i++) {
                                array.push($.extend(true, data[i], {
                                    text: data[i].manufacturer_code,
                                    value: data[i].tbl_manufacturer_code_id,
                                    data: {
                                        subtext: data[i].manufacturer_name
                                    }
                                }));
                            }
                        }
                        return array;
                    }
                };

                $.ajax({
                    type: 'GET',
                    url: 'home/source-type',
                    dataType: 'json',
                    beforeSend: function() {},
                    success: function(source_type_data) {
                        var option = '';
                        $.each(source_type_data, function(i, item) {
                            if (data.tbl_source_type_id == item.tbl_source_type_id) {
                                option += '<option data-subtext="' + item.description + '" value="' + item.tbl_source_type_id + '" selected>';
                            } else {
                                option += '<option data-subtext="' + item.description + '" value="' + item.tbl_source_type_id + '">';
                            }
                            option += item.type;
                            option += '</option>';
                        });
                        $("#select_source_type_pmc").empty().append(option);
                        $("#select_source_type_pmc").selectpicker('refresh');
                        $('button[data-id="select_source_type_pmc"]').addClass("btn-sm");
                        requestCallback.requestComplete(true);
                    },
                    error: function() {}
                });

                $.ajax({
                    type: 'GET',
                    url: 'home/manufacturer-code-type',
                    dataType: 'json',
                    beforeSend: function() {},
                    success: function(manufacturer_code_type_data) {
                        var option = '';
                        $.each(manufacturer_code_type_data, function(i, item) {
                            if (data.tbl_part_manufacturer_code_type_id == item.tbl_part_manufacturer_code_type_id) {
                                option += '<option data-subtext="' + item.description + '" value="' + item.tbl_part_manufacturer_code_type_id + '" selected>';
                            } else {
                                option += '<option data-subtext="' + item.description + '" value="' + item.tbl_part_manufacturer_code_type_id + '">';
                            }
                            option += item.type;
                            option += '</option>';
                        });
                        $("#select_manufacturer_code_type_pmc").empty().append(option);
                        $("#select_manufacturer_code_type_pmc").selectpicker('refresh');
                        $('button[data-id="select_manufacturer_code_type_pmc"]').addClass("btn-sm");
                        requestCallback.requestComplete(true);
                    },
                    error: function() {}
                });

                var requestCallback = new MyRequestsCompleted({
                    numRequest: 2,
                    singleCallback: function() {

                        $('.manufacturer-code-pmc').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsManufacturerCodeEdit);
                        $('.manufacturer-code-pmc').trigger('change');
                        $('button[data-id="manufacturer_code_pmc"]').addClass("btn-sm");
                        $('.bs-searchbox > input.form-control').addClass("input-sm");

                        $('#manufacturer_name_pmc').val(data.manufacturer_name);
                        $('#manufacturer_ref_pmc').val(data.manufacturer_ref);
                        $('#part_manufacturer_code_id_pmc').val(data.part_manufacturer_code_id);

                        $('#btn_save_pmc').val("UPDATE");
                        $('#part_manufacturer_code_modal_title').text("EDIT MANUFACTURER CODE");
                        $('#part_manufacturer_code_modal').modal('show');

                    }
                });
            },
            error: function() {}
        });
    });
    // END EDIT PART MANUFACTURER CODE

    // DELETE PART MANUFACTURER CODE
    $(document).on('click', '.delete-pmc', function() {
        id = $(this).attr('data-id');

        var manufacturerCode = $("table#part_manufacturer_code tr#" + id + " td:eq(0)").html();
        var source = $("table#part_manufacturer_code tr#" + id + " td:eq(1)").html();
        var manufacturerRef = $("table#part_manufacturer_code tr#" + id + " td:eq(2)").html();
        var type = $("table#part_manufacturer_code tr#" + id + " td:eq(3)").html();

        var msg = "<table class=\"table table-striped\">";
        msg += "<thead><tr><th>MANCODE</th><th>SOURCE</th><th>MANUFACTURER REF</th><th>TYPE</th></thead>";
        msg += "<tbody><tr><td>" + manufacturerCode + "</td><td>" + source + "</td><td>" + manufacturerRef + "</td><td>" + type + "</td></tr></tbody>";
        msg += "</table>";

        bootbox.dialog({
            message: msg,
            title: "ARE YOU SURE YOU WANT TO DELETE THIS <b>MANUFACTURER CODE</b>?",
            buttons: {
                success: {
                    label: "YES DELETE",
                    className: "btn-danger btn-sm",
                    callback: function() {
                        $.ajax({
                            type: "DELETE",
                            url: 'home/delete-part-manufacturer-code/' + id,
                            beforeSend: function() {},
                            success: function() {
                                datatable_part_manufacturer_code.ajax.reload(null, false);
                            },
                            error: function() {
                                alert('Cannot delete this Manufacturer Code.');
                            }
                        });
                    }
                },
                danger: {
                    label: "CANCEL",
                    className: "btn-default btn-sm",
                },
            },
            animate: false,
        });
    });

    $(document).ajaxComplete(function() {
        $('#manufacturer_code_pmc').on('changed.bs.select', function(e) {
            var bismillah = $("#select_manufacturer_code_pmc li.selected small").text();
            $("#manufacturer_name_pmc").val(bismillah);
            $("#manufacturer_name_pmc").attr("title", bismillah);
        });

        $('#part_manufacturer_code_modal').on('hide.bs.modal', function(e) {
            $('#select_manufacturer_code_pmc').html('<select id="manufacturer_code_pmc" class="manufacturer-code-pmc with-ajax" data-live-search="true" data-width="100%"></select> ');

            $(".error_saving_pmc").hide();
            $(".error_updating_pmc").hide();
        });
    });

    // END PART MANUFACTURER CODE

    // PART COLLOQUIAL
    // DATATABLES
    var datatable_part_colloquial;

    function get_part_colloquial(part_master_id) {
        datatable_part_colloquial = $('#part_colloquial').DataTable({
            destroy: true,
            processing: false,
            serverSide: true,
            ajax: 'home/part-colloquial/' + part_master_id,
            columns: [{
                data: 'colloquial',
                name: 'colloquial'
            }, ],
            oLanguage: {
                sLengthMenu: "_MENU_",
                sInfo: "SHOWING _START_ TO _END_ OF _TOTAL_ ENTRIES",
                oPaginate: {
                    sFirst: "FIRST",
                    sLast: "LAST",
                    sNext: "NEXT",
                    sPrevious: "PREVIOUS"
                },
                sSearch: "",
                sSearchPlaceholder: "SEARCH...",
            },
            dom: "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            pageLength: 9,
            drawCallback: function() {
                $('#part_colloquial th:last-child')
                    .addClass('cpointer')
                    .empty()
                    .append('COLLOQUIAL NAME <kbd id="add-pc" style="padding:2px 4px 1px !important;" class="kbd-primary pull-right cpointer">ADD</kbd>');
            
                var api = this.api();
                var info = api.page.info();
                recordsTotal = info.recordsTotal;
                if ( recordsTotal > 9 ) {
                    $('#part_colloquial_info').css('display', 'block');
                    $('#part_colloquial_paginate').css('display', 'block');
                }else{
                    $('#part_colloquial_info').css('display', 'none');
                    $('#part_colloquial_paginate').css('display', 'none');
                }
            }
        });
    }
    // END DATATABLES

    // ADD PART COLLOQUIAL
    $(document).on('click', '#add-pc', function() {
        $(".error_saving_pc").hide();
        $(".error_updating_pc").hide();

        $('#colloquial_pc').val("");
        $('#part_colloquial_modal_title').text("ADD COLLOQUIAL");
        $('#btn_save_pc').val("SAVE");
        $('#part_colloquial_modal').modal('show');
    });
    // END ADD PART COLLOQUIAL

    // EDIT PART COLLOQUIAL
    $(document).on('click', '.edit-pc', function() {
        id = $(this).attr('data-id');
        colloquial = $("table#part_colloquial tr#" + id + " span.colloquial").text();

        $(".error_saving_pc").hide();
        $(".error_updating_pc").hide();

        $('#colloquial_pc').val(colloquial);
        $('#part_colloquial_id_pc').val(id);
        $('#part_colloquial_modal_title').text("EDIT COLLOQUIAL");
        $('#btn_save_pc').val("UPDATE");
        $('#part_colloquial_modal').modal('show');
    });
    // END EDIT PART COLLOQUIAL

    // DELETE PART COLLOQUIAL
    $(document).on('click', '.delete-pc', function() {
        id = $(this).attr('data-id');
        colloquial = $("table#part_colloquial tr#" + id + " span.colloquial").text();

        var msg = "<table class=\"table table-striped\">";
        msg += "<thead><tr><th>COLLOQUIAL</th></thead>";
        msg += "<tbody><tr><td>" + colloquial + "</td></tr></tbody>";
        msg += "</table>";

        bootbox.dialog({
            message: msg,
            title: "ARE YOU SURE YOU WANT TO DELETE THIS <b>COLLOQUIAL NAME</b>?",
            buttons: {
                success: {
                    label: "YES DELETE",
                    className: "btn-danger btn-sm",
                    callback: function() {
                        $.ajax({
                            type: "DELETE",
                            url: "home/delete-part-colloquial/" + id,
                            beforeSend: function() {},
                            success: function() {
                                datatable_part_colloquial.ajax.reload(null, false);
                            },
                            error: function() {
                                alert('Cannot delete this Colloquial Name.');
                            }
                        });
                    }
                },
                danger: {
                    label: "CANCEL",
                    className: "btn-default btn-sm",
                },
            },
            animate: false,
        });
    });
    // END DELETE PART COLLOQUIAL

    // SAVE PART COLLOQUIAL
    $("#btn_save_pc").click(function() {
        var formData = {
            part_master_id: $("#part_master tbody tr.active").attr("id"),
            colloquial: $("#colloquial_pc").val().trim(),
            created_by: $('#logged_in_user').val(),
            last_updated_by: $('#logged_in_user').val(),
            id: $('#part_colloquial_id_pc').val(),
        }

        var state = $('#btn_save_pc').val();
        var type = "POST";
        var url = "home/add-part-colloquial";


        if (state == "UPDATE") {
            type = "PUT";
            url = "home/update-part-colloquial";
        }

        $.ajax({
            type: type,
            url: url,
            data: formData,
            dataType: 'json',
            beforeSend: function(data) {
                $(".error_saving_pc").hide();
                $(".error_updating_pc").hide();

                if (state == "SAVE") {
                    $(".saving_pc").show();
                } else {
                    $(".updating_pc").show();
                }
            },
            success: function(data) {
                $('#part_colloquial_modal_form').trigger("reset");
                $(".saving_pc").hide();
                $(".updating_pc").hide();

                datatable_part_colloquial.ajax.reload(null, false);
                $('#part_colloquial_modal').modal('hide');
            },
            error: function(data) {
                $(".saving_pc").hide();
                $(".updating_pc").hide();

                if (state == "SAVE") {
                    $(".error_saving_pc").show();
                } else {
                    $(".error_updating_pc").show();
                }
            }
        });
    });
    // END SAVE PART COLLOQUIAL
    // END PART COLLOQUIAL

    // PART EQUIPMENT CODE
    // DATATABLES
    var datatable_part_equipment_code;

    function get_part_equipment_code(part_master_id,company_id) {
        datatable_part_equipment_code = $('#part_equipment_code').DataTable({
            destroy: true,
            processing: false,
            serverSide: true,
            ajax: 'home/part-equipment-code/' + part_master_id + '/' + company_id,
            columns: [{
                data: 'plant',
                name: 'plant'
            }, {
                data: 'equipment_code',
                name: 'equipment_code'
            }, {
                data: 'equipment_name',
                name: 'equipment_name'
            }, {
                data: 'qty_install',
                name: 'qty_install'
            }, {
                data: 'manufacturer_code',
                name: 'manufacturer_code'
            }, {
                data: 'document_ref',
                name: 'document_ref'
            }, {
                data: 'drawing_ref',
                name: 'drawing_ref'
            }, ],
            oLanguage: {
                sLengthMenu: "_MENU_",
                sInfo: "SHOWING _START_ TO _END_ OF _TOTAL_ ENTRIES",
                oPaginate: {
                    sFirst: "FIRST",
                    sLast: "LAST",
                    sNext: "NEXT",
                    sPrevious: "PREVIOUS"
                },
                sSearch: "",
                sSearchPlaceholder: "SEARCH...",
            },
            dom: "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            pageLength: 8,
            drawCallback: function() {
                $('#part_equipment_code th:last-child')
                    .addClass('cpointer')
                    .empty()
                    .append('DRAWING REF <kbd id="add-pec" style="padding:2px 4px 1px !important;" class="kbd-primary pull-right cpointer">ADD</kbd>');
            
                var api = this.api();
                var info = api.page.info();
                recordsTotal = info.recordsTotal;
                if ( recordsTotal > 8 ) {
                    $('#part_equipment_code_info').css('display', 'block');
                    $('#part_equipment_code_paginate').css('display', 'block');
                }else{
                    $('#part_equipment_code_info').css('display', 'none');
                    $('#part_equipment_code_paginate').css('display', 'none');
                }
            }
        });
    }
    // END DATATABLES

    // SELECT EQUIPMENT CODE
    var company_id = $("#part_master tbody tr.active .company").val();
    var optionsEquipmentCode = {
        ajax: {
            url: 'home/select-equipment-code/' + company_id,
            type: 'POST',
            dataType: 'json',
        },
        locale: {
            emptyTitle: 'SELECT EQUIPMENT CODE'
        },
        preprocessData: function(data) {
            var i, l = data.length,
                array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text: data[i].equipment_code,
                        value: data[i].tbl_equipment_code_id,
                        data: {
                            subtext: data[i].equipment_name
                        }
                    }));
                }
            }
            return array;
        }
    };

    $('.equipment-code-peq').trigger('change');
    $('.manufacturer-code-peq').trigger('change');
    // END SELECT EQUIPMENT CODE

    // ADD PART EQUIPMENT CODE
    $(document).on('click', '#add-pec', function() {
        $(".error_saving_pmc").hide();
        $(".error_updating_pmc").hide();
        
        var company_id = $("#part_master tbody tr.active .company").val();
        var optionsEquipmentCode = {
            ajax: {
                url: 'home/select-equipment-code/' + company_id,
                type: 'POST',
                dataType: 'json',
            },
            locale: {
                emptyTitle: 'SELECT EQUIPMENT CODE'
            },
            preprocessData: function(data) {
                var i, l = data.length,
                    array = [];
                if (l) {
                    for (i = 0; i < l; i++) {
                        array.push($.extend(true, data[i], {
                            text: data[i].equipment_code,
                            value: data[i].tbl_equipment_code_id,
                            data: {
                                subtext: '<span class="equipment_name">'+data[i].equipment_name+'</span><span class="hidden plant">'+data[i].plant+'</span><span class="hidden doc_ref">'+data[i].document_ref+'</span>'
                            }
                        }));
                    }
                }
                return array;
            }
        };

        $('.equipment-code-peq').trigger('change');
        $('.manufacturer-code-peq').trigger('change');

        $('.equipment-code-peq').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsEquipmentCode);
        $('button[data-id="equipment_code_peq"]').addClass("btn-sm");
        $('.bs-searchbox > input.form-control').addClass("input-sm");

        $('#equipment_code_peq').val([]);
        $('#equipment_code_peq').trigger('change.abs.preserveSelected');
        $('#equipment_code_peq').selectpicker('refresh');

        $('.manufacturer-code-peq').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsManufacturerCode);
        $('button[data-id="manufacturer_code_peq"]').addClass("btn-sm");
        $('.bs-searchbox > input.form-control').addClass("input-sm");

        $('#manufacturer_code_peq').val([]);
        $('#manufacturer_code_peq').trigger('change.abs.preserveSelected');
        $('#manufacturer_code_peq').selectpicker('refresh');

        $('#equipment_name_peq').val("");
        $('#qty_install_peq').val("");
        $('#manufacturer_name_peq').val("");
        $('#doc_ref_peq').val("");
        $('#dwg_ref_peq').val("");

        $('#part_equipment_code_modal_title').text("ADD EQUIPMENT CODE");
        $('#part_equipment_code_form').trigger("reset");
        $('#btn_save_peq').val("SAVE");
        $('#part_equipment_code_modal').modal('show');
    });
    // END ADD PART EQUIPMENT CODE

    $(document).ajaxComplete(function() {
        // CHANGE EQUIPMENT CODE
        $('#equipment_code_peq').on('changed.bs.select', function(e) {
            var equipment_name = $("#select_equipment_code_peq li.selected small span.equipment_name").text();
            $("#equipment_name_peq").val(equipment_name);
            $("#equipment_name_peq").attr("title", equipment_name);

            var plant = $("#select_equipment_code_peq li.selected small span.plant").text();
            $("#plant_peq").val(plant);
            $("#plant_peq").attr("title", plant);

            var document_ref = $("#select_equipment_code_peq li.selected small span.doc_ref").text();
            $("#document_ref_peq").val(document_ref);
            $("#document_ref_peq").attr("title", document_ref);
        });

        // CHANGE MANUFACTURER CODE
        $('#manufacturer_code_peq').on('changed.bs.select', function(e) {
            var bismillah = $("#select_manufacturer_code_peq li.selected small").text();
            $("#manufacturer_name_peq").val(bismillah);
            $("#manufacturer_name_peq").attr("title", bismillah);
        });

        // WHEN EQUIPMENT CODE MODAL HIDE
        $('#part_equipment_code_modal').on('hide.bs.modal', function(e) {

            $('#select_manufacturer_code_peq').html('<select id="manufacturer_code_peq" class="manufacturer-code-peq with-ajax" data-live-search="true" data-width="100%"></select> ');

            $('#select_equipment_code_peq').html('<select id="equipment_code_peq" class="equipment-code-peq with-ajax" data-live-search="true" data-width="100%"></select> ');

            $(".error_saving_peq").hide();
            $(".error_updating_peq").hide();

        });
    });

    // EDIT PART EQUIPMENT CODE
    $(document).on('click', '.edit-pec', function() {
        id = $(this).attr('data-id');
        var company_id = $("#part_master tbody tr.active .company").val();

        $.ajax({
            url: 'home/edit-part-equipment-code/' + id,
            type: 'GET',
            beforeSend: function() {},
            success: function(data) {


                $("#select_equipment_code_peq > button[title='SELECT EQUIPMENT CODE']").replaceWith('<button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" data-id="equipment_code_peq" title="' + data.equipment_code + '"><span class="filter-option pull-left">' + data.equipment_code + '</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>');
                $('#select_equipment_code_peq > .dropdown-menu.open').replaceWith('<div class="dropdown-menu open" style="min-height: 39px; max-height: 228px; overflow: hidden;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px; max-height: 177px; overflow-y: auto;"><li class="dropdown-header" data-optgroup="1"><span class="text">Currently Selected</span></li><li data-original-index="0" data-optgroup="1" class="selected active"><a tabindex="0" class="opt  " style="" data-tokens="null"><span class="text">' + data.equipment_code + '<small class="text-muted">' + data.equipment_name + '</small></span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul><div class="status" style="">Start typing a search query</div></div>');
                $('#select_equipment_code_peq > #equipment_code_peq').replaceWith('<select id="equipment_code_peq" class="equipment-code-peq with-ajax" data-live-search="true" tabindex="-98"><optgroup label="Currently Selected"><option value="' + data.tbl_equipment_code_id + '" selected="selected" data-subtext="' + data.equipment_name + '">' + data.equipment_code + '</option></optgroup></select>');

                $("#select_manufacturer_code_peq > button[title='SELECT MANUFACTURER CODE']").replaceWith('<button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" data-id="manufacturer_code_peq" title="' + data.manufacturer_code + '"><span class="filter-option pull-left">' + data.manufacturer_code + '</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>');
                $('#select_manufacturer_code_peq > .dropdown-menu.open').replaceWith('<div class="dropdown-menu open" style="min-height: 39px; max-height: 228px; overflow: hidden;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px; max-height: 177px; overflow-y: auto;"><li class="dropdown-header" data-optgroup="1"><span class="text">Currently Selected</span></li><li data-original-index="0" data-optgroup="1" class="selected active"><a tabindex="0" class="opt  " style="" data-tokens="null"><span class="text">' + data.manufacturer_code + '<small class="text-muted">' + data.manufacturer_name + '</small></span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul><div class="status" style="">Start typing a search query</div></div>');
                $('#select_manufacturer_code_peq > #manufacturer_code_peq').replaceWith('<select id="manufacturer_code_peq" class="manufacturer-code-peq with-ajax" data-live-search="true" tabindex="-98"><optgroup label="Currently Selected"><option value="' + data.tbl_manufacturer_code_id + '" selected="selected" data-subtext="' + data.manufacturer_name + '">' + data.manufacturer_code + '</option></optgroup></select>');

                var optionsEquipmentCodeEdit = {
                    ajax: {
                        url: "home/select-equipment-code/" + company_id,
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'SELECT EQUIPMENT CODE'
                    },
                    preprocessData: function(data) {
                        var i, l = data.length,
                            array = [];
                        if (l) {
                            for (i = 0; i < l; i++) {
                                array.push($.extend(true, data[i], {
                                    text: data[i].equipment_code,
                                    value: data[i].tbl_equipment_code_id,
                                    data: {
                                        subtext: '<span class="equipment_name">'+data[i].equipment_name+'</span><span class="hidden plant">'+data[i].plant+'</span><span class="hidden doc_ref">'+data[i].document_ref+'</span>'
                                    }
                                }));
                            }
                        }
                        return array;
                    }
                };

                $('.equipment-code-peq').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsEquipmentCodeEdit);
                $('.equipment-code-peq').trigger('change');
                $('button[data-id="equipment_code_peq"]').addClass("btn-sm");

                $('#equipment_name_peq').val(data.equipment_name);
                $('#qty_install_peq').val(data.qty_install);

                var optionsManufacturerCodePeq = {
                    ajax: {
                        url: 'home/select-manufacturer-code',
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'SELECT MANUFACTURER CODE'
                    },
                    preprocessData: function(data) {
                        var i, l = data.length,
                            array = [];
                        if (l) {
                            for (i = 0; i < l; i++) {
                                array.push($.extend(true, data[i], {
                                    text: data[i].manufacturer_code,
                                    value: data[i].tbl_manufacturer_code_id,
                                    data: {
                                        subtext: data[i].manufacturer_name
                                    }
                                }));
                            }
                        }
                        return array;
                    }
                };

                $('.manufacturer-code-peq').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsManufacturerCodePeq);
                $('.manufacturer-code-peq').trigger('change');
                $('button[data-id="manufacturer_code_peq"]').addClass("btn-sm");

                $('.bs-searchbox > input.form-control').addClass("input-sm");
                $('#manufacturer_name_peq').val(data.manufacturer_name);
                $('#document_ref_peq').val(data.document_ref).attr('title', data.document_ref);
                $('#drawing_ref_peq').val(data.drawing_ref).attr('title', data.drawing_ref);
                $('#plant_peq').val(data.plant).attr('title', data.plant);

                $('#part_equipment_code_id').val(id);

                $('#btn_save_peq').val("UPDATE");
                $('#part_equipment_code_modal_title').text("EDIT EQUIPMENT CODE");
                $('#part_equipment_code_modal').modal('show');
            },
            error: function() {}
        });
    });
    // END EDIT PART EQUIPMENT CODE

    // SAVE PART EQUIPMENT CODE
    $("#btn_save_peq").click(function() {
        var formData = {
            part_master_id: $("#part_master tbody tr.active").attr("id"),
            tbl_equipment_code_id: $("#equipment_code_peq").val(),
            qty_install: $("#qty_install_peq").val().trim(),
            tbl_manufacturer_code_id: $("#manufacturer_code_peq").val(),
            drawing_ref: $("#drawing_ref_peq").val().trim(),
            created_by: $('#logged_in_user').val(),
            last_updated_by: $('#logged_in_user').val(),
            id: $('#part_equipment_code_id').val(),
        }

        var state = $('#btn_save_peq').val();
        var type = "POST";
        var url = "home/add-part-equipment-code";


        if (state == "UPDATE") {
            type = "PUT";
            url = "home/update-part-equipment-code";
        }

        $.ajax({
            type: type,
            url: url,
            data: formData,
            dataType: 'json',
            beforeSend: function(data) {
                $(".error_saving_peq").hide();
                $(".error_updating_peq").hide();

                if (state == "SAVE") {
                    $(".saving_peq").show();
                } else {
                    $(".updating_peq").show();
                }
            },
            success: function(data) {
                $('#part_equipment_code_form').trigger("reset");
                $(".saving_peq").hide();
                $(".updating_peq").hide();

                datatable_part_equipment_code.ajax.reload(null, false);
                $('#part_equipment_code_modal').modal('hide');
            },
            error: function(data) {
                $(".saving_peq").hide();
                $(".updating_peq").hide();

                if (state == "SAVE") {
                    $(".error_saving_peq").show();
                } else {
                    $(".error_updating_peq").show();
                }
            }
        });
    });
    // END SAVE PART EQUIPMENT CODE

    // DELETE PART EQUIPMENT CODE
    $(document).on('click', '.delete-pec', function() {
        id = $(this).attr('data-id');

        var plant = $("#part_equipment_code tbody tr#" + id + " td:eq(0)").text();
        var equipmentCode = $("#part_equipment_code tbody tr#" + id + " td:eq(1)").text();
        var equipmentName = $("#part_equipment_code tbody tr#" + id + " td:eq(2)").text();
        var qtyInstall = $("#part_equipment_code tbody tr#" + id + " td:eq(3)").text();
        var manufacturerCode = $("#part_equipment_code tbody tr#" + id + " td:eq(4)").text();
        var documentRef = $("#part_equipment_code tbody tr#" + id + " td:eq(5)").text();
        var drawingRef = $("#part_equipment_code tbody tr#" + id + " span.drawing_ref").text();

        var msg = "<table class=\"table table-striped table-hover\">";
        msg += "<thead><tr><th>PLANT</th><th>EQUIPMENT CODE</th><th>EQUIPMENT NAME</th><th>QTY</th><th>MANUFACTURER CODE</th><th>DOCUMENT REF</th><th>DRAWING REF</th></thead>";
        msg += "<tbody><tr><td>" + plant + "</td><td>" + equipmentCode + "</td><td>" + equipmentName + "</td><td>" + qtyInstall + "</td><td>" + manufacturerCode + "</td><td>" + documentRef + "</td><td>" + drawingRef + "</td></tr></tbody>";
        msg += "</table>";

        bootbox.dialog({
            message: msg,
            title: "ARE YOU SURE YOU WANT TO DELETE THIS <b>EQUIPMENT CODE</b>?",
            buttons: {
                success: {
                    label: "YES DELETE",
                    className: "btn-danger btn-sm",
                    callback: function() {
                        $.ajax({
                            type: "DELETE",
                            url: 'home/delete-part-equipment-code/' + id,
                            beforeSend: function() {},
                            success: function(data) {
                                datatable_part_equipment_code.ajax.reload(null, false);
                            },
                            error: function(data) {
                                alert('Error deleting Equipment Code.');
                            }
                        });
                    }
                },
                danger: {
                    label: "CANCEL",
                    className: "btn-default btn-sm",
                },
            },
            animate: false,
            size: 'large',
        });
    });
    // END DELETE PART EQUIPMENT CODE

    $(document).ajaxComplete(function() {
        $('#part_equipment_code_modal').on('hide.bs.modal', function(e) {
            $('#select_equipment_code_peq').html('<select id="equipment_code_peq" class="equipment-code-peq with-ajax" data-live-search="true"></select>');
            $('#select_manufacturer_code_peq').html('<select id="manufacturer_code_peq" class="manufacturer-code-peq with-ajax" data-live-search="true"></select>');

            $(".error_saving_peq").hide();
            $(".error_updating_peq").hide();
        });
    });
    // END PART EQUIPMENT CODE

    // GLOBAL SEARCH
    // CATALOG NO
    var optionsSearchCatalogNo = {
        ajax: {
            url: 'search-items/select-search-catalog-no',
            type: 'POST',
            dataType: 'json',
        },
        locale: {
            emptyTitle: 'SELECT CATALOG NO',
            statusInitialized: 'Start typing search keyword(s)'
        },
        preprocessData: function(data) {
            var i, l = data.length,
                array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text: data[i].catalog_no,
                        value: data[i].catalog_no,
                    }));
                }
            }
            return array;
        }
    };

    $('.search_catalog_no').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsSearchCatalogNo);
    $('.search_catalog_no').trigger('change');
    $('button[data-id="search_catalog_no"]').addClass("btn-sm");
    $('#search_catalog_no').on('changed.bs.select', function(e) {
        $('button[data-id="search_catalog_no"]').css('background-color','#faffbd');
    });

    // HOLDING NO
    var optionsSearchHoldingNo = {
        ajax: {
            url: 'search-items/select-search-holding-no',
            type: 'POST',
            dataType: 'json',
        },
        locale: {
            emptyTitle: 'SELECT HOLDING NO',
            statusInitialized: 'Start typing search keyword(s)'
        },
        preprocessData: function(data) {
            var i, l = data.length,
                array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text: data[i].holding_no,
                        value: data[i].holding_no,
                    }));
                }
            }
            return array;
        }
    };

    $('.search_holding_no').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsSearchHoldingNo);
    $('.search_holding_no').trigger('change');
    $('button[data-id="search_holding_no"]').addClass("btn-sm");
    $('#search_holding_no').on('changed.bs.select', function(e) {
        $('button[data-id="search_holding_no"]').css('background-color','#faffbd');
    });

    // INC - ITEM NAME
    var optionsSearchIncItemName = {
        ajax: {
            url: 'search-items/select-search-inc-item-name',
            type: 'POST',
            dataType: 'json',
        },
        locale: {
            emptyTitle: 'SELECT INC : ITEM NAME',
            searchPlaceholder: 'SEARCH INC OR ITEM NAME',
            statusInitialized: 'Start typing search keyword(s)'
        },
        preprocessData: function(data) {
            var i, l = data.length,
                array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text: data[i].inc + ' : ' + data[i].item_name,
                        value: data[i].tbl_inc_id,
                    }));
                }
            }
            return array;
        }
    };

    $('.search_inc_item_name').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsSearchIncItemName);
    $('.search_inc_item_name').trigger('change');
    $('button[data-id="search_inc_item_name"]').addClass("btn-sm");
    $('#search_inc_item_name').on('changed.bs.select', function(e) {
        $('button[data-id="search_inc_item_name"]').css('background-color','#faffbd');
    });

    // COLLOQUIAL
    var optionsSearchColloquial = {
        ajax: {
            url: 'search-items/select-search-colloquial',
            type: 'POST',
            dataType: 'json',
        },
        locale: {
            emptyTitle: 'SELECT COLLOQUIAL',
            statusInitialized: 'Start typing search keyword(s)'
        },
        preprocessData: function(data) {
            var i, l = data.length,
                array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text: data[i].colloquial,
                        value: data[i].tbl_colloquial_id,
                    }));
                }
            }
            return array;
        }
    };

    $('.search_colloquial_id').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsSearchColloquial);
    $('.search_colloquial_id').trigger('change');
    $('button[data-id="search_colloquial_id"]').addClass("btn-sm");
    $('#search_colloquial_id').on('changed.bs.select', function(e) {
        $('button[data-id="search_colloquial_id"]').css('background-color','#faffbd');
    });

    // GROUP CLASS
    var optionsSearchGroupClass = {
        ajax: {
            url: 'search-items/select-search-group-class',
            type: 'POST',
            dataType: 'json',
        },
        locale: {
            emptyTitle: 'SELECT GROUP CLASS : CLASS NAME',
            searchPlaceholder: 'SEARCH GROUP CLASS OR CLASS NAME',
            statusInitialized: 'Start typing search keyword(s)'
        },
        preprocessData: function(data) {
            var i, l = data.length,
                array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text: data[i].group_class + ' : ' + data[i].name,
                        value: data[i].tbl_group_class_id,
                    }));
                }
            }
            return array;
        }
    };

    $('.search_group_class').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsSearchGroupClass);
    $('.search_group_class').trigger('change');
    $('button[data-id="search_group_class"]').addClass("btn-sm");
    $('#search_group_class').on('changed.bs.select', function(e) {
        $('button[data-id="search_group_class"]').css('background-color','#faffbd');
    });

    // CATALOG STATUS
    var optionsSearchCatalogStatus = {
        ajax: {
            url: 'search-items/select-search-catalog-status',
            type: 'POST',
            dataType: 'json',
        },
        locale: {
            emptyTitle: 'SELECT CATALOG STATUS',
            statusInitialized: 'Start typing search keyword(s)'
        },
        preprocessData: function(data) {
            var i, l = data.length,
                array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text: data[i].status,
                        value: data[i].tbl_catalog_status_id,
                    }));
                }
            }
            return array;
        }
    };

    $('.search_catalog_status').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsSearchCatalogStatus);
    $('.search_catalog_status').trigger('change');
    $('button[data-id="search_catalog_status"]').addClass("btn-sm");
    $('#search_catalog_status').on('changed.bs.select', function(e) {
        $('button[data-id="search_catalog_status"]').css('background-color','#faffbd');
    });

    // CATALOG TYPE
    $('.search_catalog_type').selectpicker();
    $('button[data-id="search_catalog_type"]').addClass("btn-sm");
    $('#search_catalog_type').on('changed.bs.select', function(e) {
        $('button[data-id="search_catalog_type"]').css('background-color','#faffbd');
    });

    // ITEM TYPE
    var optionsSearchItemType = {
        ajax: {
            url: 'search-items/select-search-item-type',
            type: 'POST',
            dataType: 'json',
        },
        locale: {
            emptyTitle: 'SELECT ITEM TYPE',
            statusInitialized: 'Start typing search keyword(s)'
        },
        preprocessData: function(data) {
            var i, l = data.length,
                array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text: data[i].type,
                        value: data[i].tbl_item_type_id,
                    }));
                }
            }
            return array;
        }
    };

    $('.search_item_type').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsSearchItemType);
    $('.search_item_type').trigger('change');
    $('button[data-id="search_item_type"]').addClass("btn-sm");
    $('#search_item_type').on('changed.bs.select', function(e) {
        $('button[data-id="search_item_type"]').css('background-color','#faffbd');
    });

    // MANUFACTURER
    var optionsSearchManufacturer = {
        ajax: {
            url: 'search-items/select-search-manufacturer',
            type: 'POST',
            dataType: 'json',
        },
        locale: {
            emptyTitle: 'SELECT MANUFACTURER CODE : MANUFACTURER NAME',
            searchPlaceholder: 'SEARCH MANUFACTURER CODE OR MANUFACTURER NAME',
            statusInitialized: 'Start typing search keyword(s)'
        },
        preprocessData: function(data) {
            var i, l = data.length,
                array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text: data[i].manufacturer_code + ' : ' + data[i].manufacturer_name,
                        value: data[i].tbl_manufacturer_code_id,
                    }));
                }
            }
            return array;
        }
    };

    $('.search_manufacturer').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsSearchManufacturer);
    $('.search_manufacturer').trigger('change');
    $('button[data-id="search_manufacturer"]').addClass("btn-sm");
    $('#search_manufacturer').on('changed.bs.select', function(e) {
        $('button[data-id="search_manufacturer"]').css('background-color','#faffbd');
    });

    // PART NUMBER
    var optionsSearchPartNumber = {
        ajax: {
            url: 'search-items/select-search-part-number',
            type: 'POST',
            dataType: 'json',
        },
        locale: {
            emptyTitle: 'SELECT PART NUMBER',
            searchPlaceholder: 'SEARCH PART NUMBER',
            statusInitialized: 'Start typing search keyword(s)'
        },
        preprocessData: function(data) {
            var i, l = data.length,
                array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text: data[i].part_number,
                        value: data[i].part_number,
                    }));
                }
            }
            return array;
        }
    };

    $('.search_part_number').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsSearchPartNumber);
    $('.search_part_number').trigger('change');
    $('button[data-id="search_part_number"]').addClass("btn-sm");
    $('#search_part_number').on('changed.bs.select', function(e) {
        $('button[data-id="search_part_number"]').css('background-color','#faffbd');
    });

    // EQUIPMENT
    var optionsSearchEquipment = {
        ajax: {
            url: 'search-items/select-search-equipment',
            type: 'POST',
            dataType: 'json',
        },
        locale: {
            emptyTitle: 'SELECT EQUIPMENT CODE : EQUIPMENT NAME',
            searchPlaceholder: 'SEARCH EQUIPMENT CODE OR EQUIPMENT NAME',
            statusInitialized: 'Start typing search keyword(s)'
        },
        preprocessData: function(data) {
            var i, l = data.length,
                array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text: data[i].equipment_code + ' : ' + data[i].equipment_name,
                        value: data[i].tbl_equipment_code_id,
                    }));
                }
            }
            return array;
        }
    };

    $('.search_equipment').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsSearchEquipment);
    $('.search_equipment').trigger('change');
    $('button[data-id="search_equipment"]').addClass("btn-sm");
    $('#search_equipment').on('changed.bs.select', function(e) {
        $('button[data-id="search_equipment"]').css('background-color','#faffbd');
    });

    // HOLDING
    var optionsSearchHolding = {
        ajax: {
            url: 'search-items/select-search-holding',
            type: 'POST',
            dataType: 'json',
        },
        locale: {
            emptyTitle: 'SELECT HOLDING NAME',
            searchPlaceholder: 'SEARCH HOLDING NAME',
            statusInitialized: 'Start typing search keyword(s)'
        },
        preprocessData: function(data) {
            var i, l = data.length,
                array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text: data[i].holding,
                        value: data[i].tbl_holding_id,
                    }));
                }
            }
            return array;
        }
    };

    $('.search_holding').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsSearchHolding);
    $('.search_holding').trigger('change');
    $('button[data-id="search_holding"]').addClass("btn-sm");
    $('#search_holding').on('changed.bs.select', function(e) {
        $('button[data-id="search_holding"]').css('background-color','#faffbd');
    });

    // COMPANY
    var optionsSearchCompany = {
        ajax: {
            url: 'search-items/select-search-company',
            type: 'POST',
            dataType: 'json',
        },
        locale: {
            emptyTitle: 'SELECT COMPANY',
            statusInitialized: 'Start typing search keyword(s)'
        },
        preprocessData: function(data) {
            var i, l = data.length,
                array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text: data[i].company,
                        value: data[i].tbl_company_id,
                    }));
                }
            }
            return array;
        }
    };

    $('.search_company').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsSearchCompany);
    $('.search_company').trigger('change');
    $('button[data-id="search_company"]').addClass("btn-sm");
    $('#search_company').on('changed.bs.select', function(e) {
        $('button[data-id="search_company"]').css('background-color','#faffbd');
    });

    // PLANT
    var optionsSearchPlant = {
        ajax: {
            url: 'search-items/select-search-plant',
            type: 'POST',
            dataType: 'json',
        },
        locale: {
            emptyTitle: 'SELECT PLANT',
            statusInitialized: 'Start typing search keyword(s)'
        },
        preprocessData: function(data) {
            var i, l = data.length,
                array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text: data[i].plant,
                        value: data[i].tbl_plant_id,
                    }));
                }
            }
            return array;
        }
    };

    $('.search_plant').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsSearchPlant);
    $('.search_plant').trigger('change');
    $('button[data-id="search_plant"]').addClass("btn-sm");
    $('#search_plant').on('changed.bs.select', function(e) {
        $('button[data-id="search_plant"]').css('background-color','#faffbd');
    });

    // PLANT
    var optionsSearchLocation = {
        ajax: {
            url: 'search-items/select-search-location',
            type: 'POST',
            dataType: 'json',
        },
        locale: {
            emptyTitle: 'SELECT LOCATION',
            statusInitialized: 'Start typing search keyword(s)'
        },
        preprocessData: function(data) {
            var i, l = data.length,
                array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text: data[i].location,
                        value: data[i].tbl_location_id,
                    }));
                }
            }
            return array;
        }
    };

    $('.search_location').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsSearchLocation);
    $('.search_location').trigger('change');
    $('button[data-id="search_location"]').addClass("btn-sm");
    $('#search_location').on('changed.bs.select', function(e) {
        $('button[data-id="search_location"]').css('background-color','#faffbd');
    });

    // SHELF
    var optionsSearchShelf = {
        ajax: {
            url: 'search-items/select-search-shelf',
            type: 'POST',
            dataType: 'json',
        },
        locale: {
            emptyTitle: 'SELECT SHELF',
            statusInitialized: 'Start typing search keyword(s)'
        },
        preprocessData: function(data) {
            var i, l = data.length,
                array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text: data[i].shelf,
                        value: data[i].tbl_shelf_id,
                    }));
                }
            }
            return array;
        }
    };

    $('.search_shelf').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsSearchShelf);
    $('.search_shelf').trigger('change');
    $('button[data-id="search_shelf"]').addClass("btn-sm");
    $('#search_shelf').on('changed.bs.select', function(e) {
        $('button[data-id="search_shelf"]').css('background-color','#faffbd');
    });

    // BIN
    var optionsSearchBin = {
        ajax: {
            url: 'search-items/select-search-bin',
            type: 'POST',
            dataType: 'json',
        },
        locale: {
            emptyTitle: 'SELECT BIN',
            statusInitialized: 'Start typing search keyword(s)'
        },
        preprocessData: function(data) {
            var i, l = data.length,
                array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text: data[i].bin,
                        value: data[i].tbl_bin_id,
                    }));
                }
            }
            return array;
        }
    };

    $('.search_bin').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsSearchBin);
    $('.search_bin').trigger('change');
    $('button[data-id="search_bin"]').addClass("btn-sm");
    $('#search_bin').on('changed.bs.select', function(e) {
        $('button[data-id="search_bin"]').css('background-color','#faffbd');
    });

    // USER
    var optionsSearchUser = {
        ajax: {
            url: 'search-items/select-search-user',
            type: 'POST',
            dataType: 'json',
        },
        locale: {
            emptyTitle: 'SELECT USER',
            searchPlaceholder: 'SEARCH USER OR USERNAME',
            statusInitialized: 'Start typing search keyword(s)'
        },
        preprocessData: function(data) {
            var i, l = data.length,
                array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text: data[i].name + ' ( ' + data[i].username + ' )',
                        value: data[i].tbl_user_id,
                    }));
                }
            }
            return array;
        }
    };

    $('.search_user').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsSearchUser);
    $('.search_user').trigger('change');
    $('button[data-id="search_user"]').addClass("btn-sm");
    $('#search_user').on('changed.bs.select', function(e) {
        $('button[data-id="search_user"]').css('background-color','#faffbd');
    });

    $('.bs-searchbox > input.form-control').addClass("input-sm");
    // END OF GLOBAL SEARCH

    $(document).on('click', '#btn_report', function() {
        from = $('#create_report_modal input[name="from"]:checked').val();
        type = $('#create_report_modal input[name="type"]:checked').val();
        generate = $('#create_report_modal input[name="generate"]:checked').val();
        // company = $('select#company').val();        
        company_id = $("#part_master tbody tr.active input.company").val();

        if(from == 1){
            key = hashids.decode($('#part_master tr.active').attr("id"))[0];
            current = 1;
        }else{
            key = hashids.decode($('#key').val())[0];
            current = 0;
        }

        company_id = hashids.decode(company_id)[0];
        keys = [key,current,type,generate,company_id];
        encodedKeys = hashids.encode(keys);

        if(from && type && generate){
            if(company_id){
                $('#report_warn').empty();
                if(generate == 1){
                    window.open('report/'+encodedKeys);
                }else{
                    document.location = 'report/'+encodedKeys;
                }
            }else{
                $('#report_warn').text('Please add a company for this catalog.');
            }
        }else{
            $('#report_warn').html('Make sure you have checked <strong>FROM</strong>, <strong>TYPE</strong> and <strong>GENERATE PDF</strong> option.</checked> ');
        }
    });

    function get_catalog_status(catalog_status_id){
        $.ajax({
            type: 'GET',
            url: 'home/catalog-status/' + catalog_status_id,
            dataType: 'json',
            success: function(data) {
                if (typeof data !== 'undefined' && data.length > 0) {
                    status = '';
                    $.each(data, function(i, item) {
                        if(catalog_status_id == item.tbl_catalog_status_id){
                            checked = 'checked'
                        }else{
                            checked = '';
                        }

                        if(i == 0){
                            color = 'danger';
                        }else if(i == 1){
                            color = 'warning';
                        }else if(i == 2){
                            color = 'success';
                        }else if(i == 3){
                            color = 'primary';
                        }

                        status += '<div class="radio radio-'+color+' radio-inline cat_status_'+item.status.toLowerCase()+'_update">';
                        status += '<input '+checked+' type="radio" id="catStatusRadio'+item.tbl_catalog_status_id+'" value="'+item.tbl_catalog_status_id+'" name="cat_status">';
                        status += '<label for="catStatusRadio'+item.tbl_catalog_status_id+'"> '+item.status+' </label>';
                        status += '</div>';
                    });
                    $('#cat_status_area').html(status);
                    $('#char_box_disabled').remove();
                    $("#characteristic_value_box > tr > td > input").prop( "disabled", false );
                    $("#submit_values").prop( "disabled", true );
                    $('.get-values-list_')
                        .removeClass('get-values-list_')
                        .addClass('get-values-list');

                    $('#classification_edit_btn').html('<kbd id="edit_classification" style="padding:2px 4px 1px !important; position: absolute; right: 10px; top: 5px; z-index: 1;" class="kbd-primary hover cpointer">EDIT</kbd>');
                }
                else{
                    $('#cat_status_area').html('');

                    $('.get-values-list')
                        .removeClass('get-values-list')
                        .addClass('get-values-list_');

                    $('kbd#add-pmc').remove();
                    $('kbd.delete-pmc').remove();
                    $('kbd.edit-pmc').remove();

                    $('#classification_edit_btn').empty();

                    $('kbd#add-pc').remove();
                    $('kbd.delete-pc').remove();
                    $('kbd.edit-pc').remove();

                    $('kbd#add-pec').remove();
                    $('kbd.delete-pec').remove();
                    $('kbd.edit-pec').remove();

                    $('#char_box').append('<div id="char_box_disabled" style="height:22%;width:100%;z-index:10;position:absolute;"></div>');
                    $("#characteristic_value_box > tr > td > input").prop( "disabled", true );
                }

                
            },
        });        
    }

    $(document).ajaxComplete(function(){
        $('input[type=radio][name=cat_status]').change(function() {
            var master_id = $("#part_master tbody tr.active").attr("id");
            var company_id = $("#part_master tbody tr.active .company").val();
            var status_id_label = $(this).next('label').text();
            var status_id = $(this).val();
            var before_changed = $("#cat_status_area").html();
            var status_column = $("table#part_master tr.active td:eq(8)");
            var status_input = $("#part_master tbody tr.active .catalog_status_id");
            $.ajax({
                type: 'POST',
                url: 'home/change-status',
                data: {master_id: master_id, company_id: company_id, status_id: status_id},
                success: function(){
                    status_column.text(status_id_label);
                    status_input.val(status_id);
                },
                error: function(){
                     $("#cat_status_area").html(before_changed);
                }
            }).unbind('change');
        });
    });

    function get_classification(part_master_id){
         $.ajax({
            type: 'GET',
            url: 'home/classification/' + part_master_id,
            dataType: 'json',
            success: function(data) {
                $('#classif_item_type').val(data.item_type);
                $('#classif_stock_type').val(data.stock_type);
                $('#classif_unit_issue').val(data.unit_issue);
                $('#classif_unit_purchase').val(data.unit_purchase);
                $('#conversion').val(data.conversion);
                $('#classif_weight').val(data.weight_value+' '+data.weight_unit);
                $('#classif_avg_unit_price').val(data.average_unit_price);
            },
            error: function(){
                // alert('ERROR');
            }
        });
    }
    $(document).on('click', '#edit_classification', function() {
        $('#edit_classification_modal').modal('show');
    });

    var $select = $('#hashtags').selectize({
        delimiter: ',',
        persist: false,
        create: function(input) {
            var output = input.match(/(\#[a-zA-Z0-9\-\_]+)/g);
            if(jQuery.isEmptyObject(output) == false){
                var output = output.map(function(x){ return x.toLowerCase() });
                return {
                    value: output,
                    text: output
                }
            }else{
                return false;
            }
        },
    });
    $('#hashtags-selectized').css('text-transform', 'lowercase');
    var selectize = $select[0].selectize;

    selectize.on('item_remove', function(value, $item){
        selectize.addOption({value:value,text:value});
        $('#hashtags_on_modal span._'+value.replace(/#/g, '')).remove();
    });

    selectize.on('item_add', function(value, $item){
        tag_item = '<span class="label label-primary cattags pull-left _'+value.replace(/#/g, '')+'">'+value+'</span>';
        $('#hashtags_on_modal').append(tag_item);

        // remove duplicate element
        var seen = {};
        $('#hashtags_on_modal span.cattags').each(function() {
            var txt = $(this).text();
            if (seen[txt])
                $(this).remove();
            else
                seen[txt] = true;
        });
    });

    $(document).on('click', '#hashtags_show_up', function() {
        $('#hashtags_on_modal').empty();
        $('#hashtags_on_inline').clone().appendTo('#hashtags_on_modal');
        var part_master_id = $("#part_master tbody tr.active").attr("id");
        var oh_request = $.ajax({
            url: 'home/option-hashtags/'+ part_master_id,
            type: 'GET',
            dataType: "json",
            success: function(option_data){
                var selectOptions = [];
                for (var index = 0, length = option_data.length; index < length; index++) {
                  var item = option_data[index];
                  selectOptions.push({
                    text  : '#'+item.tag_name.toLowerCase(),
                    value : '#'+item.tag_name.toLowerCase()
                  });
                }

                selectize.clearOptions();
                selectize.renderCache = {};
                selectize.load(function(callback) {
                    callback(selectOptions);
                });

                var uh_request = $.ajax({
                    url: 'home/user-hashtags/'+ part_master_id,
                    type: 'GET',
                    dataType: "json",
                    success: function(user_data){
                        $.each(user_data, function (index, user_value) {
                            selectize.addItem('#'+user_value.tag_name.toLowerCase(), true);
                        });
                        $('#hashtags_modal').modal('show');
                    }
                });
            }
        });
    });

    function catalog_tag(part_master_id) {
        // 1. all hashtags untuk current catalog => tampil
        // 2. all hashtags untuk all catalog => dropdown
        // 3. hashtags by user and current catalog => input
        $.ajax({
            url: 'home/catalog-hashtags/' + part_master_id,
            type: 'GET',
            dataType: "json",
            success: function(cat_data){
                tags = ''
                $.each(cat_data, function (index, cat_value) {
                    tags += '<span class="label label-primary cattags pull-left _'+cat_value.tag_name.toLowerCase()+'">';
                    tags += '#'+cat_value.tag_name.toLowerCase();
                    tags += '</span>';
                });
                $('#hashtags_on_inline').html(tags);
            }
        });
    }

    $(document).on('click', '#save_hashtags', function() {
        var part_master_id = $("#part_master tbody tr.active").attr("id");
        var tags = $('#hashtags').val();
        $.ajax({
            url: 'home/save-hashtags/' + part_master_id,
            type: 'POST',
            data: {tags: tags},
            success: function(cat_data) {
                tags = ''
                $.each(cat_data, function (index, cat_value) {
                    tags += '<span class="label label-primary cattags pull-left _'+cat_value.tag_name.toLowerCase()+'">';
                    tags += '#'+cat_value.tag_name.toLowerCase();
                    tags += '</span>';
                });
                $('#hashtags_on_inline').html(tags);
                $('#hashtags_on_modal').html(tags);
                $('#hashtags_modal').modal('hide');
            }
        })
    });

    // PART DOCUMENT DATATABLES
    var datatable_part_attachment;
    function get_part_attachment(part_master_id) {
        datatable_part_attachment = $('#part_attachment').DataTable({
            destroy: true,
            processing: false,
            serverSide: true,
            ajax: 'home/part-attachment/' + part_master_id,
            columns: [{
                data: 'type',
                name: 'type'
            }, {
                data: 'title',
                name: 'title'
            }, ],
            oLanguage: {
                sLengthMenu: "_MENU_",
                sInfo: "SHOWING _START_ TO _END_ OF _TOTAL_ ENTRIES",
                oPaginate: {
                    sFirst: "FIRST",
                    sLast: "LAST",
                    sNext: "NEXT",
                    sPrevious: "PREVIOUS"
                },
                sSearch: "",
                sSearchPlaceholder: "SEARCH...",
            },
            dom: "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            pageLength: 8,
            drawCallback: function() {
                $('#part_attachment th:last-child')
                    .addClass('cpointer')
                    .empty()
                    .append('TITLE <kbd id="add-pdc" style="padding:2px 4px 1px !important;" class="kbd-primary pull-right cpointer">ADD</kbd>');
            
                var api = this.api();
                var info = api.page.info();
                recordsTotal = info.recordsTotal;
                if ( recordsTotal > 8 ) {
                    $('#part_attachment_info').css('display', 'block');
                    $('#part_attachment_paginate').css('display', 'block');
                }else{
                    $('#part_attachment_info').css('display', 'none');
                    $('#part_attachment_paginate').css('display', 'none');
                }
            }
        });
    }
    // END PART DOCUMENT DATATABLES
    // $(document).ajaxComplete(function() {
    //     $('#characteristic_value_box').bind("DOMSubtreeModified",function(){
    //         console.log('changed');
    //     });
    // });
});