jQuery(function($) {
    // INSERT ELEMENT FOR HANDLEBARS
    $('<div id="navbar"></div><div id="content"></div>').insertAfter('#loading');
    // END INSERT ELEMENT FOR HANDLEBARS

    // HANDLEBARS TEMPLATE
    $('#navbar').html(Dictionary.templates.dictionary_navbar());
    $('#content').html(Dictionary.templates.dictionary_content());
    // END HANDLEBARS TEMPLATE

    // disable datatables error prompt
    $.fn.dataTable.ext.errMode = 'none';

    // LOADING
    $(document).ajaxStop(function() {
        $('#loading').hide();
    });
    // END LOADING

    // Dictionary Tab
    $("#dictTab a").click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });
    // End Dictionary Tab

    // Item Name DataTable
    var datatable_item_name = $('#item_name_table').DataTable({
        processing: false,
        serverSide: true,
        ajax: {
            url: 'dictionary/item-name',
            data: function(d) {
                d.inc = $('#inc_item_name_tab').val().trim();
                d.item_name = $('#item_name_item_name_tab').val().trim();
                d.colloquial = $('#colloquial_item_name_tab').val();
                d.characteristic = $('#characteristic_item_name_tab').val();
                d.group = $('#group_item_name_tab').val();
                d.class = $('#class_item_name_tab').val();
            },
        },
        columns: [{
            data: 'inc',
            name: 'inc'
        }, {
            data: 'item_name',
            name: 'item_name'
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
        dom: "<'row item_name_tr'>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        drawCallback: function() {
            var api = this.api();
            var firstRow = api.rows().data()[0];
            if (typeof firstRow != "undefined") {
                $('#eng_def_title_item_name_tab').text(firstRow['item_name']);
                $('#eng_def_title_item_name_tab').text(firstRow['item_name']);

                $('#eng_def_item_name_tab').text(firstRow['eng_definition']);
                $('#ind_def_item_name_tab').text(firstRow['ind_definition']);

                get_colloquial(firstRow['id']);
            } else {
                $('#eng_def_title_item_name_tab').text("");
                $('#eng_def_title_item_name_tab').text("");

                $('#eng_def_item_name_tab').text("");
                $('#ind_def_item_name_tab').text("");

                get_colloquial(0);
            }
        },
    });
    // Item Name End DataTable

    // Select Colloquial
    var optionsColloquialItemNameTab = {
        ajax: {
            url: 'dictionary/select-colloquial',
            type: 'POST',
            dataType: 'json',
        },
        locale: {
            emptyTitle: 'ALL COLLOQUIAL'
        },
        preprocessData: function(data) {
            var i, l = data.length,
                array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text: data[i].colloquial,
                        value: data[i].id,
                    }));
                }
            }
            return array;
        }
    };
    $('.colloquial-item-name-tab').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsColloquialItemNameTab);
    $('.colloquial-item-name-tab').trigger('change');

    $('button[data-id="colloquial_item_name_tab"]').addClass("btn-sm");
    // End Select Colloquial

    // Select Characteristic
    var optionsCharacteristicItemNameTab = {
        ajax: {
            url: 'dictionary/select-characteristic',
            type: 'POST',
            dataType: 'json',
        },
        locale: {
            emptyTitle: 'ALL CHARACTERISTIC'
        },
        preprocessData: function(data) {
            var i, l = data.length,
                array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text: data[i].characteristic,
                        value: data[i].id,
                    }));
                }
            }
            return array;
        }
    };
    $('.characteristic-item-name-tab').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsCharacteristicItemNameTab);
    $('.characteristic-item-name-tab').trigger('change');

    $('button[data-id="characteristic_item_name_tab"]').addClass("btn-sm");
    // End Select Characteristic

    // Select Group
    var optionsGroupItemNameTab = {
        ajax: {
            url: 'dictionary/select-group',
            type: 'POST',
            dataType: 'json',
        },
        locale: {
            emptyTitle: 'ALL GROUP'
        },
        preprocessData: function(data) {
            var i, l = data.length,
                array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text: data[i].group,
                        value: data[i].id,
                        data: {
                            subtext: data[i].name
                        }
                    }));
                }
            }
            return array;
        }
    };
    $('.group-item-name-tab').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsGroupItemNameTab);
    $('.group-item-name-tab').trigger('change');

    $('button[data-id="group_item_name_tab"]').addClass("btn-sm");
    // $('div.btn-group.bootstrap-select.group-item-name-tab.with-ajax').css("margin-top", "5px");
    // End Select Group

    // Select Class
    var optionsClassItemNameTab = {
        ajax: {
            url: 'dictionary/select-class',
            type: 'POST',
            dataType: 'json',
        },
        locale: {
            emptyTitle: 'ALL CLASS'
        },
        preprocessData: function(data) {
            var i, l = data.length,
                array = [];
            if (l) {
                for (i = 0; i < l; i++) {
                    array.push($.extend(true, data[i], {
                        text: data[i].class,
                        value: data[i].id,
                        data: {
                            subtext: data[i].name
                        }
                    }));
                }
            }
            return array;
        }
    };
    $('.class-item-name-tab').selectpicker('refresh').filter('.with-ajax').ajaxSelectPicker(optionsClassItemNameTab);
    $('.class-item-name-tab').trigger('change');

    $('button[data-id="class_item_name_tab"]').addClass("btn-sm");
    // $('div.btn-group.bootstrap-select.class-item-name-tab.with-ajax').css("margin-top", "5px");
    $('.bs-searchbox > input.form-control').addClass("input-sm");
    // End Select Class

    jQuery(document).ajaxComplete(function() {
        $("#inc_item_name_tab").keyup(function() {
            datatable_item_name.ajax.reload(null, false).unbind();
        });

        $("#item_name_item_name_tab").keyup(function() {
            datatable_item_name.ajax.reload(null, false).unbind();
        });

        $('#colloquial_item_name_tab').on('changed.bs.select', function(e) {
            datatable_item_name.ajax.reload(null, false).unbind();
        });

        $('#characteristic_item_name_tab').on('changed.bs.select', function(e) {
            datatable_item_name.ajax.reload(null, false).unbind();
        });

        $('#group_item_name_tab').on('changed.bs.select', function(e) {
            var bismillah = $("#select_group_item_name_tab li.selected small").text();
            $("#group_name_item_name_tab").val(bismillah);
            $("#group_name_item_name_tab").attr("title", bismillah);
            datatable_item_name.ajax.reload(null, false).unbind();
        });

        $('#class_item_name_tab').on('changed.bs.select', function(e) {
            var bismillah = $("#select_class_item_name_tab li.selected small").text();
            $("#class_name_item_name_tab").val(bismillah);
            $("#class_name_item_name_tab").attr("title", bismillah);
            datatable_item_name.ajax.reload(null, false).unbind();
        });
    });

    // Right Click Filter
    new BootstrapMenu('button[data-id="colloquial_item_name_tab"]', {
        actions: [{
            name: 'SELECT ALL COLLOQUIAL',
            onClick: function() {
                $('#colloquial_item_name_tab').val([]);
                $('#colloquial_item_name_tab').trigger('change.abs.preserveSelected');
                $('#colloquial_item_name_tab').selectpicker('refresh');
                $('#colloquial_item_name_tab').trigger("click");
                datatable_item_name.ajax.reload(null, false);
            }
        }]
    });

    new BootstrapMenu('button[data-id="characteristic_item_name_tab"]', {
        actions: [{
            name: 'SELECT ALL CHARACTERISTIC',
            onClick: function() {
                $('#characteristic_item_name_tab').val([]);
                $('#characteristic_item_name_tab').trigger('change.abs.preserveSelected');
                $('#characteristic_item_name_tab').selectpicker('refresh');
                $('#characteristic_item_name_tab').trigger("click");
                datatable_item_name.ajax.reload(null, false);
            }
        }]
    });

    new BootstrapMenu('button[data-id="group_item_name_tab"]', {
        actions: [{
            name: 'SELECT ALL GROUP',
            onClick: function() {
                $('#group_item_name_tab').val([]);
                $('#group_item_name_tab').trigger('change.abs.preserveSelected');
                $('#group_item_name_tab').selectpicker('refresh');
                $('#group_item_name_tab').trigger("click");
                datatable_item_name.ajax.reload(null, false);
            }
        }]
    });

    new BootstrapMenu('button[data-id="class_item_name_tab"]', {
        actions: [{
            name: 'SELECT ALL CLASS',
            onClick: function() {
                $('#class_item_name_tab').val([]);
                $('#class_item_name_tab').trigger('change.abs.preserveSelected');
                $('#class_item_name_tab').selectpicker('refresh');
                $('#class_item_name_tab').trigger("click");
                datatable_item_name.ajax.reload(null, false);
            }
        }]
    });

    new BootstrapMenu('#item_name_table', {
        actions: [{
            name: 'REFRESH DATA',
            onClick: function() {
                datatable_item_name.ajax.reload(null, false);
            }
        }]
    });
    // End Right Click Filter

    // DataTable Colloquial for Item Name
    var datatable_colloquial;

    function get_colloquial(tbl_inc_id) {
        datatable_colloquial = $('#colloquial_table_item_name_tab').DataTable({
            destroy: true,
            processing: false,
            serverSide: true,
            ajax: 'dictionary/colloquial/' + tbl_inc_id,
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
            pageLength: 15
        });
    }
    // End DataTable Colloquial for Item Name

});