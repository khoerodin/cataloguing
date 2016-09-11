jQuery(function($) {
    // INSERT ELEMENT FOR HANDLEBARS
    $('<div id="navbar"></div><div id="content"></div>').insertAfter('#loading');
    // END INSERT ELEMENT FOR HANDLEBARS

    // HANDLEBARS TEMPLATE
    $('#navbar').html(Settings.templates.navbar());
    $('#content').html(Settings.templates.content());
    // END HANDLEBARS TEMPLATE

    // LOADING
    $(document).ajaxStop(function() {
        $('#loading').hide();
    });
    // END LOADING

    // TAB
    $("#setingsTab a").click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
    // END TAB

    // SCROLL TAB
    var hidWidth;
    var scrollBarWidths = 40;

    var widthOfList = function() {
        var itemsWidth = 0;
        $('.list li').each(function() {
            var itemWidth = $(this).outerWidth();
            itemsWidth += itemWidth;
        });
        return itemsWidth;
    };

    var widthOfHidden = function() {
        return (($('.wrapper').outerWidth()) - widthOfList() - getLeftPosi()) - scrollBarWidths;
    };

    var getLeftPosi = function() {
        return $('.list').position().left;
    };

    var reAdjust = function() {
        if (($('.wrapper').outerWidth()) < widthOfList()) {
            $('.scroller-right').show();
        } else {
            $('.scroller-right').hide();
        }

        if (getLeftPosi() < 0) {
            $('.scroller-left').show();
        } else {
            $('.item').animate({
                left: "-=" + getLeftPosi() + "px"
            }, 'slow');
            $('.scroller-left').hide();
        }
    }

    reAdjust();

    $(window).on('resize', function(e) {
        reAdjust();
    });

    $('.scroller-right').click(function() {

        $('.scroller-left').fadeIn('slow');
        $('.scroller-right').fadeOut('slow');

        $('.list').animate({
            left: "+=" + widthOfHidden() + "px"
        }, 'slow', function() {

        });
    });

    $('.scroller-left').click(function() {

        $('.scroller-right').fadeIn('slow');
        $('.scroller-left').fadeOut('slow');

        $('.list').animate({
            left: "-=" + getLeftPosi() + "px"
        }, 'slow', function() {

        });
    });
    // END SCROLL TAB

    // FILTER TOP
    // Filter INC
    var optionsInc = {
        ajax: {
            url: 'settings/select-inc',
            type: 'POST',
            dataType: 'json',
        },
        locale: {
            emptyTitle: 'SELECT INC : ITEM NAME',
            searchPlaceholder: 'SEARCH INC OR ITEM NAME'
        },
        preprocessData: function(data) {
            var i, l = data.length,
                array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text: data[i].inc + ' : ' + data[i].item_name,
                        value: data[i].id,
                    }));
                }
            }
            return array;
        }
    };

    // for global characteristic value
    $('.global_inc').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsInc);
    $('.global_inc').trigger('change');
    $('button[data-id="global_inc"]').addClass("btn-sm");
    // end for global characteristic value

    $('.inc').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsInc);
    $('.inc').trigger('change');
    $('button[data-id="inc"]').addClass("btn-sm");

    $('.bs-searchbox > input.form-control').addClass("input-sm");

    // Filter Holding
    var optionsHolding = {
        ajax: {
            url: 'settings/select-holding',
            type: 'POST',
            dataType: 'json',
        },
        locale: {
            emptyTitle: 'SELECT HOLDING',
        },
        preprocessData: function(data) {
            var i, l = data.length,
                array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text: data[i].holding,
                        value: data[i].id,
                    }));
                }
            }
            return array;
        }
    };
    $('.holding').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsHolding);
    $('.holding').trigger('change');
    $('button[data-id="holding"]').addClass("btn-sm");
    $('.bs-searchbox > input.form-control').addClass("input-sm");

    var selectCompany = '<div class="btn-group bootstrap-select disabled company with-ajax" style="width: 100%;">';
    selectCompany += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="company" tabindex="-1" title="SELECT COMPANY"><span class="filter-option pull-left">SELECT COMPANY</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
    selectCompany += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
    selectCompany += '<select id="company" class="company with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="SELECT COMPANY"><option class="bs-title-option" value="">SELECT COMPANY</option></select>';
    selectCompany += '</div>';
    $("#select_company").html(selectCompany);

    // Revert characteristic box to placeholder
    function getGlobalCharPlaceholder(){
        charPlaceholder  = '<div class="col-xs-6">';
        charPlaceholder += '<div style="height:328px;margin-top:10px;background-color:#F1F4F8;"></div>';
        charPlaceholder += '</div>';
        $("#global-char-area").empty().append(charPlaceholder);
    } 
    function getCompanyCharPlaceholder(){
        charPlaceholder  = '<div class="col-xs-6">';
        charPlaceholder += '<div style="height:328px;margin-top:10px;background-color:#F1F4F8;"></div>';
        charPlaceholder += '</div>';
        $("#company-char-area").empty().append(charPlaceholder);
    }    
    // End revert characteristic box to placeholder

    // Revert value box to placeholder
    function getGlobalValPlaceholder(){
        valPlaceholder  = '<div class="col-xs-6">';
        valPlaceholder += '<div style="height:328px;margin-top:10px;background-color:#F1F4F8;"></div>';
        valPlaceholder += '</div>';
        $("#global-val-area").empty().append(valPlaceholder);
    }
    // End revert value box to placeholder

    // START GLOBAL CHARACTERISIC VALUE TAB
    // ============================================================
    // ============================================================
    $(document).ajaxComplete(function() {
        // Changed INC
        $('#global_inc').off('changed.bs.select');
        $('#global_inc').on('changed.bs.select', function() {
            getGlobalValPlaceholder();
            getGlobalCharacteristicsList();
        });
        // End Changed INC

        // characteristic row click 
        $(document).off('click', 'tbody#global_char_table tr');
        $(document).on('click', 'tbody#global_char_table tr', function() {
            $("tbody#global_char_table tr:first-child").removeClass('active');
            $("tbody#global_char_table tr").removeClass('active');
            $(this).addClass('active');
            id = $(this).attr('id');
            getGlobalCharValues(id);
        });
        // end characteristic row click
    });

    function getGlobalCharacteristicsList(bool) {
        var globalIncId = $("#global_inc").val();

        if (globalIncId){
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "settings/get-global-characteristics/" + globalIncId,
                success: function(data) {
                    globalCharsTable  = '<div class="col-xs-6">';
                    globalCharsTable += '<table class="table table-striped table-char-settings">';
                    globalCharsTable += '<thead><th>#</th><th>CHARACTERISICS';
                    globalCharsTable += '<span id="global-char-button" class="pull-right">';
                    globalCharsTable += '<kbd id="add-char" class="kbd-primary cpointer">ADD</kbd>';
                    globalCharsTable += '</span>';
                    globalCharsTable += '</th></thead><tbody id="global_char_table">';

                    globalOldOrder = [];
                    $.each(data, function(i, item) {
                        globalCharsTable += '<tr id="'+item.id+'"><td>';
                        globalCharsTable += '<input class="global_lic_id" name="global_lic_id[]" type="hidden" value="' + item.id + '">';
                        globalCharsTable += i + 1;
                        globalCharsTable += '</td><td>' + item.characteristic + '</td></tr>';

                        // save oldOrder temporary
                        globalOldOrder.push(i + 1);
                    });
                    globalCharsTable += '</tbody></table></div>';
                    $("#global-char-area").empty().append(globalCharsTable);
                    // for reset order
                    globalCache = $("#global_char_table").html();

                    if(bool == 1){
                        sequenceSavedMessage  = '<span class="text-primary animated fadeOut updated">Sequence updated</span>';
                        sequenceSavedMessage += '&nbsp;<kbd id="add-char" class="kbd-primary cpointer">ADD</kbd>';
                        $("#global-char-button").empty().append(sequenceSavedMessage);
                    }                
                }
            });
        }else{
            getGlobalCharPlaceholder();
            getGlobalValPlaceholder();
        }
    }

    function getGlobalCharValues(linkIncCharacteristicId) {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "settings/get-global-characteristics-values/" + linkIncCharacteristicId,
            success: function(data) {
                echo  = '<div class="col-xs-6">';
                echo += '<table class="table table-striped">';
                echo += '<thead><tr><th style="width:5%;">#</th>';
                echo += '<th style="width:45%;">VALUES</th>';
                echo += '<th style="width:35%;">ABBREV</th>';
                echo += '<th style="width:15%;">APPROVED</th></tr></thead>';
                echo += '<tbody id="global_val_table">';
                $.each(data, function(i, item) {
                    echo += '<tr><td>';
                    echo += i + 1;
                    echo += '</td><td>' + item.value + '</td>';
                    echo += '</td><td>' + item.abbrev + '</td>';
                    echo += '</td><td>' + item.approved + '</td></tr>';
                });
                echo += '</tbody></table></div>';

                $("#global-val-area").empty().append(echo);
            }
        });
    }

    // sortabe
    $(document).ajaxComplete(function(){
        $("#global_char_table").sortable({
            items: "tr",
            cursor: 'move',
            opacity: 0.6,
            update: function() {
                globalNewOrder = $("#global_char_table").sortable("toArray");
                if(globalOldOrder.equals(globalNewOrder) == false){
                    button  = '<kbd id="reset-global-char-order" class="kbd-default cpointer">RESET</kbd>';
                    button += '&nbsp;<kbd id="update-global-char-order" class="kbd-primary cpointer">UPDATE</kbd>';
                    $('#global-char-button').html(button);
                }else{
                    $('#global-char-button').empty();
                }
            }
        });
    });

    $("#global_char_table").sortable({
        helper: fixHelper,
    });
    // end sortable

    // reset global char order
    $(document).on('click', '#reset-global-char-order', function() {
        $("#global_char_table").html(globalCache);
        $('#global-char-button').html('<kbd id="add-char" class="kbd-primary cpointer">ADD</kbd>');
        getGlobalValPlaceholder();
    });    
    // end reset global char order

    // update global char order
    $(document).on('click', '#update-global-char-order', function() {
        var global_lic_id = []
        $("input.global_lic_id").each(function (){
            global_lic_id.push(parseInt($(this).val()));
        });

        $.ajax({ 
            type: "PUT",
            url: 'settings/update-gcharacteristics-order',
            data: {'lic': global_lic_id},
            success: function() {
                getGlobalValPlaceholder();
                getGlobalCharacteristicsList(1);                
            },
            error: function(){
                button  = '<span class="text-danger not-updated">Sequence not updated</span>&nbsp;';
                button += '<kbd id="reset-global-char-order" class="kbd-default cpointer">RESET</kbd>';
                button += '&nbsp;<kbd id="update-global-char-order" class="kbd-primary cpointer">UPDATE</kbd>';
                $('#global-char-button').html(button);
            }
        });
    });    
    // end update global char order

    // ADD CHARACTERISIC MODAL
    $(document).on('click', '#add-char', function() {
        var globalIncId = $("#global_inc").val();
        $.ajax({ 
            type: "GET",
            url: 'settings/characteristic-to-be-added/' + globalIncId,
            dataType: 'json',
            success: function(data) {
                tr = '';
                $.each(data, function(i, item) {
                    tr += '<tr><td>';
                    tr += i + 1;
                    tr += '</td><td>'+item.characteristic;
                    tr += '<kbd id="#" class="kbd-primary pull-right cpointer">ADD</kbd>';
                    tr += '</td></tr>';
                });
                $("#add-char-table").empty().append(tr);

                inc = $('div.global_inc.with-ajax button').attr('title');
                $('#item_name').text(inc);
                $('#add_characteristic_modal').modal('show');           
            },
            error: function(){
                
            }
        });
    });
    // END ADD CHARACTERISIC MODAL

    // END GLOBAL CHARACTERISIC VALUE TAB
    // ============================================================
    // ============================================================
    


    // START COMPANY CHARACTERISIC VALUE TAB
    // ============================================================
    // ============================================================

    $(document).ajaxComplete(function() {

        // Changed INC
        $('#inc').off('changed.bs.select');
        $('#inc').on('changed.bs.select', function() {
            getCompanyCharacteristicsList();
        });
        // End Changed INC

        // Changed Holding
        $('#holding').on('changed.bs.select', function(e) {
            $('#select_company').html('<select id="company" class="company with-ajax" data-live-search="true" data-width="100%"></select>');
            getCompanyCharPlaceholder();

            var holdingId = $(this).val();
            var optionsCompany = {
                ajax: {
                    url: 'settings/select-company/' + holdingId,
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
            $('.company').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsCompany);
            $('.company').trigger('change');
            $('button[data-id="company"]').addClass("btn-sm");
            $('.bs-searchbox > input.form-control').addClass("input-sm");
        });
        // End Changed Holding  

        // Changed Company
        $('#company').off('changed.bs.select');
        $('#company').on('changed.bs.select', function() {
            getCompanyCharacteristicsList();
        });
        // End Changed Company
    });

    function getCompanyCharacteristicsList(bool) {
        var incId = $("#inc").val();
        var companyId = $("#company").val();

        if (incId && companyId){
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "settings/get-company-characteristics/" + incId + "/" + companyId,
                success: function(data) {
                    charsTable  = '<div class="col-xs-6">';
                    charsTable += '<table class="table table-striped table-char-settings">';
                    charsTable += '<thead><th>#</th><th>CHARACTERISICS';
                    charsTable += '<span id="company-char-button" class="pull-right"></span>';
                    charsTable += '</th></thead><tbody id="company_char_table">';

                    oldOrder = [];
                    $.each(data, function(i, item) {
                        charsTable += '<tr id="'+item.link_inc_characteristic_id+'"><td>';
                        charsTable += '<input class="company_lic_id" name="company_lic_id[]" type="hidden" value="' + item.link_inc_characteristic_id + '">';
                        charsTable += i + 1;
                        charsTable += '</td><td>' + item.characteristic + '</td></tr>';

                        // save oldOrder temporary
                        oldOrder.push(i + 1);
                    });
                    charsTable += '</tbody></table></div>';
                    $("#company-char-area").empty().append(charsTable);
                    // for reset order
                    cache = $("#company_char_table").html();

                    if(bool == 1){
                        sequenceSavedMessage = '<span class="text-primary animated fadeOut updated">Sequence updated</span>';
                        $("#company-char-button").empty().append(sequenceSavedMessage);
                    }                
                }
            });
        }else{
            getCompanyCharPlaceholder();
        }
    }

    // sortabe
    $(document).ajaxComplete(function(){
        $("#company_char_table").sortable({
            items: "tr",
            cursor: 'move',
            opacity: 0.6,
            update: function() {
                newOrder = $("#company_char_table").sortable("toArray");
                if(oldOrder.equals(newOrder) == false){
                    button  = '<kbd id="reset-company-char-order" class="kbd-default cpointer">RESET</kbd>';
                    button += '&nbsp;<kbd id="update-company-char-order" class="kbd-primary cpointer">UPDATE</kbd>';
                    $('#company-char-button').html(button);
                }else{
                    $('#company-char-button').empty();
                }
            }
        });
    });

    $("#company_char_table").sortable({
        helper: fixHelper,
    });
    // end sortable

    // reset company char order
    $(document).on('click', '#reset-company-char-order', function() {
        $("#company_char_table").html(cache);
        $('#company-char-button').empty();
    });    
    // end reset company char order

    // update company char order
    $(document).on('click', '#update-company-char-order', function() {
        var company_lic_id = []
        $("input.company_lic_id").each(function (){
            company_lic_id.push(parseInt($(this).val()));
        });

        $.ajax({ 
            type: "PUT",
            url: 'settings/update-ccharacteristics-order',
            data: {'company': $('select#company').val(), 'lic': company_lic_id},
            success: function() {
                getCompanyCharacteristicsList(1);                
            },
            error: function(){
                console.log(false);
            }
        });
    });    
    // end update company char order

    // END COMPANY CHARACTERISIC VALUE TAB
    // ============================================================
    // ============================================================

    // START CATALOG STATUS TAB
    // ============================================================
    // ============================================================
    var datatable_catalog_status_tab;
    $(document).ready(function() {

        datatable_catalog_status_tab = $('#catalog_status_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'settings/datatables-catalog-status',
            },
            columns: [{
                data: 'rownum',
                name: 'rownum',
                searchable: false
            }, {
                data: 'created_at',
                name: 'created_at',
                searchable: false
            }, {
                data: 'status',
                name: 'status'
            }, {
                data: 'description',
                name: 'description'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
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
                "sSearch": "",
                "sSearchPlaceholder": "SEARCH",
            },
            columnDefs: [{
                "targets": [1],
                "visible": false,
            }, ],
            order: [
                [1, 'desc']
            ]
        });

        $("select.form-control").selectpicker();
        $("div.dataTables_length > label > div.btn-group > button").addClass("btn-sm");

        // Right Click Datatables Catalog Status Tab
        new BootstrapMenu('table#catalog_status_table', {
            actions: [{
                name: 'REFRESH CATALOG STATUS DATA',
                onClick: function() {
                    datatable_catalog_status_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Datatables Catalog Status Tab
    });

    // Reload Catalog Status DataTables
    function reload_catalog_status_table() {
        datatable_catalog_status_tab.ajax.reload(null, false);
    }
    // End Reload Catalog Status DataTables

    // Add Catalog Status
    $(document).on('click', '#add-cs', function() {
        $('#btn_save_catalog_status_tab_modal').val("SAVE").removeAttr("disabled");
        $('#catalog_status_tab_modal_title').text("ADD CATALOG STATUS");
        $('#catalog_status_tab_modal').modal('show');
    });
    // End Add Catalog Status

    // Edit Catalog Status
    $(document).on('click', '.edit-cs', function() {
        id = $(this).attr('data-id');

        var status = $("table#catalog_status_table tr#" + id + " td:eq(1)").html();
        var description = $("table#catalog_status_table tr#" + id + " td:eq(2)").html();

        $('#catalog_status_catalog_status_tab_modal').val(status);
        $('#desc_catalog_status_tab_modal').val(description);
        $('#id_catalog_status_tab_modal').val(id);

        $('#btn_save_catalog_status_tab_modal').val("UPDATE").removeAttr("disabled");
        $('#catalog_status_tab_modal_title').text("EDIT CATALOG STATUS");
        $('#ajax_process_modal').modal('hide');
        $('#catalog_status_tab_modal').modal('show');
    });
    // End Edit Catalog Status

    // Press Enter catalog_status_tab_modal
    $("#catalog_status_tab_modal").keypress(function(e) {
        switch (e.which) {
            case 13:
                $("#btn_save_catalog_status_tab_modal").trigger("click");
                break;
        }
    });
    // End Press Enter catalog_status_tab_modal

    // Save Catalog Status
    $("#btn_save_catalog_status_tab_modal").click(function() {
        var formData = {
            status: $('#catalog_status_catalog_status_tab_modal').val().trim(),
            description: $('#desc_catalog_status_tab_modal').val().trim(),
            created_by: $('#logged_in_user').val(),
            last_updated_by: $('#logged_in_user').val(),
        }

        var state = $('#btn_save_catalog_status_tab_modal').val();
        var type = "POST";
        var url = 'settings/add-catalog-status';
        var id = $('#id_catalog_status_tab_modal').val();

        if (state == "UPDATE") {
            type = "PUT";
            url = 'settings/update-catalog-status/' + id;
        }

        $.ajax({
            type: type,
            url: url,
            data: formData,
            dataType: 'json',
            beforeSend: function(data) {
                $("#catalog_status_tab_modal :input").prop('disabled', true);
                $(".error_saving_catalog_status_tab_modal").hide();
                $(".error_updating_catalog_status_tab_modal").hide();

                if (state == "SAVE") {
                    $(".saving_catalog_status_tab_modal").show();
                } else {
                    $(".updating_catalog_status_tab_modal").show();
                }

                $("#input_catalog_status_catalog_status_tab_modal").removeClass("has-error");
                $("#catalog_status_catalog_status_tab_modal + p.help-block").text("");

                $("#input_desc_catalog_status_tab_modal").removeClass("has-error");
                $("#desc_catalog_status_tab_modal + p.help-block").text("");
            },
            success: function(data) {
                $('#catalog_status_tab_modal_form').trigger("reset");
                $(".saving_catalog_status_tab_modal").hide();
                $(".updating_catalog_status_tab_modal").hide();

                $('#catalog_status_tab_modal').modal('hide');
                reload_catalog_status_table();
                $("#catalog_status_tab_modal :input").prop('disabled', false);

                $("#input_catalog_status_catalog_status_tab_modal").removeClass("has-error");
                $("#catalog_status_catalog_status_tab_modal + p.help-block").text("");

                $("#input_desc_catalog_status_tab_modal").removeClass("has-error");
                $("#desc_catalog_status_tab_modal + p.help-block").text("");
            },
            error: function(data) {
                $(".saving_catalog_status_tab_modal").hide();
                $(".updating_catalog_status_tab_modal").hide();
                if (state == "SAVE") {
                    $(".error_saving_catalog_status_tab_modal").show();
                } else {
                    $(".error_updating_catalog_status_tab_modal").show();
                }
                $("#catalog_status_tab_modal :input").prop('disabled', false);
                var errors = data.responseJSON;

                if (errors.status) {
                    $("#input_catalog_status_catalog_status_tab_modal").addClass("has-error");
                    $("#catalog_status_catalog_status_tab_modal + p.help-block").text(errors.status);
                } else {
                    $("#input_catalog_status_catalog_status_tab_modal").removeClass("has-error");
                    $("#catalog_status_catalog_status_tab_modal + p.help-block").text("");
                }

                if (errors.description) {
                    $("#input_desc_catalog_status_tab_modal").addClass("has-error");
                    $("#desc_catalog_status_tab_modal + p.help-block").text(errors.description);
                } else {
                    $("#input_desc_catalog_status_tab_modal").removeClass("has-error");
                    $("#desc_catalog_status_tab_modal + p.help-block").text("");
                }
            }
        });
    });
    // End Save Catalog Status

    // Delete Catalog Status
    $(document).on('click', '.delete-cs', function() {
        id = $(this).attr('data-id');

        var status = $("table#catalog_status_table tr#" + id + " td:eq(1)").html();
        var description = $("table#catalog_status_table tr#" + id + " td:eq(2)").html();
        var msg = "<table class=\"table table-striped\">";
        msg += "<thead><tr><th>STATUS</th><th>DESCRIPTION</th></thead>";
        msg += "<tbody><tr><td>" + status + "</td><td>" + description + "</td></tr></tbody>";
        msg += "</table>";

        bootbox.dialog({
            message: msg,
            title: "Are you sure you want to delete this Catalog Status?",
            buttons: {
                success: {
                    label: "YES DELETE",
                    className: "btn-danger btn-sm",
                    callback: function() {
                        $.ajax({
                            type: "DELETE",
                            url: 'settings/delete-catalog-status/' + id,
                            beforeSend: function() {},
                            success: function() {
                                reload_catalog_status_table();
                            },
                            error: function() {
                                alert('Cannot delete this Catalog Status.');
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
    // End Delete Catalog Status

    // Catalog Status Modal hide
    $('#catalog_status_tab_modal').on('hide.bs.modal', function(e) {
        $(".error_saving_catalog_status_tab_modal").hide();
        $(".error_updating_catalog_status_tab_modal").hide();

        $("#input_catalog_status_catalog_status_tab_modal").removeClass("has-error");
        $("#catalog_status_catalog_status_tab_modal + p.help-block").text("");

        $("#input_desc_catalog_status_tab_modal").removeClass("has-error");
        $("#desc_catalog_status_tab_modal + p.help-block").text("");

        $('#catalog_status_tab_modal_form').trigger("reset");
    });
    // End Catalog Status Modal Hide

    // END CATALOG STATUS TAB
    // ============================================================
    // ============================================================




    // START EQUIPMENT CODE TAB
    // ============================================================
    // ============================================================

    var datatable_equipment_code_tab;
    $("#equipment_code_tab").one("click", function() {

        datatable_equipment_code_tab = $('#equipment_code_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'settings/datatables-equipment-code',
                data: function(d) {
                    d.holdingId = $('#holding_equipment_code_tab').val();
                    d.companyId = $('#company_equipment_code_tab').val();
                    d.plantId = $('#plant_equipment_code_tab').val();
                },
            },
            columns: [{
                data: 'rownum',
                name: 'rownum',
                searchable: false
            }, {
                data: 'created_at',
                name: 'created_at',
                searchable: false
            }, {
                data: 'equipment_code',
                name: 'tbl_equipment_code.equipment_code'
            }, {
                data: 'equipment_name',
                name: 'tbl_equipment_code.equipment_name'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
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
                "sSearch": "",
                "sSearchPlaceholder": "SEARCH",
            },
            dom: "<'row'<'col-sm-4'l>f>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            columnDefs: [{
                "targets": [1],
                "visible": false,
            }, ],
            order: [
                [1, 'desc']
            ]
        });

        $("select.form-control").selectpicker();
        $("div.dataTables_length > label > div.btn-group > button").addClass("btn-sm");

        var filterEquipmentCode = '<div class="col-sm-2" id="select_holding_equipment_code_tab">';
        filterEquipmentCode += '<select id="holding_equipment_code_tab" class="holding-equipment-code-tab with-ajax" data-live-search="true" data-width="100%"></select>';
        filterEquipmentCode += '</div>';

        filterEquipmentCode += '<div class="col-sm-2" id="select_company_equipment_code_tab">';
        filterEquipmentCode += '<select id="company_equipment_code_tab" class="company-equipment-code-tab with-ajax" data-live-search="true" data-width="100%" disabled></select>';
        filterEquipmentCode += '</div>';

        filterEquipmentCode += '<div class="col-sm-2" id="select_plant_equipment_code_tab">';
        filterEquipmentCode += '<select id="plant_equipment_code_tab" class="plant-equipment-code-tab with-ajax" data-live-search="true" data-width="100%" disabled></select>';
        filterEquipmentCode += '</div>';


        $(filterEquipmentCode).insertBefore("#equipment_code_table_filter");
        $('#equipment_code_table_filter').addClass('col-sm-2').css("padding-left", "0px");

        // FILTER TOP Equipment Code Tab
        // Filter Holding Top Location Tab
        var optionsHoldingEquipmentCodeTab = {
            ajax: {
                url: 'settings/select-holding',
                type: 'POST',
                dataType: 'json',
            },
            locale: {
                emptyTitle: 'ALL HOLDING',
                statusInitialized: 'Start typing...'
            },
            preprocessData: function(data) {
                var i, l = data.length,
                    array = [];
                if (l) {
                    for (i = 0; i < l; i++) {
                        array.push($.extend(true, data[i], {
                            text: data[i].holding,
                            value: data[i].id,
                        }));
                    }
                }
                return array;
            }
        };
        $('.holding-equipment-code-tab').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsHoldingEquipmentCodeTab);
        $('.holding-equipment-code-tab').trigger('change');

        $('button[data-id="holding_equipment_code_tab"]').addClass("btn-sm");

        var companySelect = '<div class="btn-group bootstrap-select disabled company-equipment-code-tab with-ajax" style="width: 100%;">';
        companySelect += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="company_equipment_code_tab" tabindex="-1" title="ALL COMPANY"><span class="filter-option pull-left">ALL COMPANY</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
        companySelect += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
        companySelect += '<select id="company_equipment_code_tab" class="company-equipment-code-tab with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="ALL COMPANY"><option class="bs-title-option" value="">ALL COMPANY</option></select>';
        companySelect += '</div>';
        $("#select_company_equipment_code_tab").html(companySelect);

        var plantSelect = '<div class="btn-group bootstrap-select disabled plant-equipment-code-tab with-ajax" style="width: 100%;">';
        plantSelect += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="plant_equipment_code_tab" tabindex="-1" title="ALL PLANT"><span class="filter-option pull-left">ALL PLANT</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
        plantSelect += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
        plantSelect += '<select id="plant_equipment_code_tab" class="plant-equipment-code-tab with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="ALL PLANT"><option class="bs-title-option" value="">ALL PLANT</option></select>';
        plantSelect += '</div>';
        $("#select_plant_equipment_code_tab").html(plantSelect);
        // End Filter Holding Top Equipment Code Tab

        $(document).ajaxComplete(function() {
            // Changed Holding Top Equipment Code Tab
            $('#holding_equipment_code_tab').on('changed.bs.select', function(e) {
                $('#select_company_equipment_code_tab').html('<select id="company_equipment_code_tab" class="company-equipment-code-tab with-ajax" data-live-search="true" data-width="100%"></select>');

                var plantSelect = '<div class="btn-group bootstrap-select disabled plant-equipment-code-tab with-ajax" style="width: 100%;">';
                plantSelect += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="plant_equipment_code_tab" tabindex="-1" title="ALL PLANT"><span class="filter-option pull-left">ALL PLANT</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
                plantSelect += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
                plantSelect += '<select id="plant_equipment_code_tab" class="plant-equipment-code-tab with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="ALL PLANT"><option class="bs-title-option" value="">ALL PLANT</option></select>';
                plantSelect += '</div>';
                $("#select_plant_equipment_code_tab").html(plantSelect);

                var holdingId = $(this).val();
                var optionsCompanyEquipmentCodeTab = {
                    ajax: {
                        url: 'settings/select-company/' + holdingId,
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'ALL COMPANY',
                        statusInitialized: 'Start typing...'
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
                $('.company-equipment-code-tab').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsCompanyEquipmentCodeTab);
                $('.company-equipment-code-tab').trigger('change');
                $('button[data-id="company_equipment_code_tab"]').addClass("btn-sm");
                datatable_equipment_code_tab.ajax.reload(null, false).unbind();
            });
            // End Changed Holding Top Equipment Code Tab

            // Changed Company Top Equipment Code Tab
            $('#company_equipment_code_tab').on('changed.bs.select', function(e) {
                $('#select_plant_equipment_code_tab').html('<select id="plant_equipment_code_tab" class="plant-equipment-code-tab with-ajax" data-live-search="true" data-width="100%"></select>');

                var companyId = $(this).val();
                var optionsPlantEquipmentCodeTab = {
                    ajax: {
                        url: 'settings/select-plant/' + companyId,
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'ALL PLANT',
                        statusInitialized: 'Start typing...'
                    },
                    preprocessData: function(data) {
                        var i, l = data.length,
                            array = [];
                        if (l) {
                            for (i = 0; i < l; i++) {
                                array.push($.extend(true, data[i], {
                                    text: data[i].plant,
                                    value: data[i].id,
                                }));
                            }
                        }
                        return array;
                    }
                };
                $('.plant-equipment-code-tab').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsPlantEquipmentCodeTab);
                $('.plant-equipment-code-tab').trigger('change');
                $('button[data-id="plant_equipment_code_tab"]').addClass("btn-sm");
                datatable_equipment_code_tab.ajax.reload(null, false).unbind();
            });
            // End Changed Company Top Equipment Code Tab

            // Changed Plant Top Equipment Code Tab
            $('#plant_equipment_code_tab').on('changed.bs.select', function(e) {
                datatable_equipment_code_tab.ajax.reload(null, false).unbind();
            });
            // End Changed Plant Top Equipment Code Tab

        });

        // Right Click Holding Filter Top Equipment Code Tab
        new BootstrapMenu('button[data-id="holding_equipment_code_tab"]', {
            actions: [{
                name: 'SELECT ALL HOLDING',
                onClick: function() {
                    if ($('#holding_equipment_code_tab').prop('disabled') == false) {
                        $('#holding_equipment_code_tab').val([]);
                        $('#holding_equipment_code_tab').trigger('change.abs.preserveSelected');
                        $('#holding_equipment_code_tab').selectpicker('refresh');
                        $('#holding_equipment_code_tab').trigger("click");
                    }

                    if ($('#company_equipment_code_tab').prop('disabled') == false) {
                        $('#company_equipment_code_tab').val([]);
                        $('#company_equipment_code_tab').prop('disabled', true);
                        $('#company_equipment_code_tab').trigger('change.abs.preserveSelected');
                        $('#company_equipment_code_tab').selectpicker('refresh');
                        $('#company_equipment_code_tab').trigger("click");
                    }

                    if ($('#plant_equipment_code_tab').prop('disabled') == false) {
                        $('#plant_equipment_code_tab').val([]);
                        $('#plant_equipment_code_tab').prop('disabled', true);
                        $('#plant_equipment_code_tab').trigger('change.abs.preserveSelected');
                        $('#plant_equipment_code_tab').selectpicker('refresh');
                        $('#plant_equipment_code_tab').trigger("click");
                    }
                    datatable_equipment_code_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Holding Filter Top Equipment Code Tab

        // Right Click Company Filter Top Equipment Code Tab
        new BootstrapMenu('button[data-id="company_equipment_code_tab"]', {
            actions: [{
                name: 'SELECT ALL COMPANY',
                onClick: function() {

                    if ($('#company_equipment_code_tab').prop('disabled') == false) {
                        $('#company_equipment_code_tab').val([]);
                        $('#company_equipment_code_tab').prop('disabled', true);
                        $('#company_equipment_code_tab').trigger('change.abs.preserveSelected');
                        $('#company_equipment_code_tab').selectpicker('refresh');
                        $('#company_equipment_code_tab').trigger("click");
                    }

                    if ($('#plant_equipment_code_tab').prop('disabled') == false) {
                        $('#plant_equipment_code_tab').val([]);
                        $('#plant_equipment_code_tab').prop('disabled', true);
                        $('#plant_equipment_code_tab').trigger('change.abs.preserveSelected');
                        $('#plant_equipment_code_tab').selectpicker('refresh');
                        $('#plant_equipment_code_tab').trigger("click");
                    }
                    datatable_equipment_code_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Company Filter Top Equipment Code Tab

        // Right Click Plant Filter Top Equipment Code Tab
        new BootstrapMenu('button[data-id="plant_equipment_code_tab"]', {
            actions: [{
                name: 'SELECT ALL PLANT',
                onClick: function() {

                    if ($('#plant_equipment_code_tab').prop('disabled') == false) {
                        $('#plant_equipment_code_tab').val([]);
                        $('#plant_equipment_code_tab').prop('disabled', true);
                        $('#plant_equipment_code_tab').trigger('change.abs.preserveSelected');
                        $('#plant_equipment_code_tab').selectpicker('refresh');
                        $('#plant_equipment_code_tab').trigger("click");
                    }
                    datatable_equipment_code_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Plant Filter Top Equipment Code Tab

        // Right Click Datatables Equipment Code Tab
        new BootstrapMenu('table#equipment_code_table', {
            actions: [{
                name: 'REFRESH EQUIPMENT CODE DATA',
                onClick: function() {
                    datatable_equipment_code_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Datatables Equipment Code Tab
    });

    // Reload Equipment Code DataTables
    function reload_equipment_code_table() {
        datatable_equipment_code_tab.ajax.reload(null, false);
    }
    // End Reload Location Equipment Code

    // Add Equipment Code
    $(document).on('click', '#add-eq', function() {
        var optionsHoldingEquipmentCodeTabModal = {
            ajax: {
                url: 'settings/select-holding',
                type: 'POST',
                dataType: 'json',
            },
            locale: {
                emptyTitle: 'SELECT HOLDING',
            },
            preprocessData: function(data) {
                var i, l = data.length,
                    array = [];
                if (l) {
                    for (i = 0; i < l; i++) {
                        array.push($.extend(true, data[i], {
                            text: data[i].holding,
                            value: data[i].id,
                        }));
                    }
                }
                return array;
            }
        };

        $('.holding-equipment-code-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsHoldingEquipmentCodeTabModal);
        $('.holding-equipment-code-tab-modal').trigger('change');
        $('button[data-id="holding_equipment_code_tab_modal"]').addClass("btn-sm");
        $('.bs-searchbox > input.form-control').addClass("input-sm");

        var companySelectModal = '<div class="btn-group bootstrap-select disabled company-equipment-code-tab-modal with-ajax" style="width: 100%;">';
        companySelectModal += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="company_equipment_code_tab_modal" tabindex="-1" title="SELECT COMPANY"><span class="filter-option pull-left">SELECT COMPANY</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
        companySelectModal += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
        companySelectModal += '<select id="company_equipment_code_tab_modal" class="company-equipment-code-tab-modal with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="SELECT COMPANY"><option class="bs-title-option" value="">SELECT COMPANY</option></select>';
        companySelectModal += '</div>';
        $("#select_company_equipment_code_tab_modal").html(companySelectModal);

        var plantSelectModal = '<div class="btn-group bootstrap-select disabled plant-equipment-code-tab-modal with-ajax" style="width: 100%;">';
        plantSelectModal += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="plant_equipment_code_tab_modal" tabindex="-1" title="SELECT PLANT"><span class="filter-option pull-left">SELECT PLANT</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
        plantSelectModal += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
        plantSelectModal += '<select id="plant_equipment_code_tab_modal" class="plant-equipment-code-tab-modal with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="SELECT PLANT"><option class="bs-title-option" value="">SELECT PLANT</option></select>';
        plantSelectModal += '</div>';
        $("#select_plant_equipment_code_tab_modal").html(plantSelectModal);

        $('#btn_save_equipment_code_tab_modal').val("SAVE").prop("disabled", false);
        $('#equipment_code_tab_modal_title').text("ADD EQUIPMENT CODE");
        $('#equipment_code_tab_modal').modal('show');
    });
    // End Add Equipment Code

    // Edit Equipment Code
    $(document).on('click', '.edit-eq', function() {
        id = $(this).attr('data-id');

        $.ajax({
            url: 'settings/edit-equipment-code/' + id,
            type: 'GET',
            beforeSend: function() {
                $('#ajax_process_modal').modal('show');
            },
            success: function(data) {
                var optionsHoldingEquipmentCodeTabModal = {
                    ajax: {
                        url: 'settings/select-holding',
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'SELECT HOLDING',
                    },
                    preprocessData: function(data) {
                        var i, l = data.length,
                            array = [];
                        if (l) {
                            for (i = 0; i < l; i++) {
                                array.push($.extend(true, data[i], {
                                    text: data[i].holding,
                                    value: data[i].id,
                                }));
                            }
                        }
                        return array;
                    }
                };

                $("#select_holding_equipment_code_tab_modal > button[title='SELECT HOLDING']").replaceWith('<button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" data-id="holding_equipment_code_tab_modal" title="' + data.holding + '"><span class="filter-option pull-left">' + data.holding + '</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>');
                $('#select_holding_equipment_code_tab_modal > .dropdown-menu.open').replaceWith('<div class="dropdown-menu open" style="min-height: 39px; max-height: 228px; overflow: hidden;"><div class="bs-searchbox"><input type="text" class="form-control input-sm" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px; max-height: 177px; overflow-y: auto;"><li class="dropdown-header" data-optgroup="1"><span class="text">Currently Selected</span></li><li data-original-index="0" data-optgroup="1" class="selected active"><a tabindex="0" class="opt  " style="" data-tokens="null"><span class="text">' + data.holding + '</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul><div class="status" style="">Start typing a search query</div></div>');
                $('#select_holding_equipment_code_tab_modal > #holding_equipment_code_tab_modal').replaceWith('<select id="holding_equipment_code_tab_modal" class="holding-equipment-code-tab-modal with-ajax" data-live-search="true" data-width="100%" tabindex="-98"><optgroup label="Currently Selected"><option value="' + data.holdingId + '" selected="selected">' + data.holding + '</option></optgroup></select>');

                $('.holding-equipment-code-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsHoldingEquipmentCodeTabModal);
                $('.holding-equipment-code-tab-modal').trigger('change');
                $('button[data-id="holding_equipment_code_tab_modal"]').addClass("btn-sm");

                var holdingId = data.tbl_holding_id;
                var optionsCompanyEquipmentCodeTabModal = {
                    ajax: {
                        url: 'settings/select-company/' + holdingId,
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

                $("#select_company_equipment_code_tab_modal > button[title='SELECT COMPANY']").replaceWith('<button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" data-id="company_equipment_code_tab_modal" title="' + data.company + '"><span class="filter-option pull-left">' + data.company + '</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>');
                $('#select_company_equipment_code_tab_modal > .dropdown-menu.open').replaceWith('<div class="dropdown-menu open" style="min-height: 39px; max-height: 228px; overflow: hidden;"><div class="bs-searchbox"><input type="text" class="form-control input-sm" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px; max-height: 177px; overflow-y: auto;"><li class="dropdown-header" data-optgroup="1"><span class="text">Currently Selected</span></li><li data-original-index="0" data-optgroup="1" class="selected active"><a tabindex="0" class="opt  " style="" data-tokens="null"><span class="text">' + data.company + '<small class="text-muted">' + data.company_desc + '</small></span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul><div class="status" style="">Start typing a search query</div></div>');
                $('#select_company_equipment_code_tab_modal > #company_equipment_code_tab_modal').replaceWith('<select id="company_equipment_code_tab_modal" class="company-equipment-code-tab-modal with-ajax" data-live-search="true" data-width="100%" tabindex="-98"><optgroup label="Currently Selected"><option value="' + data.companyId + '" selected="selected">' + data.company + '</option></optgroup></select>');

                $('.company-equipment-code-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsCompanyEquipmentCodeTabModal);
                $('.company-equipment-code-tab-modal').trigger('change');
                $('button[data-id="company_equipment_code_tab_modal"]').addClass("btn-sm");

                var companyId = data.companyId;
                var optionsPlantEquipmentCodeTabModal = {
                    ajax: {
                        url: 'settings/select-plant/' + companyId,
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'SELECT PLANT',
                    },
                    preprocessData: function(data) {
                        var i, l = data.length,
                            array = [];
                        if (l) {
                            for (i = 0; i < l; i++) {
                                array.push($.extend(true, data[i], {
                                    text: data[i].plant,
                                    value: data[i].id,
                                }));
                            }
                        }
                        return array;
                    }
                };

                $("#select_plant_equipment_code_tab_modal > button[title='SELECT PLANT']").replaceWith('<button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" data-id="plant_equipment_code_tab_modal" title="' + data.plant + '"><span class="filter-option pull-left">' + data.plant + '</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>');
                $('#select_plant_equipment_code_tab_modal > .dropdown-menu.open').replaceWith('<div class="dropdown-menu open" style="min-height: 39px; max-height: 228px; overflow: hidden;"><div class="bs-searchbox"><input type="text" class="form-control input-sm" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px; max-height: 177px; overflow-y: auto;"><li class="dropdown-header" data-optgroup="1"><span class="text">Currently Selected</span></li><li data-original-index="0" data-optgroup="1" class="selected active"><a tabindex="0" class="opt  " style="" data-tokens="null"><span class="text">' + data.plant + '<small class="text-muted">' + data.plant_desc + '</small></span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul><div class="status" style="">Start typing a search query</div></div>');
                $('#select_plant_equipment_code_tab_modal > #plant_equipment_code_tab_modal').replaceWith('<select id="plant_equipment_code_tab_modal" class="plant-equipment-code-tab-modal with-ajax" data-live-search="true" data-width="100%" tabindex="-98"><optgroup label="Currently Selected"><option value="' + data.plantId + '" selected="selected">' + data.plant + '</option></optgroup></select>');

                $('.plant-equipment-code-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsPlantEquipmentCodeTabModal);
                $('.plant-equipment-code-tab-modal').trigger('change');
                $('button[data-id="plant_equipment_code_tab_modal"]').addClass("btn-sm");

                $('.bs-searchbox > input.form-control').addClass("input-sm");

                $('#equipment_code_equipment_code_tab_modal').val(data.equipment_code);
                $('#equipment_name_equipment_code_tab_modal').val(data.equipment_name);
                $('#id_equipment_code_tab_modal').val(id);

                $("#equipment_code_equipment_code_tab_modal").prop("disabled", false);
                $("#equipment_name_equipment_code_tab_modal").prop("disabled", false);

                $('#btn_save_equipment_code_tab_modal').val("UPDATE").removeAttr("disabled");
                $('#equipment_code_tab_modal_title').text("EDIT EQUIPMENT CODE");
                $('#ajax_process_modal').modal('hide');
                $('#equipment_code_tab_modal').modal('show');
            },
            error: function() {
                $('#ajax_process_modal').modal('hide');
            }
        });
    });
    // End Edit Equipment Code

    // Press Enter equipment_code_tab_modal
    $("#equipment_code_tab_modal").keypress(function(e) {
        switch (e.which) {
            case 13:
                $("#btn_save_equipment_code_tab_modal").trigger("click");
                break;
        }
    });
    // End Press Enter equipment_code_tab_modal

    // Save Equipment Code
    $("#btn_save_equipment_code_tab_modal").click(function() {
        var formData = {
            equipment_code: $('#equipment_code_equipment_code_tab_modal').val().trim(),
            equipment_name: $('#equipment_name_equipment_code_tab_modal').val().trim(),
            tbl_plant_id: $('#plant_equipment_code_tab_modal').val(),
            created_by: $('#logged_in_user').val(),
            last_updated_by: $('#logged_in_user').val(),
        }

        var state = $('#btn_save_equipment_code_tab_modal').val();
        var type = "POST";
        var url = 'settings/add-equipment-code';
        var id = $('#id_equipment_code_tab_modal').val();

        if (state == "UPDATE") {
            type = "PUT";
            url = 'settings/update-equipment-code/' + id;
        }

        $.ajax({
            type: type,
            url: url,
            data: formData,
            dataType: 'json',
            beforeSend: function(data) {
                $("#equipment_code_tab_modal :input").prop('disabled', true);
                $(".error_saving_equipment_code_tab_modal").hide();
                $(".error_updating_equipment_code_tab_modal").hide();

                if (state == "SAVE") {
                    $(".saving_equipment_code_tab_modal").show();
                } else {
                    $(".updating_equipment_code_tab_modal").show();
                }

                $("#form_plant_equipment_code_tab_modal").removeClass("has-error");
                $("#plant_equipment_code_tab_modal + p.help-block").text("");

                $("#form_equipment_code_equipment_code_tab_modal").removeClass("has-error");
                $("#equipment_code_equipment_code_tab_modal + p.help-block").text("");

                $("#form_equipment_name_equipment_code_tab_modal").removeClass("has-error");
                $("#equipment_name_equipment_code_tab_modal + p.help-block").text("");
            },
            success: function(data) {
                $('#equipment_code_tab_modal_form').trigger("reset");
                $(".saving_equipment_code_tab_modal").hide();
                $(".updating_equipment_code_tab_modal").hide();

                $('#equipment_code_tab_modal').modal('hide');
                reload_equipment_code_table();
                $("#equipment_code_tab_modal :input").prop('disabled', false);

                $("#form_plant_equipment_code_tab_modal").removeClass("has-error");
                $("#plant_equipment_code_tab_modal + p.help-block").text("");

                $("#form_equipment_code_equipment_code_tab_modal").removeClass("has-error");
                $("#equipment_code_equipment_code_tab_modal + p.help-block").text("");

                $("#form_equipment_name_equipment_code_tab_modal").removeClass("has-error");
                $("#equipment_name_equipment_code_tab_modal + p.help-block").text("");
            },
            error: function(data) {
                $(".saving_equipment_code_tab_modal").hide();
                $(".updating_equipment_code_tab_modal").hide();
                if (state == "SAVE") {
                    $(".error_saving_equipment_code_tab_modal").show();
                } else {
                    $(".error_updating_equipment_code_tab_modal").show();
                }
                $("#equipment_code_tab_modal :input").prop('disabled', false);

                var errors = data.responseJSON;

                if (errors.tbl_plant_id) {
                    $("#form_plant_equipment_code_tab_modal").addClass("has-error");
                    $("#plant_equipment_code_tab_modal + p.help-block").text(errors.tbl_plant_id);
                } else {
                    $("#form_plant_equipment_code_tab_modal").removeClass("has-error");
                    $("#plant_equipment_code_tab_modal + p.help-block").text("");
                }

                if (errors.equipment_code) {
                    $("#form_equipment_code_equipment_code_tab_modal").addClass("has-error");
                    $("#equipment_code_equipment_code_tab_modal + p.help-block").text(errors.equipment_code);
                } else {
                    $("#form_equipment_code_equipment_code_tab_modal").removeClass("has-error");
                    $("#equipment_code_equipment_code_tab_modal + p.help-block").text("");
                }

                if (errors.equipment_name) {
                    $("#form_equipment_name_equipment_code_tab_modal").addClass("has-error");
                    $("#equipment_name_equipment_code_tab_modal + p.help-block").text(errors.equipment_name);
                } else {
                    $("#form_equipment_name_equipment_code_tab_modal").removeClass("has-error");
                    $("#equipment_name_equipment_code_tab_modal + p.help-block").text("");
                }
            }
        });
    });
    // End Save Equipment Code

    // Delete Equipment Code
    $(document).on('click', '.delete-eq', function() {
        id = $(this).attr('data-id');

        var equipmentCode = $("table#equipment_code_table tr#" + id + " td:eq(1)").html();
        var equipmentName = $("table#equipment_code_table tr#" + id + " td:eq(2)").html();
        var msg = "<table class=\"table table-striped\">";
        msg += "<thead><tr><th>EQUIPMENT CODE</th><th>EQUIPMENT NAME</th></thead>";
        msg += "<tbody><tr><td>" + equipmentCode + "</td><td>" + equipmentName + "</td></tr></tbody>";
        msg += "</table>";

        bootbox.dialog({
            message: msg,
            title: "Are you sure you want to delete this Equipment Code?",
            buttons: {
                success: {
                    label: "YES DELETE",
                    className: "btn-danger btn-sm",
                    callback: function() {
                        $.ajax({
                            type: "DELETE",
                            url: 'settings/delete-equipment-code/' + id,
                            beforeSend: function() {},
                            success: function() {
                                reload_equipment_code_table();
                            },
                            error: function() {
                                alert('Cannot delete this Equipment Code.');
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
    // End Delete Equipment Code

    // Changed Select inside Equipment Code Modal
    $(document).ajaxComplete(function() {

        $('#holding_equipment_code_tab_modal').on('changed.bs.select', function(e) {
            $('#select_company_equipment_code_tab_modal').html('<select id="company_equipment_code_tab_modal" class="company-equipment-code-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');

            var plantSelectModal = '<div class="btn-group bootstrap-select disabled plant-equipment-code-tab-modal with-ajax" style="width: 100%;">';
            plantSelectModal += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="plant_equipment_code_tab_modal" tabindex="-1" title="SELECT PLANT"><span class="filter-option pull-left">SELECT PLANT</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
            plantSelectModal += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
            plantSelectModal += '<select id="plant_equipment_code_tab_modal" class="plant-equipment-code-tab-modal with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="SELECT PLANT"><option class="bs-title-option" value="">SELECT PLANT</option></select>';
            plantSelectModal += '</div>';
            $("#select_plant_equipment_code_tab_modal").html(plantSelectModal);

            var holdingId = $(this).val();
            var optionsCompanyEquipmentCodeTabModal = {
                ajax: {
                    url: 'settings/select-company/' + holdingId,
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

            $('.company-equipment-code-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsCompanyEquipmentCodeTabModal);
            $('.company-equipment-code-tab-modal').trigger('change');
            $('button[data-id="company_equipment_code_tab_modal"]').addClass("btn-sm");
            $('.bs-searchbox > input.form-control').addClass("input-sm");
        });

        $('#company_equipment_code_tab_modal').on('changed.bs.select', function(e) {
            $('#select_plant_equipment_code_tab_modal').html('<select id="plant_equipment_code_tab_modal" class="plant-equipment-code-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');

            var companyId = $(this).val();
            var optionsPlantEquipmentCodeTabModal = {
                ajax: {
                    url: 'settings/select-plant/' + companyId,
                    type: 'POST',
                    dataType: 'json',
                },
                locale: {
                    emptyTitle: 'SELECT PLANT',
                },
                preprocessData: function(data) {
                    var i, l = data.length,
                        array = [];
                    if (l) {
                        for (i = 0; i < l; i++) {
                            array.push($.extend(true, data[i], {
                                text: data[i].plant,
                                value: data[i].id,
                            }));
                        }
                    }
                    return array;
                }
            };

            $('.plant-equipment-code-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsPlantEquipmentCodeTabModal);
            $('.plant-equipment-code-tab-modal').trigger('change');
            $('button[data-id="plant_equipment_code_tab_modal"]').addClass("btn-sm");
            $('.bs-searchbox > input.form-control').addClass("input-sm");
        });

    });
    // End Changed Select inside Equipment Code Modal

    // Equipment Code Modal hide
    $('#equipment_code_tab_modal').on('hide.bs.modal', function(e) {
        $('#select_holding_equipment_code_tab_modal').html('<select id="holding_equipment_code_tab_modal" class="holding-equipment-code-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');
        $('#select_company_equipment_code_tab_modal').html('<select id="company_equipment_code_tab_modal" class="company-equipment-code-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');
        $('#select_plant_equipment_code_tab_modal').html('<select id="plant_equipment_code_tab_modal" class="plant-equipment-code-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');

        $('#equipment_code_tab_modal_form').trigger("reset");

        $(".error_saving_equipment_code_tab_modal").hide();
        $(".error_updating_equipment_code_tab_modal").hide();

        $("#equipment_code_equipment_code_tab_modal").prop("disabled", true).val("");
        $("#equipment_name_equipment_code_tab_modal").prop("disabled", true).val("");

        $("#form_plant_equipment_code_tab_modal").removeClass("has-error");
        $("#plant_equipment_code_tab_modal + p.help-block").text("");

        $("#form_equipment_code_equipment_code_tab_modal").removeClass("has-error");
        $("#equipment_code_equipment_code_tab_modal + p.help-block").text("");

        $("#form_equipment_name_equipment_code_tab_modal").removeClass("has-error");
        $("#equipment_name_equipment_code_tab_modal + p.help-block").text("");

    });
    // End Equipment Code Modal Hide

    // END EQUIPMENT CODE TAB
    // ============================================================
    // ============================================================




    // START HARMONIZED CODE TAB
    // ============================================================
    // ============================================================

    var datatable_harmonized_code_tab;
    $("#harmonized_code_tab").one("click", function() {

        datatable_harmonized_code_tab = $('#harmonized_code_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'settings/datatables-harmonized-code',
            },
            columns: [{
                data: 'rownum',
                name: 'rownum',
                searchable: false
            }, {
                data: 'created_at',
                name: 'created_at',
                searchable: false
            }, {
                data: 'code',
                name: 'code'
            }, {
                data: 'description',
                name: 'description'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
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
                "sSearch": "",
                "sSearchPlaceholder": "SEARCH",
            },
            columnDefs: [{
                "targets": [1],
                "visible": false,
            }, ],
            order: [
                [1, 'desc']
            ]
        });

        $("select.form-control").selectpicker();
        $("div.dataTables_length > label > div.btn-group > button").addClass("btn-sm");

        // Right Click Harmonized Code Tab
        new BootstrapMenu('table#harmonized_code_table', {
            actions: [{
                name: 'REFRESH HARMONIZED CODE DATA',
                onClick: function() {
                    datatable_harmonized_code_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Datatables Harmonized Code Tab
    });

    // Reload Harmonized Code DataTables
    function reload_harmonized_code_table() {
        datatable_harmonized_code_tab.ajax.reload(null, false);
    }
    // End Reload Harmonized Code DataTables

    // Add Harmonized Code
    $(document).on('click', '#add-hrc', function() {
        $('#btn_save_harmonized_code_tab_modal').val("SAVE").removeAttr("disabled");
        $('#harmonized_code_tab_modal_title').text("ADD HARMONIZED CODE");
        $('#harmonized_code_tab_modal_form').trigger("reset");
        $('#harmonized_code_tab_modal').modal('show');
    });
    // End Harmonized Code

    // Edit Harmonized Code
    $(document).on('click', '.edit-hrc', function() {
        id = $(this).attr('data-id');

        var code = $("table#harmonized_code_table tr#" + id + " td:eq(1)").html();
        var description = $("table#harmonized_code_table tr#" + id + " td:eq(2)").html();

        $('#harmonized_code_harmonized_code_tab_modal').val(code);
        $('#desc_harmonized_code_tab_modal').val(description);
        $('#id_harmonized_code_tab_modal').val(id);

        $('#btn_save_harmonized_code_tab_modal').val("UPDATE").removeAttr("disabled");
        $('#harmonized_code_tab_modal_title').text("EDIT HARMONIZED CODE");
        $('#ajax_process_modal').modal('hide');
        $('#harmonized_code_tab_modal').modal('show');
    });
    // End Edit Harmonized Code

    // Press Enter harmonized_code_tab_modal
    $("#harmonized_code_tab_modal").keypress(function(e) {
        switch (e.which) {
            case 13:
                $("#btn_save_harmonized_code_tab_modal").trigger("click");
                break;
        }
    });
    // End Press Enter harmonized_code_tab_modal

    // Save Harmonized Code
    $("#btn_save_harmonized_code_tab_modal").click(function() {
        var formData = {
            code: $('#harmonized_code_harmonized_code_tab_modal').val().trim(),
            description: $('#desc_harmonized_code_tab_modal').val().trim(),
            created_by: $('#logged_in_user').val(),
            last_updated_by: $('#logged_in_user').val(),
        }

        var state = $('#btn_save_harmonized_code_tab_modal').val();
        var type = "POST";
        var url = 'settings/add-harmonized-code';
        var id = $('#id_harmonized_code_tab_modal').val();

        if (state == "UPDATE") {
            type = "PUT";
            url = 'settings/update-harmonized-code/' + id;
        }

        $.ajax({
            type: type,
            url: url,
            data: formData,
            dataType: 'json',
            beforeSend: function(data) {
                $("#harmonized_code_tab_modal :input").prop('disabled', true);
                $(".error_saving_harmonized_code_tab_modal").hide();
                $(".error_updating_harmonized_code_tab_modal").hide();

                if (state == "SAVE") {
                    $(".saving_harmonized_code_tab_modal").show();
                } else {
                    $(".updating_harmonized_code_tab_modal").show();
                }

                $("#form_harmonized_code_harmonized_code_tab_modal").removeClass("has-error");
                $("#harmonized_code_harmonized_code_tab_modal + p.help-block").text("");
                $("#form_desc_harmonized_code_tab_modal").removeClass("has-error");
                $("#desc_harmonized_code_tab_modal + p.help-block").text("");
            },
            success: function(data) {
                $('#harmonized_code_tab_modal_form').trigger("reset");
                $(".saving_harmonized_code_tab_modal").hide();
                $(".updating_harmonized_code_tab_modal").hide();

                $('#harmonized_code_tab_modal').modal('hide');
                reload_harmonized_code_table();
                $("#harmonized_code_tab_modal :input").prop('disabled', false);

                $("#form_harmonized_code_harmonized_code_tab_modal").removeClass("has-error");
                $("#harmonized_code_harmonized_code_tab_modal + p.help-block").text("");
                $("#form_desc_harmonized_code_tab_modal").removeClass("has-error");
                $("#desc_harmonized_code_tab_modal + p.help-block").text("");
            },
            error: function(data) {
                $(".saving_harmonized_code_tab_modal").hide();
                $(".updating_harmonized_code_tab_modal").hide();
                if (state == "SAVE") {
                    $(".error_saving_harmonized_code_tab_modal").show();
                } else {
                    $(".error_updating_harmonized_code_tab_modal").show();
                }
                $("#harmonized_code_tab_modal :input").prop('disabled', false);

                var errors = data.responseJSON;

                if (errors.code) {
                    $("#form_harmonized_code_harmonized_code_tab_modal").addClass("has-error");
                    $("#harmonized_code_harmonized_code_tab_modal + p.help-block").text(errors.code);
                } else {
                    $("#form_harmonized_code_harmonized_code_tab_modal").removeClass("has-error");
                    $("#harmonized_code_harmonized_code_tab_modal + p.help-block").text("");
                }

                if (errors.description) {
                    $("#form_desc_harmonized_code_tab_modal").addClass("has-error");
                    $("#desc_harmonized_code_tab_modal + p.help-block").text(errors.code);
                } else {
                    $("#form_desc_harmonized_code_tab_modal").removeClass("has-error");
                    $("#desc_harmonized_code_tab_modal + p.help-block").text("");
                }
            }
        });
    });
    // End Save Harmonized Code

    // Delete Harmonized Code
    $(document).on('click', '.delete-hrc', function() {
        id = $(this).attr('data-id');

        var code = $("table#harmonized_code_table tr#" + id + " td:eq(1)").html();
        var description = $("table#harmonized_code_table tr#" + id + " td:eq(2)").html();
        var msg = "<table class=\"table table-striped\">";
        msg += "<thead><tr><th>HARMONIZED CODE</th><th>DESCRIPTION</th></thead>";
        msg += "<tbody><tr><td>" + code + "</td><td>" + description + "</td></tr></tbody>";
        msg += "</table>";

        bootbox.dialog({
            message: msg,
            title: "Are you sure you want to delete this Harmonized Code?",
            buttons: {
                success: {
                    label: "YES DELETE",
                    className: "btn-danger btn-sm",
                    callback: function() {
                        $.ajax({
                            type: "DELETE",
                            url: 'settings/delete-harmonized-code/' + id,
                            beforeSend: function() {},
                            success: function() {
                                reload_harmonized_code_table();
                            },
                            error: function() {
                                alert('Cannot delete this Harmonized Code.');
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
    // End Delete Harmonized Code

    // Harmonized Code Modal hide
    $('#harmonized_code_tab_modal').on('hide.bs.modal', function(e) {
        $(".error_saving_harmonized_code_tab_modal").hide();
        $(".error_updating_harmonized_code_tab_modal").hide();

        $("#form_harmonized_code_harmonized_code_tab_modal").removeClass("has-error");
        $("#harmonized_code_harmonized_code_tab_modal + p.help-block").text("");
        $("#form_desc_harmonized_code_tab_modal").removeClass("has-error");
        $("#desc_harmonized_code_tab_modal + p.help-block").text("");
    });
    // End Harmonized Code Modal Hide

    // END HARMONIZED CODE TAB
    // ============================================================
    // ============================================================




    // START HAZARD CLASS TAB
    // ============================================================
    // ============================================================

    var datatable_hazard_class_tab;
    $("#hazard_class_tab").one("click", function() {

        datatable_hazard_class_tab = $('#hazard_class_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'settings/datatables-hazard-class',
            },
            columns: [{
                data: 'rownum',
                name: 'rownum',
                searchable: false
            }, {
                data: 'created_at',
                name: 'created_at',
                searchable: false
            }, {
                data: 'class',
                name: 'class'
            }, {
                data: 'description',
                name: 'description'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
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
                "sSearch": "",
                "sSearchPlaceholder": "SEARCH",
            },
            columnDefs: [{
                "targets": [1],
                "visible": false,
            }, ],
            order: [
                [1, 'desc']
            ]
        });

        $("select.form-control").selectpicker();
        $("div.dataTables_length > label > div.btn-group > button").addClass("btn-sm");

        // Right Click Hazard Class Tab
        new BootstrapMenu('table#hazard_class_table', {
            actions: [{
                name: 'REFRESH HAZARD CLASS DATA',
                onClick: function() {
                    datatable_hazard_class_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Datatables Hazard Class Tab
    });

    // Reload Hazard Class DataTables
    function reload_hazard_class_table() {
        datatable_hazard_class_tab.ajax.reload(null, false);
    }
    // End Reload Hazard Class DataTables

    // Add Hazard Class
    $(document).on('click', '#add-hzc', function() {
        $('#btn_save_hazard_class_tab_modal').val("SAVE").removeAttr("disabled");
        $('#hazard_class_tab_modal_title').text("ADD HAZARD CLASS");
        $('#hazard_class_tab_modal').modal('show');
    });
    // End Add Hazard Class

    // Edit Hazard Class
    $(document).on('click', '.edit-hzc', function() {
        id = $(this).attr('data-id');

        var hzclass = $("table#hazard_class_table tr#" + id + " td:eq(1)").html();
        var description = $("table#hazard_class_table tr#" + id + " td:eq(2)").html();

        $('#hazard_class_hazard_class_tab_modal').val(hzclass);
        $('#desc_hazard_class_tab_modal').val(description);
        $('#id_hazard_class_tab_modal').val(id);

        $('#btn_save_hazard_class_tab_modal').val("UPDATE").removeAttr("disabled");
        $('#hazard_class_tab_modal_title').text("EDIT HAZARD CLASS");
        $('#ajax_process_modal').modal('hide');
        $('#hazard_class_tab_modal').modal('show');
    });
    // End Edit Hazard Class


    // Press Enter hazard_class_tab_modal
    $("#hazard_class_tab_modal").keypress(function(e) {
        switch (e.which) {
            case 13:
                $("#btn_save_hazard_class_tab_modal").trigger("click");
                break;
        }
    });
    // End Press Enter hazard_class_tab_modal


    // Save Hazard Class
    $("#btn_save_hazard_class_tab_modal").click(function() {
        var formData = {
            class: $('#hazard_class_hazard_class_tab_modal').val().trim(),
            description: $('#desc_hazard_class_tab_modal').val().trim(),
            created_by: $('#logged_in_user').val(),
            last_updated_by: $('#logged_in_user').val(),
        }

        var state = $('#btn_save_hazard_class_tab_modal').val();
        var type = "POST";
        var url = 'settings/add-hazard-class';
        var id = $('#id_hazard_class_tab_modal').val();

        if (state == "UPDATE") {
            type = "PUT";
            url = 'settings/update-hazard-class/' + id;
        }

        $.ajax({
            type: type,
            url: url,
            data: formData,
            dataType: 'json',
            beforeSend: function(data) {
                $("#hazard_class_tab_modal :input").prop('disabled', true);
                $(".error_saving_hazard_class_tab_modal").hide();
                $(".error_updating_hazard_class_tab_modal").hide();

                $("#form_hazard_class_hazard_class_tab_modal").removeClass("has-error");
                $("#hazard_class_hazard_class_tab_modal + p.help-block").text("");
                $("#form_desc_hazard_class_tab_modal").removeClass("has-error");
                $("#desc_hazard_class_tab_modal + p.help-block").text("");

                if (state == "SAVE") {
                    $(".saving_hazard_class_tab_modal").show();
                } else {
                    $(".updating_hazard_class_tab_modal").show();
                }
            },
            success: function(data) {
                $('#hazard_class_tab_modal_form').trigger("reset");
                $(".saving_hazard_class_tab_modal").hide();
                $(".updating_hazard_class_tab_modal").hide();

                $('#hazard_class_tab_modal').modal('hide');
                reload_hazard_class_table();
                $("#hazard_class_tab_modal :input").prop('disabled', false);

                $("#form_hazard_class_hazard_class_tab_modal").removeClass("has-error");
                $("#hazard_class_hazard_class_tab_modal + p.help-block").text("");
                $("#form_desc_hazard_class_tab_modal").removeClass("has-error");
                $("#desc_hazard_class_tab_modal + p.help-block").text("");
            },
            error: function(data) {
                $(".saving_hazard_class_tab_modal").hide();
                $(".updating_hazard_class_tab_modal").hide();
                if (state == "SAVE") {
                    $(".error_saving_hazard_class_tab_modal").show();
                } else {
                    $(".error_updating_hazard_class_tab_modal").show();
                }

                $("#hazard_class_tab_modal :input").prop('disabled', false);

                var errors = data.responseJSON;

                if (errors.class) {
                    $("#form_hazard_class_hazard_class_tab_modal").addClass("has-error");
                    $("#hazard_class_hazard_class_tab_modal + p.help-block").text(errors.class);
                } else {
                    $("#form_hazard_class_hazard_class_tab_modal").removeClass("has-error");
                    $("#hazard_class_hazard_class_tab_modal + p.help-block").text("");
                }

                if (errors.description) {
                    $("#form_desc_hazard_class_tab_modal").addClass("has-error");
                    $("#desc_hazard_class_tab_modal + p.help-block").text(errors.description);
                } else {
                    $("#form_desc_hazard_class_tab_modal").removeClass("has-error");
                    $("#desc_hazard_class_tab_modal + p.help-block").text("");
                }
            }
        });
    });
    // End Save Hazard Class

    // Delete Hazard Class
    $(document).on('click', '.delete-hzc', function() {
        id = $(this).attr('data-id');

        var hzclass = $("table#hazard_class_table tr#" + id + " td:eq(1)").html();
        var description = $("table#hazard_class_table tr#" + id + " td:eq(2)").html();
        var msg = "<table class=\"table table-striped\">";
        msg += "<thead><tr><th>HAZARD CLASS</th><th>DESCRIPTION</th></thead>";
        msg += "<tbody><tr><td>" + hzclass + "</td><td>" + description + "</td></tr></tbody>";
        msg += "</table>";

        bootbox.dialog({
            message: msg,
            title: "Are you sure you want to delete this Hazard Class?",
            buttons: {
                success: {
                    label: "YES DELETE",
                    className: "btn-danger btn-sm",
                    callback: function() {
                        $.ajax({
                            type: "DELETE",
                            url: 'settings/delete-hazard-class/' + id,
                            beforeSend: function() {},
                            success: function() {
                                reload_hazard_class_table();
                            },
                            error: function() {
                                alert('Cannot delete this Hazard Class.');
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
    // End Delete Hazard Class

    // Hazard Class Modal hide
    $('#hazard_class_tab_modal').on('hide.bs.modal', function(e) {
        $('#hazard_class_tab_modal_form').trigger("reset");
        $(".error_saving_hazard_class_tab_modal").hide();
        $(".error_updating_hazard_class_tab_modal").hide();

        $("#form_hazard_class_hazard_class_tab_modal").removeClass("has-error");
        $("#hazard_class_hazard_class_tab_modal + p.help-block").text("");
        $("#form_desc_hazard_class_tab_modal").removeClass("has-error");
        $("#desc_hazard_class_tab_modal + p.help-block").text("");
    });
    // End Hazard Class Modal Hide

    // END HAZARD CLASS TAB
    // ============================================================
    // ============================================================




    // START HOLDING-BIN HOLDING TAB
    // ============================================================
    // ============================================================

    var datatable_holding_tab;
    $("#holding_to_bin_tab").one("click", function() {

        datatable_holding_tab = $('#holding_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'settings/datatables-holding',
            },
            columns: [{
                data: 'rownum',
                name: 'rownum',
                searchable: false
            }, {
                data: 'created_at',
                name: 'created_at',
                searchable: false
            }, {
                data: 'holding',
                name: 'tbl_holding.holding'
            }, {
                data: 'description',
                name: 'tbl_holding.description'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
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
                "sSearch": "",
                "sSearchPlaceholder": "SEARCH",
            },
            columnDefs: [{
                "targets": [1],
                "visible": false,
            }, ],
            order: [
                [1, 'desc']
            ]
        });

        $("select.form-control").selectpicker();
        $("div.dataTables_length > label > div.btn-group > button").addClass("btn-sm");

        // Right Click Datatables Holding Tab
        new BootstrapMenu('table#holding_table', {
            actions: [{
                name: 'REFRESH HOLDING DATA',
                onClick: function() {
                    datatable_holding_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Datatables Holding Tab
    });

    // Reload Holding DataTables
    function reload_holding_table() {
        datatable_holding_tab.ajax.reload(null, false);
    }
    // End Reload Holding DataTables

    // Add Holding
    $(document).on('click', '#add-hol', function() {
        $('#btn_save_holding_tab_modal').val("SAVE").removeAttr("disabled");
        $('#holding_tab_modal_title').text("ADD HOLDING");
        $('#holding_tab_modal').modal('show');
    });
    // End Add Holding

    // Edit Holding
    $(document).on('click', '.edit-hol', function() {
            id = $(this).attr('data-id');

            var holding = $("table#holding_table tr#" + id + " td:eq(1)").html();
            var description = $("table#holding_table tr#" + id + " td:eq(2)").html();

            $('#holding_holding_tab_modal').val(holding);
            $('#holding_desc_holding_tab_modal').val(description);
            $('#id_holding_tab_modal').val(id);

            $('#btn_save_holding_tab_modal').val("UPDATE").removeAttr("disabled");
            $('#holding_tab_modal_title').text("EDIT HOLDING");
            $('#ajax_process_modal').modal('hide');
            $('#holding_tab_modal').modal('show');
        })
        // End Edit Holding

    // Press Enter holding_tab_modal
    $("#holding_tab_modal").keypress(function(e) {
        switch (e.which) {
            case 13:
                $("#btn_save_holding_tab_modal").trigger("click");
                break;
        }
    });
    // End Press Enter holding_tab_modal

    // Save Holding
    $("#btn_save_holding_tab_modal").click(function() {
        var formData = {
            holding: $('#holding_holding_tab_modal').val().trim(),
            description: $('#holding_desc_holding_tab_modal').val().trim(),
            created_by: $('#logged_in_user').val(),
            last_updated_by: $('#logged_in_user').val(),
        }

        var state = $('#btn_save_holding_tab_modal').val();
        var type = "POST";
        var url = 'settings/add-holding';
        var holdingId = $('#id_holding_tab_modal').val();

        if (state == "UPDATE") {
            type = "PUT";
            url = 'settings/update-holding/' + holdingId;
        }

        $.ajax({
            type: type,
            url: url,
            data: formData,
            dataType: 'json',
            beforeSend: function(data) {
                $("#holding_tab_modal :input").prop('disabled', true);
                $(".error_saving_holding_tab_modal").hide();
                $(".error_updating_holding_tab_modal").hide();

                if (state == "SAVE") {
                    $(".saving_holding_tab_modal").show();
                } else {
                    $(".updating_holding_tab_modal").show();
                }

                $("#form_holding_holding_tab_modal").removeClass("has-error");
                $("#holding_holding_tab_modal + p.help-block").text("");

                $("#form_holding_desc_holding_tab_modal").removeClass("has-error");
                $("#holding_desc_holding_tab_modal + p.help-block").text("");
            },
            success: function(data) {
                $('#holding_tab_modal_form').trigger("reset");
                $(".saving_holding_tab_modal").hide();
                $(".updating_holding_tab_modal").hide();

                $('#holding_tab_modal').modal('hide');
                reload_holding_table();
                $("#holding_tab_modal :input").prop('disabled', false);

                $("#form_holding_holding_tab_modal").removeClass("has-error");
                $("#holding_holding_tab_modal + p.help-block").text("");

                $("#form_holding_desc_holding_tab_modal").removeClass("has-error");
                $("#holding_desc_holding_tab_modal + p.help-block").text("");
            },
            error: function(data) {
                $(".saving_holding_tab_modal").hide();
                $(".updating_holding_tab_modal").hide();
                if (state == "SAVE") {
                    $(".error_saving_holding_tab_modal").show();
                } else {
                    $(".error_updating_holding_tab_modal").show();
                }
                $("#holding_tab_modal :input").prop('disabled', false);

                var errors = data.responseJSON;

                if (errors.holding) {
                    $("#form_holding_holding_tab_modal").addClass("has-error");
                    $("#holding_holding_tab_modal + p.help-block").text(errors.holding);
                } else {
                    $("#form_holding_holding_tab_modal").removeClass("has-error");
                    $("#holding_holding_tab_modal + p.help-block").text("");
                }

                if (errors.description) {
                    $("#form_holding_desc_holding_tab_modal").addClass("has-error");
                    $("#holding_desc_holding_tab_modal + p.help-block").text(errors.description);
                } else {
                    $("#form_holding_desc_holding_tab_modal").removeClass("has-error");
                    $("#holding_desc_holding_tab_modal + p.help-block").text("");
                }
            }
        });
    });
    // End Save Holding

    // Delete Holding
    $(document).on('click', '.delete-hol', function() {
        id = $(this).attr('data-id');

        var holding = $("table#holding_table tr#" + id + " td:eq(1)").html();
        var description = $("table#holding_table tr#" + id + " td:eq(2)").html();
        var msg = "<table class=\"table table-striped\">";
        msg += "<thead><tr><th>HOLDING</th><th>DESCRIPTION</th></thead>";
        msg += "<tbody><tr><td>" + holding + "</td><td>" + description + "</td></tr></tbody>";
        msg += "</table>";

        bootbox.dialog({
            message: msg,
            title: "Are you sure you want to delete this Holding?",
            buttons: {
                success: {
                    label: "YES DELETE",
                    className: "btn-danger btn-sm",
                    callback: function() {
                        $.ajax({
                            type: "DELETE",
                            url: 'settings/delete-holding/' + id,
                            beforeSend: function() {},
                            success: function() {
                                reload_holding_table();
                            },
                            error: function() {
                                alert('Cannot delete this Holding.');
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
    // End Delete Holding

    // Holding Modal hide
    $('#holding_tab_modal').on('hide.bs.modal', function(e) {
        $(".error_saving_holding_tab_modal").hide();
        $(".error_updating_holding_tab_modal").hide();

        $('#holding_tab_modal_form').trigger("reset");

        $("#form_holding_holding_tab_modal").removeClass("has-error");
        $("#holding_holding_tab_modal + p.help-block").text("");

        $("#form_holding_desc_holding_tab_modal").removeClass("has-error");
        $("#holding_desc_holding_tab_modal + p.help-block").text("");
    });
    // End Holding Modal Hide

    // END HOLDING-BIN HOLDING TAB
    // ============================================================
    // ============================================================




    // START HOLDING-BIN COMPANY TAB
    // ============================================================
    // ============================================================

    var datatable_company_tab;
    $("#company_tab").one("click", function() {

        datatable_company_tab = $('#company_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'settings/datatables-company',
                data: function(d) {
                    d.holdingId = $('#holding_company_tab').val();
                },
            },
            columns: [{
                data: 'rownum',
                name: 'rownum',
                searchable: false
            }, {
                data: 'created_at',
                name: 'created_at',
                searchable: false
            }, {
                data: 'company',
                name: 'tbl_company.company'
            }, {
                data: 'description',
                name: 'tbl_company.description'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
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
                "sSearch": "",
                "sSearchPlaceholder": "SEARCH",
            },
            dom: "<'row'<'col-sm-8'l>f>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            columnDefs: [{
                "targets": [1],
                "visible": false,
            }, ],
            order: [
                [1, 'desc']
            ]
        });

        $("select.form-control").selectpicker();
        $("div.dataTables_length > label > div.btn-group > button").addClass("btn-sm");

        var filterCompany = '<div class="col-sm-2" id="select_holding_company_tab">';
        filterCompany += '<select id="holding_company_tab" class="holding-company-tab with-ajax" data-live-search="true" data-width="100%"></select>';
        filterCompany += '</div>';

        $(filterCompany).insertBefore("#company_table_filter");
        $('#company_table_filter').addClass('col-sm-2').css("padding-left", "0px");

        // FILTER TOP Company Tab
        // Filter Holding Top Company Tab
        var optionsHoldingCompanyTab = {
            ajax: {
                url: 'settings/select-holding',
                type: 'POST',
                dataType: 'json',
            },
            locale: {
                emptyTitle: 'ALL HOLDING',
                statusInitialized: 'Start typing...'
            },
            preprocessData: function(data) {
                var i, l = data.length,
                    array = [];
                if (l) {
                    for (i = 0; i < l; i++) {
                        array.push($.extend(true, data[i], {
                            text: data[i].holding,
                            value: data[i].id,
                        }));
                    }
                }
                return array;
            }
        };
        $('.holding-company-tab').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsHoldingCompanyTab);
        $('.holding-company-tab').trigger('change');

        $('button[data-id="holding_company_tab"]').addClass("btn-sm");
        // End Filter Holding Top Company Tab

        $(document).ajaxComplete(function() {
            // Changed Holding Top Company Tab
            $('#holding_company_tab').on('changed.bs.select', function(e) {
                datatable_company_tab.ajax.reload(null, false).unbind();
            });
            // End Changed Holding Top Company Tab
        });

        // Right Click Holding Filter Top Company Tab
        new BootstrapMenu('button[data-id="holding_company_tab"]', {
            actions: [{
                name: 'SELECT ALL HOLDING',
                onClick: function() {
                    if ($('#holding_company_tab').prop('disabled') == false) {
                        $('#holding_company_tab').val([]);
                        $('#holding_company_tab').trigger('change.abs.preserveSelected');
                        $('#holding_company_tab').selectpicker('refresh');
                        $('#holding_company_tab').trigger("click");
                    }
                    datatable_company_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Holding Filter Top Company Tab

        // Right Click Datatables Company Tab
        new BootstrapMenu('table#company_table', {
            actions: [{
                name: 'REFRESH COMPANY DATA',
                onClick: function() {
                    datatable_company_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Datatables Company Tab
    });

    // Reload Company DataTables
    function reload_company_table() {
        datatable_company_tab.ajax.reload(null, false);
    }
    // End Reload Company DataTables

    // Add Company
    $(document).on('click', '#add-cp', function() {
        var optionsHoldingCompanyTabModal = {
            ajax: {
                url: 'settings/select-holding',
                type: 'POST',
                dataType: 'json',
            },
            locale: {
                emptyTitle: 'SELECT HOLDING',
            },
            preprocessData: function(data) {
                var i, l = data.length,
                    array = [];
                if (l) {
                    for (i = 0; i < l; i++) {
                        array.push($.extend(true, data[i], {
                            text: data[i].holding,
                            value: data[i].id,
                        }));
                    }
                }
                return array;
            }
        };

        $('.holding-company-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsHoldingCompanyTabModal);
        $('.holding-company-tab-modal').trigger('change');
        $('button[data-id="holding_company_tab_modal"]').addClass("btn-sm");
        $('.bs-searchbox > input.form-control').addClass("input-sm");

        $('#btn_save_company_tab_modal').val("SAVE").removeAttr("disabled");
        $('#company_tab_modal_title').text("ADD COMPANY");
        $('#company_tab_modal').modal('show');
    });
    // End Add Company

    // Edit Plant
    $(document).on('click', '.edit-cp', function() {
        id = $(this).attr('data-id');

        $.ajax({
            url: 'settings/edit-company/' + id,
            type: 'GET',
            beforeSend: function() {
                $('#ajax_process_modal').modal('show');
            },
            success: function(data) {
                var optionsHoldingCompanyTabModal = {
                    ajax: {
                        url: 'settings/select-holding',
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'SELECT HOLDING',
                    },
                    preprocessData: function(data) {
                        var i, l = data.length,
                            array = [];
                        if (l) {
                            for (i = 0; i < l; i++) {
                                array.push($.extend(true, data[i], {
                                    text: data[i].holding,
                                    value: data[i].id,
                                }));
                            }
                        }
                        return array;
                    }
                };

                $("#select_holding_company_tab_modal > button[title='SELECT HOLDING']").replaceWith('<button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" data-id="holding_company_tab_modal" title="' + data.holding + '"><span class="filter-option pull-left">' + data.holding + '</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>');
                $('#select_holding_company_tab_modal > .dropdown-menu.open').replaceWith('<div class="dropdown-menu open" style="min-height: 39px; max-height: 228px; overflow: hidden;"><div class="bs-searchbox"><input type="text" class="form-control input-sm" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px; max-height: 177px; overflow-y: auto;"><li class="dropdown-header" data-optgroup="1"><span class="text">Currently Selected</span></li><li data-original-index="0" data-optgroup="1" class="selected active"><a tabindex="0" class="opt  " style="" data-tokens="null"><span class="text">' + data.holding + '</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul><div class="status" style="">Start typing a search query</div></div>');
                $('#select_holding_company_tab_modal > #holding_company_tab_modal').replaceWith('<select id="holding_company_tab_modal" class="holding-company-tab-modal with-ajax" data-live-search="true" data-width="100%" tabindex="-98"><optgroup label="Currently Selected"><option value="' + data.holdingId + '" selected="selected">' + data.holding + '</option></optgroup></select>');

                $('.holding-company-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsHoldingCompanyTabModal);
                $('.holding-company-tab-modal').trigger('change');
                $('button[data-id="holding_company_tab_modal"]').addClass("btn-sm");

                $('.bs-searchbox > input.form-control').addClass("input-sm");

                $('#company_company_tab_modal').val(data.company);
                $('#company_desc_company_tab_modal').val(data.description);
                $('#id_company_tab_modal').val(id);

                $('#btn_save_company_tab_modal').val("UPDATE").removeAttr("disabled");
                $('#company_tab_modal_title').text("EDIT COMPANY");
                $('#ajax_process_modal').modal('hide');
                $('#company_tab_modal').modal('show');
            },
            error: function() {
                $('#ajax_process_modal').modal('hide');
            }
        });
    });
    // End Edit Comapany

    // Press Enter company_tab_modal
    $("#company_tab_modal").keypress(function(e) {
        switch (e.which) {
            case 13:
                $("#btn_save_company_tab_modal").trigger("click");
                break;
        }
    });
    // End Press Enter company_tab_modal

    // Save Company
    $("#btn_save_company_tab_modal").click(function() {
        var formData = {
            tbl_holding_id: $('#holding_company_tab_modal').val().trim(),
            company: $('#company_company_tab_modal').val().trim(),
            description: $('#company_desc_company_tab_modal').val().trim(),
            created_by: $('#logged_in_user').val(),
            last_updated_by: $('#logged_in_user').val(),
        }

        var state = $('#btn_save_company_tab_modal').val();
        var type = "POST";
        var url = 'settings/add-company';
        var companyId = $('#id_company_tab_modal').val();

        if (state == "UPDATE") {
            type = "PUT";
            url = 'settings/update-company/' + companyId;
        }

        $.ajax({
            type: type,
            url: url,
            data: formData,
            dataType: 'json',
            beforeSend: function(data) {
                $("#company_tab_modal :input").prop('disabled', true);
                $(".error_saving_company_tab_modal").hide();
                $(".error_updating_company_tab_modal").hide();

                if (state == "SAVE") {
                    $(".saving_company_tab_modal").show();
                } else {
                    $(".updating_company_tab_modal").show();
                }

                $("#form_company_company_tab_modal").removeClass("has-error");
                $("#company_company_tab_modal + p.help-block").text("");
                $("#form_holding_company_tab_modal").removeClass("has-error");
                $("#holding_company_tab_modal + p.help-block").text("");
                $("#form_company_desc_company_tab_modal").removeClass("has-error");
                $("#company_desc_company_tab_modal + p.help-block").text("");
            },
            success: function(data) {
                $('#company_tab_modal_form').trigger("reset");
                $(".saving_company_tab_modal").hide();
                $(".updating_company_tab_modal").hide();

                $('#company_tab_modal').modal('hide');
                reload_company_table();
                $("#company_tab_modal :input").prop('disabled', false);

                $("#form_company_company_tab_modal").removeClass("has-error");
                $("#company_company_tab_modal + p.help-block").text("");
                $("#form_holding_company_tab_modal").removeClass("has-error");
                $("#holding_company_tab_modal + p.help-block").text("");
                $("#form_company_desc_company_tab_modal").removeClass("has-error");
                $("#company_desc_company_tab_modal + p.help-block").text("");
            },
            error: function(data) {
                $(".saving_company_tab_modal").hide();
                $(".updating_company_tab_modal").hide();
                if (state == "SAVE") {
                    $(".error_saving_company_tab_modal").show();
                } else {
                    $(".error_updating_company_tab_modal").show();
                }
                $("#company_tab_modal :input").prop('disabled', false);

                var errors = data.responseJSON;

                if (errors.company) {
                    $("#form_company_company_tab_modal").addClass("has-error");
                    $("#company_company_tab_modal + p.help-block").text(errors.company);
                } else {
                    $("#form_company_company_tab_modal").removeClass("has-error");
                    $("#company_company_tab_modal + p.help-block").text("");
                }

                if (errors.holding) {
                    $("#form_holding_company_tab_modal").addClass("has-error");
                    $("#holding_company_tab_modal + p.help-block").text(errors.holding);
                } else {
                    $("#form_holding_company_tab_modal").removeClass("has-error");
                    $("#holding_company_tab_modal + p.help-block").text("");
                }

                if (errors.description) {
                    $("#form_company_desc_company_tab_modal").addClass("has-error");
                    $("#company_desc_company_tab_modal + p.help-block").text(errors.description);
                } else {
                    $("#form_company_desc_company_tab_modal").removeClass("has-error");
                    $("#company_desc_company_tab_modal + p.help-block").text("");
                }
            }
        });
    });
    // End Save Company

    // Delete Company
    $(document).on('click', '.delete-cp', function() {
        id = $(this).attr('data-id');

        var company = $("table#company_table tr#" + id + " td:eq(1)").html();
        var description = $("table#company_table tr#" + id + " td:eq(2)").html();
        var msg = "<table class=\"table table-striped\">";
        msg += "<thead><tr><th>COMPANY</th><th>DESCRIPTION</th></thead>";
        msg += "<tbody><tr><td>" + company + "</td><td>" + description + "</td></tr></tbody>";
        msg += "</table>";

        bootbox.dialog({
            message: msg,
            title: "Are you sure you want to delete this Company?",
            buttons: {
                success: {
                    label: "YES DELETE",
                    className: "btn-danger btn-sm",
                    callback: function() {
                        $.ajax({
                            type: "DELETE",
                            url: 'settings/delete-company/' + id,
                            beforeSend: function() {},
                            success: function() {
                                reload_company_table();
                            },
                            error: function() {
                                alert('Cannot delete this Company.');
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
    // End Delete Company

    // Company Modal hide
    $('#company_tab_modal').on('hide.bs.modal', function(e) {
        $('#select_holding_company_tab_modal').html('<select id="holding_company_tab_modal" class="holding-company-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');

        $(".error_saving_company_tab_modal").hide();
        $(".error_updating_company_tab_modal").hide();

        $('#company_tab_modal_form').trigger("reset");

        $("#form_company_company_tab_modal").removeClass("has-error");
        $("#company_company_tab_modal + p.help-block").text("");
        $("#form_holding_company_tab_modal").removeClass("has-error");
        $("#holding_company_tab_modal + p.help-block").text("");
        $("#form_company_desc_company_tab_modal").removeClass("has-error");
        $("#company_desc_company_tab_modal + p.help-block").text("");
    });
    // End Company Modal Hide

    // END HOLDING-BIN COMPANY TAB
    // ============================================================
    // ============================================================




    // START HOLDING-BIN PLANT TAB
    // ============================================================
    // ============================================================

    var datatable_plant_tab;
    $("#plant_tab").one("click", function() {

        datatable_plant_tab = $('#plant_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'settings/datatables-plant',
                data: function(d) {
                    d.holdingId = $('#holding_plant_tab').val();
                    d.companyId = $('#company_plant_tab').val();
                },
            },
            columns: [{
                data: 'rownum',
                name: 'rownum',
                searchable: false
            }, {
                data: 'created_at',
                name: 'created_at',
                searchable: false
            }, {
                data: 'plant',
                name: 'tbl_plant.plant'
            }, {
                data: 'description',
                name: 'tbl_plant.description'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
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
                "sSearch": "",
                "sSearchPlaceholder": "SEARCH",
            },
            dom: "<'row'<'col-sm-6'l>f>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            columnDefs: [{
                "targets": [1],
                "visible": false,
            }, ],
            order: [
                [1, 'desc']
            ]
        });

        $("select.form-control").selectpicker();
        $("div.dataTables_length > label > div.btn-group > button").addClass("btn-sm");

        var filterPlant = '<div class="col-sm-2" id="select_holding_plant_tab">';
        filterPlant += '<select id="holding_plant_tab" class="holding-plant-tab with-ajax" data-live-search="true" data-width="100%"></select>';
        filterPlant += '</div>';

        filterPlant += '<div class="col-sm-2" id="select_company_plant_tab">';
        filterPlant += '<select id="company_plant_tab" class="company-plant-tab with-ajax" data-live-search="true" data-width="100%" disabled></select>';
        filterPlant += '</div>';

        $(filterPlant).insertBefore("#plant_table_filter");
        $('#plant_table_filter').addClass('col-sm-2').css("padding-left", "0px");

        // FILTER TOP Plant Tab
        // Filter Holding Top Plant Tab
        var optionsHoldingPlantTab = {
            ajax: {
                url: 'settings/select-holding',
                type: 'POST',
                dataType: 'json',
            },
            locale: {
                emptyTitle: 'ALL HOLDING',
                statusInitialized: 'Start typing...'
            },
            preprocessData: function(data) {
                var i, l = data.length,
                    array = [];
                if (l) {
                    for (i = 0; i < l; i++) {
                        array.push($.extend(true, data[i], {
                            text: data[i].holding,
                            value: data[i].id,
                        }));
                    }
                }
                return array;
            }
        };
        $('.holding-plant-tab').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsHoldingPlantTab);
        $('.holding-plant-tab').trigger('change');

        $('button[data-id="holding_plant_tab"]').addClass("btn-sm");

        var companySelect = '<div class="btn-group bootstrap-select disabled company-plant-tab with-ajax" style="width: 100%;">';
        companySelect += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="company_plant_tab" tabindex="-1" title="ALL COMPANY"><span class="filter-option pull-left">ALL COMPANY</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
        companySelect += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
        companySelect += '<select id="company_plant_tab" class="company-plant-tab with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="ALL COMPANY"><option class="bs-title-option" value="">ALL COMPANY</option></select>';
        companySelect += '</div>';
        $("#select_company_plant_tab").html(companySelect);
        // End Filter Holding Top Plant Tab

        $(document).ajaxComplete(function() {
            // Changed Holding Top Plant Tab
            $('#holding_plant_tab').on('changed.bs.select', function(e) {
                $('#select_company_plant_tab').html('<select id="company_plant_tab" class="company-plant-tab with-ajax" data-live-search="true" data-width="100%"></select>');

                var holdingId = $(this).val();
                var optionsCompanyPlantTab = {
                    ajax: {
                        url: 'settings/select-company/' + holdingId,
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'ALL COMPANY',
                        statusInitialized: 'Start typing...'
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
                $('.company-plant-tab').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsCompanyPlantTab);
                $('.company-plant-tab').trigger('change');
                $('button[data-id="company_plant_tab"]').addClass("btn-sm");
                datatable_plant_tab.ajax.reload(null, false).unbind();
            });
            // End Changed Holding Top Plant Tab

            // Changed Company Top Plant Tab
            $('#company_plant_tab').on('changed.bs.select', function(e) {
                datatable_plant_tab.ajax.reload(null, false).unbind();
            });
            // End Changed Company Top Plant Tab
        });

        // Right Click Holding Filter Top Plant Tab
        new BootstrapMenu('button[data-id="holding_plant_tab"]', {
            actions: [{
                name: 'SELECT ALL HOLDING',
                onClick: function() {
                    if ($('#holding_plant_tab').prop('disabled') == false) {
                        $('#holding_plant_tab').val([]);
                        $('#holding_plant_tab').trigger('change.abs.preserveSelected');
                        $('#holding_plant_tab').selectpicker('refresh');
                        $('#holding_plant_tab').trigger("click");
                    }

                    if ($('#company_plant_tab').prop('disabled') == false) {
                        $('#company_plant_tab').val([]);
                        $('#company_plant_tab').prop('disabled', true);
                        $('#company_plant_tab').trigger('change.abs.preserveSelected');
                        $('#company_plant_tab').selectpicker('refresh');
                        $('#company_plant_tab').trigger("click");
                    }
                    datatable_plant_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Holding Filter Top Plant Tab

        // Right Click Company Filter Top Plant Tab
        new BootstrapMenu('button[data-id="company_plant_tab"]', {
            actions: [{
                name: 'SELECT ALL COMPANY',
                onClick: function() {

                    if ($('#company_plant_tab').prop('disabled') == false) {
                        $('#company_plant_tab').val([]);
                        $('#company_plant_tab').prop('disabled', true);
                        $('#company_plant_tab').trigger('change.abs.preserveSelected');
                        $('#company_plant_tab').selectpicker('refresh');
                        $('#company_plant_tab').trigger("click");
                    }
                    datatable_plant_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Company Filter Top Plant Tab

        // Right Click Datatables Plant Tab
        new BootstrapMenu('table#plant_table', {
            actions: [{
                name: 'REFRESH PLANT DATA',
                onClick: function() {
                    datatable_plant_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Datatables Plant Tab
    });

    // Reload Plant DataTables
    function reload_plant_table() {
        datatable_plant_tab.ajax.reload(null, false);
    }
    // End Reload Plant DataTables

    // Add Plant
    $(document).on('click', '#add-pl', function() {
        var optionsHoldingPlantTabModal = {
            ajax: {
                url: 'settings/select-holding',
                type: 'POST',
                dataType: 'json',
            },
            locale: {
                emptyTitle: 'SELECT HOLDING',
            },
            preprocessData: function(data) {
                var i, l = data.length,
                    array = [];
                if (l) {
                    for (i = 0; i < l; i++) {
                        array.push($.extend(true, data[i], {
                            text: data[i].holding,
                            value: data[i].id,
                        }));
                    }
                }
                return array;
            }
        };

        $('.holding-plant-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsHoldingPlantTabModal);
        $('.holding-plant-tab-modal').trigger('change');
        $('button[data-id="holding_plant_tab_modal"]').addClass("btn-sm");
        $('.bs-searchbox > input.form-control').addClass("input-sm");

        var companySelectModal = '<div class="btn-group bootstrap-select disabled company-plant-tab-modal with-ajax" style="width: 100%;">';
        companySelectModal += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="company_plant_tab_modal" tabindex="-1" title="SELECT COMPANY"><span class="filter-option pull-left">SELECT COMPANY</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
        companySelectModal += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
        companySelectModal += '<select id="company_plant_tab_modal" class="company-plant-tab-modal with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="SELECT COMPANY"><option class="bs-title-option" value="">SELECT COMPANY</option></select>';
        companySelectModal += '</div>';
        $("#select_company_plant_tab_modal").html(companySelectModal);

        $('#btn_save_plant_tab_modal').val("SAVE").removeAttr("disabled");
        $('#plant_tab_modal_title').text("ADD PLANT");
        $('#plant_tab_modal').modal('show');
    });
    // End Add Plant

    // Edit Plant
    $(document).on('click', '.edit-pl', function() {
        id = $(this).attr('data-id');

        $.ajax({
            url: 'settings/edit-plant/' + id,
            type: 'GET',
            beforeSend: function() {
                $('#ajax_process_modal').modal('show');
            },
            success: function(data) {
                var optionsHoldingPlantTabModal = {
                    ajax: {
                        url: 'settings/select-holding',
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'SELECT HOLDING',
                    },
                    preprocessData: function(data) {
                        var i, l = data.length,
                            array = [];
                        if (l) {
                            for (i = 0; i < l; i++) {
                                array.push($.extend(true, data[i], {
                                    text: data[i].holding,
                                    value: data[i].id,
                                }));
                            }
                        }
                        return array;
                    }
                };

                $("#select_holding_plant_tab_modal > button[title='SELECT HOLDING']").replaceWith('<button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" data-id="holding_plant_tab_modal" title="' + data.holding + '"><span class="filter-option pull-left">' + data.holding + '</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>');
                $('#select_holding_plant_tab_modal > .dropdown-menu.open').replaceWith('<div class="dropdown-menu open" style="min-height: 39px; max-height: 228px; overflow: hidden;"><div class="bs-searchbox"><input type="text" class="form-control input-sm" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px; max-height: 177px; overflow-y: auto;"><li class="dropdown-header" data-optgroup="1"><span class="text">Currently Selected</span></li><li data-original-index="0" data-optgroup="1" class="selected active"><a tabindex="0" class="opt  " style="" data-tokens="null"><span class="text">' + data.holding + '</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul><div class="status" style="">Start typing a search query</div></div>');
                $('#select_holding_plant_tab_modal > #holding_plant_tab_modal').replaceWith('<select id="holding_plant_tab_modal" class="holding-plant-tab-modal with-ajax" data-live-search="true" data-width="100%" tabindex="-98"><optgroup label="Currently Selected"><option value="' + data.holdingId + '" selected="selected">' + data.holding + '</option></optgroup></select>');

                $('.holding-plant-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsHoldingPlantTabModal);
                $('.holding-plant-tab-modal').trigger('change');
                $('button[data-id="holding_plant_tab_modal"]').addClass("btn-sm");

                var holdingId = data.holding;
                var optionsCompanyPlantTabModal = {
                    ajax: {
                        url: 'settings/select-company/' + holdingId,
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

                $("#select_company_palnt_tab_modal > button[title='SELECT COMPANY']").replaceWith('<button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" data-id="company_plant_tab_modal" title="' + data.company + '"><span class="filter-option pull-left">' + data.company + '</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>');
                $('#select_company_plant_tab_modal > .dropdown-menu.open').replaceWith('<div class="dropdown-menu open" style="min-height: 39px; max-height: 228px; overflow: hidden;"><div class="bs-searchbox"><input type="text" class="form-control input-sm" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px; max-height: 177px; overflow-y: auto;"><li class="dropdown-header" data-optgroup="1"><span class="text">Currently Selected</span></li><li data-original-index="0" data-optgroup="1" class="selected active"><a tabindex="0" class="opt  " style="" data-tokens="null"><span class="text">' + data.company + '<small class="text-muted">' + data.company_desc + '</small></span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul><div class="status" style="">Start typing a search query</div></div>');
                $('#select_company_plant_tab_modal > #company_plant_tab_modal').replaceWith('<select id="company_plant_tab_modal" class="company-plant-tab-modal with-ajax" data-live-search="true" data-width="100%" tabindex="-98"><optgroup label="Currently Selected"><option value="' + data.companyId + '" selected="selected">' + data.company + '</option></optgroup></select>');

                $('.company-plant-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsCompanyPlantTabModal);
                $('.company-plant-tab-modal').trigger('change');
                $('button[data-id="company_plant_tab_modal"]').addClass("btn-sm");

                $('.bs-searchbox > input.form-control').addClass("input-sm");

                $('#plant_plant_tab_modal').val(data.plant);
                $('#plant_desc_plant_tab_modal').val(data.description);
                $('#id_plant_tab_modal').val(id);

                $('#btn_save_plant_tab_modal').val("UPDATE").removeAttr("disabled");
                $('#plant_tab_modal_title').text("EDIT PLANT");
                $('#ajax_process_modal').modal('hide');
                $('#plant_tab_modal').modal('show');
            },
            error: function() {
                $('#ajax_process_modal').modal('hide');
            }
        });
    });
    // End Edit Plant

    // Press Enter plant_tab_modal
    $("#plant_tab_modal").keypress(function(e) {
        switch (e.which) {
            case 13:
                $("#btn_save_plant_tab_modal").trigger("click");
                break;
        }
    });
    // End Press Enter plant_tab_modal

    // Save Plant
    $("#btn_save_plant_tab_modal").click(function() {
        var formData = {
            plant: $('#plant_plant_tab_modal').val().trim(),
            description: $('#plant_desc_plant_tab_modal').val().trim(),
            tbl_company_id: $('#company_plant_tab_modal').val(),
            created_by: $('#logged_in_user').val(),
            last_updated_by: $('#logged_in_user').val(),
        }

        var state = $('#btn_save_plant_tab_modal').val();
        var type = "POST";
        var url = 'settings/add-plant';
        var plantId = $('#id_plant_tab_modal').val();

        if (state == "UPDATE") {
            type = "PUT";
            url = 'settings/update-plant/' + plantId;
        }

        $.ajax({
            type: type,
            url: url,
            data: formData,
            dataType: 'json',
            beforeSend: function(data) {
                $("#plant_tab_modal :input").prop('disabled', true);
                $(".error_saving_plant_tab_modal").hide();
                $(".error_updating_plant_tab_modal").hide();

                if (state == "SAVE") {
                    $(".saving_plant_tab_modal").show();
                } else {
                    $(".updating_plant_tab_modal").show();
                }

                $("#form_plant_plant_tab_modal").removeClass("has-error");
                $("#plant_plant_tab_modal + p.help-block").text("");
                $("#form_company_plant_tab_modal").removeClass("has-error");
                $("#company_plant_tab_modal + p.help-block").text("");
                $("#form_plant_desc_plant_tab_modal").removeClass("has-error");
                $("#plant_desc_plant_tab_modal + p.help-block").text("");
            },
            success: function(data) {
                $('#plant_tab_modal_form').trigger("reset");
                $(".saving_plant_tab_modal").hide();
                $(".updating_plant_tab_modal").hide();

                $('#plant_tab_modal').modal('hide');
                reload_plant_table();
                $("#plant_tab_modal :input").prop('disabled', false);

                $("#form_plant_plant_tab_modal").removeClass("has-error");
                $("#plant_plant_tab_modal + p.help-block").text("");
                $("#form_company_plant_tab_modal").removeClass("has-error");
                $("#company_plant_tab_modal + p.help-block").text("");
                $("#form_plant_desc_plant_tab_modal").removeClass("has-error");
                $("#plant_desc_plant_tab_modal + p.help-block").text("");
            },
            error: function(data) {
                $(".saving_plant_tab_modal").hide();
                $(".updating_plant_tab_modal").hide();
                if (state == "SAVE") {
                    $(".error_saving_plant_tab_modal").show();
                } else {
                    $(".error_updating_plant_tab_modal").show();
                }
                $("#plant_tab_modal :input").prop('disabled', false);

                var errors = data.responseJSON;

                if (errors.plant) {
                    $("#form_plant_plant_tab_modal").addClass("has-error");
                    $("#plant_plant_tab_modal + p.help-block").text(errors.plant);
                } else {
                    $("#form_plant_plant_tab_modal").removeClass("has-error");
                    $("#plant_plant_tab_modal + p.help-block").text("");
                }

                if (errors.company) {
                    $("#form_company_plant_tab_modal").addClass("has-error");
                    $("#company_plant_tab_modal + p.help-block").text(errors.company);
                } else {
                    $("#form_company_plant_tab_modal").removeClass("has-error");
                    $("#company_plant_tab_modal + p.help-block").text("");
                }

                if (errors.description) {
                    $("#form_plant_desc_plant_tab_modal").addClass("has-error");
                    $("#plant_desc_plant_tab_modal + p.help-block").text(errors.description);
                } else {
                    $("#form_plant_desc_plant_tab_modal").removeClass("has-error");
                    $("#plant_desc_plant_tab_modal + p.help-block").text("");
                }
            }
        });
    });
    // End Save Plant

    // Delete Plant
    $(document).on('click', '.delete-pl', function() {
        id = $(this).attr('data-id');

        var plant = $("table#plant_table tr#" + id + " td:eq(1)").html();
        var description = $("table#plant_table tr#" + id + " td:eq(2)").html();
        var msg = "<table class=\"table table-striped\">";
        msg += "<thead><tr><th>PLANT</th><th>DESCRIPTION</th></thead>";
        msg += "<tbody><tr><td>" + plant + "</td><td>" + description + "</td></tr></tbody>";
        msg += "</table>";

        bootbox.dialog({
            message: msg,
            title: "Are you sure you want to delete this Plant?",
            buttons: {
                success: {
                    label: "YES DELETE",
                    className: "btn-danger btn-sm",
                    callback: function() {
                        $.ajax({
                            type: "DELETE",
                            url: 'settings/delete-plant/' + id,
                            beforeSend: function() {},
                            success: function() {
                                reload_plant_table();
                            },
                            error: function() {
                                alert('Cannot delete this Plant.');
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
    // End Delete Plant

    // Changed Select inside Plant Modal
    $(document).ajaxComplete(function() {

        $('#holding_plant_tab_modal').on('changed.bs.select', function(e) {
            $('#select_company_plant_tab_modal').html('<select id="company_plant_tab_modal" class="company-plant-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');

            var holdingId = $(this).val();
            var optionsCompanyPlantTabModal = {
                ajax: {
                    url: 'settings/select-company/' + holdingId,
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

            $('.company-plant-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsCompanyPlantTabModal);
            $('.company-plant-tab-modal').trigger('change');
            $('button[data-id="company_plant_tab_modal"]').addClass("btn-sm");
            $('.bs-searchbox > input.form-control').addClass("input-sm");
        });

    });
    // End Changed Select inside Plant Modal

    // Plant Modal hide
    $('#plant_tab_modal').on('hide.bs.modal', function(e) {
        $('#select_holding_plant_tab_modal').html('<select id="holding_plant_tab_modal" class="holding-plant-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');
        $('#select_company_plant_tab_modal').html('<select id="company_plant_tab_modal" class="company-plant-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');

        $(".error_saving_plant_tab_modal").hide();
        $(".error_updating_plant_tab_modal").hide();

        $('#plant_tab_modal_form').trigger("reset");

        $("#form_plant_plant_tab_modal").removeClass("has-error");
        $("#plant_plant_tab_modal + p.help-block").text("");
        $("#form_company_plant_tab_modal").removeClass("has-error");
        $("#company_plant_tab_modal + p.help-block").text("");
        $("#form_plant_desc_plant_tab_modal").removeClass("has-error");
        $("#plant_desc_plant_tab_modal + p.help-block").text("");
    });
    // End Plant Modal Hide

    // END HOLDING-BIN PLANT TAB
    // ============================================================
    // ============================================================




    // START HOLDING-BIN LOCATION TAB
    // ============================================================
    // ============================================================

    var datatable_location_tab;
    $("#location_tab").one("click", function() {

        datatable_location_tab = $('#location_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'settings/datatables-location',
                data: function(d) {
                    d.holdingId = $('#holding_location_tab').val();
                    d.companyId = $('#company_location_tab').val();
                    d.plantId = $('#plant_location_tab').val();
                },
            },
            columns: [{
                data: 'rownum',
                name: 'rownum',
                searchable: false
            }, {
                data: 'created_at',
                name: 'created_at',
                searchable: false
            }, {
                data: 'location',
                name: 'tbl_location.location'
            }, {
                data: 'description',
                name: 'tbl_location.description'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
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
                "sSearch": "",
                "sSearchPlaceholder": "SEARCH",
            },
            dom: "<'row'<'col-sm-4'l>f>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            columnDefs: [{
                "targets": [1],
                "visible": false,
            }, ],
            order: [
                [1, 'desc']
            ]
        });

        $("select.form-control").selectpicker();
        $("div.dataTables_length > label > div.btn-group > button").addClass("btn-sm");

        var filterLocation = '<div class="col-sm-2" id="select_holding_location_tab">';
        filterLocation += '<select id="holding_location_tab" class="holding-location-tab with-ajax" data-live-search="true" data-width="100%"></select>';
        filterLocation += '</div>';

        filterLocation += '<div class="col-sm-2" id="select_company_location_tab">';
        filterLocation += '<select id="company_location_tab" class="company-location-tab with-ajax" data-live-search="true" data-width="100%" disabled></select>';
        filterLocation += '</div>';

        filterLocation += '<div class="col-sm-2" id="select_plant_location_tab">';
        filterLocation += '<select id="plant_location_tab" class="plant-location-tab with-ajax" data-live-search="true" data-width="100%" disabled></select>';
        filterLocation += '</div>';


        $(filterLocation).insertBefore("#location_table_filter");
        $('#location_table_filter').addClass('col-sm-2').css("padding-left", "0px");

        // FILTER TOP Location Tab
        // Filter Holding Top Location Tab
        var optionsHoldingLocationTab = {
            ajax: {
                url: 'settings/select-holding',
                type: 'POST',
                dataType: 'json',
            },
            locale: {
                emptyTitle: 'ALL HOLDING',
                statusInitialized: 'Start typing...'
            },
            preprocessData: function(data) {
                var i, l = data.length,
                    array = [];
                if (l) {
                    for (i = 0; i < l; i++) {
                        array.push($.extend(true, data[i], {
                            text: data[i].holding,
                            value: data[i].id,
                        }));
                    }
                }
                return array;
            }
        };
        $('.holding-location-tab').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsHoldingLocationTab);
        $('.holding-location-tab').trigger('change');

        $('button[data-id="holding_location_tab"]').addClass("btn-sm");

        var companySelect = '<div class="btn-group bootstrap-select disabled company-location-tab with-ajax" style="width: 100%;">';
        companySelect += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="company_location_tab" tabindex="-1" title="ALL COMPANY"><span class="filter-option pull-left">ALL COMPANY</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
        companySelect += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
        companySelect += '<select id="company_location_tab" class="company-location-tab with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="ALL COMPANY"><option class="bs-title-option" value="">ALL COMPANY</option></select>';
        companySelect += '</div>';
        $("#select_company_location_tab").html(companySelect);

        var plantSelect = '<div class="btn-group bootstrap-select disabled plant-location-tab with-ajax" style="width: 100%;">';
        plantSelect += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="plant_location_tab" tabindex="-1" title="ALL PLANT"><span class="filter-option pull-left">ALL PLANT</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
        plantSelect += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
        plantSelect += '<select id="plant_location_tab" class="plant-location-tab with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="ALL PLANT"><option class="bs-title-option" value="">ALL PLANT</option></select>';
        plantSelect += '</div>';
        $("#select_plant_location_tab").html(plantSelect);
        // End Filter Holding Top Location Tab

        $(document).ajaxComplete(function() {
            // Changed Holding Top Location Tab
            $('#holding_location_tab').on('changed.bs.select', function(e) {
                $('#select_company_location_tab').html('<select id="company_location_tab" class="company-location-tab with-ajax" data-live-search="true" data-width="100%"></select>');

                var plantSelect = '<div class="btn-group bootstrap-select disabled plant-location-tab with-ajax" style="width: 100%;">';
                plantSelect += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="plant_location_tab" tabindex="-1" title="ALL PLANT"><span class="filter-option pull-left">ALL PLANT</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
                plantSelect += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
                plantSelect += '<select id="plant_location_tab" class="plant-location-tab with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="ALL PLANT"><option class="bs-title-option" value="">ALL PLANT</option></select>';
                plantSelect += '</div>';
                $("#select_plant_location_tab").html(plantSelect);

                var holdingId = $(this).val();
                var optionsCompanyLocationTab = {
                    ajax: {
                        url: 'settings/select-company/' + holdingId,
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'ALL COMPANY',
                        statusInitialized: 'Start typing...'
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
                $('.company-location-tab').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsCompanyLocationTab);
                $('.company-location-tab').trigger('change');
                $('button[data-id="company_location_tab"]').addClass("btn-sm");
                datatable_location_tab.ajax.reload(null, false).unbind();
            });
            // End Changed Holding Top Location Tab

            // Changed Company Top Location Tab
            $('#company_location_tab').on('changed.bs.select', function(e) {
                $('#select_plant_location_tab').html('<select id="plant_location_tab" class="plant-location-tab with-ajax" data-live-search="true" data-width="100%"></select>');

                var companyId = $(this).val();
                var optionsPlantLocationTab = {
                    ajax: {
                        url: 'settings/select-plant/' + companyId,
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'ALL PLANT',
                        statusInitialized: 'Start typing...'
                    },
                    preprocessData: function(data) {
                        var i, l = data.length,
                            array = [];
                        if (l) {
                            for (i = 0; i < l; i++) {
                                array.push($.extend(true, data[i], {
                                    text: data[i].plant,
                                    value: data[i].id,
                                }));
                            }
                        }
                        return array;
                    }
                };
                $('.plant-location-tab').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsPlantLocationTab);
                $('.plant-location-tab').trigger('change');
                $('button[data-id="plant_location_tab"]').addClass("btn-sm");
                datatable_location_tab.ajax.reload(null, false).unbind();
            });
            // End Changed Company Top Location Tab

            // Changed Plant Top Location Tab
            $('#plant_location_tab').on('changed.bs.select', function(e) {
                datatable_location_tab.ajax.reload(null, false).unbind();
            });
            // End Changed Plant Top Location Tab

        });

        // Right Click Holding Filter Top Location Tab
        new BootstrapMenu('button[data-id="holding_location_tab"]', {
            actions: [{
                name: 'SELECT ALL HOLDING',
                onClick: function() {
                    if ($('#holding_location_tab').prop('disabled') == false) {
                        $('#holding_location_tab').val([]);
                        $('#holding_location_tab').trigger('change.abs.preserveSelected');
                        $('#holding_location_tab').selectpicker('refresh');
                        $('#holding_location_tab').trigger("click");
                    }

                    if ($('#company_location_tab').prop('disabled') == false) {
                        $('#company_location_tab').val([]);
                        $('#company_location_tab').prop('disabled', true);
                        $('#company_location_tab').trigger('change.abs.preserveSelected');
                        $('#company_location_tab').selectpicker('refresh');
                        $('#company_location_tab').trigger("click");
                    }

                    if ($('#plant_location_tab').prop('disabled') == false) {
                        $('#plant_location_tab').val([]);
                        $('#plant_location_tab').prop('disabled', true);
                        $('#plant_location_tab').trigger('change.abs.preserveSelected');
                        $('#plant_location_tab').selectpicker('refresh');
                        $('#plant_location_tab').trigger("click");
                    }
                    datatable_location_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Holding Filter Top Location Tab

        // Right Click Company Filter Top Location Tab
        new BootstrapMenu('button[data-id="company_location_tab"]', {
            actions: [{
                name: 'SELECT ALL COMPANY',
                onClick: function() {

                    if ($('#company_location_tab').prop('disabled') == false) {
                        $('#company_location_tab').val([]);
                        $('#company_location_tab').prop('disabled', true);
                        $('#company_location_tab').trigger('change.abs.preserveSelected');
                        $('#company_location_tab').selectpicker('refresh');
                        $('#company_location_tab').trigger("click");
                    }

                    if ($('#plant_location_tab').prop('disabled') == false) {
                        $('#plant_location_tab').val([]);
                        $('#plant_location_tab').prop('disabled', true);
                        $('#plant_location_tab').trigger('change.abs.preserveSelected');
                        $('#plant_location_tab').selectpicker('refresh');
                        $('#plant_location_tab').trigger("click");
                    }
                    datatable_location_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Company Filter Top Location Tab

        // Right Click Plant Filter Top Location Tab
        new BootstrapMenu('button[data-id="plant_location_tab"]', {
            actions: [{
                name: 'SELECT ALL PLANT',
                onClick: function() {

                    if ($('#plant_location_tab').prop('disabled') == false) {
                        $('#plant_location_tab').val([]);
                        $('#plant_location_tab').prop('disabled', true);
                        $('#plant_location_tab').trigger('change.abs.preserveSelected');
                        $('#plant_location_tab').selectpicker('refresh');
                        $('#plant_location_tab').trigger("click");
                    }
                    datatable_location_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Plant Filter Top Location Tab

        // Right Click Datatables Location Tab
        new BootstrapMenu('table#location_table', {
            actions: [{
                name: 'REFRESH LOCATION DATA',
                onClick: function() {
                    datatable_location_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Datatables Location Tab
    });

    // Reload Location DataTables
    function reload_location_table() {
        datatable_location_tab.ajax.reload(null, false);
    }
    // End Reload Location DataTables

    // Add Location
    $(document).on('click', '#add-loc', function() {
        var optionsHoldingLocationTabModal = {
            ajax: {
                url: 'settings/select-holding',
                type: 'POST',
                dataType: 'json',
            },
            locale: {
                emptyTitle: 'SELECT HOLDING',
            },
            preprocessData: function(data) {
                var i, l = data.length,
                    array = [];
                if (l) {
                    for (i = 0; i < l; i++) {
                        array.push($.extend(true, data[i], {
                            text: data[i].holding,
                            value: data[i].id,
                        }));
                    }
                }
                return array;
            }
        };

        $('.holding-location-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsHoldingLocationTabModal);
        $('.holding-location-tab-modal').trigger('change');
        $('button[data-id="holding_location_tab_modal"]').addClass("btn-sm");
        $('.bs-searchbox > input.form-control').addClass("input-sm");

        var companySelectModal = '<div class="btn-group bootstrap-select disabled company-location-tab-modal with-ajax" style="width: 100%;">';
        companySelectModal += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="company_location_tab_modal" tabindex="-1" title="SELECT COMPANY"><span class="filter-option pull-left">SELECT COMPANY</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
        companySelectModal += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
        companySelectModal += '<select id="company_location_tab_modal" class="company-location-tab-modal with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="SELECT COMPANY"><option class="bs-title-option" value="">SELECT COMPANY</option></select>';
        companySelectModal += '</div>';
        $("#select_company_location_tab_modal").html(companySelectModal);

        var plantSelectModal = '<div class="btn-group bootstrap-select disabled plant-location-tab-modal with-ajax" style="width: 100%;">';
        plantSelectModal += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="plant_location_tab_modal" tabindex="-1" title="SELECT PLANT"><span class="filter-option pull-left">SELECT PLANT</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
        plantSelectModal += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
        plantSelectModal += '<select id="plant_location_tab_modal" class="plant-location-tab-modal with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="SELECT PLANT"><option class="bs-title-option" value="">SELECT PLANT</option></select>';
        plantSelectModal += '</div>';
        $("#select_plant_location_tab_modal").html(plantSelectModal);

        $('#btn_save_location_tab_modal').val("SAVE").removeAttr("disabled");
        $('#location_tab_modal_title').text("ADD LOCATION");
        $('#location_tab_modal').modal('show');
    });
    // End Add Location

    // Edit Location
    $(document).on('click', '.edit-loc', function() {
        id = $(this).attr('data-id');
        $.ajax({
            url: 'settings/edit-location/' + id,
            type: 'GET',
            beforeSend: function() {
                $('#ajax_process_modal').modal('show');
            },
            success: function(data) {
                var optionsHoldingLocationTabModal = {
                    ajax: {
                        url: 'settings/select-holding',
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'SELECT HOLDING',
                    },
                    preprocessData: function(data) {
                        var i, l = data.length,
                            array = [];
                        if (l) {
                            for (i = 0; i < l; i++) {
                                array.push($.extend(true, data[i], {
                                    text: data[i].holding,
                                    value: data[i].id,
                                }));
                            }
                        }
                        return array;
                    }
                };

                $("#select_holding_location_tab_modal > button[title='SELECT HOLDING']").replaceWith('<button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" data-id="holding_location_tab_modal" title="' + data.holding + '"><span class="filter-option pull-left">' + data.holding + '</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>');
                $('#select_holding_location_tab_modal > .dropdown-menu.open').replaceWith('<div class="dropdown-menu open" style="min-height: 39px; max-height: 228px; overflow: hidden;"><div class="bs-searchbox"><input type="text" class="form-control input-sm" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px; max-height: 177px; overflow-y: auto;"><li class="dropdown-header" data-optgroup="1"><span class="text">Currently Selected</span></li><li data-original-index="0" data-optgroup="1" class="selected active"><a tabindex="0" class="opt  " style="" data-tokens="null"><span class="text">' + data.holding + '</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul><div class="status" style="">Start typing a search query</div></div>');
                $('#select_holding_location_tab_modal > #holding_location_tab_modal').replaceWith('<select id="holding_location_tab_modal" class="holding-location-tab-modal with-ajax" data-live-search="true" data-width="100%" tabindex="-98"><optgroup label="Currently Selected"><option value="' + data.holdingId + '" selected="selected">' + data.holding + '</option></optgroup></select>');

                $('.holding-location-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsHoldingLocationTabModal);
                $('.holding-location-tab-modal').trigger('change');
                $('button[data-id="holding_location_tab_modal"]').addClass("btn-sm");

                var optionsCompanyLocationTabModal = {
                    ajax: {
                        url: 'settings/select-company/' + data.holdingId,
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

                $("#select_company_location_tab_modal > button[title='SELECT COMPANY']").replaceWith('<button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" data-id="company_location_tab_modal" title="' + data.company + '"><span class="filter-option pull-left">' + data.company + '</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>');
                $('#select_company_location_tab_modal > .dropdown-menu.open').replaceWith('<div class="dropdown-menu open" style="min-height: 39px; max-height: 228px; overflow: hidden;"><div class="bs-searchbox"><input type="text" class="form-control input-sm" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px; max-height: 177px; overflow-y: auto;"><li class="dropdown-header" data-optgroup="1"><span class="text">Currently Selected</span></li><li data-original-index="0" data-optgroup="1" class="selected active"><a tabindex="0" class="opt  " style="" data-tokens="null"><span class="text">' + data.company + '</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul><div class="status" style="">Start typing a search query</div></div>');
                $('#select_company_location_tab_modal > #company_location_tab_modal').replaceWith('<select id="company_location_tab_modal" class="company-location-tab-modal with-ajax" data-live-search="true" data-width="100%" tabindex="-98"><optgroup label="Currently Selected"><option value="' + data.companyId + '" selected="selected">' + data.company + '</option></optgroup></select>');

                $('.company-location-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsCompanyLocationTabModal);
                $('.company-location-tab-modal').trigger('change');
                $('button[data-id="company_location_tab_modal"]').addClass("btn-sm");

                var companyId = data.company;
                var optionsPlantLocationTabModal = {
                    ajax: {
                        url: 'settings/select-plant/' + companyId,
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'SELECT PLANT',
                    },
                    preprocessData: function(data) {
                        var i, l = data.length,
                            array = [];
                        if (l) {
                            for (i = 0; i < l; i++) {
                                array.push($.extend(true, data[i], {
                                    text: data[i].plant,
                                    value: data[i].id,
                                }));
                            }
                        }
                        return array;
                    }
                };

                $("#select_plant_location_tab_modal > button[title='SELECT PLANT']").replaceWith('<button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" data-id="plant_location_tab_modal" title="' + data.plant + '"><span class="filter-option pull-left">' + data.plant + '</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>');
                $('#select_plant_location_tab_modal > .dropdown-menu.open').replaceWith('<div class="dropdown-menu open" style="min-height: 39px; max-height: 228px; overflow: hidden;"><div class="bs-searchbox"><input type="text" class="form-control input-sm" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px; max-height: 177px; overflow-y: auto;"><li class="dropdown-header" data-optgroup="1"><span class="text">Currently Selected</span></li><li data-original-index="0" data-optgroup="1" class="selected active"><a tabindex="0" class="opt  " style="" data-tokens="null"><span class="text">' + data.plant + '</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul><div class="status" style="">Start typing a search query</div></div>');
                $('#select_plant_location_tab_modal > #plant_location_tab_modal').replaceWith('<select id="plant_location_tab_modal" class="plant-location-tab-modal with-ajax" data-live-search="true" data-width="100%" tabindex="-98"><optgroup label="Currently Selected"><option value="' + data.plantId + '" selected="selected">' + data.plant + '</option></optgroup></select>');

                $('.plant-location-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsPlantLocationTabModal);
                $('.plant-location-tab-modal').trigger('change');
                $('button[data-id="plant_location_tab_modal"]').addClass("btn-sm");

                $('.bs-searchbox > input.form-control').addClass("input-sm");

                $('#location_location_tab_modal').val(data.location);
                $('#location_desc_location_tab_modal').val(data.description);
                $('#id_location_tab_modal').val(id);

                $('#btn_save_location_tab_modal').val("UPDATE").removeAttr("disabled");
                $('#location_tab_modal_title').text("EDIT LOCATION");
                $('#ajax_process_modal').modal('hide');
                $('#location_tab_modal').modal('show');
            },
            error: function() {
                $('#ajax_process_modal').modal('hide');
            }
        });
    });
    // End Edit Location

    // Press Enter location_tab_modal
    $("#location_tab_modal").keypress(function(e) {
        switch (e.which) {
            case 13:
                $("#btn_save_location_tab_modal").trigger("click");
                break;
        }
    });
    // End Press Enter location_tab_modal

    // Save Location
    $("#btn_save_location_tab_modal").click(function() {
        var formData = {
            location: $('#location_location_tab_modal').val().trim(),
            description: $('#location_desc_location_tab_modal').val().trim(),
            tbl_plant_id: $('#plant_location_tab_modal').val(),
            created_by: $('#logged_in_user').val(),
            last_updated_by: $('#logged_in_user').val(),
        }

        var state = $('#btn_save_location_tab_modal').val();
        var type = "POST";
        var url = 'settings/add-location';
        var locationId = $('#id_location_tab_modal').val();

        if (state == "UPDATE") {
            type = "PUT";
            url = 'settings/update-location/' + locationId;
        }

        $.ajax({
            type: type,
            url: url,
            data: formData,
            dataType: 'json',
            beforeSend: function(data) {
                $("#location_tab_modal :input").prop('disabled', true);
                $(".error_saving_location_tab_modal").hide();
                $(".error_updating_location_tab_modal").hide();

                if (state == "SAVE") {
                    $(".saving_location_tab_modal").show();
                } else {
                    $(".updating_location_tab_modal").show();
                }

                $("#form_location_location_tab_modal").removeClass("has-error");
                $("#location_location_tab_modal + p.help-block").text("");
                $("#form_plant_location_tab_modal").removeClass("has-error");
                $("#plant_location_tab_modal + p.help-block").text("");
                $("#form_location_desc_location_tab_modal").removeClass("has-error");
                $("#location_desc_location_tab_modal + p.help-block").text("");
            },
            success: function(data) {
                $('#location_tab_modal_form').trigger("reset");
                $(".saving_location_tab_modal").hide();
                $(".updating_location_tab_modal").hide();

                $('#location_tab_modal').modal('hide');
                reload_location_table();
                $("#location_tab_modal :input").prop('disabled', false);

                $("#form_location_location_tab_modal").removeClass("has-error");
                $("#location_location_tab_modal + p.help-block").text("");
                $("#form_plant_location_tab_modal").removeClass("has-error");
                $("#plant_location_tab_modal + p.help-block").text("");
                $("#form_location_desc_location_tab_modal").removeClass("has-error");
                $("#location_desc_location_tab_modal + p.help-block").text("");
            },
            error: function(data) {
                $(".saving_location_tab_modal").hide();
                $(".updating_location_tab_modal").hide();
                if (state == "SAVE") {
                    $(".error_saving_location_tab_modal").show();
                } else {
                    $(".error_updating_location_tab_modal").show();
                }
                $("#location_tab_modal :input").prop('disabled', false);

                var errors = data.responseJSON;

                if (errors.location) {
                    $("#form_location_location_tab_modal").addClass("has-error");
                    $("#location_location_tab_modal + p.help-block").text(errors.location);
                } else {
                    $("#form_location_location_tab_modal").removeClass("has-error");
                    $("#location_location_tab_modal + p.help-block").text("");
                }

                if (errors.plant) {
                    $("#form_plant_location_tab_modal").addClass("has-error");
                    $("#plant_location_tab_modal + p.help-block").text(errors.plant);
                } else {
                    $("#form_plant_location_tab_modal").removeClass("has-error");
                    $("#plant_location_tab_modal + p.help-block").text("");
                }

                if (errors.description) {
                    $("#form_location_desc_location_tab_modal").addClass("has-error");
                    $("#location_desc_location_tab_modal + p.help-block").text(errors.description);
                } else {
                    $("#form_location_desc_location_tab_modal").removeClass("has-error");
                    $("#location_desc_location_tab_modal + p.help-block").text("");
                }
            }
        });
    });
    // End Save Location

    // Delete location
    $(document).on('click', '.delete-loc', function() {
        id = $(this).attr('data-id');

        var location = $("table#location_table tr#" + id + " td:eq(1)").html();
        var description = $("table#location_table tr#" + id + " td:eq(2)").html();
        var msg = "<table class=\"table table-striped\">";
        msg += "<thead><tr><th>LOCATION</th><th>DESCRIPTION</th></thead>";
        msg += "<tbody><tr><td>" + location + "</td><td>" + description + "</td></tr></tbody>";
        msg += "</table>";

        bootbox.dialog({
            message: msg,
            title: "Are you sure you want to delete this Location?",
            buttons: {
                success: {
                    label: "YES DELETE",
                    className: "btn-danger btn-sm",
                    callback: function() {
                        $.ajax({
                            type: "DELETE",
                            url: 'settings/delete-location/' + id,
                            beforeSend: function() {},
                            success: function() {
                                reload_location_table();
                            },
                            error: function() {
                                alert('Cannot delete this Location.');
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
    // End Delete Location

    // Changed Select inside Location Modal
    $(document).ajaxComplete(function() {

        $('#holding_location_tab_modal').on('changed.bs.select', function(e) {
            $('#select_company_location_tab_modal').html('<select id="company_location_tab_modal" class="company-location-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');

            var plantSelectModal = '<div class="btn-group bootstrap-select disabled plant-location-tab-modal with-ajax" style="width: 100%;">';
            plantSelectModal += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="plant_location_tab_modal" tabindex="-1" title="SELECT PLANT"><span class="filter-option pull-left">SELECT PLANT</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
            plantSelectModal += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
            plantSelectModal += '<select id="plant_location_tab_modal" class="plant-location-tab-modal with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="SELECT PLANT"><option class="bs-title-option" value="">SELECT PLANT</option></select>';
            plantSelectModal += '</div>';
            $("#select_plant_location_tab_modal").html(plantSelectModal);

            var holdingId = $(this).val();
            var optionsCompanyLocationTabModal = {
                ajax: {
                    url: 'settings/select-company/' + holdingId,
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

            $('.company-location-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsCompanyLocationTabModal);
            $('.company-location-tab-modal').trigger('change');
            $('button[data-id="company_location_tab_modal"]').addClass("btn-sm");
            $('.bs-searchbox > input.form-control').addClass("input-sm");
        });

        $('#company_location_tab_modal').on('changed.bs.select', function(e) {
            $('#select_plant_location_tab_modal').html('<select id="plant_location_tab_modal" class="plant-location-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');

            var companyId = $(this).val();
            var optionsPlantLocationTabModal = {
                ajax: {
                    url: 'settings/select-plant/' + companyId,
                    type: 'POST',
                    dataType: 'json',
                },
                locale: {
                    emptyTitle: 'SELECT PLANT',
                },
                preprocessData: function(data) {
                    var i, l = data.length,
                        array = [];
                    if (l) {
                        for (i = 0; i < l; i++) {
                            array.push($.extend(true, data[i], {
                                text: data[i].plant,
                                value: data[i].id,
                            }));
                        }
                    }
                    return array;
                }
            };

            $('.plant-location-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsPlantLocationTabModal);
            $('.plant-location-tab-modal').trigger('change');
            $('button[data-id="plant_location_tab_modal"]').addClass("btn-sm");
            $('.bs-searchbox > input.form-control').addClass("input-sm");
        });

    });
    // End Changed Select inside Location Modal

    // Location Modal hide
    $('#location_tab_modal').on('hide.bs.modal', function(e) {
        $('#select_holding_location_tab_modal').html('<select id="holding_location_tab_modal" class="holding-location-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');
        $('#select_company_location_tab_modal').html('<select id="company_location_tab_modal" class="company-location-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');
        $('#select_plant_location_tab_modal').html('<select id="plant_location_tab_modal" class="plant-location-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');

        $(".error_saving_location_tab_modal").hide();
        $(".error_updating_location_tab_modal").hide();

        $('#location_tab_modal_form').trigger("reset");

        $("#form_location_location_tab_modal").removeClass("has-error");
        $("#location_location_tab_modal + p.help-block").text("");
        $("#form_plant_location_tab_modal").removeClass("has-error");
        $("#plant_location_tab_modal + p.help-block").text("");
        $("#form_location_desc_location_tab_modal").removeClass("has-error");
        $("#location_desc_location_tab_modal + p.help-block").text("");
    });
    // End Location Modal Hide

    // END HOLDING-BIN LOCATION TAB
    // ============================================================
    // ============================================================




    // START HOLDING-BIN SHELF TAB
    // ============================================================
    // ============================================================

    var datatable_shelf_tab;
    $("#shelf_tab").one("click", function() {

        datatable_shelf_tab = $('#shelf_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'settings/datatables-shelf',
                data: function(d) {
                    d.holdingId = $('#holding_shelf_tab').val();
                    d.companyId = $('#company_shelf_tab').val();
                    d.plantId = $('#plant_shelf_tab').val();
                    d.locationId = $('#location_shelf_tab').val();
                },
            },
            columns: [{
                data: 'rownum',
                name: 'rownum',
                searchable: false
            }, {
                data: 'created_at',
                name: 'created_at',
                searchable: false
            }, {
                data: 'shelf',
                name: 'tbl_shelf.shelf'
            }, {
                data: 'description',
                name: 'tbl_shelf.description'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
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
                "sSearch": "",
                "sSearchPlaceholder": "SEARCH",
            },
            dom: "<'row'<'col-sm-2'l>f>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            columnDefs: [{
                "targets": [1],
                "visible": false,
            }, ],
            order: [
                [1, 'desc']
            ]
        });

        $("select.form-control").selectpicker();
        $("div.dataTables_length > label > div.btn-group > button").addClass("btn-sm");

        var filterShelf = '<div class="col-sm-2" id="select_holding_shelf_tab">';
        filterShelf += '<select id="holding_shelf_tab" class="holding-shelf-tab with-ajax" data-live-search="true" data-width="100%"></select>';
        filterShelf += '</div>';

        filterShelf += '<div class="col-sm-2" id="select_company_shelf_tab">';
        filterShelf += '<select id="company_shelf_tab" class="company-shelf-tab with-ajax" data-live-search="true" data-width="100%" disabled></select>';
        filterShelf += '</div>';

        filterShelf += '<div class="col-sm-2" id="select_plant_shelf_tab">';
        filterShelf += '<select id="plant_shelf_tab" class="plant-shelf-tab with-ajax" data-live-search="true" data-width="100%" disabled></select>';
        filterShelf += '</div>';

        filterShelf += '<div class="col-sm-2" id="select_location_shelf_tab">';
        filterShelf += '<select id="location_shelf_tab" class="location-shelf-tab with-ajax" data-live-search="true" data-width="100%" disabled></select>';
        filterShelf += '</div>';


        $(filterShelf).insertBefore("#shelf_table_filter");
        $('#shelf_table_filter').addClass('col-sm-2').css("padding-left", "0px");

        // FILTER TOP Shelf Tab
        // Filter Holding Top Shelf Tab
        var optionsHoldingShelfTab = {
            ajax: {
                url: 'settings/select-holding',
                type: 'POST',
                dataType: 'json',
            },
            locale: {
                emptyTitle: 'ALL HOLDING',
                statusInitialized: 'Start typing...'
            },
            preprocessData: function(data) {
                var i, l = data.length,
                    array = [];
                if (l) {
                    for (i = 0; i < l; i++) {
                        array.push($.extend(true, data[i], {
                            text: data[i].holding,
                            value: data[i].id,
                        }));
                    }
                }
                return array;
            }
        };
        $('.holding-shelf-tab').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsHoldingShelfTab);
        $('.holding-shelf-tab').trigger('change');

        $('button[data-id="holding_shelf_tab"]').addClass("btn-sm");

        var companySelect = '<div class="btn-group bootstrap-select disabled company-shelf-tab with-ajax" style="width: 100%;">';
        companySelect += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="company_shelf_tab" tabindex="-1" title="ALL COMPANY"><span class="filter-option pull-left">ALL COMPANY</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
        companySelect += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
        companySelect += '<select id="company_shelf_tab" class="company-shelf-tab with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="ALL COMPANY"><option class="bs-title-option" value="">ALL COMPANY</option></select>';
        companySelect += '</div>';
        $("#select_company_shelf_tab").html(companySelect);

        var plantSelect = '<div class="btn-group bootstrap-select disabled plant-shelf-tab with-ajax" style="width: 100%;">';
        plantSelect += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="plant_shelf_tab" tabindex="-1" title="ALL PLANT"><span class="filter-option pull-left">ALL PLANT</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
        plantSelect += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
        plantSelect += '<select id="plant_shelf_tab" class="plant-shelf-tab with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="ALL PLANT"><option class="bs-title-option" value="">ALL PLANT</option></select>';
        plantSelect += '</div>';
        $("#select_plant_shelf_tab").html(plantSelect);

        var locationSelect = '<div class="btn-group bootstrap-select disabled location-shelf-tab with-ajax" style="width: 100%;">';
        locationSelect += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="location_shelf_tab" tabindex="-1" title="ALL LOCATION"><span class="filter-option pull-left">ALL LOCATION</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
        locationSelect += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
        locationSelect += '<select id="location_shelf_tab" class="location-shelf-tab with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="ALL LOCATION"><option class="bs-title-option" value="">ALL LOCATION</option></select>';
        locationSelect += '</div>';
        $("#select_location_shelf_tab").html(locationSelect);

        // End Filter Holding Top Shelf Tab

        $(document).ajaxComplete(function() {
            // Changed Holding Top Shelf Tab
            $('#holding_shelf_tab').on('changed.bs.select', function(e) {
                $('#select_company_shelf_tab').html('<select id="company_shelf_tab" class="company-shelf-tab with-ajax" data-live-search="true" data-width="100%"></select>');

                var plantSelect = '<div class="btn-group bootstrap-select disabled plant-shelf-tab with-ajax" style="width: 100%;">';
                plantSelect += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="plant_shelf_tab" tabindex="-1" title="ALL PLANT"><span class="filter-option pull-left">ALL PLANT</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
                plantSelect += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
                plantSelect += '<select id="plant_shelf_tab" class="plant-shelf-tab with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="ALL PLANT"><option class="bs-title-option" value="">ALL PLANT</option></select>';
                plantSelect += '</div>';
                $("#select_plant_shelf_tab").html(plantSelect);

                var locationSelect = '<div class="btn-group bootstrap-select disabled location-shelf-tab with-ajax" style="width: 100%;">';
                locationSelect += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="location_shelf_tab" tabindex="-1" title="ALL LOCATION"><span class="filter-option pull-left">ALL LOCATION</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
                locationSelect += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
                locationSelect += '<select id="location_shelf_tab" class="location-shelf-tab with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="ALL LOCATION"><option class="bs-title-option" value="">ALL LOCATION</option></select>';
                locationSelect += '</div>';
                $("#select_location_shelf_tab").html(locationSelect);

                var holdingId = $(this).val();
                var optionsCompanyShelfTab = {
                    ajax: {
                        url: 'settings/select-company/' + holdingId,
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'ALL COMPANY',
                        statusInitialized: 'Start typing...'
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
                $('.company-shelf-tab').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsCompanyShelfTab);
                $('.company-shelf-tab').trigger('change');
                $('button[data-id="company_shelf_tab"]').addClass("btn-sm");
                datatable_shelf_tab.ajax.reload(null, false).unbind();
            });
            // End Changed Holding Top Shelf Tab

            // Changed Company Top Shelf Tab
            $('#company_shelf_tab').on('changed.bs.select', function(e) {
                $('#select_plant_shelf_tab').html('<select id="plant_shelf_tab" class="plant-shelf-tab with-ajax" data-live-search="true" data-width="100%"></select>');

                var locationSelect = '<div class="btn-group bootstrap-select disabled location-shelf-tab with-ajax" style="width: 100%;">';
                locationSelect += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="location_shelf_tab" tabindex="-1" title="ALL LOCATION"><span class="filter-option pull-left">ALL LOCATION</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
                locationSelect += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
                locationSelect += '<select id="location_shelf_tab" class="location-shelf-tab with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="ALL LOCATION"><option class="bs-title-option" value="">ALL LOCATION</option></select>';
                locationSelect += '</div>';
                $("#select_location_shelf_tab").html(locationSelect);

                var companyId = $(this).val();
                var optionsPlantShelfTab = {
                    ajax: {
                        url: 'settings/select-plant/' + companyId,
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'ALL PLANT',
                        statusInitialized: 'Start typing...'
                    },
                    preprocessData: function(data) {
                        var i, l = data.length,
                            array = [];
                        if (l) {
                            for (i = 0; i < l; i++) {
                                array.push($.extend(true, data[i], {
                                    text: data[i].plant,
                                    value: data[i].id,
                                }));
                            }
                        }
                        return array;
                    }
                };
                $('.plant-shelf-tab').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsPlantShelfTab);
                $('.plant-shelf-tab').trigger('change');
                $('button[data-id="plant_shelf_tab"]').addClass("btn-sm");
                datatable_shelf_tab.ajax.reload(null, false).unbind();
            });
            // End Changed Company Top Shelf Tab

            // Changed Plant Top Shelf Tab
            $('#plant_shelf_tab').on('changed.bs.select', function(e) {
                $('#select_location_shelf_tab').html('<select id="location_shelf_tab" class="location-shelf-tab with-ajax" data-live-search="true" data-width="100%"></select>');

                var plantId = $(this).val();
                var optionsLocationShelfTab = {
                    ajax: {
                        url: 'settings/select-location/' + plantId,
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'ALL LOCATION',
                        statusInitialized: 'Start typing...'
                    },
                    preprocessData: function(data) {
                        var i, l = data.length,
                            array = [];
                        if (l) {
                            for (i = 0; i < l; i++) {
                                array.push($.extend(true, data[i], {
                                    text: data[i].location,
                                    value: data[i].id,
                                }));
                            }
                        }
                        return array;
                    }
                };
                $('.location-shelf-tab').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsLocationShelfTab);
                $('.location-shelf-tab').trigger('change');
                $('button[data-id="location_shelf_tab"]').addClass("btn-sm");
                datatable_shelf_tab.ajax.reload(null, false).unbind();
            });
            // End Changed Plant Top Shelf Tab

            // Changed Location Top Shelf Tab
            $('#location_shelf_tab').on('changed.bs.select', function(e) {
                datatable_shelf_tab.ajax.reload(null, false).unbind();
            });
            // End Changed Location Top Shelf Tab

        });

        // Right Click Holding Filter Top Shelf Tab
        new BootstrapMenu('button[data-id="holding_shelf_tab"]', {
            actions: [{
                name: 'SELECT ALL HOLDING',
                onClick: function() {
                    if ($('#holding_shelf_tab').prop('disabled') == false) {
                        $('#holding_shelf_tab').val([]);
                        $('#holding_shelf_tab').trigger('change.abs.preserveSelected');
                        $('#holding_shelf_tab').selectpicker('refresh');
                        $('#company_shelf_tab').trigger("click");
                    }

                    if ($('#company_shelf_tab').prop('disabled') == false) {
                        $('#company_shelf_tab').val([]);
                        $('#company_shelf_tab').prop('disabled', true);
                        $('#company_shelf_tab').trigger('change.abs.preserveSelected');
                        $('#company_shelf_tab').selectpicker('refresh');
                        $('#company_shelf_tab').trigger("click");
                    }

                    if ($('#plant_shelf_tab').prop('disabled') == false) {
                        $('#plant_shelf_tab').val([]);
                        $('#plant_shelf_tab').prop('disabled', true);
                        $('#plant_shelf_tab').trigger('change.abs.preserveSelected');
                        $('#plant_shelf_tab').selectpicker('refresh');
                        $('#plant_shelf_tab').trigger("click");
                    }

                    if ($('#location_shelf_tab').prop('disabled') == false) {
                        $('#location_shelf_tab').val([]);
                        $('#location_shelf_tab').prop('disabled', true);
                        $('#location_shelf_tab').trigger('change.abs.preserveSelected');
                        $('#location_shelf_tab').selectpicker('refresh');
                        $('#location_shelf_tab').trigger("click");
                    }
                    datatable_shelf_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Holding Filter Top Shelf Tab

        // Right Click Company Filter Top Shelf Tab
        new BootstrapMenu('button[data-id="company_shelf_tab"]', {
            actions: [{
                name: 'SELECT ALL COMPANY',
                onClick: function() {

                    if ($('#company_shelf_tab').prop('disabled') == false) {
                        $('#company_shelf_tab').val([]);
                        $('#company_shelf_tab').prop('disabled', true);
                        $('#company_shelf_tab').trigger('change.abs.preserveSelected');
                        $('#company_shelf_tab').selectpicker('refresh');
                        $('#company_shelf_tab').trigger("click");
                    }

                    if ($('#plant_shelf_tab').prop('disabled') == false) {
                        $('#plant_shelf_tab').val([]);
                        $('#plant_shelf_tab').prop('disabled', true);
                        $('#plant_shelf_tab').trigger('change.abs.preserveSelected');
                        $('#plant_shelf_tab').selectpicker('refresh');
                        $('#plant_shelf_tab').trigger("click");
                    }

                    if ($('#location_shelf_tab').prop('disabled') == false) {
                        $('#location_shelf_tab').val([]);
                        $('#location_shelf_tab').prop('disabled', true);
                        $('#location_shelf_tab').trigger('change.abs.preserveSelected');
                        $('#location_shelf_tab').selectpicker('refresh');
                        $('#location_shelf_tab').trigger("click");
                    }
                    datatable_shelf_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Company Filter Top Shelf Tab

        // Right Click Plant Filter Top Shelf Tab
        new BootstrapMenu('button[data-id="plant_shelf_tab"]', {
            actions: [{
                name: 'SELECT ALL PLANT',
                onClick: function() {

                    if ($('#plant_shelf_tab').prop('disabled') == false) {
                        $('#plant_shelf_tab').val([]);
                        $('#plant_shelf_tab').prop('disabled', true);
                        $('#plant_shelf_tab').trigger('change.abs.preserveSelected');
                        $('#plant_shelf_tab').selectpicker('refresh');
                        $('#plant_shelf_tab').trigger("click");
                    }

                    if ($('#location_shelf_tab').prop('disabled') == false) {
                        $('#location_shelf_tab').val([]);
                        $('#location_shelf_tab').prop('disabled', true);
                        $('#location_shelf_tab').trigger('change.abs.preserveSelected');
                        $('#location_shelf_tab').selectpicker('refresh');
                        $('#location_shelf_tab').trigger("click");
                    }
                    datatable_shelf_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Plant Filter Top Shelf Tab

        // Right Click Location Filter Top Shelf Tab
        new BootstrapMenu('button[data-id="location_shelf_tab"]', {
            actions: [{
                name: 'SELECT ALL LOCATION',
                onClick: function() {

                    if ($('#location_shelf_tab').prop('disabled') == false) {
                        $('#location_shelf_tab').val([]);
                        $('#location_shelf_tab').prop('disabled', true);
                        $('#location_shelf_tab').trigger('change.abs.preserveSelected');
                        $('#location_shelf_tab').selectpicker('refresh');
                        $('#location_shelf_tab').trigger("click");
                    }
                    datatable_shelf_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Location Filter Top Shelf Tab

        // Right Click Datatables Shelf Tab
        new BootstrapMenu('table#shelf_table', {
            actions: [{
                name: 'REFRESH SHELF DATA',
                onClick: function() {
                    datatable_shelf_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Datatables Shelf Tab
    });

    // Reload Shelf DataTable 
    function reload_shelf_table() {
        datatable_shelf_tab.ajax.reload(null, false);
    }
    // End Reload Shelf DataTable

    // Add Shelf
    $(document).on('click', '#add-sh', function() {
        var optionsHoldingShelfTabModal = {
            ajax: {
                url: 'settings/select-holding',
                type: 'POST',
                dataType: 'json',
            },
            locale: {
                emptyTitle: 'SELECT HOLDING',
            },
            preprocessData: function(data) {
                var i, l = data.length,
                    array = [];
                if (l) {
                    for (i = 0; i < l; i++) {
                        array.push($.extend(true, data[i], {
                            text: data[i].holding,
                            value: data[i].id,
                        }));
                    }
                }
                return array;
            }
        };

        $('.holding-shelf-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsHoldingShelfTabModal);
        $('.holding-shelf-tab-modal').trigger('change');
        $('button[data-id="holding_shelf_tab_modal"]').addClass("btn-sm");
        $('.bs-searchbox > input.form-control').addClass("input-sm");

        var companySelectModal = '<div class="btn-group bootstrap-select disabled company-shelf-tab-modal with-ajax" style="width: 100%;">';
        companySelectModal += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="company_shelf_tab_modal" tabindex="-1" title="SELECT COMPANY"><span class="filter-option pull-left">SELECT COMPANY</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
        companySelectModal += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
        companySelectModal += '<select id="company_shelf_tab_modal" class="company-shelf-tab-modal with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="SELECT COMPANY"><option class="bs-title-option" value="">SELECT COMPANY</option></select>';
        companySelectModal += '</div>';
        $("#select_company_shelf_tab_modal").html(companySelectModal);

        var plantSelectModal = '<div class="btn-group bootstrap-select disabled plant-shelf-tab-modal with-ajax" style="width: 100%;">';
        plantSelectModal += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="plant_shelf_tab_modal" tabindex="-1" title="SELECT PLANT"><span class="filter-option pull-left">SELECT PLANT</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
        plantSelectModal += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
        plantSelectModal += '<select id="plant_shelf_tab_modal" class="plant-shelf-tab-modal with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="SELECT PLANT"><option class="bs-title-option" value="">SELECT PLANT</option></select>';
        plantSelectModal += '</div>';
        $("#select_plant_shelf_tab_modal").html(plantSelectModal);

        var locationSelectModal = '<div class="btn-group bootstrap-select disabled location-shelf-tab-modal with-ajax" style="width: 100%;">';
        locationSelectModal += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="location_shelf_tab_modal" tabindex="-1" title="SELECT LOCATION"><span class="filter-option pull-left">SELECT LOCATION</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
        locationSelectModal += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
        locationSelectModal += '<select id="location_shelf_tab_modal" class="location-shelf-tab-modal with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="SELECT LOCATION"><option class="bs-title-option" value="">SELECT LOCATION</option></select>';
        locationSelectModal += '</div>';
        $("#select_location_shelf_tab_modal").html(locationSelectModal);

        $('#btn_save_shelf_tab_modal').val("SAVE").removeAttr("disabled");
        $('#shelf_tab_modal_title').text("ADD SHELF");
        $('#shelf_tab_modal').modal('show');
    });
    // End Add Shelf

    // Edit Shelf
    $(document).on('click', '.edit-sh', function() {
        id = $(this).attr('data-id');

        $.ajax({
            url: 'settings/edit-shelf/' + id,
            type: 'GET',
            beforeSend: function() {
                $('#ajax_process_modal').modal('show');
            },
            success: function(data) {
                var optionsHoldingShelfTabModal = {
                    ajax: {
                        url: 'settings/select-holding',
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'SELECT HOLDING',
                    },
                    preprocessData: function(data) {
                        var i, l = data.length,
                            array = [];
                        if (l) {
                            for (i = 0; i < l; i++) {
                                array.push($.extend(true, data[i], {
                                    text: data[i].holding,
                                    value: data[i].id,
                                }));
                            }
                        }
                        return array;
                    }
                };

                $("#select_holding_shelf_tab_modal > button[title='SELECT HOLDING']").replaceWith('<button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" data-id="holding_shelf_tab_modal" title="' + data.holding + '"><span class="filter-option pull-left">' + data.holding + '</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>');
                $('#select_holding_shelf_tab_modal > .dropdown-menu.open').replaceWith('<div class="dropdown-menu open" style="min-height: 39px; max-height: 228px; overflow: hidden;"><div class="bs-searchbox"><input type="text" class="form-control input-sm" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px; max-height: 177px; overflow-y: auto;"><li class="dropdown-header" data-optgroup="1"><span class="text">Currently Selected</span></li><li data-original-index="0" data-optgroup="1" class="selected active"><a tabindex="0" class="opt  " style="" data-tokens="null"><span class="text">' + data.holding + '</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul><div class="status" style="">Start typing a search query</div></div>');
                $('#select_holding_shelf_tab_modal > #holding_shelf_tab_modal').replaceWith('<select id="holding_shelf_tab_modal" class="holding-shelf-tab-modal with-ajax" data-live-search="true" data-width="100%" tabindex="-98"><optgroup label="Currently Selected"><option value="' + data.holdingId + '" selected="selected">' + data.holding + '</option></optgroup></select>');

                $('.holding-shelf-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsHoldingShelfTabModal);
                $('.holding-shelf-tab-modal').trigger('change');
                $('button[data-id="holding_shelf_tab_modal"]').addClass("btn-sm");

                var optionsCompanyShelfTabModal = {
                    ajax: {
                        url: 'settings/select-company/' + data.holdingId,
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

                $("#select_company_shelf_tab_modal > button[title='SELECT COMPANY']").replaceWith('<button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" data-id="company_shelf_tab_modal" title="' + data.company + '"><span class="filter-option pull-left">' + data.company + '</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>');
                $('#select_company_shelf_tab_modal > .dropdown-menu.open').replaceWith('<div class="dropdown-menu open" style="min-height: 39px; max-height: 228px; overflow: hidden;"><div class="bs-searchbox"><input type="text" class="form-control input-sm" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px; max-height: 177px; overflow-y: auto;"><li class="dropdown-header" data-optgroup="1"><span class="text">Currently Selected</span></li><li data-original-index="0" data-optgroup="1" class="selected active"><a tabindex="0" class="opt  " style="" data-tokens="null"><span class="text">' + data.company + '<small class="text-muted">' + data.company_desc + '</small></span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul><div class="status" style="">Start typing a search query</div></div>');
                $('#select_company_shelf_tab_modal > #company_shelf_tab_modal').replaceWith('<select id="company_shelf_tab_modal" class="company-shelf-tab-modal with-ajax" data-live-search="true" data-width="100%" tabindex="-98"><optgroup label="Currently Selected"><option value="' + data.companyId + '" selected="selected">' + data.company + '</option></optgroup></select>');

                $('.company-shelf-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsCompanyShelfTabModal);
                $('.company-shelf-tab-modal').trigger('change');
                $('button[data-id="company_shelf_tab_modal"]').addClass("btn-sm");

                var optionsPlantShelfTabModal = {
                    ajax: {
                        url: 'settings/select-plant/' + data.companyId,
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'SELECT PLANT',
                    },
                    preprocessData: function(data) {
                        var i, l = data.length,
                            array = [];
                        if (l) {
                            for (i = 0; i < l; i++) {
                                array.push($.extend(true, data[i], {
                                    text: data[i].plant,
                                    value: data[i].id,
                                }));
                            }
                        }
                        return array;
                    }
                };

                $("#select_plant_shelf_tab_modal > button[title='SELECT PLANT']").replaceWith('<button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" data-id="plant_shelf_tab_modal" title="' + data.plant + '"><span class="filter-option pull-left">' + data.plant + '</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>');
                $('#select_plant_shelf_tab_modal > .dropdown-menu.open').replaceWith('<div class="dropdown-menu open" style="min-height: 39px; max-height: 228px; overflow: hidden;"><div class="bs-searchbox"><input type="text" class="form-control input-sm" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px; max-height: 177px; overflow-y: auto;"><li class="dropdown-header" data-optgroup="1"><span class="text">Currently Selected</span></li><li data-original-index="0" data-optgroup="1" class="selected active"><a tabindex="0" class="opt  " style="" data-tokens="null"><span class="text">' + data.plant + '<small class="text-muted">' + data.plant_desc + '</small></span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul><div class="status" style="">Start typing a search query</div></div>');
                $('#select_plant_shelf_tab_modal > #plant_shelf_tab_modal').replaceWith('<select id="plant_shelf_tab_modal" class="plant-shelf-tab-modal with-ajax" data-live-search="true" data-width="100%" tabindex="-98"><optgroup label="Currently Selected"><option value="' + data.plantId + '" selected="selected">' + data.plant + '</option></optgroup></select>');

                $('.plant-shelf-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsPlantShelfTabModal);
                $('.plant-shelf-tab-modal').trigger('change');
                $('button[data-id="plant_shelf_tab_modal"]').addClass("btn-sm");

                var optionsLocationShelfTabModal = {
                    ajax: {
                        url: 'settings/select-location/' + data.plantId,
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'SELECT LOCATION',
                    },
                    preprocessData: function(data) {
                        var i, l = data.length,
                            array = [];
                        if (l) {
                            for (i = 0; i < l; i++) {
                                array.push($.extend(true, data[i], {
                                    text: data[i].location,
                                    value: data[i].id,
                                }));
                            }
                        }
                        return array;
                    }
                };

                $("#select_location_shelf_tab_modal > button[title='SELECT LOCATION']").replaceWith('<button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" data-id="location_shelf_tab_modal" title="' + data.location + '"><span class="filter-option pull-left">' + data.location + '</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>');
                $('#select_location_shelf_tab_modal > .dropdown-menu.open').replaceWith('<div class="dropdown-menu open" style="min-height: 39px; max-height: 228px; overflow: hidden;"><div class="bs-searchbox"><input type="text" class="form-control input-sm" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px; max-height: 177px; overflow-y: auto;"><li class="dropdown-header" data-optgroup="1"><span class="text">Currently Selected</span></li><li data-original-index="0" data-optgroup="1" class="selected active"><a tabindex="0" class="opt  " style="" data-tokens="null"><span class="text">' + data.location + '<small class="text-muted">' + data.location_desc + '</small></span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul><div class="status" style="">Start typing a search query</div></div>');
                $('#select_location_shelf_tab_modal > #location_shelf_tab_modal').replaceWith('<select id="location_shelf_tab_modal" class="location-shelf-tab-modal with-ajax" data-live-search="true" data-width="100%" tabindex="-98"><optgroup label="Currently Selected"><option value="' + data.locationId + '" selected="selected">' + data.location + '</option></optgroup></select>');

                $('.location-shelf-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsLocationShelfTabModal);
                $('.location-shelf-tab-modal').trigger('change');
                $('button[data-id="location_shelf_tab_modal"]').addClass("btn-sm");

                $('.bs-searchbox > input.form-control').addClass("input-sm");

                $('#shelf_shelf_tab_modal').val(data.shelf);
                $('#shelf_desc_shelf_tab_modal').val(data.description);
                $('#id_shelf_tab_modal').val(id);

                $('#btn_save_shelf_tab_modal').val("UPDATE").removeAttr("disabled");
                $('#shelf_tab_modal_title').text("EDIT SHELF");
                $('#ajax_process_modal').modal('hide');
                $('#shelf_tab_modal').modal('show');
            },
            error: function() {
                $('#ajax_process_modal').modal('hide');
            }
        });
    });
    // End Edit Shelf

    // Press Enter shelf_tab_modal
    $("#shelf_tab_modal").keypress(function(e) {
        switch (e.which) {
            case 13:
                $("#btn_save_shelf_tab_modal").trigger("click");
                break;
        }
    });
    // End Press Enter shelf_tab_modal

    // Save Shelf
    $("#btn_save_shelf_tab_modal").click(function() {
        var formData = {
            shelf: $('#shelf_shelf_tab_modal').val().trim(),
            description: $('#shelf_desc_shelf_tab_modal').val().trim(),
            tbl_location_id: $('#location_shelf_tab_modal').val(),
            created_by: $('#logged_in_user').val(),
            last_updated_by: $('#logged_in_user').val(),
        }

        var state = $('#btn_save_shelf_tab_modal').val();
        var type = "POST";
        var url = 'settings/add-shelf';
        var shelfId = $('#id_shelf_tab_modal').val();

        if (state == "UPDATE") {
            type = "PUT";
            url = 'settings/update-shelf/' + shelfId;
        }

        $.ajax({
            type: type,
            url: url,
            data: formData,
            dataType: 'json',
            beforeSend: function(data) {
                $("#shelf_tab_modal :input").prop('disabled', true);
                $(".error_saving_shelf_tab_modal").hide();
                $(".error_updating_shelf_tab_modal").hide();

                if (state == "SAVE") {
                    $(".saving_shelf_tab_modal").show();
                } else {
                    $(".updating_shelf_tab_modal").show();
                }

                $("#form_shelf_shelf_tab_modal").removeClass("has-error");
                $("#shelf_shelf_tab_modal + p.help-block").text("");

                $("#form_location_shelf_tab_modal").removeClass("has-error");
                $("#location_shelf_tab_modal + p.help-block").text("");

                $("#form_shelf_desc_shelf_tab_modal").removeClass("has-error");
                $("#shelf_desc_shelf_tab_modal + p.help-block").text("");
            },
            success: function(data) {
                $('#shelf_tab_modal_form').trigger("reset");
                $(".saving_shelf_tab_modal").hide();
                $(".updating_shelf_tab_modal").hide();

                $('#shelf_tab_modal').modal('hide');
                reload_shelf_table();
                $("#shelf_tab_modal :input").prop('disabled', false);

                $("#form_shelf_shelf_tab_modal").removeClass("has-error");
                $("#shelf_shelf_tab_modal + p.help-block").text("");

                $("#form_location_shelf_tab_modal").removeClass("has-error");
                $("#location_shelf_tab_modal + p.help-block").text("");

                $("#form_shelf_desc_shelf_tab_modal").removeClass("has-error");
                $("#shelf_desc_shelf_tab_modal + p.help-block").text("");
            },
            error: function(data) {
                $(".saving_shelf_tab_modal").hide();
                $(".updating_shelf_tab_modal").hide();
                if (state == "SAVE") {
                    $(".error_saving_shelf_tab_modal").show();
                } else {
                    $(".error_updating_shelf_tab_modal").show();
                }
                $("#shelf_tab_modal :input").prop('disabled', false);

                var errors = data.responseJSON;

                if (errors.shelf) {
                    $("#form_shelf_shelf_tab_modal").addClass("has-error");
                    $("#shelf_shelf_tab_modal + p.help-block").text(errors.shelf);
                } else {
                    $("#form_shelf_shelf_tab_modal").removeClass("has-error");
                    $("#shelf_shelf_tab_modal + p.help-block").text("");
                }

                if (errors.location) {
                    $("#form_location_shelf_tab_modal").addClass("has-error");
                    $("#location_shelf_tab_modal + p.help-block").text(errors.location);
                } else {
                    $("#form_location_shelf_tab_modal").removeClass("has-error");
                    $("#location_shelf_tab_modal + p.help-block").text("");
                }

                if (errors.description) {
                    $("#form_shelf_desc_shelf_tab_modal").addClass("has-error");
                    $("#shelf_desc_shelf_tab_modal + p.help-block").text(errors.description);
                } else {
                    $("#form_shelf_desc_shelf_tab_modal").removeClass("has-error");
                    $("#shelf_desc_shelf_tab_modal + p.help-block").text("");
                }
            }
        });
    });
    // End Save Shelf

    // Delete Shelf
    $(document).on('click', '.delete-sh', function() {
        id = $(this).attr('data-id');

        var shelf = $("table#shelf_table tr#" + id + " td:eq(1)").html();
        var description = $("table#shelf_table tr#" + id + " td:eq(2)").html();
        var msg = "<table class=\"table table-striped\">";
        msg += "<thead><tr><th>SHELF</th><th>DESCRIPTION</th></thead>";
        msg += "<tbody><tr><td>" + shelf + "</td><td>" + description + "</td></tr></tbody>";
        msg += "</table>";

        bootbox.dialog({
            message: msg,
            title: "Are you sure you want to delete this Shelf?",
            buttons: {
                success: {
                    label: "YES DELETE",
                    className: "btn-danger btn-sm",
                    callback: function() {
                        $.ajax({
                            type: "DELETE",
                            url: 'settings/delete-shelf/' + id,
                            beforeSend: function() {},
                            success: function() {
                                reload_shelf_table();
                            },
                            error: function() {
                                alert('Cannot delete this Shelf.');
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
    // End Delete Shelf

    // Changed Select inside Shelf Modal
    $(document).ajaxComplete(function() {

        $('#holding_shelf_tab_modal').on('changed.bs.select', function(e) {
            $('#select_company_shelf_tab_modal').html('<select id="company_shelf_tab_modal" class="company-shelf-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');

            var plantSelectModal = '<div class="btn-group bootstrap-select disabled plant-shelf-tab-modal with-ajax" style="width: 100%;">';
            plantSelectModal += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="plant_shelf_tab_modal" tabindex="-1" title="SELECT PLANT"><span class="filter-option pull-left">SELECT PLANT</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
            plantSelectModal += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
            plantSelectModal += '<select id="plant_shelf_tab_modal" class="plant-shelf-tab-modal with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="SELECT PLANT"><option class="bs-title-option" value="">SELECT PLANT</option></select>';
            plantSelectModal += '</div>';
            $("#select_plant_shelf_tab_modal").html(plantSelectModal);

            var locationSelectModal = '<div class="btn-group bootstrap-select disabled location-shelf-tab-modal with-ajax" style="width: 100%;">';
            locationSelectModal += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="location_shelf_tab_modal" tabindex="-1" title="SELECT LOCATION"><span class="filter-option pull-left">SELECT LOCATION</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
            locationSelectModal += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
            locationSelectModal += '<select id="location_shelf_tab_modal" class="location-shelf-tab-modal with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="SELECT LOCATION"><option class="bs-title-option" value="">SELECT LOCATION</option></select>';
            locationSelectModal += '</div>';
            $("#select_location_shelf_tab_modal").html(locationSelectModal);

            var holdingId = $(this).val();
            var optionsCompanyShelfTabModal = {
                ajax: {
                    url: 'settings/select-company/' + holdingId,
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

            $('.company-shelf-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsCompanyShelfTabModal);
            $('.company-shelf-tab-modal').trigger('change');
            $('button[data-id="company_shelf_tab_modal"]').addClass("btn-sm");
            $('.bs-searchbox > input.form-control').addClass("input-sm");
        });

        $('#company_shelf_tab_modal').on('changed.bs.select', function(e) {
            $('#select_plant_shelf_tab_modal').html('<select id="plant_shelf_tab_modal" class="plant-shelf-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');

            var locationSelectModal = '<div class="btn-group bootstrap-select disabled location-shelf-tab-modal with-ajax" style="width: 100%;">';
            locationSelectModal += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="location_shelf_tab_modal" tabindex="-1" title="SELECT LOCATION"><span class="filter-option pull-left">SELECT LOCATION</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
            locationSelectModal += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
            locationSelectModal += '<select id="location_shelf_tab_modal" class="location-shelf-tab-modal with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="SELECT LOCATION"><option class="bs-title-option" value="">SELECT LOCATION</option></select>';
            locationSelectModal += '</div>';
            $("#select_location_shelf_tab_modal").html(locationSelectModal);

            var companyId = $(this).val();
            var optionsPlantShelfTabModal = {
                ajax: {
                    url: 'settings/select-plant/' + companyId,
                    type: 'POST',
                    dataType: 'json',
                },
                locale: {
                    emptyTitle: 'SELECT PLANT',
                },
                preprocessData: function(data) {
                    var i, l = data.length,
                        array = [];
                    if (l) {
                        for (i = 0; i < l; i++) {
                            array.push($.extend(true, data[i], {
                                text: data[i].plant,
                                value: data[i].id,
                            }));
                        }
                    }
                    return array;
                }
            };

            $('.plant-shelf-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsPlantShelfTabModal);
            $('.plant-shelf-tab-modal').trigger('change');
            $('button[data-id="plant_shelf_tab_modal"]').addClass("btn-sm");
            $('.bs-searchbox > input.form-control').addClass("input-sm");
        });

        $('#plant_shelf_tab_modal').on('changed.bs.select', function(e) {
            $('#select_location_shelf_tab_modal').html('<select id="location_shelf_tab_modal" class="location-shelf-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');

            var plantId = $(this).val();
            var optionsLocationShelfTabModal = {
                ajax: {
                    url: 'settings/select-location/' + plantId,
                    type: 'POST',
                    dataType: 'json',
                },
                locale: {
                    emptyTitle: 'SELECT LOCATION',
                },
                preprocessData: function(data) {
                    var i, l = data.length,
                        array = [];
                    if (l) {
                        for (i = 0; i < l; i++) {
                            array.push($.extend(true, data[i], {
                                text: data[i].location,
                                value: data[i].id,
                            }));
                        }
                    }
                    return array;
                }
            };

            $('.location-shelf-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsLocationShelfTabModal);
            $('.location-shelf-tab-modal').trigger('change');
            $('button[data-id="location_shelf_tab_modal"]').addClass("btn-sm");
            $('.bs-searchbox > input.form-control').addClass("input-sm");
        });

    });
    // End Changed Select inside Shelf Modal

    // Shelf Modal hide
    $('#shelf_tab_modal').on('hide.bs.modal', function(e) {
        $('#select_holding_shelf_tab_modal').html('<select id="holding_shelf_tab_modal" class="holding-shelf-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');
        $('#select_company_shelf_tab_modal').html('<select id="company_shelf_tab_modal" class="company-shelf-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');
        $('#select_plant_shelf_tab_modal').html('<select id="plant_shelf_tab_modal" class="plant-shelf-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');
        $('#select_location_shelf_tab_modal').html('<select id="location_shelf_tab_modal" class="location-shelf-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');

        $(".error_saving_shelf_tab_modal").hide();
        $(".error_updating_shelf_tab_modal").hide();

        $('#shelf_tab_modal_form').trigger("reset");

        $("#form_shelf_shelf_tab_modal").removeClass("has-error");
        $("#shelf_shelf_tab_modal + p.help-block").text("");

        $("#form_location_shelf_tab_modal").removeClass("has-error");
        $("#location_shelf_tab_modal + p.help-block").text("");

        $("#form_shelf_desc_shelf_tab_modal").removeClass("has-error");
        $("#shelf_desc_shelf_tab_modal + p.help-block").text("");
    });
    // End Shelf Modal Hide

    // END HOLDING-BIN SHELF TAB
    // ============================================================
    // ============================================================




    // START HOLDING-BIN BIN TAB
    // ============================================================
    // ============================================================

    var datatable_bin_tab;
    $("#bin_tab").one("click", function() {

        datatable_bin_tab = $('#bin_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'settings/datatables-bin',
                data: function(d) {
                    d.holdingId = $('#holding_bin_tab').val();
                    d.companyId = $('#company_bin_tab').val();
                    d.plantId = $('#plant_bin_tab').val();
                    d.locationId = $('#location_bin_tab').val();
                    d.shelfId = $('#shelf_bin_tab').val();
                },
            },
            columns: [{
                data: 'rownum',
                name: 'rownum',
                searchable: false
            }, {
                data: 'created_at',
                name: 'created_at',
                searchable: false
            }, {
                data: 'bin',
                name: 'tbl_bin.bin'
            }, {
                data: 'description',
                name: 'tbl_bin.description'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
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
                "sSearch": "",
                "sSearchPlaceholder": "SEARCH",
            },
            dom: "<'row'f>" + "<'row'<'col-sm-12'tr>>" + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            columnDefs: [{
                "targets": [1],
                "visible": false,
            }, ],
            order: [
                [1, 'desc']
            ]
        });

        $("select.form-control").selectpicker();
        $("div.dataTables_length > label > div.btn-group > button").addClass("btn-sm");

        var filterBin = '<div class="col-sm-2" id="select_holding_bin_tab">';
        filterBin += '<select id="holding_bin_tab" class="holding-bin-tab with-ajax" data-live-search="true" data-width="100%"></select>';
        filterBin += '</div>';

        filterBin += '<div class="col-sm-2" id="select_company_bin_tab">';
        filterBin += '<select id="company_bin_tab" class="company-bin-tab with-ajax" data-live-search="true" data-width="100%" disabled></select>';
        filterBin += '</div>';

        filterBin += '<div class="col-sm-2" id="select_plant_bin_tab">';
        filterBin += '<select id="plant_bin_tab" class="plant-bin-tab with-ajax" data-live-search="true" data-width="100%" disabled></select>';
        filterBin += '</div>';

        filterBin += '<div class="col-sm-2" id="select_location_bin_tab">';
        filterBin += '<select id="location_bin_tab" class="location-bin-tab with-ajax" data-live-search="true" data-width="100%" disabled></select>';
        filterBin += '</div>';

        filterBin += '<div class="col-sm-2" id="select_shelf_bin_tab">';
        filterBin += '<select id="shelf_bin_tab" class="shelf-bin-tab with-ajax" data-live-search="true" data-width="100%" disabled></select>';
        filterBin += '</div>';

        $(filterBin).insertBefore("#bin_table_filter");
        $('#bin_table_filter').addClass('col-sm-2').css("padding-left", "0px");

        // FILTER TOP
        // Filter Holding Top
        var optionsHoldingBinTab = {
            ajax: {
                url: 'settings/select-holding',
                type: 'POST',
                dataType: 'json',
            },
            locale: {
                emptyTitle: 'ALL HOLDING',
                statusInitialized: 'Start typing...'
            },
            preprocessData: function(data) {
                var i, l = data.length,
                    array = [];
                if (l) {
                    for (i = 0; i < l; i++) {
                        array.push($.extend(true, data[i], {
                            text: data[i].holding,
                            value: data[i].id,
                        }));
                    }
                }
                return array;
            }
        };
        $('.holding-bin-tab').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsHoldingBinTab);
        $('.holding-bin-tab').trigger('change');

        $('button[data-id="holding_bin_tab"]').addClass("btn-sm");

        var companySelect = '<div class="btn-group bootstrap-select disabled company-bin-tab with-ajax" style="width: 100%;">';
        companySelect += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="company_bin_tab" tabindex="-1" title="ALL COMPANY"><span class="filter-option pull-left">ALL COMPANY</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
        companySelect += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
        companySelect += '<select id="company_bin_tab" class="company-bin-tab with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="ALL COMPANY"><option class="bs-title-option" value="">ALL COMPANY</option></select>';
        companySelect += '</div>';
        $("#select_company_bin_tab").html(companySelect);

        var plantSelect = '<div class="btn-group bootstrap-select disabled plant-bin-tab with-ajax" style="width: 100%;">';
        plantSelect += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="plant_bin_tab" tabindex="-1" title="ALL PLANT"><span class="filter-option pull-left">ALL PLANT</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
        plantSelect += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
        plantSelect += '<select id="plant_bin_tab" class="plant-bin-tab with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="ALL PLANT"><option class="bs-title-option" value="">ALL PLANT</option></select>';
        plantSelect += '</div>';
        $("#select_plant_bin_tab").html(plantSelect);

        var locationSelect = '<div class="btn-group bootstrap-select disabled location-bin-tab with-ajax" style="width: 100%;">';
        locationSelect += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="location_bin_tab" tabindex="-1" title="ALL LOCATION"><span class="filter-option pull-left">ALL LOCATION</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
        locationSelect += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
        locationSelect += '<select id="location_bin_tab" class="location-bin-tab with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="ALL LOCATION"><option class="bs-title-option" value="">ALL LOCATION</option></select>';
        locationSelect += '</div>';
        $("#select_location_bin_tab").html(locationSelect);

        var shelfSelect = '<div class="btn-group bootstrap-select disabled shelf-bin-tab with-ajax" style="width: 100%;">';
        shelfSelect += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="shelf_bin_tab" tabindex="-1" title="ALL SHELF"><span class="filter-option pull-left">ALL SHELF</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
        shelfSelect += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
        shelfSelect += '<select id="shelf_bin_tab" class="shelf-bin-tab with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="ALL SHELF"><option class="bs-title-option" value="">ALL SHELF</option></select>';
        shelfSelect += '</div>';
        $("#select_shelf_bin_tab").html(shelfSelect);

        // End Filter Holding Top

        $(document).ajaxComplete(function() {
            // Changed Holding Top
            $('#holding_bin_tab').on('changed.bs.select', function(e) {
                $('#select_company_bin_tab').html('<select id="company_bin_tab" class="company-bin-tab with-ajax" data-live-search="true" data-width="100%"></select>');

                var plantSelect = '<div class="btn-group bootstrap-select disabled plant-bin-tab with-ajax" style="width: 100%;">';
                plantSelect += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="plant_bin_tab" tabindex="-1" title="ALL PLANT"><span class="filter-option pull-left">ALL PLANT</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
                plantSelect += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
                plantSelect += '<select id="plant_bin_tab" class="plant-bin-tab with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="ALL PLANT"><option class="bs-title-option" value="">ALL PLANT</option></select>';
                plantSelect += '</div>';
                $("#select_plant_bin_tab").html(plantSelect);

                var locationSelect = '<div class="btn-group bootstrap-select disabled location-bin-tab with-ajax" style="width: 100%;">';
                locationSelect += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="location_bin_tab" tabindex="-1" title="ALL LOCATION"><span class="filter-option pull-left">ALL LOCATION</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
                locationSelect += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
                locationSelect += '<select id="location_bin_tab" class="location-bin-tab with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="ALL LOCATION"><option class="bs-title-option" value="">ALL LOCATION</option></select>';
                locationSelect += '</div>';
                $("#select_location_bin_tab").html(locationSelect);

                var shelfSelect = '<div class="btn-group bootstrap-select disabled shelf-bin-tab with-ajax" style="width: 100%;">';
                shelfSelect += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="shelf_bin_tab" tabindex="-1" title="ALL SHELF"><span class="filter-option pull-left">ALL SHELF</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
                shelfSelect += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
                shelfSelect += '<select id="shelf_bin_tab" class="shelf-bin-tab with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="ALL SHELF"><option class="bs-title-option" value="">ALL SHELF</option></select>';
                shelfSelect += '</div>';
                $("#select_shelf_bin_tab").html(shelfSelect);

                var holdingId = $(this).val();
                var optionsCompanyBinTab = {
                    ajax: {
                        url: 'settings/select-company/' + holdingId,
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'ALL COMPANY',
                        statusInitialized: 'Start typing...'
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
                $('.company-bin-tab').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsCompanyBinTab);
                $('.company-bin-tab').trigger('change');
                $('button[data-id="company_bin_tab"]').addClass("btn-sm");
                datatable_bin_tab.ajax.reload(null, false).unbind();
            });
            // End Changed Holding Top

            // Changed Company Top
            $('#company_bin_tab').on('changed.bs.select', function(e) {
                $('#select_plant_bin_tab').html('<select id="plant_bin_tab" class="plant-bin-tab with-ajax" data-live-search="true" data-width="100%"></select>');

                var locationSelect = '<div class="btn-group bootstrap-select disabled location-bin-tab with-ajax" style="width: 100%;">';
                locationSelect += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="location_bin_tab" tabindex="-1" title="ALL LOCATION"><span class="filter-option pull-left">ALL LOCATION</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
                locationSelect += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
                locationSelect += '<select id="location_bin_tab" class="location-bin-tab with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="ALL LOCATION"><option class="bs-title-option" value="">ALL LOCATION</option></select>';
                locationSelect += '</div>';
                $("#select_location_bin_tab").html(locationSelect);

                var shelfSelect = '<div class="btn-group bootstrap-select disabled shelf-bin-tab with-ajax" style="width: 100%;">';
                shelfSelect += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="shelf_bin_tab" tabindex="-1" title="ALL SHELF"><span class="filter-option pull-left">ALL SHELF</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
                shelfSelect += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
                shelfSelect += '<select id="shelf_bin_tab" class="shelf-bin-tab with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="ALL SHELF"><option class="bs-title-option" value="">ALL SHELF</option></select>';
                shelfSelect += '</div>';
                $("#select_shelf_bin_tab").html(shelfSelect);

                var companyId = $(this).val();
                var optionsPlantBinTab = {
                    ajax: {
                        url: 'settings/select-plant/' + companyId,
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'ALL PLANT',
                        statusInitialized: 'Start typing...'
                    },
                    preprocessData: function(data) {
                        var i, l = data.length,
                            array = [];
                        if (l) {
                            for (i = 0; i < l; i++) {
                                array.push($.extend(true, data[i], {
                                    text: data[i].plant,
                                    value: data[i].id,
                                }));
                            }
                        }
                        return array;
                    }
                };
                $('.plant-bin-tab').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsPlantBinTab);
                $('.plant-bin-tab').trigger('change');
                $('button[data-id="plant_bin_tab"]').addClass("btn-sm");
                datatable_bin_tab.ajax.reload(null, false).unbind();
            });
            // End Changed Company Top

            // Changed Plant Top
            $('#plant_bin_tab').on('changed.bs.select', function(e) {
                $('#select_location_bin_tab').html('<select id="location_bin_tab" class="location-bin-tab with-ajax" data-live-search="true" data-width="100%"></select>');

                var shelfSelect = '<div class="btn-group bootstrap-select disabled shelf-bin-tab with-ajax" style="width: 100%;">';
                shelfSelect += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="shelf_bin_tab" tabindex="-1" title="ALL SHELF"><span class="filter-option pull-left">ALL SHELF</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
                shelfSelect += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
                shelfSelect += '<select id="shelf_bin_tab" class="shelf-bin-tab with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="ALL SHELF"><option class="bs-title-option" value="">ALL SHELF</option></select>';
                shelfSelect += '</div>';
                $("#select_shelf_bin_tab").html(shelfSelect);

                var plantId = $(this).val();
                var optionsLocationBinTab = {
                    ajax: {
                        url: 'settings/select-location/' + plantId,
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'ALL LOCATION',
                        statusInitialized: 'Start typing...'
                    },
                    preprocessData: function(data) {
                        var i, l = data.length,
                            array = [];
                        if (l) {
                            for (i = 0; i < l; i++) {
                                array.push($.extend(true, data[i], {
                                    text: data[i].location,
                                    value: data[i].id,
                                }));
                            }
                        }
                        return array;
                    }
                };
                $('.location-bin-tab').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsLocationBinTab);
                $('.location-bin-tab').trigger('change');
                $('button[data-id="location_bin_tab"]').addClass("btn-sm");
                datatable_bin_tab.ajax.reload(null, false).unbind();
            });
            // End Changed Company Top

            // Changed Location Top
            $('#location_bin_tab').on('changed.bs.select', function(e) {
                $('#select_shelf_bin_tab').html('<select id="shelf_bin_tab" class="shelf-bin-tab with-ajax" data-live-search="true" data-width="100%"></select>');

                var locationId = $(this).val();
                var optionsShelfBinTab = {
                    ajax: {
                        url: 'settings/select-shelf/' + locationId,
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'ALL SHELF',
                        statusInitialized: 'Start typing...'
                    },
                    preprocessData: function(data) {
                        var i, l = data.length,
                            array = [];
                        if (l) {
                            for (i = 0; i < l; i++) {
                                array.push($.extend(true, data[i], {
                                    text: data[i].shelf,
                                    value: data[i].id,
                                }));
                            }
                        }
                        return array;
                    }
                };
                $('.shelf-bin-tab').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsShelfBinTab);
                $('.shelf-bin-tab').trigger('change');
                $('button[data-id="shelf_bin_tab"]').addClass("btn-sm");
                datatable_bin_tab.ajax.reload(null, false).unbind();
            });
            // End Changed Location Top

            // Changed Shelf Top
            $('#shelf_bin_tab').on('changed.bs.select', function(e) {
                datatable_bin_tab.ajax.reload(null, false).unbind();
            });
            // End Changed Shelf Top

        });

        // Right Click Holding Filter Top Bin Tab
        new BootstrapMenu('button[data-id="holding_bin_tab"]', {
            actions: [{
                name: 'SELECT ALL HOLDING',
                onClick: function() {
                    if ($('#holding_bin_tab').prop('disabled') == false) {
                        $('#holding_bin_tab').val([]);
                        $('#holding_bin_tab').trigger('change.abs.preserveSelected');
                        $('#holding_bin_tab').selectpicker('refresh');
                        $('#holding_bin_tab').trigger("click");
                    }
                    if ($('#company_bin_tab').prop('disabled') == false) {
                        $('#company_bin_tab').val([]);
                        $('#company_bin_tab').prop('disabled', true);
                        $('#company_bin_tab').trigger('change.abs.preserveSelected');
                        $('#company_bin_tab').selectpicker('refresh');
                        $('#company_bin_tab').trigger("click");
                    }

                    if ($('#plant_bin_tab').prop('disabled') == false) {
                        $('#plant_bin_tab').val([]);
                        $('#plant_bin_tab').prop('disabled', true);
                        $('#plant_bin_tab').trigger('change.abs.preserveSelected');
                        $('#plant_bin_tab').selectpicker('refresh');
                        $('#plant_bin_tab').trigger("click");
                    }

                    if ($('#location_bin_tab').prop('disabled') == false) {
                        $('#location_bin_tab').val([]);
                        $('#location_bin_tab').prop('disabled', true);
                        $('#location_bin_tab').trigger('change.abs.preserveSelected');
                        $('#location_bin_tab').selectpicker('refresh');
                        $('#location_bin_tab').trigger("click");
                    }

                    if ($('#shelf_bin_tab').prop('disabled') == false) {
                        $('#shelf_bin_tab').val([]);
                        $('#shelf_bin_tab').prop('disabled', true);
                        $('#shelf_bin_tab').trigger('change.abs.preserveSelected');
                        $('#shelf_bin_tab').selectpicker('refresh');
                        $('#shelf_bin_tab').trigger("click");
                    }
                    datatable_bin_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Holding Filter Top Bin Tab

        // Right Click Company Filter Top Bin Tab
        new BootstrapMenu('button[data-id="company_bin_tab"]', {
            actions: [{
                name: 'SELECT ALL COMPANY',
                onClick: function() {

                    if ($('#company_bin_tab').prop('disabled') == false) {
                        $('#company_bin_tab').val([]);
                        $('#company_bin_tab').prop('disabled', true);
                        $('#company_bin_tab').trigger('change.abs.preserveSelected');
                        $('#company_bin_tab').selectpicker('refresh');
                        $('#company_bin_tab').trigger("click");
                    }

                    if ($('#plant_bin_tab').prop('disabled') == false) {
                        $('#plant_bin_tab').val([]);
                        $('#plant_bin_tab').prop('disabled', true);
                        $('#plant_bin_tab').trigger('change.abs.preserveSelected');
                        $('#plant_bin_tab').selectpicker('refresh');
                        $('#plant_bin_tab').trigger("click");
                    }

                    if ($('#location_bin_tab').prop('disabled') == false) {
                        $('#location_bin_tab').val([]);
                        $('#location_bin_tab').prop('disabled', true);
                        $('#location_bin_tab').trigger('change.abs.preserveSelected');
                        $('#location_bin_tab').selectpicker('refresh');
                        $('#location_bin_tab').trigger("click");
                    }

                    if ($('#shelf_bin_tab').prop('disabled') == false) {
                        $('#shelf_bin_tab').val([]);
                        $('#shelf_bin_tab').prop('disabled', true);
                        $('#shelf_bin_tab').trigger('change.abs.preserveSelected');
                        $('#shelf_bin_tab').selectpicker('refresh');
                        $('#shelf_bin_tab').trigger("click");
                    }
                    datatable_bin_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Company Filter Top Bin Tab

        // Right Click Plant Filter Top Bin Tab
        new BootstrapMenu('button[data-id="plant_bin_tab"]', {
            actions: [{
                name: 'SELECT ALL PLANT',
                onClick: function() {

                    if ($('#plant_bin_tab').prop('disabled') == false) {
                        $('#plant_bin_tab').val([]);
                        $('#plant_bin_tab').prop('disabled', true);
                        $('#plant_bin_tab').trigger('change.abs.preserveSelected');
                        $('#plant_bin_tab').selectpicker('refresh');
                        $('#plant_bin_tab').trigger("click");
                    }

                    if ($('#location_bin_tab').prop('disabled') == false) {
                        $('#location_bin_tab').val([]);
                        $('#location_bin_tab').prop('disabled', true);
                        $('#location_bin_tab').trigger('change.abs.preserveSelected');
                        $('#location_bin_tab').selectpicker('refresh');
                        $('#location_bin_tab').trigger("click");
                    }

                    if ($('#shelf_bin_tab').prop('disabled') == false) {
                        $('#shelf_bin_tab').val([]);
                        $('#shelf_bin_tab').prop('disabled', true);
                        $('#shelf_bin_tab').trigger('change.abs.preserveSelected');
                        $('#shelf_bin_tab').selectpicker('refresh');
                        $('#shelf_bin_tab').trigger("click");
                    }
                    datatable_bin_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Plant Filter Top Bin Tab

        // Right Click Location Filter Top Bin Tab
        new BootstrapMenu('button[data-id="location_bin_tab"]', {
            actions: [{
                name: 'SELECT ALL LOCATION',
                onClick: function() {

                    if ($('#location_bin_tab').prop('disabled') == false) {
                        $('#location_bin_tab').val([]);
                        $('#location_bin_tab').prop('disabled', true);
                        $('#location_bin_tab').trigger('change.abs.preserveSelected');
                        $('#location_bin_tab').selectpicker('refresh');
                        $('#location_bin_tab').trigger("click");
                    }

                    if ($('#shelf_bin_tab').prop('disabled') == false) {
                        $('#shelf_bin_tab').val([]);
                        $('#shelf_bin_tab').prop('disabled', true);
                        $('#shelf_bin_tab').trigger('change.abs.preserveSelected');
                        $('#shelf_bin_tab').selectpicker('refresh');
                        $('#shelf_bin_tab').trigger("click");
                    }
                    datatable_bin_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Location Filter Top Bin Tab

        // Right Click Shelf Filter Top Bin Tab
        new BootstrapMenu('button[data-id="shelf_bin_tab"]', {
            actions: [{
                name: 'SELECT ALL SHELF',
                onClick: function() {
                    if ($('#shelf_bin_tab').prop('disabled') == false) {
                        $('#shelf_bin_tab').val([]);
                        $('#shelf_bin_tab').prop('disabled', true);
                        $('#shelf_bin_tab').trigger('change.abs.preserveSelected');
                        $('#shelf_bin_tab').selectpicker('refresh');
                        $('#shelf_bin_tab').trigger("click");
                    }
                    datatable_bin_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Shelf Filter Top Bin Tab

        // Right Click Datatables Shelf Tab Bin Tab
        new BootstrapMenu('table#bin_table', {
            actions: [{
                name: 'REFRESH BIN DATA',
                onClick: function() {
                    datatable_bin_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Datatables Shelf Tab Bin Tab
    });

    // Reload DataTable 
    function reload_table() {
        datatable_bin_tab.ajax.reload(null, false);
    }
    // End Reload DataTable

    // Add Bin
    $(document).on('click', '#add-bn', function() {
        id = $(this).attr('data-id');

        var optionsHoldingBinTabModal = {
            ajax: {
                url: 'settings/select-holding',
                type: 'POST',
                dataType: 'json',
            },
            locale: {
                emptyTitle: 'SELECT HOLDING',
            },
            preprocessData: function(data) {
                var i, l = data.length,
                    array = [];
                if (l) {
                    for (i = 0; i < l; i++) {
                        array.push($.extend(true, data[i], {
                            text: data[i].holding,
                            value: data[i].id,
                        }));
                    }
                }
                return array;
            }
        };

        $('.holding-bin-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsHoldingBinTabModal);
        $('.holding-bin-tab-modal').trigger('change');
        $('button[data-id="holding_bin_tab_modal"]').addClass("btn-sm");
        $('.bs-searchbox > input.form-control').addClass("input-sm");

        var companySelectModal = '<div class="btn-group bootstrap-select disabled company-bin-tab-modal with-ajax" style="width: 100%;">';
        companySelectModal += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="company_bin_tab_modal" tabindex="-1" title="SELECT COMPANY"><span class="filter-option pull-left">SELECT COMPANY</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
        companySelectModal += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
        companySelectModal += '<select id="company_bin_tab_modal" class="company-bin-tab-modal with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="SELECT COMPANY"><option class="bs-title-option" value="">SELECT COMPANY</option></select>';
        companySelectModal += '</div>';
        $("#select_company_bin_tab_modal").html(companySelectModal);

        var plantSelectModal = '<div class="btn-group bootstrap-select disabled plant-bin-tab-modal with-ajax" style="width: 100%;">';
        plantSelectModal += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="plant_bin_tab_modal" tabindex="-1" title="SELECT PLANT"><span class="filter-option pull-left">SELECT PLANT</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
        plantSelectModal += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
        plantSelectModal += '<select id="plant_bin_tab_modal" class="plant-bin-tab-modal with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="SELECT PLANT"><option class="bs-title-option" value="">SELECT PLANT</option></select>';
        plantSelectModal += '</div>';
        $("#select_plant_bin_tab_modal").html(plantSelectModal);

        var locationSelectModal = '<div class="btn-group bootstrap-select disabled location-bin-tab-modal with-ajax" style="width: 100%;">';
        locationSelectModal += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="location_bin_tab_modal" tabindex="-1" title="SELECT LOCATION"><span class="filter-option pull-left">SELECT LOCATION</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
        locationSelectModal += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
        locationSelectModal += '<select id="location_bin_tab_modal" class="location-bin-tab-modal with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="SELECT LOCATION"><option class="bs-title-option" value="">SELECT LOCATION</option></select>';
        locationSelectModal += '</div>';
        $("#select_location_bin_tab_modal").html(locationSelectModal);

        var shelfSelectModal = '<div class="btn-group bootstrap-select disabled shelf-bin-tab-modal with-ajax" style="width: 100%;">';
        shelfSelectModal += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="shelf_bin_tab_modal" tabindex="-1" title="SELECT SHELF"><span class="filter-option pull-left">SELECT SHELF</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
        shelfSelectModal += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
        shelfSelectModal += '<select id="shelf_bin_tab_modal" class="shelf-bin-tab-modal with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="SELECT SHELF"><option class="bs-title-option" value="">SELECT SHELF</option></select>';
        shelfSelectModal += '</div>';
        $("#select_shelf_bin_tab_modal").html(shelfSelectModal);

        $('#btn_save_bin_tab_modal').val("SAVE").removeAttr("disabled");
        $('#bin_tab_modal_title').text("ADD BIN");
        $('#bin_tab_modal').modal('show');
    });
    // End Add Bin

    // Edit Bin
    $(document).on('click', '.edit-bn', function() {
        id = $(this).attr('data-id');

        $.ajax({
            url: 'settings/edit-bin/' + id,
            type: 'GET',
            beforeSend: function() {
                $('#ajax_process_modal').modal('show');
            },
            success: function(data) {
                var optionsHoldingBinTabModal = {
                    ajax: {
                        url: 'settings/select-holding',
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'SELECT HOLDING',
                    },
                    preprocessData: function(data) {
                        var i, l = data.length,
                            array = [];
                        if (l) {
                            for (i = 0; i < l; i++) {
                                array.push($.extend(true, data[i], {
                                    text: data[i].holding,
                                    value: data[i].id,
                                }));
                            }
                        }
                        return array;
                    }
                };

                $("#select_holding_bin_tab_modal > button[title='SELECT HOLDING']").replaceWith('<button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" data-id="holding_bin_tab_modal" title="' + data.holding + '"><span class="filter-option pull-left">' + data.holding + '</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>');
                $('#select_holding_bin_tab_modal > .dropdown-menu.open').replaceWith('<div class="dropdown-menu open" style="min-height: 39px; max-height: 228px; overflow: hidden;"><div class="bs-searchbox"><input type="text" class="form-control input-sm" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px; max-height: 177px; overflow-y: auto;"><li class="dropdown-header" data-optgroup="1"><span class="text">Currently Selected</span></li><li data-original-index="0" data-optgroup="1" class="selected active"><a tabindex="0" class="opt  " style="" data-tokens="null"><span class="text">' + data.holding + '</span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul><div class="status" style="">Start typing a search query</div></div>');
                $('#select_holding_bin_tab_modal > #holding_bin_tab_modal').replaceWith('<select id="holding_bin_tab_modal" class="holding-bin-tab-modal with-ajax" data-live-search="true" data-width="100%" tabindex="-98"><optgroup label="Currently Selected"><option value="' + data.holdingId + '" selected="selected">' + data.holding + '</option></optgroup></select>');

                $('.holding-bin-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsHoldingBinTabModal);
                $('.holding-bin-tab-modal').trigger('change');
                $('button[data-id="holding_bin_tab_modal"]').addClass("btn-sm");

                var optionsCompanyBinTabModal = {
                    ajax: {
                        url: 'settings/select-company/' + data.holdingId,
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

                $("#select_company_bin_tab_modal > button[title='SELECT COMPANY']").replaceWith('<button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" data-id="company_bin_tab_modal" title="' + data.company + '"><span class="filter-option pull-left">' + data.company + '</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>');
                $('#select_company_bin_tab_modal > .dropdown-menu.open').replaceWith('<div class="dropdown-menu open" style="min-height: 39px; max-height: 228px; overflow: hidden;"><div class="bs-searchbox"><input type="text" class="form-control input-sm" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px; max-height: 177px; overflow-y: auto;"><li class="dropdown-header" data-optgroup="1"><span class="text">Currently Selected</span></li><li data-original-index="0" data-optgroup="1" class="selected active"><a tabindex="0" class="opt  " style="" data-tokens="null"><span class="text">' + data.company + '<small class="text-muted">' + data.company_desc + '</small></span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul><div class="status" style="">Start typing a search query</div></div>');
                $('#select_company_bin_tab_modal > #company_bin_tab_modal').replaceWith('<select id="company_bin_tab_modal" class="company-bin-tab-modal with-ajax" data-live-search="true" data-width="100%" tabindex="-98"><optgroup label="Currently Selected"><option value="' + data.companyId + '" selected="selected">' + data.company + '</option></optgroup></select>');

                $('.company-bin-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsCompanyBinTabModal);
                $('.company-bin-tab-modal').trigger('change');
                $('button[data-id="company_bin_tab_modal"]').addClass("btn-sm");

                var companyId = data.company;
                var optionsPlantBinTabModal = {
                    ajax: {
                        url: 'settings/select-plant/' + companyId,
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'SELECT PLANT',
                    },
                    preprocessData: function(data) {
                        var i, l = data.length,
                            array = [];
                        if (l) {
                            for (i = 0; i < l; i++) {
                                array.push($.extend(true, data[i], {
                                    text: data[i].plant,
                                    value: data[i].id,
                                }));
                            }
                        }
                        return array;
                    }
                };

                $("#select_plant_bin_tab_modal > button[title='SELECT PLANT']").replaceWith('<button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" data-id="plant_bin_tab_modal" title="' + data.plant + '"><span class="filter-option pull-left">' + data.plant + '</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>');
                $('#select_plant_bin_tab_modal > .dropdown-menu.open').replaceWith('<div class="dropdown-menu open" style="min-height: 39px; max-height: 228px; overflow: hidden;"><div class="bs-searchbox"><input type="text" class="form-control input-sm" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px; max-height: 177px; overflow-y: auto;"><li class="dropdown-header" data-optgroup="1"><span class="text">Currently Selected</span></li><li data-original-index="0" data-optgroup="1" class="selected active"><a tabindex="0" class="opt  " style="" data-tokens="null"><span class="text">' + data.plant + '<small class="text-muted">' + data.plant_desc + '</small></span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul><div class="status" style="">Start typing a search query</div></div>');
                $('#select_plant_bin_tab_modal > #plant_bin_tab_modal').replaceWith('<select id="plant_bin_tab_modal" class="plant-bin-tab-modal with-ajax" data-live-search="true" data-width="100%" tabindex="-98"><optgroup label="Currently Selected"><option value="' + data.plantId + '" selected="selected">' + data.plant + '</option></optgroup></select>');

                $('.plant-bin-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsPlantBinTabModal);
                $('.plant-bin-tab-modal').trigger('change');
                $('button[data-id="plant_bin_tab_modal"]').addClass("btn-sm");

                var plantId = data.plant;
                var optionsLocationBinTabModal = {
                    ajax: {
                        url: 'settings/select-location/' + plantId,
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'SELECT LOCATION',
                    },
                    preprocessData: function(data) {
                        var i, l = data.length,
                            array = [];
                        if (l) {
                            for (i = 0; i < l; i++) {
                                array.push($.extend(true, data[i], {
                                    text: data[i].location,
                                    value: data[i].id,
                                }));
                            }
                        }
                        return array;
                    }
                };

                $("#select_location_bin_tab_modal > button[title='SELECT LOCATION']").replaceWith('<button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" data-id="location_bin_tab_modal" title="' + data.location + '"><span class="filter-option pull-left">' + data.location + '</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>');
                $('#select_location_bin_tab_modal > .dropdown-menu.open').replaceWith('<div class="dropdown-menu open" style="min-height: 39px; max-height: 228px; overflow: hidden;"><div class="bs-searchbox"><input type="text" class="form-control input-sm" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px; max-height: 177px; overflow-y: auto;"><li class="dropdown-header" data-optgroup="1"><span class="text">Currently Selected</span></li><li data-original-index="0" data-optgroup="1" class="selected active"><a tabindex="0" class="opt  " style="" data-tokens="null"><span class="text">' + data.location + '<small class="text-muted">' + data.location_desc + '</small></span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul><div class="status" style="">Start typing a search query</div></div>');
                $('#select_location_bin_tab_modal > #location_bin_tab_modal').replaceWith('<select id="location_bin_tab_modal" class="location-bin-tab-modal with-ajax" data-live-search="true" data-width="100%" tabindex="-98"><optgroup label="Currently Selected"><option value="' + data.locationId + '" selected="selected">' + data.location + '</option></optgroup></select>');

                $('.location-bin-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsLocationBinTabModal);
                $('.location-bin-tab-modal').trigger('change');
                $('button[data-id="location_bin_tab_modal"]').addClass("btn-sm");

                var locationId = data.location;
                var optionsShelfBinTabModal = {
                    ajax: {
                        url: 'settings/select-shelf/' + locationId,
                        type: 'POST',
                        dataType: 'json',
                    },
                    locale: {
                        emptyTitle: 'SELECT SHELF',
                    },
                    preprocessData: function(data) {
                        var i, l = data.length,
                            array = [];
                        if (l) {
                            for (i = 0; i < l; i++) {
                                array.push($.extend(true, data[i], {
                                    text: data[i].shelf,
                                    value: data[i].id,
                                }));
                            }
                        }
                        return array;
                    }
                };

                $("#select_shelf_bin_tab_modal > button[title='SELECT SHELF']").replaceWith('<button type="button" class="btn dropdown-toggle btn-default" data-toggle="dropdown" data-id="shelf_bin_tab_modal" title="' + data.shelf + '"><span class="filter-option pull-left">' + data.shelf + '</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>');
                $('#select_shelf_bin_tab_modal > .dropdown-menu.open').replaceWith('<div class="dropdown-menu open" style="min-height: 39px; max-height: 228px; overflow: hidden;"><div class="bs-searchbox"><input type="text" class="form-control input-sm" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px; max-height: 177px; overflow-y: auto;"><li class="dropdown-header" data-optgroup="1"><span class="text">Currently Selected</span></li><li data-original-index="0" data-optgroup="1" class="selected active"><a tabindex="0" class="opt  " style="" data-tokens="null"><span class="text">' + data.shelf + '<small class="text-muted">' + data.shelf_desc + '</small></span><span class="glyphicon glyphicon-ok check-mark"></span></a></li></ul><div class="status" style="">Start typing a search query</div></div>');
                $('#select_shelf_bin_tab_modal > #shelf_bin_tab_modal').replaceWith('<select id="shelf_bin_tab_modal" class="shelf-bin-tab-modal with-ajax" data-live-search="true" data-width="100%" tabindex="-98"><optgroup label="Currently Selected"><option value="' + data.shelfId + '" selected="selected">' + data.shelf + '</option></optgroup></select>');

                $('.shelf-bin-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsShelfBinTabModal);
                $('.shelf-bin-tab-modal').trigger('change');
                $('button[data-id="shelf_bin_tab_modal"]').addClass("btn-sm");

                $('.bs-searchbox > input.form-control').addClass("input-sm");

                $('#bin_bin_tab_modal').val(data.bin);
                $('#bin_desc_bin_tab_modal').val(data.description);
                $('#id_bin_tab_modal').val(id);

                $('#btn_save_bin_tab_modal').val("UPDATE").removeAttr("disabled");
                $('#bin_tab_modal_title').text("EDIT BIN");
                $('#ajax_process_modal').modal('hide');
                $('#bin_tab_modal').modal('show');
            },
            error: function() {
                $('#ajax_process_modal').modal('hide');
            }
        });
    });
    // End Edit Bin

    // Press Enter bin_tab_modal
    $("#bin_tab_modal").keypress(function(e) {
        switch (e.which) {
            case 13:
                $("#btn_save_bin_tab_modal").trigger("click");
                break;
        }
    });
    // End Press Enter bin_tab_modal

    // Save Bin
    $("#btn_save_bin_tab_modal").click(function() {
        var formData = {
            bin: $('#bin_bin_tab_modal').val().trim(),
            description: $('#bin_desc_bin_tab_modal').val().trim(),
            tbl_shelf_id: $('#shelf_bin_tab_modal').val(),
            created_by: $('#logged_in_user').val(),
            last_updated_by: $('#logged_in_user').val(),
        }

        var state = $('#btn_save_bin_tab_modal').val();
        var type = "POST";
        var url = 'settings/add-bin';
        var binId = $('#id_bin_tab_modal').val();

        if (state == "UPDATE") {
            type = "PUT";
            url = 'settings/update-bin/' + binId;
        }

        $.ajax({
            type: type,
            url: url,
            data: formData,
            dataType: 'json',
            beforeSend: function(data) {
                $("#bin_tab_modal :input").prop('disabled', true);
                $(".error_saving_bin_tab_modal").hide();
                $(".error_updating_bin_tab_modal").hide();

                if (state == "SAVE") {
                    $(".saving_bin_tab_modal").show();
                } else {
                    $(".updating_bin_tab_modal").show();
                }

                $("#form_bin_bin_tab_modal").removeClass("has-error");
                $("#bin_bin_tab_modal + p.help-block").text("");

                $("#form_shelf_bin_tab_modal").removeClass("has-error");
                $("#shelf_bin_tab_modal + p.help-block").text("");

                $("#form_bin_desc_bin_tab_modal").removeClass("has-error");
                $("#bin_desc_bin_tab_modal + p.help-block").text("");
            },
            success: function(data) {
                $('#bin_tab_modal_form').trigger("reset");
                $(".saving_bin_tab_modal").hide();
                $(".updating_bin_tab_modal").hide();

                $('#bin_tab_modal').modal('hide');
                reload_table();
                $("#bin_tab_modal :input").prop('disabled', false);

                $("#form_bin_bin_tab_modal").removeClass("has-error");
                $("#bin_bin_tab_modal + p.help-block").text("");

                $("#form_shelf_bin_tab_modal").removeClass("has-error");
                $("#shelf_bin_tab_modal + p.help-block").text("");

                $("#form_bin_desc_bin_tab_modal").removeClass("has-error");
                $("#bin_desc_bin_tab_modal + p.help-block").text("");
            },
            error: function(data) {
                $(".saving_bin_tab_modal").hide();
                $(".updating_bin_tab_modal").hide();
                if (state == "SAVE") {
                    $(".error_saving_bin_tab_modal").show();
                } else {
                    $(".error_updating_bin_tab_modal").show();
                }
                $("#bin_tab_modal :input").prop('disabled', false);

                var errors = data.responseJSON;

                if (errors.bin) {
                    $("#form_bin_bin_tab_modal").addClass("has-error");
                    $("#bin_bin_tab_modal + p.help-block").text(errors.bin);
                } else {
                    $("#form_bin_bin_tab_modal").removeClass("has-error");
                    $("#bin_bin_tab_modal + p.help-block").text("");
                }

                if (errors.shelf) {
                    $("#form_shelf_bin_tab_modal").addClass("has-error");
                    $("#shelf_bin_tab_modal + p.help-block").text(errors.shelf);
                } else {
                    $("#form_shelf_bin_tab_modal").removeClass("has-error");
                    $("#shelf_bin_tab_modal + p.help-block").text("");
                }

                if (errors.description) {
                    $("#form_bin_desc_bin_tab_modal").addClass("has-error");
                    $("#bin_desc_bin_tab_modal + p.help-block").text(errors.description);
                } else {
                    $("#form_bin_desc_bin_tab_modal").removeClass("has-error");
                    $("#bin_desc_bin_tab_modal + p.help-block").text("");
                }
            }
        });
    });
    // End Save Bin

    // Delete Bin
    $(document).on('click', '.delete-bn', function() {
        id = $(this).attr('data-id');

        var bin = $("table#bin_table tr#" + id + " td:eq(1)").html();
        var description = $("table#bin_table tr#" + id + " td:eq(2)").html();
        var msg = "<table class=\"table table-striped\">";
        msg += "<thead><tr><th>BIN</th><th>DESCRIPTION</th></thead>";
        msg += "<tbody><tr><td>" + bin + "</td><td>" + description + "</td></tr></tbody>";
        msg += "</table>";

        bootbox.dialog({
            message: msg,
            title: "Are you sure you want to delete this Bin?",
            buttons: {
                success: {
                    label: "YES DELETE",
                    className: "btn-danger btn-sm",
                    callback: function() {
                        $.ajax({
                            type: "DELETE",
                            url: 'settings/delete-bin/' + id,
                            beforeSend: function() {},
                            success: function() {
                                reload_table();
                            },
                            error: function() {
                                alert('Cannot delete this Bin.');
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
    // End Delete Bin

    // Changed Select inside Modal
    $(document).ajaxComplete(function() {

        $('#holding_bin_tab_modal').on('changed.bs.select', function(e) {
            $('#select_company_bin_tab_modal').html('<select id="company_bin_tab_modal" class="company-bin-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');

            var plantSelectModal = '<div class="btn-group bootstrap-select disabled plant-bin-tab-modal with-ajax" style="width: 100%;">';
            plantSelectModal += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="plant_bin_tab_modal" tabindex="-1" title="SELECT PLANT"><span class="filter-option pull-left">SELECT PLANT</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
            plantSelectModal += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
            plantSelectModal += '<select id="plant_bin_tab_modal" class="plant-bin-tab-modal with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="SELECT PLANT"><option class="bs-title-option" value="">SELECT PLANT</option></select>';
            plantSelectModal += '</div>';
            $("#select_plant_bin_tab_modal").html(plantSelectModal);

            var locationSelectModal = '<div class="btn-group bootstrap-select disabled location-bin-tab-modal with-ajax" style="width: 100%;">';
            locationSelectModal += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="location_bin_tab_modal" tabindex="-1" title="SELECT LOCATION"><span class="filter-option pull-left">SELECT LOCATION</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
            locationSelectModal += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
            locationSelectModal += '<select id="location_bin_tab_modal" class="location-bin-tab-modal with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="SELECT LOCATION"><option class="bs-title-option" value="">SELECT LOCATION</option></select>';
            locationSelectModal += '</div>';
            $("#select_location_bin_tab_modal").html(locationSelectModal);

            var shelfSelectModal = '<div class="btn-group bootstrap-select disabled shelf-bin-tab-modal with-ajax" style="width: 100%;">';
            shelfSelectModal += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="shelf_bin_tab_modal" tabindex="-1" title="SELECT SHELF"><span class="filter-option pull-left">SELECT SHELF</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
            shelfSelectModal += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
            shelfSelectModal += '<select id="shelf_bin_tab_modal" class="shelf-bin-tab-modal with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="SELECT SHELF"><option class="bs-title-option" value="">SELECT SHELF</option></select>';
            shelfSelectModal += '</div>';
            $("#select_shelf_bin_tab_modal").html(shelfSelectModal);

            var holdingId = $(this).val();
            var optionsCompanyBinTabModal = {
                ajax: {
                    url: 'settings/select-company/' + holdingId,
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

            $('.company-bin-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsCompanyBinTabModal);
            $('.company-bin-tab-modal').trigger('change');
            $('button[data-id="company_bin_tab_modal"]').addClass("btn-sm");
            $('.bs-searchbox > input.form-control').addClass("input-sm");
        });

        $('#company_bin_tab_modal').on('changed.bs.select', function(e) {
            $('#select_plant_bin_tab_modal').html('<select id="plant_bin_tab_modal" class="plant-bin-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');

            var locationSelectModal = '<div class="btn-group bootstrap-select disabled location-bin-tab-modal with-ajax" style="width: 100%;">';
            locationSelectModal += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="location_bin_tab_modal" tabindex="-1" title="SELECT LOCATION"><span class="filter-option pull-left">SELECT LOCATION</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
            locationSelectModal += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
            locationSelectModal += '<select id="location_bin_tab_modal" class="location-bin-tab-modal with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="SELECT LOCATION"><option class="bs-title-option" value="">SELECT LOCATION</option></select>';
            locationSelectModal += '</div>';
            $("#select_location_bin_tab_modal").html(locationSelectModal);

            var shelfSelectModal = '<div class="btn-group bootstrap-select disabled shelf-bin-tab-modal with-ajax" style="width: 100%;">';
            shelfSelectModal += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="shelf_bin_tab_modal" tabindex="-1" title="SELECT SHELF"><span class="filter-option pull-left">SELECT SHELF</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
            shelfSelectModal += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
            shelfSelectModal += '<select id="shelf_bin_tab_modal" class="shelf-bin-tab-modal with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="SELECT SHELF"><option class="bs-title-option" value="">SELECT SHELF</option></select>';
            shelfSelectModal += '</div>';
            $("#select_shelf_bin_tab_modal").html(shelfSelectModal);

            $("#bin_bin_tab_modal").val("");
            $("#bin_desc_bin_tab_modal").val("");

            var companyId = $(this).val();
            var optionsPlantBinTabModal = {
                ajax: {
                    url: 'settings/select-plant/' + companyId,
                    type: 'POST',
                    dataType: 'json',
                },
                locale: {
                    emptyTitle: 'SELECT PLANT',
                },
                preprocessData: function(data) {
                    var i, l = data.length,
                        array = [];
                    if (l) {
                        for (i = 0; i < l; i++) {
                            array.push($.extend(true, data[i], {
                                text: data[i].plant,
                                value: data[i].id,
                            }));
                        }
                    }
                    return array;
                }
            };

            $('.plant-bin-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsPlantBinTabModal);
            $('.plant-bin-tab-modal').trigger('change');
            $('button[data-id="plant_bin_tab_modal"]').addClass("btn-sm");
            $('.bs-searchbox > input.form-control').addClass("input-sm");
        });

        $('#plant_bin_tab_modal').on('changed.bs.select', function(e) {
            $('#select_location_bin_tab_modal').html('<select id="location_bin_tab_modal" class="location-bin-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');

            var shelfSelectModal = '<div class="btn-group bootstrap-select disabled shelf-bin-tab-modal with-ajax" style="width: 100%;">';
            shelfSelectModal += '<button type="button" class="btn dropdown-toggle disabled btn-default btn-sm" data-toggle="dropdown" data-id="shelf_bin_tab_modal" tabindex="-1" title="SELECT SHELF"><span class="filter-option pull-left">SELECT SHELF</span>&nbsp;<span class="bs-caret"><span class="caret"></span></span></button>';
            shelfSelectModal += '<div class="dropdown-menu open" style="min-height: 0px;"><div class="bs-searchbox"><input type="text" class="form-control" autocomplete="off" placeholder="Search..."></div><ul class="dropdown-menu inner" role="menu" style="min-height: 0px;"></ul><div class="status" style="">Start typing a search query</div></div>';
            shelfSelectModal += '<select id="shelf_bin_tab_modal" class="shelf-bin-tab-modal with-ajax" data-live-search="true" data-width="100%" disabled="" tabindex="-98" title="SELECT SHELF"><option class="bs-title-option" value="">SELECT SHELF</option></select>';
            shelfSelectModal += '</div>';
            $("#select_shelf_bin_tab_modal").html(shelfSelectModal);

            var plantId = $(this).val();
            var optionsLocationBinTabModal = {
                ajax: {
                    url: 'settings/select-location/' + plantId,
                    type: 'POST',
                    dataType: 'json',
                },
                locale: {
                    emptyTitle: 'SELECT LOCATION',
                },
                preprocessData: function(data) {
                    var i, l = data.length,
                        array = [];
                    if (l) {
                        for (i = 0; i < l; i++) {
                            array.push($.extend(true, data[i], {
                                text: data[i].location,
                                value: data[i].id,
                            }));
                        }
                    }
                    return array;
                }
            };

            $('.location-bin-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsLocationBinTabModal);
            $('.location-bin-tab-modal').trigger('change');
            $('button[data-id="location_bin_tab_modal"]').addClass("btn-sm");
            $('.bs-searchbox > input.form-control').addClass("input-sm");
        });

        $('#location_bin_tab_modal').on('changed.bs.select', function(e) {
            $('#select_shelf_bin_tab_modal').html('<select id="shelf_bin_tab_modal" class="shelf-bin-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');

            var locationId = $(this).val();
            var optionsShelfBinTabModal = {
                ajax: {
                    url: 'settings/select-shelf/' + locationId,
                    type: 'POST',
                    dataType: 'json',
                },
                locale: {
                    emptyTitle: 'SELECT SHELF',
                },
                preprocessData: function(data) {
                    var i, l = data.length,
                        array = [];
                    if (l) {
                        for (i = 0; i < l; i++) {
                            array.push($.extend(true, data[i], {
                                text: data[i].shelf,
                                value: data[i].id,
                            }));
                        }
                    }
                    return array;
                }
            };

            $('.shelf-bin-tab-modal').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsShelfBinTabModal);
            $('.shelf-bin-tab-modal').trigger('change');
            $('button[data-id="shelf_bin_tab_modal"]').addClass("btn-sm");
            $('.bs-searchbox > input.form-control').addClass("input-sm");
        });
    });
    // End Changed Select inside Modal

    // Bin Modal hide
    $('#bin_tab_modal').on('hide.bs.modal', function(e) {
        $('#select_holding_bin_tab_modal').html('<select id="holding_bin_tab_modal" class="holding-bin-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');
        $('#select_company_bin_tab_modal').html('<select id="company_bin_tab_modal" class="company-bin-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');
        $('#select_plant_bin_tab_modal').html('<select id="plant_bin_tab_modal" class="plant-bin-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');
        $('#select_location_bin_tab_modal').html('<select id="location_bin_tab_modal" class="location-bin-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');
        $('#select_shelf_bin_tab_modal').html('<select id="shelf_bin_tab_modal" class="shelf-bin-tab-modal with-ajax" data-live-search="true" data-width="100%"></select>');

        $(".error_saving_bin_tab_modal").hide();
        $(".error_updating_bin_tab_modal").hide();

        $('#bin_tab_modal_form').trigger("reset");

        $("#form_bin_bin_tab_modal").removeClass("has-error");
        $("#bin_bin_tab_modal + p.help-block").text("");

        $("#form_shelf_bin_tab_modal").removeClass("has-error");
        $("#shelf_bin_tab_modal + p.help-block").text("");

        $("#form_bin_desc_bin_tab_modal").removeClass("has-error");
        $("#bin_desc_bin_tab_modal + p.help-block").text("");
    });
    // End Bin Modal Hide

    // END HOLDING-BIN BIN TAB
    // ============================================================
    // ============================================================




    // START ITEM TYPE TAB
    // ============================================================
    // ============================================================

    var datatable_item_type_tab;
    $("#item_type_tab").one("click", function() {

        datatable_item_type_tab = $('#item_type_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'settings/datatables-item-type',
            },
            columns: [{
                data: 'rownum',
                name: 'rownum',
                searchable: false
            }, {
                data: 'created_at',
                name: 'created_at',
                searchable: false
            }, {
                data: 'type',
                name: 'type'
            }, {
                data: 'description',
                name: 'description'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
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
                "sSearch": "",
                "sSearchPlaceholder": "SEARCH",
            },
            columnDefs: [{
                "targets": [1],
                "visible": false,
            }, ],
            order: [
                [1, 'desc']
            ]
        });

        $("select.form-control").selectpicker();
        $("div.dataTables_length > label > div.btn-group > button").addClass("btn-sm");

        // Right Click Datatables Item Type Tab
        new BootstrapMenu('table#item_type_table', {
            actions: [{
                name: 'REFRESH ITEM TYPE DATA',
                onClick: function() {
                    datatable_item_type_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Datatables Item Type Tab
    });

    // Reload Item Type DataTables
    function reload_item_type_table() {
        datatable_item_type_tab.ajax.reload(null, false);
    }
    // End Reload Item Type DataTables

    // Add Item Type
    $(document).on('click', '#add-it', function() {
        $('#btn_save_item_type_tab_modal').val("SAVE").removeAttr("disabled");
        $('#item_type_tab_modal_title').text("ADD ITEM TYPE");
        $('#item_type_tab_modal').modal('show');
    });
    // End Add Item Type

    // Edit Item Type
    $(document).on('click', '.edit-it', function() {
        id = $(this).attr('data-id');

        var type = $("table#item_type_table tr#" + id + " td:eq(1)").html();
        var description = $("table#item_type_table tr#" + id + " td:eq(2)").html();

        $('#item_type_item_type_tab_modal').val(type);
        $('#desc_item_type_tab_modal').val(description);
        $('#id_item_type_tab_modal').val(id);

        $('#btn_save_item_type_tab_modal').val("UPDATE").removeAttr("disabled");
        $('#item_type_tab_modal_title').text("EDIT ITEM TYPE");
        $('#ajax_process_modal').modal('hide');
        $('#item_type_tab_modal').modal('show');
    });
    // End Edit Item Type

    // Press Enter item_type_tab_modal
    $("#item_type_tab_modal").keypress(function(e) {
        switch (e.which) {
            case 13:
                $("#btn_save_item_type_tab_modal").trigger("click");
                break;
        }
    });
    // End Press Enter item_type_tab_modal


    // Save Catalog Type
    $("#btn_save_item_type_tab_modal").click(function() {
        var formData = {
            type: $('#item_type_item_type_tab_modal').val().trim(),
            description: $('#desc_item_type_tab_modal').val().trim(),
            created_by: $('#logged_in_user').val(),
            last_updated_by: $('#logged_in_user').val(),
        }

        var state = $('#btn_save_item_type_tab_modal').val();
        var type = "POST";
        var url = 'settings/add-item-type';
        var id = $('#id_item_type_tab_modal').val();

        if (state == "UPDATE") {
            type = "PUT";
            url = 'settings/update-item-type/' + id;
        }

        $.ajax({
            type: type,
            url: url,
            data: formData,
            dataType: 'json',
            beforeSend: function(data) {
                $("#item_type_tab_modal :input").prop('disabled', true);
                $(".error_saving_item_type_tab_modal").hide();
                $(".error_updating_item_type_tab_modal").hide();

                if (state == "SAVE") {
                    $(".saving_item_type_tab_modal").show();
                } else {
                    $(".updating_item_type_tab_modal").show();
                }
                $("#form_item_type_item_type_tab_modal").removeClass("has-error");
                $("#item_type_item_type_tab_modal + p.help-block").text("");
                $("#form_desc_item_type_tab_modal").removeClass("has-error");
                $("#desc_item_type_tab_modal + p.help-block").text("");
            },
            success: function(data) {
                $('#item_type_tab_modal_form').trigger("reset");
                $(".saving_item_type_tab_modal").hide();
                $(".updating_item_type_tab_modal").hide();

                $('#item_type_tab_modal').modal('hide');
                reload_item_type_table();
                $("#item_type_tab_modal :input").prop('disabled', false);

                $("#form_item_type_item_type_tab_modal").removeClass("has-error");
                $("#item_type_item_type_tab_modal + p.help-block").text("");
                $("#form_desc_item_type_tab_modal").removeClass("has-error");
                $("#desc_item_type_tab_modal + p.help-block").text("");
            },
            error: function(data) {
                $(".saving_item_type_tab_modal").hide();
                $(".updating_item_type_tab_modal").hide();
                if (state == "SAVE") {
                    $(".error_saving_item_type_tab_modal").show();
                } else {
                    $(".error_updating_item_type_tab_modal").show();
                }
                $("#item_type_tab_modal :input").prop('disabled', false);

                var errors = data.responseJSON;

                if (errors.type) {
                    $("#form_item_type_item_type_tab_modal").addClass("has-error");
                    $("#item_type_item_type_tab_modal + p.help-block").text(errors.type);
                } else {
                    $("#form_item_type_item_type_tab_modal").removeClass("has-error");
                    $("#item_type_item_type_tab_modal + p.help-block").text("");
                }

                if (errors.description) {
                    $("#form_desc_item_type_tab_modal").addClass("has-error");
                    $("#desc_item_type_tab_modal + p.help-block").text(errors.description);
                } else {
                    $("#form_desc_item_type_tab_modal").removeClass("has-error");
                    $("#desc_item_type_tab_modal + p.help-block").text("");
                }
            }
        });
    });
    // End Save Item Type

    // Delete Item Type
    $(document).on('click', '.delete-it', function() {
        id = $(this).attr('data-id');

        var type = $("table#item_type_table tr#" + id + " td:eq(1)").html();
        var description = $("table#item_type_table tr#" + id + " td:eq(2)").html();
        var msg = "<table class=\"table table-striped\">";
        msg += "<thead><tr><th>ITEM TYPE</th><th>DESCRIPTION</th></thead>";
        msg += "<tbody><tr><td>" + type + "</td><td>" + description + "</td></tr></tbody>";
        msg += "</table>";

        bootbox.dialog({
            message: msg,
            title: "Are you sure you want to delete this Item Type?",
            buttons: {
                success: {
                    label: "YES DELETE",
                    className: "btn-danger btn-sm",
                    callback: function() {
                        $.ajax({
                            type: "DELETE",
                            url: 'settings/delete-item-type/' + id,
                            beforeSend: function() {},
                            success: function() {
                                reload_item_type_table();
                            },
                            error: function() {
                                alert('Cannot delete this Item Type.');
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
    // End Delete Item Type

    // Item Type Modal hide
    $('#item_type_tab_modal').on('hide.bs.modal', function(e) {
        $(".error_saving_item_type_tab_modal").hide();
        $(".error_updating_item_type_tab_modal").hide();

        $('#item_type_tab_modal_form').trigger("reset");

        $("#form_item_type_item_type_tab_modal").removeClass("has-error");
        $("#item_type_item_type_tab_modal + p.help-block").text("");
        $("#form_desc_item_type_tab_modal").removeClass("has-error");
        $("#desc_item_type_tab_modal + p.help-block").text("");
    });
    // End Item Type Modal Hide

    // END ITEM TYPE TAB
    // ============================================================
    // ============================================================




    // START SOURCE TYPE TAB
    // ============================================================
    // ============================================================

    var datatable_source_type_tab;
    $("#source_type_tab").one("click", function() {

        datatable_source_type_tab = $('#source_type_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'settings/datatables-source-type',
            },
            columns: [{
                data: 'rownum',
                name: 'rownum',
                searchable: false
            }, {
                data: 'created_at',
                name: 'created_at',
                searchable: false
            }, {
                data: 'type',
                name: 'type'
            }, {
                data: 'description',
                name: 'description'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
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
                "sSearch": "",
                "sSearchPlaceholder": "SEARCH",
            },
            columnDefs: [{
                "targets": [1],
                "visible": false,
            }, ],
            order: [
                [1, 'desc']
            ]
        });

        $("select.form-control").selectpicker();
        $("div.dataTables_length > label > div.btn-group > button").addClass("btn-sm");

        // Right Click Datatables Source Type Tab
        new BootstrapMenu('table#source_type_table', {
            actions: [{
                name: 'REFRESH SOURCE TYPE DATA',
                onClick: function() {
                    datatable_source_type_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Datatables Source Type Tab
    });

    // Reload Source Type DataTables
    function reload_source_type_table() {
        datatable_source_type_tab.ajax.reload(null, false);
    }
    // End Reload Source Type DataTables

    // Add Source Type
    $(document).on('click', '#add-sot', function() {
        $('#btn_save_source_type_tab_modal').val("SAVE").removeAttr("disabled");
        $('#source_type_tab_modal_title').text("ADD SOURCE TYPE");
        $('#source_type_tab_modal').modal('show');
    });
    // End Add Source Type

    // Edit Source Type
    $(document).on('click', '.edit-sot', function() {
        id = $(this).attr('data-id');

        var type = $("table#source_type_table tr#" + id + " td:eq(1)").html();
        var description = $("table#source_type_table tr#" + id + " td:eq(2)").html();

        $('#source_type_source_type_tab_modal').val(type);
        $('#desc_source_type_tab_modal').val(description);
        $('#id_source_type_tab_modal').val(id);

        $('#btn_save_source_type_tab_modal').val("UPDATE").removeAttr("disabled");
        $('#source_type_tab_modal_title').text("EDIT SOURCE TYPE");
        $('#ajax_process_modal').modal('hide');
        $('#source_type_tab_modal').modal('show');
    });
    // End Edit Source Type

    // Press Enter source_type_tab_modal
    $("#source_type_tab_modal").keypress(function(e) {
        switch (e.which) {
            case 13:
                $("#btn_save_source_type_tab_modal").trigger("click");
                break;
        }
    });
    // End Press Enter source_type_tab_modal

    // Save Source Type
    $("#btn_save_source_type_tab_modal").click(function() {
        var formData = {
            type: $('#source_type_source_type_tab_modal').val().trim(),
            description: $('#desc_source_type_tab_modal').val().trim(),
            created_by: $('#logged_in_user').val(),
            last_updated_by: $('#logged_in_user').val(),
        }

        var state = $('#btn_save_source_type_tab_modal').val();
        var type = "POST";
        var url = 'settings/add-source-type';
        var id = $('#id_source_type_tab_modal').val();

        if (state == "UPDATE") {
            type = "PUT";
            url = 'settings/update-source-type/' + id;
        }

        $.ajax({
            type: type,
            url: url,
            data: formData,
            dataType: 'json',
            beforeSend: function(data) {
                $("#source_type_tab_modal :input").prop('disabled', true);
                $(".error_saving_source_type_tab_modal").hide();
                $(".error_updating_source_type_tab_modal").hide();

                if (state == "SAVE") {
                    $(".saving_source_type_tab_modal").show();
                } else {
                    $(".updating_source_type_tab_modal").show();
                }

                $("#form_source_type_source_type_tab_modal").removeClass("has-error");
                $("#source_type_source_type_tab_modal + p.help-block").text("");
                $("#form_desc_source_type_tab_modal").removeClass("has-error");
                $("#desc_source_type_tab_modal + p.help-block").text("");
            },
            success: function(data) {
                $('#source_type_tab_modal_form').trigger("reset");
                $(".saving_source_type_tab_modal").hide();
                $(".updating_source_type_tab_modal").hide();

                $('#source_type_tab_modal').modal('hide');
                reload_source_type_table();
                $("#source_type_tab_modal :input").prop('disabled', false);

                $("#form_source_type_source_type_tab_modal").removeClass("has-error");
                $("#source_type_source_type_tab_modal + p.help-block").text("");
                $("#form_desc_source_type_tab_modal").removeClass("has-error");
                $("#desc_source_type_tab_modal + p.help-block").text("");
            },
            error: function(data) {
                $(".saving_source_type_tab_modal").hide();
                $(".updating_source_type_tab_modal").hide();
                if (state == "SAVE") {
                    $(".error_saving_source_type_tab_modal").show();
                } else {
                    $(".error_updating_source_type_tab_modal").show();
                }
                $("#source_type_tab_modal :input").prop('disabled', false);

                var errors = data.responseJSON;

                if (errors.type) {
                    $("#form_source_type_source_type_tab_modal").addClass("has-error");
                    $("#source_type_source_type_tab_modal + p.help-block").text(errors.type);
                } else {
                    $("#form_source_source_item_type_tab_modal").removeClass("has-error");
                    $("#source_source_item_type_tab_modal + p.help-block").text("");
                }

                if (errors.description) {
                    $("#form_desc_source_type_tab_modal").addClass("has-error");
                    $("#desc_source_type_tab_modal + p.help-block").text(errors.description);
                } else {
                    $("#form_desc_source_type_tab_modal").removeClass("has-error");
                    $("#desc_source_type_tab_modal + p.help-block").text("");
                }
            }
        });
    });
    // End Save Source Type

    // Delete Source Type
    $(document).on('click', '.delete-sot', function() {
        id = $(this).attr('data-id');

        var type = $("table#source_type_table tr#" + id + " td:eq(1)").html();
        var description = $("table#source_type_table tr#" + id + " td:eq(2)").html();
        var msg = "<table class=\"table table-striped\">";
        msg += "<thead><tr><th>SOURCE TYPE</th><th>DESCRIPTION</th></thead>";
        msg += "<tbody><tr><td>" + type + "</td><td>" + description + "</td></tr></tbody>";
        msg += "</table>";

        bootbox.dialog({
            message: msg,
            title: "Are you sure you want to delete this Source Type?",
            buttons: {
                success: {
                    label: "YES DELETE",
                    className: "btn-danger btn-sm",
                    callback: function() {
                        $.ajax({
                            type: "DELETE",
                            url: 'settings/delete-source-type/' + id,
                            beforeSend: function() {},
                            success: function() {
                                reload_source_type_table();
                            },
                            error: function() {
                                alert('Cannot delete this Source Type.');
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
    // End Delete Source Type

    // Source Type Modal hide
    $('#source_type_tab_modal').on('hide.bs.modal', function(e) {
        $(".error_saving_source_type_tab_modal").hide();
        $(".error_updating_source_type_tab_modal").hide();
        $('#source_type_tab_modal_form').trigger("reset");

        $("#form_source_type_source_type_tab_modal").removeClass("has-error");
        $("#source_type_source_type_tab_modal + p.help-block").text("");
        $("#form_desc_source_type_tab_modal").removeClass("has-error");
        $("#desc_source_type_tab_modal + p.help-block").text("");

    });
    // End Source Type Modal Hide

    // END SOURCE TYPE TAB
    // ============================================================
    // ============================================================




    // START STOCK TYPE TAB
    // ============================================================
    // ============================================================

    var datatable_stock_type_tab;
    $("#stock_type_tab").one("click", function() {

        datatable_stock_type_tab = $('#stock_type_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'settings/datatables-stock-type',
            },
            columns: [{
                data: 'rownum',
                name: 'rownum',
                searchable: false
            }, {
                data: 'created_at',
                name: 'created_at',
                searchable: false
            }, {
                data: 'type',
                name: 'type'
            }, {
                data: 'description',
                name: 'description'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
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
                "sSearch": "",
                "sSearchPlaceholder": "SEARCH",
            },
            columnDefs: [{
                "targets": [1],
                "visible": false,
            }, ],
            order: [
                [1, 'desc']
            ]
        });

        $("select.form-control").selectpicker();
        $("div.dataTables_length > label > div.btn-group > button").addClass("btn-sm");

        // Right Click Datatables Stock Type Tab
        new BootstrapMenu('table#stock_type_table', {
            actions: [{
                name: 'REFRESH STOCK TYPE DATA',
                onClick: function() {
                    datatable_stock_type_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Datatables Stock Type Tab
    });

    // Reload Stock Type DataTables
    function reload_stock_type_table() {
        datatable_stock_type_tab.ajax.reload(null, false);
    }
    // End Reload Stock Type DataTables

    // Add Source Type
    $(document).on('click', '#add-stt', function() {
        $('#btn_save_stock_type_tab_modal').val("SAVE").removeAttr("disabled");
        $('#stock_type_tab_modal_title').text("ADD STOCK TYPE");
        $('#stock_type_tab_modal').modal('show');
    });
    // End Add Stock Type

    // Edit Stock Type
    $(document).on('click', '.edit-stt', function() {
        id = $(this).attr('data-id');

        var type = $("table#stock_type_table tr#" + id + " td:eq(1)").html();
        var description = $("table#stock_type_table tr#" + id + " td:eq(2)").html();

        $('#stock_type_stock_type_tab_modal').val(type);
        $('#desc_stock_type_tab_modal').val(description);
        $('#id_stock_type_tab_modal').val(id);

        $('#btn_save_stock_type_tab_modal').val("UPDATE").removeAttr("disabled");
        $('#stock_type_tab_modal_title').text("EDIT STOCK TYPE");
        $('#ajax_process_modal').modal('hide');
        $('#stock_type_tab_modal').modal('show');
    });
    // End Edit Stock Type

    // Press Enter stock_type_tab_modal
    $("#stock_type_tab_modal").keypress(function(e) {
        switch (e.which) {
            case 13:
                $("#btn_save_stock_type_tab_modal").trigger("click");
                break;
        }
    });
    // End Press Enter stock_type_tab_modal

    // Save Stock Type
    $("#btn_save_stock_type_tab_modal").click(function() {
        var formData = {
            type: $('#stock_type_stock_type_tab_modal').val().trim(),
            description: $('#desc_stock_type_tab_modal').val().trim(),
            created_by: $('#logged_in_user').val(),
            last_updated_by: $('#logged_in_user').val(),
        }

        var state = $('#btn_save_stock_type_tab_modal').val();
        var type = "POST";
        var url = 'settings/add-stock-type';
        var id = $('#id_stock_type_tab_modal').val();

        if (state == "UPDATE") {
            type = "PUT";
            url = 'settings/update-stock-type/' + id;
        }

        $.ajax({
            type: type,
            url: url,
            data: formData,
            dataType: 'json',
            beforeSend: function(data) {
                $("#stock_type_tab_modal :input").prop('disabled', true);
                $(".error_saving_stock_type_tab_modal").hide();
                $(".error_updating_stock_type_tab_modal").hide();

                if (state == "SAVE") {
                    $(".saving_stock_type_tab_modal").show();
                } else {
                    $(".updating_stock_type_tab_modal").show();
                }

                $("#form_stock_type_stock_type_tab_modal").removeClass("has-error");
                $("#stock_type_stock_type_tab_modal + p.help-block").text("");

                $("#form_desc_stock_type_tab_modal").removeClass("has-error");
                $("#desc_stock_type_tab_modal + p.help-block").text("");
            },
            success: function(data) {
                $('#stock_type_tab_modal_form').trigger("reset");
                $(".saving_stock_type_tab_modal").hide();
                $(".updating_stock_type_tab_modal").hide();

                $('#stock_type_tab_modal').modal('hide');
                reload_stock_type_table();
                $("#stock_type_tab_modal :input").prop('disabled', false);

                $("#form_stock_type_stock_type_tab_modal").removeClass("has-error");
                $("#stock_type_stock_type_tab_modal + p.help-block").text("");

                $("#form_desc_stock_type_tab_modal").removeClass("has-error");
                $("#desc_stock_type_tab_modal + p.help-block").text("");
            },
            error: function(data) {
                $(".saving_stock_type_tab_modal").hide();
                $(".updating_stock_type_tab_modal").hide();
                if (state == "SAVE") {
                    $(".error_saving_stock_type_tab_modal").show();
                } else {
                    $(".error_updating_stock_type_tab_modal").show();
                }
                $("#stock_type_tab_modal :input").prop('disabled', false);

                var errors = data.responseJSON;

                if (errors.type) {
                    $("#form_stock_type_stock_type_tab_modal").addClass("has-error");
                    $("#stock_type_stock_type_tab_modal + p.help-block").text(errors.type);
                } else {
                    $("#form_stock_type_stock_type_tab_modal").removeClass("has-error");
                    $("#stock_type_stock_type_tab_modal + p.help-block").text("");
                }

                if (errors.description) {
                    $("#form_desc_stock_type_tab_modal").addClass("has-error");
                    $("#desc_stock_type_tab_modal + p.help-block").text(errors.description);
                } else {
                    $("#form_desc_stock_type_tab_modal").removeClass("has-error");
                    $("#desc_stock_type_tab_modal + p.help-block").text("");
                }
            }
        });
    });
    // End Save Stock Type

    // Delete Stock Type
    $(document).on('click', '.delete-stt', function() {
        id = $(this).attr('data-id');

        var type = $("table#stock_type_table tr#" + id + " td:eq(1)").html();
        var description = $("table#stock_type_table tr#" + id + " td:eq(2)").html();
        var msg = "<table class=\"table table-striped\">";
        msg += "<thead><tr><th>STOCK TYPE</th><th>DESCRIPTION</th></thead>";
        msg += "<tbody><tr><td>" + type + "</td><td>" + description + "</td></tr></tbody>";
        msg += "</table>";

        bootbox.dialog({
            message: msg,
            title: "Are you sure you want to delete this Stock Type?",
            buttons: {
                success: {
                    label: "YES DELETE",
                    className: "btn-danger btn-sm",
                    callback: function() {
                        $.ajax({
                            type: "DELETE",
                            url: 'settings/delete-stock-type/' + id,
                            beforeSend: function() {},
                            success: function() {
                                reload_stock_type_table();
                            },
                            error: function() {
                                alert('Cannot delete this Stock Type.');
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
    // End Delete Stock Type

    // Stock Type Modal hide
    $('#stock_type_tab_modal').on('hide.bs.modal', function(e) {
        $(".error_saving_stock_type_tab_modal").hide();
        $(".error_updating_stock_type_tab_modal").hide();
        $('#stock_type_tab_modal_form').trigger("reset");

        $("#form_stock_type_stock_type_tab_modal").removeClass("has-error");
        $("#stock_type_stock_type_tab_modal + p.help-block").text("");

        $("#form_desc_stock_type_tab_modal").removeClass("has-error");
        $("#desc_stock_type_tab_modal + p.help-block").text("");
    });
    // End Stock Type Modal Hide

    // END STOCK TYPE TAB
    // ============================================================
    // ============================================================




    // START Unit OF MEASUREMENT TAB
    // ============================================================
    // ============================================================

    var datatable_unit_of_measurement_tab;
    $("#unit_of_measurement_tab").one("click", function() {
        datatable_unit_of_measurement_tab = $('#unit_of_measurement_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'settings/datatables-unit-of-measurement',
            },
            columns: [{
                "className": 'details-control',
                "orderable": false,
                "searchable": false,
                "data": null,
                "defaultContent": ''
            }, {
                data: 'created_at',
                name: 'created_at',
                searchable: false
            }, {
                data: 'rownum',
                name: 'rownum',
                searchable: false
            }, {
                data: 'unit4',
                name: 'unit4'
            }, {
                data: 'unit3',
                name: 'unit3'
            }, {
                data: 'unit2',
                name: 'unit2'
            }, {
                data: 'description',
                name: 'description'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
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
                "sSearch": "",
                "sSearchPlaceholder": "SEARCH",
            },
            columnDefs: [{
                "targets": [1],
                "visible": false,
            }, ],
            order: [
                [1, 'desc']
            ]
        });

        $("select.form-control").selectpicker();
        $("div.dataTables_length > label > div.btn-group > button").addClass("btn-sm");

        // Right Click Datatables Unit Of Measurement Tab
        new BootstrapMenu('table#unit_of_measurement_table', {
            actions: [{
                name: 'REFRESH UNIT OF MEASUREMENT DATA',
                onClick: function() {
                    datatable_unit_of_measurement_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Datatables Unit Of Measurement Tab
    });

    /*$(document).ajaxComplete(function() {
      var template = Handlebars.compile($("#details-template").html());
      $('#unit_of_measurement_table tbody').on('click', 'td.details-control', function() {
          var tr = $(this).closest('tr');
          var row = datatable_unit_of_measurement_tab.row(tr);

          if (row.child.isShown()) {
              // This row is already open - close it
              row.child.hide();
              tr.removeClass('shown');
          } else {
              // Open this row
              row.child(template(row.data())).show();
              tr.addClass('shown');
          }
      });
      return false;
    });*/

    // Reload Unit Of Measurement DataTables
    function reload_unit_of_measurement_table() {
        datatable_unit_of_measurement_tab.ajax.reload(null, false);
    }
    // End Reload Unit Of Measurement DataTables

    // Add Source Type
    $(document).on('click', '#add-uom', function() {
        $('#btn_save_unit_of_measurement_tab_modal').val("SAVE").removeAttr("disabled");
        $('#unit_of_measurement_tab_modal_title').text("ADD UNIT OF MEASUREMENT");
        $('#unit_of_measurement_tab_modal').modal('show');
    });
    // End Add Unit Of Measurement

    // Edit Unit Of Measurement
    $(document).on('click', '.edit-uom', function() {
        id = $(this).attr('data-id');

        $.ajax({
            url: 'settings/edit-unit-of-measurement/' + id,
            type: 'GET',
            beforeSend: function() {
                $('#ajax_process_modal').modal('show');
            },
            success: function(data) {
                $('#unit4_unit_of_measurement_tab_modal').val(data.unit4);
                $('#unit3_unit_of_measurement_tab_modal').val(data.unit3);
                $('#unit2_unit_of_measurement_tab_modal').val(data.unit2);
                $('#desc_unit_of_measurement_tab_modal').val(data.description);
                $('#eng_definition_unit_of_measurement_tab_modal').val(data.eng_definition);
                $('#ind_definition_unit_of_measurement_tab_modal').val(data.ind_definition);
                $('#id_unit_of_measurement_tab_modal').val(id);

                $('#btn_save_unit_of_measurement_tab_modal').val("UPDATE").removeAttr("disabled");
                $('#unit_of_measurement_tab_modal_title').text("EDIT UNIT OF MEASUREMENT");
                $('#ajax_process_modal').modal('hide');
                $('#unit_of_measurement_tab_modal').modal('show');
            },
            error: function() {
                $('#ajax_process_modal').modal('hide');
            }
        });
    });
    // End Edit Unit Of Measurement

    // Press Enter unit_of_measurement_tab_modal
    $("#unit_of_measurement_tab_modal").keypress(function(e) {
        switch (e.which) {
            case 13:
                $("#btn_save_unit_of_measurement_tab_modal").trigger("click");
                break;
        }
    });
    // End Press Enter unit_of_measurement_tab_modal

    // Save Unit Of Measurement
    $("#btn_save_unit_of_measurement_tab_modal").click(function() {
        var formData = {
            unit4: $('#unit4_unit_of_measurement_tab_modal').val().trim(),
            unit3: $('#unit3_unit_of_measurement_tab_modal').val().trim(),
            unit2: $('#unit2_unit_of_measurement_tab_modal').val().trim(),
            description: $('#desc_unit_of_measurement_tab_modal').val().trim(),
            eng_definition: $('#eng_definition_unit_of_measurement_tab_modal').val().trim(),
            ind_definition: $('#ind_definition_unit_of_measurement_tab_modal').val().trim(),
            created_by: $('#logged_in_user').val(),
            last_updated_by: $('#logged_in_user').val(),
        }

        var state = $('#btn_save_unit_of_measurement_tab_modal').val();
        var type = "POST";
        var url = 'settings/add-unit-of-measurement';
        var id = $('#id_unit_of_measurement_tab_modal').val();

        if (state == "UPDATE") {
            type = "PUT";
            url = 'settings/update-unit-of-measurement/' + id;
        }

        $.ajax({
            type: type,
            url: url,
            data: formData,
            dataType: 'json',
            beforeSend: function(data) {
                $("#unit_of_measurement_tab_modal :input").prop('disabled', true);
                $(".error_saving_unit_of_measurement_tab_modal").hide();
                $(".error_updating_unit_of_measurement_tab_modal").hide();

                if (state == "SAVE") {
                    $(".saving_unit_of_measurement_tab_modal").show();
                } else {
                    $(".updating_unit_of_measurement_tab_modal").show();
                }

                $("#form_unit4_unit_of_measurement_tab_modal").removeClass("has-error");
                $("#unit4_unit_of_measurement_tab_modal + p.help-block").text("");

                $("#form_unit3_unit_of_measurement_tab_modal").removeClass("has-error");
                $("#unit3_unit_of_measurement_tab_modal + p.help-block").text("");

                $("#form_unit2_unit_of_measurement_tab_modal").removeClass("has-error");
                $("#unit2_unit_of_measurement_tab_modal + p.help-block").text("");

                $("#form_desc_unit_of_measurement_tab_modal").removeClass("has-error");
                $("#desc_unit_of_measurement_tab_modal + p.help-block").text("");

                $("#form_eng_definition_unit_of_measurement_tab_modal").removeClass("has-error");
                $("#eng_definition_unit_of_measurement_tab_modal + p.help-block").text("");

                $("#form_ind_definition_unit_of_measurement_tab_modal").removeClass("has-error");
                $("#ind_definition_unit_of_measurement_tab_modal + p.help-block").text("");
            },
            success: function(data) {
                $('#unit_of_measurement_tab_modal_form').trigger("reset");
                $(".saving_unit_of_measurement_tab_modal").hide();
                $(".updating_unit_of_measurement_tab_modal").hide();

                $('#unit_of_measurement_tab_modal').modal('hide');
                reload_unit_of_measurement_table();
                $("#unit_of_measurement_tab_modal :input").prop('disabled', false);

                $("#form_unit4_unit_of_measurement_tab_modal").removeClass("has-error");
                $("#unit4_unit_of_measurement_tab_modal + p.help-block").text("");

                $("#form_unit3_unit_of_measurement_tab_modal").removeClass("has-error");
                $("#unit3_unit_of_measurement_tab_modal + p.help-block").text("");

                $("#form_unit2_unit_of_measurement_tab_modal").removeClass("has-error");
                $("#unit2_unit_of_measurement_tab_modal + p.help-block").text("");

                $("#form_desc_unit_of_measurement_tab_modal").removeClass("has-error");
                $("#desc_unit_of_measurement_tab_modal + p.help-block").text("");

                $("#form_eng_definition_unit_of_measurement_tab_modal").removeClass("has-error");
                $("#eng_definition_unit_of_measurement_tab_modal + p.help-block").text("");

                $("#form_ind_definition_unit_of_measurement_tab_modal").removeClass("has-error");
                $("#ind_definition_unit_of_measurement_tab_modal + p.help-block").text("");
            },
            error: function(data) {
                $(".saving_unit_of_measurement_tab_modal").hide();
                $(".updating_unit_of_measurement_tab_modal").hide();
                if (state == "SAVE") {
                    $(".error_saving_unit_of_measurement_tab_modal").show();
                } else {
                    $(".error_updating_unit_of_measurement_tab_modal").show();
                }
                $("#unit_of_measurement_tab_modal :input").prop('disabled', false);

                var errors = data.responseJSON;

                if (errors.unit4) {
                    $("#form_unit4_unit_of_measurement_tab_modal").addClass("has-error");
                    $("#unit4_unit_of_measurement_tab_modal + p.help-block").text(errors.unit4);
                } else {
                    $("#form_unit4_unit_of_measurement_tab_modal").removeClass("has-error");
                    $("#unit4_unit_of_measurement_tab_modal + p.help-block").text("");
                }

                if (errors.unit3) {
                    $("#form_unit3_unit_of_measurement_tab_modal").addClass("has-error");
                    $("#unit3_unit_of_measurement_tab_modal + p.help-block").text(errors.unit3);
                } else {
                    $("#form_unit3_unit_of_measurement_tab_modal").removeClass("has-error");
                    $("#unit3_unit_of_measurement_tab_modal + p.help-block").text("");
                }

                if (errors.unit2) {
                    $("#form_unit2_unit_of_measurement_tab_modal").addClass("has-error");
                    $("#unit2_unit_of_measurement_tab_modal + p.help-block").text(errors.unit2);
                } else {
                    $("#form_unit2_unit_of_measurement_tab_modal").removeClass("has-error");
                    $("#unit2_unit_of_measurement_tab_modal + p.help-block").text("");
                }

                if (errors.description) {
                    $("#form_desc_unit_of_measurement_tab_modal").addClass("has-error");
                    $("#desc_unit_of_measurement_tab_modal + p.help-block").text(errors.description);
                } else {
                    $("#form_desc_unit_of_measurement_tab_modal").removeClass("has-error");
                    $("#desc_unit_of_measurement_tab_modal + p.help-block").text("");
                }

                if (errors.eng_definition) {
                    $("#form_eng_definition_unit_of_measurement_tab_modal").addClass("has-error");
                    $("#eng_definition_unit_of_measurement_tab_modal + p.help-block").text(errors.eng_definition);
                } else {
                    $("#form_eng_definition_unit_of_measurement_tab_modal").removeClass("has-error");
                    $("#eng_definition_unit_of_measurement_tab_modal + p.help-block").text("");
                }

                if (errors.ind_definition) {
                    $("#form_ind_definition_unit_of_measurement_tab_modal").addClass("has-error");
                    $("#ind_definition_unit_of_measurement_tab_modal + p.help-block").text(errors.ind_definition);
                } else {
                    $("#form_ind_definition_unit_of_measurement_tab_modal").removeClass("has-error");
                    $("#ind_definition_unit_of_measurement_tab_modal + p.help-block").text("");
                }
            }
        });
    });
    // End Save Unit Of Measurement

    // Delete Unit Of Measurement
    $(document).on('click', '.delete-uom', function() {
        id = $(this).attr('data-id');

        var unit4 = $("table#unit_of_measurement_table tr#" + id + " td:eq(2)").html();
        var unit3 = $("table#unit_of_measurement_table tr#" + id + " td:eq(3)").html();
        var unit2 = $("table#unit_of_measurement_table tr#" + id + " td:eq(4)").html();
        var description = $("table#unit_of_measurement_table tr#" + id + " td:eq(5)").html();
        var msg = "<table class=\"table table-striped\">";
        msg += "<thead><tr><th>UNIT 4</th><th>UNIT 3</th><th>UNIT 2</th><th>DESCRIPTION</th></thead>";
        msg += "<tbody><tr><td>" + unit4 + "</td><td>" + unit3 + "</td><td>" + unit2 + "</td><td>" + description + "</td></tr></tbody>";
        msg += "</table>";

        bootbox.dialog({
            message: msg,
            title: "Are you sure you want to delete this Unit Of Measurement?",
            buttons: {
                success: {
                    label: "YES DELETE",
                    className: "btn-danger btn-sm",
                    callback: function() {
                        $.ajax({
                            type: "DELETE",
                            url: 'settings/delete-unit-of-measurement/' + id,
                            beforeSend: function() {},
                            success: function() {
                                reload_unit_of_measurement_table();
                            },
                            error: function() {
                                alert('Cannot delete this Unit Of Measurement.');
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
    // End Delete Unit Of Measurement

    // Unit Of Measurement Modal hide
    $('#unit_of_measurement_tab_modal').on('hide.bs.modal', function(e) {
        $(".error_saving_unit_of_measurement_tab_modal").hide();
        $(".error_updating_unit_of_measurement_tab_modal").hide();

        $('#unit_of_measurement_tab_modal_form').trigger("reset");

        $("#form_unit4_unit_of_measurement_tab_modal").removeClass("has-error");
        $("#unit4_unit_of_measurement_tab_modal + p.help-block").text("");

        $("#form_unit3_unit_of_measurement_tab_modal").removeClass("has-error");
        $("#unit3_unit_of_measurement_tab_modal + p.help-block").text("");

        $("#form_unit2_unit_of_measurement_tab_modal").removeClass("has-error");
        $("#unit2_unit_of_measurement_tab_modal + p.help-block").text("");

        $("#form_desc_unit_of_measurement_tab_modal").removeClass("has-error");
        $("#desc_unit_of_measurement_tab_modal + p.help-block").text("");

        $("#form_eng_definition_unit_of_measurement_tab_modal").removeClass("has-error");
        $("#eng_definition_unit_of_measurement_tab_modal + p.help-block").text("");

        $("#form_ind_definition_unit_of_measurement_tab_modal").removeClass("has-error");
        $("#ind_definition_unit_of_measurement_tab_modal + p.help-block").text("");
    });
    // End Unit Of Measurement Modal Hide

    // END Unit Of Measurement TAB
    // ============================================================
    // ============================================================




    // START USER CLASS TAB
    // ============================================================
    // ============================================================

    var datatable_user_class_tab;
    $("#user_class_tab").one("click", function() {

        datatable_user_class_tab = $('#user_class_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'settings/datatables-user-class',
            },
            columns: [{
                data: 'rownum',
                name: 'rownum',
                searchable: false
            }, {
                data: 'created_at',
                name: 'created_at',
                searchable: false
            }, {
                data: 'class',
                name: 'class'
            }, {
                data: 'description',
                name: 'description'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
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
                "sSearch": "",
                "sSearchPlaceholder": "SEARCH",
            },
            columnDefs: [{
                "targets": [1],
                "visible": false,
            }, ],
            order: [
                [1, 'desc']
            ]
        });

        $("select.form-control").selectpicker();
        $("div.dataTables_length > label > div.btn-group > button").addClass("btn-sm");

        // Right Click User Class Tab
        new BootstrapMenu('table#user_class_table', {
            actions: [{
                name: 'REFRESH USER CLASS DATA',
                onClick: function() {
                    datatable_user_class_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Datatables User Class Tab
    });

    // Reload User Class DataTables
    function reload_user_class_table() {
        datatable_user_class_tab.ajax.reload(null, false);
    }
    // End Reload User Class DataTables

    // Add User Class
    $(document).on('click', '#add-uc', function() {
        $('#btn_save_user_class_tab_modal').val("SAVE").removeAttr("disabled");
        $('#user_class_tab_modal_title').text("ADD USER CLASS");
        $('#user_class_tab_modal').modal('show');
    });
    // End Add User Class

    // Edit User Class
    $(document).on('click', '.edit-uc', function() {
        id = $(this).attr('data-id');

        var usclass = $("table#user_class_table tr#" + id + " td:eq(1)").html();
        var description = $("table#user_class_table tr#" + id + " td:eq(2)").html();

        $('#user_class_user_class_tab_modal').val(usclass);
        $('#desc_user_class_tab_modal').val(description);
        $('#id_user_class_tab_modal').val(id);

        $('#btn_save_user_class_tab_modal').val("UPDATE").removeAttr("disabled");
        $('#user_class_tab_modal_title').text("EDIT USER CLASS");
        $('#ajax_process_modal').modal('hide');
        $('#user_class_tab_modal').modal('show');
    });
    // End Edit User Class


    // Press Enter user_class_tab_modal
    $("#user_class_tab_modal").keypress(function(e) {
        switch (e.which) {
            case 13:
                $("#btn_save_user_class_tab_modal").trigger("click");
                break;
        }
    });
    // End Press Enter user_class_tab_modal

    // Save User Class
    $("#btn_save_user_class_tab_modal").click(function() {
        var formData = {
            class: $('#user_class_user_class_tab_modal').val().trim(),
            description: $('#desc_user_class_tab_modal').val().trim(),
            created_by: $('#logged_in_user').val(),
            last_updated_by: $('#logged_in_user').val(),
        }

        var state = $('#btn_save_user_class_tab_modal').val();
        var type = "POST";
        var url = 'settings/add-user-class';
        var id = $('#id_user_class_tab_modal').val();

        if (state == "UPDATE") {
            type = "PUT";
            url = 'settings/update-user-class/' + id;
        }

        $.ajax({
            type: type,
            url: url,
            data: formData,
            dataType: 'json',
            beforeSend: function(data) {
                $("#user_class_tab_modal :input").prop('disabled', true);
                $(".error_saving_user_class_tab_modal").hide();
                $(".error_updating_user_class_tab_modal").hide();

                if (state == "SAVE") {
                    $(".saving_user_class_tab_modal").show();
                } else {
                    $(".updating_user_class_tab_modal").show();
                }

                $("#form_desc_user_class_tab_modal").removeClass("has-error");
                $("#desc_user_class_tab_modal + p.help-block").text("");

                $("#form_user_class_user_class_tab_modal").removeClass("has-error");
                $("#user_class_user_class_tab_modal + p.help-block").text("");
            },
            success: function(data) {
                $('#user_class_tab_modal_form').trigger("reset");
                $(".saving_user_class_tab_modal").hide();
                $(".updating_user_class_tab_modal").hide();

                $('#user_class_tab_modal').modal('hide');
                reload_user_class_table();
                $("#user_class_tab_modal :input").prop('disabled', false);

                $("#form_desc_user_class_tab_modal").removeClass("has-error");
                $("#desc_user_class_tab_modal + p.help-block").text("");

                $("#form_user_class_user_class_tab_modal").removeClass("has-error");
                $("#user_class_user_class_tab_modal + p.help-block").text("");
            },
            error: function(data) {
                $(".saving_user_class_tab_modal").hide();
                $(".updating_user_class_tab_modal").hide();
                if (state == "SAVE") {
                    $(".error_saving_user_class_tab_modal").show();
                } else {
                    $(".error_updating_user_class_tab_modal").show();
                }
                $("#user_class_tab_modal :input").prop('disabled', false);

                var errors = data.responseJSON;

                if (errors.class) {
                    $("#form_user_class_user_class_tab_modal").addClass("has-error");
                    $("#user_class_user_class_tab_modal + p.help-block").text(errors.class);
                } else {
                    $("#form_user_class_user_class_tab_modal").removeClass("has-error");
                    $("#user_class_user_class_tab_modal + p.help-block").text("");
                }

                if (errors.description) {
                    $("#form_desc_user_class_tab_modal").addClass("has-error");
                    $("#desc_user_class_tab_modal + p.help-block").text(errors.description);
                } else {
                    $("#form_desc_user_class_tab_modal").removeClass("has-error");
                    $("#desc_user_class_tab_modal + p.help-block").text("");
                }
            }
        });
    });
    // End Save User Class

    // Delete User Class
    $(document).on('click', '.delete-uc', function() {
        id = $(this).attr('data-id');

        var usclass = $("table#user_class_table tr#" + id + " td:eq(1)").html();
        var description = $("table#user_class_table tr#" + id + " td:eq(2)").html();
        var msg = "<table class=\"table table-striped\">";
        msg += "<thead><tr><th>USER CLASS</th><th>DESCRIPTION</th></thead>";
        msg += "<tbody><tr><td>" + usclass + "</td><td>" + description + "</td></tr></tbody>";
        msg += "</table>";

        bootbox.dialog({
            message: msg,
            title: "Are you sure you want to delete this User Class?",
            buttons: {
                success: {
                    label: "YES DELETE",
                    className: "btn-danger btn-sm",
                    callback: function() {
                        $.ajax({
                            type: "DELETE",
                            url: 'settings/delete-user-class/' + id,
                            beforeSend: function() {},
                            success: function() {
                                reload_user_class_table();
                            },
                            error: function() {
                                alert('Cannot delete this User Class.');
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
    // End Delete User Class

    // User Class Modal hide
    $('#user_class_tab_modal').on('hide.bs.modal', function(e) {
        $(".error_saving_user_class_tab_modal").hide();
        $(".error_updating_user_class_tab_modal").hide();
        $('#user_class_tab_modal_form').trigger("reset");

        $("#form_desc_user_class_tab_modal").removeClass("has-error");
        $("#desc_user_class_tab_modal + p.help-block").text("");

        $("#form_user_class_user_class_tab_modal").removeClass("has-error");
        $("#user_class_user_class_tab_modal + p.help-block").text("");
    });
    // End User Class Modal Hide

    // END USER CLASS TAB
    // ============================================================
    // ============================================================




    // START WEIGHT UNIT TAB
    // ============================================================
    // ============================================================

    var datatable_weight_unit_tab;
    $("#weight_unit_tab").one("click", function() {

        datatable_weight_unit_tab = $('#weight_unit_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'settings/datatables-weight-unit',
            },
            columns: [{
                data: 'rownum',
                name: 'rownum',
                searchable: false
            }, {
                data: 'created_at',
                name: 'created_at',
                searchable: false
            }, {
                data: 'unit',
                name: 'unit'
            }, {
                data: 'description',
                name: 'description'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
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
                "sSearch": "",
                "sSearchPlaceholder": "SEARCH",
            },
            columnDefs: [{
                "targets": [1],
                "visible": false,
            }, ],
            order: [
                [1, 'desc']
            ]
        });

        $("select.form-control").selectpicker();
        $("div.dataTables_length > label > div.btn-group > button").addClass("btn-sm");

        // Right Click Weight Unit Tab
        new BootstrapMenu('table#weight_unit_table', {
            actions: [{
                name: 'REFRESH WEIGHT UNIT DATA',
                onClick: function() {
                    datatable_weight_unit_tab.ajax.reload(null, false);
                }
            }]
        });
        // End Right Click Datatables Weight Unit Tab
    });

    // Reload Weight Unit DataTables
    function reload_weight_unit_table() {
        datatable_weight_unit_tab.ajax.reload(null, false);
    }
    // End Reload Weight Unit DataTables

    // Add Weight Unit
    $(document).on('click', '#add-wu', function() {
        $('#btn_save_weight_unit_tab_modal').val("SAVE").removeAttr("disabled");
        $('#weight_unit_tab_modal_title').text("ADD WEIGHT UNIT");
        $('#weight_unit_tab_modal').modal('show');
    });
    // End Add Weight Unit

    // Edit Weight Unit
    $(document).on('click', '.edit-wu', function() {
        id = $(this).attr('data-id');

        var unit = $("table#weight_unit_table tr#" + id + " td:eq(1)").html();
        var description = $("table#weight_unit_table tr#" + id + " td:eq(2)").html();

        $('#weight_unit_weight_unit_tab_modal').val(unit);
        $('#desc_weight_unit_tab_modal').val(description);
        $('#id_weight_unit_tab_modal').val(id);

        $('#btn_save_weight_unit_tab_modal').val("UPDATE").removeAttr("disabled");
        $('#weight_unit_tab_modal_title').text("EDIT WEIGHT UNIT");
        $('#ajax_process_modal').modal('hide');
        $('#weight_unit_tab_modal').modal('show');
    });
    // End Edit Weight Unit

    // Press Enter weight_unit_tab_modal
    $("#weight_unit_tab_modal").keypress(function(e) {
        switch (e.which) {
            case 13:
                $("#btn_save_weight_unit_tab_modal").trigger("click");
                break;
        }
    });
    // End Press Enter weight_unit_tab_modal

    // Save Weight Unit
    $("#btn_save_weight_unit_tab_modal").click(function() {
        var formData = {
            unit: $('#weight_unit_weight_unit_tab_modal').val().trim(),
            description: $('#desc_weight_unit_tab_modal').val().trim(),
            created_by: $('#logged_in_user').val(),
            last_updated_by: $('#logged_in_user').val(),
        }

        var state = $('#btn_save_weight_unit_tab_modal').val();
        var type = "POST";
        var url = 'settings/add-weight-unit';
        var id = $('#id_weight_unit_tab_modal').val();

        if (state == "UPDATE") {
            type = "PUT";
            url = 'settings/update-weight-unit/' + id;
        }

        $.ajax({
            type: type,
            url: url,
            data: formData,
            dataType: 'json',
            beforeSend: function(data) {
                $("#weight_unit_tab_modal :input").prop('disabled', true);
                $(".error_saving_weight_unit_tab_modal").hide();
                $(".error_updating_weight_unit_tab_modal").hide();

                if (state == "SAVE") {
                    $(".saving_weight_unit_tab_modal").show();
                } else {
                    $(".updating_weight_unit_tab_modal").show();
                }

                $("#form_weight_unit_weight_unit_tab_modal").removeClass("has-error");
                $("#weight_unit_weight_unit_tab_modal + p.help-block").text("");

                $("#form_desc_weight_unit_tab_modal").removeClass("has-error");
                $("#desc_weight_unit_tab_modal + p.help-block").text("");
            },
            success: function(data) {
                $('#weight_unit_tab_modal_form').trigger("reset");
                $(".saving_weight_unit_tab_modal").hide();
                $(".updating_weight_unit_tab_modal").hide();

                $('#weight_unit_tab_modal').modal('hide');
                reload_weight_unit_table();
                $("#weight_unit_tab_modal :input").prop('disabled', false);

                $("#form_weight_unit_weight_unit_tab_modal").removeClass("has-error");
                $("#weight_unit_weight_unit_tab_modal + p.help-block").text("");

                $("#form_desc_weight_unit_tab_modal").removeClass("has-error");
                $("#desc_weight_unit_tab_modal + p.help-block").text("");
            },
            error: function(data) {
                $(".saving_weight_unit_tab_modal").hide();
                $(".updating_weight_unit_tab_modal").hide();
                if (state == "SAVE") {
                    $(".error_saving_weight_unit_tab_modal").show();
                } else {
                    $(".error_updating_weight_unit_tab_modal").show();
                }
                $("#weight_unit_tab_modal :input").prop('disabled', false);

                var errors = data.responseJSON;

                if (errors.unit) {
                    $("#form_weight_unit_weight_unit_tab_modal").addClass("has-error");
                    $("#weight_unit_weight_unit_tab_modal + p.help-block").text(errors.unit);
                } else {
                    $("#form_weight_unit_weight_unit_tab_modal").removeClass("has-error");
                    $("#weight_unit_weight_unit_tab_modal + p.help-block").text("");
                }

                if (errors.description) {
                    $("#form_desc_weight_unit_tab_modal").addClass("has-error");
                    $("#desc_weight_unit_tab_modal + p.help-block").text(errors.description);
                } else {
                    $("#form_desc_weight_unit_tab_modal").removeClass("has-error");
                    $("#desc_weight_unit_tab_modal + p.help-block").text("");
                }
            }
        });
    });
    // End Save Weight Unit

    // Delete Weight Unit
    $(document).on('click', '.delete-wu', function() {
        id = $(this).attr('data-id');

        var unit = $("table#weight_unit_table tr#" + id + " td:eq(1)").html();
        var description = $("table#weight_unit_table tr#" + id + " td:eq(2)").html();
        var msg = "<table class=\"table table-striped\">";
        msg += "<thead><tr><th>WEIGHT UNIT</th><th>DESCRIPTION</th></thead>";
        msg += "<tbody><tr><td>" + unit + "</td><td>" + description + "</td></tr></tbody>";
        msg += "</table>";

        bootbox.dialog({
            message: msg,
            title: "Are you sure you want to delete this Weight Unit?",
            buttons: {
                success: {
                    label: "YES DELETE",
                    className: "btn-danger btn-sm",
                    callback: function() {
                        $.ajax({
                            type: "DELETE",
                            url: 'settings/delete-weight-unit/' + id,
                            beforeSend: function() {},
                            success: function() {
                                reload_weight_unit_table();
                            },
                            error: function() {
                                alert('Cannot delete this Weight Unit.');
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
    // End Delete Weight Unit

    // Weight Unit Modal hide
    $('#weight_unit_tab_modal').on('hide.bs.modal', function(e) {
        $(".error_saving_weight_unit_tab_modal").hide();
        $(".error_updating_weight_unit_tab_modal").hide();

        $('#weight_unit_tab_modal_form').trigger("reset");

        $("#form_weight_unit_weight_unit_tab_modal").removeClass("has-error");
        $("#weight_unit_weight_unit_tab_modal + p.help-block").text("");

        $("#form_desc_weight_unit_tab_modal").removeClass("has-error");
        $("#desc_weight_unit_tab_modal + p.help-block").text("");
    });
    // End Weight Unit Modal Hide

    // END WEIGHT UNIT TAB
    // ============================================================
    // ============================================================
});