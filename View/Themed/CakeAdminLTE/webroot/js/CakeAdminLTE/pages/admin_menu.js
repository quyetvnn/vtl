var ADMIN_MENU = {
    url_index: '',
    url_get_shop_data: '',
    old_shop_id: '',
    url_get_item_detail: '',
    url_upgrade_item_detail: '',
    data_change_status: {},
    message_confirm: '',
    is_have_pending: 0,
    init_page: function(){
		COMMON.init_validate_form_tabs($("#btn-submit-data"));
        // init element decimal
        COMMON.init_element_decimal($('.decimal-number'));
        
        ADMIN_MENU.init_select_brand($("#ddl_brand_id"), $("#ddl_shop_id"));
    },
    init_select_brand: function(brand_ele, shop_ele){
        $(brand_ele).on('change', function(){
            COMMON.call_ajax({
                url: ADMIN_MENU.url_get_shop_data,
                type: 'POST',
                data: {
                    brand_id: $(this).val()
                },
                dataType: 'json',
                success: function(result){
                    var html_options = "<option value=''>" + $(shop_ele).find("option").first().text() + "</option>";
                    if(result.status === true){
                        for(var key in result['params']){
                            html_options += "<option value=" + key + ">" + result['params'][key] + "</option>";
                        }
                    }

                    $(shop_ele).html(html_options);
                    if(ADMIN_MENU.old_shop_id != "" && $(shop_ele).find("option[value=" + ADMIN_MENU.old_shop_id + "]").length){
                        $(shop_ele).val(ADMIN_MENU.old_shop_id);
                    }
                    $(shop_ele).selectpicker('refresh');
                },
                error: function(error){
                    alert("Get data for shop is error!")
                }
            });
        });
    },
    init_edit_form: function(){
        $('#menu-edit-form').on('submit', function(event){
            if(ADMIN_MENU.is_have_pending == 1){
                var result = confirm(ADMIN_MENU.message_confirm_continuous_edit_pending);
                if (result == false) {
                    event.preventDefault();
                } 
            }
        });
    },
    init_detail_page: function(){
        var hashtag = window.location.hash.substr(1);
        if(hashtag){
            $('a[href="#' + hashtag+ '"]').trigger('click');
        }


        $('.btn-approve').off().on('click', function(){
            ADMIN_MENU.data_change_status = {
                id: $(this).data('id'),
                detail_id: $(this).data('detail-id'),
                status: 1
            };

            ADMIN_MENU.init_confirm_change_status('Approve');
        });

        $('.btn-reject').off().on('click', function(){
            ADMIN_MENU.data_change_status = {
                id: $(this).data('id'),
                detail_id: $(this).data('detail-id'),
                status: 4
            };

            ADMIN_MENU.init_confirm_change_status('Reject');
        });

        $('.btn-view-detail').on('click', function(){
            var id = $(this).data('id');

            COMMON.call_ajax({
                url: ADMIN_MENU.url_get_item_detail + '/' + id,
                type: 'GET',
                dataType: 'text',
                success: function(result){
                    $('.menu-detail-modal .modal-body').html(result);
                    $('.menu-detail-modal').modal('show');
                    ADMIN_MENU.init_action_popup_view_detail();
                },
                error: function(error){
                    alert("Get data for menu detail is error!")
                }
            });
        });
    },
    init_action_popup_view_detail: function(){
        $('.btn-approve-modal').off().on('click', function(){
            ADMIN_MENU.data_change_status = {
                id: $(this).data('id'),
                detail_id: $(this).data('detail-id'),
                status: 1
            };

            ADMIN_MENU.init_confirm_change_status('Approve');
        });

        $('.btn-reject-modal').off().on('click', function(){
            ADMIN_MENU.data_change_status = {
                id: $(this).data('id'),
                detail_id: $(this).data('detail-id'),
                status: 4
            };

            ADMIN_MENU.init_confirm_change_status('Reject');
        });
    },
    init_confirm_change_status: function(action){
        var message = ADMIN_MENU.message_confirm.replace("[action]", action);
        $('.confirm-change-status-modal .modal-body h3').text(message);
        $('.confirm-change-status-modal').modal('show');
        
        $('.btn-confirm-yes').off().on('click', function(){
            COMMON.call_ajax({
                url: ADMIN_MENU.url_upgrade_item_detail + '/' + ADMIN_MENU.data_change_status.id,
                type: 'POST',
                data: {
                    menu_detail_id: ADMIN_MENU.data_change_status.detail_id,
                    status: ADMIN_MENU.data_change_status.status
                },
                dataType: 'json',
                success: function(result){
                    if(typeof(result.status) != "undefined"){
                        alert(result.params.message);
                        if(result.status === true){
                            window.location.href = ADMIN_MENU.url_index;
                        }
                    }else{
                        alert(action + " this menu was FAILED!");
                    }
                },
                error: function(error){
                    alert(action + " this menu was FAILED!");
                }
            });
        });
    }
}