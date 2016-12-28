jQuery(function($) {
    // INSERT ELEMENT FOR HANDLEBARS
    $('<div id="navbar"></div><div id="content"></div>').insertAfter('#loading');
    // END INSERT ELEMENT FOR HANDLEBARS

    // HANDLEBARS TEMPLATE
    $('#navbar').html(Accounts.templates.navbar());
    $('#content').html(Accounts.templates.content());
    // END HANDLEBARS TEMPLATE

    // accountsTab
    $("#accountsTab a").click(function(e){
        e.preventDefault();
        $(this).tab('show');
    });
    // END accountsTab

    // LOAD USERS DATATABLES
    get_users();
    get_roles();

    // USERS DATATABLES
    var datatable_users;
    function get_users() {
        datatable_users = $('#users').DataTable({
            destroy: true,
            processing: false,
            serverSide: true,
            ajax: 'accounts/users',
            columns: [{
                data: 'name',
                name: 'name'
            }, {
                data: 'username',
                name: 'username'
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
            pageLength: 12,
            columnDefs: [ {
              "targets": 1,
              "orderable": false
            } ],
            drawCallback: function() {
                $('#users th:last-child')
                    .addClass('cpointer')
                    .empty()
                    .append('USERNAME <kbd id="add-user" style="padding:2px 4px 1px !important;" class="kbd-primary pull-right cpointer">ADD</kbd>');
                $('#users td:last-child')
                	.addClass('normalcase');

                $("#users tbody tr:first-child").addClass('active');
                $("#users tbody tr").on('click', function(event) {
                    $("#users tbody tr:first-child").removeClass('active');
                    $("#users tbody tr").removeClass('active');
                    $(this).addClass('active');
                });

                var id = $("#users tbody tr.active").attr("id");
                if(id){
                	get_role_user(id);
                }                

                var api = this.api();
                var info = api.page.info();
                recordsTotal = info.recordsTotal;
                if ( recordsTotal > 12 ) {
                    $('#users_info').css('display', 'block');
                    $('#users_paginate').css('display', 'block');
                }else{
                    $('#users_info').css('display', 'none');
                    $('#users_paginate').css('display', 'none');
                }
            }
        });
    }
    // END USERS DATATABLES

    // WHEN CLICK USERS ROW
    $("#users tbody").delegate("tr", "click", function() {
	    var id = $(this).attr('id');
	    get_role_user(id);
	});

	// ROLE USER DATATABLES
    var datatable_role_user;
    function get_role_user(id) {
        datatable_role_user = $('#role_user').DataTable({
            destroy: true,
            processing: false,
            serverSide: true,
            ajax: 'accounts/role-user/' + id,
            columns: [{
                data: 'display_name',
                name: 'display_name'
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
            pageLength: 12,
            ordering: false,
            drawCallback: function() {
                $('#role_user th:last-child')
                    .addClass('cpointer')
                    .empty()
                    .append('ROLE <kbd id="add-role-user" style="padding:2px 4px 1px !important;" class="kbd-primary pull-right cpointer">ADD</kbd>');

                var api = this.api();
                var info = api.page.info();
                recordsTotal = info.recordsTotal;
                if ( recordsTotal > 12 ) {
                    $('#role_user_info').css('display', 'block');
                    $('#role_user_paginate').css('display', 'block');
                }else{
                    $('#role_user_info').css('display', 'none');
                    $('#role_user_paginate').css('display', 'none');
                }
            }
        });
    }
    // END USER ROLE DATATABLES

    // ADD ROLES MODAL
    $(document).on('click', '#add-role-user', function() {
        var requestCallback = new MyRequestsCompleted({
            numRequest: 1,
            singleCallback: function() {
                $('#add_role_user_modal').modal('show');
            }
        });

        id = $('#users tr.active').attr('id');
        $.ajax({
            type: 'GET',
            url: 'accounts/not-my-role/' + id,
            dataType: 'json',
            success: function(data) {
                if(data.length > 0){
                    var modalData = '';
                    $.each(data, function(i, item) {
                        modalData += '<div class="checkbox checkbox-primary">';
                        modalData += '<input value="'+item.role_id+'" id="checkbox'+item.role_id+'" class="not_my_role styled" type="checkbox">';
                        modalData += '<label for="checkbox'+item.role_id+'">'+item.display_name.toUpperCase()+'</label>';
                        modalData += '</div>';
                    });
                    $('.modal-header').removeClass('hidden');
                    $('#save-role-user').removeClass('hidden');
                }else{
                    modalData = 'NO DATA';
                    $('.modal-header').addClass('hidden');
                    $('#save-role-user').addClass('hidden');
                }
                $('#add_role_user_modal .modal-body').html(modalData);
                requestCallback.requestComplete(true);
            },
        });
    });
    // END ADD ROLES MODAL

    // SAVE ADD ROLE TO USER
    $(document).on('click', '#save-role-user', function() {
        var id = $('#users tr.active').attr('id');
        var roles = $('input.not_my_role:checked').map(function() {
            return {
                name: 'role_id[]',
                value: $(this).val()
            };
        });

        $.ajax({
            type: 'POST',
            url: 'accounts/submit-role-user',
            data: 'user_id=' + id + '&' + jQuery.param(roles), 
            dataType: 'json',
            success: function() {
                datatable_role_user.ajax.reload(null, false);
                $('#add_role_user_modal').modal('hide');
            },
            error: function() {
                alert('ERROR');
            },
        });
    });
    // END SAVE ADD ROLE TO USER

    // ROLES DATATABLES
    var datatable_roles;
    function get_roles() {
        datatable_roles = $('#roles').DataTable({
            destroy: true,
            processing: false,
            serverSide: true,
            ajax: 'accounts/roles',
            columns: [{
                data: 'name',
                name: 'name'
            }, {
                data: 'description',
                name: 'description'
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
            pageLength: 12,
            columnDefs: [ {
              "targets": 1,
              "orderable": false
            } ],
            drawCallback: function() {
                $('#roles th:last-child')
                    .addClass('cpointer')
                    .empty()
                    .append('DESCRIPTION <kbd id="add-role" style="padding:2px 4px 1px !important;" class="kbd-primary pull-right cpointer">ADD</kbd>');
                $('#roles td:last-child')
                    .addClass('normalcase');

                $("#roles tbody tr:first-child").addClass('active');
                $("#roles tbody tr").on('click', function(event) {
                    $("#roles tbody tr:first-child").removeClass('active');
                    $("#roles tbody tr").removeClass('active');
                    $(this).addClass('active');
                });

                var id = $("#roles tbody tr.active").attr("id");
                if(id){
                    get_permission_role(id);
                }                

                var api = this.api();
                var info = api.page.info();
                recordsTotal = info.recordsTotal;
                if ( recordsTotal > 12 ) {
                    $('#roles_info').css('display', 'block');
                    $('#roles_paginate').css('display', 'block');
                }else{
                    $('#roles_info').css('display', 'none');
                    $('#roles_paginate').css('display', 'none');
                }
            }
        });
    }
    // END ROLES DATATABLES

    // WHEN CLICK ROLES ROW
    $("#roles tbody").delegate("tr", "click", function() {
        var id = $(this).attr('id');
        get_permission_role(id);
    });

    // PERMISSION ROLE DATATABLES
    var datatable_permission_role;
    function get_permission_role(id) {
        datatable_permission_role = $('#permission_role').DataTable({
            destroy: true,
            processing: false,
            serverSide: true,
            ajax: 'accounts/permission-role/' + id,
            columns: [{
                data: 'display_name',
                name: 'display_name'
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
            pageLength: 12,
            ordering: false,
            drawCallback: function() {
                $('#permission_role th:last-child')
                    .addClass('cpointer')
                    .empty()
                    .append('PERMISSION <kbd id="add-permission-role" style="padding:2px 4px 1px !important;" class="kbd-primary pull-right cpointer">ADD</kbd>');

                var api = this.api();
                var info = api.page.info();
                recordsTotal = info.recordsTotal;
                if ( recordsTotal > 12 ) {
                    $('#permission_role_info').css('display', 'block');
                    $('#permission_role_paginate').css('display', 'block');
                }else{
                    $('#permission_role_info').css('display', 'none');
                    $('#permission_role_paginate').css('display', 'none');
                }
            }
        });
    }
    // END PERMISSION ROLE DATATABLES

    // ADD PERMISSION MODAL
    $(document).on('click', '#add-permission-role', function() {
        var requestCallback = new MyRequestsCompleted({
            numRequest: 1,
            singleCallback: function() {
                $('#add_permission_role_modal').modal('show');
            }
        });

        id = $('#roles tr.active').attr('id');
        $.ajax({
            type: 'GET',
            url: 'accounts/not-my-permission/' + id,
            dataType: 'json',
            success: function(data) {
                if(data.length > 0){
                    var modalData = '';
                    $.each(data, function(i, item) {
                        modalData += '<div class="checkbox checkbox-primary">';
                        modalData += '<input value="'+item.permission_id+'" id="checkbox'+item.permission_id+'" class="not_my_permission styled" type="checkbox">';
                        modalData += '<label for="checkbox'+item.permission_id+'">'+item.display_name.toUpperCase()+'</label>';
                        modalData += '</div>';
                    });
                    $('.modal-header').removeClass('hidden');
                    $('#save-permission-role').removeClass('hidden');
                }else{
                    modalData = 'NO DATA';
                    $('.modal-header').addClass('hidden');
                    $('#save-permission-role').addClass('hidden');
                }
                $('#add_permission_role_modal .modal-body').html(modalData);
                requestCallback.requestComplete(true);
            },
        });
    });
    // END ADD PERMISSION MODAL

    // SAVE ADD PERMISSION TO ROLE
    $(document).on('click', '#save-permission-role', function() {
        var id = $('#roles tr.active').attr('id');
        var permission = $('input.not_my_permission:checked').map(function() {
            return {
                name: 'permission_id[]',
                value: $(this).val()
            };
        });

        $.ajax({
            type: 'POST',
            url: 'accounts/submit-permission-role',
            data: 'role_id=' + id + '&' + jQuery.param(permission), 
            dataType: 'json',
            success: function() {
                datatable_permission_role.ajax.reload(null, false);
                $('#add_permission_role_modal').modal('hide');
            },
            error: function() {
                alert('ERROR');
            },
        });
    });
    // END SAVE ADD PERMISSION TO ROLE
});